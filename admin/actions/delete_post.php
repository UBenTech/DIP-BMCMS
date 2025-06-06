<?php
// admin/delete_post.php
require_once __DIR__ . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['csrf_token'] ?? '';
    if (!validate_csrf_token($token)) {
        $_SESSION['flash_error'] = "Invalid CSRF token. Please try again.";
        header("Location: posts.php");
        exit;
    }

    $post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($post_id < 1) {
        $_SESSION['flash_error'] = "Invalid post ID.";
        header("Location: posts.php");
        exit;
    }

    // Delete featured image file if exists
    $stmt_img = $conn->prepare("SELECT featured_image FROM posts WHERE id = ? LIMIT 1");
    if ($stmt_img) {
        $stmt_img->bind_param("i", $post_id);
        $stmt_img->execute();
        $res_img = $stmt_img->get_result();
        if ($res_img && $res_img->num_rows === 1) {
            $row   = $res_img->fetch_assoc();
            $img   = $row['featured_image'];
            if ($img && file_exists(__DIR__ . "/../uploads/{$img}")) {
                unlink(__DIR__ . "/../uploads/{$img}");
            }
        }
        $stmt_img->close();
    }

    // Delete the post
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Post deleted successfully.";
        } else {
            $_SESSION['flash_error'] = "Failed to delete post: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['flash_error'] = "Failed to prepare delete statement: " . $conn->error;
    }

    header("Location: posts.php");
    exit;
} else {
    header("Location: posts.php");
    exit;
}
