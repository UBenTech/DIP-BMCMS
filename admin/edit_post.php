<?php
// admin/edit_post.php
require_once __DIR__ . '/header.php';

// Initialize variables
$is_edit   = false;
$post_id   = $_GET['id'] ?? null;
$title     = '';
$slug      = '';
$content   = '';
$excerpt   = '';
$category_id = '';
$status    = 'draft';
$meta_desc = '';
$meta_keys = '';
$featured_image = '';

// Fetch categories for dropdown
$cats_stmt = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
$categories = $cats_stmt && $cats_stmt->num_rows > 0 ? $cats_stmt->fetch_all(MYSQLI_ASSOC) : [];

if ($post_id) {
    // Editing existing post
    $is_edit = true;
    $stmt = $conn->prepare("
      SELECT title, slug, content, excerpt, category_id, status, meta_description, meta_keywords, featured_image
      FROM posts
      WHERE id = ? LIMIT 1
    ");
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $row = $res->fetch_assoc();
            $title         = $row['title'];
            $slug          = $row['slug'];
            $content       = $row['content'];
            $excerpt       = $row['excerpt'];
            $category_id   = $row['category_id'];
            $status        = $row['status'];
            $meta_desc     = $row['meta_description'];
            $meta_keys     = $row['meta_keywords'];
            $featured_image= $row['featured_image'];
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission (Insert or Update)
    $token = $_POST['csrf_token'] ?? '';
    if (!validate_csrf_token($token)) {
        $_SESSION['flash_error'] = "Invalid CSRF token. Please try again.";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    $title       = trim($_POST['title'] ?? '');
    $slug_input  = trim($_POST['slug'] ?? '');
    $content     = $_POST['content'] ?? '';
    $excerpt     = trim($_POST['excerpt'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $status      = $_POST['status'] ?? 'draft';
    $meta_desc   = trim($_POST['meta_description'] ?? '');
    $meta_keys   = trim($_POST['meta_keywords'] ?? '');

    // Basic validation
    $errors = [];
    if ($title === '') {
        $errors[] = "Title is required.";
    }
    if ($slug_input === '') {
        $errors[] = "Slug is required.";
    }
    if ($content === '') {
        $errors[] = "Content cannot be empty.";
    }
    if ($category_id < 1) {
        $errors[] = "Please select a category.";
    }
    if (!in_array($status, ['draft','published'], true)) {
        $errors[] = "Invalid status.";
    }

    // Handle featured image upload if provided
    $featured_img_filename = $featured_image;
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = handle_file_upload($_FILES['featured_image'], __DIR__ . '/../uploads/', ['image/jpeg','image/png','image/gif','image/webp'], 2*1024*1024);
        if (is_array($upload)) {
            $errors = array_merge($errors, $upload);
        } else {
            // Delete old image if exists
            if ($featured_image && file_exists(__DIR__ . "/../uploads/{$featured_image}")) {
                unlink(__DIR__ . "/../uploads/{$featured_image}");
            }
            $featured_img_filename = $upload;
        }
    }

    if (empty($errors)) {
        if ($is_edit) {
            // UPDATE existing post
            $sql = "
              UPDATE posts
              SET title = ?, slug = ?, content = ?, excerpt = ?, category_id = ?, status = ?, meta_description = ?, meta_keywords = ?, featured_image = ?
              WHERE id = ? 
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssisss(si)",
                $title,
                $slug_input,
                $content,
                $excerpt,
                $category_id,
                $status,
                $meta_desc,
                $meta_keys,
                $featured_img_filename,
                $post_id
            );
            if ($stmt->execute()) {
                $_SESSION['flash_success'] = "Post updated successfully.";
                header("Location: posts.php");
                exit;
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // INSERT new post
            $sql = "
              INSERT INTO posts (title, slug, content, excerpt, category_id, status, meta_description, meta_keywords, featured_image, created_at)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssissss",
                $title,
                $slug_input,
                $content,
                $excerpt,
                $category_id,
                $status,
                $meta_desc,
                $meta_keys,
                $featured_img_filename
            );
            if ($stmt->execute()) {
                $_SESSION['flash_success'] = "Post created successfully.";
                header("Location: posts.php");
                exit;
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Below is the form view
?>
<div class="px-6 py-8 flex-1 overflow-y-auto">
  <h3 class="text-2xl font-semibold text-text mb-6">
    <?= $is_edit ? "Edit Post" : "Add New Post"; ?>
  </h3>

  <?php if (!empty($errors)): ?>
    <div class="mb-6 px-4 py-3 bg-error/10 border border-error text-error rounded-md">
      <ul class="list-disc list-inside space-y-1">
        <?php foreach ($errors as $err): ?>
          <li><?= esc_html($err); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="space-y-6">
    <?= generate_csrf_input(); ?>

    <!-- Title -->
    <div>
      <label for="title" class="block text-sm font-medium text-text mb-1">Title <span class="text-error">*</span></label>
      <input
        type="text"
        name="title"
        id="title"
        value="<?= esc_html($title); ?>"
        required
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
        placeholder="Enter post title"
      />
    </div>

    <!-- Slug -->
    <div>
      <label for="slug" class="block text-sm font-medium text-text mb-1">Slug <span class="text-error">*</span></label>
      <input
        type="text"
        name="slug"
        id="slug"
        value="<?= esc_html($slug); ?>"
        required
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
        placeholder="post-slug-example"
      />
      <p class="text-xs text-text/70 mt-1">URL‐friendly identifier (no spaces).</p>
    </div>

    <!-- Category -->
    <div>
      <label for="category_id" class="block text-sm font-medium text-text mb-1">Category <span class="text-error">*</span></label>
      <select
        id="category_id"
        name="category_id"
        required
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
      >
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= (int)$cat['id']; ?>" <?= (int)$category_id === (int)$cat['id'] ? 'selected' : ''; ?>>
            <?= esc_html($cat['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Status -->
    <div>
      <label for="status" class="block text-sm font-medium text-text mb-1">Status <span class="text-error">*</span></label>
      <select
        id="status"
        name="status"
        required
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
      >
        <option value="draft" <?= $status === 'draft' ? 'selected' : ''; ?>>Draft</option>
        <option value="published" <?= $status === 'published' ? 'selected' : ''; ?>>Published</option>
      </select>
    </div>

    <!-- Featured Image -->
    <div>
      <label for="featured_image" class="block text-sm font-medium text-text mb-1">Featured Image</label>
      <?php if ($featured_image): ?>
        <div class="mb-2">
          <img
            src="<?= esc_url(BASE_URL . 'uploads/' . $featured_image); ?>"
            alt="Current Featured Image"
            class="h-40 w-full object-cover rounded-md shadow-md"
            onError="this.style.display='none';"
          />
        </div>
      <?php endif; ?>
      <input
        type="file"
        name="featured_image"
        id="featured_image"
        accept=".jpg,.jpeg,.png,.gif,.webp"
        class="w-full text-text"
      />
      <p class="text-xs text-text/70 mt-1">Max size: 2MB. Formats: JPG/PNG/GIF/WEBP.</p>
    </div>

    <!-- Excerpt -->
    <div>
      <label for="excerpt" class="block text-sm font-medium text-text mb-1">Excerpt</label>
      <textarea
        name="excerpt"
        id="excerpt"
        rows="3"
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-y"
        placeholder="Short summary of the post (optional)"
      ><?= esc_html($excerpt); ?></textarea>
    </div>

    <!-- Content (WYSIWYG/HTML) -->
    <div>
      <label for="content" class="block text-sm font-medium text-text mb-1">Content <span class="text-error">*</span></label>
      <textarea
        name="content"
        id="content"
        rows="10"
        required
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-y"
        placeholder="Write your post content here..."
      ><?= esc_textarea($content); ?></textarea>
    </div>

    <!-- Meta Description -->
    <div>
      <label for="meta_description" class="block text-sm font-medium text-text mb-1">Meta Description</label>
      <textarea
        name="meta_description"
        id="meta_description"
        rows="2"
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-y"
        placeholder="SEO meta description (optional)"
      ><?= esc_html($meta_desc); ?></textarea>
    </div>

    <!-- Meta Keywords -->
    <div>
      <label for="meta_keywords" class="block text-sm font-medium text-text mb-1">Meta Keywords</label>
      <input
        type="text"
        name="meta_keywords"
        id="meta_keywords"
        value="<?= esc_html($meta_keys); ?>"
        class="w-full px-4 py-3 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
        placeholder="keyword1, keyword2, keyword3 (optional)"
      />
    </div>

    <!-- Submit -->
    <div class="pt-4 border-t border-base-200 flex justify-end space-x-4">
      <a href="posts.php" class="px-6 py-2 bg-neutral-light hover:bg-neutral-lighter text-text font-medium rounded-md transition-colors">
        Cancel
      </a>
      <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-hover text-white font-medium rounded-md shadow transition-colors">
        <?= $is_edit ? "Update Post" : "Create Post"; ?>
      </button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
