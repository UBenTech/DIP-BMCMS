<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- HELPERS & UTILITIES ---
require_once 'includes/functions.php';

// --- LOAD SITE SETTINGS ---
$site_settings = load_site_settings();

// --- CONFIGURATION ---
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

require_once 'includes/db.php';

$page = $_GET['page'] ?? null;

if ($page) {
    $post = get_post_by_slug($page);

    if ($post) {
        echo "<h1>" . esc_html($post['title']) . "</h1>";
        echo "<p><em>Published on " . esc_html($post['created_at']) . "</em></p>";
        echo "<div>" . $post['content'] . "</div>";
    } else {
        echo "<h2>404 - Article Not Found</h2>";
        echo "<p>The page you’re looking for doesn't exist.</p>";
    }
} else {
    echo "<h1>Welcome to " . SITE_NAME . "</h1>";
    echo "<p>" . SITE_TAGLINE . "</p>";
    // Optionally show latest posts
}
?>
