<?php
try {
    $pdo = new PDO("pgsql:host=localhost;port=5433; dbname=ouaga_tourisme", "postgres", "123456789");
    echo "Connexion réussie à PostgreSQL ✅";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
