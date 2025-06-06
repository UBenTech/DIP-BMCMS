<div class="bg-white dark:bg-base-200 rounded-lg shadow p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-neutral mb-2 md:mb-0">Manage Posts</h2>
        <a href="?admin_page=add_post" class="bg-accent hover:bg-accent-hover text-white px-5 py-2 rounded font-semibold shadow transition-all">
            + New Post
        </a>
    </div>
    <!-- Add search/filter inputs here -->
    <input type="search" placeholder="Search Posts..." class="input input-bordered mb-4 w-full md:w-1/3" />
    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr class="bg-base-300 text-secondary">
                <th class="p-3 text-left">Title</th>
                <th class="p-3 text-left">Author</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">SEO</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
        <!-- Loop posts here -->
        <?php foreach ($posts as $post): ?>
            <tr class="border-b border-neutral-lighter hover:bg-base-200">
                <td class="p-3"><?php echo esc_html($post['title']); ?></td>
                <td class="p-3"><?php echo esc_html($post['author']); ?></td>
                <td class="p-3">
                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                        <?php echo $post['status']=='published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                        <?php echo ucfirst($post['status']); ?>
                    </span>
                </td>
                <td class="p-3"><?php echo format_date($post['date']); ?></td>
                <td class="p-3">
                    <?php echo esc_html($post['seo_title'] ?? '—'); ?>
                </td>
                <td class="p-3 space-x-2">
                    <a href="?admin_page=edit_post&id=<?php echo $post['id']; ?>" class="text-primary hover:underline">Edit</a>
                    <a href="?admin_page=delete_post&id=<?php echo $post['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Delete this post?')">Delete</a>
                    <a href="/post/<?php echo $post['slug']; ?>" class="text-secondary hover:underline" target="_blank">Preview</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>