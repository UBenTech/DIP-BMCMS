<?php
// includes/header.php

$page_title        = $page_title        ?? (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_description  = $meta_description  ?? 'Welcome to ' . (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_keywords     = $meta_keywords     ?? '';

defined('BASE_URL') or define('BASE_URL', '/');
if (!defined('SITE_NAME')) {
    $site_settings = load_site_settings();
    define('SITE_NAME', $site_settings['site_name'] ?? 'dipug.com');
}

global $page;
$current_page = $page ?? ($_GET['page'] ?? 'home');

$services = [
    ["name"=>"Web Development","page"=>"webDev","icon"=>"code-xml","desc"=>"Modern websites & applications."],
    ["name"=>"Software Solutions","page"=>"software","icon"=>"app-window","desc"=>"Custom software for your needs."],
    ["name"=>"Online Courses","page"=>"courses","icon"=>"graduation-cap","desc"=>"Upskill with expert-led courses."],
    ["name"=>"Tech Support","page"=>"support","icon"=>"life-buoy","desc"=>"Reliable IT assistance & consulting."],
    ["name"=>"Cloud Solutions","page"=>"cloud","icon"=>"cloud-cog","desc"=>"Scalable cloud infrastructure."],
    ["name"=>"Cybersecurity","page"=>"cybersecurity","icon"=>"shield-check","desc"=>"Protect your valuable digital assets."]
];

$nav_links = [
    ["name"=>"Home","page"=>"home","icon"=>"home"],
    ["name"=>"Services","page"=>"services_overview","icon"=>"layers","is_mega"=>true],
    ["name"=>"Portfolio","page"=>"portfolio","icon"=>"briefcase"],
    ["name"=>"Blog","page"=>"blog","icon"=>"book-open"],
    ["name"=>"Contact","page"=>"contact","icon"=>"mail"],
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= esc_html($page_title) ?></title>
  <meta name="description" content="<?= esc_html($meta_description) ?>">
  <?php if ($meta_keywords): ?>
    <meta name="keywords" content="<?= esc_html($meta_keywords) ?>">
  <?php endif; ?>

  <script src="https://cdn.tailwindcss.com?plugins=typography,forms"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: { DEFAULT: '#6366f1', hover: '#4f46e5' },
            secondary: { DEFAULT: '#10b981', hover: '#059669' },
            accent: { DEFAULT: '#f59e0b', hover: '#d97706' },
            neutral: '#1e293b', 'neutral-content': '#e2e8f0',
            'base-100': '#0f172a', 'base-200': '#1e293b',
            'neutral-focus': '#334155', 'neutral-light':'#334155', 'neutral-lighter':'#475569'
          },
          fontFamily: {
            sans: ['Inter','system-ui','sans-serif'],
            display: ['Poppins','sans-serif']
          }
        }
      }
    }
  </script>

  <script src="https://unpkg.com/lucide@latest" integrity="sha384-..." crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
  <link rel="icon" href="<?= BASE_URL ?>assets/favicon.ico" type="image/x-icon">

  <style>
    body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
    .font-display { font-family: 'Poppins', sans-serif; }
    .nav-link-active { color: #10b981; font-weight: 600; }
    .mega-menu-container { display:none; opacity:0; transform:translateY(5px); transition:.2s; pointer-events:none; }
    .group:hover .mega-menu-container,
    .mega-menu-trigger:focus + .mega-menu-container,
    .mega-menu-container:hover {
      display:block; opacity:1; pointer-events:auto; transform:translateY(0);
    }
    .mobile-menu { max-height:0; overflow:hidden; transition:max-height .4s ease; }
    .mobile-menu.open { max-height:calc(100vh-4rem); }
  </style>
</head>

<body class="antialiased bg-base-100 text-neutral-content flex flex-col min-h-screen">

  <!-- Top Info Bar -->
  <div class="bg-neutral text-neutral-content/70 py-2 px-4 border-b border-base-300 text-xs">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex space-x-4">
        <a href="<?= BASE_URL ?>about" class="hover:text-secondary transition">About Us</a>
        <a href="<?= BASE_URL ?>contact" class="hover:text-secondary transition">Contact</a>
        <a href="<?= BASE_URL ?>privacy" class="hover:text-secondary transition">Privacy Policy</a>
      </div>
      <div class="flex items-center space-x-4">
        <?php foreach(['facebook','twitter','linkedin','instagram'] as $icon): ?>
          <a href="#" aria-label="<?= ucfirst($icon) ?>" title="<?= ucfirst($icon) ?>" class="hover:text-secondary transition">
            <i data-lucide="<?= $icon ?>" class="w-4 h-4"></i>
          </a>
        <?php endforeach; ?>
        <?php if (!isset($_SESSION['admin_user_id'])): ?>
          <a href="<?= BASE_URL ?>admin/" class="ml-3 px-2 py-0.5 rounded bg-secondary hover:bg-secondary-hover text-white text-xs transition">Admin Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Main Navigation -->
  <header aria-label="Main Navigation" class="bg-base-200/80 backdrop-blur-lg sticky top-0 z-50 border-b border-base-300 print:hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Logo -->
        <a href="<?= BASE_URL ?>" class="flex items-center space-x-2">
          <i data-lucide="cpu" class="w-8 h-8 text-secondary"></i>
          <span class="font-display text-xl sm:text-2xl font-bold text-neutral-content hover:text-secondary transition"><?= SITE_NAME ?></span>
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-4">
          <?php foreach ($nav_links as $link): ?>
            <?php 
              $url = BASE_URL . $link['page'];
              $active = ($current_page === $link['page']) ? 'nav-link-active' : 'text-neutral-content/70 hover:text-secondary';
            ?>
            <?php if (!empty($link['is_mega'])): ?>
              <div class="group relative">
                <a href="<?= $url ?>" class="mega-menu-trigger px-3 py-2 rounded text-sm font-medium flex items-center space-x-1 <?= $active ?>" aria-haspopup="true">
                  <i data-lucide="<?= $link['icon'] ?>" class="w-4 h-4"></i>
                  <span><?= $link['name'] ?></span>
                  <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-hover:rotate-180"></i>
                </a>
                <div class="mega-menu-container absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-md bg-neutral shadow-xl border-t-2 border-secondary rounded-b">
                  <div class="p-6 grid grid-cols-2 gap-4">
                    <?php foreach ($services as $s): ?>
                      <a href="<?= BASE_URL . $s['page'] ?>" class="flex items-start space-x-3 p-3 hover:bg-base-300 rounded transition">
                        <i data-lucide="<?= $s['icon'] ?>" class="w-6 h-6 text-secondary"></i>
                        <div>
                          <div class="font-semibold text-neutral-content"><?= $s['name'] ?></div>
                          <div class="text-xs text-neutral-content/70"><?= $s['desc'] ?></div>
                        </div>
                      </a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <a href="<?= $url ?>" class="px-3 py-2 rounded text-sm font-medium flex items-center space-x-1 <?= $active ?>">
                <i data-lucide="<?= $link['icon'] ?>" class="w-4 h-4"></i>
                <span><?= $link['name'] ?></span>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>

          <!-- Admin Panel Link -->
          <?php if (isset($_SESSION['admin_user_id'])): ?>
            <a href="<?= BASE_URL ?>admin/" class="px-3 py-2 rounded text-sm font-medium text-neutral-content/70 hover:text-secondary transition flex items-center">
              <i data-lucide="settings-2" class="w-4 h-4 mr-1"></i>Admin Panel
            </a>
            <a href="<?= BASE_URL ?>admin/index.php?admin_page=logout" class="ml-2 px-3 py-1.5 rounded text-sm font-medium bg-red-600 hover:bg-red-700 text-white flex items-center transition">
              <i data-lucide="log-out" class="w-4 h-4 mr-1"></i>Sign Out
            </a>
          <?php endif; ?>
        </nav>

        <!-- Mobile Toggle -->
        <div class="md:hidden">
          <button id="mobileMenuButton" aria-label="Toggle menu" class="text-neutral-content/70 hover:text-secondary p-2 rounded focus:outline-none transition">
            <i data-lucide="menu" id="mobileOpenIcon" class="w-7 h-7"></i>
            <i data-lucide="x" id="mobileCloseIcon" class="w-7 h-7 hidden"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu md:hidden bg-neutral border-t border-base-300 w-full absolute z-40">
      <nav class="px-2 pt-2 pb-4 space-y-1">
        <?php foreach ($nav_links as $link): ?>
          <?php 
            $url = BASE_URL . $link['page'];
            $active = ($current_page === $link['page']) ? 'text-secondary bg-base-300' : 'text-neutral-content/70 hover:text-secondary hover:bg-base-300';
          ?>
          <a href="<?= $url ?>" class="block px-3 py-3 rounded text-base font-medium flex items-center space-x-2 <?= $active ?>">
            <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5"></i>
            <span><?= $link['name'] ?></span>
          </a>

          <?php if (!empty($link['is_mega'])): ?>
            <div class="pl-6 space-y-1 border-l-2 border-base-300">
              <?php foreach ($services as $s): ?>
                <a href="<?= BASE_URL . $s['page'] ?>" class="block px-3 py-2 rounded text-sm text-neutral-content/70 hover:text-secondary hover:bg-base-300 flex items-center space-x-2">
                  <i data-lucide="<?= $s['icon'] ?>" class="w-4 h-4"></i>
                  <span><?= $s['name'] ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>

        <!-- Admin Mobile -->
        <div class="border-t border-base-300 pt-4 mt-4 space-y-2">
          <?php if (isset($_SESSION['admin_user_id'])): ?>
            <a href="<?= BASE_URL ?>admin/" class="block px-3 py-3 rounded text-base font-medium text-neutral-content/70 hover:text-secondary hover:bg-base-300">Admin Dashboard</a>
            <a href="<?= BASE_URL ?>admin/index.php?admin_page=logout" class="block w-full text-left px-3 py-3 rounded text-base font-medium bg-red-600 hover:bg-red-700 text-white">Sign Out</a>
          <?php else: ?>
            <a href="<?= BASE_URL ?>admin/" class="block px-3 py-3 rounded text-base font-medium text-neutral-content/70 hover:text-secondary hover:bg-base-300">Admin Login</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>

  <main class="flex-grow">
