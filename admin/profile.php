<?php
include '../config/functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$profile = get_profile();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_data = [
        'name' => $_POST['name'] ?? '',
        'title' => $_POST['title'] ?? '',
        'bio' => $_POST['bio'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'location' => $_POST['location'] ?? '',
        'github_url' => $_POST['github_url'] ?? '',
        'linkedin_url' => $_POST['linkedin_url'] ?? '',
        'twitter_url' => $_POST['twitter_url'] ?? ''
    ];
    
    if (update_profile($update_data)) {
        $message = 'Profil berhasil diperbarui!';
        $profile = get_profile();
    } else {
        $message = 'Gagal memperbarui profil.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Admin Portfolio</title>
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
            min-height: 120px;
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
            <h2>✏️ Edit Profil</h2>
            
            <?php if ($message): ?>
                <div class="success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="name">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($profile['name'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="title">Posisi/Title *</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($profile['title'] ?? '') ?>" placeholder="Contoh: Web Developer, Designer, etc">
                </div>
                
                <div class="form-group">
                    <label for="bio">Bio/Deskripsi</label>
                    <textarea id="bio" name="bio" placeholder="Ceritakan tentang diri Anda..."><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" id="location" name="location" value="<?= htmlspecialchars($profile['location'] ?? '') ?>" placeholder="Contoh: Jakarta, Indonesia">
                </div>

        <div class="form-group">
            <label for="profile_image">URL Foto Profil</label>
            <input type="url" id="profile_image" name="profile_image" value="<?= htmlspecialchars($profile['profile_image'] ?? '') ?>" placeholder="https://example.com/profile.jpg">
        </div>
                
                <div class="form-group">
                    <label for="github_url">GitHub URL</label>
                    <input type="url" id="github_url" name="github_url" value="<?= htmlspecialchars($profile['github_url'] ?? '') ?>" placeholder="https://github.com/username">
                </div>
                
                <div class="form-group">
                    <label for="linkedin_url">LinkedIn URL</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" value="<?= htmlspecialchars($profile['linkedin_url'] ?? '') ?>" placeholder="https://linkedin.com/in/username">
                </div>
                
                <div class="form-group">
                    <label for="twitter_url">Twitter URL</label>
                    <input type="url" id="twitter_url" name="twitter_url" value="<?= htmlspecialchars($profile['twitter_url'] ?? '') ?>" placeholder="https://twitter.com/username">
                </div>
                
                <div>
                    <button type="submit" class="btn">💾 Simpan Profil</button>
                    <a href="dashboard.php" class="btn btn-back">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
