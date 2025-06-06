<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Handle form submission logic here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-plus"></i> Add New Post</h1>
    <?php include '_partials/nav.php'; ?>
    <div class="card">
        <form method="post" action="">
            <label>Title</label>
            <input type="text" name="title" required>
            <label>Content</label>
            <textarea name="content" rows="10" required></textarea>
            <label>Status</label>
            <select name="status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
            <button type="submit" class="btn success"><i class="fa fa-save"></i> Save</button>
        </form>
    </div>
</div>
</body>
</html>