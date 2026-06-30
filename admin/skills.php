<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$skills = get_skills();
$message = '';

// Handle skill deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (delete_skill($_GET['delete'])) {
        $message = 'Skill berhasil dihapus!';
        $skills = get_skills();
    }
}

// Handle skill addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_skill'])) {
    $skill_name = $_POST['skill_name'] ?? '';
    $category = $_POST['category'] ?? '';
    $level = $_POST['level'] ?? '';
    
    if ($skill_name && $category && $level) {
        if (add_skill($skill_name, $category, $level)) {
            $message = 'Skill berhasil ditambahkan!';
            $skills = get_skills();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Skills - Admin Portfolio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-menu {
            display: flex;
            gap: 20px;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .navbar-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .section h2 {
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 15px;
            align-items: flex-end;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #764ba2;
        }
        
        .btn-small {
            padding: 8px 15px;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th {
            background: #f5f7fa;
            padding: 12px;
            text-align: left;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
            font-size: 14px;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
        }
        
        .btn-delete:hover {
            background: #c0392b;
        }
        
        .btn-back {
            background: #999;
            text-decoration: none;
            margin-top: 20px;
        }
        
        .btn-back:hover {
            background: #666;
        }
        
        .skill-tag {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 5px;
        }
        
        .skill-level {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📊 Portfolio Admin</h1>
        <div class="navbar-menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profil</a>
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
            <h2>➕ Tambah Skill Baru</h2>
            
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="skill_name">Nama Skill</label>
                        <input type="text" id="skill_name" name="skill_name" placeholder="Contoh: PHP, React, Docker" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Backend">Backend</option>
                            <option value="Frontend">Frontend</option>
                            <option value="Database">Database</option>
                            <option value="DevOps">DevOps</option>
                            <option value="Tools">Tools</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select id="level" name="level" required>
                            <option value="">Pilih Level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="add_skill" class="btn btn-small">+ Tambah</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="section">
            <h2>📚 Daftar Skills</h2>
            
            <?php if ($skills): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Skill</th>
                            <th>Kategori</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grouped_skills = [];
                        foreach ($skills as $skill) {
                            $cat = $skill['category'] ?? 'Lainnya';
                            if (!isset($grouped_skills[$cat])) {
                                $grouped_skills[$cat] = [];
                            }
                            $grouped_skills[$cat][] = $skill;
                        }
                        
                        foreach ($grouped_skills as $category => $cat_skills): ?>
                            <tr style="background: #f0f0f0;">
                                <td colspan="4"><strong><?= htmlspecialchars($category) ?></strong></td>
                            </tr>
                            <?php foreach ($cat_skills as $skill): ?>
                                <tr>
                                    <td><?= htmlspecialchars($skill['skill_name']) ?></td>
                                    <td><?= htmlspecialchars($skill['category']) ?></td>
                                    <td><span class="skill-level"><?= htmlspecialchars($skill['level']) ?></span></td>
                                    <td>
                                        <a href="skills.php?delete=<?= $skill['id'] ?>" class="btn-delete" onclick="return confirm('Yakin hapus skill ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #999; padding: 30px 0;">Belum ada skill yang ditambahkan.</p>
            <?php endif; ?>
            
            <a href="dashboard.php" class="btn btn-back">← Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
