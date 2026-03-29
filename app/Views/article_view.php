<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<article class="article-detail">
    <header class="article-header">
        <h1><?= esc($article['titre']) ?></h1>
        <div class="article-chapeau">
            <?= $article['chapeau'] ?>
        </div>
        <div class="article-meta">
            Publié le <time datetime="<?= esc($article['date_publication']) ?>"><?= date('d/m/Y', strtotime($article['date_publication'])) ?></time>
        </div>
    </header>


    <div class="article-body">
        <?= $article['corps'] // Contenu riche (H2, H3 intégrés) ?>
    </div>
</article>

<style>
    .article-detail {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .article-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .article-header h1 {
        font-size: 3rem;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .article-chapeau {
        font-family: var(--font-serif);
        font-size: 1.45rem;
        color: #333;
        margin-bottom: 25px;
        line-height: 1.4;
        font-weight: 700;
        font-style: italic; /* Style typique des chapeaux Le Monde */
    }

    .article-chapeau p {
        margin: 0;
    }

    .article-meta {
        font-size: 0.9rem;
        color: var(--secondary-color);
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        padding: 10px 0;
        display: inline-block;
    }

    .article-figure {
        margin: 0 0 40px 0;
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

    @media (max-width: 768px) {
        .article-header h1 { font-size: 2rem; }
        .article-body { font-size: 1.1rem; }
    }
</style>
<?= $this->endSection() ?>
