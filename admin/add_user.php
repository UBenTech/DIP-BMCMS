<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $u=$_POST['username']; $e=$_POST['email']; $p=password_hash($_POST['password'],PASSWORD_DEFAULT);
  $stmt=$conn->prepare("INSERT INTO users (username,email,password,created_at) VALUES (?,?,?,NOW())");
  $stmt->bind_param("sss",$u,$e,$p); $stmt->execute();
  header("Location: users.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add User</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body{margin-left:240px;font-family:Arial;background:#f9f9f9;}
    .container{padding:20px;} form{background:#fff;padding:20px;border-radius:6px;}
    input{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:4px;}
    button{background:#403EF1;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;}
    button:hover{opacity:0.9;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-user-plus"></i> Add User</h1>
  <form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Create User</button>
  </form>
</div>
</body>
</html>
