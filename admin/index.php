<?php
session_start();
require_once __DIR__ . '/../includes/config.php'; // NEW: Include global config
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ' . BASE_URL . 'admin/pages/login.php'); // Redirect to direct login page path
    exit();
}
include 'includes/header.php'; // Using local admin includes
echo '<h1>Admin Dashboard</h1>';
include 'includes/footer.php'; // Using local admin includes
?>