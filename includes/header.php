<?php
$page_title = $page_title ?? (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_description = $meta_description ?? 'Welcome to ' . (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_keywords = $meta_keywords ?? '';

defined('BASE_URL') or define('BASE_URL', '/');
if (!defined('SITE_NAME')) {
    $site_settings_for_header_name = load_site_settings();
    define('SITE_NAME', $site_settings_for_header_name['site_name'] ?? 'dipug.com');
}

global $page;
$current_public_page = $page ?? ($_GET['page'] ?? 'home');

$services_menu_items_header = [
    ["name" => "Web Development", "page" => "webDev", "icon" => "code-xml", "desc" => "Modern websites & applications."],
    ["name" => "Software Solutions", "page" => "software", "icon" => "app-window", "desc" => "Custom software for your needs."],
    ["name" => "Online Courses", "page" => "courses", "icon" => "graduation-cap", "desc" => "Upskill with expert-led courses."],
    ["name" => "Tech Support", "page" => "support", "icon" => "life-buoy", "desc" => "Reliable IT assistance & consulting."],
    ["name" => "Cloud Solutions", "page" => "cloud", "icon" => "cloud-cog", "desc" => "Scalable cloud infrastructure."],
    ["name" => "Cybersecurity", "page" => "cybersecurity", "icon" => "shield-check", "desc" => "Protect your valuable digital assets."]
];
$main_nav_links = [
    ["name" => "Home", "page" => "home", "icon" => "home"],
    ["name" => "Services", "page" => "services_overview", "icon" => "layers", "is_mega_menu" => true],
    ["name" => "Portfolio", "page" => "portfolio", "icon" => "briefcase"],
    ["name" => "Blog", "page" => "blog", "icon" => "book-open"],
    ["name" => "Contact", "page" => "contact", "icon" => "mail"]
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc_html($page_title) ?></title>
  <meta name="description" content="<?= esc_html($meta_description) ?>">
  <?php if (!empty($meta_keywords)): ?>
    <meta name="keywords" content="<?= esc_html($meta_keywords) ?>">
  <?php endif; ?>

  <script src="https://cdn.tailwindcss.com?plugins=typography,forms"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#0056B3',
            secondary: '#10b981',
            highlight: '#F59E0B',
            accent: '#4B5563',
            base: '#F4F4F4',
            text: '#333333',
            dark: '#0f172a',
            dark-panel: '#1e293b'
          },
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            display: ['Poppins', 'sans-serif'],
          },
        }
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
  <link rel="icon" href="<?= BASE_URL ?>assets/favicon.ico" type="image/x-icon">
</head>

<body class="bg-base text-[var(--text)] font-sans min-h-screen flex flex-col">

<!-- Top bar -->
<div class="bg-white border-b border-gray-300 text-xs text-accent px-4 py-2">
  <div class="max-w-screen-xl mx-auto flex justify-between items-center">
    <div class="space-x-4">
      <a href="<?= BASE_URL ?>about" class="hover:text-highlight transition">About Us</a>
      <a href="<?= BASE_URL ?>contact" class="hover:text-highlight transition">Contact</a>
      <a href="<?= BASE_URL ?>privacy" class="hover:text-highlight transition">Privacy Policy</a>
    </div>
    <div class="space-x-3 flex items-center">
      <?php foreach (['facebook', 'twitter', 'linkedin', 'instagram'] as $icon): ?>
        <a href="#" aria-label="<?= ucfirst($icon) ?>" class="hover:text-highlight transition">
          <i data-lucide="<?= $icon ?>" class="w-4 h-4"></i>
        </a>
      <?php endforeach; ?>
      <?php if (!isset($_SESSION['admin_user_id'])): ?>
        <a href="<?= BASE_URL ?>admin/" class="ml-3 bg-primary text-white px-2 py-0.5 rounded text-xs hover:opacity-90 transition">Admin Login</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Main Header -->
<header class="bg-white shadow sticky top-0 z-50">
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
    <a href="<?= BASE_URL ?>" class="flex items-center text-primary font-display text-xl font-bold">
      <i data-lucide="cpu" class="w-6 h-6 mr-2"></i><?= SITE_NAME ?>
    </a>

    <nav class="hidden md:flex items-center space-x-4">
      <?php foreach ($main_nav_links as $link): 
        $link_url = rtrim(BASE_URL, '/') . '/' . $link['page'];
        $is_active = $current_public_page === $link['page'];
      ?>
        <a href="<?= $link_url ?>" class="text-sm px-3 py-2 rounded-md font-medium transition <?=
          $is_active ? 'text-primary font-semibold' : 'text-accent hover:text-highlight'
        ?>">
          <i data-lucide="<?= $link['icon'] ?>" class="w-4 h-4 mr-1 inline"></i><?= $link['name'] ?>
        </a>
      <?php endforeach; ?>

      <?php if (isset($_SESSION['admin_user_id'])): ?>
        <a href="<?= BASE_URL ?>admin/" class="text-accent hover:text-highlight text-sm px-3 py-2 rounded-md transition">Admin Panel</a>
        <a href="<?= BASE_URL ?>admin/index.php?admin_page=logout" class="ml-2 text-white bg-red-600 hover:bg-red-700 text-sm px-3 py-1 rounded transition">Sign Out</a>
      <?php endif; ?>
    </nav>

    <div class="md:hidden">
      <button id="mobileMenuButton" class="text-accent hover:text-highlight p-2">
        <i data-lucide="menu" class="w-6 h-6"></i>
      </button>
    </div>
  </div>
</header>

<!-- Mobile menu (JS toggle handled externally) -->
<div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200 shadow px-4 py-4 space-y-2">
  <?php foreach ($main_nav_links as $link): 
    $link_url = rtrim(BASE_URL, '/') . '/' . $link['page'];
    $is_active = $current_public_page === $link['page'];
  ?>
    <a href="<?= $link_url ?>" class="block text-base font-medium <?= $is_active ? 'text-primary font-semibold' : 'text-accent hover:text-highlight' ?>">
      <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5 inline mr-2"></i><?= $link['name'] ?>
    </a>
  <?php endforeach; ?>

  <?php if (!isset($_SESSION['admin_user_id'])): ?>
    <a href="<?= BASE_URL ?>admin/" class="block text-accent hover:text-highlight">Admin Login</a>
  <?php else: ?>
    <a href="<?= BASE_URL ?>admin/" class="block text-accent hover:text-highlight">Admin Panel</a>
    <a href="<?= BASE_URL ?>admin/index.php?admin_page=logout" class="block text-red-600 hover:text-red-700">Sign Out</a>
  <?php endif; ?>
</div>

<main class="flex-grow">
