<?php
// admin/auth/logout.php
if (session_status() == PHP_SESSION_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/config.php'; // NEW: Include global config

// Unset all session variables
$_SESSION = array();

// Destroy the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Use BASE_URL from config and then construct admin_base_url
$admin_base_url = BASE_URL . 'admin/';

// Redirect to login page directly
header('Location: ' . $admin_base_url . 'pages/login.php?status=loggedout');
exit;
?>