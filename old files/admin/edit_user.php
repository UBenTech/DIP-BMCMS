<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Fetch user by ID, handle update logic here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-edit"></i> Edit User</h1>
    <?php include '_partials/nav.php'; ?>
    <div class="card">
        <form method="post" action="">
            <label>Email</label>
            <input type="email" name="email" value="admin@example.com">
            <label>Role</label>
            <select name="role">
                <option value="admin" selected>Admin</option>
                <option value="editor">Editor</option>
            </select>
            <button type="submit" class="btn success"><i class="fa fa-save"></i> Update</button>
        </form>
    </div>
</div>
</body>
</html>