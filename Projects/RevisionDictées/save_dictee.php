<?php
//fichier de connexion à la base de données
require 'connexion.php';
//récupération des données
$titre = $_POST['titre'];
$contenu = $_POST['contenu'];
//préparation de la requête d'insertion
$sql = "INSERT INTO dictees (titre, contenu) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
//exécution de la requête
$stmt->execute([$titre, $contenu]);
?>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <title>Succès - Dictée enregistrée</title> <!--titre dans l'onglet-->
    <style>
        /*reset des marges et paddings*/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* style global du corps de la page */
        body {
            font-family: 'arial', sans-serif;
            background-color: #faf8fc;
            color: #333;
            padding: 20px;
        }
        /*en-tête violet*/
        header {
            background-color: #f9e5ff;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        /* titre dans l'en-tête */
        header h1 {
            font-size: 2em;
            color: #6b4b8c;
        }
        /*bloc vert = succès*/
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            margin: 0 auto 30px auto;
            border: 1px solid #c3e6cb;
            border-radius: 10px;
            max-width: 500px;
            font-size: 1.2em;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        /*bouton de retour*/
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
        /*effet au survol du bouton*/
        a.button:hover {
            background-color: #e9c3f8;
            transform: scale(1.05);
            color: #fff;
        }
        /*centrage du contenu principal*/
        .container {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<!--en-tête de l'application-->
<header>
    <h1>Application de dictées</h1>
</header>
<!--bloc principal-->
<div class="container">
    <div class="success">
        la dictée a été enregistrée avec succès !
    </div>
    <!--bouton pour retourner au menu principal-->
    <a class="button" href="index.php">Retour au menu</a>
</div>
</body>
</html>