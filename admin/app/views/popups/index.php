<?php
$items = $result['data'];
$total = $result['total'];
$pages = $result['pages'];
$page  = $result['page'];

$today = date('Y-m-d');

// Decide a popup's live status for the badge.
$statusOf = function (array $p) use ($today): array {
    if (!(int) $p['is_active']) {
        return ['Inactive', 'history', 'bg-line-soft text-muted border-line'];
    }
    if (!empty($p['expires_at']) && $p['expires_at'] < $today) {
        return ['Expired', 'history', 'bg-line-soft text-muted border-line'];
    }
    if (!empty($p['starts_at']) && $p['starts_at'] > $today) {
        return ['Scheduled', 'clock', 'bg-warn-50 text-warn border-warn/20'];
    }
    return ['Live', 'radio', 'bg-accent-50 text-accent border-accent/20'];
};
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Popups</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> popup<?= $total !== 1 ? 's' : '' ?> total
            <?php if (array_filter($filters, fn($v) => $v !== '')): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
            <span class="block sm:inline text-subtle">· shown as a modal when visitors open the website</span>
        </p>
    </div>
    <button onclick="openAddModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white hover:opacity-90 text-[13px] font-semibold transition shadow-card">
        <i data-lucide="plus" class="w-4 h-4"></i> Add Popup
    </button>
</div>

<!-- Info banner -->
<div class="bg-brand-50 border border-brand-100 rounded-xl p-3.5 mb-5 flex items-start gap-2.5">
    <i data-lucide="info" class="w-4 h-4 text-brand mt-0.5 shrink-0"></i>
    <p class="text-[12px] text-ink-soft leading-relaxed">
        Only <strong class="text-ink">one</strong> popup shows on the site at a time — the live one with the lowest sort order.
        A popup is live when it is <strong class="text-ink">Active</strong> and today falls within its start / expiry dates.
        Each visitor sees it once per browser session.
    </p>
</div>

<!-- Filter panel -->
<div class="bg-panel rounded-xl border border-line p-4 mb-5 shadow-card">
    <form method="GET" action="<?= e(url('/popups')) ?>">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search']) ?>"
                        placeholder="Title, subtitle, message…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">When</label>
                <select name="when"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All</option>
                    <option value="live"      <?= $filters['when'] === 'live'      ? 'selected' : '' ?>>Live now</option>
                    <option value="scheduled" <?= $filters['when'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                    <option value="expired"   <?= $filters['when'] === 'expired'   ? 'selected' : '' ?>>Expired</option>
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
                    <a href="<?= e(url('/popups')) ?>"
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
        <i data-lucide="message-square-dashed" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
        <p class="text-[13px] font-semibold text-ink">No popups found</p>
        <p class="text-[12px] text-muted mt-1">
            <?= array_filter($filters, fn($v) => $v !== '') ? 'Try adjusting your filters.' : 'Add your first popup to get started.' ?>
        </p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <?php foreach ($items as $it):
            $img = $it['image_path'] ? public_url($it['image_path']) : '';
            [$badge, $badgeIcon, $badgeCls] = $statusOf($it);
            $window = [];
            if (!empty($it['starts_at']))  $window[] = 'From ' . date('M j, Y', strtotime($it['starts_at']));
            if (!empty($it['expires_at'])) $window[] = 'Until ' . date('M j, Y', strtotime($it['expires_at']));
        ?>
            <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden flex flex-col group">
                <div class="aspect-[16/10] bg-line-soft relative overflow-hidden">
                    <?php if ($img): ?>
                        <img src="<?= e($img) ?>" alt="<?= e($it['title']) ?>"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                        <div class="absolute inset-0 grid place-items-center text-subtle">
                            <i data-lucide="image" class="w-8 h-8"></i>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-2.5 left-2.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold border <?= $badgeCls ?>">
                        <i data-lucide="<?= $badgeIcon ?>" class="w-3 h-3"></i>
                        <?= $badge ?>
                    </span>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <?php if (!empty($it['subtitle'])): ?>
                        <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-brand mb-1"><?= e($it['subtitle']) ?></span>
                    <?php endif; ?>
                    <h3 class="font-display text-[15px] font-bold text-ink leading-snug"><?= e($it['title']) ?></h3>
                    <?php if (!empty($it['description'])): ?>
                        <p class="text-[12px] text-muted mt-1.5 line-clamp-2"><?= e($it['description']) ?></p>
                    <?php endif; ?>
                    <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-[11px] text-ink-soft">
                        <?php if ($window): ?>
                            <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3 text-subtle"></i><?= e(implode(' · ', $window)) ?></span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 text-subtle"><i data-lucide="infinity" class="w-3 h-3"></i>Always on</span>
                        <?php endif; ?>
                        <?php if (!empty($it['button_label'])): ?>
                            <span class="inline-flex items-center gap-1"><i data-lucide="mouse-pointer-click" class="w-3 h-3 text-subtle"></i><?= e($it['button_label']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 pt-3 border-t border-line flex items-center justify-between">
                        <span class="text-[11px] text-subtle">Order #<?= (int) $it['sort_order'] ?></span>
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
                    $url_i  = url('/popups') . '?' . http_build_query(array_filter($filters, fn($v) => $v !== '') + ['page' => $i]);
                    $active = $i === $page;
                ?>
                    <a href="<?= e($url_i) ?>"
                        class="min-w-[30px] h-[30px] px-2 flex items-center justify-center rounded-lg text-[12px] font-medium transition
                            <?= $active
                                ? 'bg-brand text-white font-semibold'
                                : 'text-ink-soft hover:bg-line-soft hover:text-ink' ?>">
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
                    <i data-lucide="message-square-plus" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add Popup</h3>
                    <p class="text-[11px] text-muted">Shown as a modal on the public website</p>
                </div>
            </div>
            <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form action="<?= e(url('/popups/store')) ?>" method="POST" enctype="multipart/form-data"
              class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div>
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Monsoon Pottery Sale" class="form-input">
            </div>
            <div>
                <label class="form-label">Subtitle / Eyebrow</label>
                <input type="text" name="subtitle" placeholder="e.g. Limited Time Offer" class="form-input">
            </div>
            <div>
                <label class="form-label">Image</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand file:text-[12px] file:font-semibold">
                <p class="text-[11px] text-subtle mt-1">JPG, PNG, WebP or GIF. Resized to 1600px and saved as WebP.</p>
            </div>
            <div>
                <label class="form-label">Message</label>
                <textarea name="description" rows="3" placeholder="Short message shown inside the popup…" class="form-input resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Button Label</label>
                    <input type="text" name="button_label" placeholder="e.g. Book Now" class="form-input">
                </div>
                <div>
                    <label class="form-label">Button Link</label>
                    <input type="text" name="button_url" placeholder="e.g. contact.php" class="form-input">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Start Date</label>
                    <input type="date" name="starts_at" class="form-input">
                    <p class="text-[11px] text-subtle mt-1">Blank = starts immediately.</p>
                </div>
                <div>
                    <label class="form-label">Expire Date</label>
                    <input type="date" name="expires_at" class="form-input">
                    <p class="text-[11px] text-subtle mt-1">Blank = never expires.</p>
                </div>
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
                    <h3 class="font-display text-[15px] font-bold text-ink">Edit Popup</h3>
                    <p class="text-[11px] text-muted" id="editSubtitle">Update popup</p>
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
                <label class="form-label">Subtitle / Eyebrow</label>
                <input type="text" name="subtitle" id="edit_subtitle" class="form-input">
            </div>
            <div>
                <label class="form-label">Replace Image</label>
                <div id="edit_image_preview" class="mb-2 hidden">
                    <img id="edit_image_img" src="" alt="" class="w-full h-32 object-cover rounded-lg border border-line">
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand file:text-[12px] file:font-semibold">
                <p class="text-[11px] text-subtle mt-1">Leave empty to keep the current image.</p>
            </div>
            <div>
                <label class="form-label">Message</label>
                <textarea name="description" id="edit_description" rows="3" class="form-input resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Button Label</label>
                    <input type="text" name="button_label" id="edit_button_label" class="form-input">
                </div>
                <div>
                    <label class="form-label">Button Link</label>
                    <input type="text" name="button_url" id="edit_button_url" class="form-input">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Start Date</label>
                    <input type="date" name="starts_at" id="edit_starts_at" class="form-input">
                </div>
                <div>
                    <label class="form-label">Expire Date</label>
                    <input type="date" name="expires_at" id="edit_expires_at" class="form-input">
                </div>
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
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete this popup?</h3>
        <p class="text-[13px] text-muted mb-5">
            <strong id="deleteName" class="text-ink"></strong> and its image will be permanently removed.
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
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
var BASE = '<?= e(rtrim(url(''), '/')) ?>';
var PUBLIC_BASE = '<?= e(rtrim(public_url(''), '/')) ?>';

function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openEditModal(it) {
    var f = document.getElementById('editForm');
    f.action = BASE + '/popups/' + it.id + '/update';
    document.getElementById('edit_title').value        = it.title        || '';
    document.getElementById('edit_subtitle').value     = it.subtitle     || '';
    document.getElementById('edit_description').value  = it.description  || '';
    document.getElementById('edit_button_label').value = it.button_label || '';
    document.getElementById('edit_button_url').value   = it.button_url   || '';
    document.getElementById('edit_starts_at').value    = it.starts_at    || '';
    document.getElementById('edit_expires_at').value   = it.expires_at   || '';
    document.getElementById('edit_sort_order').value   = it.sort_order   || 0;
    document.getElementById('edit_is_active').value    = String(it.is_active);
    document.getElementById('editSubtitle').textContent = it.title || 'Update popup';

    var preview = document.getElementById('edit_image_preview');
    var img     = document.getElementById('edit_image_img');
    if (it.image_path) {
        img.src = PUBLIC_BASE + '/' + it.image_path;
        preview.classList.remove('hidden');
    } else {
        img.src = '';
        preview.classList.add('hidden');
    }

    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = BASE + '/popups/' + id + '/delete';
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
        ['addModal','editModal','deleteModal'].forEach(closeModal);
    }
});
</script>
