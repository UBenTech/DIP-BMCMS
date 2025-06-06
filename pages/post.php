<?php
// pages/post.php
global $conn;
global $page_title;
global $meta_description;
global $meta_keywords;
global $site_settings;

$post_data = null;
$is_preview = false;
$base_blog_url_for_return = rtrim(BASE_URL, '/') . '/blog';


if (isset($_GET['preview_id']) && isset($_GET['token']) && isset($_SESSION['admin_user_id'])) {
    $preview_post_id = (int)$_GET['preview_id'];
    $preview_token = $_GET['token'];
    if (validate_preview_token($preview_post_id, $preview_token)) {
        $is_preview = true;
        $sql = "SELECT posts.*, categories.name as category_name, categories.slug as category_slug
                FROM posts
                LEFT JOIN categories ON posts.category_id = categories.id
                WHERE posts.id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if ($stmt) $stmt->bind_param("i", $preview_post_id);
    } else {
         $meta_description = "Invalid or expired preview link.";
    }
} else {
    $post_slug_or_id = isset($_GET['slug']) ? $_GET['slug'] : (isset($_GET['id']) ? $_GET['id'] : null);
    if ($post_slug_or_id) {
        $sql = "SELECT posts.*, categories.name as category_name, categories.slug as category_slug
                FROM posts
                LEFT JOIN categories ON posts.category_id = categories.id
                WHERE posts.status = 'published' AND ";

        if (isset($_GET['slug'])) { // Slug is present due to .htaccess rewrite
            $sql .= "posts.slug = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            if ($stmt) $stmt->bind_param("s", $post_slug_or_id);
        } else { // Fallback if accessed via ?page=post&id= (should be rare with .htaccess)
            $post_id_int = (int)$post_slug_or_id;
            $sql .= "posts.id = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            if ($stmt) $stmt->bind_param("i", $post_id_int);
        }
    }
}

if (isset($stmt) && $stmt) {
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $post_data = $result->fetch_assoc();
            $page_title = esc_html($post_data['title']) . ($is_preview ? " (Preview)" : "") . " - Blog | " . SITE_NAME;

            if (!empty($post_data['meta_description'])) {
                $meta_description = esc_html($post_data['meta_description']);
            } elseif (!empty($post_data['excerpt'])) {
                $meta_description = esc_html(generate_excerpt($post_data['excerpt'], 160, ''));
            } else {
                $meta_description = esc_html(generate_excerpt($post_data['content'], 160, ''));
            }
            $meta_keywords = !empty($post_data['meta_keywords']) ? esc_html($post_data['meta_keywords']) : '';
        }
    } else {
        error_log("Error executing single post statement: " . $stmt->error);
    }
    $stmt->close();
} elseif (!isset($stmt) && !$is_preview && isset($post_slug_or_id)) {
     error_log("Error preparing statement for single post: " . $conn->error);
}


if (empty($meta_description) && !$post_data && isset($site_settings['site_tagline'])) {
    $meta_description = esc_html($site_settings['site_tagline']);
} elseif (empty($meta_description) && !$post_data) {
    $meta_description = "The requested content could not be found on " . SITE_NAME;
}
if (!isset($meta_keywords)) {
    $meta_keywords = '';
}

?>
<?php
// Add Canonical URL for SEO
if ($post_data && !empty($post_data['slug'])) {
    $canonical_url = rtrim(BASE_URL, '/') . '/' . esc_html($post_data['slug']);
    echo '<link rel="canonical" href="' . $canonical_url . '" />' . "\n";
}
?>

<div class="bg-neutral-light/10 py-12 md:py-16 animate-fade-in-up">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($is_preview && $post_data): ?>
            <div class="mb-6 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-md text-sm text-center">
                <i data-lucide="alert-triangle" class="inline-block w-4 h-4 mr-1"></i>
                You are viewing a DRAFT PREVIEW. This post is not yet published.
                <?php if ($post_data['status'] !== 'draft') echo " (Current status: " . esc_html($post_data['status']) . ")"; ?>
            </div>
        <?php endif; ?>

        <?php if ($post_data): ?>
            <article class="max-w-3xl mx-auto bg-neutral p-6 sm:p-8 md:p-10 rounded-xl shadow-2xl">
                <header class="mb-8 pb-6 border-b border-neutral-light/50">
                    <?php if(!empty($post_data['category_name']) && !empty($post_data['category_slug'])):
                        $category_pretty_url_post = rtrim(BASE_URL, '/') . '/blog/category/' . esc_html($post_data['category_slug']);
                    ?>
                    <a href="<?php echo $category_pretty_url_post; ?>" class="text-sm font-semibold uppercase tracking-wider text-secondary hover:text-teal-400 transition-colors"><?php echo esc_html($post_data['category_name']); ?></a>
                    <?php endif; ?>
                    <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-100 mt-3 mb-4 leading-tight"><?php echo esc_html($post_data['title']); ?></h1>
                    <div class="flex items-center text-slate-400 text-sm space-x-4">
                        <span><i data-lucide="calendar-days" class="inline-block w-4 h-4 mr-1.5 relative -top-px"></i>Published on <?php echo format_date($post_data['created_at']); ?></span>
                        <?php if($post_data['updated_at'] && format_date($post_data['updated_at']) !== format_date($post_data['created_at'])): ?>
                            <span><i data-lucide="edit-3" class="inline-block w-4 h-4 mr-1.5 relative -top-px"></i>Updated on <?php echo format_date($post_data['updated_at']); ?></span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (!empty($post_data['featured_image'])): ?>
                    <figure class="mb-8 rounded-lg overflow-hidden shadow-lg aspect-video">
                        <img src="<?php echo BASE_URL . 'uploads/' . esc_html($post_data['featured_image']); ?>" alt="<?php echo esc_html($post_data['title']); ?>" class="w-full h-full object-cover" onError="this.style.display='none'; this.parentElement.innerHTML = '<div class=\'w-full h-full bg-neutral-light flex items-center justify-center text-slate-500\'><i data-lucide=\'image-off\' class=\'w-16 h-16\'></i><p>Image not found</p></div>'; lucide.createIcons();">
                    </figure>
                <?php endif; ?>

                <div class="prose prose-lg prose-invert max-w-none
                            prose-headings:font-display prose-headings:text-slate-100
                            prose-p:text-slate-300 prose-p:leading-relaxed
                            prose-a:text-secondary prose-a:no-underline hover:prose-a:text-teal-400 hover:prose-a:underline
                            prose-strong:text-slate-100
                            prose-blockquote:text-slate-400 prose-blockquote:border-secondary
                            prose-code:text-pink-400 prose-code:bg-neutral-light prose-code:px-1 prose-code:py-0.5 prose-code:rounded
                            prose-pre:bg-neutral-light prose-pre:text-slate-300 prose-pre:p-4 prose-pre:rounded-md prose-pre:overflow-x-auto
                            prose-ul:list-disc prose-ul:ml-5 prose-ol:list-decimal prose-ol:ml-5
                            prose-li:marker:text-secondary
                            prose-img:rounded-lg prose-img:shadow-md
                            ">
                    <?php echo $post_data['content']; ?>
                </div>

                <?php if (!empty($post_data['meta_keywords'])): ?>
                <div class="mt-10 pt-6 border-t border-neutral-light/50">
                    <p class="text-sm text-slate-400 flex items-center">
                        <i data-lucide="tags" class="w-4 h-4 mr-2 text-secondary"></i>
                        <span class="font-semibold mr-1">Keywords:</span>
                        <span class="italic"><?php echo esc_html($post_data['meta_keywords']); ?></span>
                    </p>
                </div>
                <?php endif; ?>

                <div class="mt-12 pt-8 border-t border-neutral-light/50">
                    <h3 class="font-display text-2xl font-semibold text-slate-100 mb-6">Comments</h3>
                    <p class="text-slate-400 italic">Comments are currently disabled or not yet implemented for this post.</p>
                </div>

            </article>
            <div class="mt-12 text-center">
                <a href="<?php echo $base_blog_url_for_return; ?>" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-100 bg-neutral-lighter hover:bg-secondary rounded-lg shadow transition-colors group">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i> Return to Blog
                </a>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <i data-lucide="file-question" class="w-24 h-24 text-slate-500 mx-auto mb-6"></i>
                <h1 class="font-display text-4xl font-bold text-slate-100 mb-3">Post Not Found</h1>
                <p class="text-lg text-slate-400 mb-8">Sorry, we couldn't find the blog post you were looking for, or the preview link is invalid/expired.</p>
                <a href="<?php echo $base_blog_url_for_return; ?>" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-secondary hover:bg-opacity-80 rounded-lg shadow-lg transition-colors">
                    <i data-lucide="arrow-left-circle" class="w-5 h-5 mr-2"></i> Return to Blog
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>