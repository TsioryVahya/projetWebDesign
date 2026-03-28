<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="home-grid">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $index => $article): ?>
            <?php 
                $article_url = '/actualite/' . date('Y/m/d/', strtotime($article['date_publication'])) . $article['slug'] . '_' . $article['id'] . '.html';
                $is_main = ($index === 0);
            ?>
            <article class="article-card <?= $is_main ? 'main-article' : '' ?>">
                <?php if (!empty($article['image_principale'])): ?>
                    <a href="<?= esc($article_url) ?>">
                        <img src="<?= esc($article['image_principale']) ?>" 
                             alt="<?= esc($article['image_alt'] ?? 'Image de l\'article') ?>"
                             loading="<?= $index < 2 ? 'eager' : 'lazy' ?>"
                             decoding="async"
                             width="800"
                             height="450">
                    </a>
                <?php endif; ?>
                
                <div class="article-content">
                    <h2><a href="<?= esc($article_url) ?>"><?= esc($article['titre']) ?></a></h2>
                    <p class="article-chapeau"><?= esc($article['chapeau']) ?></p>
                    <time datetime="<?= esc($article['date_publication']) ?>"><?= date('d/m/Y', strtotime($article['date_publication'])) ?></time>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
</div>

<style>
    .home-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 20px;
    }

    .main-article {
        grid-column: span 3;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 40px;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 40px;
        margin-bottom: 20px;
    }

    .main-article h2 { font-size: 2.5rem; line-height: 1.1; }

    .article-card h2 { margin: 10px 0; font-size: 1.4rem; }
    .article-card h2 a { color: inherit; text-decoration: none; }
    .article-card h2 a:hover { text-decoration: underline; }

    .article-chapeau { color: #555; font-size: 0.95rem; margin-bottom: 10px; }
    
    time { font-size: 0.8rem; color: var(--secondary-color); font-weight: bold; }

    @media (max-width: 992px) {
        .home-grid { grid-template-columns: repeat(2, 1fr); }
        .main-article { grid-column: span 2; grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .home-grid { grid-template-columns: 1fr; }
        .main-article { grid-column: span 1; }
    }
</style>
<?= $this->endSection() ?>
