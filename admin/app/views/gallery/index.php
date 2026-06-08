<?php
use Calyo\Models\GalleryImage;

/** @var array $result */
/** @var array $filters */
/** @var array $categories  Full category rows (for the manage-categories panel) */
/** @var array $categoryMap slug => label (for dropdowns / chips) */
/** @var array $imageCounts slug => number of images using it */

$items = $result['data'];
$total = $result['total'];
$pages = $result['pages'];
$page  = $result['page'];

$imageCounts = $imageCounts ?? [];

// Resolve the display URL for a row (external URL as-is, uploads via /public).
$displayUrl = function (array $row): string {
    if (($row['source_type'] ?? 'upload') === 'url') {
        return (string) ($row['image_url'] ?? '');
    }
    return !empty($row['image_path']) ? public_url($row['image_path']) : '';
};
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Gallery</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> image<?= $total !== 1 ? 's' : '' ?> on the public gallery
            <?php if (array_filter($filters, fn($v) => $v !== '')): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button onclick="openCategoriesModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-line bg-panel text-ink-soft hover:bg-line-soft text-[13px] font-semibold transition shadow-card">
            <i data-lucide="tags" class="w-4 h-4"></i> Manage Categories
        </button>
        <button onclick="openAddModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white hover:opacity-90 text-[13px] font-semibold transition shadow-card">
            <i data-lucide="image-plus" class="w-4 h-4"></i> Add Image
        </button>
    </div>
</div>

<!-- Filter panel -->
<div class="bg-panel rounded-xl border border-line p-4 mb-5 shadow-card">
    <form method="GET" action="<?= e(url('/gallery')) ?>">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search']) ?>"
                        placeholder="Title or category…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Category</label>
                <select name="category"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All</option>
                    <?php foreach ($categoryMap as $slug => $label): ?>
                        <option value="<?= e($slug) ?>" <?= $filters['category'] === $slug ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Status</label>
                <select name="is_active"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All</option>
                    <option value="1" <?= $filters['is_active'] === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $filters['is_active'] === '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand text-white text-[13px] font-semibold hover:opacity-90 transition">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Apply
                </button>
                <?php if (array_filter($filters, fn($v) => $v !== '')): ?>
                    <a href="<?= e(url('/gallery')) ?>"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<!-- Grid -->
<?php if (empty($items)): ?>
    <div class="bg-panel rounded-xl border border-line shadow-card py-16 text-center">
        <div class="w-14 h-14 rounded-2xl bg-brand-50 grid place-items-center mx-auto mb-3">
            <i data-lucide="image" class="w-6 h-6 text-brand"></i>
        </div>
        <p class="text-[13px] font-semibold text-ink">No gallery images</p>
        <p class="text-[12px] text-muted mt-1">
            <?= array_filter($filters, fn($v) => $v !== '') ? 'Try adjusting your filters.' : 'Add your first image to populate the website gallery.' ?>
        </p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <?php foreach ($items as $it):
            $src    = $displayUrl($it);
            $isUrl  = ($it['source_type'] ?? 'upload') === 'url';
            $catSlug = (string) $it['category'];
        ?>
            <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden flex flex-col group">
                <div class="aspect-square bg-line-soft relative overflow-hidden">
                    <?php if ($src): ?>
                        <img src="<?= e($src) ?>" alt="<?= e($it['title']) ?>" loading="lazy"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                        <div class="absolute inset-0 grid place-items-center text-subtle">
                            <i data-lucide="image-off" class="w-7 h-7"></i>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-2 left-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold border bg-white/90 text-ink-soft border-line backdrop-blur-sm">
                        <?= e(GalleryImage::categoryLabel($catSlug)) ?>
                    </span>
                    <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[10px] font-semibold border <?= $isUrl ? 'bg-brand-50 text-brand border-brand/20' : 'bg-success-50 text-success border-success/20' ?> backdrop-blur-sm"
                          title="<?= $isUrl ? 'External URL' : 'Uploaded file' ?>">
                        <i data-lucide="<?= $isUrl ? 'link' : 'hard-drive' ?>" class="w-3 h-3"></i>
                    </span>
                    <?php if (!(int) $it['is_active']): ?>
                        <span class="absolute bottom-2 left-2 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold border bg-slate-900/70 text-white border-transparent">
                            Hidden
                        </span>
                    <?php endif; ?>
                </div>
                <div class="p-3 flex-1 flex flex-col">
                    <h3 class="font-semibold text-ink text-[13px] leading-snug truncate" title="<?= e($it['title']) ?>"><?= e($it['title']) ?></h3>
                    <div class="mt-2 pt-2 border-t border-line flex items-center justify-between">
                        <span class="text-[11px] text-subtle">#<?= (int) $it['sort_order'] ?></span>
                        <div class="flex items-center gap-1">
                            <button
                                onclick='openEditModal(<?= htmlspecialchars(json_encode($it), ENT_QUOTES) ?>)'
                                class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-brand-50 hover:text-brand transition" title="Edit">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </button>
                            <button
                                onclick="openDeleteModal(<?= (int) $it['id'] ?>, '<?= e(addslashes($it['title'])) ?>')"
                                class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-danger-50 hover:text-danger transition" title="Delete">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($pages > 1): ?>
        <div class="flex items-center justify-between mt-5 px-2">
            <p class="text-[12px] text-muted">
                Showing <?= (($page - 1) * $result['per_page']) + 1 ?>–<?= min($page * $result['per_page'], $total) ?> of <?= $total ?>
            </p>
            <div class="flex items-center gap-1">
                <?php for ($i = 1; $i <= $pages; $i++):
                    $url_i  = url('/gallery') . '?' . http_build_query(array_filter($filters, fn($v) => $v !== '') + ['page' => $i]);
                    $active = $i === $page;
                ?>
                    <a href="<?= e($url_i) ?>"
                        class="min-w-[30px] h-[30px] px-2 flex items-center justify-center rounded-lg text-[12px] font-medium transition
                            <?= $active ? 'bg-brand text-white font-semibold' : 'text-ink-soft hover:bg-line-soft hover:text-ink' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════
     MODAL: Add
════════════════════════════════════════════════════════════ -->
<div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('addModal')"></div>
    <div class="relative w-full max-w-lg max-h-[92vh] flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                    <i data-lucide="image-plus" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add Gallery Image</h3>
                    <p class="text-[11px] text-muted">Shown on the public gallery page</p>
                </div>
            </div>
            <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form action="<?= e(url('/gallery/store')) ?>" method="POST" enctype="multipart/form-data"
              class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div>
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Terracotta Handthrown Mugs" class="form-input">
            </div>
            <div>
                <label class="form-label">Category</label>
                <select name="category" class="form-input">
                    <?php foreach ($categoryMap as $slug => $label): ?>
                        <option value="<?= e($slug) ?>"><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Source toggle -->
            <div>
                <label class="form-label">Image Source</label>
                <div class="grid grid-cols-2 gap-2" role="tablist">
                    <button type="button" data-src-btn="upload" onclick="setSource('add','upload')"
                        class="src-tab src-tab-active flex items-center justify-center gap-2 py-2 rounded-lg border text-[12.5px] font-semibold transition">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i> Upload from System
                    </button>
                    <button type="button" data-src-btn="url" onclick="setSource('add','url')"
                        class="src-tab flex items-center justify-center gap-2 py-2 rounded-lg border text-[12.5px] font-semibold transition">
                        <i data-lucide="link" class="w-3.5 h-3.5"></i> Direct URL
                    </button>
                </div>
                <input type="hidden" name="source" id="add_source" value="upload">
            </div>

            <div data-src-pane="add-upload">
                <label class="form-label">Image File</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand file:text-[12px] file:font-semibold">
                <p class="text-[11px] text-subtle mt-1">JPG, PNG, WebP or GIF. Resized to 1600px and saved as WebP.</p>
            </div>
            <div data-src-pane="add-url" class="hidden">
                <label class="form-label">Image URL</label>
                <input type="url" name="image_url" placeholder="https://example.com/photo.jpg" class="form-input">
                <p class="text-[11px] text-subtle mt-1">The URL is saved directly to the database — no copy is stored.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="form-input">
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-input">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Save
                </button>
                <button type="button" onclick="closeModal('addModal')"
                    class="px-5 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL: Edit
════════════════════════════════════════════════════════════ -->
<div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('editModal')"></div>
    <div class="relative w-full max-w-lg max-h-[92vh] flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-warn-50 grid place-items-center">
                    <i data-lucide="pencil" class="w-4 h-4 text-warn"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Edit Gallery Image</h3>
                    <p class="text-[11px] text-muted" id="editSubtitle">Update image</p>
                </div>
            </div>
            <button onclick="closeModal('editModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form id="editForm" action="" method="POST" enctype="multipart/form-data"
              class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div>
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="edit_title" required class="form-input">
            </div>
            <div>
                <label class="form-label">Category</label>
                <select name="category" id="edit_category" class="form-input">
                    <?php foreach ($categoryMap as $slug => $label): ?>
                        <option value="<?= e($slug) ?>"><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="form-label">Current Image</label>
                <div id="edit_image_preview" class="mb-1 hidden">
                    <img id="edit_image_img" src="" alt="" class="w-full h-36 object-cover rounded-lg border border-line bg-surface">
                </div>
            </div>

            <!-- Source toggle -->
            <div>
                <label class="form-label">Image Source</label>
                <div class="grid grid-cols-2 gap-2" role="tablist">
                    <button type="button" data-src-btn="upload" onclick="setSource('edit','upload')"
                        class="src-tab flex items-center justify-center gap-2 py-2 rounded-lg border text-[12.5px] font-semibold transition">
                        <i data-lucide="upload" class="w-3.5 h-3.5"></i> Upload from System
                    </button>
                    <button type="button" data-src-btn="url" onclick="setSource('edit','url')"
                        class="src-tab flex items-center justify-center gap-2 py-2 rounded-lg border text-[12.5px] font-semibold transition">
                        <i data-lucide="link" class="w-3.5 h-3.5"></i> Direct URL
                    </button>
                </div>
                <input type="hidden" name="source" id="edit_source" value="upload">
            </div>

            <div data-src-pane="edit-upload">
                <label class="form-label">Replace File</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand file:text-[12px] file:font-semibold">
                <p class="text-[11px] text-subtle mt-1">Leave empty to keep the current uploaded image.</p>
            </div>
            <div data-src-pane="edit-url" class="hidden">
                <label class="form-label">Image URL</label>
                <input type="url" name="image_url" id="edit_image_url" placeholder="https://example.com/photo.jpg" class="form-input">
                <p class="text-[11px] text-subtle mt-1">The URL is saved directly to the database.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" id="edit_sort_order" class="form-input">
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" id="edit_is_active" class="form-input">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Update
                </button>
                <button type="button" onclick="closeModal('editModal')"
                    class="px-5 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL: Delete
════════════════════════════════════════════════════════════ -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
    <div class="relative bg-panel rounded-2xl shadow-pop w-full max-w-sm p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-danger-50 grid place-items-center mx-auto mb-4">
            <i data-lucide="trash-2" class="w-5 h-5 text-danger"></i>
        </div>
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete this image?</h3>
        <p class="text-[13px] text-muted mb-5">
            <strong id="deleteName" class="text-ink"></strong> will be removed from the website gallery.
        </p>
        <form id="deleteForm" action="" method="POST" class="flex gap-3">
            <?= csrf_field() ?>
            <button type="button" onclick="closeModal('deleteModal')"
                class="flex-1 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                Cancel
            </button>
            <button type="submit"
                class="flex-1 py-2.5 rounded-xl bg-danger text-white text-[13px] font-semibold hover:opacity-90 transition">
                Yes, Delete
            </button>
        </form>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL: Manage Categories
════════════════════════════════════════════════════════════ -->
<div id="categoriesModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('categoriesModal')"></div>
    <div class="relative w-full max-w-2xl max-h-[92vh] flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                    <i data-lucide="tags" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Gallery Categories</h3>
                    <p class="text-[11px] text-muted">Used for the filter chips on the public gallery page</p>
                </div>
            </div>
            <button onclick="closeModal('categoriesModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5"
             style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">

            <!-- Add new category -->
            <form action="<?= e(url('/gallery/categories/store')) ?>" method="POST"
                  class="bg-surface border border-line rounded-xl p-4">
                <?= csrf_field() ?>
                <p class="text-[12px] font-semibold text-ink mb-3 flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5 text-brand"></i> Add a category
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                    <div class="sm:col-span-4">
                        <label class="form-label">Label <span class="text-danger">*</span></label>
                        <input type="text" name="label" required placeholder="e.g. Tableware" class="form-input">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" placeholder="auto from label" class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Order</label>
                        <input type="number" name="sort_order" value="<?= count($categories) + 1 ?>" class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-input">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="sm:col-span-1">
                        <button type="submit"
                            class="w-full py-2 rounded-lg bg-brand text-white text-[13px] font-semibold hover:opacity-90 transition" title="Add">
                            <i data-lucide="check" class="w-4 h-4 mx-auto"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Existing categories -->
            <?php if (empty($categories)): ?>
                <p class="text-[13px] text-muted text-center py-6">No categories yet — add your first one above.</p>
            <?php else: ?>
                <div class="space-y-2">
                    <?php foreach ($categories as $c):
                        $count = (int) ($imageCounts[$c['slug']] ?? 0);
                    ?>
                        <div class="bg-surface border border-line rounded-xl p-3">
                            <div class="flex items-end gap-2 flex-wrap">
                                <form action="<?= e(url('/gallery/categories/' . (int) $c['id'] . '/update')) ?>" method="POST"
                                      class="grid grid-cols-2 sm:grid-cols-12 gap-2 items-end flex-1">
                                    <?= csrf_field() ?>
                                    <div class="col-span-2 sm:col-span-4">
                                        <label class="form-label">Label</label>
                                        <input type="text" name="label" required value="<?= e($c['label']) ?>" class="form-input">
                                    </div>
                                    <div class="col-span-2 sm:col-span-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" name="slug" value="<?= e($c['slug']) ?>" class="form-input">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="form-label">Order</label>
                                        <input type="number" name="sort_order" value="<?= (int) $c['sort_order'] ?>" class="form-input">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="form-label">Status</label>
                                        <select name="is_active" class="form-input">
                                            <option value="1" <?= (int) $c['is_active'] === 1 ? 'selected' : '' ?>>Active</option>
                                            <option value="0" <?= (int) $c['is_active'] === 0 ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <button type="submit"
                                            class="w-full py-2 rounded-lg border border-line text-ink-soft hover:bg-brand-50 hover:text-brand transition" title="Save">
                                            <i data-lucide="save" class="w-4 h-4 mx-auto"></i>
                                        </button>
                                    </div>
                                </form>
                                <form action="<?= e(url('/gallery/categories/' . (int) $c['id'] . '/delete')) ?>" method="POST"
                                      onsubmit="return confirm('Delete the &quot;<?= e(addslashes($c['label'])) ?>&quot; category?');">
                                    <?= csrf_field() ?>
                                    <button type="submit"
                                        class="w-9 h-9 rounded-lg grid place-items-center text-ink-soft hover:bg-danger-50 hover:text-danger transition"
                                        title="<?= $count > 0 ? 'In use by ' . $count . ' image(s)' : 'Delete category' ?>">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="text-[11px] text-subtle mt-2">
                                <?= $count ?> image<?= $count === 1 ? '' : 's' ?> in this category
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-[11px] text-subtle">
                    Renaming a slug re-points its images automatically. A category that still has images can't be deleted.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>


<style>
.form-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #64748b;
    margin-bottom: 6px;
}
.form-input {
    width: 100%;
    padding: 8px 12px;
    background: #f6f7fb;
    border: 1px solid #e9ecf3;
    border-radius: 8px;
    font-size: 13px;
    color: #0f172a;
    transition: border-color .15s, box-shadow .15s;
    outline: none;
}
.form-input:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
}
.form-input::placeholder { color: #94a3b8; }
.src-tab { border-color: #e9ecf3; background: #f6f7fb; color: #64748b; }
.src-tab-active { border-color: #4f46e5; background: #eef2ff; color: #4338ca; }
</style>

<script>
var BASE = '<?= e(rtrim(url(''), '/')) ?>';
var PUBLIC_BASE = '<?= e(rtrim(public_url(''), '/')) ?>';

// Toggle between the "upload" and "url" source panes for a given form prefix.
function setSource(prefix, source) {
    document.getElementById(prefix + '_source').value = source;

    var modal = document.getElementById(prefix === 'add' ? 'addModal' : 'editModal');
    modal.querySelectorAll('[data-src-btn]').forEach(function (btn) {
        btn.classList.toggle('src-tab-active', btn.getAttribute('data-src-btn') === source);
    });
    modal.querySelector('[data-src-pane="' + prefix + '-upload"]').classList.toggle('hidden', source !== 'upload');
    modal.querySelector('[data-src-pane="' + prefix + '-url"]').classList.toggle('hidden', source !== 'url');
    if (window.lucide) lucide.createIcons();
}

function openAddModal() {
    setSource('add', 'upload');
    document.getElementById('addModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openCategoriesModal() {
    document.getElementById('categoriesModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openEditModal(it) {
    var f = document.getElementById('editForm');
    f.action = BASE + '/gallery/' + it.id + '/update';
    document.getElementById('edit_title').value      = it.title      || '';
    document.getElementById('edit_category').value   = it.category   || 'studio';
    document.getElementById('edit_sort_order').value = it.sort_order || 0;
    document.getElementById('edit_is_active').value  = String(it.is_active);
    document.getElementById('editSubtitle').textContent = it.title || 'Update image';

    var isUrl = it.source_type === 'url';
    var src   = isUrl ? (it.image_url || '') : (it.image_path ? PUBLIC_BASE + '/' + it.image_path : '');

    document.getElementById('edit_image_url').value = isUrl ? (it.image_url || '') : '';

    var preview = document.getElementById('edit_image_preview');
    var img     = document.getElementById('edit_image_img');
    if (src) {
        img.src = src;
        preview.classList.remove('hidden');
    } else {
        img.src = '';
        preview.classList.add('hidden');
    }

    setSource('edit', isUrl ? 'url' : 'upload');

    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = BASE + '/gallery/' + id + '/delete';
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['addModal','editModal','deleteModal','categoriesModal'].forEach(closeModal);
    }
});
</script>
