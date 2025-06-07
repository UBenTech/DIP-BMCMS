<?php
// includes/config.php

// Define BASE_URL dynamically for public_html as the document root
if (!defined('BASE_URL')) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $base_path = '/'; // Root of the domain
    
    define('BASE_URL', $protocol . "://" . $host . $base_path);
}

// Load site settings from JSON
// This path is relative to includes/config.php -> public_html/config/site_settings.json
$settings_file_path = __DIR__ . '/../config/site_settings.json';
$site_settings = [];
if (file_exists($settings_file_path)) {
    $json_data = file_get_contents($settings_file_path);
    if ($json_data !== false) {
        $loaded_settings = json_decode($json_data, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($loaded_settings)) {
            $site_settings = $loaded_settings;
        }
    }
}

// Default settings if file not found or invalid
$default_settings = [
    'site_name'          => 'DIPUG',
    'site_tagline'       => 'Digital Innovation and Programming',
    'posts_per_page'     => 10,
    'contact_email'      => 'info@dipug.com',
    'footer_copyright'   => '&copy; {year} dipug.com. All Rights Reserved.',
];

// Merge loaded settings with defaults
$settings = array_merge($default_settings, $site_settings);

defined('SITE_NAME') or define('SITE_NAME', $settings['site_name']);
defined('SITE_TAGLINE') or define('SITE_TAGLINE', $settings['site_tagline']);
defined('POSTS_PER_PAGE') or define('POSTS_PER_PAGE', $settings['posts_per_page']);
defined('CONTACT_EMAIL') or define('CONTACT_EMAIL', $settings['contact_email']);
defined('FOOTER_COPYRIGHT') or define('FOOTER_COPYRIGHT', str_replace('{year}', date('Y'), $settings['footer_copyright']));

?>