<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'author' => $_POST['author'] ?? '',
        'company' => $_POST['company'] ?? '',
        'message' => $_POST['message'] ?? '',
        'rating' => $_POST['rating'] ?? 5
    ];

    if (add_testimonial($data)) {
        $message = 'Testimonial berhasil ditambahkan.';
    } else {
        $message = 'Gagal menambahkan testimonial.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Tambah Testimonial - Admin</title>
    <style>body{font-family:Segoe UI,Arial;margin:20px;} .btn{padding:8px 12px;background:#4f46e5;color:#fff;border-radius:4px;text-decoration:none;} label{display:block;margin-top:8px;} textarea{width:100%;height:120px;}</style>
</head>
<body>
    <h1>Tambah Testimonial</h1>
    <?php if ($message): ?>
        <div style="background:#e6ffed;border-left:4px solid #22c55e;padding:10px;margin-bottom:12px;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Author<input type="text" name="author" required></label>
        <label>Company<input type="text" name="company"></label>
        <label>Message<textarea name="message" required></textarea></label>
        <label>Rating<input type="number" name="rating" min="1" max="5" value="5"></label>
        <div style="margin-top:10px;"><button class="btn" type="submit">Simpan</button> <a class="btn" href="testimonials.php">Kembali</a></div>
    </form>
</body>
</html>
