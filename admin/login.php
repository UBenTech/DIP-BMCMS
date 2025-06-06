<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = mysqli_real_escape_string($conn, $_POST['user']);
    $p = $_POST['pass'];

    // Adjust this query to match how you flag admin users in your users table:
    // Option A: you have an is_admin column
    $sql = "SELECT * FROM users WHERE username='$u' AND is_admin=1 LIMIT 1";
    // Option B: you use a role field
    // $sql = "SELECT * FROM users WHERE username='$u' AND role='admin' LIMIT 1";

    $res = mysqli_query($conn, $sql);

    if ($res && $r = mysqli_fetch_assoc($res)) {
        if (password_verify($p, $r['password'])) {
            $_SESSION['admin'] = $u;
            header('Location: index.php');
            exit;
        }
    }
    $error = "Invalid credentials or not authorized.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body{display:flex;justify-content:center;align-items:center;height:100vh;background:#f9f9f9;font-family:Arial;}
    .box{background:#fff;padding:30px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    input{width:100%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:4px;}
    button{width:100%;background:#403EF1;color:#fff;padding:10px;border:none;border-radius:4px;cursor:pointer;}
    .error{color:red;}
  </style>
</head>
<body>
<div class="box">
  <h2>Admin Login</h2>
  <?php if (isset($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post">
    <input name="user" placeholder="Username" required>
    <input name="pass" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>
</body>
</html>
