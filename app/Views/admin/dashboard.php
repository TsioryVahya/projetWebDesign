<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Dashboard - Journaliste</h1>
        <div class="actions">
            <a href="/articles/create" class="btn btn-primary">Publier un nouvel article</a>
            <a href="/logout" class="btn btn-secondary">Déconnexion</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Slug</th>
                <th>Date Pub.</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= esc($article['id']) ?></td>
                    <td><?= esc($article['titre']) ?></td>
                    <td><code><?= esc($article['slug']) ?></code></td>
                    <td><?= date('d/m/Y H:i', strtotime($article['date_publication'])) ?></td>
                    <td>
                        <a href="/articles/edit/<?= $article['id'] ?>" class="btn-sm btn-edit">Modifier</a>
                        <a href="/articles/delete/<?= $article['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    .admin-dashboard { padding: 20px 0; }
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    
    .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .admin-table th, .admin-table td { border: 1px solid var(--border-color); padding: 12px; text-align: left; }
    .admin-table th { background: #f4f4f4; font-family: var(--font-serif); }
    .admin-table tr:hover { background: #f9f9f9; }

    .btn { padding: 10px 20px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; display: inline-block; }
    .btn-primary { background: #000; color: #fff; }
    .btn-secondary { background: #666; color: #fff; margin-left: 10px; }
    
    .btn-sm { padding: 5px 10px; text-decoration: none; font-size: 0.8rem; border-radius: 3px; }
    .btn-edit { background: #28a745; color: #fff; }
    .btn-delete { background: #dc3545; color: #fff; margin-left: 5px; }
    
    .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin-bottom: 20px; }
</style>
<?= $this->endSection() ?>
