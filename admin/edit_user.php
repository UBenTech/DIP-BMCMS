<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';

$id = intval($_GET['id']);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $u=$_POST['username']; $e=$_POST['email'];
  $stmt=$conn->prepare("UPDATE users SET username=?,email=? WHERE id=?");
  $stmt->bind_param("ssi",$u,$e,$id); $stmt->execute();
  header("Location: users.php");
}
$res = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit User</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body{margin-left:240px;font-family:Arial;background:#f9f9f9;}
    .container{padding:20px;} form{background:#fff;padding:20px;border-radius:6px;}
    input{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:4px;}
    button{background:#469FD7;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;}
    button:hover{opacity:0.9;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-edit"></i> Edit User</h1>
  <form method="post">
    <input type="text" name="username" value="<?=htmlspecialchars($user['username'])?>" required>
    <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>" required>
    <button type="submit">Save Changes</button>
  </form>
</div>
</body>
</html>
