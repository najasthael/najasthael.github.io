<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Application de Dictées</title> <!--titre de l'onglet-->
    <style>
        /*reset des marges/paddings par défaut*/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'arial', sans-serif;
            line-height: 1.6;
            background-color: #faf8fc;
            color: #333;
            padding: 20px;
        }
        /* en-tête violet*/
        header {
            background-color: #f9e5ff;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        /*titre principal*/
        header h1 {
            font-size: 2em;
            color: #6b4b8c;
        }
        /*bloc bienvenue*/
        #ref {
            background-color: #ffeaf0;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 1.2em;
            color: #aa3f58;
        }
        /*section principale*/
        section {
            margin: 30px auto;
            padding: 20px;
            width: 90%;
            max-width: 1000px;
        }
        article {
            background-color: #f4f0fa;
            border: 1px solid #e0d4f7;
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
        }
        /*titres des articles*/
        article h2 {
            font-size: 1.5em;
            color: #6b4b8c;
            margin-bottom: 10px;
        }
        /*description des actions*/
        .phrase {
            margin-bottom: 15px;
            font-size: 1em;
            color: #555;
        }
        /* style des boutons*/
        a.survol {
            text-decoration: none;
            background-color: #6a4d99;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1.1em;
            display: inline-block;
            transition: background-color 0.3s, transform 0.3s;
        }
        a.survol:hover {
            background-color: #e9c3f8;
            color: #fff;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<!--en-tête avec titre-->
<header>
    <h1>Application de dictées</h1>
</header>
<!--message d’accueil-->
<div id="ref">
    <p>Bienvenue dans l'application de dictée de mots pour les élèves !</p>
</div>
<!--zone principale avec 4 fonctionnalités-->
<section>
    <article>
        <h2>Créer une dictée</h2>
        <p class="phrase">Rédigez une nouvelle dictée à proposer aux élèves.</p>
        <p class="phrase"><a href="create_dictee.php" class="survol">Créer</a></p>
    </article>
    <article>
        <h2>Faire une dictée</h2>
        <p class="phrase">Accédez à une dictée et saisissez les réponses d'un élève.</p>
        <p class="phrase"><a href="passation.php" class="survol">Commencer</a></p>
    </article>
    <article>
        <h2>Statistiques</h2>
        <p class="phrase">Consultez les résultats et suivez les progrès.</p>
        <p class="phrase"><a href="stats.php" class="survol">Voir les statistiques</a></p>
    </article>
    <article>
        <h2>Correction automatique</h2>
        <p class="phrase">Corrigez la dictée avec les mots suggérés.</p>
        <p class="phrase"><a href="correction_externe.php" class="survol">Corriger</a></p>
    </article>
</section>

</body>
</html>
