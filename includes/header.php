<?php
// includes/header.php

$page_title = $page_title ?? (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_description = $meta_description ?? 'Welcome to ' . (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_keywords = $meta_keywords ?? '';

defined('BASE_URL') or define('BASE_URL', '/');
if (!defined('SITE_NAME')) {
    $site_settings = load_site_settings();
    define('SITE_NAME', $site_settings['site_name'] ?? 'dipug.com');
}

global $page;
$current_page = $page ?? ($_GET['page'] ?? 'home');

$main_nav_links = [
    ["name" => "Home", "page" => "home"],
    ["name" => "Services", "page" => "services"],
    ["name" => "Portfolio", "page" => "portfolio"],
    ["name" => "Blog", "page" => "blog"],
    ["name" => "Contact", "page" => "contact"]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc_html($page_title) ?></title>
  <meta name="description" content="<?= esc_html($meta_description) ?>" />
  <?php if ($meta_keywords): ?>
    <meta name="keywords" content="<?= esc_html($meta_keywords) ?>" />
  <?php endif; ?>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            display: ['Poppins', 'sans-serif']
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    :root {
      --primary: #0056B3;
      --background: #F4F4F4;
      --accent: #4B5563;
      --text: #333333;
      --highlight: #F59E0B;
    }

    body {
      background-color: var(--background);
      color: var(--text);
      font-family: 'Inter', sans-serif;
    }

    .nav-link {
      @apply text-sm font-medium px-3 py-2 rounded-md transition-colors;
      color: var(--accent);
    }

    .nav-link:hover {
      color: var(--highlight);
    }

    .nav-link-active {
      color: var(--primary);
      font-weight: 600;
    }
  </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

<!-- Top Info Bar -->
<div class="bg-white border-b border-gray-200 text-xs text-[var(--accent)] px-4 py-2">
  <div class="max-w-screen-xl mx-auto flex justify-between items-center">
    <div class="space-x-4">
      <a href="<?= BASE_URL ?>about" class="hover:text-[var(--highlight)] transition">About</a>
      <a href="<?= BASE_URL ?>contact" class="hover:text-[var(--highlight)] transition">Contact</a>
      <a href="<?= BASE_URL ?>privacy" class="hover:text-[var(--highlight)] transition">Privacy</a>
    </div>
    <div class="space-x-3 flex items-center">
      <?php foreach (['facebook', 'twitter', 'linkedin', 'instagram'] as $icon): ?>
        <a href="#" aria-label="<?= ucfirst($icon) ?>" class="hover:text-[var(--highlight)] transition">
          <i data-lucide="<?= $icon ?>" class="w-4 h-4"></i>
        </a>
      <?php endforeach; ?>
      <?php if (!isset($_SESSION['admin_user_id'])): ?>
        <a href="<?= BASE_URL ?>admin/" class="ml-3 bg-[var(--primary)] text-white px-2 py-0.5 rounded text-xs hover:opacity-90 transition">Admin Login</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Main Header -->
<header class="bg-white shadow sticky top-0 z-50">
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
    <!-- Logo -->
    <a href="<?= BASE_URL ?>" class="font-display text-xl font-bold text-[var(--primary)] hover:text-[var(--highlight)] transition flex items-center">
      <i data-lucide="cpu" class="w-6 h-6 mr-2"></i><?= SITE_NAME ?>
    </a>

    <!-- Desktop Nav -->
    <nav class="hidden md:flex items-center space-x-4">
      <?php foreach ($main_nav_links as $link): 
        $url = BASE_URL . $link['page'];
        $is_active = $current_page === $link['page'] ? 'nav-link-active' : 'nav-link';
      ?>
        <a href="<?= $url ?>" class="<?= $is_active ?>"><?= $link['name'] ?></a>
      <?php endforeach; ?>

      <?php if (isset($_SESSION['admin_user_id'])): ?>
        <a href="<?= BASE_URL ?>admin/" class="nav-link">Admin Panel</a>
        <a href="<?= BASE_URL ?>admin/index.php?admin_page=logout" class="ml-2 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm transition">Sign Out</a>
      <?php endif; ?>
    </nav>

    <!-- Mobile Toggle -->
    <div class="md:hidden">
      <button id="mobileMenuToggle" class="text-[var(--accent)] hover:text-[var(--highlight)] transition p-2">
        <i data-lucide="menu" class="w-6 h-6"></i>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Menu -->
<div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200 shadow px-4 py-4 space-y-2">
  <?php foreach ($main_nav_links as $link): 
    $url = BASE_URL . $link['page'];
    $is_active = $current_page === $link['page'] ? 'text-[var(--primary)] font-semibold' : 'text-[var(--accent)]';
  ?>
    <a href="<?= $url ?>" class="block <?= $is_active ?> hover:text-[var(--highlight)]"><?= $link['name'] ?></a>
  <?php endforeach; ?>

  <?php if (!isset($_SESSION['admin_user_id'])): ?>
    <a href="<?= BASE_URL ?>admin/" class="block text-[var(--accent)] hover:text-[var(--highlight)]">Admin Login</a>
  <?php else: ?>
    <a href="<?= BASE_URL ?>admin/" class="block text-[var(--accent)] hover:text-[var(--highlight)]">Admin Panel</a>
    <a href="<?= BASE_URL ?>admin/index.php?admin_page=logout" class="block text-red-600 hover:text-red-700">Sign Out</a>
  <?php endif; ?>
</div>

<!-- Toggle script -->
<script>
  document.getElementById('mobileMenuToggle')?.addEventListener('click', () => {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
  });
</script>

<main class="flex-grow">
