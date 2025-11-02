<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Passation de dictée</title> <!--titre de la page-->
  <style>
    /* réinitialisation des styles*/
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    /*style général du corps de la page*/
    body {
      font-family: 'arial', sans-serif;
      background-color: #faf8fc;
      color: #333;
      padding: 20px;
    }
    /*en-tête*/
    header {
      background-color: #f9e5ff;
      padding: 20px;
      text-align: center;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }
    /*titre de l’en-tête*/
    header h1 {
      font-size: 2em;
      color: #6b4b8c;
    }
    /*bloc formulaire principal*/
    section {
      background-color: #ffffff;
      max-width: 600px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }
    /*sous-titre du formulaire*/
    section h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #6b4b8c;
    }
    /*disposition verticale*/
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    /*style des labels*/
    label {
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }
    /*style des champs de formulaire*/
    select, textarea, input[type="submit"], input[type="date"] {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #dcdcdc;
      border-radius: 8px;
      font-size: 1em;
      background-color: #fefefe;
      transition: border-color 0.3s;
    }
    /*effet focus*/
    select:focus, textarea:focus, input[type="date"]:focus {
      border-color: #b3e2d4;
      outline: none;
    }
    /*redimensionnement vertical du textarea*/
    textarea {
      resize: vertical;
    }
    /*style du bouton de soumission*/
    input[type="submit"] {
      background-color: #6a4d99;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s;
      border: none;
    }
    /* effet hover sur le bouton */
    input[type="submit"]:hover {
      background-color: #e9c3f8;
      transform: scale(1.05);
      color: #fff;
    }
  </style>
</head>
<body>
<?php
//connexion à la base de données
require 'connexion.php';
//récupération du niveau sélectionné depuis l’url
$niveauChoisi = $_GET['niveau'] ?? '';
?>
<!--en-tête de la page-->
<header>
  <h1>Application de dictées</h1>
</header>
<!--formulaire de sélection du niveau rechargement automatique-->
<form method="get" style="max-width: 600px; margin: 0 auto 20px auto; text-align: center;">
  <label for="niveau">Choisir par niveau :</label>
  <select name="niveau" id="niveau" onchange="this.form.submit()" style="padding: 10px; border-radius: 8px;">
    <option value="">— Tous les niveaux —</option>
    <?php
    //récupération des niveaux
    $niveaux = $pdo->query("SELECT DISTINCT niveau FROM eleves ORDER BY niveau")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($niveaux as $n) {
        //vérifie si ce niveau est sélectionné
        $selected = ($niveauChoisi === $n['niveau']) ? 'selected' : '';
        echo "<option value='".htmlspecialchars($n['niveau'])."' $selected>".htmlspecialchars($n['niveau'])."</option>";
    }
    ?>
  </select>
</form>
<!--formulaire principal de passation-->
<section>
  <h2>Passation de dictée</h2>
  <form action="analyser_reponse.php" method="POST">
    <!--sélection d’un élève, filtré si un niveau est choisi-->
    <label for="id_eleve">Choisissez un élève :</label>
    <select name="id_eleve" required>
      <?php
      if (!empty($niveauChoisi)) {
          $stmt = $pdo->prepare("SELECT id, nom FROM eleves WHERE niveau = ? ORDER BY nom");
          $stmt->execute([$niveauChoisi]);
          $eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } else {
          $eleves = $pdo->query("SELECT id, nom FROM eleves ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
      }
      foreach ($eleves as $eleve) {
          echo "<option value='" . htmlspecialchars($eleve['id']) . "'>" . htmlspecialchars($eleve['nom']) . "</option>";
      }
      ?>
    </select>
    <!--sélection d'une dictée parmi celles enregistrées-->
    <label for="id_dictee">Choisissez une dictée :</label>
    <select name="id_dictee" required>
      <?php
      foreach ($pdo->query("SELECT id, titre FROM dictees") as $dictee) {
          echo "<option value='" . htmlspecialchars($dictee['id']) . "'>" . htmlspecialchars($dictee['titre']) . "</option>";
      }
      ?>
    </select>
    <!--champ pour indiquer la date de passation-->
    <label for="date_passation">Date de passation :</label>
    <input type="date" name="date_passation" required>
    <!--zone de saisie de la réponse de l’élève-->
    <label for="reponse">Réponse de l’élève :</label>
    <textarea name="reponse" rows="5" placeholder="Tapez la réponse ici..." required></textarea>
    <!--bouton d’envoi pour lancer l’analyse-->
    <input type="submit" value="Analyser et enregistrer">
  </form>
</section>
</body>
</html>