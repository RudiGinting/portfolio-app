<?php
include '../config/functions.php';

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$profile = get_profile();
$projects = get_projects();
$skills = get_skills();
$total_projects = count($projects);
$total_skills = count($skills);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Portfolio</title>
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
            align-items: center;
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
        
        .navbar-menu a.logout {
            background: rgba(255, 0, 0, 0.3);
        }
        
        .navbar-menu a.logout:hover {
            background: rgba(255, 0, 0, 0.5);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        
        .card h3 {
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        
        .card .stat {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .card a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }
        
        .card a:hover {
            text-decoration: underline;
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
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #764ba2;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .profile-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .profile-info p {
            margin-bottom: 10px;
        }
        
        .profile-info strong {
            color: #667eea;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        table th {
            background: #f5f7fa;
            padding: 12px;
            text-align: left;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        
        .btn-edit {
            background: #3498db;
            color: white;
        }
        
        .btn-edit:hover {
            background: #2980b9;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c0392b;
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
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="dashboard-grid">
            <div class="card">
                <h3>Total Projects</h3>
                <div class="stat"><?= $total_projects ?></div>
                <a href="projects.php">Kelola Projects →</a>
            </div>
            
            <div class="card">
                <h3>Total Skills</h3>
                <div class="stat"><?= $total_skills ?></div>
                <a href="skills.php">Kelola Skills →</a>
            </div>
            
            <div class="card">
                <h3>Profile Name</h3>
                <div class="stat" style="font-size: 18px;"><?= htmlspecialchars($profile['name'] ?? 'N/A') ?></div>
                <a href="profile.php">Edit Profil →</a>
            </div>
            
            <div class="card">
                <h3>Views</h3>
                <div class="stat">Publik</div>
                <a href="../index.php" target="_blank">Lihat Website →</a>
            </div>
        </div>
        
        <div class="section">
            <h2>📝 Profil Singkat</h2>
            <div class="profile-info">
                <div>
                    <p><strong>Nama:</strong> <?= htmlspecialchars($profile['name'] ?? '') ?></p>
                    <p><strong>Posisi:</strong> <?= htmlspecialchars($profile['title'] ?? '') ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($profile['email'] ?? '') ?></p>
                </div>
                <div>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone'] ?? '') ?></p>
                    <p><strong>Lokasi:</strong> <?= htmlspecialchars($profile['location'] ?? '') ?></p>
                    <a href="profile.php" class="btn btn-small">Edit Profil</a>
                </div>
            </div>
            <p><strong>Bio:</strong> <?= htmlspecialchars($profile['bio'] ?? '') ?></p>
        </div>
        
        <div class="section">
            <h2>🚀 Project Terbaru</h2>
            <?php if ($projects): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Teknologi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($projects, 0, 5) as $project): ?>
                            <tr>
                                <td><?= htmlspecialchars($project['title']) ?></td>
                                <td><?= htmlspecialchars(substr($project['description'], 0, 50)) ?>...</td>
                                <td><?= htmlspecialchars($project['technologies']) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="edit-project.php?id=<?= $project['id'] ?>" class="btn-edit">Edit</a>
                                        <a href="delete-project.php?id=<?= $project['id'] ?>" class="btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
                <a href="projects.php" class="btn">Kelola Semua Projects</a>
            <?php else: ?>
                <p>Belum ada project. <a href="add-project.php">Tambah project pertama Anda</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
