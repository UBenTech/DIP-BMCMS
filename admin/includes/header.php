<?php
// admin/includes/header.php

// $admin_page_title is set in admin/index.php
// $admin_page (for TinyMCE condition) is also set in admin/index.php
$current_admin_page_for_header = $admin_page ?? ($_GET['admin_page'] ?? 'dashboard');


// Ensure BASE_URL and SITE_NAME are available (should be defined in admin/index.php after loading settings)
defined('BASE_URL') or define('BASE_URL', '/'); 
defined('SITE_NAME') or define('SITE_NAME', 'dipug.com'); 

$admin_base_url = BASE_URL . 'admin/';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($admin_page_title); ?> | <?php echo esc_html(SITE_NAME); ?> Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                     colors: {
                        'admin-primary': '#4338ca', // Indigo-700
                        'admin-secondary': '#059669', // Emerald-600
                        'admin-bg': '#f3f4f6',       // Gray-100 (light background for admin)
                        'admin-text': '#1f2937',     // Gray-800
                        'admin-sidebar-bg': '#1f2937', // Gray-800
                        'admin-sidebar-text': '#d1d5db', // Gray-300
                        'admin-sidebar-hover': '#374151', // Gray-700
                        'admin-sidebar-active': '#4f46e5', // Indigo-600 (matching primary a bit more)
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', '"Noto Sans"', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'], 
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lucide-static@latest/dist/lucide.min.js"></script>
    
    <?php if ($current_admin_page_for_header === 'add_post' || $current_admin_page_for_header === 'edit_post'): ?>
    <script src="https://cdn.tiny.cloud/1/8p9b08ie4vj71jyp1rcn5fubk9tukzougnjrla69sgyox9z0/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin_style.css"> 
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/favicon.ico" type="image/x-icon">

    <style>
        /* Minimal essential styles if admin_style.css is not comprehensive */
        .admin-content { transition: margin-left 0.3s ease-in-out; }
        /* Sidebar toggle classes would be handled by JS if implementing dynamic collapse for desktop */
        .tox-tinymce { border-radius: 0.375rem; border-width: 1px; border-color: #D1D5DB; } /* Tailwind gray-300 */
    </style>
</head>
<body class="bg-admin-bg text-admin-text font-sans">
    <div class="flex h-screen overflow-hidden"> 
        <?php include_once 'sidebar.php'; // Include the sidebar ?>
        
        <div class="flex-1 flex flex-col overflow-hidden"> 
            <header class="bg-white shadow-md p-4 flex justify-between items-center border-b print:hidden flex-shrink-0">
                <div class="flex items-center">
                    <button id="adminSidebarToggle" class="p-2 rounded-md text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-admin-primary md:hidden mr-2">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-700"><?php echo esc_html($admin_page_title); ?></h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden sm:inline">
                        Welcome, <?php echo isset($_SESSION['admin_full_name']) && !empty($_SESSION['admin_full_name']) ? esc_html($_SESSION['admin_full_name']) : (isset($_SESSION['admin_username']) ? esc_html($_SESSION['admin_username']) : 'Admin'); ?>!
                    </span>
                    <a href="<?php echo BASE_URL; ?>" target="_blank" title="View Live Site" class="text-sm text-admin-secondary hover:underline flex items-center">
                        <i data-lucide="external-link" class="w-4 h-4 mr-1"></i>View Site
                    </a>
                    <a href="<?php echo $admin_base_url; ?>index.php?admin_page=logout" class="text-sm text-red-600 hover:text-red-800 flex items-center bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-md transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4 mr-1.5"></i>Logout
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-admin-bg p-4 sm:p-6">
                