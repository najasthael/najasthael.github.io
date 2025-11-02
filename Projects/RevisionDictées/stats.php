<?php 
require 'connexion.php'; //connexion à la base de données
//fonction qui calcule le taux d’erreur et la note à partir de la distance de levenshtein
function calculer_stats($original, $saisi) {
    $distance = levenshtein($original, $saisi); // calcule le nombre de modifications nécessaires
    $longueur = max(strlen($original), 1); // évite une division par zéro
    $erreur_pourcentage = round(($distance / $longueur) * 100, 2); // convertit en pourcentage
    $note = round(max(0, 10 - ($erreur_pourcentage / 10)), 2); // note sur 10, minimum 0
    return [$erreur_pourcentage, $note]; // retourne un tableau contenant les deux valeurs
}
?>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques générales</title> <!--titre de la page-->
  <style>
    /*reset global*/
    * { margin: 0; padding: 0; box-sizing: border-box; }
    /*style du corps de page*/
    body {
      font-family: 'arial', sans-serif;
      background-color: #faf8fc;
      color: #333;
      padding: 20px;
    }
    /*style de l'en-tête*/
    header {
      background-color: #f9e5ff;
      padding: 20px;
      text-align: center;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }
    /*titre de l'application*/
    header h1 {
      font-size: 2em;
      color: #6b4b8c;
    }
    /*sous-titres*/
    h2 {
      text-align: center;
      color: #6b4b8c;
      margin-bottom: 20px;
    }
    /*formulaire de sélection*/
    form {
      margin-bottom: 30px;
      text-align: center;
    }
    /*liste déroulante*/
    select {
      padding: 10px;
      width: 250px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1em;
      background-color: #ffffff;
      transition: border-color 0.3s;
    }
    select:focus {
      border-color: #b3e2d4;
      outline: none;
    }
    /*bouton d'action*/
    button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #6a4d99;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1em;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s;
    }
    button:hover {
      background-color: #e9c3f8;
      transform: scale(1.05);
      color: #fff;
    }
    /*tableau de résultats*/
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.05);
    }
    th, td {
      border: 1px solid #e0d4f7;
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #f4f0fa;
      color: #6b4b8c;
    }
    td pre {
      white-space: pre-wrap;
      word-wrap: break-word;
    }
    /*paragraphe*/
    p {
      margin-top: 20px;
      text-align: center;
      color: #555;
    }
    /*zone de bouton d’export*/
    .export-btn {
      text-align: center;
      margin-top: 20px;
    }
    /*bouton retour*/
    a.button {
      display: inline-block;
      background-color: #6a4d99;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 8px;
      font-size: 1.1em;
      transition: background-color 0.3s, transform 0.3s;
    }
    a.button:hover {
      background-color: #e9c3f8;
      transform: scale(1.05);
      color: #fff;
    }
    /*centrage général*/
    .container {
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>
<body>
<header>
  <h1>Application de dictées</h1>
</header>
<?php
// récupération des dictées et élèves dans la base
$dictees = $pdo->query("select id, titre from dictees order by id")->fetchAll(PDO::FETCH_ASSOC);
$eleves = $pdo->query("select id, nom, niveau from eleves order by niveau, nom")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>statistiques par dictée</h2> 
<form method="get">
  <!--formulaire permettant de sélectionner une dictée depuis la liste-->
  <label for="id_dictee">choisir une dictée :</label><br>
  <select name="id_dictee" id="id_dictee" onchange="this.form.submit()">
    <!--option par défaut non sélectionnée-->
    <option value="">— sélectionner —</option>
    <!--boucle pour générer une option pour chaque dictée-->
    <?php foreach($dictees as $d): ?>
      <option value="<?= $d['id'] ?>" <?= (isset($_GET['id_dictee']) && $_GET['id_dictee'] == $d['id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($d['titre']) ?>
      </option>
    <?php endforeach; ?>
  </select>
</form>
<h2>statistiques par élève</h2>
<form method="get">
  <!--formulaire permettant de sélectionner un élève depuis la liste-->
  <label for="id_eleve">choisir un élève :</label><br>
  <select name="id_eleve" id="id_eleve" onchange="this.form.submit()">
    <option value="">— sélectionner —</option>
    <!--boucle pour afficher les élèves avec leur niveau-->
    <?php foreach($eleves as $e): ?>
      <option value="<?= $e['id'] ?>" <?= (isset($_GET['id_eleve']) && $_GET['id_eleve'] == $e['id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($e['nom']) ?> (<?= htmlspecialchars($e['niveau']) ?>)
      </option>
    <?php endforeach; ?>
  </select>
</form>
<?php
//si une dictée a été sélectionnée dans l'url
if (isset($_GET['id_dictee']) && !empty($_GET['id_dictee'])) {
    $did = (int)$_GET['id_dictee']; //sécurise la valeur reçue
    //récupère les réponses des élèves à cette dictée
    $stmt = $pdo->prepare("select e.nom, r.reponse, r.erreurs, r.date_saisie 
                           from reponses r 
                           join eleves e on r.id_eleve = e.id 
                           where r.id_dictee = ? 
                           order by e.nom, r.date_saisie");
    $stmt->execute([$did]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>résultats pour la dictée sélectionnée</h2>";
    if ($data) {
        //affiche l’en-tête du tableau
        echo "<table><thead><tr>
                <th>élève</th>
                <th>erreurs</th>
                <th>date</th>
                <th>note estimée</th>
                <th>% d'erreur</th>
              </tr></thead><tbody>";
        foreach ($data as $row) {
            //charge une seule fois le texte original de la dictée
            if (!isset($contenu_dictee)) {
                $stmt_texte = $pdo->prepare("select contenu from dictees where id = ?");
                $stmt_texte->execute([$did]);
                $contenu_dictee = $stmt_texte->fetchColumn();
            }
            //calcule les stats à partir du texte original et de la réponse
            list($erreur_pourcentage, $note_estimee) = calculer_stats($contenu_dictee, $row['reponse']);
            //affiche une ligne par réponse
            echo "<tr>
                    <td>".htmlspecialchars($row['nom'])."</td>
                    <td><pre>".htmlspecialchars($row['erreurs'])."</pre></td>
                    <td>".htmlspecialchars(substr($row['date_saisie'], 0, 10))."</td>
                    <td>$note_estimee / 10</td>
                    <td>$erreur_pourcentage%</td>
                  </tr>";
        }
        echo "</tbody></table>";
        //bouton pour exporter les résultats de cette dictée
        echo "<div class='export-btn'>
                <form method='get' action='export_par_dictee.php'>
                  <input type='hidden' name='id_dictee' value='$did'>
                  <button type='submit'>exporter en excel</button>
                </form>
              </div>";
    } else {
        echo "<p>aucune réponse pour cette dictée.</p>";
    }
}
//si un élève a été sélectionné dans l'url
if (isset($_GET['id_eleve']) && !empty($_GET['id_eleve'])) {
    $eid = (int)$_GET['id_eleve']; // sécurise l’id
    //récupère toutes les réponses de cet élève avec les dictées associées
    $stmt = $pdo->prepare("select d.titre, r.reponse, r.erreurs, r.date_saisie 
                           from reponses r 
                           join dictees d on r.id_dictee = d.id 
                           where r.id_eleve = ? 
                           order by r.date_saisie desc");
    $stmt->execute([$eid]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>résultats pour l'élève sélectionné</h2>";
    if ($data) {
        echo "<table><thead><tr>
                <th>dictée</th>
                <th>réponse</th>
                <th>erreurs</th>
                <th>date</th>
                <th>note estimée</th>
                <th>% d'erreur</th>
              </tr></thead><tbody>";
        foreach ($data as $row) {
            //récupère le texte original de chaque dictée par titre
            $stmt2 = $pdo->prepare("select contenu from dictees where titre = ?");
            $stmt2->execute([$row['titre']]);
            $contenu = $stmt2->fetchColumn();
            //calcule les statistiques pour chaque réponse
            list($erreur_pourcentage, $note_estimee) = calculer_stats($contenu, $row['reponse']);
            echo "<tr>
                    <td>".htmlspecialchars($row['titre'])."</td>
                    <td>".nl2br(htmlspecialchars($row['reponse']))."</td>
                    <td><pre>".htmlspecialchars($row['erreurs'])."</pre></td>
                    <td>".htmlspecialchars(substr($row['date_saisie'], 0, 10))."</td>
                    <td>$note_estimee / 10</td>
                    <td>$erreur_pourcentage%</td>
                  </tr>";
        }
        echo "</tbody></table>";
        //bouton pour exporter les résultats de cet élève
        echo "<div class='export-btn'>
                <form method='get' action='export_par_eleve.php'>
                  <input type='hidden' name='id_eleve' value='$eid'>
                  <button type='submit'>exporter en excel</button>
                </form>
              </div>";
    } else {
        echo "<p>aucune réponse pour cet élève.</p>";
    }
}
?>
<br><a class="button" href="index.php">retour au menu</a>
</body>
</html>