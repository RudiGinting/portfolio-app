<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$educations = get_education();
$message = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (delete_education($_GET['delete'])) {
        $message = 'Education entry berhasil dihapus!';
        $educations = get_education();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_education'])) {
    $data = [
        'institution' => $_POST['institution'] ?? '',
        'degree' => $_POST['degree'] ?? '',
        'major' => $_POST['major'] ?? '',
        'gpa' => $_POST['gpa'] ?? '',
        'start_date' => $_POST['start_date'] ?? '',
        'end_date' => $_POST['end_date'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];

    if (add_education($data)) {
        $message = 'Education berhasil ditambahkan!';
        $educations = get_education();
        $_POST = [];
    } else {
        $message = 'Gagal menambahkan education entry.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Education - Admin Portfolio</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; color: #333; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .navbar-menu { display: flex; gap: 18px; flex-wrap: wrap; }
        .navbar-menu a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; }
        .navbar-menu a:hover { background: rgba(255,255,255,0.18); }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .section { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .section h2 { margin-bottom: 20px; color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #28a745; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; transition: background 0.3s; }
        .btn:hover { background: #764ba2; }
        .btn-delete { background: #e74c3c; }
        .btn-delete:hover { background: #c0392b; }
        .btn-back { background: #999; }
        .btn-back:hover { background: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { padding: 14px; border-bottom: 1px solid #eee; text-align: left; vertical-align: top; }
        table th { background: #f5f7fa; color: #666; font-weight: 600; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .empty { text-align: center; color: #999; padding: 30px 0; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📚 Resume Admin</h1>
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
        <?php if ($message): ?>
            <div class="success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="section">
            <h2>➕ Tambah Education</h2>
            <form method="POST">
                <input type="hidden" name="add_education" value="1">
                <div class="form-group">
                    <label for="institution">Institution *</label>
                    <input type="text" id="institution" name="institution" value="<?= htmlspecialchars($_POST['institution'] ?? '') ?>" required>
                </div>
                <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label for="degree">Degree</label>
                        <input type="text" id="degree" name="degree" value="<?= htmlspecialchars($_POST['degree'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="major">Major</label>
                        <input type="text" id="major" name="major" value="<?= htmlspecialchars($_POST['major'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="text" id="start_date" name="start_date" value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>" placeholder="e.g. September 2023">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="text" id="end_date" name="end_date" value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>" placeholder="e.g. Present">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gpa">GPA / Score</label>
                    <input type="text" id="gpa" name="gpa" value="<?= htmlspecialchars($_POST['gpa'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn">Simpan Education</button>
            </form>
        </div>

        <div class="section">
            <h2>📘 Education List</h2>
            <?php if ($educations): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Institution</th>
                            <th>Degree / Major</th>
                            <th>Period</th>
                            <th>Description</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($educations as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['institution']) ?></td>
                                <td><?= htmlspecialchars($item['degree']) ?> / <?= htmlspecialchars($item['major']) ?></td>
                                <td><?= htmlspecialchars($item['start_date']) ?> - <?= htmlspecialchars($item['end_date']) ?></td>
                                <td><?= nl2br(htmlspecialchars($item['description'])) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="edit-education.php?id=<?= $item['id'] ?>" class="btn">Edit</a>
                                        <a href="education.php?delete=<?= $item['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin menghapus entry ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty">Belum ada education entry.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
