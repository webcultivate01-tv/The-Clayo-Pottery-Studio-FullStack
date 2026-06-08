<?php
$items = $result['data'];
$total = $result['total'];
$pages = $result['pages'];
$page  = $result['page'];

$today = date('Y-m-d');
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Events</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> event<?= $total !== 1 ? 's' : '' ?> total
            <?php if (array_filter($filters, fn($v) => $v !== '')): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
        </p>
    </div>
    <button onclick="openAddModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white hover:opacity-90 text-[13px] font-semibold transition shadow-card">
        <i data-lucide="plus" class="w-4 h-4"></i> Add Event
    </button>
</div>

<!-- Filter panel -->
<div class="bg-panel rounded-xl border border-line p-4 mb-5 shadow-card">
    <form method="GET" action="<?= e(url('/events')) ?>">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search']) ?>"
                        placeholder="Title, description, location…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">When</label>
                <select name="when"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All</option>
                    <option value="upcoming" <?= $filters['when'] === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                    <option value="past"     <?= $filters['when'] === 'past'     ? 'selected' : '' ?>>Past</option>
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
                    <a href="<?= e(url('/events')) ?>"
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
        <i data-lucide="calendar" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
        <p class="text-[13px] font-semibold text-ink">No events found</p>
        <p class="text-[12px] text-muted mt-1">
            <?= array_filter($filters, fn($v) => $v !== '') ? 'Try adjusting your filters.' : 'Add your first event to get started.' ?>
        </p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <?php foreach ($items as $it):
            $img    = $it['image_path'] ? public_url($it['image_path']) : '';
            $isPast = !empty($it['event_date']) && $it['event_date'] < $today;
            $dateLabel = !empty($it['event_date'])
                ? date('M j, Y', strtotime($it['event_date']))
                : 'Date TBA';
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
                    <span class="absolute top-2.5 left-2.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold border <?= $isPast ? 'bg-line-soft text-muted border-line' : 'bg-accent-50 text-accent border-accent/20' ?>">
                        <i data-lucide="<?= $isPast ? 'history' : 'calendar' ?>" class="w-3 h-3"></i>
                        <?= $isPast ? 'Past' : 'Upcoming' ?>
                    </span>
                    <?php if (!(int) $it['is_active']): ?>
                        <span class="absolute top-2.5 right-2.5 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold border bg-line-soft text-muted border-line">
                            Inactive
                        </span>
                    <?php endif; ?>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="font-display text-[15px] font-bold text-ink leading-snug"><?= e($it['title']) ?></h3>
                    <?php if (!empty($it['description'])): ?>
                        <p class="text-[12px] text-muted mt-1.5 line-clamp-2"><?= e($it['description']) ?></p>
                    <?php endif; ?>
                    <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-[11px] text-ink-soft">
                        <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3 text-subtle"></i><?= e($dateLabel) ?></span>
                        <?php if (!empty($it['event_time'])): ?>
                            <span class="inline-flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3 text-subtle"></i><?= e($it['event_time']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($it['location'])): ?>
                            <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3 text-subtle"></i><?= e($it['location']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($it['price'])): ?>
                            <span class="inline-flex items-center gap-1"><i data-lucide="tag" class="w-3 h-3 text-subtle"></i><?= e($it['price']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($it['capacity'])): ?>
                            <span class="inline-flex items-center gap-1"><i data-lucide="users" class="w-3 h-3 text-subtle"></i><?= e($it['capacity']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 pt-3 border-t border-line flex items-center justify-between">
                        <span class="text-[11px] text-subtle">#<?= (int) $it['sort_order'] ?> · /<?= e($it['slug']) ?></span>
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
                    $url_i  = url('/events') . '?' . http_build_query(array_filter($filters, fn($v) => $v !== '') + ['page' => $i]);
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
                    <i data-lucide="calendar-plus" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add Event</h3>
                    <p class="text-[11px] text-muted">Shown on the public website</p>
                </div>
            </div>
            <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form action="<?= e(url('/events/store')) ?>" method="POST" enctype="multipart/form-data"
              class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div>
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Diwali Pottery Festival" class="form-input">
            </div>
            <div>
                <label class="form-label">Image</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand file:text-[12px] file:font-semibold">
                <p class="text-[11px] text-subtle mt-1">JPG, PNG, WebP or GIF. Resized to 1600px and saved as WebP.</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Event Date</label>
                    <input type="date" name="event_date" class="form-input">
                </div>
                <div>
                    <label class="form-label">Event Time</label>
                    <input type="text" name="event_time" placeholder="e.g. 4:00 PM – 7:00 PM" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Location</label>
                <input type="text" name="location" placeholder="e.g. Clayo Studio, Amravati" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Price</label>
                    <input type="text" name="price" placeholder="e.g. ₹1,200 / Free" class="form-input">
                </div>
                <div>
                    <label class="form-label">Capacity</label>
                    <input type="text" name="capacity" placeholder="e.g. 20 seats" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" placeholder="Short description shown on the website…" class="form-input resize-none"></textarea>
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
                    <h3 class="font-display text-[15px] font-bold text-ink">Edit Event</h3>
                    <p class="text-[11px] text-muted" id="editSubtitle">Update event</p>
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
                <label class="form-label">Replace Image</label>
                <div id="edit_image_preview" class="mb-2 hidden">
                    <img id="edit_image_img" src="" alt="" class="w-full h-32 object-cover rounded-lg border border-line">
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="form-input file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-brand-50 file:text-brand file:text-[12px] file:font-semibold">
                <p class="text-[11px] text-subtle mt-1">Leave empty to keep the current image.</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Event Date</label>
                    <input type="date" name="event_date" id="edit_event_date" class="form-input">
                </div>
                <div>
                    <label class="form-label">Event Time</label>
                    <input type="text" name="event_time" id="edit_event_time" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Location</label>
                <input type="text" name="location" id="edit_location" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Price</label>
                    <input type="text" name="price" id="edit_price" class="form-input">
                </div>
                <div>
                    <label class="form-label">Capacity</label>
                    <input type="text" name="capacity" id="edit_capacity" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" id="edit_description" rows="4" class="form-input resize-none"></textarea>
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
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete this event?</h3>
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
    f.action = BASE + '/events/' + it.id + '/update';
    document.getElementById('edit_title').value       = it.title       || '';
    document.getElementById('edit_event_date').value  = it.event_date  || '';
    document.getElementById('edit_event_time').value  = it.event_time  || '';
    document.getElementById('edit_location').value    = it.location    || '';
    document.getElementById('edit_price').value       = it.price       || '';
    document.getElementById('edit_capacity').value    = it.capacity    || '';
    document.getElementById('edit_description').value = it.description || '';
    document.getElementById('edit_sort_order').value  = it.sort_order  || 0;
    document.getElementById('edit_is_active').value   = String(it.is_active);
    document.getElementById('editSubtitle').textContent = it.title || 'Update event';

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
    document.getElementById('deleteForm').action = BASE + '/events/' + id + '/delete';
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
