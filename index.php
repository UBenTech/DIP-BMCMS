<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- HELPERS & UTILITIES ---
require_once __DIR__ . '/includes/functions.php'; // For esc_html, load_site_settings etc.

// --- LOAD SITE SETTINGS ---
$site_settings = load_site_settings();

// --- CONFIGURATION (Use loaded settings, fallback to defaults if needed) ---
define('BASE_URL', '/'); 
define('SITE_NAME', $site_settings['site_name'] ?? 'dipug.com');
define('SITE_TAGLINE', $site_settings['site_tagline'] ?? 'Digital Innovation and Programming');
define('POSTS_PER_PAGE', (int)($site_settings['posts_per_page'] ?? 10));
define('CONTACT_EMAIL', $site_settings['contact_email'] ?? 'info@example.com');
define('FOOTER_COPYRIGHT', $site_settings['footer_copyright'] ?? '&copy; {year} dipug.com. All Rights Reserved.');

define('DB_HOST', 'localhost');
define('DB_USER', 'u662439561_main5_'); 
define('DB_PASS', 'XpGmn&9a');     
define('DB_NAME', 'u662439561_Main5_'); 

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/hash.php'; 

// --- BASIC ROUTING ---
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$admin_page = isset($_GET['admin_page']) ? $_GET['admin_page'] : null; 

// --- PAGE HEAD (Title, Meta) ---
$page_title_suffix = SITE_NAME . " - " . SITE_TAGLINE;
$page_title = SITE_NAME; 
$meta_description = "Welcome to " . SITE_NAME . ". Your trusted partner for digital innovation, programming, IT services, software, courses, and web development.";

if ($admin_page) {
    if ($page === 'admin') {
        include_once __DIR__ . '/admin/index.php';
        exit; 
    }
}

switch ($page) {
    case 'home':
        $page_title = SITE_NAME . " - Innovate, Program, Succeed";
        $include_file = __DIR__ . '/pages/home.php';
        break;
    case 'about':
        $page_title = "About Us - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/about.php';
        break;
    case 'contact':
        $page_title = "Contact Us - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/contact.php';
        break;
    case 'privacy':
        $page_title = "Privacy Policy - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/privacy.php';
        break;
    case 'services_overview':
        $page_title = "Our Services - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/services_overview.php';
        break;
    case 'software':
        $page_title = "Software Solutions - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/software.php';
        break;
    case 'courses':
        $page_title = "Online Courses - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/courses.php';
        break;
    case 'support':
        $page_title = "Tech Support - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/support.php';
        break;
    case 'webDev':
        $page_title = "Web Development - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/web_development.php';
        break;
    case 'cloud':
        $page_title = "Cloud Solutions - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/cloud.php';
        break;
    case 'cybersecurity':
        $page_title = "Cybersecurity - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/cybersecurity.php';
        break;
    case 'portfolio':
        $page_title = "Our Portfolio - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/portfolio.php';
        break;
    case 'blog':
        $page_title = "Blog - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/blog.php';
        break;
    case 'post':
        $post_slug_or_id = isset($_GET['slug']) ? $_GET['slug'] : (isset($_GET['id']) ? (int)$_GET['id'] : null);
        $page_title = "Blog Post - " . $page_title_suffix; 
        $include_file = __DIR__ . '/pages/post.php';
        break;
    default:
        http_response_code(404);
        $page_title = "Page Not Found - " . $page_title_suffix;
        $include_file = __DIR__ . '/pages/404.php';
        break;
}

// --- HEADER ---
include_once __DIR__ . '/includes/header.php';

// --- MAIN CONTENT ---
if (file_exists($include_file)) {
    include_once $include_file;
} else {
    echo "<div class='container mx-auto my-10 p-8 bg-red-100 border border-red-400 text-red-700 rounded-lg text-center'>";
    echo "<h1 class='text-2xl font-bold'>Error: Content File Missing</h1>";
    echo "<p>The file '" . esc_html($include_file) . "' could not be found.</p>";
    echo "</div>";
}

// --- FOOTER ---
include_once __DIR__ . '/includes/footer.php';

if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>