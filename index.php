<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once 'includes/config.php'; // NEW: Include global config
require_once 'includes/functions.php';
require_once 'includes/db.php';

$page = $_GET['page'] ?? '';

include 'includes/header.php'; // Updated path for consistency

if ($page === '') {
    echo "<h1>Welcome to " . esc_html(SITE_NAME) . "</h1>";
    echo "<p>" . esc_html(SITE_TAGLINE) . "</p>";
    // List recent posts
    // Assuming get_recent_posts() function is defined and compatible with db.php connection
    // $posts = get_recent_posts();
    // foreach($posts as $p) {
    //     echo "<h2><a href='".esc_html($p['slug'])."'>".esc_html($p['title'])."</a></h2>";
    // }
} else {
    $post = get_post_by_slug($page);
    if ($post) {
        echo "<h1>".esc_html($post['title'])."</h1>";
        echo "<p><em>Published on " . esc_html($post['created_at']) . "</em></p>";
        echo $post['content'];
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1><p>Article not found.</p>";
    }
}

include 'includes/footer.php'; // Updated path for consistency
?>