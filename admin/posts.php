<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Placeholder for DB connection and posts fetch
//$posts = [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Posts</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-pen"></i> Manage Posts</h1>
    <?php include '_partials/nav.php'; ?>
    <a href="add_post.php" class="btn success"><i class="fa fa-plus"></i> Add New Post</a>
    <div class="card">
        <table width="100%">
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <!-- Example row, replace with PHP loop for $posts -->
            <tr>
                <td>Sample Post</td>
                <td><span class="success">Published</span></td>
                <td>
                    <a href="edit_post.php?id=1" class="btn"><i class="fa fa-edit"></i></a>
                    <a href="delete_post.php?id=1" class="btn danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>