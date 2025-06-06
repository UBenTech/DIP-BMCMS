<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Handle user creation logic here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-user-plus"></i> Add User</h1>
    <?php include '_partials/nav.php'; ?>
    <div class="card">
        <form method="post" action="">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label>Role</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
            </select>
            <button type="submit" class="btn success"><i class="fa fa-save"></i> Create</button>
        </form>
    </div>
</div>
</body>
</html>