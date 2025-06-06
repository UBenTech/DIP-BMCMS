<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM posts WHERE id=$id");
header("Location: posts.php");
?>
