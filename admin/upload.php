<?php
/**
 * Script d'upload TinyMCE (Image)
 */
require_once '../config.php';
require_once 'auth_check.php';

// Dossier de destination relatif et absolu
$uploadDirRel = '/public/uploads/articles/';
$uploadDirAbs = __DIR__ . '/..' . $uploadDirRel;

// Créer le dossier s'il n'existe pas
if (!file_exists($uploadDirAbs)) {
    mkdir($uploadDirAbs, 0777, true);
}

// Récupération du fichier
$file = $_FILES['file'] ?? null;

if ($file && $file['error'] === UPLOAD_ERR_OK) {
    // Génération d'un nom unique crypté (pour éviter les doublons)
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = time() . '_' . uniqid() . '.' . $ext;
    
    $destPath = $uploadDirAbs . $newName;
    
    if (move_uploaded_file($file['tmp_name'], $destPath)) {
        // Succès - On renvoie l'URL absolue pour TinyMCE
        echo json_encode([
            'location' => BASE_URL . 'public/uploads/articles/' . $newName
        ]);
        exit;
    }
}

// Échec
header('HTTP/1.1 500 Internal Server Error');
echo json_encode(['error' => 'Échec de l\'upload du fichier.']);
