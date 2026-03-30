<?php
/**
 * CRUD des types (page unique)
 */
require_once '../config.php';
require_once 'auth_check.php';

$feedback = '';
$feedbackType = 'success';

$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'save') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            $feedback = "Le nom du type est obligatoire.";
            $feedbackType = 'error';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE types SET nom = ? WHERE id = ?");
                    $stmt->execute([$nom, $id]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO types (nom) VALUES (?)");
                    $stmt->execute([$nom]);
                }
                header('Location: types.php?status=saved');
                exit;
            } catch (PDOException $e) {
                $feedback = "Impossible d'enregistrer ce type (nom deja utilise).";
                $feedbackType = 'error';
            }
        }
    }

    if ($action === 'delete') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("DELETE FROM types WHERE id = ?");
                $stmt->execute([$id]);
                header('Location: types.php?status=deleted');
                exit;
            } catch (PDOException $e) {
                $feedback = "Suppression impossible: ce type est utilise par des articles.";
                $feedbackType = 'error';
            }
        }
    }
}

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'saved') {
        $feedback = 'Type enregistre avec succes.';
        $feedbackType = 'success';
    }
    if ($_GET['status'] === 'deleted') {
        $feedback = 'Type supprime avec succes.';
        $feedbackType = 'success';
    }
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editType = ['id' => 0, 'nom' => ''];

if ($editId > 0) {
    $editStmt = $pdo->prepare("SELECT id, nom FROM types WHERE id = ?");
    $editStmt->execute([$editId]);
    $result = $editStmt->fetch();
    if ($result) {
        $editType = $result;
    }
}

$listStmt = $pdo->query("SELECT t.id, t.nom, COUNT(a.id) AS nb_articles FROM types t LEFT JOIN articles a ON a.section_type_id = t.id GROUP BY t.id, t.nom ORDER BY t.id ASC");
$types = $listStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types - Administration</title>
    <style>
        body { font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; background: #f0f0f1; color: #3c434a; margin: 0; display: flex; }
        .wp-sidebar { width: 160px; background: #1d2327; color: #fff; min-height: 100vh; padding-top: 20px; }
        .wp-sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 15px; font-size: 14px; }
        .wp-sidebar a:hover { color: #72aee6; background: #2c3338; }

        .wp-content { flex: 1; padding: 20px 40px; }
        .wrap { max-width: 1100px; margin: 0 auto; }
        h1 { font-size: 23px; font-weight: 400; margin: 0 0 20px; }

        .panel { background: #fff; border: 1px solid #c3c4c7; margin-bottom: 20px; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .panel-head { padding: 10px 12px; border-bottom: 1px solid #c3c4c7; font-size: 14px; font-weight: 600; }
        .panel-body { padding: 12px; }

        .row { display: flex; gap: 10px; align-items: center; }
        .input { width: 100%; border: 1px solid #8c8f94; border-radius: 4px; padding: 8px; box-sizing: border-box; font-size: 14px; }
        .btn { background: #2271b1; border: 1px solid #2271b1; color: #fff; border-radius: 3px; font-weight: 600; padding: 8px 12px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 13px; }
        .btn:hover { background: #135e96; }
        .btn-light { background: #f6f7f7; color: #2271b1; }
        .btn-danger { background: #b32d2e; border-color: #b32d2e; }
        .btn-danger:hover { background: #8a2424; }

        .notice { padding: 10px 12px; border-left: 4px solid #2271b1; margin-bottom: 15px; background: #f0f6fc; }
        .notice.error { border-left-color: #d63638; background: #fbeaea; }

        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #f0f0f1; font-size: 13px; }
        th { border-bottom: 1px solid #c3c4c7; font-size: 14px; }
        .actions { display: flex; gap: 8px; }
    </style>
</head>
<body>

<div class="wp-sidebar">
    <a href="/index.php" style="font-weight: bold; border-bottom: 1px solid #3c434a; margin-bottom: 15px;">Voir le site</a>
    <a href="dashboard.php">Tableau de bord</a>
    <a href="articles.php">Articles</a>
    <a href="form.php">Ajouter</a>
    <a href="types.php" style="background:#2271b1">Types</a>
    <a href="logout.php" style="color: #f08080;">Deconnexion</a>
</div>

<div class="wp-content">
    <div class="wrap">
        <h1>Types de navigation</h1>

        <?php if ($feedback): ?>
            <div class="notice <?= $feedbackType === 'error' ? 'error' : '' ?>"><?= htmlspecialchars($feedback) ?></div>
        <?php endif; ?>

        <div class="panel">
            <div class="panel-head"><?= (int)$editType['id'] > 0 ? 'Modifier le type' : 'Ajouter un type' ?></div>
            <div class="panel-body">
                <form method="post" class="row">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?= (int)$editType['id'] ?>">
                    <input class="input" type="text" name="nom" placeholder="Nom du type (ex: International)" value="<?= htmlspecialchars($editType['nom']) ?>" required>
                    <button class="btn" type="submit"><?= (int)$editType['id'] > 0 ? 'Mettre a jour' : 'Ajouter' ?></button>
                    <?php if ((int)$editType['id'] > 0): ?>
                        <a href="types.php" class="btn btn-light">Annuler</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">Liste des types</div>
            <div class="panel-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:70px;">ID</th>
                            <th>Nom</th>
                            <th style="width:110px;">Articles</th>
                            <th style="width:230px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($types as $type): ?>
                            <tr>
                                <td><?= (int)$type['id'] ?></td>
                                <td><?= htmlspecialchars($type['nom']) ?></td>
                                <td><?= (int)$type['nb_articles'] ?></td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-light" href="types.php?edit=<?= (int)$type['id'] ?>">Modifier</a>
                                        <form method="post" onsubmit="return confirm('Supprimer ce type ?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int)$type['id'] ?>">
                                            <button class="btn btn-danger" type="submit">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
