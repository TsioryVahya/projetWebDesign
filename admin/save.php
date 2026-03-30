<?php
/**
 * Script de traitement du formulaire (POST)
 */
require_once '../config.php';
require_once 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int)$_POST['id'];
$titre = trim($_POST['titre']);
$chapeau = trim($_POST['chapeau']);
$corps = $_POST['corps'];
$section = trim($_POST['section']);
$date_publication = !empty($_POST['date_publication']) ? date('Y-m-d H:i:s', strtotime($_POST['date_publication'])) : date('Y-m-d H:i:s');

// Sécurise la section: elle doit exister dans la table des types
try {
    $typeStmt = $pdo->prepare("SELECT COUNT(*) FROM types WHERE nom = ?");
    $typeStmt->execute([$section]);
    if ((int)$typeStmt->fetchColumn() === 0) {
        $fallbackStmt = $pdo->query("SELECT nom FROM types ORDER BY id ASC LIMIT 1");
        $section = $fallbackStmt->fetchColumn() ?: 'International';
    }
} catch (Throwable $e) {
    if ($section === '') {
        $section = 'International';
    }
}

// 1. Extraction automatique de la première image et de son ALT depuis le corps TinyMCE
$image_principale = '';
$image_alt = '';

// Regex pour chercher la 1ère image dans le dossier uploads/articles
if (preg_match('/<img[^>]+src=["\']([^"\']*\/public\/uploads\/articles\/([^"\'?]+))["\'][^>]*>/i', $corps, $matches)) {
    $image_principale = $matches[2]; // ex: mon-image.jpg
    
    // On cherche aussi le ALT dans la même balise
    if (preg_match('/alt=["\']([^"\']*)["\']/', $matches[0], $altMatch)) {
        $image_alt = html_entity_decode(trim($altMatch[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

// 2. Génération automatique du slug (URL propre)
$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titre), '-'));

// 3. Insertion ou Mise à jour en Base de Données
if ($id > 0) {
    // UPDATE
    $sql = "UPDATE articles SET titre=?, chapeau=?, corps=?, image_principale=?, image_alt=?, slug=?, section=?, date_publication=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $chapeau, $corps, $image_principale, $image_alt, $slug, $section, $date_publication, $id]);
} else {
    // INSERT
    $sql = "INSERT INTO articles (titre, chapeau, corps, image_principale, image_alt, slug, section, date_publication) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $chapeau, $corps, $image_principale, $image_alt, $slug, $section, $date_publication]);
}

// Redirection vers le dashboard
header('Location: index.php?success=1');
exit;
