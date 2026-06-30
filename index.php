<?php
include 'config/functions.php';

$profile = get_profile();
$projects = get_projects();
$skills = get_skills();

// Group skills by category
$grouped_skills = [];
foreach ($skills as $skill) {
    $cat = $skill['category'] ?? 'Lainnya';
    if (!isset($grouped_skills[$cat])) {
        $grouped_skills[$cat] = [];
    }
    $grouped_skills[$cat][] = $skill;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['name'] ?? 'My Portfolio') ?> - Portfolio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.6;
        }
        
        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        nav .logo {
            font-size: 20px;
            font-weight: bold;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        nav a:hover {
            opacity: 0.8;
        }
        
        /* Main content */
        main {
            margin-top: 60px;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 30px;
            text-align: center;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 15px;
            animation: fadeInDown 1s ease;
        }
        
        .hero .title {
            font-size: 24px;
            margin-bottom: 20px;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.2s both;
        }
        
        .hero p {
            max-width: 600px;
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.4s both;
        }
        
        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            animation: fadeInUp 1s ease 0.6s both;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid white;
            cursor: pointer;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Sections */
        section {
            padding: 80px 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        section h2 {
            font-size: 36px;
            margin-bottom: 50px;
            text-align: center;
            color: #333;
            position: relative;
        }
        
        section h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: #667eea;
            margin: 15px auto 0;
        }
        
        /* About Section */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .about-content h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #667eea;
        }
        
        .about-content p {
            margin-bottom: 15px;
            line-height: 1.8;
            color: #666;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-block;
            width: 45px;
            height: 45px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
        }
        
        .social-links a:hover {
            background: #764ba2;
            transform: translateY(-5px);
        }
        
        .contact-info {
            background: #f5f7fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .contact-info p {
            margin: 10px 0;
        }
        
        /* Skills Section */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .skill-category {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .skill-category:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .skill-category h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .skill-tag {
            background: white;
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .skill-tag:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        /* Projects Section */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .project-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .project-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
        }
        
        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .project-content {
            padding: 25px;
        }
        
        .project-content h3 {
            margin-bottom: 10px;
            color: #333;
        }
        
        .project-content p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .project-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }
        
        .tech-tag {
            background: #f0f0f0;
            color: #667eea;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .project-links {
            display: flex;
            gap: 10px;
        }
        
        .project-links a {
            flex: 1;
            padding: 10px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background 0.3s;
            font-size: 14px;
        }
        
        .project-links a:hover {
            background: #764ba2;
        }
        
        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
        }
        
        .contact-section h2 {
            color: white;
        }
        
        .contact-section h2::after {
            background: white;
        }
        
        .contact-section p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }
        
        .contact-method {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        
        .contact-method h3 {
            margin-bottom: 15px;
        }
        
        .contact-method a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .contact-method a:hover {
            opacity: 0.8;
        }
        
        /* Footer */
        footer {
            background: #1a1a1a;
            color: white;
            text-align: center;
            padding: 30px;
        }
        
        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            nav ul {
                gap: 15px;
            }
            
            .hero h1 {
                font-size: 32px;
            }
            
            .hero .title {
                font-size: 18px;
            }
            
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .cta-buttons {
                flex-direction: column;
            }
            
            section h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">💼 Portfolio</div>
        <ul>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="resume.php">Resume</a></li>
            <li><a href="#contact">Kontak</a></li>
            <li><a href="admin/login.php" style="background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 5px;">Admin</a></li>
        </ul>
    </nav>
    
    <main>
        <!-- Hero Section -->
        <div class="hero">
            <h1><?= htmlspecialchars($profile['name'] ?? 'Hai Dunia!') ?></h1>
            <div class="title"><?= htmlspecialchars($profile['title'] ?? 'Web Developer') ?></div>
            <p><?= htmlspecialchars($profile['bio'] ?? '') ?></p>
            <div class="cta-buttons">
                <a href="#projects" class="btn btn-primary">Lihat Portfolio Saya</a>
                <a href="#contact" class="btn btn-secondary">Hubungi Saya</a>
            </div>
        </div>
        
        <!-- About Section -->
        <section id="about" class="about">
            <h2>👋 Tentang Saya</h2>
            <div class="about-content">
                <div>
                    <h3><?= htmlspecialchars($profile['name'] ?? '') ?></h3>
                    <p><?= htmlspecialchars($profile['bio'] ?? '') ?></p>
                    <div class="social-links">
                        <?php if ($profile['github_url']): ?>
                            <a href="<?= htmlspecialchars($profile['github_url']) ?>" target="_blank" title="GitHub">🐙</a>
                        <?php endif; ?>
                        <?php if ($profile['linkedin_url']): ?>
                            <a href="<?= htmlspecialchars($profile['linkedin_url']) ?>" target="_blank" title="LinkedIn">💼</a>
                        <?php endif; ?>
                        <?php if ($profile['twitter_url']): ?>
                            <a href="<?= htmlspecialchars($profile['twitter_url']) ?>" target="_blank" title="Twitter">𝕏</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <div class="contact-info">
                        <h3>Informasi Kontak</h3>
                        <?php if ($profile['email']): ?>
                            <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
                        <?php endif; ?>
                        <?php if ($profile['phone']): ?>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone']) ?></p>
                        <?php endif; ?>
                        <?php if ($profile['location']): ?>
                            <p><strong>Lokasi:</strong> <?= htmlspecialchars($profile['location']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Skills Section -->
        <section id="skills" class="skills">
            <h2>🛠️ Skills & Expertise</h2>
            <div class="skills-grid">
                <?php foreach ($grouped_skills as $category => $cat_skills): ?>
                    <div class="skill-category">
                        <h3><?= htmlspecialchars($category) ?></h3>
                        <div class="skill-list">
                            <?php foreach ($cat_skills as $skill): ?>
                                <span class="skill-tag"><?= htmlspecialchars($skill['skill_name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- Projects Section -->
        <section id="projects" class="projects">
            <h2>🚀 Portfolio Projects</h2>
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <div class="project-image">
                            <?php if ($project['image_url']): ?>
                                <img src="<?= htmlspecialchars($project['image_url']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
                            <?php else: ?>
                                📱
                            <?php endif; ?>
                        </div>
                        <div class="project-content">
                            <h3><?= htmlspecialchars($project['title']) ?></h3>
                            <p><?= htmlspecialchars(substr($project['description'], 0, 150)) ?>...</p>
                            <div class="project-tech">
                                <?php 
                                $techs = explode(',', $project['technologies']);
                                foreach (array_slice($techs, 0, 3) as $tech): 
                                ?>
                                    <span class="tech-tag"><?= htmlspecialchars(trim($tech)) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="project-links">
                                <?php if ($project['demo_link']): ?>
                                    <a href="<?= htmlspecialchars($project['demo_link']) ?>" target="_blank">🔗 Demo</a>
                                <?php endif; ?>
                                <?php if ($project['github_link']): ?>
                                    <a href="<?= htmlspecialchars($project['github_link']) ?>" target="_blank">💻 Code</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact" class="contact-section">
            <h2>📧 Mari Terhubung</h2>
            <p>Saya terbuka untuk peluang baru dan kolaborasi yang menarik!</p>
            <div class="contact-methods">
                <?php if ($profile['email']): ?>
                    <div class="contact-method">
                        <h3>📧 Email</h3>
                        <a href="mailto:<?= htmlspecialchars($profile['email']) ?>"><?= htmlspecialchars($profile['email']) ?></a>
                    </div>
                <?php endif; ?>
                <?php if ($profile['phone']): ?>
                    <div class="contact-method">
                        <h3>📱 Telepon</h3>
                        <a href="tel:<?= htmlspecialchars($profile['phone']) ?>"><?= htmlspecialchars($profile['phone']) ?></a>
                    </div>
                <?php endif; ?>
                <?php if ($profile['location']): ?>
                    <div class="contact-method">
                        <h3>📍 Lokasi</h3>
                        <p><?= htmlspecialchars($profile['location']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($profile['name'] ?? 'Portfolio') ?>. Semua hak cipta dilindungi.</p>
        <p style="font-size: 12px; margin-top: 10px; opacity: 0.7;">Dibuat dengan ❤️ menggunakan PHP & MySQL</p>
    </footer>
</body>
</html>
