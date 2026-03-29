<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php if (!empty($articles)): ?>
    <div class="article-list">
        <?php foreach ($articles as $index => $article): ?>
            <?php
                $url = '/actualite/' . date('Y/m/d/', strtotime($article['date_publication'])) . $article['slug'] . '_' . $article['id'] . '.html';

                // Priorité au chapeau ; sinon on extrait depuis le corps
                $chapeau_brut = strip_tags($article['chapeau'] ?? '');
                $chapeau_brut = html_entity_decode($chapeau_brut, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $chapeau_brut = preg_replace('/[\s\x{00A0}]+/u', ' ', $chapeau_brut);
                $chapeau_brut = trim($chapeau_brut);

                if (!empty($chapeau_brut)) {
                    // On a un chapeau → on l'utilise, tronqué à 220 chars
                    $extrait = $chapeau_brut;
                } else {
                    // Pas de chapeau → on extrait depuis le corps
                    $extrait = strip_tags($article['corps'] ?? '');
                    $extrait = html_entity_decode($extrait, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $extrait = preg_replace('/[\s\x{00A0}]+/u', ' ', $extrait);
                    $extrait = trim($extrait);
                }

                if (mb_strlen($extrait) > 220) {
                    $extrait = mb_substr($extrait, 0, 220);
                    $extrait = mb_substr($extrait, 0, mb_strrpos($extrait, ' ')) . '…';
                }
            ?>
            <article class="list-card">
                <div class="list-card-body">
                    <?php if (!empty($article['section'])): ?>
                        <span class="card-section"><?= esc(strtoupper($article['section'])) ?></span>
                    <?php endif; ?>

                    <h2 class="card-title">
                        <a href="<?= esc($url) ?>"><?= esc($article['titre']) ?></a>
                    </h2>

                    <?php if (!empty($extrait)): ?>
                        <p class="card-extract"><?= esc($extrait) ?></p>
                    <?php endif; ?>

                    <time class="card-date" datetime="<?= esc($article['date_publication']) ?>">
                        Publié le <?= date('d/m/Y à H\hi', strtotime($article['date_publication'])) ?>
                    </time>
                </div>

                <?php if (!empty($article['image_principale'])): ?>
                    <a href="<?= esc($url) ?>" class="card-img-link">
                        <img src="/uploads/articles/<?= esc($article['image_principale']) ?>"
                             alt="<?= esc(!empty($article['image_alt']) ? $article['image_alt'] : $article['titre']) ?>"
                             width="420" height="220"
                             loading="<?= $index < 2 ? 'eager' : 'lazy' ?>"
                             decoding="async">
                    </a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <p class="no-articles">Aucun article disponible pour le moment.</p>
<?php endif; ?>

<style>
    /* ── LISTE ──────────────────────────────────────── */
    .article-list {
        margin-top: 10px;
    }

    /* ── CARTE ARTICLE ──────────────────────────────── */
    .list-card {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 18px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .list-card:first-child {
        border-top: 1px solid var(--border-color);
    }

    /* ── CORPS TEXTE ────────────────────────────────── */
    .list-card-body {
        flex: 1;
        min-width: 0;
    }

    /* ── SECTION BADGE (Rouge) ───────────────────────── */
    .card-section {
        display: inline-block;
        font-family: var(--font-sans);
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #fff;
        background: #c00;
        padding: 2px 7px;
        margin-bottom: 6px;
        line-height: 1;
    }

    /* ── TITRE ──────────────────────────────────────── */
    .card-title {
        font-family: var(--font-serif);
        font-size: 1.25rem;
        font-weight: 800;
        line-height: 1.25;
        margin: 0 0 8px;
    }

    .card-title a {
        color: inherit;
        text-decoration: underline;
        text-decoration-color: transparent;
        text-underline-offset: 3px;
        transition: text-decoration-color .2s;
    }

    .card-title a:hover {
        text-decoration-color: currentColor;
    }

    /* ── EXTRAIT ───────────────────────────── */
    .card-extract {
        font-family: var(--font-serif);
        font-size: 1.05rem;
        color: #333;
        line-height: 1.5;
        margin: 0 0 8px;
    }

    /* ── DATE ───────────────────────────────────────── */
    .card-date {
        display: block;
        font-family: var(--font-sans);
        font-size: 0.75rem;
        color: var(--secondary-color);
        font-weight: 600;
    }

    /* ── IMAGE MINIATURE ────────────────────────────── */
    .card-img-link {
        flex-shrink: 0;
        display: block;
    }

    .card-img-link img {
        width: 420px;
        height: 220px;
        object-fit: cover;
        display: block;
        transition: transform .3s ease;
    }

    .card-img-link:hover img {
        transform: scale(1.03);
    }

    /* ── RESPONSIVE ─────────────────────────────────── */
    @media (max-width: 900px) {
        .card-img-link img {
            width: 300px;
            height: 160px;
        }
    }

    @media (max-width: 600px) {
        .list-card {
            flex-direction: column-reverse;
        }

        .card-img-link img {
            width: 100%;
            height: 220px;
        }
    }
</style>

<?= $this->endSection() ?>
