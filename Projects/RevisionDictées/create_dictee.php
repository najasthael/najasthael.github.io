<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer une dictée</title> <!--titre de la page-->
  <style>
    /*réinitialisation des marges*/
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
    /*titre principal*/
    header h1 {
      font-size: 2em;
      color: #6b4b8c;
    }
    /*section centrale*/
    section {
      background-color: #ffffff;
      max-width: 600px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }
    /*sous-titre de la section*/
    section h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #6b4b8c;
    }
    /*disposition du formulaire*/
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    /*style des libellés*/
    p {
      font-weight: bold;
      margin-top: 15px;
      margin-bottom: 5px;
      color: #555;
      text-align: center;
    }
    /*champs de texte et zone de saisie*/
    input[type="text"], textarea {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #dcdcdc;
      border-radius: 8px;
      font-size: 1em;
      background-color: #fefefe;
      transition: border-color 0.3s;
    }
    /*effet visuel*/
    input[type="text"]:focus, textarea:focus {
      border-color: #b3e2d4;
      outline: none;
    }
    /*redimensionnement du textarea*/
    textarea {
      resize: vertical;
    }
    /*bouton de soumission du formulaire*/
    input[type="submit"] {
      margin-top: 20px;
      background-color: #6a4d99;
      color: white;
      font-weight: bold;
      border: none;
      padding: 12px 20px;
      font-size: 1.1em;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s;
    }
    /*effet de survol du bouton*/
    input[type="submit"]:hover {
      background-color: #e9c3f8;
      transform: scale(1.05);
      color: #fff;
    }
  </style>
</head>
<body>
<!-- en-tête-->
<header>
  <h1>Application de dictées</h1>
</header>
<!--formulaire de création d'une nouvelle dictée-->
<section>
  <h2>Créer une nouvelle dictée</h2>
  <form action="save_dictee.php" method="POST">
    <!--champ pour le titre de la dictée-->
    <p>Titre de la dictée :</p>
    <input type="text" name="titre" required>
    <!--champ pour le contenu-->
    <p>Contenu de la dictée de mots (séparés par , ou ; ) :</p>
    <textarea name="contenu" rows="5" required></textarea>
    <!--bouton pour envoyer le formulaire-->
    <input type="submit" value="Enregistrer">
  </form>
</section>

</body>
</html>