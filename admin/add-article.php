<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'] ?? '',
        'slug' => $_POST['slug'] ?? '',
        'excerpt' => $_POST['excerpt'] ?? '',
        'content' => $_POST['content'] ?? '',
        'author' => $_POST['author'] ?? '',
        'published_at' => $_POST['published_at'] ?? null
    ];

    if (add_article($data)) {
        $message = 'Article berhasil ditambahkan.';
    } else {
        $message = 'Gagal menambahkan article.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Tambah Article - Admin</title>
    <style>body{font-family:Segoe UI,Arial;margin:20px;} .btn{padding:8px 12px;background:#4f46e5;color:#fff;border-radius:4px;text-decoration:none;} label{display:block;margin-top:8px;} textarea{width:100%;height:160px;}</style>
</head>
<body>
    <h1>Tambah Article</h1>
    <?php if ($message): ?>
        <div style="background:#e6ffed;border-left:4px solid #22c55e;padding:10px;margin-bottom:12px;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Title<input type="text" name="title" required></label>
        <label>Slug<input type="text" name="slug" required></label>
        <label>Excerpt<textarea name="excerpt"></textarea></label>
        <label>Content<textarea name="content"></textarea></label>
        <label>Author<input type="text" name="author"></label>
        <label>Published At<input type="datetime-local" name="published_at"></label>
        <div style="margin-top:10px;"><button class="btn" type="submit">Simpan</button> <a class="btn" href="articles.php">Kembali</a></div>
    </form>
</body>
</html>
