<?php
/**
 * Dashboard Admin - Style WordPress
 */
require_once '../config.php';
require_once 'auth_check.php';

$query = $pdo->query("SELECT a.*, t.nom AS section_nom FROM articles a INNER JOIN types t ON t.id = a.section_type_id ORDER BY a.created_at DESC");
$articles = $query->fetchAll();

$title = "Dashboard - PHP Vanilla";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- On garde les polices système de WP -->
    <style>
        body { font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; background: #f0f0f1; color: #3c434a; margin: 0; display: flex; }
        
        /* Sidebar Admin (simulation légère) */
        .wp-sidebar { width: 160px; background: #1d2327; color: #fff; min-height: 100vh; padding-top: 20px; }
        .wp-sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 15px; font-size: 14px; }
        .wp-sidebar a:hover { color: #72aee6; background: #2c3338; }

        /* Contenu Principal */
        .wp-content { flex: 1; padding: 20px 40px; }
        .wrap { max-width: 1200px; margin: 0 auto; }
        
        .header-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        h1 { font-size: 23px; font-weight: 400; margin: 0; }
        
        .page-title-action { border: 1px solid #2271b1; border-radius: 3px; color: #2271b1; font-size: 13px; font-weight: 600; padding: 4px 8px; text-decoration: none; margin-left: 10px; }
        .page-title-action:hover { background: #2271b1; color: #fff; }

        /* Tableau style WP */
        .wp-list-table { width: 100%; border: 1px solid #c3c4c7; background: #fff; border-collapse: collapse; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .wp-list-table th { text-align: left; padding: 10px; border-bottom: 1px solid #c3c4c7; font-size: 14px; color: #2c3338; font-weight: 700; }
        .wp-list-table td { padding: 10px; border-bottom: 1px solid #f0f0f1; font-size: 13px; vertical-align: top; }
        .wp-list-table tr:hover { background: #f6f7f7; }

        .row-title { font-size: 14px; font-weight: 600; color: #2271b1; text-decoration: none; display: block; margin-bottom: 5px; }
        .row-actions { visibility: hidden; font-size: 12px; color: #a1a1a1; }
        tr:hover .row-actions { visibility: visible; }
        .row-actions a { color: #2271b1; text-decoration: none; }
        .row-actions a.delete { color: #b32d2e; }

        .badge-section { background: #dcdcde; padding: 2px 6px; font-size: 11px; border-radius: 3px; color: #3c434a; font-weight: 600; text-transform: uppercase; }
    </style>
</head>
<body>

<div class="wp-sidebar">
    <a href="/index.php" style="font-weight: bold; border-bottom: 1px solid #3c434a; margin-bottom: 15px;">Voir le site</a>
    <a href="index.php" style="background:#2271b1">Articles</a>
    <a href="form.php">Ajouter</a>
    <a href="logout.php" style="color: #f08080;">Déconnexion</a>
</div>

<div class="wp-content">
    <div class="wrap">
        <div class="header-top">
            <h1>Articles <a href="form.php" class="page-title-action">Ajouter</a></h1>
        </div>

        <table class="wp-list-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Titre</th>
                    <th>Section</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <?php
                        // On construit l'URL propre comme sur l'accueil
                        $date_slug = date('Y/m/d', strtotime($article['date_publication']));
                        $url = "/actualite/{$date_slug}/" . ($article['slug'] ?: 'article') . "_{$article['id']}.html";
                    ?>
                    <td>
                        <a href="form.php?id=<?= $article['id'] ?>" class="row-title"><?= htmlspecialchars($article['titre']) ?></a>
                        <div class="row-actions">
                            <a href="form.php?id=<?= $article['id'] ?>">Modifier</a> | 
                            <a href="<?= $url ?>" target="_blank">Afficher</a> | 
                            <a href="delete.php?id=<?= $article['id'] ?>" class="delete" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </div>
                    </td>
                    <td><span class="badge-section"><?= htmlspecialchars($article['section_nom']) ?></span></td>
                    <td>
                        <?= date('d/m/Y', strtotime($article['date_publication'])) ?><br>
                        <span style="color:#646970; font-size:11px;">Publié</span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
