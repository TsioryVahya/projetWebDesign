<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($meta_description ?? 'Toute l\'actualité en direct.') ?>">
    <title><?= esc($title ?? 'Actualités') ?> | <?= esc($site_name ?? 'La gazette') ?></title>
    
    <!-- Typographie Serif (Inspiration Le Monde) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    </noscript>
    
    <style>
        :root{--primary-color:#000;--secondary-color:#666;--bg-color:#fff;--border-color:#e5e5e5;--font-serif:"Playfair Display",serif;--font-sans:"Source Sans 3",sans-serif}
        body{margin:0;padding:0;background-color:var(--bg-color);color:var(--primary-color);font-family:var(--font-sans);line-height:1.6}
        header{border-bottom:2px solid var(--primary-color);padding:20px 0;margin-bottom:30px}
        .container{max-width:1200px;margin:0 auto;padding:0 20px}
        .logo{font-family:var(--font-serif);font-size:2.5rem;text-align:center;font-weight:900;text-transform:uppercase;letter-spacing:-1px}
        .logo a{text-decoration:none;color:var(--primary-color)}
        nav{text-align:center;margin-top:15px;border-top:1px solid var(--border-color);padding-top:10px}
        nav a{margin:0 15px;text-decoration:none;color:var(--primary-color);font-weight:700;font-size:.9rem;text-transform:uppercase}
        main{min-height:70vh}
        footer{background-color:#f9f9f9;border-top:1px solid var(--border-color);padding:40px 0;margin-top:50px;color:var(--secondary-color);font-size:.85rem}
        .footer-content{display:flex;justify-content:space-between}
        h1,h2,h3,h4,h5,h6{font-family:var(--font-serif);font-weight:800;margin-top:0}
        img{max-width:100%;height:auto;display:block}
        @media (max-width:768px){.logo{font-size:1.8rem}nav a{margin:0 5px;font-size:.8rem}}
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="logo">
            <a href="/"><?= esc($site_name) ?></a>
        </div>
        <nav>
            <a href="/">Accueil</a>
            <a href="/section/international">International</a>
            <a href="/section/politique">Politique</a>
            <a href="/section/societe">Société</a>
            <a href="/section/economie">Économie</a>
        </nav>
    </div>
</header>

<main class="container">
    <?= $this->renderSection('content') ?>
</main>

<footer>
    <div class="container">
        <div class="footer-content">
            <div>
                &copy; <?= date('Y') ?> <?= esc($site_name) ?>. Tous droits réservés.
            </div>
            <div>
                <a href="/mentions-legales" style="color: inherit; text-decoration: none; margin-left: 20px;">Mentions légales</a>
                <a href="/contact" style="color: inherit; text-decoration: none; margin-left: 20px;">Contact</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
