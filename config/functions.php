<?php
session_start();

// Include database connection
$conn = include 'database.php';

// Login function
function login_user($username, $password) {
    global $conn;
    
    $username = $conn->real_escape_string($username);
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    return false;
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Logout function
function logout_user() {
    session_destroy();
    header('Location: login.php');
}

// Get profile data
function get_profile() {
    global $conn;
    $sql = "SELECT * FROM profile LIMIT 1";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Update profile
function update_profile($data) {
    global $conn;
    
    $name = $conn->real_escape_string($data['name'] ?? '');
    $title = $conn->real_escape_string($data['title'] ?? '');
    $bio = $conn->real_escape_string($data['bio'] ?? '');
    $email = $conn->real_escape_string($data['email'] ?? '');
    $phone = $conn->real_escape_string($data['phone'] ?? '');
    $location = $conn->real_escape_string($data['location'] ?? '');
    $github = $conn->real_escape_string($data['github_url'] ?? '');
    $linkedin = $conn->real_escape_string($data['linkedin_url'] ?? '');
    $twitter = $conn->real_escape_string($data['twitter_url'] ?? '');
    $profile_image = $conn->real_escape_string($data['profile_image'] ?? '');
    
    $sql = "UPDATE profile SET 
            name='$name', 
            title='$title', 
            bio='$bio', 
            email='$email', 
            phone='$phone', 
            location='$location',
            github_url='$github',
            linkedin_url='$linkedin',
            twitter_url='$twitter',
            profile_image='$profile_image'
            WHERE id=1";
    
    return $conn->query($sql);
}

// Get all skills
function get_skills() {
    global $conn;
    $sql = "SELECT * FROM skills ORDER BY category";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Add skill
function add_skill($skill_name, $category, $level) {
    global $conn;
    
    $skill_name = $conn->real_escape_string($skill_name);
    $category = $conn->real_escape_string($category);
    $level = $conn->real_escape_string($level);
    
    $sql = "INSERT INTO skills (skill_name, category, level) VALUES ('$skill_name', '$category', '$level')";
    return $conn->query($sql);
}

// Delete skill
function delete_skill($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM skills WHERE id=$id";
    return $conn->query($sql);
}

// Get all projects
function get_projects() {
    global $conn;
    $sql = "SELECT * FROM projects ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get project by ID
function get_project($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM projects WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Add project
function add_project($data) {
    global $conn;
    
    $title = $conn->real_escape_string($data['title']);
    $description = $conn->real_escape_string($data['description']);
    $image_url = $conn->real_escape_string($data['image_url']);
    $github_link = $conn->real_escape_string($data['github_link']);
    $demo_link = $conn->real_escape_string($data['demo_link']);
    $technologies = $conn->real_escape_string($data['technologies']);
    
    $sql = "INSERT INTO projects (title, description, image_url, github_link, demo_link, technologies) 
            VALUES ('$title', '$description', '$image_url', '$github_link', '$demo_link', '$technologies')";
    
    return $conn->query($sql);
}

// Update project
function update_project($id, $data) {
    global $conn;
    
    $id = intval($id);
    $title = $conn->real_escape_string($data['title']);
    $description = $conn->real_escape_string($data['description']);
    $image_url = $conn->real_escape_string($data['image_url']);
    $github_link = $conn->real_escape_string($data['github_link']);
    $demo_link = $conn->real_escape_string($data['demo_link']);
    $technologies = $conn->real_escape_string($data['technologies']);
    
    $sql = "UPDATE projects SET 
            title='$title', 
            description='$description', 
            image_url='$image_url',
            github_link='$github_link',
            demo_link='$demo_link',
            technologies='$technologies'
            WHERE id=$id";
    
    return $conn->query($sql);
}

// Delete project
function delete_project($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM projects WHERE id=$id";
    return $conn->query($sql);
}

// Testimonials CRUD
function get_testimonials() {
    global $conn;
    $sql = "SELECT * FROM testimonials ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_testimonial($data) {
    global $conn;
    $author = $conn->real_escape_string($data['author'] ?? 'Anonymous');
    $company = $conn->real_escape_string($data['company'] ?? '');
    $message = $conn->real_escape_string($data['message'] ?? '');
    $rating = intval($data['rating'] ?? 5);

    $sql = "INSERT INTO testimonials (author, company, message, rating) VALUES ('$author', '$company', '$message', $rating)";
    return $conn->query($sql);
}

function delete_testimonial($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM testimonials WHERE id=$id";
    return $conn->query($sql);
}

function update_testimonial($id, $data) {
    global $conn;
    $id = intval($id);
    $author = $conn->real_escape_string($data['author'] ?? 'Anonymous');
    $company = $conn->real_escape_string($data['company'] ?? '');
    $message = $conn->real_escape_string($data['message'] ?? '');
    $rating = intval($data['rating'] ?? 5);

    $sql = "UPDATE testimonials SET author='$author', company='$company', message='$message', rating=$rating WHERE id=$id";
    return $conn->query($sql);
}

// Articles CRUD
function get_articles() {
    global $conn;
    $sql = "SELECT * FROM articles ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_article($data) {
    global $conn;
    $title = $conn->real_escape_string($data['title'] ?? '');
    $slug = $conn->real_escape_string($data['slug'] ?? '');
    $excerpt = $conn->real_escape_string($data['excerpt'] ?? '');
    $content = $conn->real_escape_string($data['content'] ?? '');
    $author = $conn->real_escape_string($data['author'] ?? '');
    $published_at = $conn->real_escape_string($data['published_at'] ?? null);

    $sql = "INSERT INTO articles (title, slug, excerpt, content, author, published_at) VALUES ('$title', '$slug', '$excerpt', '$content', '$author', " . ($published_at ? "'$published_at'" : "NULL") . ")";
    return $conn->query($sql);
}

function delete_article($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM articles WHERE id=$id";
    return $conn->query($sql);
}

function update_article($id, $data) {
    global $conn;
    $id = intval($id);
    $title = $conn->real_escape_string($data['title'] ?? '');
    $slug = $conn->real_escape_string($data['slug'] ?? '');
    $excerpt = $conn->real_escape_string($data['excerpt'] ?? '');
    $content = $conn->real_escape_string($data['content'] ?? '');
    $author = $conn->real_escape_string($data['author'] ?? '');
    $published_at = $conn->real_escape_string($data['published_at'] ?? null);

    $sql = "UPDATE articles SET title='$title', slug='$slug', excerpt='$excerpt', content='$content', author='$author', published_at=" . ($published_at ? "'$published_at'" : "NULL") . " WHERE id=$id";
    return $conn->query($sql);
}

// Education CRUD
function get_education() {
    global $conn;
    $sql = "SELECT * FROM education ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_education($data) {
    global $conn;
    $institution = $conn->real_escape_string($data['institution'] ?? '');
    $degree = $conn->real_escape_string($data['degree'] ?? '');
    $major = $conn->real_escape_string($data['major'] ?? '');
    $gpa = $conn->real_escape_string($data['gpa'] ?? '');
    $start_date = $conn->real_escape_string($data['start_date'] ?? '');
    $end_date = $conn->real_escape_string($data['end_date'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');

    $sql = "INSERT INTO education (institution, degree, major, gpa, start_date, end_date, description) VALUES ('$institution', '$degree', '$major', '$gpa', '$start_date', '$end_date', '$description')";
    return $conn->query($sql);
}

function delete_education($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM education WHERE id=$id";
    return $conn->query($sql);
}

function get_education_by_id($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM education WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function update_education($id, $data) {
    global $conn;
    $id = intval($id);
    $institution = $conn->real_escape_string($data['institution'] ?? '');
    $degree = $conn->real_escape_string($data['degree'] ?? '');
    $major = $conn->real_escape_string($data['major'] ?? '');
    $gpa = $conn->real_escape_string($data['gpa'] ?? '');
    $start_date = $conn->real_escape_string($data['start_date'] ?? '');
    $end_date = $conn->real_escape_string($data['end_date'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');

    $sql = "UPDATE education SET institution='$institution', degree='$degree', major='$major', gpa='$gpa', start_date='$start_date', end_date='$end_date', description='$description' WHERE id=$id";
    return $conn->query($sql);
}

// Experience CRUD
function get_experience() {
    global $conn;
    $sql = "SELECT * FROM experience ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_experience($data) {
    global $conn;
    $role = $conn->real_escape_string($data['role'] ?? '');
    $company = $conn->real_escape_string($data['company'] ?? '');
    $location = $conn->real_escape_string($data['location'] ?? '');
    $start_date = $conn->real_escape_string($data['start_date'] ?? '');
    $end_date = $conn->real_escape_string($data['end_date'] ?? '');
    $details = $conn->real_escape_string($data['details'] ?? '');

    $sql = "INSERT INTO experience (role, company, location, start_date, end_date, details) VALUES ('$role', '$company', '$location', '$start_date', '$end_date', '$details')";
    return $conn->query($sql);
}

function delete_experience($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM experience WHERE id=$id";
    return $conn->query($sql);
}

function get_experience_by_id($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM experience WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function update_experience($id, $data) {
    global $conn;
    $id = intval($id);
    $role = $conn->real_escape_string($data['role'] ?? '');
    $company = $conn->real_escape_string($data['company'] ?? '');
    $location = $conn->real_escape_string($data['location'] ?? '');
    $start_date = $conn->real_escape_string($data['start_date'] ?? '');
    $end_date = $conn->real_escape_string($data['end_date'] ?? '');
    $details = $conn->real_escape_string($data['details'] ?? '');

    $sql = "UPDATE experience SET role='$role', company='$company', location='$location', start_date='$start_date', end_date='$end_date', details='$details' WHERE id=$id";
    return $conn->query($sql);
}

// Organization CRUD
function get_organizations() {
    global $conn;
    $sql = "SELECT * FROM organizations ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_organization($data) {
    global $conn;
    $role = $conn->real_escape_string($data['role'] ?? '');
    $organization = $conn->real_escape_string($data['organization'] ?? '');
    $start_date = $conn->real_escape_string($data['start_date'] ?? '');
    $end_date = $conn->real_escape_string($data['end_date'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');

    $sql = "INSERT INTO organizations (role, organization, start_date, end_date, description) VALUES ('$role', '$organization', '$start_date', '$end_date', '$description')";
    return $conn->query($sql);
}

function delete_organization($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM organizations WHERE id=$id";
    return $conn->query($sql);
}

function get_organization_by_id($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM organizations WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function update_organization($id, $data) {
    global $conn;
    $id = intval($id);
    $role = $conn->real_escape_string($data['role'] ?? '');
    $organization = $conn->real_escape_string($data['organization'] ?? '');
    $start_date = $conn->real_escape_string($data['start_date'] ?? '');
    $end_date = $conn->real_escape_string($data['end_date'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');

    $sql = "UPDATE organizations SET role='$role', organization='$organization', start_date='$start_date', end_date='$end_date', description='$description' WHERE id=$id";
    return $conn->query($sql);
}

// Certification CRUD
function get_certifications() {
    global $conn;
    $sql = "SELECT * FROM certifications ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function add_certification($data) {
    global $conn;
    $title = $conn->real_escape_string($data['title'] ?? '');
    $issuer = $conn->real_escape_string($data['issuer'] ?? '');
    $issue_date = $conn->real_escape_string($data['issue_date'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');

    $sql = "INSERT INTO certifications (title, issuer, issue_date, description) VALUES ('$title', '$issuer', '$issue_date', '$description')";
    return $conn->query($sql);
}

function delete_certification($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM certifications WHERE id=$id";
    return $conn->query($sql);
}

function get_certification_by_id($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM certifications WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function update_certification($id, $data) {
    global $conn;
    $id = intval($id);
    $title = $conn->real_escape_string($data['title'] ?? '');
    $issuer = $conn->real_escape_string($data['issuer'] ?? '');
    $issue_date = $conn->real_escape_string($data['issue_date'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');

    $sql = "UPDATE certifications SET title='$title', issuer='$issuer', issue_date='$issue_date', description='$description' WHERE id=$id";
    return $conn->query($sql);
}

// Newsletter subscribers
function add_subscriber($email, $name = '') {
    global $conn;
    $email = $conn->real_escape_string($email);
    $name = $conn->real_escape_string($name);
    $sql = "INSERT IGNORE INTO newsletter_subscribers (email, name) VALUES ('$email', '$name')";
    return $conn->query($sql);
}

function get_subscribers() {
    global $conn;
    $sql = "SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function delete_subscriber($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM newsletter_subscribers WHERE id=$id";
    return $conn->query($sql);
}
?>
