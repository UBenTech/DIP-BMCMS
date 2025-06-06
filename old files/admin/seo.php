<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Load/save SEO settings logic here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - SEO</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-globe"></i> SEO Management</h1>
    <?php include '_partials/nav.php'; ?>
    <div class="card">
        <form method="post" action="">
            <label for="site_title">Site Title</label>
            <input type="text" id="site_title" name="site_title" value="My Blog">
            <label for="meta_description">Meta Description</label>
            <textarea id="meta_description" name="meta_description" rows="3">My awesome blog about stuff...</textarea>
            <button type="submit" class="btn success"><i class="fa fa-save"></i> Save</button>
        </form>
    </div>
</div>
</body>
</html>