<?php
/**
 * Page de connexion Admin
 */
require_once '../config.php';
session_start();

// Si déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['admin_auth'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Dans un vrai projet, on vérifie en BDD avec password_verify()
    // Ici, pour simplifier la transition, on met un accès par défaut
    if ($user === 'admin' && $pass === 'admin123') {
        $_SESSION['admin_auth'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Source Sans 3', sans-serif; background: #f0f0f1; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 30px; border: 1px solid #c3c4c7; box-shadow: 0 1px 3px rgba(0,0,0,.1); width: 320px; }
        h1 { font-size: 1.2rem; text-align: center; margin-bottom: 25px; }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600; }
        input { width: 100%; padding: 8px; border: 1px solid #8c8f94; box-sizing: border-box; border-radius: 4px; }
        .btn { width: 100%; padding: 10px; background: #2271b1; color: #fff; border: none; cursor: pointer; border-radius: 4px; font-weight: 600; font-size: 14px; }
        .error { color: #d63638; background: #fbeaea; padding: 10px; border-left: 4px solid #d63638; margin-bottom: 15px; font-size: 13px; }
    </style>
</head>
<body>

<div class="login-box">
    <h1>Administration</h1>
    
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="input-group">
            <label>Identifiant</label>
            <input type="text" name="username" value="admin" required>
        </div>
        <div class="input-group">
            <label>Mot de passe</label>
            <input type="password" name="password" value="admin123" required>
        </div>
        <button type="submit" class="btn">Se connecter</button>
    </form>
</div>

</body>
</html>
