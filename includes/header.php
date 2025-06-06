<?php
// includes/header.php

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
    <title><?php echo esc_html($page_title); ?></title>
    <meta name="description" content="<?php echo esc_html($meta_description); ?>">
    <?php if (!empty($meta_keywords)): ?>
    <meta name="keywords" content="<?php echo esc_html($meta_keywords); ?>">
    <?php endif; ?>

    <script src="https://cdn.tailwindcss.com?plugins=typography,forms"></script> 
    <script>
        tailwind.config = {
            darkMode: 'class', 
            theme: {
                extend: {
                    colors: {
                        'primary': { DEFAULT: '#1d4ed8', 'hover': '#1e40af' },
                        'secondary': { DEFAULT: '#16a34a', 'hover': '#15803d' },
                        'accent': { DEFAULT: '#facc15', 'hover': '#eab308' },
                        'neutral': '#f8fafc',
                        'neutral-content': '#0f172a',
                        'neutral-focus': '#e2e8f0',
                        'neutral-light': '#e2e8f0',
                        'neutral-lighter': '#f1f5f9',
                        'base-100': '#ffffff',
                        'base-200': '#f1f5f9',
                        'base-300': '#e2e8f0',
                        'info': '#0ea5e9',
                        'success': '#10b981',
                        'warning': '#f97316',
                        'error': '#ef4444',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    transitionProperty: {
                        'height': 'height', 
                        'spacing': 'margin, padding', 
                        'max-height': 'max-height'
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards', 
                        'slide-in-left': 'slideInLeft 0.5s ease-out forwards',
                        'slide-down': 'slideDown 0.3s ease-out forwards',
                        'slide-up': 'slideUp 0.3s ease-out forwards'
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(-20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-100%)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '1', transform: 'translateY(0)' },
                            '100%': { opacity: '0', transform: 'translateY(-100%)' }
                        }
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
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #0f172a;
        }
        .font-display {
            font-family: 'Poppins', sans-serif;
        }
        .nav-link-active {
            color: #16a34a;
            font-weight: 600;
        }
        .mega-menu-container {
            display: none;
            opacity: 0;
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
            pointer-events: none;
            transform: translateY(5px);
        }
        .group:hover .mega-menu-container,
        .mega-menu-trigger:focus + .mega-menu-container,
        .mega-menu-container:hover {
            display: block;
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
        .mobile-menu {
            max-height: 0;
            overflow-y: auto;
            transition: max-height 0.4s cubic-bezier(0.25, 0.1, 0.25, 1);
        }
        .mobile-menu.open {
            max-height: calc(100vh - 4rem);
        }
    </style>
</head>
<body class="antialiased bg-base-100 text-neutral-content flex flex-col min-h-screen">
