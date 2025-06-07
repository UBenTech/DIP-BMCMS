<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once 'includes/functions.php';
require_once 'includes/db.php';

$settings = load_site_settings();
define('SITE_NAME',$settings['site_name']??'dipug.com');
define('SITE_TAGLINE',$settings['site_tagline']??'Digital Innovation and Programming');

$page = $_GET['page'] ?? '';

include 'header.php';

if ($page === '') {
    echo "<h1>Welcome to " . esc_html(SITE_NAME) . "</h1>";
    echo "<p>" . esc_html(SITE_TAGLINE) . "</p>";
    // List recent posts
    \$posts = get_recent_posts();
    foreach(\$posts as \$p) {
        echo "<h2><a href='".esc_html(\$p['slug'])."'>".esc_html(\$p['title'])."</a></h2>";
    }
} else {
    \$post = get_post_by_slug(\$page);
    if (\$post) {
        echo "<h1>".esc_html(\$post['title'])."</h1>";
        echo "<p><em>Published on " . esc_html(\$post['created_at']) . "</em></p>";
        echo \$post['content'];
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1><p>Article not found.</p>";
    }
}

include 'footer.php';
?>