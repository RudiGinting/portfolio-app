<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$id = intval($_GET['id'] ?? 0);
$cert = get_certification_by_id($id);
if (!$cert) {
    header('Location: certifications.php');
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'] ?? '',
        'issuer' => $_POST['issuer'] ?? '',
        'issue_date' => $_POST['issue_date'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];

    if (update_certification($id, $data)) {
        $message = 'Certification berhasil diperbarui!';
        $cert = get_certification_by_id($id);
    } else {
        $message = 'Gagal memperbarui certification entry.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certification - Admin Portfolio</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; color: #333; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .navbar-menu { display: flex; gap: 18px; flex-wrap: wrap; }
        .navbar-menu a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; }
        .navbar-menu a:hover { background: rgba(255,255,255,0.18); }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .section { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section h2 { margin-bottom: 20px; color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #28a745; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; transition: background 0.3s; }
        .btn:hover { background: #764ba2; }
        .btn-back { background: #999; }
        .btn-back:hover { background: #666; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📜 Resume Admin</h1>
        <div class="navbar-menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profil</a>
            <a href="education.php">Education</a>
            <a href="experience.php">Experience</a>
            <a href="organizations.php">Organizations</a>
            <a href="certifications.php">Certifications</a>
            <a href="projects.php">Projects</a>
            <a href="skills.php">Skills</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="container">
        <div class="section">
            <h2>✏️ Edit Certification</h2>
            <?php if ($message): ?>
                <div class="success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($cert['title']) ?>" required>
                </div>
                <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label for="issuer">Issuer</label>
                        <input type="text" id="issuer" name="issuer" value="<?= htmlspecialchars($cert['issuer']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="issue_date">Issue Date</label>
                        <input type="text" id="issue_date" name="issue_date" value="<?= htmlspecialchars($cert['issue_date']) ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?= htmlspecialchars($cert['description']) ?></textarea>
                </div>
                <button type="submit" class="btn">Update Certification</button>
                <a href="certifications.php" class="btn btn-back">← Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>
