<?php
/**
 * Script de suppression simple (DELETE)
 */
require_once '../config.php';
require_once 'auth_check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php?deleted=1');
exit;
