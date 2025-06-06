<?php
// admin/pages/login.php
// This page will have its own full HTML structure, not using admin header/footer.
defined('BASE_URL') or define('BASE_URL', '/');
$admin_base_url = BASE_URL . 'admin/';

$error_message = '';
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Clear error after displaying
}
$redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : ($admin_base_url . 'index.php?admin_page=dashboard');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?php echo SITE_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { /* Minimal config for login page */
            theme: { extend: { colors: { 'admin-primary': '#4338ca', 'admin-secondary': '#059669' } } }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/lucide-static@latest/dist/lucide.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #e5e7eb; /* gray-200 */ } </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl w-full max-w-md transform transition-all hover:scale-[1.01] duration-300">
        <div class="text-center mb-8">
            <a href="<?php echo BASE_URL; ?>" class="inline-flex items-center space-x-2">
                <i data-lucide="cpu" class="w-10 h-10 text-admin-primary"></i>
                <span class="text-2xl font-bold text-gray-800"><?php echo SITE_NAME; ?> Admin</span>
            </a>
        </div>

        <?php if ($error_message): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <p><?php echo esc_html($error_message); ?></p>
            </div>
        <?php endif; ?>

        <form action="<?php echo $admin_base_url; ?>index.php?admin_page=login_process" method="POST" class="space-y-6">
            <input type="hidden" name="redirect_url" value="<?php echo esc_html($redirect_url); ?>">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username or Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                    </span>
                    <input type="text" name="username" id="username" required 
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-admin-primary focus:border-admin-primary sm:text-sm transition-colors"
                           placeholder="your_username">
                </div>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                 <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                    </span>
                    <input type="password" name="password" id="password" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-admin-primary focus:border-admin-primary sm:text-sm transition-colors"
                           placeholder="••••••••">
                </div>
            </div>
            <div>
                <button type="submit" 
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-admin-primary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-primary transition-all duration-150 ease-in-out transform hover:scale-105">
                    <i data-lucide="log-in" class="w-5 h-5 mr-2"></i>
                    Sign In
                </button>
            </div>
        </form>
        <p class="mt-8 text-center text-xs text-gray-500">
            <a href="<?php echo BASE_URL; ?>" class="hover:underline">← Back to <?php echo SITE_NAME; ?></a>
        </p>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
