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

<div class="article-list">
    <?php if ($articles): ?>
        <?php foreach ($articles as $idx => $article): ?>
            <?php
                // Nettoyage de l'extrait (Chapeau ou Corps)
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

                // Génération de l'URL propre style "Le Monde" 
                // Format : /actualite/YYYY/MM/DD/slug_id.html
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
                             fetchpriority="<?= $idx === 0 ? 'high' : 'auto' ?>"
                             loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>"
                             decoding="async">
                    </a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
