<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';
$u = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body{margin-left:240px;font-family:Arial;background:#f9f9f9;}
    .container{padding:20px;}
    table{width:100%;border-collapse:collapse;background:#fff;}
    th,td{padding:12px;border-bottom:1px solid #ccc;}
    th{background:#403EF1;color:#fff;}
    a.btn{padding:6px 12px;border-radius:4px;color:#fff;text-decoration:none;font-size:14px;}
    .edit{background:#469FD7;} .disable{background:#F26722;} .btn:hover{opacity:0.9;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-users"></i> Manage Users</h1>
  <table>
    <thead><tr><th>Username</th><th>Email</th><th>Joined</th><th>Actions</th></tr></thead>
    <tbody>
    <?php while($r=mysqli_fetch_assoc($u)): ?>
      <tr>
        <td><?=htmlspecialchars($r['username'])?></td>
        <td><?=htmlspecialchars($r['email'])?></td>
        <td><?=date('Y-m-d',strtotime($r['created_at']))?></td>
        <td>
          <a href="edit_user.php?id=<?=$r['id']?>" class="btn edit">Edit</a>
          <a href="disable_user.php?id=<?=$r['id']?>" class="btn disable" onclick="return confirm('Disable?')">Disable</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
