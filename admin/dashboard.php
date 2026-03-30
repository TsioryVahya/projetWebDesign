<?php
/**
 * Dashboard Admin - Accueil avec statistiques
 */
require_once '../config.php';
require_once 'auth_check.php';

// Statistiques globales
$totalArticles = (int)$pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$totalTypes = (int)$pdo->query("SELECT COUNT(*) FROM types")->fetchColumn();
$recentArticles = $pdo->query("SELECT a.id, a.titre, a.date_publication, t.nom AS section_nom FROM articles a INNER JOIN types t ON t.id = a.section_type_id ORDER BY a.date_publication DESC LIMIT 5")->fetchAll();

// Articles par type
$articlesByType = $pdo->query("SELECT t.nom, COUNT(a.id) AS count FROM types t LEFT JOIN articles a ON a.section_type_id = t.id GROUP BY t.id, t.nom ORDER BY count DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Tableau de bord d'administration avec statistiques des articles et des types de navigation.">
    <title>Dashboard - Administration</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; background: #f0f0f1; color: #3c434a; display: flex; }
        
        .wp-sidebar { width: 160px; background: #1d2327; color: #fff; min-height: 100vh; padding-top: 20px; position: fixed; height: 100vh; overflow-y: auto; }
        .wp-sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 15px; font-size: 14px; transition: all 0.2s; }
        .wp-sidebar a:hover { color: #72aee6; background: #2c3338; }
        .wp-sidebar a.active { background: #2271b1; color: #fff; }

        .wp-content { flex: 1; margin-left: 160px; padding: 20px 40px; min-height: 100vh; }
        .wrap { max-width: 1400px; margin: 0 auto; }
        h1 { font-size: 32px; font-weight: 400; margin-bottom: 30px; }

        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        .card { background: #fff; border: 1px solid #c3c4c7; padding: 20px; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .card-title { font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #646970; font-weight: 700; margin-bottom: 10px; }
        .card-stat { font-size: 40px; font-weight: 700; color: #2271b1; }
        .card-action { margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e5e5; }
        .card-action a { display: inline-block; color: #2271b1; text-decoration: none; font-size: 13px; font-weight: 600; }
        .card-action a:hover { text-decoration: underline; }

        .articles-section { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .section-box { background: #fff; border: 1px solid #c3c4c7; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .section-head { padding: 12px 15px; border-bottom: 1px solid #c3c4c7; font-weight: 600; font-size: 14px; background: #fff; }
        .section-body { padding: 0; }

        .recent-item { padding: 12px 15px; border-bottom: 1px solid #f0f0f1; font-size: 13px; display: flex; justify-content: space-between; align-items: center; }
        .recent-item:last-child { border-bottom: none; }
        .recent-title { flex: 1; }
        .recent-title a { color: #2271b1; text-decoration: none; font-weight: 500; }
        .recent-title a:hover { text-decoration: underline; }
        .recent-meta { color: #646970; font-size: 11px; }
        .recent-type { background: #dcdcde; padding: 2px 6px; font-size: 11px; border-radius: 3px; color: #3c434a; font-weight: 600; text-transform: uppercase; white-space: nowrap; }

        .chart-item { padding: 12px 15px; border-bottom: 1px solid #f0f0f1; display: flex; justify-content: space-between; align-items: center; }
        .chart-item:last-child { border-bottom: none; }
        .chart-label { flex: 1; font-size: 13px; }
        .chart-bar { width: 60px; background: #e5e5e5; height: 24px; position: relative; margin: 0 10px; }
        .chart-bar-fill { height: 100%; background: #2271b1; transition: width 0.3s; }
        .chart-count { width: 40px; text-align: right; font-weight: 700; }

        @media (max-width: 900px) {
            .articles-section { grid-template-columns: 1fr; }
            .wp-sidebar { width: 100%; height: auto; position: static; }
            .wp-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<nav class="wp-sidebar" aria-label="Navigation administration">
    <a href="/index.php" style="font-weight: bold; border-bottom: 1px solid #3c434a; margin-bottom: 15px;">Voir le site</a>
    <a href="dashboard.php" class="active">Tableau de bord</a>
    <a href="articles.php">Articles</a>
    <a href="form.php">Ajouter</a>
    <a href="types.php">Types</a>
    <a href="logout.php" style="color: #f08080;">Deconnexion</a>
</nav>

<main class="wp-content">
    <div class="wrap">
        <h1>Bienvenue au tableau de bord</h1>

        <!-- Cartes de statistiques -->
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-title">Articles publies</div>
                <div class="card-stat"><?= $totalArticles ?></div>
                <div class="card-action">
                    <a href="articles.php">Voir tous les articles →</a>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Types de navigation</div>
                <div class="card-stat"><?= $totalTypes ?></div>
                <div class="card-action">
                    <a href="types.php">Gerer les types →</a>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Action rapide</div>
                <div class="card-stat" style="font-size: 24px; color: #3c434a;">+</div>
                <div class="card-action">
                    <a href="form.php">Creer un nouvel article →</a>
                </div>
            </div>
        </div>

        <!-- Section articles et types -->
        <div class="articles-section">
            <!-- Articles recents -->
            <div class="section-box">
                <div class="section-head">Articles recents</div>
                <div class="section-body">
                    <?php if ($recentArticles): ?>
                        <?php foreach ($recentArticles as $article): ?>
                            <div class="recent-item">
                                <div class="recent-title">
                                    <a href="form.php?id=<?= $article['id'] ?>"><?= htmlspecialchars(mb_substr($article['titre'], 0, 35)) ?></a>
                                    <div class="recent-meta"><?= date('d/m/Y', strtotime($article['date_publication'])) ?></div>
                                </div>
                                <span class="recent-type"><?= htmlspecialchars($article['section_nom']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 15px; color: #646970; font-size: 13px;">Aucun article encore.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Articles par type -->
            <div class="section-box">
                <div class="section-head">Articles par type</div>
                <div class="section-body">
                    <?php if ($articlesByType): ?>
                        <?php 
                            $maxCount = max(array_column($articlesByType, 'count')) ?: 1;
                        ?>
                        <?php foreach ($articlesByType as $row): ?>
                            <div class="chart-item">
                                <div class="chart-label"><?= htmlspecialchars($row['nom']) ?></div>
                                <div class="chart-bar">
                                    <div class="chart-bar-fill" style="width: <?= ($row['count'] / $maxCount) * 100 ?>%"></div>
                                </div>
                                <div class="chart-count"><?= $row['count'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 15px; color: #646970; font-size: 13px;">Aucun type.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
