<?php
// admin/header.php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header("Location: ../index.php?page=admin&admin_page=login");
    exit;
}
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

// Fetch the logged‐in admin’s name (optional, adjust to your user table structure)
$admin_name = "Administrator";
$user_id    = $_SESSION['admin_user_id'];
$stmt       = $conn->prepare("SELECT name FROM users WHERE id = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        $row        = $res->fetch_assoc();
        $admin_name = $row['name'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin · <?= esc_html(SITE_NAME); ?></title>
  <!-- Tailwind + plugins for Admin -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  <script>
    tailwind.config = {
      darkMode: false,
      theme: {
        extend: {
          colors: {
            primary: { DEFAULT: '#6366f1', hover: '#4f46e5' },
            secondary: { DEFAULT: '#10b981', hover: '#059669' },
            accent: { DEFAULT: '#f59e0b', hover: '#d97706' },
            neutral: '#1e293b',
            'neutral-light': '#334155',
            'neutral-lighter': '#475569',
            'base-100': '#FFFFFF',
            'base-200': '#F4F4F4',
            'base-300': '#E5E7EB',
            info: '#22d3ee',
            success: '#34d399',
            warning: '#fbbf24',
            error: '#f87171',
          },
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', '"Noto Sans"', 'sans-serif'],
            display: ['Poppins', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-base-200 text-text antialiased flex h-screen overflow-hidden">
  <!-- Sidebar -->
  <aside class="w-64 bg-neutral text-base-100 flex-shrink-0">
    <div class="p-6">
      <a href="<?= BASE_URL; ?>" class="flex items-center space-x-2">
        <i data-lucide="cpu" class="w-6 h-6 text-secondary"></i>
        <span class="font-display text-xl font-bold">DIPUG Admin</span>
      </a>
    </div>
    <nav class="px-4 space-y-2">
      <a href="index.php" class="block px-4 py-2 rounded-md hover:bg-neutral-lighter <?= ($admin_page ?? '') === 'dashboard' ? 'bg-neutral-light text-text font-semibold' : '' ?>">
        <i data-lucide="home" class="w-5 h-5 inline-block mr-2"></i> Dashboard
      </a>
      <a href="posts.php" class="block px-4 py-2 rounded-md hover:bg-neutral-lighter <?= strpos($_SERVER['REQUEST_URI'], 'posts.php') !== false ? 'bg-neutral-light text-text font-semibold' : '' ?>">
        <i data-lucide="file-text" class="w-5 h-5 inline-block mr-2"></i> Posts
      </a>
      <a href="categories.php" class="block px-4 py-2 rounded-md hover:bg-neutral-lighter <?= strpos($_SERVER['REQUEST_URI'], 'categories.php') !== false ? 'bg-neutral-light text-text font-semibold' : '' ?>">
        <i data-lucide="layers" class="w-5 h-5 inline-block mr-2"></i> Categories
      </a>
      <a href="comments.php" class="block px-4 py-2 rounded-md hover:bg-neutral-lighter <?= strpos($_SERVER['REQUEST_URI'], 'comments.php') !== false ? 'bg-neutral-light text-text font-semibold' : '' ?>">
        <i data-lucide="message-circle" class="w-5 h-5 inline-block mr-2"></i> Comments
      </a>
      <a href="users.php" class="block px-4 py-2 rounded-md hover:bg-neutral-lighter <?= strpos($_SERVER['REQUEST_URI'], 'users.php') !== false ? 'bg-neutral-light text-text font-semibold' : '' ?>">
        <i data-lucide="users" class="w-5 h-5 inline-block mr-2"></i> Users
      </a>
      <a href="site_settings.php" class="block px-4 py-2 rounded-md hover:bg-neutral-lighter <?= strpos($_SERVER['REQUEST_URI'], 'site_settings.php') !== false ? 'bg-neutral-light text-text font-semibold' : '' ?>">
        <i data-lucide="settings" class="w-5 h-5 inline-block mr-2"></i> Site Settings
      </a>
    </nav>
    <div class="absolute bottom-0 w-full px-6 py-4 border-t border-neutral-lighter/50">
      <p class="text-sm text-text/70">Logged in as:</p>
      <p class="font-medium text-text mt-1"><?= esc_html($admin_name); ?></p>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col overflow-y-auto">
    <!-- Topbar -->
    <header class="flex items-center justify-between bg-base-100 px-6 py-4 border-b border-neutral-lighter/50">
      <h2 class="text-2xl font-display font-semibold text-text">Manage Posts</h2>
      <div class="flex space-x-3">
        <a href="<?= BASE_URL; ?>" target="_blank" class="text-sm font-medium text-secondary hover:text-secondary-hover transition-colors">
          View Site
        </a>
        <form action="logout.php" method="POST">
          <?= generate_csrf_input(); ?>
          <button type="submit" class="inline-flex items-center space-x-1 px-4 py-2 bg-error hover:bg-error-hover text-white rounded-md shadow-sm transition-colors text-sm">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </header>

    <!-- Flash Messages -->
    <div class="px-6 py-4">
      <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-4 px-4 py-3 bg-success/20 border border-success text-success rounded-md">
          <?= esc_html($_SESSION['flash_success']); ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
      <?php endif; ?>
      <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 px-4 py-3 bg-error/10 border border-error text-error rounded-md">
          <?= esc_html($_SESSION['flash_error']); ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
      <?php endif; ?>
    </div>
