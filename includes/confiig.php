<?php
$host = 'localhost';
$port = '5433'; // ton port PostgreSQL personnalisé
$dbname = 'ouaga_tourisme';
$user = 'postgres';
$password = '123456789';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à PostgreSQL ✅";
} catch (PDOException $e) {
    die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
