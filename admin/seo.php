<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');
include '../includes/db.php';
include '_partials/nav.php';

// Example: manage sitemap.txt regeneration
if(isset($_POST['regenerate'])){
  $pages = mysqli_query($conn,"SELECT slug,lastmod FROM posts");
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
  while($p=mysqli_fetch_assoc($pages)){
    $xml .= "  <url><loc>https://yourdomain.com/{$p['slug']}</loc><lastmod>{$p['lastmod']}</lastmod></url>\n";
  }
  $xml .= "</urlset>";
  file_put_contents("../sitemap.xml",$xml);
  header("Location: seo.php?ok=1");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>SEO Tools</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body{margin-left:240px;font-family:Arial;background:#f9f9f9;}
    .container{padding:20px;} .box{background:#fff;padding:20px;border-radius:6px;}
    button{background:#469FD7;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer;}
    button:hover{opacity:0.9;}
    .success{color:green;}
  </style>
</head>
<body>
<div class="container">
  <h1><i class="fa fa-globe"></i> SEO Tools</h1>
  <div class="box">
    <?php if(isset($_GET['ok'])): ?><p class="success">Sitemap regenerated!</p><?php endif; ?>
    <form method="post">
      <button name="regenerate"><i class="fa fa-sync"></i> Regenerate Sitemap</button>
    </form>
  </div>
</div>
</body>
</html>
