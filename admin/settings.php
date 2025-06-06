<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  // example: site title setting
  $site = $_POST['site_title'];
  mysqli_query($conn, "UPDATE settings SET value='$site' WHERE name='site_title'");
  header("Location: settings.php");
}
$res = mysqli_query($conn, "SELECT * FROM settings");
$settings = [];
while($r=mysqli_fetch_assoc($res)) $settings[$r['name']]=$r['value'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Settings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body{margin-left:240px;font-family:Arial;background:#f9f9f9;}
    .container{padding:20px;} form{background:#fff;padding:20px;border-radius:6px;}
    input{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:4px;}
    button{background:#403EF1;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;}
    button:hover{opacity:0.9;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-gear"></i> Settings</h1>
  <form method="post">
    <label>Site Title</label>
    <input type="text" name="site_title" value="<?=htmlspecialchars($settings['site_title'] ?? '')?>">
    <button type="submit">Save Settings</button>
  </form>
</div>
</body>
</html>
