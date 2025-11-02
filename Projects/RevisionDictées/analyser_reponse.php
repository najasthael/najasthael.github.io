<?php 
require 'connexion.php'; //connexion à la base de données
// vérifie que tous les champs post sont bien présents
if (empty($_POST['id_eleve']) || empty($_POST['id_dictee']) || empty($_POST['reponse'])) {
    die("erreur : données post manquantes !");
}
//vérifie que l'extension intl est disponible
if (!class_exists('Normalizer')) {
    die("l'extension intl doit être activée.");
}
//fonction pour découper un texte en mots en gérant les apostrophes et minuscules
function tokenize(string $text): array {
    $text = mb_strtolower($text, 'utf-8');
    $text = str_replace(['’', '‘', 'ʼ'], "'", $text); //uniformise les apostrophes
    $text = preg_replace("/\b([ldcjmnst])'(?=\p{L}+)/u", "$1' ", $text); //espace après contractions
    preg_match_all("/\p{L}+'|\p{L}+|\./u", $text, $matches); //extrait les mots et ponctuation
    return $matches[0];
}
//extrait le radical en retirant la désinence d’un mot
function get_radical(string $word, string $desinence): string {
    return mb_substr($word, 0, mb_strlen($word) - mb_strlen($desinence), 'utf-8');
}
// détecte une erreur de segmentation
function is_segmentation_error(string $ref, string $elv): bool {
    return strpos($ref, "'") !== false && str_replace("'", '', $ref) === $elv;
}
//retire les accents d’une chaîne unicode
function remove_accents(string $str): string {
    if (!class_exists('Normalizer')) return $str;
    $str = Normalizer::normalize($str, Normalizer::FORM_D);
    return preg_replace('/\p{Mn}/u', '', $str);
}
//vérifie si un mot contient des accents
function has_accent(string $word): bool {
    return preg_match('/[\x{0300}-\x{036f}]/u', Normalizer::normalize($word, Normalizer::FORM_D));
}
// récupération des données post
$id_eleve  = $_POST['id_eleve'];
$id_dictee = $_POST['id_dictee'];
$reponse   = $_POST['reponse'];
$date      = $_POST['date_passation'];
//récupère le contenu de la dictée depuis la base
$stmt = $pdo->prepare("select contenu from dictees where id = ?");
$stmt->execute([$id_dictee]);
$contenu_dictee = $stmt->fetchColumn();
//découpe la dictée et la réponse en mots
$mots_ref = tokenize($contenu_dictee);
$mots_elv = tokenize($reponse);
//calcule la distance de levenshtein et une estimation d’erreur globale
function analyse_erreur_leven($attendu, $saisi) {
    $distance = levenshtein($attendu, $saisi);
    $longueur_max = max(strlen($attendu), 1);
    $erreur = ($distance / $longueur_max) * 100;
    return [
        'distance' => $distance,
        'erreur_pourcentage' => round($erreur, 2)
    ];
}
$analyse_leven = analyse_erreur_leven($contenu_dictee, $reponse);
$note = max(0, 10 - ($analyse_leven['erreur_pourcentage'] / 10)); // note sur 10
$note = round($note, 2);
//affichage du résultat global
echo "<div style='margin-top: 1em; padding: 1em; background: #eef; border: 1px solid #99c;'>
    <strong>distance de levenshtein :</strong> {$analyse_leven['distance']}<br>
    <strong>erreur globale :</strong> {$analyse_leven['erreur_pourcentage']}%<br>
    <strong>note estimée :</strong> $note / 10
</div>";
//charge le lexique depuis la base dans un tableau
$lexique = [];
foreach ($pdo->query("select * from lexique") as $row) {
    $mot = mb_strtolower(trim($row['mot']), 'utf-8');
    $lexique[$mot] = [
        'categorie' => mb_strtoupper($row['categorie'], 'utf-8'),
        'lemme'     => mb_strtolower($row['lemme'], 'utf-8'),
        'desinence' => $row['desinence']
    ];
}
//initialise les erreurs par catégorie
$categories = ['NOM', 'VERBE', 'DÉTERMINANT', 'PRÉPOSITION', 'PONCTUATION', 'PRONOM', 'ADJECTIF'];
$errors = array_fill_keys($categories, []);
$error_counts = array_fill_keys($categories, 0);
$checked = [];
//boucle principale de comparaison entre mots attendus et mots saisis
foreach ($mots_ref as $ref) {
    $ref_lower = mb_strtolower($ref, 'utf-8');
    if (!isset($lexique[$ref_lower])) {
        die("erreur : le mot '$ref_lower' est absent du lexique.");
    }
    $cat = $lexique[$ref_lower]['categorie'];
    $found = false;
    $best_match = null;
    $problems = [];
    foreach ($mots_elv as $i => $elv) {
        if (in_array($i, $checked)) continue;
        $elv_lower = mb_strtolower($elv, 'utf-8');
        $ref_noacc = remove_accents($ref_lower);
        $elv_noacc = remove_accents($elv_lower);
        $temp_problems = [];
        //erreur de segmentation
        if (is_segmentation_error($ref_lower, $elv_lower)) {
            $temp_problems[] = 'segmentation';
        }
        //vérifie la désinence si présente
        if ($lexique[$ref_lower]['desinence']) {
            $radical = get_radical($ref_noacc, $lexique[$ref_lower]['desinence']);
            if (mb_substr($elv_noacc, 0, mb_strlen($radical)) === $radical) {
                $desinence_elv = mb_substr($elv_noacc, mb_strlen($radical));
                if ($desinence_elv !== $lexique[$ref_lower]['desinence']) {
                    if (!in_array('désinence', $temp_problems)) {
                        $temp_problems[] = 'désinence';
                    }
                }
            }
        }
        //erreur d’accent
        if (
            $ref_lower !== $elv_lower &&
            $ref_noacc === $elv_noacc &&
            !in_array('accent', $temp_problems)
        ) {
            $temp_problems[] = 'accent';
        }
        //erreur d’orthographe si la similarité est forte
        similar_text($ref_lower, $elv_lower, $percent);
        if ($percent > 70 && $ref_lower !== $elv_lower && empty($temp_problems)) {
            $temp_problems[] = 'orthographe';
        }
        //correspondance exacte
        if ($ref_lower === $elv_lower) {
            $found = true;
            $checked[] = $i;
            break;
        }
        //enregistre le meilleur match s'il y a un problème détecté
        if (!empty($temp_problems)) {
            $best_match = ['index' => $i, 'elv' => $elv, 'problems' => $temp_problems];
            break;
        }
    }
    //si correspondance exacte, on passe au mot suivant
    if ($found) continue;
    //sinon on note l'erreur ou l'omission
    if ($best_match) {
        $errors[$cat][] = "$ref ≠ {$best_match['elv']} (" . implode(' + ', $best_match['problems']) . ")";
        $error_counts[$cat]++;
        $checked[] = $best_match['index'];
    } else {
        $errors[$cat][] = "$ref ≠ (omission)";
        $error_counts[$cat]++;
    }
}
//point final manquant
if (in_array('.', $mots_ref) && !in_array('.', $mots_elv)) {
    $deja_omission_point = false;
    if (!empty($errors['PONCTUATION'])) {
        foreach ($errors['PONCTUATION'] as $err) {
            if (strpos($err, '. ≠') !== false) {
                $deja_omission_point = true;
                break;
            }
        }
    }
    if (!$deja_omission_point) {
        $errors['PONCTUATION'][] = ". ≠ (omission)";
        $error_counts['PONCTUATION']++;
    }
}
//construction du rapport des erreurs
$erreurs_finales = "";
foreach ($categories as $cat) {
    if (!empty($errors[$cat])) {
        $count = $error_counts[$cat];
        $mot = ($count === 1) ? "erreur" : "erreurs";
        $erreurs_finales .= "$cat ($count $mot):\n";
        foreach (array_unique($errors[$cat]) as $e) {
            $erreurs_finales .= "- $e\n";
        }
    }
}
//enregistre la réponse et les erreurs dans la base
$stmt = $pdo->prepare("insert into reponses (id_dictee, id_eleve, reponse, erreurs, date_saisie) values (?, ?, ?, ?, ?)");
$stmt->execute([$id_dictee, $id_eleve, $reponse, $erreurs_finales, $date]);
?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>succès - analyse enregistrée</title>
    <style>
        body {
            font-family: 'arial', sans-serif;
            background-color: #faf8fc;
            padding: 20px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
        a.button {
            margin-top: 20px;
            display: inline-block;
            background-color: #6a4d99;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }
        a.button:hover {
            background-color: #e9c3f8;
            color: white;
        }
    </style>
</head>
<body>
<!--message de succès après analyse-->
<div class="success">
    analyse de la dictée terminée et enregistrée avec succès !
</div><br>
<!--lien de retour-->
<a class="button" href="index.php">retour au menu</a>
</body>
</html>