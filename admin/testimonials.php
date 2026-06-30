<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    if (delete_testimonial($id)) {
        $message = 'Testimonial berhasil dihapus.';
    } else {
        $message = 'Gagal menghapus testimonial.';
    }
}

$testimonials = get_testimonials();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Testimonials - Admin</title>
    <style>body{font-family:Segoe UI,Arial;margin:20px;} .btn{padding:8px 12px;background:#4f46e5;color:#fff;border-radius:4px;text-decoration:none;} table{width:100%;border-collapse:collapse;margin-top:12px;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} .actions{display:flex;gap:8px;}</style>
</head>
<body>
    <h1>Testimonials</h1>
    <?php if ($message): ?>
        <div style="background:#e6ffed;border-left:4px solid #22c55e;padding:10px;margin-bottom:12px;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <a class="btn" href="add-testimonial.php">+ Tambah Testimonial</a>
    <table>
        <thead><tr><th>Author</th><th>Company</th><th>Message</th><th>Rating</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($testimonials as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['author']) ?></td>
                    <td><?= htmlspecialchars($t['company']) ?></td>
                    <td><?= htmlspecialchars($t['message']) ?></td>
                    <td><?= htmlspecialchars($t['rating']) ?></td>
                    <td class="actions">
                        <a href="edit-testimonial.php?id=<?= $t['id'] ?>">Edit</a>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Hapus testimonial ini?');">
                            <input type="hidden" name="delete_id" value="<?= $t['id'] ?>">
                            <button class="btn" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
