<?php
// admin/includes/sidebar.php

// $admin_page is defined in the calling script (admin/index.php)
// and is expected to be in the current scope when this file is included.
// We use it here to determine the active link.
$active_admin_page = $admin_page ?? ($_GET['admin_page'] ?? 'dashboard');

// Ensure BASE_URL and SITE_NAME are available (should be defined in admin/index.php)
defined('BASE_URL') or define('BASE_URL', '/'); // Fallback, but should be set
defined('SITE_NAME') or define('SITE_NAME', 'dipug.com'); // Fallback

$admin_base_url = BASE_URL . 'admin/';

$nav_items = [
    'dashboard' => ['icon' => 'layout-dashboard', 'text' => 'Dashboard'],
    'posts' => ['icon' => 'file-text', 'text' => 'Posts', 'sub_pages' => ['add_post', 'edit_post']],
    'categories' => ['icon' => 'folder-kanban', 'text' => 'Categories', 'sub_pages' => ['add_category', 'edit_category']],
    'comments' => ['icon' => 'messages-square', 'text' => 'Comments'], 
    'users' => ['icon' => 'users', 'text' => 'Users', 'sub_pages' => ['add_user', 'edit_user']],
    'settings' => ['icon' => 'settings', 'text' => 'Site Settings'], // Changed text slightly for clarity
];
?>
<aside id="adminSidebar" class="bg-admin-sidebar-bg text-admin-sidebar-text w-64 min-h-screen flex-shrink-0 flex flex-col transition-all duration-300 ease-in-out fixed md:relative -translate-x-full md:translate-x-0 z-50 md:z-auto print:hidden">
    <div class="h-16 flex items-center justify-center px-4 border-b border-gray-700 shadow-sm">
        <a href="<?php echo $admin_base_url; ?>index.php?admin_page=dashboard" class="flex items-center space-x-2">
            <i data-lucide="cpu" class="w-7 h-7 text-admin-secondary"></i>
            <span class="font-display text-lg font-semibold text-white"><?php echo esc_html(SITE_NAME); ?> Admin</span>
        </a>
    </div>

    <nav class="flex-grow px-2 py-4 space-y-1 overflow-y-auto">
        <?php foreach ($nav_items as $page_slug => $item): ?>
            <?php
                $is_active = ($active_admin_page === $page_slug);
                if (isset($item['sub_pages']) && in_array($active_admin_page, $item['sub_pages'])) {
                    $is_active = true; 
                }
            ?>
            <a href="<?php echo $admin_base_url; ?>index.php?admin_page=<?php echo $page_slug; ?>" 
               class="flex items-center px-3 py-2.5 rounded-md text-sm font-medium transition-colors group
                      <?php echo $is_active ? 'bg-admin-sidebar-active text-white shadow-md' : 'hover:bg-admin-sidebar-hover hover:text-white'; ?>">
                <i data-lucide="<?php echo $item['icon']; ?>" class="w-5 h-5 mr-3 shrink-0 group-hover:scale-110 transition-transform"></i>
                <span><?php echo esc_html($item['text']); ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="px-4 py-3 border-t border-gray-700 mt-auto">
        <p class="text-xs text-gray-400">&copy; <?php echo date('Y'); ?> <?php echo esc_html(SITE_NAME); ?></p>
    </div>
</aside>
