<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Load/save settings logic here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Settings</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-gear"></i> Site Settings</h1>
    <?php include '_partials/nav.php'; ?>
    <div class="card">
        <form method="post" action="">
            <label for="site_email">Site Email</label>
            <input type="email" id="site_email" name="site_email" value="admin@myblog.com">
            <label for="logo_url">Logo URL</label>
            <input type="text" id="logo_url" name="logo_url" value="/logo.png">
            <button type="submit" class="btn success"><i class="fa fa-save"></i> Save</button>
        </form>
    </div>
</div>
</body>
</html>