<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'La Gazette - Votre source d\'actualités internationales, politiques et économiques.') ?>">
    <title><?= (isset($title) ? $title . ' | ' : '') . SITE_NAME ?></title>
    
    <!-- Typographies Playfair & Source Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #000;
            --secondary-color: #666;
            --bg-color: #fff;
            --border-color: #e5e5e5;
            --font-serif: "Playfair Display", serif;
            --font-sans: "Source Sans 3", sans-serif;
        }

        body {
            margin: 0; padding: 0;
            background-color: var(--bg-color);
            color: var(--primary-color);
            font-family: var(--font-sans);
            line-height: 1.6;
        }

        header {
            border-bottom: 2px solid var(--primary-color);
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-family: var(--font-serif);
            font-size: 2.5rem;
            text-align: center;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .logo a { text-decoration: none; color: var(--primary-color); }

        nav {
            text-align: center;
            margin-top: 15px;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 700;
            font-size: .9rem;
            text-transform: uppercase;
        }

        main { min-height: 70vh; }

        footer {
            background-color: #f9f9f9;
            border-top: 1px solid var(--border-color);
            padding: 40px 0;
            margin-top: 50px;
            color: var(--secondary-color);
            font-size: .85rem;
        }

        .footer-content { display: flex; justify-content: space-between; }

        /* Styles spécifiques aux cartes d'articles */
        .article-list { margin-top: 10px; }
        .list-card {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 22px 0;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
        }
        .list-card:last-child { border-bottom: none; }
        .list-card-body { flex: 1; min-width: 0; }
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
        }
        .card-title {
            font-family: var(--font-serif);
            font-size: 1.25rem;
            font-weight: 800;
            line-height: 1.25;
            margin: 0 0 8px;
        }
        .card-title:hover { text-decoration: underline; }
        .card-extract {
            font-family: var(--font-serif);
            font-size: 1.05rem;
            color: #333;
            line-height: 1.5;
            margin: 0 0 8px;
            font-style: italic;
        }
        .card-date { font-size: 0.75rem; color: var(--secondary-color); font-weight: 600; }
        .card-img-link img {
            width: 420px;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 768px) {
            .list-card { flex-direction: column-reverse; }
            .card-img-link img { width: 100%; height: 200px; }
        }
    </style>
</head>
<body>

<?php
$navTypes = [];
try {
    $navStmt = $pdo->query("SELECT nom FROM types ORDER BY id ASC");
    $navTypes = $navStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Throwable $e) {
    $navTypes = ['International', 'Politique', 'Société', 'Économie'];
}
?>

<header>
    <div class="container">
        <div class="logo"><a href="/index.php"><?= SITE_NAME ?></a></div>
        <nav>
            <a href="/index.php">Accueil</a>
            <?php foreach ($navTypes as $typeNom): ?>
                <a href="/index.php?section=<?= urlencode($typeNom) ?>"><?= htmlspecialchars($typeNom) ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>

<main class="container">
