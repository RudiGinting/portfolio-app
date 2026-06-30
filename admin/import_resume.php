<?php
// Script to import resume data into profile and articles
require_once __DIR__ . '/../config/functions.php';

// Profile data from user
$profile = [
    'name' => 'Rudi Alva Jonathan Ginting',
    'title' => 'Fullstack Developer / Informatics Student',
    'bio' => "I am an Informatics student at Del Institute of Technology with a strong interest in software development, particularly in Backend, Frontend, Full Stack Development, Quality Assurance, and Android Development. I am highly motivated to learn and have hands-on experience in web and application development. Actively involved in organizational activities, I continuously strive to improve my skills and contribute to innovative technology projects.",
    'email' => 'rudialvajonathanginting@gmail.com',
    'phone' => '+62 895-3511-95782',
    'location' => 'South Jakarta, Indonesia',
    'github_url' => 'https://github.com/RudiGinting',
    'linkedin_url' => 'https://www.linkedin.com/in/rudi-alva-jonathan-ginting-1551563b3/',
    'twitter_url' => ''
];

if (update_profile($profile)) {
    echo "Profile updated successfully\n";
} else {
    echo "Failed to update profile: " . ($conn->error ?? 'unknown') . "\n";
}

function ensure_unique_row($sql, $insertCallback) {
    global $conn;
    $check = $conn->query($sql);
    if ($check && $check->num_rows > 0) {
        return false;
    }
    return $insertCallback();
}

function ensure_skill($data) {
    $skill = $data['skill_name'] ?? '';
    $category = $data['category'] ?? '';
    $safeSkill = $GLOBALS['conn']->real_escape_string($skill);
    $safeCategory = $GLOBALS['conn']->real_escape_string($category);
    return ensure_unique_row("SELECT id FROM skills WHERE skill_name='$safeSkill' AND category='$safeCategory' LIMIT 1", function() use ($data) {
        return add_skill($data['skill_name'], $data['category'], $data['level']);
    });
}

function ensure_education($data) {
    $institution = $GLOBALS['conn']->real_escape_string($data['institution'] ?? '');
    $degree = $GLOBALS['conn']->real_escape_string($data['degree'] ?? '');
    $start_date = $GLOBALS['conn']->real_escape_string($data['start_date'] ?? '');
    return ensure_unique_row("SELECT id FROM education WHERE institution='$institution' AND degree='$degree' AND start_date='$start_date' LIMIT 1", function() use ($data) {
        return add_education($data);
    });
}

function ensure_experience($data) {
    $role = $GLOBALS['conn']->real_escape_string($data['role'] ?? '');
    $company = $GLOBALS['conn']->real_escape_string($data['company'] ?? '');
    $start_date = $GLOBALS['conn']->real_escape_string($data['start_date'] ?? '');
    return ensure_unique_row("SELECT id FROM experience WHERE role='$role' AND company='$company' AND start_date='$start_date' LIMIT 1", function() use ($data) {
        return add_experience($data);
    });
}

function ensure_organization($data) {
    $role = $GLOBALS['conn']->real_escape_string($data['role'] ?? '');
    $organization = $GLOBALS['conn']->real_escape_string($data['organization'] ?? '');
    $start_date = $GLOBALS['conn']->real_escape_string($data['start_date'] ?? '');
    return ensure_unique_row("SELECT id FROM organizations WHERE role='$role' AND organization='$organization' AND start_date='$start_date' LIMIT 1", function() use ($data) {
        return add_organization($data);
    });
}

function ensure_certification($data) {
    $title = $GLOBALS['conn']->real_escape_string($data['title'] ?? '');
    $issuer = $GLOBALS['conn']->real_escape_string($data['issuer'] ?? '');
    return ensure_unique_row("SELECT id FROM certifications WHERE title='$title' AND issuer='$issuer' LIMIT 1", function() use ($data) {
        return add_certification($data);
    });
}

function ensure_article($data) {
    global $conn;
    $slug = $conn->real_escape_string($data['slug']);
    return ensure_unique_row("SELECT id FROM articles WHERE slug='$slug' LIMIT 1", function() use ($data) {
        return add_article($data);
    });
}

function ensure_testimonial($data) {
    $author = $GLOBALS['conn']->real_escape_string($data['author'] ?? '');
    $company = $GLOBALS['conn']->real_escape_string($data['company'] ?? '');
    $message = $GLOBALS['conn']->real_escape_string($data['message'] ?? '');
    return ensure_unique_row("SELECT id FROM testimonials WHERE author='$author' AND company='$company' AND message='$message' LIMIT 1", function() use ($data) {
        return add_testimonial($data);
    });
}

function ensure_project($data) {
    $title = $GLOBALS['conn']->real_escape_string($data['title'] ?? '');
    $slug = $GLOBALS['conn']->real_escape_string($data['slug'] ?? '');
    return ensure_unique_row("SELECT id FROM projects WHERE title='$title' LIMIT 1", function() use ($data) {
        return add_project($data);
    });
}

$now = date('Y-m-d H:i:s');

$skills = [
    ['skill_name' => 'Full-Stack Web Development', 'category' => 'Web', 'level' => 'Advanced'],
    ['skill_name' => 'Frontend Development', 'category' => 'Web', 'level' => 'Advanced'],
    ['skill_name' => 'Backend Development', 'category' => 'Web', 'level' => 'Advanced'],
    ['skill_name' => 'PHP', 'category' => 'Backend', 'level' => 'Advanced'],
    ['skill_name' => 'Laravel', 'category' => 'Backend', 'level' => 'Intermediate'],
    ['skill_name' => 'Golang', 'category' => 'Backend', 'level' => 'Intermediate'],
    ['skill_name' => 'Node.js', 'category' => 'Backend', 'level' => 'Intermediate'],
    ['skill_name' => 'React.js', 'category' => 'Frontend', 'level' => 'Intermediate'],
    ['skill_name' => 'JavaScript', 'category' => 'Frontend', 'level' => 'Advanced'],
    ['skill_name' => 'HTML/CSS', 'category' => 'Frontend', 'level' => 'Advanced'],
    ['skill_name' => 'MySQL', 'category' => 'Database', 'level' => 'Intermediate'],
    ['skill_name' => 'PostgreSQL', 'category' => 'Database', 'level' => 'Intermediate'],
    ['skill_name' => 'RESTful API', 'category' => 'API', 'level' => 'Intermediate'],
    ['skill_name' => 'Git', 'category' => 'Tools', 'level' => 'Advanced'],
    ['skill_name' => 'Android Development', 'category' => 'Mobile', 'level' => 'Intermediate'],
    ['skill_name' => 'Quality Assurance', 'category' => 'Process', 'level' => 'Intermediate'],
    ['skill_name' => 'Problem Solving', 'category' => 'Soft Skill', 'level' => 'Advanced'],
    ['skill_name' => 'Communication', 'category' => 'Soft Skill', 'level' => 'Advanced'],
    ['skill_name' => 'Teamwork', 'category' => 'Soft Skill', 'level' => 'Advanced'],
    ['skill_name' => 'Leadership', 'category' => 'Soft Skill', 'level' => 'Intermediate']
];

foreach ($skills as $skill) {
    if (ensure_skill($skill)) {
        echo "Inserted skill: " . $skill['skill_name'] . "\n";
    }
}

$educations = [
    [
        'institution' => 'Del Institute of Technology',
        'degree' => 'Bachelor of Informatics',
        'major' => 'Informatics',
        'gpa' => '3.55 / 4.00',
        'start_date' => 'September 2023',
        'end_date' => 'Present',
        'description' => 'Focused on fullstack development, software engineering, and quality assurance while actively participating in student organizations.'
    ]
];

foreach ($educations as $education) {
    if (ensure_education($education)) {
        echo "Inserted education: " . $education['institution'] . "\n";
    }
}

$experiences = [
    [
        'role' => 'Fullstack Developer Intern',
        'company' => 'PT Pratesis',
        'location' => 'Jakarta, Indonesia',
        'start_date' => 'July 2025',
        'end_date' => 'September 2025',
        'details' => "Developed and enhanced the Pronto Xi ERP application, fixed client issues, built advanced filtering functionality, and improved system performance and usability."
    ],
    [
        'role' => 'Web Developer',
        'company' => 'SMK Negeri 3 Balige Project',
        'location' => 'Balige, Indonesia',
        'start_date' => 'March 2025',
        'end_date' => 'May 2025',
        'details' => "Built a School Information System using fullstack web technologies and collaborated with stakeholders to define requirements and deploy the solution."
    ]
];

foreach ($experiences as $experience) {
    if (ensure_experience($experience)) {
        echo "Inserted experience: " . $experience['role'] . " at " . $experience['company'] . "\n";
    }
}

$projects = [
    [
        'title' => 'School Information System – SMK Negeri 3 Balige',
        'description' => "Developed School Information System including student data, portfolio, graduation certificate (SKL) and RESTful APIs.",
        'image_url' => '',
        'github_link' => 'https://github.com/FIRMAN1975/smk-3-balige-app',
        'demo_link' => '',
        'technologies' => 'PHP, Laravel, MySQL, JavaScript'
    ],
    [
        'title' => 'Internship Management System (Android)',
        'description' => "Full-stack internship management system and companion Android app using modern Android stack.",
        'image_url' => '',
        'github_link' => 'https://github.com/RudiGinting/pam-2026-ifs23004-proyek1-fe',
        'demo_link' => '',
        'technologies' => 'Ktor, PostgreSQL, JWT, Android (Jetpack Compose)'
    ],
    [
        'title' => 'Website LPPM IT Del',
        'description' => "Book Award Submission Platform using Laravel and PostgreSQL to automate workflows between faculty and administration.",
        'image_url' => '',
        'github_link' => 'https://github.com/RudiGinting/Project-LPPM',
        'demo_link' => '',
        'technologies' => 'Laravel, PHP, PostgreSQL, JavaScript'
    ],
    [
        'title' => 'QUICLIB (Java GUI)',
        'description' => "Desktop library management application for organizing and tracking personal book collections.",
        'image_url' => '',
        'github_link' => '',
        'demo_link' => '',
        'technologies' => 'Java, Swing, MySQL'
    ]
];

foreach ($projects as $p) {
    if (ensure_project($p)) {
        echo "Inserted project: " . $p['title'] . "\n";
    }
}

$organizations = [
    [
        'role' => 'Head of Public Relations Division',
        'organization' => 'Informatics Student Association',
        'start_date' => 'January 2025',
        'end_date' => 'Present',
        'description' => 'Led communication strategies, managed event outreach, and coordinated internal and external campaigns.'
    ],
    [
        'role' => 'Member',
        'organization' => 'Informatics Student Association',
        'start_date' => 'September 2023',
        'end_date' => 'Present',
        'description' => 'Participated in technology workshops and contributed to academic and community-building initiatives.'
    ]
];

foreach ($organizations as $organization) {
    if (ensure_organization($organization)) {
        echo "Inserted organization: " . $organization['organization'] . "\n";
    }
}

$certifications = [
    ['title' => 'AWS Cloud and Gen AI Fundamentals', 'issuer' => 'AWS', 'issue_date' => '2025', 'description' => 'Fundamentals of cloud computing and generative AI on AWS.'],
    ['title' => 'Programming Logic 101', 'issuer' => 'Online Training', 'issue_date' => '2024', 'description' => 'Core programming concepts and algorithmic thinking.'],
    ['title' => 'JavaScript Programming Fundamentals', 'issuer' => 'Online Training', 'issue_date' => '2024', 'description' => 'Web development and JavaScript language fundamentals.'],
    ['title' => 'SQL for Beginners', 'issuer' => 'Online Training', 'issue_date' => '2024', 'description' => 'Basic database querying with SQL.'],
    ['title' => 'Android UI Development', 'issuer' => 'Online Training', 'issue_date' => '2023', 'description' => 'Designing and implementing Android application interfaces.'],
    ['title' => 'Java Programming', 'issuer' => 'Online Training', 'issue_date' => '2023', 'description' => 'Java programming and object-oriented software development.'],
    ['title' => 'Data Science Basics', 'issuer' => 'Online Training', 'issue_date' => '2024', 'description' => 'Introductory data science and analysis techniques.']
];

foreach ($certifications as $certification) {
    if (ensure_certification($certification)) {
        echo "Inserted certification: " . $certification['title'] . "\n";
    }
}

$testimonials = [
    [
        'author' => 'Supervisor at PT Pratesis',
        'company' => 'PT Pratesis',
        'message' => 'Rudi demonstrated strong technical skills and delivered clean, maintainable code while collaborating effectively with the team.',
        'rating' => 5
    ],
    [
        'author' => 'Lecturer at Del Institute of Technology',
        'company' => 'IT Del',
        'message' => 'Rudi consistently brings enthusiasm and discipline to projects, delivering reliable solutions and supporting peers.',
        'rating' => 5
    ]
];

foreach ($testimonials as $testimonial) {
    if (ensure_testimonial($testimonial)) {
        echo "Inserted testimonial: " . $testimonial['author'] . "\n";
    }
}

$articles = [
    [
        'title' => 'Professional Summary',
        'slug' => 'professional-summary',
        'excerpt' => 'Informatics student with hands-on experience in web and application development.',
        'content' => "I am an Informatics student at Del Institute of Technology with a strong interest in software development, particularly in Backend, Frontend, Full Stack Development, Quality Assurance, and Android Development. I am highly motivated to learn and have hands-on experience in web and application development. Actively involved in organizational activities, I continuously strive to improve my skills and contribute to innovative technology projects.",
        'author' => 'Rudi Alva Jonathan Ginting',
        'published_at' => $now
    ],
    [
        'title' => 'Education at Del Institute of Technology',
        'slug' => 'education-del-institute',
        'excerpt' => 'Bachelor of Informatics, GPA 3.55 / 4.00',
        'content' => "Del Institute of Technology\nBachelor of Informatics\nGPA: 3.55 / 4.00",
        'author' => 'Rudi Alva Jonathan Ginting',
        'published_at' => $now
    ],
    [
        'title' => 'Internship Experience at PT Pratesis',
        'slug' => 'internship-experience',
        'excerpt' => 'Fullstack Developer at PT Pratesis and other internships',
        'content' => "PT Pratesis - Fullstack Developer\n- Support development and enhancement of Pronto Xi ERP\n- Investigate and resolve client-reported issues\n- Improve data accessibility and user efficiency by developing advanced filtering functionalities and contributing to stability and performance.",
        'author' => 'Rudi Alva Jonathan Ginting',
        'published_at' => $now
    ],
    [
        'title' => 'Project Highlights',
        'slug' => 'project-experience-highlights',
        'excerpt' => 'School Information System, Internship Management System, Website LPPM IT Del.',
        'content' => "- School Information System – SMK Negeri 3 Balige (Fullstack Developer)\n- Internship Management System (Android)\n- Website LPPM IT Del\n- QUICLIB Java GUI and others.\nSee repositories: https://github.com/FIRMAN1975/smk-3-balige-app, https://github.com/RudiGinting/pam-2026-ifs23004-proyek1-fe, https://github.com/RudiGinting/Project-LPPM",
        'author' => 'Rudi Alva Jonathan Ginting',
        'published_at' => $now
    ],
    [
        'title' => 'Organizational Experience & Skills',
        'slug' => 'organizational-experience-skills',
        'excerpt' => 'Active in Informatics Student Association; certifications and essential skills.',
        'content' => "Organizational roles: Head of Public Relations Division, Member of Informatics Student Association.\n\nCertifications: AWS Cloud and Gen AI Fundamentals, Programming Logic 101, JavaScript Programming Fundamentals, SQL for Beginners, Android UI Development, Java Programming, Data Science Basics.\n\nSkills: Full-Stack Web Development, Backend Development, Frontend Development, RESTful API, React.js, Node.js, Laravel, Golang, PostgreSQL, MySQL.\nSoft skills: Problem Solving, Communication, Teamwork, Leadership, Time Management.",
        'author' => 'Rudi Alva Jonathan Ginting',
        'published_at' => $now
    ]
];

foreach ($articles as $a) {
    if (ensure_article($a)) {
        echo "Inserted article: " . $a['title'] . "\n";
    } else {
        if ($conn->error) echo "Article insert error: " . $conn->error . "\n";
    }
}

echo "Import finished.\n";
