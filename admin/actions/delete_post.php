<?php
// admin/actions/delete_post.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../includes/db.php';
require_once '../../includes/functions.php'; // For CSRF validation
require_once '../../includes/hash.php';

defined('BASE_URL') or define('BASE_URL', '/');
$admin_base_url = BASE_URL . 'admin/';
$upload_path = '../../uploads/';

// --- AUTHENTICATION CHECK ---
if (!isset($_SESSION['admin_user_id'])) {
    $_SESSION['flash_message'] = "You must be logged in to perform this action.";
    $_SESSION['flash_message_type'] = "error";
    // Redirect to login or posts page if preferred
    header('Location: ' . $admin_base_url . 'index.php?admin_page=login');
    exit;
}

if (isset($_GET['id']) && isset($_GET['csrf_token'])) {
    $post_id = (int)$_GET['id'];
    $token = $_GET['csrf_token'];

    // --- CSRF TOKEN VALIDATION ---
    if (!validate_csrf_token($token)) {
        $_SESSION['flash_message'] = "Invalid or missing CSRF token. Action aborted.";
        $_SESSION['flash_message_type'] = "error";
        header('Location: ' . $admin_base_url . 'index.php?admin_page=posts');
        exit;
    }

    // Fetch featured image filename before deleting the record
    $stmt_img = $conn->prepare("SELECT featured_image FROM posts WHERE id = ?");
    $featured_image_to_delete = null;
    if ($stmt_img) {
        $stmt_img->bind_param("i", $post_id);
        $stmt_img->execute();
        $result_img = $stmt_img->get_result();
        if ($result_img->num_rows === 1) {
            $img_data = $result_img->fetch_assoc();
            $featured_image_to_delete = $img_data['featured_image'];
        }
        $stmt_img->close();
    }


    // --- DATABASE DELETION ---
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Delete the physical image file if it exists
                if (!empty($featured_image_to_delete)) {
                    $file_path = $upload_path . $featured_image_to_delete;
                    if (file_exists($file_path)) {
                        @unlink($file_path); // Use @ to suppress errors if file not found, though it should exist
                    }
                }
                $_SESSION['flash_message'] = "Post deleted successfully.";
                $_SESSION['flash_message_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Post not found or already deleted.";
                $_SESSION['flash_message_type'] = "error";
            }
        } else {
            // Log error: $stmt->error
            error_log("DB Error deleting post: " . $stmt->error);
            $_SESSION['flash_message'] = "Error deleting post: " . $stmt->error;
            $_SESSION['flash_message_type'] = "error";
        }
        $stmt->close();
    } else {
        // Log error: $conn->error
        error_log("DB Prepare Error deleting post: " . $conn->error);
        $_SESSION['flash_message'] = "Database error. Could not prepare statement for deletion.";
        $_SESSION['flash_message_type'] = "error";
    }
} else {
    $_SESSION['flash_message'] = "Invalid request: Missing post ID or CSRF token.";
    $_SESSION['flash_message_type'] = "error";
}

if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}

header('Location: ' . $admin_base_url . 'index.php?admin_page=posts');
exit;
?>
