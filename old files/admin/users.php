<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Placeholder for users fetch
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Users</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-users"></i> Manage Users</h1>
    <?php include '_partials/nav.php'; ?>
    <a href="add_user.php" class="btn success"><i class="fa fa-user-plus"></i> Add User</a>
    <div class="card">
        <table width="100%">
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <!-- Example row, replace with PHP loop for users -->
            <tr>
                <td>admin@example.com</td>
                <td>Admin</td>
                <td><span class="success">Active</span></td>
                <td>
                    <a href="edit_user.php?id=1" class="btn"><i class="fa fa-edit"></i></a>
                    <a href="disable_user.php?id=1" class="btn danger"><i class="fa fa-ban"></i></a>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>