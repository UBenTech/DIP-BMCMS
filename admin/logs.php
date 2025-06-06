<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '_partials/nav.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>System Logs</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body{margin-left:240px;font-family:Arial;background:#f9f9f9;color:#333;}
    .container{padding:20px;} .log-box{background:#fff;padding:20px;border:1px solid #ddd;border-radius:6px;}
    pre{white-space:pre-wrap;font-size:14px;line-height:1.6;color:#555;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-book"></i> System Logs</h1>
  <div class="log-box">
    <pre>
[2025-06-07 12:01] Admin logged in
[2025-06-07 12:03] Post "Welcome" updated
[2025-06-07 12:05] User "bob" disabled
    </pre>
  </div>
</div>
</body>
</html>
