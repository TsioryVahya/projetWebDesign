<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="admin-form-container">
    <div class="form-header">
        <h1><?= esc($title) ?></h1>
        <a href="/admin/dashboard" class="btn btn-secondary">Retour au Dashboard</a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= isset($article) ? '/articles/update/' . $article['id'] : '/articles/store' ?>" method="post" class="admin-form">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="titre">Titre (H1)</label>
            <input type="text" name="titre" id="titre" value="<?= old('titre', $article['titre'] ?? '') ?>" required placeholder="Le titre de l'article">
        </div>

        <div class="form-group">
            <label for="chapeau">Chapeau (Introduction en gras / Meta Description)</label>
            <textarea name="chapeau" id="chapeau" rows="4" required placeholder="L'introduction résumée de l'article"><?= old('chapeau', $article['chapeau'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="corps">Corps de l'article (Contenu riche - HTML simple accepté)</label>
            <textarea name="corps" id="corps" rows="12" required placeholder="Le corps de l'article avec balises H2, H3 intégrées"><?= old('corps', $article['corps'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image_principale">URL de l'image principale</label>
                <input type="text" name="image_principale" id="image_principale" value="<?= old('image_principale', $article['image_principale'] ?? '') ?>" placeholder="https://example.com/image.jpg">
            </div>
            <div class="form-group">
                <label for="image_alt">Texte alternatif (SEO Alt)</label>
                <input type="text" name="image_alt" id="image_alt" value="<?= old('image_alt', $article['image_alt'] ?? '') ?>" placeholder="Description de l'image">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="meta_title">Titre SEO (Meta Title)</label>
                <input type="text" name="meta_title" id="meta_title" value="<?= old('meta_title', $article['meta_title'] ?? '') ?>" placeholder="Titre SEO spécifique">
            </div>
            <div class="form-group">
                <label for="date_publication">Date de publication</label>
                <input type="datetime-local" name="date_publication" id="date_publication" value="<?= old('date_publication', isset($article) ? date('Y-m-d\TH:i', strtotime($article['date_publication'])) : '') ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><?= isset($article) ? 'Mettre à jour' : 'Publier l\'article' ?></button>
    </form>
</div>

<style>
    .admin-form-container { max-width: 900px; margin: 30px auto; padding: 30px; border: 1px solid var(--border-color); background: #fff; }
    .form-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    
    .admin-form .form-group { margin-bottom: 25px; }
    .admin-form label { display: block; font-weight: 700; margin-bottom: 8px; font-family: var(--font-serif); }
    .admin-form input[type="text"], 
    .admin-form input[type="datetime-local"], 
    .admin-form textarea { width: 100%; padding: 12px; border: 1px solid #ccc; font-family: inherit; font-size: 1rem; box-sizing: border-box; }
    
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }

    .btn { padding: 12px 25px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; display: inline-block; font-size: 1rem; }
    .btn-primary { background: #000; color: #fff; }
    .btn-secondary { background: #666; color: #fff; }
    
    .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 25px; }
    .alert-danger ul { margin: 0; padding-left: 20px; }

    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
    }
</style>
<?= $this->endSection() ?>
