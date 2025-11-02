<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Correction automatique</title> <!--titre de la page dans l'onglet-->
  <style>
    /* style général du corps de la page */
    body {
      font-family: arial;
      background: #fdf6ff;
      padding: 30px;
      color: #333;
    }
    /* style de la zone de texte */
    textarea {
      width: 100%;
      height: 150px;
      padding: 10px;
      font-size: 1em;
      margin-bottom: 20px;
    }
    /* style du bouton de soumission */
    button {
      padding: 10px 20px;
      background: #6a4d99;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    /* bloc pour afficher les résultats de correction */
    .result {
      margin-top: 20px;
      padding: 10px;
      background: #eaffea;
      border: 1px solid #bdf5bd;
    }
    /* style du bouton retour au menu */
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
    /* effet visuel au survol du bouton retour */
    a.button:hover {
      background-color: #e9c3f8;
      transform: scale(1.05);
      color: #fff;
    }
    /* centrage du contenu avec espacement vertical */
    .container {
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>
<body>
<!-- titre principal de la page -->
<h1>Correction automatique</h1>
<!-- formulaire permettant à l'utilisateur de saisir un texte -->
<form method="post">
  <!-- zone de saisie préremplie si un texte a déjà été soumis -->
  <textarea name="texte"><?= isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : '' ?></textarea><br>
  <button type="submit">Corriger</button> <!-- bouton pour envoyer le texte -->
</form>
<?php
// si un texte a été soumis
if (!empty($_POST['texte'])) {
    $texte = $_POST['texte']; // récupère le texte depuis la requête post
    $ch = curl_init(); // initialise la session curl
    // configuration de la requête curl vers l'api languagetool
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.languagetool.org/v2/check', // url de l'api de correction
        CURLOPT_RETURNTRANSFER => true, // retourne la réponse sous forme de chaîne
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'text' => $texte, // texte à analyser
            'language' => 'fr', // langue définie en français
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: DictéeApp/1.0' // nom d'application 
        ]
    ]);
    $response = curl_exec($ch); // exécute la requête
    curl_close($ch); // ferme la session curl
    $data = json_decode($response, true); // décode la réponse json
    // s’il y a des erreurs détectées dans le texte
    if (!empty($data['matches'])) {
        echo "<div class='result'><strong>Suggestions :</strong><ul>"; // début du bloc résultat
        // boucle sur chaque erreur détectée
        foreach ($data['matches'] as $match) {
            $mot_incorrect = substr($texte, $match['offset'], $match['length']); // extrait le mot fautif
            echo "<li><strong>" . htmlspecialchars($mot_incorrect) . "</strong> → ";
            // s’il y a des suggestions proposées
            if (!empty($match['replacements'])) {
                // affiche les suggestions séparées par virgule
                echo "<em>" . implode(', ', array_column($match['replacements'], 'value')) . "</em>";
                // ajoute un lien vers le conjugueur si l'erreur semble liée à un verbe
                if (stripos($match['rule']['category']['name'], 'grammaire') !== false || stripos($match['message'], 'verbe') !== false) {
                    echo " <a href='https://leconjugueur.lefigaro.fr/conjugaison/verbe/" . urlencode($mot_incorrect) . ".html' target='_blank'>(Conjuguer)</a>";
                }
            } else {
                echo "<em>Pas de suggestion</em>"; // aucun remplacement proposé
            }
            echo "</li>"; // fin de l'élément de la liste
        }
        echo "</ul></div>"; // fin du bloc de suggestions
    } else {
        // si aucune erreur détectée par languagetool
        echo "<div class='result'>Aucune erreur détectée.</div>";
    }
}
?>
<!-- lien retour vers le menu principal -->
<br><a class="button" href="index.php">Retour au menu</a>
</body>
</html>