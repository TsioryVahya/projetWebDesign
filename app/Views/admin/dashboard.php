<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="wp-header-actions" style="margin-bottom: 20px;">
    <a href="/articles/create" class="wp-button wp-button-primary" style="margin-right: 10px;">Ajouter nouveau</a>
</div>

<div class="wp-card" style="padding: 0; overflow: hidden;">
    <table class="wp-table">
        <thead>
            <tr>
                <th class="column-title">Titre</th>
                <th class="column-author">Auteur</th>
                <th class="column-date">Date</th>
                <th class="column-actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td class="column-title">
                        <strong><a href="/articles/edit/<?= $article['id'] ?>"><?= esc($article['titre']) ?></a></strong>
                        <div class="row-actions">
                            <span class="edit"><a href="/articles/edit/<?= $article['id'] ?>">Modifier</a> | </span>
                            <span class="trash"><a href="/articles/delete/<?= $article['id'] ?>" class="submitdelete" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">Corbeille</a> | </span>
                            <span class="view"><a href="/actualite/<?= date('Y/m/d/', strtotime($article['date_publication'])) . $article['slug'] . '_' . $article['id'] . '.html' ?>" target="_blank">Afficher</a></span>
                        </div>
                    </td>
                    <td class="column-author">Admin</td>
                    <td class="column-date">
                        Publié<br>
                        <?= date('d/m/Y', strtotime($article['date_publication'])) ?> à <?= date('H:i', strtotime($article['date_publication'])) ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                             <a href="/articles/edit/<?= $article['id'] ?>" class="wp-button">Éditer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    .wp-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .wp-table th {
        text-align: left;
        padding: 10px 15px;
        font-weight: 600;
        font-size: 14px;
        border-bottom: 1px solid #c3c4c7;
        background: #f6f7f7;
    }

    .wp-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f1;
        font-size: 13px;
        vertical-align: top;
    }

    .wp-table tr:hover {
        background: #f6f7f7;
    }

    .column-title strong a {
        color: #2271b1;
        text-decoration: none;
        font-size: 14px;
    }

    .row-actions {
        visibility: hidden;
        font-size: 12px;
        margin-top: 5px;
    }

    .wp-table tr:hover .row-actions {
        visibility: visible;
    }

    .row-actions a {
        text-decoration: none;
        color: #2271b1;
    }

    .row-actions .submitdelete {
        color: #b32d2e;
    }

    .column-date {
        color: #50575e;
    }

    .column-author {
        color: #2271b1;
    }
</style>
<?= $this->endSection() ?>
