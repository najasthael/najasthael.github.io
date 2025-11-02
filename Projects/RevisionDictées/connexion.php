<?php 
//connexion à la base de données avec les identifiants
try {
    //création d'un objet pdo pour se connecter à mysql avec le nom d'utilisateur et le mot de passe
    $pdo = new PDO('mysql:host=localhost;dbname=leteillierm', 'leteillierm', '&leteillierm;'); 
    //configuration du pdo pour générer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "La base est ouverte !";
} catch (Exception $e) {
    //en cas d'échec de la connexion = affichage de l'erreur, arrêt du script
    die("Connexion échouée : " . $e->getMessage());
}
?>