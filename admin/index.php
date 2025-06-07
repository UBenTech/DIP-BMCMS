<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: auth/login.php');
    exit();
}
include '../includes/header.php';
echo '<h1>Admin Dashboard</h1>';
include '../includes/footer.php';
?>