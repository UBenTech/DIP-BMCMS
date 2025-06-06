<?php
/**
 * Header template for the WordPress theme.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>">
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com?plugins=typography,forms"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {
              DEFAULT: '#0056B3',
              hover: '#004a99',
            },
            secondary: {
              DEFAULT: '#4B5563',
              hover: '#374151',
            },
            accent: {
              DEFAULT: '#F59E0B',
              hover: '#d97706',
            },
            neutral: '#F4F4F4',
            'neutral-content': '#333333',
            'neutral-focus': '#0056B3',
            'neutral-light': '#E5E7EB',
            'neutral-lighter': '#F9FAFB',
            'base-100': '#FFFFFF',
            'base-200': '#F4F4F4',
            'base-300': '#E5E7EB',
            info: '#22d3ee',
            success: '#34d399',
            warning: '#F59E0B',
            error: '#f87171'
          },
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            display: ['Poppins', 'sans-serif']
          },
          transitionProperty: {
            height: 'height',
            spacing: 'margin, padding',
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
    };
  </script>

  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" type="image/x-icon">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #0f172a;
      color: #e2e8f0;
    }
    .font-display {
      font-family: 'Poppins', sans-serif;
    }
    .nav-link-active {
      color: #10b981;
      font-weight: 600;
    }
    .mega-menu-container {
      display: none;
      opacity: 0;
      transform: translateY(5px);
      transition: opacity 0.2s ease-out, transform 0.2s ease-out;
      pointer-events: none;
    }
    .group:hover .mega-menu-container,
    .mega-menu-trigger:focus + .mega-menu-container,
    .mega-menu-container:hover {
      display: block;
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
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

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
