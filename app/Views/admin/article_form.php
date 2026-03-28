<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<form action="<?= isset($article) ? '/articles/update/' . $article['id'] : '/articles/store' ?>" method="post" class="wp-editor-form">
    <?= csrf_field() ?>

    <div class="wp-editor-container">
        <!-- Main Column: Title and Content -->
        <div class="wp-editor-main">
            <div class="wp-title-wrapper">
                <input type="text" name="titre" id="titre" class="wp-title-input" 
                       value="<?= old('titre', $article['titre'] ?? '') ?>" 
                       required placeholder="Saisir le titre ici">
            </div>

            <div class="wp-card" style="margin-bottom: 20px;">
                <label for="chapeau" style="display: block; font-weight: 600; margin-bottom: 10px;">Extrait (Chapeau)</label>
                <textarea name="chapeau" id="chapeau" rows="3" required 
                          style="width: 100%; border: 1px solid #c3c4c7; padding: 10px; box-sizing: border-box;"><?= old('chapeau', $article['chapeau'] ?? '') ?></textarea>
            </div>

            <div class="wp-card">
                <label for="corps" style="display: block; font-weight: 600; margin-bottom: 10px;">Contenu de l'article</label>
                <textarea name="corps" id="corps" rows="20" required 
                          style="width: 100%; border: 1px solid #c3c4c7; padding: 10px; box-sizing: border-box; font-family: monospace;"><?= old('corps', $article['corps'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- Sidebar Column: Publish settings, Image, SEO -->
        <div class="wp-editor-sidebar">
            <!-- Publish Box -->
            <div class="wp-card sidebar-box">
                <h3 class="box-title">Publier</h3>
                <div class="box-content">
                    <p><strong>État :</strong> <?= isset($article) ? 'Publié' : 'Brouillon' ?></p>
                    <p><strong>Visibilité :</strong> Publique</p>
                    <div class="form-group">
                        <label for="date_publication">Publier le :</label>
                        <input type="datetime-local" name="date_publication" id="date_publication" 
                               value="<?= old('date_publication', isset($article) ? date('Y-m-d\TH:i', strtotime($article['date_publication'])) : date('Y-m-d\TH:i')) ?>"
                               style="width: 100%; margin-top: 5px;">
                    </div>
                </div>
                <div class="box-footer">
                    <?php if (isset($article)): ?>
                        <a href="/articles/delete/<?= $article['id'] ?>" class="submitdelete" onclick="return confirm('Mettre à la corbeille ?')">Déplacer dans la corbeille</a>
                    <?php endif; ?>
                    <button type="submit" class="wp-button wp-button-primary">
                        <?= isset($article) ? 'Mettre à jour' : 'Publier' ?>
                    </button>
                </div>
            </div>

            <!-- SEO Box -->
            <div class="wp-card sidebar-box">
                <h3 class="box-title">Réglages SEO</h3>
                <div class="box-content">
                    <div class="form-group">
                        <label for="meta_title">Titre SEO</label>
                        <input type="text" name="meta_title" id="meta_title" 
                               value="<?= old('meta_title', $article['meta_title'] ?? '') ?>" 
                               style="width: 100%;" placeholder="Titre dans Google">
                    </div>
                </div>
            </div>

            <!-- Image Box -->
            <div class="wp-card sidebar-box">
                <h3 class="box-title">Image mise en avant</h3>
                <div class="box-content">
                    <div class="form-group">
                        <label for="image_principale">URL de l'image</label>
                        <input type="text" name="image_principale" id="image_principale" 
                               value="<?= old('image_principale', $article['image_principale'] ?? '') ?>" 
                               style="width: 100%; margin-bottom: 10px;" placeholder="https://...">
                        
                        <label for="image_alt">Texte alternatif (Alt)</label>
                        <input type="text" name="image_alt" id="image_alt" 
                               value="<?= old('image_alt', $article['image_alt'] ?? '') ?>" 
                               style="width: 100%;" placeholder="Description pour SEO">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .wp-editor-container {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px;
    }

    .wp-title-wrapper {
        margin-bottom: 20px;
    }

    .wp-title-input {
        width: 100%;
        padding: 10px 15px;
        font-size: 1.7rem;
        font-weight: 600;
        border: 1px solid #c3c4c7;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
        box-sizing: border-box;
    }

    .sidebar-box {
        padding: 0;
        margin-bottom: 20px;
    }

    .box-title {
        margin: 0;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        border-bottom: 1px solid #c3c4c7;
        background: #fff;
    }

    .box-content {
        padding: 15px;
        font-size: 13px;
    }

    .box-content p {
        margin: 0 0 10px 0;
    }

    .box-footer {
        padding: 10px 15px;
        background: #f6f7f7;
        border-top: 1px solid #c3c4c7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .submitdelete {
        color: #b32d2e;
        text-decoration: underline;
        font-size: 13px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    input[type="text"], input[type="datetime-local"], textarea {
        border: 1px solid #8c8f94;
        border-radius: 3px;
        padding: 5px;
    }

    @media (max-width: 1100px) {
        .wp-editor-container {
            grid-template-columns: 1fr;
        }
        .wp-editor-sidebar {
            order: 2;
        }
    }
</style>
<?= $this->endSection() ?>
