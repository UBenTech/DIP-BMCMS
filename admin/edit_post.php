<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';

$id = intval($_GET['id']);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $t=$_POST['title']; $b=$_POST['body'];
  $stmt=$conn->prepare("UPDATE posts SET title=?, body=? WHERE id=?");
  $stmt->bind_param("ssi",$t,$b,$id); $stmt->execute();
  header("Location: posts.php");
}
$res = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$post = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Post</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin-left: 240px; font-family: Arial; background: #f9f9f9; }
    .container{padding:20px;}
    form{background:#fff;padding:20px;border-radius:6px;}
    input,textarea{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:4px;}
    button{background:#469FD7;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;}
    button:hover{opacity:0.9;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-edit"></i> Edit Post</h1>
  <form method="post">
    <input type="text" name="title" value="<?=htmlspecialchars($post['title'])?>" required>
    <textarea name="body" rows="8" required><?=htmlspecialchars($post['body'])?></textarea>
    <button type="submit">Save Changes</button>
  </form>
</div>
</body>
</html>
