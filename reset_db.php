<?php
/**
 * Script de reinitialisation de la base de donnees
 * SUPPRIMER CE FICHIER APRES UTILISATION
 */

// Cle secrete pour eviter les acces non autorises
$secret = 'reset2024ouaga';

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    die("Acces refuse. Utilisez: reset_db.php?key=$secret");
}

require_once 'includes/config.php';

echo "<h2>Reinitialisation de la base de donnees...</h2>";

try {
    // Supprimer les tables existantes
    $pdo->exec("DROP TABLE IF EXISTS reservations CASCADE");
    echo "<p>Table reservations supprimee</p>";

    $pdo->exec("DROP TABLE IF EXISTS images_sites CASCADE");
    echo "<p>Table images_sites supprimee</p>";

    $pdo->exec("DROP TABLE IF EXISTS sites CASCADE");
    echo "<p>Table sites supprimee</p>";

    $pdo->exec("DROP TABLE IF EXISTS hotels CASCADE");
    echo "<p>Table hotels supprimee</p>";

    $pdo->exec("DROP TABLE IF EXISTS utilisateurs CASCADE");
    echo "<p>Table utilisateurs supprimee</p>";

    echo "<h3>Tables supprimees avec succes!</h3>";
    echo "<p><strong>Maintenant, visitez <a href='patrimoine.php'>patrimoine.php</a> pour recreer les tables avec les bonnes donnees.</strong></p>";
    echo "<p style='color:red;'><strong>IMPORTANT: Supprimez ce fichier (reset_db.php) apres utilisation!</strong></p>";

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erreur: " . $e->getMessage() . "</p>";
}
?>
