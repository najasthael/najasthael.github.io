<?php
require 'connexion.php';
function calculer_stats($original, $saisi) {
    $distance = levenshtein($original, $saisi);
    $longueur = max(strlen($original), 1);
    $erreur_pourcentage = round(($distance / $longueur) * 100, 2);
    $note = round(max(0, 10 - ($erreur_pourcentage / 10)), 2);
    return [$erreur_pourcentage, $note];
}
$id_dictee = $_GET['id_dictee'] ?? null;
if (empty($id_dictee)) {
    header('Location: stats.php');
    exit();
}
$id_dictee = (int)$id_dictee;
$stmt = $pdo->prepare("SELECT e.nom AS eleve_nom, d.titre, d.contenu, r.reponse, r.erreurs, r.date_saisie
                       FROM reponses r
                       JOIN dictees d ON r.id_dictee = d.id
                       JOIN eleves  e ON r.id_eleve = e.id
                       WHERE d.id = ?
                       ORDER BY e.nom");
$stmt->execute([$id_dictee]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt_titre = $pdo->prepare("SELECT titre FROM dictees WHERE id = ?");
$stmt_titre->execute([$id_dictee]);
$titre = $stmt_titre->fetchColumn();
$titre_fichier = str_replace(' ', '_', $titre); // Nettoie le titre pour un nom de fichier

header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="export_'.$titre_fichier.'.xls"');
echo "\xEF\xBB\xBF"; // UTF-8 correct pour Excel
echo "<table border='1'>";
echo "<tr><th>Élève</th><th>Dictée</th><th>Date</th><th>Erreurs</th><th>Note estimée</th><th>% d'erreur</th></tr>";
foreach ($rows as $row) {
    list($erreur_pourcentage, $note_estimee) = calculer_stats($row['contenu'], $row['reponse']);
    echo "<tr>";
    echo "<td>".htmlspecialchars($row['eleve_nom'])."</td>";
    echo "<td>".htmlspecialchars($row['titre'])."</td>";
    echo "<td>".htmlspecialchars(substr($row['date_saisie'], 0, 10))."</td>";
    echo "<td><pre>".htmlspecialchars($row['erreurs'])."</pre></td>";
    echo "<td>$note_estimee / 10</td>";
    echo "<td>$erreur_pourcentage%</td>";
    echo "</tr>";
}
echo "</table>";
?>