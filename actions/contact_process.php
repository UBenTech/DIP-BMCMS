<?php
// actions/contact_process.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
require_once '../includes/functions.php'; // For esc_html, CSRF, load_site_settings
// No DB connection needed for basic mail sending, but might be for logging.

// Load site settings to get the recipient email
$site_settings = load_site_settings();
$recipient_email = $site_settings['contact_email'] ?? 'your-default-email@example.com'; // Fallback

defined('BASE_URL') or define('BASE_URL', '/');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact_form'])) {
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $_SESSION['contact_form_errors'] = ["CSRF token mismatch. Please try submitting the form again."];
        $_SESSION['contact_form_data'] = $_POST;
        header('Location: ' . BASE_URL . 'index.php?page=contact');
        exit;
    }

    $name = trim($_POST['contact_name']);
    $email = trim($_POST['contact_email']);
    $subject = trim($_POST['contact_subject']);
    $message = trim($_POST['contact_message']);
    
    $errors = [];

    if (empty($name)) { $errors[] = "Full Name is required."; }
    if (empty($email)) { $errors[] = "Email Address is required."; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Invalid Email Address format."; }
    if (empty($message)) { $errors[] = "Message is required."; }
    if (empty($subject)) { $subject = "New Contact Form Submission from " . SITE_NAME; } // Default subject

    // Basic spam check (honeypot - add a hidden field in the form later if needed)
    // if (!empty($_POST['honeypot_field'])) { /* Likely a bot */ exit; }


    if (!empty($errors)) {
        $_SESSION['contact_form_errors'] = $errors;
        $_SESSION['contact_form_data'] = $_POST;
        header('Location: ' . BASE_URL . 'index.php?page=contact#contact-form-section'); // Or however you ID the form
        exit;
    }

    // --- Send Email ---
    $to = $recipient_email;
    $email_subject = "Contact Form: " . strip_tags($subject) . " - from " . strip_tags($name);
    
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: " . strip_tags($name) . "\n";
    $email_body .= "Email: " . strip_tags($email) . "\n";
    $email_body .= "Subject: " . strip_tags($subject) . "\n\n";
    $email_body .= "Message:\n" . strip_tags($message) . "\n";
    
    $headers = "From: " . strip_tags($name) . " <" . strip_tags($email) . ">\r\n";
    $headers .= "Reply-To: " . strip_tags($email) . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    // For PHP mail() to work, your server needs a configured mail sending agent (like Sendmail or Postfix)
    // or you need to configure SMTP settings in php.ini.
    // For reliable email delivery, using a library like PHPMailer with SMTP is highly recommended.
    if (mail($to, $email_subject, $email_body, $headers)) {
        $_SESSION['contact_form_success'] = "Thank you for your message! We'll get back to you shortly.";
        // Clear form data from session on success
        unset($_SESSION['contact_form_data']); 
    } else {
        error_log("Mail sending failed. To: $to, Subject: $email_subject");
        $_SESSION['contact_form_errors'] = ["Sorry, there was an error sending your message. Please try again later or contact us directly at " . esc_html($recipient_email) . "."];
        $_SESSION['contact_form_data'] = $_POST; // Keep data if sending failed
    }

    header('Location: ' . BASE_URL . 'index.php?page=contact#contact-form-section'); // Redirect back to contact page
    exit;

} else {
    // Not a POST request or form not submitted correctly
    header('Location: ' . BASE_URL . 'index.php?page=contact');
    exit;
}
?>
