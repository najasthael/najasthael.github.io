<?php 
require 'connexion.php'; //de connexion à la base de données pdo
//fonction pour calculer le pourcentage d'erreur et la note estimée à partir de la distance de levenshtein
function calculer_stats($original, $saisi) {
    $distance = levenshtein($original, $saisi); //calcule la distance minimale de transformation entre les deux chaînes
    $longueur = max(strlen($original), 1); //évite division par zéro en cas de texte vide
    $erreur_pourcentage = round(($distance / $longueur) * 100, 2); //convertit la distance en pourcentage arrondi à 2 décimales
    $note = round(max(0, 10 - ($erreur_pourcentage / 10)), 2); //calcule une note sur 10 en pénalisant selon l'erreur
    return [$erreur_pourcentage, $note]; //retourne les deux valeurs dans un tableau
}
//récupère l'identifiant de l'élève depuis l'url (méthode get)
$id_eleve = $_GET['id_eleve'] ?? null;
//redirige vers la page stats.php si aucun id n'est fourni
if (empty($id_eleve)) {
    header('Location: stats.php'); // redirection http
    exit(); // stoppe le script immédiatement
}
//conversion de l'id en entier
$id_eleve = (int)$id_eleve;
//prépare une requête pour obtenir le nom et le niveau de l'élève
$stmt_info = $pdo->prepare("SELECT nom, niveau FROM eleves WHERE id = ?");
$stmt_info->execute([$id_eleve]); //exécute avec l'id comme paramètre
$eleve_info = $stmt_info->fetch(PDO::FETCH_ASSOC); //récupère les infos de l'élève sous forme de tableau
$prenom = $eleve_info['nom']; //extrait le nom de l'élève
$classe = $eleve_info['niveau']; //extrait le niveau (classe) de l'élève
//prépare une requête pour obtenir toutes les réponses de cet élève
$stmt = $pdo->prepare("SELECT d.titre, r.reponse, r.erreurs, r.date_saisie
                       FROM reponses r
                       JOIN dictees d ON r.id_dictee = d.id
                       WHERE r.id_eleve = ?
                       ORDER BY r.date_saisie DESC");
$stmt->execute([$id_eleve]); //exécute la requête
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); //stocke toutes les réponses sous forme de tableau
//configure les en-têtes http pour téléchargement d’un fichier excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); //type de fichier excel
header('Content-Disposition: attachment; filename="export_'.$prenom.'_'.$classe.'.xls"'); //nom du fichier exporté

echo "\xEF\xBB\xBF"; //bom utf-8 pour que excel lise bien les accents
//début du tableau html utilisé comme contenu du fichier excel
echo "<table border='1'>";
//première ligne : en-tête des colonnes
echo "<tr><th>Dictée</th><th>Réponse de l'élève</th><th>Erreurs</th><th>Date</th><th>Note estimée</th><th>% d'erreur</th></tr>";
//boucle sur chaque ligne de réponse récupérée
foreach ($rows as $row) {
    //récupère le texte original de la dictée correspondant à la réponse
    $stmt2 = $pdo->prepare("SELECT contenu FROM dictees WHERE titre = ?");
    $stmt2->execute([$row['titre']]);
    $contenu = $stmt2->fetchColumn(); //extrait le champ "contenu"
    //calcule les stats (note + erreur) en comparant le texte original à la réponse de l’élève
    list($erreur_pourcentage, $note_estimee) = calculer_stats($contenu, $row['reponse']);
    //crée une ligne dans le tableau avec toutes les données formatées
    echo "<tr>";
    echo "<td>".htmlspecialchars($row['titre'])."</td>"; //affiche le titre de la dictée
    echo "<td>".nl2br(htmlspecialchars($row['reponse']))."</td>"; //affiche la réponse avec sauts de ligne
    echo "<td><pre>".htmlspecialchars($row['erreurs'])."</pre></td>"; //affiche les erreurs avec mise en forme
    echo "<td>".htmlspecialchars(substr($row['date_saisie'], 0, 10))."</td>"; //affiche la date sans l’heure
    echo "<td>$note_estimee / 10</td>"; //note calculée
    echo "<td>$erreur_pourcentage%</td>"; //pourcentage d'erreur
    echo "</tr>";
}
//fin du tableau
echo "</table>";
?>