<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Fetch post by ID, handle update logic
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-edit"></i> Edit Post</h1>
    <?php include '_partials/nav.php'; ?>
    <div class="card">
        <form method="post" action="">
            <label>Title</label>
            <input type="text" name="title" value="Sample Post">
            <label>Content</label>
            <textarea name="content" rows="10">Sample content...</textarea>
            <label>Status</label>
            <select name="status">
                <option value="draft">Draft</option>
                <option value="published" selected>Published</option>
            </select>
            <button type="submit" class="btn success"><i class="fa fa-save"></i> Update</button>
        </form>
    </div>
</div>
</body>
</html>