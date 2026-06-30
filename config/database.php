<?php
// Database configuration (use environment variables when available)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'portfolio_db';

// Create connection (connect to server first)
$conn = new mysqli($db_host, $db_user, $db_pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure database is selected / created (if permitted)
if ($db_name) {
    if (!$conn->select_db($db_name)) {
        // If running on local server, try to create the database
        if ($db_host === 'localhost' || $db_host === '127.0.0.1') {
            $sql_create_db = "CREATE DATABASE IF NOT EXISTS `" . $db_name . "`";
            if ($conn->query($sql_create_db) === TRUE) {
                $conn->select_db($db_name);
                create_tables($conn);
            } else {
                echo "Error creating database: " . $conn->error;
            }
        } else {
            // Remote DB: assume database exists and skip creation. Attempt to select again and create tables if allowed.
            // Try selecting once more; if still fails, leave it to remote DB admin to create DB.
            if ($conn->select_db($db_name)) {
                create_tables($conn);
            } else {
                // Could not select remote database; operations requiring DB will fail until configured.
                error_log("Warning: unable to select database $db_name on host $db_host");
            }
        }
    } else {
        // DB selected successfully - ensure tables exist
        create_tables($conn);
    }
}

function create_tables($conn) {
    // Users table
    $sql_users = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_users);
    
    // Profile table
    $sql_profile = "CREATE TABLE IF NOT EXISTS profile (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        title VARCHAR(100),
        bio TEXT,
        email VARCHAR(100),
        phone VARCHAR(20),
        location VARCHAR(100),
        github_url VARCHAR(255),
        linkedin_url VARCHAR(255),
        twitter_url VARCHAR(255),
        profile_image VARCHAR(255),
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->query($sql_profile);
    
    // Skills table
    $sql_skills = "CREATE TABLE IF NOT EXISTS skills (
        id INT PRIMARY KEY AUTO_INCREMENT,
        skill_name VARCHAR(100) NOT NULL,
        category VARCHAR(50),
        level VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_skills);
    
    // Projects table
    $sql_projects = "CREATE TABLE IF NOT EXISTS projects (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(150) NOT NULL,
        description TEXT NOT NULL,
        image_url VARCHAR(255),
        github_link VARCHAR(255),
        demo_link VARCHAR(255),
        technologies VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->query($sql_projects);

    // Education table
    $sql_education = "CREATE TABLE IF NOT EXISTS education (
        id INT PRIMARY KEY AUTO_INCREMENT,
        institution VARCHAR(255) NOT NULL,
        degree VARCHAR(255),
        major VARCHAR(255),
        gpa VARCHAR(50),
        start_date VARCHAR(50),
        end_date VARCHAR(50),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_education);

    // Experience table
    $sql_experience = "CREATE TABLE IF NOT EXISTS experience (
        id INT PRIMARY KEY AUTO_INCREMENT,
        role VARCHAR(255) NOT NULL,
        company VARCHAR(255) NOT NULL,
        location VARCHAR(255),
        start_date VARCHAR(50),
        end_date VARCHAR(50),
        details TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_experience);

    // Organizations table
    $sql_organizations = "CREATE TABLE IF NOT EXISTS organizations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        role VARCHAR(255) NOT NULL,
        organization VARCHAR(255) NOT NULL,
        start_date VARCHAR(50),
        end_date VARCHAR(50),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_organizations);

    // Certifications table
    $sql_certifications = "CREATE TABLE IF NOT EXISTS certifications (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        issuer VARCHAR(255),
        issue_date VARCHAR(50),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_certifications);

    // Testimonials table
    $sql_testimonials = "CREATE TABLE IF NOT EXISTS testimonials (
        id INT PRIMARY KEY AUTO_INCREMENT,
        author VARCHAR(150) NOT NULL,
        company VARCHAR(150),
        message TEXT NOT NULL,
        rating TINYINT DEFAULT 5,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_testimonials);

    // Articles table
    $sql_articles = "CREATE TABLE IF NOT EXISTS articles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE,
        excerpt TEXT,
        content LONGTEXT,
        author VARCHAR(150),
        published_at DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->query($sql_articles);

    // Newsletter subscribers
    $sql_newsletter = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        name VARCHAR(150),
        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_newsletter);

    // Site statistics table
    $sql_site_stats = "CREATE TABLE IF NOT EXISTS site_stats (
        id INT PRIMARY KEY AUTO_INCREMENT,
        page VARCHAR(150) NOT NULL,
        views BIGINT DEFAULT 0,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->query($sql_site_stats);
    
    // Insert default admin user if not exists
    $check_user = "SELECT * FROM users WHERE username='admin'";
    $result = $conn->query($check_user);
    
    if ($result->num_rows == 0) {
        $hashed_pass = password_hash('admin123', PASSWORD_BCRYPT);
        $sql_insert = "INSERT INTO users (username, password, email) VALUES ('admin', '$hashed_pass', 'admin@portfolio.com')";
        $conn->query($sql_insert);
    }
    
    // Insert default profile if not exists
    $check_profile = "SELECT * FROM profile LIMIT 1";
    $result = $conn->query($check_profile);
    
    if ($result->num_rows == 0) {
        $sql_insert_profile = "INSERT INTO profile (name, title, bio, email, phone, location) VALUES 
            ('Your Name', 'Web Developer', 'Passionate about creating beautiful and functional websites', 'your.email@example.com', '+62-XXX-XXXX-XXXX', 'Indonesia')";
        $conn->query($sql_insert_profile);
    }
}

// Return connection
return $conn;
?>
