<?php
/**
 * Fichier de configuration et connexion à la Base de Données
 */

// Paramètres de connexion (Correspondent à votre docker-compose)
$host = 'db';
$dbname = 'journal_db';
$username = 'admin';
$password = 'admin123';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Activer les erreurs PDO pour le développement
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// URL de base du site (utile pour les liens et images)
define('BASE_URL', 'http://localhost:8080/');
define('SITE_NAME', 'La Gazette');
