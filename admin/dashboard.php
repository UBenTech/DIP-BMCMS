<?php
// admin/pages/dashboard.php
// This is included by admin/index.php, so $admin_page_title is set.
// Session should be started and auth check done by admin/index.php.

global $conn; // Access the database connection from db.php

// Example: Fetch some stats
$post_count_query = "SELECT COUNT(*) as total_posts FROM posts";
$post_count_result = $conn->query($post_count_query);
$total_posts = ($post_count_result && $post_count_result->num_rows > 0) ? $post_count_result->fetch_assoc()['total_posts'] : 0;

// Placeholder for other stats
$total_users = 0; // Replace with actual query if users table exists
$total_comments = 0; // Replace with actual query if comments table exists

?>
<div class="container mx-auto px-4 py-8">
    
    <div class="mb-8 p-6 bg-white rounded-lg shadow-lg border border-gray-200 animate-fade-in-up">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Welcome back, <?php echo isset($_SESSION['admin_username']) ? esc_html($_SESSION['admin_username']) : 'Admin'; ?>!</h2>
        <p class="text-gray-600">Here's a quick overview of your site:</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-admin-primary to-indigo-500 text-white p-6 rounded-xl shadow-xl transform hover:scale-105 transition-transform duration-300 animate-fade-in-up" style="animation-delay: 100ms;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wider opacity-80">Total Posts</p>
                    <p class="text-4xl font-bold"><?php echo $total_posts; ?></p>
                </div>
                <i data-lucide="file-text" class="w-12 h-12 opacity-50"></i>
            </div>
            <a href="<?php echo $admin_base_url; ?>index.php?admin_page=posts" class="block mt-4 text-sm opacity-90 hover:opacity-100 hover:underline">View Posts <i data-lucide="arrow-right" class="inline-block w-3 h-3"></i></a>
        </div>

        <div class="bg-gradient-to-br from-admin-secondary to-emerald-500 text-white p-6 rounded-xl shadow-xl transform hover:scale-105 transition-transform duration-300 animate-fade-in-up" style="animation-delay: 200ms;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wider opacity-80">Total Users</p>
                    <p class="text-4xl font-bold"><?php echo $total_users; ?></p>
                </div>
                <i data-lucide="users" class="w-12 h-12 opacity-50"></i>
            </div>
             <a href="<?php echo $admin_base_url; ?>index.php?admin_page=users" class="block mt-4 text-sm opacity-90 hover:opacity-100 hover:underline">Manage Users <i data-lucide="arrow-right" class="inline-block w-3 h-3"></i></a>
        </div>
        
        <div class="bg-gradient-to-br from-amber-500 to-yellow-400 text-white p-6 rounded-xl shadow-xl transform hover:scale-105 transition-transform duration-300 animate-fade-in-up" style="animation-delay: 300ms;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wider opacity-80">Pending Comments</p>
                    <p class="text-4xl font-bold"><?php echo $total_comments; ?></p>
                </div>
                <i data-lucide="message-square" class="w-12 h-12 opacity-50"></i>
            </div>
             <a href="#" class="block mt-4 text-sm opacity-90 hover:opacity-100 hover:underline">Moderate Comments <i data-lucide="arrow-right" class="inline-block w-3 h-3"></i></a>
        </div>
    </div>

    <div class="mb-8 bg-white p-6 rounded-lg shadow animate-fade-in-up" style="animation-delay: 400ms;">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <a href="<?php echo $admin_base_url; ?>index.php?admin_page=add_post" class="flex flex-col items-center justify-center p-4 bg-indigo-50 hover:bg-indigo-100 text-admin-primary rounded-lg shadow hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i data-lucide="plus-square" class="w-10 h-10 mb-2"></i>
                <span class="text-sm font-medium">Add New Post</span>
            </a>
            <a href="<?php echo $admin_base_url; ?>index.php?admin_page=posts" class="flex flex-col items-center justify-center p-4 bg-emerald-50 hover:bg-emerald-100 text-admin-secondary rounded-lg shadow hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i data-lucide="settings" class="w-10 h-10 mb-2"></i>
                <span class="text-sm font-medium">Manage Content</span>
            </a>
            </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow animate-fade-in-up" style="animation-delay: 500ms;">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Recent Activity</h3>
        <ul class="space-y-3">
            <li class="text-sm text-gray-600 border-b border-gray-100 pb-2">No recent activity to display.</li>
            </ul>
    </div>

</div>
