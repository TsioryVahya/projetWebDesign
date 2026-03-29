<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="login-container">
    <h1>Connexion BackOffice</h1>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="username">Utilisateur</label>
            <input type="text" name="username" id="username" value="admin" 	required placeholder="admin">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" value="admin123" required placeholder="admin123">
        </div>
        <button type="submit">Se connecter</button>
    </form>
</div>

<style>
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        border: 1px solid var(--border-color);
        background: #f9f9f9;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; box-sizing: border-box; }
    button { width: 100%; padding: 12px; background: #000; color: #fff; border: none; cursor: pointer; font-weight: bold; }
    button:hover { background: #333; }
    .alert-danger { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 20px; }
</style>
<?= $this->endSection() ?>
