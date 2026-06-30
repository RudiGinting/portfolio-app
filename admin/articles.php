<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    if (delete_article($id)) {
        $message = 'Article berhasil dihapus.';
    } else {
        $message = 'Gagal menghapus article.';
    }
}

$articles = get_articles();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Articles - Admin</title>
    <style>body{font-family:Segoe UI,Arial;margin:20px;} .btn{padding:8px 12px;background:#4f46e5;color:#fff;border-radius:4px;text-decoration:none;} table{width:100%;border-collapse:collapse;margin-top:12px;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} .actions{display:flex;gap:8px;}</style>
</head>
<body>
    <h1>Articles</h1>
    <?php if ($message): ?>
        <div style="background:#e6ffed;border-left:4px solid #22c55e;padding:10px;margin-bottom:12px;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <a class="btn" href="add-article.php">+ Tambah Article</a>
    <table>
        <thead><tr><th>Title</th><th>Slug</th><th>Author</th><th>Published At</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($articles as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['title']) ?></td>
                    <td><?= htmlspecialchars($a['slug']) ?></td>
                    <td><?= htmlspecialchars($a['author']) ?></td>
                    <td><?= htmlspecialchars($a['published_at']) ?></td>
                    <td class="actions">
                        <a href="edit-article.php?id=<?= $a['id'] ?>">Edit</a>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Hapus article ini?');">
                            <input type="hidden" name="delete_id" value="<?= $a['id'] ?>">
                            <button class="btn" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
