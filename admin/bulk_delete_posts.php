<?php
// admin/bulk_delete_posts.php
require_once __DIR__ . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validate_csrf_token($token)) {
        $_SESSION['flash_error'] = "Invalid CSRF token. Please try again.";
        header("Location: posts.php");
        exit;
    }

    $selected = $_POST['selected_posts'] ?? [];
    if (!is_array($selected) || count($selected) === 0) {
        $_SESSION['flash_error'] = "No posts were selected.";
        header("Location: posts.php");
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($selected), '?'));
    $types = str_repeat('i', count($selected));
    $sql = "SELECT id, featured_image FROM posts WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($types, ...$selected);
        $stmt->execute();
        $result = $stmt->get_result();
        $to_delete_images = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['featured_image'])) {
                $to_delete_images[] = $row['featured_image'];
            }
        }
        $stmt->close();

        // Delete image files
        foreach ($to_delete_images as $img) {
            $path = __DIR__ . "/../uploads/{$img}";
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Delete posts themselves
        $sql2 = "DELETE FROM posts WHERE id IN ($placeholders)";
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2) {
            $stmt2->bind_param($types, ...$selected);
            if ($stmt2->execute()) {
                $_SESSION['flash_success'] = count($selected) . " post(s) deleted successfully.";
            } else {
                $_SESSION['flash_error'] = "Error deleting posts: " . $stmt2->error;
            }
            $stmt2->close();
        } else {
            $_SESSION['flash_error'] = "Failed to prepare bulk delete statement: " . $conn->error;
        }
    } else {
        $_SESSION['flash_error'] = "Failed to prepare select statement: " . $conn->error;
    }

    header("Location: posts.php");
    exit;
} else {
    header("Location: posts.php");
    exit;
}
