<?php
/**
 * Page d'accueil - Liste des articles
 */
require_once 'config.php';

// Filtre par section ?
$section = isset($_GET['section']) ? $_GET['section'] : null;

// Requête SQL
if ($section) {
    $query = $pdo->prepare("SELECT a.*, t.nom AS section_nom FROM articles a INNER JOIN types t ON t.id = a.section_type_id WHERE t.nom = ? ORDER BY a.date_publication DESC");
    $query->execute([$section]);
} else {
    $query = $pdo->query("SELECT a.*, t.nom AS section_nom FROM articles a INNER JOIN types t ON t.id = a.section_type_id ORDER BY a.date_publication DESC");
}

$articles = $query->fetchAll();

$title = $section ? $section : "Accueil";
include 'header.php';
?>

<?php
$featured = isset($articles[0]) ? $articles[0] : null;
$other_articles = array_slice($articles, 1);
?>

<?php if ($featured): ?>
    <?php
        $date_slug = date('Y/m/d', strtotime($featured['date_publication']));
        $url = "/actualite/{$date_slug}/" . ($featured['slug'] ?: 'article') . "_{$featured['id']}.html";
        $featuredSection = $featured['section_nom'] ?? ($featured['section'] ?? '');
    ?>
    <section class="featured-article">
        <a href="<?= $url ?>" class="featured-link">
            <div class="featured-content">
                <?php if (!empty($featuredSection)): ?>
                    <span class="card-section"><?= htmlspecialchars((string)$featuredSection) ?></span>
                <?php endif; ?>
                <h1 class="featured-title"><?= htmlspecialchars($featured['titre']) ?></h1>
                <p class="featured-excerpt"><?= htmlspecialchars(mb_substr(strip_tags($featured['chapeau']), 0, 250)) ?>...</p>
                <time class="card-date">Publié le <?= date('d/m/Y à H\hi', strtotime($featured['date_publication'])) ?></time>
            </div>
            <?php if (!empty($featured['image_principale'])): ?>
                <div class="featured-image">
                    <img src="/public/uploads/articles/<?= htmlspecialchars($featured['image_principale']) ?>" 
                         alt="<?= htmlspecialchars($featured['image_alt'] ?? '') ?>"
                         fetchpriority="high">
                </div>
            <?php endif; ?>
        </a>
    </section>
    <hr class="section-divider">
<?php endif; ?>

<div class="article-list">
    <?php if ($other_articles): ?>
        <?php foreach ($other_articles as $idx => $article): ?>
            <?php
                // Nettoyage de l'extrait
                $chapeau_brut = strip_tags($article['chapeau'] ?? '');
                $chapeau_brut = html_entity_decode($chapeau_brut, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $chapeau_brut = preg_replace('/[\s\x{00A0}]+/u', ' ', $chapeau_brut);
                $chapeau_brut = trim($chapeau_brut);

                if (!empty($chapeau_brut)) {
                    $extrait = $chapeau_brut;
                } else {
                    $extrait = strip_tags($article['corps'] ?? '');
                    $extrait = html_entity_decode($extrait, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $extrait = preg_replace('/[\s\x{00A0}]+/u', ' ', $extrait);
                    $extrait = trim($extrait);
                }

                if (mb_strlen($extrait) > 220) {
                    $extrait = mb_substr($extrait, 0, 220);
                    $extrait = mb_substr($extrait, 0, mb_strrpos($extrait, ' ')) . '…';
                }

                $date_slug = date('Y/m/d', strtotime($article['date_publication']));
                $url = "/actualite/{$date_slug}/" . ($article['slug'] ?: 'article') . "_{$article['id']}.html";
            ?>
            <article class="list-card">
                <div class="list-card-body">
                    <?php if (!empty($article['section_nom'])): ?>
                        <span class="card-section"><?= htmlspecialchars($article['section_nom']) ?></span>
                    <?php endif; ?>

                    <h2 class="card-title">
                        <a href="<?= $url ?>" style="text-decoration: none; color: inherit;">
                            <?= htmlspecialchars($article['titre']) ?>
                        </a>
                    </h2>

                    <?php if (!empty($extrait)): ?>
                        <p class="card-extract"><?= htmlspecialchars($extrait) ?></p>
                    <?php endif; ?>

                    <time class="card-date">
                        Publié le <?= date('d/m/Y à H\hi', strtotime($article['date_publication'])) ?>
                    </time>
                </div>

                <?php if (!empty($article['image_principale'])): ?>
                    <a href="<?= $url ?>" class="card-img-link">
                        <img src="/public/uploads/articles/<?= htmlspecialchars($article['image_principale']) ?>"
                             alt="<?= htmlspecialchars($article['image_alt'] ?? '') ?>"
                             width="420" height="220"
                             loading="lazy"
                             decoding="async">
                    </a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php elseif (!$featured): ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>
</div>

<style>
    /* ── STYLE DE "LA UNE" ────────────────────────────── */
    .featured-article {
        margin-bottom: 40px;
        padding: 20px 0;
    }
    .featured-link {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 30px;
        text-decoration: none;
        color: inherit;
        align-items: center;
    }
    .featured-title {
        font-family: var(--font-serif);
        font-size: 2.8rem;
        font-weight: 900;
        line-height: 1.1;
        margin: 15px 0;
    }
    .featured-excerpt {
        font-family: var(--font-serif);
        font-size: 1.25rem;
        line-height: 1.5;
        color: #333;
        margin-bottom: 20px;
    }
    .featured-image img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        display: block;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .section-divider {
        border: 0;
        border-top: 3px solid #000;
        margin: 40px 0;
    }

    @media (max-width: 900px) {
        .featured-link {
            grid-template-columns: 1fr;
        }
        .featured-title { font-size: 2rem; }
        .featured-image img { height: 300px; }
    }
</style>

<?php include 'footer.php'; ?>
