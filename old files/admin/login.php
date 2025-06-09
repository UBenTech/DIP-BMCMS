<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}
// Handle login logic here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1><i class="fa fa-sign-in-alt"></i> Admin Login</h1>
    <div class="card">
        <form method="post" action="">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit" class="btn success"><i class="fa fa-sign-in-alt"></i> Login</button>
        </form>
    </div>
</div>
</body>
</html>