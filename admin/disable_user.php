<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';

$id = intval($_GET['id']);
mysqli_query($conn, "UPDATE users SET active=0 WHERE id=$id");
header("Location: users.php");
?>
