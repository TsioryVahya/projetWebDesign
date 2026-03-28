<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | Administration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --wp-bg: #f0f0f1;
            --wp-sidebar: #1d2327;
            --wp-sidebar-active: #2271b1;
            --wp-sidebar-hover: #2c3338;
            --wp-text: #3c434a;
            --wp-border: #c3c4c7;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            background: var(--wp-bg);
            color: var(--wp-text);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .wp-sidebar {
            width: 160px;
            background: var(--wp-sidebar);
            color: #fff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .wp-sidebar-header {
            padding: 15px;
            background: #000;
            text-align: center;
        }

        .wp-sidebar-header a {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .wp-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .wp-menu-item a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background 0.1s;
        }

        .wp-menu-item a:hover {
            background: var(--wp-sidebar-hover);
            color: #72aee6;
        }

        .wp-menu-item.active a {
            background: var(--wp-sidebar-active);
            color: #fff;
        }

        .wp-menu-item svg {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            fill: currentColor;
            opacity: 0.7;
        }

        /* Main Content Area */
        .wp-main {
            flex: 1;
            margin-left: 160px;
            padding: 20px 40px;
        }

        .wp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .wp-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        /* WordPress Style Buttons */
        .wp-button {
            display: inline-block;
            text-decoration: none;
            padding: 6px 12px;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            cursor: pointer;
            border: 1px solid #2271b1;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            background: #f6f7f7;
            color: #2271b1;
        }

        .wp-button-primary {
            background: #2271b1;
            color: #fff;
        }

        .wp-button-primary:hover {
            background: #135e96;
            border-color: #135e96;
            color: #fff;
        }

        /* WP Card / Content Box */
        .wp-card {
            background: #fff;
            border: 1px solid var(--wp-border);
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            padding: 20px;
        }

        @media (max-width: 782px) {
            .wp-sidebar { width: 36px; }
            .wp-sidebar span { display: none; }
            .wp-main { margin-left: 36px; padding: 15px; }
        }
    </style>
</head>
<body>

<div class="wp-sidebar">
    <div class="wp-sidebar-header">
        <a href="/">Le Journal</a>
    </div>
    <ul class="wp-menu">
        <li class="wp-menu-item <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>">
            <a href="/admin/dashboard">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                <span>Tableau de bord</span>
            </a>
        </li>
        <li class="wp-menu-item <?= strpos(current_url(), 'articles') !== false ? 'active' : '' ?>">
            <a href="/admin/dashboard">
                <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                <span>Articles</span>
            </a>
        </li>
        <li class="wp-menu-item">
            <a href="/logout">
                <svg viewBox="0 0 24 24"><path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                <span>Se déconnecter</span>
            </a>
        </li>
    </ul>
</div>

<div class="wp-main">
    <div class="wp-header">
        <h1><?= esc($title) ?></h1>
        <?php if (isset($header_action)): ?>
            <?= $header_action ?>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="background: #fff; border-left: 4px solid #00a32a; padding: 12px; margin: 20px 0; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="background: #fff; border-left: 4px solid #d63638; padding: 12px; margin: 20px 0; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

</body>
</html>
