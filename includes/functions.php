<?php
function is_admin_logged_in() {
    return isset($_SESSION['admin']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: ../admin/login.php');
        exit;
    }
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
// Add other useful helpers as needed
?>