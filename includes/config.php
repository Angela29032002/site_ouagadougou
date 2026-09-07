<?php
/**
 * Configuration de la base de donnees PostgreSQL
 * Utilise les variables d'environnement pour la production (Render)
 * ou les valeurs par defaut pour le developpement local
 */

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'ouaga_tourisme';
$user = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '123456789';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    // En production, ne pas afficher les details de l'erreur
    if (getenv('DB_HOST')) {
        die("Erreur de connexion a la base de donnees. Veuillez reessayer plus tard.");
    } else {
        die("Erreur de connexion : " . $e->getMessage());
    }
    // Initialiser la base de donnees si necessaire
    require_once __DIR__ . '/init_db.php';
}
?>
