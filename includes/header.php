<?php
// includes/header.php

$page_title = $page_title ?? (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_description = $meta_description ?? 'Welcome to ' . (defined('SITE_NAME') ? SITE_NAME : 'dipug.com');
$meta_keywords = $meta_keywords ?? '';

defined('BASE_URL') or define('BASE_URL', '/');
// Ensure SITE_NAME is defined, falling back if necessary
// This might already be defined in your main index.php after loading settings
if (!defined('SITE_NAME')) {
    $site_settings_for_header_name = load_site_settings(); // Assumes load_site_settings() is available via functions.php
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
    <title><?php echo esc_html($page_title); ?></title>

    <meta name="description" content="<?php echo esc_html($meta_description); ?>">
    <?php if (!empty($meta_keywords)): ?>
    <meta name="keywords" content="<?php echo esc_html($meta_keywords); ?>">
    <?php endif; ?>

    <script src="https://cdn.tailwindcss.com?plugins=typography,forms"></script>
    <script>
        tailwind.config = {
            darkMode: 'media', // Use 'media' for system preference, or 'class' if you implement a theme switcher
            theme: {
                extend: {
                    colors: {
                        // New Color Palette based on user's request:
                        'primary': { DEFAULT: '#0056b3', 'hover': '#004494' }, // Blue
                        'secondary': { DEFAULT: '#10b981', 'hover': '#059669' }, // Keeping original secondary (Emerald)
                        'accent': { DEFAULT: '#d14', 'hover': '#b71234' }, // Code Accent (Reddish)
                        'neutral': '#fff', // White for containers
                        'neutral-content': '#333', // Dark text for light background
                        'neutral-focus': '#f0f0f0', // Light gray for hover/focus states
                        'neutral-light': '#eee', // Lighter gray, e.g., for pre backgrounds
                        'neutral-lighter': '#ddd', // Even lighter gray, e.g., for borders
                        'base-100': '#f4f4f4', // Main background color (light gray)
                        'base-200': '#fff', // Card/container background (white) - duplicate of neutral
                        'base-300': '#eee', // Light gray for pre/code backgrounds - duplicate of neutral-light
                        'info': '#22d3ee', 'success': '#34d399', 'warning': '#fbb_f24', 'error': '#f87171',
                        // Custom color for strong if needed, otherwise it will inherit neutral-content
                        'text-strong': '#555',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', '"Noto Sans"', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    transitionProperty: { 'height': 'height', 'spacing': 'margin, padding', 'max-height': 'max-height' },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                        'slide-in-left': 'slideInLeft 0.5s ease-out forwards',
                        'slide-down': 'slideDown 0.3s ease-out forwards',
                        'slide-up': 'slideUp 0.3s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideInLeft: { '0%': { opacity: '0', transform: 'translateX(-20px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        slideDown: { '0%': { opacity: '0', transform: 'translateY(-100%)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideUp: { '0%': { opacity: '1', transform: 'translateY(0)' }, '100%': { opacity: '0', transform: 'translateY(-100%)' } },
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/favicon.ico" type="image/x-icon">

    <style>
        /* These styles override/complement Tailwind based on the new palette */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--tw-colors-base-100); /* Use Tailwind defined base-100 */
            color: var(--tw-colors-neutral-content); /* Use Tailwind defined neutral-content */
        }
        .font-display { font-family: 'Poppins', sans-serif; }
        .nav-link-active { color: var(--tw-colors-secondary); font-weight: 600; } /* Use Tailwind defined secondary */

        /* Specific styles from your snippet, mapped to new Tailwind colors */
        .container {
            background: var(--tw-colors-neutral); /* White background for containers */
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2, h3 {
            color: var(--tw-colors-primary); /* Blue for headings */
        }
        pre {
            background-color: var(--tw-colors-neutral-light); /* Lighter gray for pre background */
            border: 1px solid var(--tw-colors-neutral-lighter); /* Even lighter gray for borders */
            border-left: 5px solid var(--tw-colors-primary); /* Blue for pre left border */
        }
        code {
            color: var(--tw-colors-accent); /* Reddish for code */
        }
        strong {
            color: var(--tw-colors-text-strong); /* Darker gray for strong */
        }


        /* Existing styles below */
        .mega-menu-container { display: none; opacity: 0; transition: opacity 0.2s ease-out, transform 0.2s ease-out; pointer-events: none; transform: translateY(5px); }
        .group:hover .mega-menu-container,
        .mega-menu-trigger:focus + .mega-menu-container,
        .mega-menu-container:hover { display: block; opacity: 1; pointer-events: auto; transform: translateY(0); }
        .mobile-menu { max-height: 0; overflow-y: auto; transition: max-height 0.4s cubic-bezier(0.25, 0.1, 0.25, 1); }
        .mobile-menu.open { max-height: calc(100vh - 4rem); }
    </style>
</head>
<body class="antialiased bg-base-100 text-neutral-content flex flex-col min-h-screen">

    <div class="bg-neutral text-slate-400 py-2 px-4 sm:px-6 lg:px-8 border-b border-neutral-light text-xs print:hidden">
        <div class="container mx-auto flex flex-wrap justify-between items-center">
            <div class="flex space-x-4 mb-1 sm:mb-0">
                <a href="<?php echo rtrim(BASE_URL, '/'); ?>/about" class="hover:text-secondary transition-colors">About Us</a>
                <a href="<?php echo rtrim(BASE_URL, '/'); ?>/contact" class="hover:text-secondary transition-colors">Contact</a>
                <a href="<?php echo rtrim(BASE_URL, '/'); ?>/privacy" class="hover:text-secondary transition-colors">Privacy Policy</a>
            </div>
            <div class="flex space-x-3 items-center"> {/* Added items-center */}
                <a href="#" aria-label="Facebook" class="hover:text-secondary transition-colors"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                <a href="#" aria-label="Twitter" class="hover:text-secondary transition-colors"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                <a href="#" aria-label="LinkedIn" class="hover:text-secondary transition-colors"><i data-lucide="linkedin" class="w-4 h-4"></i></a>
                <a href="#" aria-label="Instagram" class="hover:text-secondary transition-colors"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                <?php if (!isset($_SESSION['admin_user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>admin/" class="ml-3 px-2 py-0.5 rounded text-xs bg-secondary hover:bg-secondary-hover text-white transition-colors">Admin Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <header id="mainNav" class="bg-base-200/80 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-neutral-light/50 print:hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="<?php echo rtrim(BASE_URL, '/'); ?>/" class="flex items-center space-x-2 shrink-0">
                    <i data-lucide="cpu" class="w-8 h-8 text-secondary"></i>
                    <span class="font-display text-xl sm:text-2xl font-bold text-slate-100 hover:text-secondary transition-colors"><?php echo SITE_NAME; ?></span>
                </a>

                <nav class="hidden md:flex items-center space-x-1">
                    <?php foreach($main_nav_links as $link_item): ?>
                        <?php $link_url = rtrim(BASE_URL, '/') . '/' . $link_item['page']; ?>
                        <?php if (isset($link_item['is_mega_menu']) && $link_item['is_mega_menu']): ?>
                            <div class="group relative">
                                <a href="<?php echo $link_url; // Link to the services overview page ?>"
                                   aria-haspopup="true" aria-expanded="false"
                                   class="mega-menu-trigger px-3 py-2 rounded-md text-sm font-medium <?php echo (in_array($current_public_page, [$link_item['page'], 'webDev', 'software', 'courses', 'support', 'cloud', 'cybersecurity']) ? 'nav-link-active' : 'text-neutral-content hover:bg-neutral-focus hover:text-secondary'); ?> transition-colors flex items-center space-x-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-base-200 focus:ring-secondary">
                                    <i data-lucide="<?php echo $link_item['icon']; ?>" class="w-4 h-4 mr-1"></i>
                                    <span><?php echo esc_html($link_item['name']); ?></span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 ml-1 group-hover:rotate-180 transition-transform"></i>
                                </a>
                                <div class="mega-menu-container absolute top-full left-1/2 transform -translate-x-1/2 mt-0 w-max min-w-[560px] pt-1">
                                    <div class="bg-neutral shadow-2xl rounded-b-lg border-t-2 border-secondary p-6 grid grid-cols-2 gap-x-6 gap-y-4">
                                        <?php foreach($services_menu_items_header as $s_item): ?>
                                        <a href="<?php echo rtrim(BASE_URL, '/') . '/' . $s_item['page']; ?>" class="p-3 hover:bg-neutral-focus rounded-lg group/item flex items-start space-x-3 transition-colors">
                                            <i data-lucide="<?php echo $s_item['icon']; ?>" class="w-6 h-6 text-secondary mt-1 shrink-0"></i>
                                            <div><span class="font-semibold text-neutral-content group-hover/item:text-primary block text-base"><?php echo esc_html($s_item['name']); ?></span><span class="text-xs text-text-strong block"><?php echo esc_html($s_item['desc'] ?? ''); ?></span></div>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo $link_url; ?>" class="px-3 py-2 rounded-md text-sm font-medium <?php echo ($current_public_page === $link_item['page'] ? 'nav-link-active' : 'text-neutral-content hover:bg-neutral-focus hover:text-secondary'); ?> transition-colors flex items-center space-x-1">
                                <i data-lucide="<?php echo $link_item['icon']; ?>" class="w-4 h-4 mr-1"></i>
                                <span><?php echo esc_html($link_item['name']); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if (isset($_SESSION['admin_user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>admin/" class="px-3 py-2 rounded-md text-sm font-medium text-neutral-content hover:bg-neutral-focus hover:text-secondary transition-colors flex items-center space-x-1"><i data-lucide="settings-2" class="w-4 h-4 mr-1"></i>Admin Panel</a>
                        <a href="<?php echo BASE_URL; ?>admin/index.php?admin_page=logout" class="ml-2 px-3 py-1.5 rounded-md text-sm font-medium bg-red-600 hover:bg-red-700 text-white transition-colors flex items-center space-x-1"><i data-lucide="log-out" class="w-4 h-4 mr-1"></i>Sign Out</a>
                    <?php endif; ?>
                </nav>

                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" aria-label="Open Menu" aria-expanded="false" aria-controls="mobileMenu" class="text-neutral-content hover:text-secondary focus:outline-none p-2 rounded-md hover:bg-neutral-focus">
                        <i id="mobileMenuIconOpen" data-lucide="menu" class="w-7 h-7 block"></i>
                        <i id="mobileMenuIconClose" data-lucide="x" class="w-7 h-7 hidden"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobileMenu" class="mobile-menu md:hidden bg-neutral border-t border-neutral-lighter/50 absolute w-full shadow-xl left-0">
            <nav class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <?php foreach($main_nav_links as $link_item): ?>
                     <?php $link_url_mobile = rtrim(BASE_URL, '/') . '/' . $link_item['page']; ?>
                     <a href="<?php echo $link_url_mobile; ?>" class="block px-3 py-3 rounded-md text-base font-medium <?php echo ($current_public_page === $link_item['page'] ? 'text-secondary bg-neutral-focus' : 'text-neutral-content hover:bg-neutral-focus hover:text-secondary'); ?> transition-colors flex items-center space-x-2">
                        <i data-lucide="<?php echo $link_item['icon']; ?>" class="w-5 h-5"></i>
                        <span><?php echo esc_html($link_item['name']); ?></span>
                    </a>
                    <?php if (isset($link_item['is_mega_menu']) && $link_item['is_mega_menu']): ?>
                        <div class="pl-5 space-y-1 border-l-2 border-neutral-focus ml-2.5 mb-2">
                        <?php foreach($services_menu_items_header as $s_item): ?>
                            <a href="<?php echo rtrim(BASE_URL, '/') . '/' . $s_item['page']; ?>" class="block px-3 py-2 rounded-md text-sm font-medium text-neutral-content hover:bg-neutral-focus hover:text-secondary transition-colors flex items-center space-x-2">
                                <i data-lucide="<?php echo $s_item['icon']; ?>" class="w-4 h-4"></i>
                                <span><?php echo esc_html($s_item['name']); ?></span>
                            </a>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="border-t border-neutral-lighter pt-4 mt-4 space-y-2">
                    <?php if (isset($_SESSION['admin_user_id'])): ?>
                         <a href="<?php echo BASE_URL; ?>admin/" class="block px-3 py-3 rounded-md text-base font-medium text-neutral-content hover:bg-neutral-focus hover:text-secondary transition-colors">Admin Dashboard</a>
                        <a href="<?php echo BASE_URL; ?>admin/index.php?admin_page=logout" class="block w-full text-left px-3 py-3 rounded-md text-base font-medium bg-red-600 hover:bg-red-700 text-white transition-colors">Sign Out</a>
                    <?php else: ?>
                         <a href="<?php echo BASE_URL; ?>admin/" class="block px-3 py-3 rounded-md text-base font-medium text-neutral-content hover:bg-neutral-focus hover:text-secondary transition-colors">Admin Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
<main class="flex-grow">