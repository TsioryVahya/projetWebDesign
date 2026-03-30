<?php
/**
 * Page détail de l'article
 */
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Requête SQL
$query = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$query->execute([$id]);
$article = $query->fetch();

if (!$article) {
    die("Article non trouvé.");
}

$title = $article['titre'];
// Générer une meta description propre pour le SEO
$meta_description = mb_substr(strip_tags($article['chapeau']), 0, 160) . '...';
include 'header.php';
?>

<article class="article-detail">
    <header class="article-header">
        <h1 style="font-family: var(--font-serif); font-size: 3rem; margin-bottom: 20px; line-height: 1.1;">
            <?= htmlspecialchars($article['titre']) ?>
        </h1>
        <div class="article-chapeau">
            <?= nl2br(htmlspecialchars($article['chapeau'])) ?>
        </div>
        <div class="article-meta" style="font-size: 0.9rem; color: var(--secondary-color); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); padding: 10px 0; display: inline-block;">
            Publié le <time><?= date('d/m/Y', strtotime($article['date_publication'])) ?></time>
        </div>
    </header>

    <div class="article-body">
        <?= $article['corps'] // Contenu riche via TinyMCE ?>
    </div>
</article>

<style>
    .article-detail { max-width: 800px; margin: 0 auto; }
    .article-header { margin-bottom: 30px; text-align: center; }
    .article-chapeau {
        font-family: var(--font-serif);
        font-size: 1.45rem;
        color: #333;
        margin-bottom: 25px;
        line-height: 1.4;
        font-weight: 700;
        font-style: italic;
    }
    .article-body {
        font-family: var(--font-serif);
        font-size: 1.2rem;
        line-height: 1.8;
    }
    .article-body h2 {
        font-size: 1.8rem;
        margin-top: 40px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
    }
    .article-body img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 20px auto;
    }
</style>

<?php include 'footer.php'; ?>
