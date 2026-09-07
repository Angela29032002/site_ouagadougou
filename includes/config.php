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

// En production (Render), utiliser SSL
$sslmode = getenv('DB_HOST') ? ';sslmode=require' : '';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname$sslmode",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    // Initialiser la base de donnees si necessaire (tables du site Ouagadougou)
    require_once __DIR__ . '/init_db.php';

} catch (PDOException $e) {
    // Temporairement afficher l'erreur pour debug
    die("Erreur DB: " . $e->getMessage() . " | Host: $host | DB: $dbname");
}
?>
