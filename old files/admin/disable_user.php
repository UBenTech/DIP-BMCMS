<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Handle user disabling logic here, then redirect
header('Location: users.php');
exit;