<?php
/**
 * Script d'initialisation de la base de donnees
 * Execute automatiquement au premier demarrage
 * NOTE: Ce fichier est inclus depuis config.php, $pdo est deja disponible
 */

function initializeDatabase($pdo) {
    try {
        // Verifier si les tables existent deja
        $result = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_name = 'utilisateurs'");
        if ($result->fetchColumn() > 0) {
            return; // Tables deja creees
        }

        // Lire et executer le schema SQL
        $schemaPath = __DIR__ . '/../database/schema.sql';
        if (file_exists($schemaPath)) {
            $sql = file_get_contents($schemaPath);
            $pdo->exec($sql);
            error_log("Base de donnees initialisee avec succes");
        }
    } catch (PDOException $e) {
        error_log("Erreur lors de l'initialisation de la base: " . $e->getMessage());
    }
}

// Executer l'initialisation
initializeDatabase($pdo);
?>
