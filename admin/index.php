<?php
session_start();
if (!isset($_SESSION['admin'])) header('Location: login.php');
include '_partials/nav.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin-left: 240px; font-family: Arial; background: #f9f9f9; color: #333; }
    .container { padding: 20px; }
    .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .card h2 { margin: 0 0 10px; }
  </style>
</head>
<body>
  <div class="container">
    <h1><i class="fa fa-gauge"></i> Dashboard</h1>
    <div class="card">
      <h2>Total Posts</h2>
      <?php
        include '../includes/db.php';
        $res = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM posts");
        $c = mysqli_fetch_assoc($res)['cnt'];
        echo "<p style='font-size:24px;'>$c</p>";
      ?>
    </div>
    <div class="card">
      <h2>Total Users</h2>
      <?php
        $res = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM users");
        $c = mysqli_fetch_assoc($res)['cnt'];
        echo "<p style='font-size:24px;'>$c</p>";
      ?>
    </div>
  </div>
</body>
</html>
