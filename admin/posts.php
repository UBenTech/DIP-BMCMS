<?php
session_start();
if (!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';
$posts = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Posts</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin-left: 240px; font-family: Arial; background: #f9f9f9; color: #333; }
    .container { padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
    th, td { padding: 12px; border-bottom: 1px solid #ccc; }
    th { background: #403EF1; color: #fff; }
    a.btn { padding: 6px 12px; border-radius: 4px; color: #fff; text-decoration: none; font-size:14px; }
    .edit { background: #469FD7; } .delete { background: #F26722; }
    .preview { background: #7A7A7A; } .btn:hover { opacity: 0.9; }
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-pen"></i> Manage Posts</h1>
  <table>
    <thead>
      <tr><th>Title</th><th>Date</th><th>Author</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php while($r = mysqli_fetch_assoc($posts)): ?>
      <tr>
        <td><?=htmlspecialchars($r['title'])?></td>
        <td><?=date('Y-m-d',strtotime($r['created_at']))?></td>
        <td><?=htmlspecialchars($r['author'])?></td>
        <td>
          <a href="edit_post.php?id=<?=$r['id']?>" class="btn edit">Edit</a>
          <a href="delete_post.php?id=<?=$r['id']?>" class="btn delete" onclick="return confirm('Delete?')">Delete</a>
          <a href="../post.php?id=<?=$r['id']?>" target="_blank" class="btn preview">Preview</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
