<?php
/**
 * Formulaire d'édition - Style WordPress
 */
require_once '../config.php';
require_once 'auth_check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = [
    'id' => 0,
    'titre' => '',
    'chapeau' => '',
    'corps' => '',
    'section_type_id' => 0,
    'date_publication' => date('Y-m-d H:i')
];

if ($id > 0) {
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
    $query->execute([$id]);
    $result = $query->fetch();
    if ($result) {
        $article = $result;
        $article['date_publication'] = date('Y-m-d\TH:i', strtotime($article['date_publication']));
    }
}

$typeSections = [];
try {
    $typeStmt = $pdo->query("SELECT id, nom FROM types ORDER BY id ASC");
    $typeSections = $typeStmt->fetchAll();
} catch (Throwable $e) {
    $typeSections = [];
}

if ((int)$article['section_type_id'] <= 0 && !empty($typeSections)) {
    $article['section_type_id'] = (int)$typeSections[0]['id'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $id > 0 ? "Modifier l'article" : "Ajouter un article" ?></title>
    <script src="https://cdn.tiny.cloud/1/sxyjev2bs1aa2f9bg0b00yfxr3l8b908so3ejezh14m8dfzt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        /* Masquer les avertissements "No API Key" qui bloquent l'écriture */
        .tox-notification { display: none !important; }
        .tox-statusbar__branding { display: none !important; }
        
        body { font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; background: #f0f0f1; margin: 0; color: #3c434a; }
        .wp-bar { background: #1d2327; padding: 10px 40px; }
        .wp-bar a { color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; }
        
        .wp-wrap { max-width: 1200px; margin: 20px auto; padding: 0 40px; }
        .wp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }
        .wp-header h1 { font-size: 23px; font-weight: 400; margin: 0; }
        
        /* Conteneur Éditeur style WP */
        .wp-editor-container { display: grid; grid-template-columns: 1fr 300px; gap: 20px; }
        
        /* Zone Titre */
        .wp-title { width: 100%; font-size: 1.7rem; padding: 10px; border: 1px solid #c3c4c7; box-shadow: inset 0 1px 2px rgba(0,0,0,.07); margin-bottom: 20px; box-sizing: border-box; }
        
        /* Metabox style */
        .postbox { background: #fff; border: 1px solid #c3c4c7; margin-bottom: 20px; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .postbox-header { padding: 8px 12px; border-bottom: 1px solid #c3c4c7; font-weight: 600; font-size: 14px; background: #fff; }
        .postbox-inside { padding: 12px; font-size: 13px; }
        
        label { display: block; font-weight: 600; color: #3c434a; margin-bottom: 5px; }
        .wp-select, .wp-input { width: 100%; border: 1px solid #8c8f94; border-radius: 4px; padding: 5px; box-sizing: border-box; font-size: 14px; }
        
        /* Bouton WP */
        .wp-btn { background: #2271b1; border: 1px solid #2271b1; color: #fff; border-radius: 3px; font-weight: 600; padding: 8px 12px; cursor: pointer; text-decoration: none; display: inline-block; width: 100%; text-align: center; box-sizing: border-box; font-size: 13px; }
        .wp-btn:hover { background: #135e96; color: #fff; }
        .wp-btn-secondary { background: #f6f7f7; color: #2271b1; border: 1px solid #2271b1; margin-top: 10px; }
    </style>
</head>
<body>

<div class="wp-bar">
    <a href="index.php">← Retour au Dashboard</a>
</div>

<div class="wp-wrap">
    <div class="wp-header">
        <h1><?= $id > 0 ? "Modifier l'article" : "Ajouter un nouvel article" ?></h1>
    </div>

    <form action="save.php" method="post">
        <input type="hidden" name="id" value="<?= $article['id'] ?>">

        <div class="wp-editor-container">
            <!-- Colonne Principale -->
            <div class="wp-main">
                <input type="text" name="titre" class="wp-title" value="<?= htmlspecialchars($article['titre']) ?>" placeholder="Entrez le titre ici" required>
                
                <div class="postbox" style="margin-bottom: 30px;">
                    <div class="postbox-header">Extrait (Chapeau)</div>
                    <div class="postbox-inside">
                        <textarea name="chapeau" class="wp-input" rows="4" style="border:none; width:100%; outline:none;" placeholder="Optionnel : écrire l'extrait ici..."><?= htmlspecialchars($article['chapeau']) ?></textarea>
                    </div>
                </div>

                <textarea id="my-editor" name="corps"><?= htmlspecialchars($article['corps']) ?></textarea>
            </div>

            <!-- Colonne Latérale (Sidebars) -->
            <div class="wp-side">
                
                <!-- Bloc Publier -->
                <div class="postbox">
                    <div class="postbox-header">Publier</div>
                    <div class="postbox-inside">
                        <label>Date :</label>
                        <input type="datetime-local" name="date_publication" class="wp-input" style="margin-bottom: 15px;" value="<?= $article['date_publication'] ?>">
                        
                        <label>Section :</label>
                        <select name="section_type_id" class="wp-select" style="margin-bottom: 20px;">
                            <?php foreach($typeSections as $type): ?>
                                <option value="<?= (int)$type['id'] ?>" <?= (int)$article['section_type_id'] === (int)$type['id'] ? 'selected' : '' ?>><?= htmlspecialchars($type['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        
                        <input type="submit" class="wp-btn" value="<?= $id > 0 ? 'Mettre à jour' : 'Publier' ?>">
                        <a href="index.php" class="wp-btn wp-btn-secondary">Annuler</a>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    tinymce.init({
        selector: '#my-editor',
        height: 600,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image | help',
        images_upload_url: 'upload.php',
        automatic_uploads: true,
        convert_urls: false,
        branding: false,
        skin: 'oxide',
        content_css: 'default'
    });
</script>

</body>
</html>
