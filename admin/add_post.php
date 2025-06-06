<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $t=$_POST['title']; $b=$_POST['body']; $a=$_SESSION['admin'];
  $stmt=$conn->prepare("INSERT INTO posts (title,body,author,created_at) VALUES (?,?,?,NOW())");
  $stmt->bind_param("sss",$t,$b,$a); $stmt->execute();
  header("Location: posts.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Post</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin-left: 240px; font-family: Arial; background: #f9f9f9; color: #333; }
    .container{padding:20px;}
    form{background:#fff;padding:20px;border-radius:6px;}
    input,textarea{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:4px;}
    button{background:#403EF1;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;}
    button:hover{opacity:0.9;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-plus"></i> Add New Post</h1>
  <form method="post">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="body" rows="8" placeholder="Content" required></textarea>
    <button type="submit">Publish</button>
  </form>
</div>
</body>
</html>
