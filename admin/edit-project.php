<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$project_id = $_GET['id'] ?? 0;
$project = get_project($project_id);

if (!$project) {
    header('Location: projects.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'image_url' => $_POST['image_url'] ?? '',
        'github_link' => $_POST['github_link'] ?? '',
        'demo_link' => $_POST['demo_link'] ?? '',
        'technologies' => $_POST['technologies'] ?? ''
    ];
    
    if (update_project($project_id, $project_data)) {
        $message = 'Project berhasil diperbarui!';
        $project = get_project($project_id);
    } else {
        $message = 'Gagal memperbarui project.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - Admin Portfolio</title>
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
            max-width: 700px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #764ba2;
        }
        
        .btn-back {
            background: #999;
            text-decoration: none;
            margin-left: 10px;
        }
        
        .btn-back:hover {
            background: #666;
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
        <div class="section">
            <h2>✏️ Edit Project</h2>
            
            <?php if ($message): ?>
                <div class="success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="title">Judul Project *</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi *</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($project['description']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="technologies">Teknologi/Stack *</label>
                    <input type="text" id="technologies" name="technologies" value="<?= htmlspecialchars($project['technologies']) ?>" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="image_url">URL Gambar</label>
                        <input type="url" id="image_url" name="image_url" value="<?= htmlspecialchars($project['image_url']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="demo_link">Demo Link</label>
                        <input type="url" id="demo_link" name="demo_link" value="<?= htmlspecialchars($project['demo_link']) ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="github_link">GitHub Link</label>
                    <input type="url" id="github_link" name="github_link" value="<?= htmlspecialchars($project['github_link']) ?>">
                </div>
                
                <div>
                    <button type="submit" class="btn">💾 Update Project</button>
                    <a href="projects.php" class="btn btn-back">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
