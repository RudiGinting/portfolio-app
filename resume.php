<?php
include 'config/functions.php';

$profile = get_profile();
$education = get_education();
$experience = get_experience();
$organizations = get_organizations();
$certifications = get_certifications();
$skills = get_skills();
$testimonials = get_testimonials();
$articles = get_articles();

$grouped_skills = [];
foreach ($skills as $skill) {
    $category = $skill['category'] ?: 'Lainnya';
    if (!isset($grouped_skills[$category])) {
        $grouped_skills[$category] = [];
    }
    $grouped_skills[$category][] = $skill;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['name'] ?? 'Resume') ?> - Resume</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7fb; color: #2a2a2a; line-height: 1.6; }
        a { color: #4f46e5; text-decoration: none; }
        a:hover { text-decoration: underline; }
        header { background: #312e81; color: white; padding: 40px 20px; text-align: center; }
        header .container { max-width: 1100px; margin: 0 auto; }
        header h1 { font-size: 3rem; margin-bottom: 10px; }
        header p { max-width: 800px; margin: 0 auto; opacity: .86; }
        .page-nav { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; margin-top: 24px; }
        .page-nav a { background: rgba(255,255,255,.12); padding: 10px 18px; border-radius: 999px; border: 1px solid rgba(255,255,255,.18); }
        .main { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }
        .section { margin-bottom: 40px; }
        .section h2 { font-size: 2rem; margin-bottom: 20px; color: #111827; position: relative; }
        .section h2::after { content: ''; display: block; width: 60px; height: 4px; background: #4f46e5; margin-top: 12px; }
        .hero-grid { display: grid; grid-template-columns: 1fr 320px; gap: 30px; align-items: start; }
        .hero-card { background: white; border-radius: 20px; padding: 28px; box-shadow: 0 20px 60px rgba(15,23,42,.08); }
        .hero-card figure { width: 100%; height: 320px; background: #eef2ff; display: flex; align-items: center; justify-content: center; border-radius: 18px; overflow: hidden; }
        .hero-card figure img { width: 100%; height: 100%; object-fit: cover; }
        .hero-card .contact-list { margin-top: 24px; display: grid; gap: 12px; }
        .hero-card .contact-list div { display: flex; justify-content: space-between; padding: 14px 18px; border-radius: 15px; background: #f8fafc; }
        .hero-summary { display: grid; gap: 16px; }
        .hero-summary p { max-width: 100%; }
        .tag-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .tag { background: #eef2ff; color: #312e81; padding: 9px 14px; border-radius: 999px; font-size: 14px; }
        .row-grid { display: grid; gap: 30px; }
        .card { background: white; border-radius: 18px; padding: 28px; box-shadow: 0 20px 60px rgba(15,23,42,.06); }
        .card table { width: 100%; border-collapse: collapse; }
        .card table td { vertical-align: top; padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .card table td:first-child { width: 170px; font-weight: 700; color: #4b5563; }
        .skill-blocks { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .skill-block { background: #eef2ff; border-radius: 18px; padding: 22px; }
        .skill-block h3 { margin-bottom: 14px; color: #312e81; }
        .skill-item { margin-bottom: 10px; }
        .skill-item strong { display: block; font-weight: 700; margin-bottom: 4px; }
        .skill-item span { display: inline-block; background: white; padding: 6px 10px; border-radius: 999px; border: 1px solid #c7d2fe; font-size: 13px; color: #1f2937; }
        .timeline { display: grid; gap: 20px; }
        .timeline-item { padding: 20px; border-radius: 20px; background: #ffffff; border: 1px solid #e5e7eb; }
        .timeline-item h3 { margin-bottom: 10px; font-size: 1.2rem; }
        .timeline-item .small { font-size: .95rem; color: #6b7280; margin-bottom: 12px; }
        .timeline-item p { color: #374151; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .profile-links { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 12px; }
        .profile-links a { background: #eef2ff; color: #1d4ed8; padding: 10px 16px; border-radius: 999px; font-size: 14px; }
        .footer-note { text-align: center; padding: 30px 0; color: #6b7280; }
        @media (max-width: 900px) {
            .hero-grid, .two-col { grid-template-columns: 1fr; }
            .hero-card { padding: 24px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><?= htmlspecialchars($profile['name'] ?? 'Resume') ?></h1>
            <p><?= htmlspecialchars($profile['title'] ?? 'A professional resume summary is available here.') ?></p>
            <div class="page-nav">
                <a href="#about">About</a>
                <a href="#education">Education</a>
                <a href="#experience">Experience</a>
                <a href="#organizations">Organizations</a>
                <a href="#certifications">Certifications</a>
                <a href="#skills">Skills</a>
                <a href="#testimonials">Testimonials</a>
                <a href="#articles">Articles</a>
            </div>
        </div>
    </header>

    <main class="main">
        <section id="about" class="section">
            <div class="hero-grid">
                <div class="hero-summary card">
                    <h2>About</h2>
                    <p><?= nl2br(htmlspecialchars($profile['bio'] ?? '')) ?></p>
                    <div class="profile-links">
                        <?php if (!empty($profile['email'])): ?><a href="mailto:<?= htmlspecialchars($profile['email']) ?>">Email</a><?php endif; ?>
                        <?php if (!empty($profile['phone'])): ?><a href="tel:<?= htmlspecialchars($profile['phone']) ?>">Phone</a><?php endif; ?>
                        <?php if (!empty($profile['github_url'])): ?><a href="<?= htmlspecialchars($profile['github_url']) ?>" target="_blank">GitHub</a><?php endif; ?>
                        <?php if (!empty($profile['linkedin_url'])): ?><a href="<?= htmlspecialchars($profile['linkedin_url']) ?>" target="_blank">LinkedIn</a><?php endif; ?>
                    </div>
                </div>
                <div class="hero-card">
                    <?php if (!empty($profile['profile_image'])): ?>
                        <figure><img src="<?= htmlspecialchars($profile['profile_image']) ?>" alt="<?= htmlspecialchars($profile['name'] ?? 'Profile Image') ?>"></figure>
                    <?php else: ?>
                        <figure><span style="font-size: 5rem; color: #4f46e5;">👤</span></figure>
                    <?php endif; ?>
                    <div class="contact-list">
                        <?php if (!empty($profile['email'])): ?><div><strong>Email</strong><span><?= htmlspecialchars($profile['email']) ?></span></div><?php endif; ?>
                        <?php if (!empty($profile['phone'])): ?><div><strong>Phone</strong><span><?= htmlspecialchars($profile['phone']) ?></span></div><?php endif; ?>
                        <?php if (!empty($profile['location'])): ?><div><strong>Location</strong><span><?= htmlspecialchars($profile['location']) ?></span></div><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="education" class="section">
            <h2>Education</h2>
            <div class="timeline">
                <?php if ($education): ?>
                    <?php foreach ($education as $item): ?>
                        <div class="timeline-item">
                            <h3><?= htmlspecialchars($item['degree'] ?: $item['institution']) ?></h3>
                            <div class="small"><?= htmlspecialchars($item['institution']) ?> · <?= htmlspecialchars($item['start_date']) ?> - <?= htmlspecialchars($item['end_date']) ?></div>
                            <?php if ($item['major']): ?><p><strong>Major:</strong> <?= htmlspecialchars($item['major']) ?></p><?php endif; ?>
                            <?php if ($item['gpa']): ?><p><strong>GPA / Score:</strong> <?= htmlspecialchars($item['gpa']) ?></p><?php endif; ?>
                            <?php if ($item['description']): ?><p><?= nl2br(htmlspecialchars($item['description'])) ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="timeline-item"><p>No education entries available yet.</p></div>
                <?php endif; ?>
            </div>
        </section>

        <section id="experience" class="section">
            <h2>Experience</h2>
            <div class="timeline">
                <?php if ($experience): ?>
                    <?php foreach ($experience as $item): ?>
                        <div class="timeline-item">
                            <h3><?= htmlspecialchars($item['role']) ?></h3>
                            <div class="small"><?= htmlspecialchars($item['company']) ?> · <?= htmlspecialchars($item['start_date']) ?> - <?= htmlspecialchars($item['end_date']) ?></div>
                            <?php if ($item['location']): ?><p><strong>Location:</strong> <?= htmlspecialchars($item['location']) ?></p><?php endif; ?>
                            <?php if ($item['details']): ?><p><?= nl2br(htmlspecialchars($item['details'])) ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="timeline-item"><p>No experience entries available yet.</p></div>
                <?php endif; ?>
            </div>
        </section>

        <section id="organizations" class="section">
            <h2>Organizations</h2>
            <div class="timeline">
                <?php if ($organizations): ?>
                    <?php foreach ($organizations as $item): ?>
                        <div class="timeline-item">
                            <h3><?= htmlspecialchars($item['role']) ?></h3>
                            <div class="small"><?= htmlspecialchars($item['organization']) ?> · <?= htmlspecialchars($item['start_date']) ?> - <?= htmlspecialchars($item['end_date']) ?></div>
                            <?php if ($item['description']): ?><p><?= nl2br(htmlspecialchars($item['description'])) ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="timeline-item"><p>No organization entries available yet.</p></div>
                <?php endif; ?>
            </div>
        </section>

        <section id="certifications" class="section">
            <h2>Certifications</h2>
            <div class="timeline">
                <?php if ($certifications): ?>
                    <?php foreach ($certifications as $item): ?>
                        <div class="timeline-item">
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <div class="small"><?= htmlspecialchars($item['issuer']) ?> · <?= htmlspecialchars($item['issue_date']) ?></div>
                            <?php if ($item['description']): ?><p><?= nl2br(htmlspecialchars($item['description'])) ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="timeline-item"><p>No certifications available yet.</p></div>
                <?php endif; ?>
            </div>
        </section>

        <section id="skills" class="section">
            <h2>Skills</h2>
            <div class="skill-blocks">
                <?php foreach ($grouped_skills as $category => $items): ?>
                    <div class="skill-block">
                        <h3><?= htmlspecialchars($category) ?></h3>
                        <?php foreach ($items as $item): ?>
                            <div class="skill-item">
                                <strong><?= htmlspecialchars($item['skill_name']) ?></strong>
                                <span><?= htmlspecialchars($item['level']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="testimonials" class="section">
            <h2>Testimonials</h2>
            <div class="timeline">
                <?php if ($testimonials): ?>
                    <?php foreach ($testimonials as $item): ?>
                        <div class="timeline-item">
                            <p><?= nl2br(htmlspecialchars($item['message'])) ?></p>
                            <div class="small">— <?= htmlspecialchars($item['author']) ?>, <?= htmlspecialchars($item['company']) ?> <?= $item['rating'] ? '· Rating: ' . intval($item['rating']) : '' ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="timeline-item"><p>No testimonials available yet.</p></div>
                <?php endif; ?>
            </div>
        </section>

        <section id="articles" class="section">
            <h2>Articles & Notes</h2>
            <div class="row-grid">
                <?php if ($articles): ?>
                    <?php foreach ($articles as $item): ?>
                        <div class="card">
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <div class="small"><?= htmlspecialchars($item['author'] ?? 'Unknown') ?> · <?= htmlspecialchars($item['published_at'] ? date('d M Y', strtotime($item['published_at'])) : '') ?></div>
                            <p><?= nl2br(htmlspecialchars($item['excerpt'] ?: substr($item['content'], 0, 180))) ?></p>
                            <?php if ($item['content']): ?><p><?= nl2br(htmlspecialchars(substr($item['content'], 0, 260))) ?>...</p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card"><p>No articles available yet.</p></div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer-note">
        &copy; <?= date('Y') ?> <?= htmlspecialchars($profile['name'] ?? 'Portfolio') ?>. Resume generated from stored portfolio data.
    </footer>
</body>
</html>
