<?php
// includes/functions.php

/**
 * Loads site settings from a JSON file or returns defaults.
 */
function load_site_settings(): array {
    $settings_file_path = __DIR__ . '/../config/site_settings.json'; 
    
    $default_settings = [
        'site_name' => 'DIPUG', 
        'site_tagline' => 'Digital Innovation and Programing', 
        'posts_per_page' => 10,
        'contact_email' => 'info@dipug.com',
        'footer_copyright' => '&copy; {year} dipug.com. All Rights Reserved.',
    ];

    if (file_exists($settings_file_path)) {
        $json_data = file_get_contents($settings_file_path);
        $loaded_settings = json_decode($json_data, true);
        if (is_array($loaded_settings)) {
            return array_merge($default_settings, $loaded_settings);
        }
    }
    return $default_settings;
}

function esc_html(?string $string): string {
    return htmlspecialchars((string)$string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function esc_url(string $string): string {
    return urlencode($string);
}

function slugify(string $text, string $divider = '-'): string {
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, $divider);
    $text = preg_replace('~-+~', $divider, $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a-' . substr(md5(time() . random_bytes(4)), 0, 6);
    }
    return $text;
}

function generate_excerpt(string $content, int $length = 200, string $suffix = '...'): string {
    $content_no_tags = strip_tags($content); // Strip tags before generating excerpt
    if (mb_strlen($content_no_tags) <= $length) {
        return $content_no_tags;
    }
    $excerpt = mb_substr($content_no_tags, 0, $length);
    $last_space = mb_strrpos($excerpt, ' ');
    if ($last_space !== false) {
        $excerpt = mb_substr($excerpt, 0, $last_space);
    }
    return $excerpt . $suffix;
}

function format_date(?string $date_string, string $format = 'F j, Y'): string {
    if (empty($date_string) || $date_string === '0000-00-00 00:00:00') {
        return 'N/A';
    }
    try {
        $date = new DateTime($date_string);
        return $date->format($format);
    } catch (Exception $e) {
        return 'N/A'; 
    }
}

function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time']) || (time() - $_SESSION['csrf_token_time'] > 1800 )) { 
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token(string $token): bool {
    if (isset($_SESSION['csrf_token']) && isset($_SESSION['csrf_token_time']) && (time() - $_SESSION['csrf_token_time'] <= 1800) && hash_equals($_SESSION['csrf_token'], $token)) {
        return true;
    }
    unset($_SESSION['csrf_token']);
    unset($_SESSION['csrf_token_time']);
    return false;
}

function generate_csrf_input(): string {
    $token = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . esc_html($token) . '">';
}

function handle_file_upload(array $file_input, string $upload_dir, array $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], int $max_size = 2 * 1024 * 1024): string|array {
    $errors = [];
    if (!isset($file_input['error']) || is_array($file_input['error'])) {
        $errors[] = 'Invalid file upload parameters.'; return $errors;
    }
    switch ($file_input['error']) {
        case UPLOAD_ERR_OK: break;
        case UPLOAD_ERR_NO_FILE: return ''; 
        case UPLOAD_ERR_INI_SIZE: case UPLOAD_ERR_FORM_SIZE:
            $errors[] = 'Exceeded filesize limit.'; return $errors;
        default:
            $errors[] = 'Unknown file upload error. Code: ' . $file_input['error']; return $errors;
    }
    if ($file_input['size'] > $max_size) {
        $errors[] = 'Exceeded filesize limit (Max ' . ($max_size / 1024 / 1024) . 'MB).';
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file_input['tmp_name']);
    if (!in_array($mime_type, $allowed_types)) {
        $errors[] = 'Invalid file type. Allowed types: ' . implode(', ', $allowed_types);
    }
    if (!empty($errors)) { return $errors; }
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) { 
            $errors[] = 'Upload directory does not exist and could not be created.'; return $errors;
        }
    }
    if (!is_writable($upload_dir)) {
        $errors[] = 'Upload directory is not writable.'; return $errors;
    }
    $file_extension = strtolower(pathinfo($file_input['name'], PATHINFO_EXTENSION));
    $safe_filename_base = slugify(pathinfo($file_input['name'], PATHINFO_FILENAME)); 
    $new_filename = $safe_filename_base . '_' . bin2hex(random_bytes(8)) . '.' . $file_extension; 
    $destination = rtrim($upload_dir, '/') . '/' . $new_filename;
    if (!move_uploaded_file($file_input['tmp_name'], $destination)) {
        $errors[] = 'Failed to move uploaded file.'; return $errors;
    }
    return $new_filename;
}

/**
 * Generates a secure preview token for a post.
 * Stores it in the session.
 * @param int $post_id The ID of the post to generate a token for.
 * @return string The generated token.
 */
function generate_preview_token(int $post_id): string {
    $token = bin2hex(random_bytes(16));
    $_SESSION['preview_token_' . $post_id] = $token;
    $_SESSION['preview_token_time_' . $post_id] = time(); // Add expiry time
    return $token;
}

/**
 * Validates a preview token for a post.
 * @param int $post_id The ID of the post.
 * @param string $token The token to validate.
 * @return bool True if valid, false otherwise.
 */
function validate_preview_token(int $post_id, string $token): bool {
    $token_key = 'preview_token_' . $post_id;
    $time_key = 'preview_token_time_' . $post_id;
    // Token valid for, e.g., 1 hour (3600 seconds)
    if (isset($_SESSION[$token_key]) && isset($_SESSION[$time_key]) && 
        (time() - $_SESSION[$time_key] < 3600) && 
        hash_equals($_SESSION[$token_key], $token)) {
        // Optionally consume the token after one use
        // unset($_SESSION[$token_key], $_SESSION[$time_key]);
        return true;
    }
    return false;
}

?>
