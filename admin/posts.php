<?php
// admin/posts.php
require_once __DIR__ . '/header.php';

// Fetch categories for filter dropdown
$cats_stmt = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
$categories = [];
if ($cats_stmt && $cats_stmt->num_rows > 0) {
    $categories = $cats_stmt->fetch_all(MYSQLI_ASSOC);
}

// Handle filters & pagination parameters
$search_term        = $_GET['search'] ?? '';
$category_filter_id = (isset($_GET['category']) && is_numeric($_GET['category'])) ? (int)$_GET['category'] : '';
$status_filter      = $_GET['status'] ?? '';
$current_page       = isset($_GET['page_num']) ? max(1, (int)$_GET['page_num']) : 1;
$per_page           = 10;
$offset             = ($current_page - 1) * $per_page;

// Build base SQL + count
$count_sql = "SELECT COUNT(*) FROM posts p";
$where     = ["1=1"];
$params    = []; 
$types     = "";

// Join category if filtering
if ($category_filter_id) {
    $where[]  = "p.category_id = ?";
    $params[] = $category_filter_id;
    $types   .= "i";
}

if (!empty($search_term)) {
    $where[]   = "(p.title LIKE ? OR p.content LIKE ?)";
    $like_term = "%" . $search_term . "%";
    $params[]  = $like_term;
    $params[]  = $like_term;
    $types    .= "ss";
}

if (in_array($status_filter, ['draft','published'], true)) {
    $where[]   = "p.status = ?";
    $params[]  = $status_filter;
    $types    .= "s";
}

$where_clause = "WHERE " . implode(" AND ", $where);
$count_sql   .= " " . $where_clause;

// Get total count
$total_posts = 0;
$stmt_count  = $conn->prepare($count_sql);
if ($stmt_count) {
    if (!empty($params)) {
        // bind_param requires variables passed by reference
        $bind_names = [];
        $bind_names[] = & $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_names[] = & $params[$i];
        }
        call_user_func_array([$stmt_count, 'bind_param'], $bind_names);
    }
    $stmt_count->execute();
    $stmt_count->bind_result($total_posts);
    $stmt_count->fetch();
    $stmt_count->close();
}

$total_pages = ceil($total_posts / $per_page);

// Build the “fetch” query (with LIMIT & OFFSET)
$fetch_sql = "
  SELECT p.id, p.title, p.slug, c.name AS category_name, p.status, p.created_at
  FROM posts p
  LEFT JOIN categories c ON p.category_id = c.id
  $where_clause
  ORDER BY p.created_at DESC
  LIMIT ? OFFSET ?
";

$stmt_fetch = $conn->prepare($fetch_sql);
$posts       = [];

if ($stmt_fetch) {
    if (!empty($params)) {
        // We need to bind ($types . "ii") plus all values in $params, then $per_page, $offset.
        // Again, build an array by reference:
        $full_types  = $types . "ii";
        $bind_vals   = [];
        $bind_vals[] = & $full_types;
        // each param must be a variable reference:
        for ($i = 0; $i < count($params); $i++) {
            $bind_vals[] = & $params[$i];
        }
        // Finally, add $per_page and $offset (by reference):
        $bind_vals[] = & $per_page;
        $bind_vals[] = & $offset;

        call_user_func_array([$stmt_fetch, 'bind_param'], $bind_vals);
    } else {
        // No WHERE params, so just bind LIMIT and OFFSET:
        $stmt_fetch->bind_param("ii", $per_page, $offset);
    }

    $stmt_fetch->execute();
    $res = $stmt_fetch->get_result();
    if ($res) {
        $posts = $res->fetch_all(MYSQLI_ASSOC);
    }
    $stmt_fetch->close();
}
?>

<div class="px-6 flex-1 overflow-y-auto">
  <!-- Actions Bar -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <h3 class="text-xl font-semibold text-text mb-4 md:mb-0">
      All Posts (<?= esc_html($total_posts); ?>)
    </h3>
    <div class="flex space-x-3">
      <a href="edit_post.php" class="px-4 py-2 bg-secondary hover:bg-secondary-hover text-white font-medium rounded-md shadow">
        <i data-lucide="plus" class="w-4 h-4 mr-2 inline-block"></i> Add New Post
      </a>
    </div>
  </div>

  <!-- Filters -->
  <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div>
      <label for="search" class="block text-sm font-medium text-text/70 mb-1">Search</label>
      <input
        type="text"
        id="search"
        name="search"
        value="<?= esc_html($search_term); ?>"
        placeholder="Title or content..."
        class="w-full px-4 py-2 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
      />
    </div>

    <div>
      <label for="category" class="block text-sm font-medium text-text/70 mb-1">Category</label>
      <select
        id="category"
        name="category"
        class="w-full px-4 py-2 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
      >
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= (int)$cat['id']; ?>" <?= $category_filter_id === (int)$cat['id'] ? 'selected' : ''; ?>>
            <?= esc_html($cat['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="status" class="block text-sm font-medium text-text/70 mb-1">Status</label>
      <select
        id="status"
        name="status"
        class="w-full px-4 py-2 bg-base-200 border border-neutral-light rounded-md text-text focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
      >
        <option value="">All Statuses</option>
        <option value="draft" <?= $status_filter === 'draft' ? 'selected' : ''; ?>>Draft</option>
        <option value="published" <?= $status_filter === 'published' ? 'selected' : ''; ?>>Published</option>
      </select>
    </div>

    <div class="self-end flex space-x-2">
      <button type="submit" class="px-6 py-2 bg-secondary hover:bg-secondary-hover text-white font-medium rounded-md shadow">
        <i data-lucide="filter" class="w-4 h-4 mr-2 inline-block"></i>Filter
      </button>
      <?php if ($search_term || $category_filter_id || $status_filter): ?>
        <a href="posts.php" class="px-4 py-2 bg-neutral-light hover:bg-neutral-lighter text-text font-medium rounded-md shadow text-sm flex items-center">
          <i data-lucide="refresh-ccw" class="w-4 h-4 mr-1"></i>Clear
        </a>
      <?php endif; ?>
    </div>
  </form>

  <!-- Posts Table -->
  <form id="bulkDeleteForm" method="POST" action="bulk_delete_posts.php">
    <?= generate_csrf_input(); ?>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-base-100 rounded-lg shadow-lg">
        <thead class="bg-base-200">
          <tr>
            <th class="px-4 py-2 text-left">
              <input type="checkbox" id="selectAll" class="form-checkbox h-4 w-4 text-secondary" />
            </th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-text/70">Title</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-text/70">Category</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-text/70">Status</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-text/70">Date Created</th>
            <th class="px-4 py-2 text-center text-sm font-semibold text-text/70">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($posts)): ?>
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-text/70 italic">
                No posts found.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($posts as $post): ?>
              <tr class="border-t border-base-200 hover:bg-base-200">
                <td class="px-4 py-3">
                  <input
                    type="checkbox"
                    name="selected_posts[]"
                    value="<?= (int)$post['id']; ?>"
                    class="form-checkbox h-4 w-4 text-secondary"
                  />
                </td>
                <td class="px-4 py-3 text-sm text-text">
                  <?= esc_html($post['title']); ?>
                </td>
                <td class="px-4 py-3 text-sm text-text/70">
                  <?= esc_html($post['category_name'] ?? '—'); ?>
                </td>
                <td class="px-4 py-3 text-sm">
                  <?php if ($post['status'] === 'published'): ?>
                    <span class="inline-block px-2 py-1 bg-success/20 text-success text-xs font-semibold rounded-full">Published</span>
                  <?php else: ?>
                    <span class="inline-block px-2 py-1 bg-error/20 text-error text-xs font-semibold rounded-full">Draft</span>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-sm text-text/70">
                  <?= esc_html(format_date($post['created_at'], 'M j, Y | H:i')); ?>
                </td>
                <td class="px-4 py-3 text-center space-x-2">
                  <!-- Preview Button -->
                  <a
                    href="<?= BASE_URL . '/' . esc_url($post['slug']); ?>"
                    target="_blank"
                    class="inline-flex items-center px-3 py-1 bg-info hover:bg-info-hover text-white text-xs font-medium rounded-md transition-colors"
                  >
                    <i data-lucide="eye" class="w-4 h-4 mr-1"></i>Preview
                  </a>
                  <!-- Edit Button -->
                  <a
                    href="edit_post.php?id=<?= (int)$post['id']; ?>"
                    class="inline-flex items-center px-3 py-1 bg-primary hover:bg-primary-hover text-white text-xs font-medium rounded-md transition-colors"
                  >
                    <i data-lucide="edit-2" class="w-4 h-4 mr-1"></i>Edit
                  </a>
                  <!-- Delete Button triggers modal -->
                  <button
                    type="button"
                    data-post-id="<?= (int)$post['id']; ?>"
                    class="delete-btn inline-flex items-center px-3 py-1 bg-error hover:bg-error-hover text-white text-xs font-medium rounded-md transition-colors"
                  >
                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Bulk Delete Button -->
    <div class="mt-4 text-right">
      <button
        type="submit"
        class="inline-flex items-center px-4 py-2 bg-error hover:bg-error-hover text-white font-medium rounded-md shadow transition-colors"
        onclick="return confirm('Are you sure you want to delete the selected posts?');"
      >
        <i data-lucide="trash" class="w-4 h-4 mr-2"></i>Delete Selected
      </button>
    </div>
  </form>

  <!-- Pagination -->
  <?php if ($total_pages > 1): ?>
    <nav class="mt-8 flex justify-center items-center space-x-1 sm:space-x-2">
      <?php if ($current_page > 1): ?>
        <a
          href="?page_num=<?= $current_page - 1; ?>&search=<?= urlencode($search_term); ?>&category=<?= $category_filter_id; ?>&status=<?= esc_html($status_filter); ?>"
          class="px-3 py-2 text-sm text-text/80 bg-base-200 hover:bg-secondary hover:text-white rounded-md transition-colors flex items-center"
        >
          <i data-lucide="chevron-left" class="w-4 h-4 sm:mr-1"></i>
          <span class="hidden sm:inline">Previous</span>
        </a>
      <?php endif; ?>

      <?php
        $start = max(1, $current_page - 2);
        $end   = min($total_pages, $start + 4);
        if ($end - $start < 4) {
          $start = max(1, $end - 4);
        }

        if ($start > 1) {
          echo '<a href="?page_num=1&search=' . urlencode($search_term) . '&category=' . $category_filter_id . '&status=' . esc_html($status_filter) . '" class="px-3 py-2 text-sm text-text/80 bg-base-200 hover:bg-secondary hover:text-white rounded-md transition-colors">1</a>';
          if ($start > 2) {
            echo '<span class="px-3 py-2 text-sm text-text/60">…</span>';
          }
        }

        for ($i = $start; $i <= $end; $i++):
      ?>
        <?php if ($i === $current_page): ?>
          <span class="px-3 py-2 text-sm font-semibold text-white bg-primary rounded-md"><?= $i; ?></span>
        <?php else: ?>
          <a
            href="?page_num=<?= $i; ?>&search=<?= urlencode($search_term); ?>&category=<?= $category_filter_id; ?>&status=<?= esc_html($status_filter); ?>"
            class="px-3 py-2 text-sm text-text/80 bg-base-200 hover:bg-secondary hover:text-white rounded-md transition-colors"
          ><?= $i; ?></a>
        <?php endif; ?>
      <?php endfor;

        if ($end < $total_pages) {
          if ($end < $total_pages - 1) {
            echo '<span class="px-3 py-2 text-sm text-text/60">…</span>';
          }
          echo '<a href="?page_num=' . $total_pages . '&search=' . urlencode($search_term) . '&category=' . $category_filter_id . '&status=' . esc_html($status_filter) . '" class="px-3 py-2 text-sm text-text/80 bg-base-200 hover:bg-secondary hover:text-white rounded-md transition-colors">' . $total_pages . '</a>';
        }
      ?>

      <?php if ($current_page < $total_pages): ?>
        <a
          href="?page_num=<?= $current_page + 1; ?>&search=<?= urlencode($search_term); ?>&category=<?= $category_filter_id; ?>&status=<?= esc_html($status_filter); ?>"
          class="px-3 py-2 text-sm text-text/80 bg-base-200 hover:bg-secondary hover:text-white rounded-md transition-colors flex items-center"
        >
          <span class="hidden sm:inline">Next</span>
          <i data-lucide="chevron-right" class="w-4 h-4 sm:ml-1"></i>
        </a>
      <?php endif; ?>
    </nav>
  <?php endif; ?>
</div>

<!-- Delete Confirmation Modal (Hidden by default) -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden">
  <div class="bg-base-100 rounded-lg shadow-xl w-11/12 md:w-1/3 p-6">
    <h4 class="text-lg font-semibold text-text mb-4">Confirm Deletion</h4>
    <p class="text-text/70 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>
    <div class="flex justify-end space-x-3">
      <button id="cancelDeleteBtn" class="px-4 py-2 bg-base-200 hover:bg-neutral-lighter text-text font-medium rounded-md">Cancel</button>
      <button id="confirmDeleteBtn" class="px-4 py-2 bg-error hover:bg-error-hover text-white font-medium rounded-md">Delete</button>
    </div>
  </div>
</div>

<script>
  // Toggle delete modal and set target ID
  const deleteModal      = document.getElementById('deleteModal');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  const cancelDeleteBtn  = document.getElementById('cancelDeleteBtn');
  let deletePostId       = null;

  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      deletePostId = btn.getAttribute('data-post-id');
      deleteModal.classList.remove('hidden');
    });
  });

  cancelDeleteBtn.addEventListener('click', () => {
    deleteModal.classList.add('hidden');
    deletePostId = null;
  });

  confirmDeleteBtn.addEventListener('click', () => {
    if (!deletePostId) return;
    // Redirect to delete_post.php with CSRF token
    const token = '<?= generate_csrf_token(); ?>';
    window.location.href = `delete_post.php?id=${deletePostId}&csrf_token=${token}`;
  });

  // Select All checkboxes
  document.getElementById('selectAll').addEventListener('change', e => {
    const checked = e.target.checked;
    document.querySelectorAll('input[name="selected_posts[]"]').forEach(chk => {
      chk.checked = checked;
    });
  });
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
