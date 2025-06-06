<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Handle post deletion logic here, then redirect
header('Location: posts.php');
exit;