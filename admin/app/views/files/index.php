<?php
use Calyo\Models\Booking;

/** @var array $bookings */
/** @var int   $totalImages */

$cardCount = count($bookings);

// Build JS-friendly map of booking id -> images array
$imageMap = [];
foreach ($bookings as $b) {
    $imageMap[(int) $b['id']] = $b['images'];
}
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Files</h2>
        <p class="text-[13px] text-muted mt-0.5">
            Reference images attached to delivered bookings.
            <?php if ($cardCount > 0): ?>
                <span class="text-ink-soft font-medium">
                    <?= $cardCount ?> booking<?= $cardCount !== 1 ? 's' : '' ?> ·
                    <?= $totalImages ?> image<?= $totalImages !== 1 ? 's' : '' ?>
                </span>
            <?php endif; ?>
        </p>
    </div>
    <div class="flex items-center gap-2">
        <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-line bg-panel text-[12px] text-muted">
            <i data-lucide="hard-drive" class="w-3.5 h-3.5 text-brand"></i>
            Delete to free storage
        </span>
    </div>
</div>

<!-- Intro / how-to strip -->
<div class="bg-panel rounded-xl border border-line shadow-card mb-5 px-4 py-3 flex items-start gap-3">
    <div class="w-9 h-9 rounded-lg bg-warn-50 grid place-items-center shrink-0">
        <i data-lucide="info" class="w-4 h-4 text-warn"></i>
    </div>
    <div class="text-[12.5px] text-ink-soft leading-relaxed">
        Once a booking is marked <strong class="text-teal">Delivered</strong>, its reference images stay on disk.
        Click a card to preview images and remove ones you no longer need —
        deletes are removed from the database <em>and</em> from <code class="text-[11px] bg-line-soft px-1 py-0.5 rounded">/public/uploads/bookings/</code>.
    </div>
</div>

<?php if ($cardCount === 0): ?>
    <!-- Empty state -->
    <div class="bg-panel rounded-xl border border-line shadow-card py-16 text-center">
        <div class="w-14 h-14 rounded-2xl bg-success-50 grid place-items-center mx-auto mb-3">
            <i data-lucide="folder-check" class="w-6 h-6 text-success"></i>
        </div>
        <p class="text-[14px] font-semibold text-ink">No delivered booking files</p>
        <p class="text-[12.5px] text-muted mt-1 max-w-sm mx-auto">
            When a booking with reference images is marked delivered, it will show up here so you can clear out its files.
        </p>
        <a href="<?= e(url('/bookings')) ?>"
            class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
            <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i> Go to Bookings
        </a>
    </div>
<?php else: ?>

    <!-- Cards grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php foreach ($bookings as $b):
            $images   = $b['images'];
            $imgCount = count($images);
            $coverUrl = public_url($images[0]);
            $extra    = max(0, $imgCount - 1);
        ?>
            <button type="button"
                onclick="openFilesModal(<?= (int) $b['id'] ?>)"
                class="text-left bg-panel rounded-xl border border-line shadow-card overflow-hidden hover:border-brand/40 hover:shadow-pop transition group">

                <!-- Cover -->
                <div class="relative aspect-[16/10] bg-surface overflow-hidden">
                    <img src="<?= e($coverUrl) ?>" alt=""
                        class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500">
                    <!-- Image count chip -->
                    <span class="absolute top-2.5 left-2.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-900/70 text-white text-[11px] font-semibold backdrop-blur-sm">
                        <i data-lucide="images" class="w-3 h-3"></i>
                        <?= $imgCount ?> image<?= $imgCount !== 1 ? 's' : '' ?>
                    </span>
                    <!-- Delivered pill -->
                    <span class="absolute top-2.5 right-2.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-teal-50 text-teal text-[11px] font-semibold border border-teal/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal"></span>
                        Delivered
                    </span>
                    <!-- "+N more" stack hint -->
                    <?php if ($extra > 0): ?>
                        <span class="absolute bottom-2.5 right-2.5 inline-flex items-center gap-1 px-2 py-1 rounded-md bg-slate-900/65 text-white text-[10.5px] font-semibold">
                            +<?= $extra ?> more
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Meta -->
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-1.5">
                        <h3 class="font-semibold text-ink text-[14px] leading-snug truncate"><?= e($b['customer_name']) ?></h3>
                        <span class="text-[11px] text-muted shrink-0">#<?= (int) $b['id'] ?></span>
                    </div>
                    <div class="text-[12px] text-muted leading-relaxed space-y-1">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="layers" class="w-3 h-3 text-subtle shrink-0"></i>
                            <span class="truncate"><?= e($b['service']) ?></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="calendar" class="w-3 h-3 text-subtle shrink-0"></i>
                            <span><?= e(date('d M Y', strtotime($b['preferred_date']))) ?></span>
                            <span class="text-subtle">·</span>
                            <i data-lucide="clock" class="w-3 h-3 text-subtle shrink-0"></i>
                            <span><?= e($b['preferred_time']) ?></span>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-line flex items-center justify-between">
                        <span class="text-[11px] text-muted">
                            Updated <?= e(date('d M Y', strtotime($b['updated_at'] ?: $b['created_at']))) ?>
                        </span>
                        <span class="inline-flex items-center gap-1 text-[12px] font-semibold text-brand group-hover:gap-2 transition-all">
                            View files
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>
                </div>
            </button>
        <?php endforeach; ?>
    </div>

<?php endif; ?>


<!-- ════════════════════════════════════════════════════════
     MODAL: Files for a booking
════════════════════════════════════════════════════════ -->
<div id="filesModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeFilesModal()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl flex flex-col bg-panel shadow-pop">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-9 h-9 rounded-lg bg-brand-50 grid place-items-center shrink-0">
                    <i data-lucide="folder-open" class="w-4 h-4 text-brand"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-display text-[15px] font-bold text-ink truncate" id="fm_title">Reference Images</h3>
                    <p class="text-[11px] text-muted truncate" id="fm_subtitle">Click an image to view, trash to remove.</p>
                </div>
            </div>
            <button onclick="closeFilesModal()" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition shrink-0">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Meta + actions -->
        <div class="px-6 py-3 border-b border-line flex items-center justify-between gap-2 bg-surface/40">
            <div class="text-[12px] text-muted flex items-center gap-2">
                <i data-lucide="images" class="w-3.5 h-3.5 text-subtle"></i>
                <span><span id="fm_count">0</span> image(s)</span>
            </div>
            <button type="button" id="fm_delete_all_btn" onclick="deleteAllFiles()"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-danger/30 text-[12px] font-semibold text-danger hover:bg-danger-50 transition">
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                Delete all
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto px-6 py-5" style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <div id="fm_grid" class="grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
            <div id="fm_empty" class="hidden text-center py-10">
                <div class="w-12 h-12 rounded-2xl bg-success-50 grid place-items-center mx-auto mb-3">
                    <i data-lucide="check" class="w-5 h-5 text-success"></i>
                </div>
                <p class="text-[13px] font-semibold text-ink">All files cleared</p>
                <p class="text-[12px] text-muted mt-1">This booking has no reference images left.</p>
            </div>
        </div>
    </div>
</div>


<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 z-[60] hidden bg-slate-900/85 backdrop-blur-sm" onclick="closeLightbox(event)">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 text-white grid place-items-center hover:bg-white/20 transition">
        <i data-lucide="x" class="w-5 h-5"></i>
    </button>
    <div class="absolute inset-0 flex items-center justify-center p-6 pointer-events-none">
        <img id="lightboxImg" src="" alt="" class="max-w-full max-h-full rounded-xl shadow-pop pointer-events-auto">
    </div>
</div>


<script>
var BASE        = '<?= e(rtrim(url(''), '/')) ?>';
var PUBLIC_BASE = '<?= e(rtrim(public_url(''), '/')) ?>';
var CSRF_TOKEN  = '<?= e(csrf_token()) ?>';

// Map of booking id → { name, images: [path,…] }
var FILES = <?= json_encode(array_map(function ($b) {
    return [
        'name'    => $b['customer_name'],
        'service' => $b['service'],
        'images'  => $b['images'],
    ];
}, array_combine(array_map(fn($b) => (int) $b['id'], $bookings), $bookings))) ?: '{}' ?>;

var currentBookingId = null;

function openFilesModal(bookingId) {
    currentBookingId = bookingId;
    var entry = FILES[bookingId];
    if (!entry) return;

    document.getElementById('fm_title').textContent    = entry.name;
    document.getElementById('fm_subtitle').textContent = entry.service;

    renderFiles();

    document.getElementById('filesModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function closeFilesModal() {
    document.getElementById('filesModal').classList.add('hidden');
    document.body.style.overflow = '';
    currentBookingId = null;
}

function renderFiles() {
    if (!currentBookingId) return;
    var entry = FILES[currentBookingId] || { images: [] };
    var imgs  = entry.images || [];

    document.getElementById('fm_count').textContent = imgs.length;

    var grid    = document.getElementById('fm_grid');
    var empty   = document.getElementById('fm_empty');
    var delAll  = document.getElementById('fm_delete_all_btn');

    grid.innerHTML = '';

    if (imgs.length === 0) {
        empty.classList.remove('hidden');
        grid.classList.add('hidden');
        delAll.disabled = true;
        delAll.classList.add('opacity-40', 'pointer-events-none');
        return;
    }

    empty.classList.add('hidden');
    grid.classList.remove('hidden');
    delAll.disabled = false;
    delAll.classList.remove('opacity-40', 'pointer-events-none');

    imgs.forEach(function (path, idx) {
        var url = PUBLIC_BASE + '/' + path;
        var cell = document.createElement('div');
        cell.className = 'relative group aspect-square rounded-lg overflow-hidden border border-line bg-surface';
        cell.innerHTML =
            '<img src="' + url + '" alt="" class="w-full h-full object-cover cursor-pointer" onclick="openLightbox(\'' + url + '\')">' +
            '<div class="absolute inset-x-0 bottom-0 px-2 py-1.5 bg-gradient-to-t from-slate-900/75 to-transparent flex items-center justify-between">' +
                '<span class="text-[10.5px] text-white/90 font-semibold">#' + (idx + 1) + '</span>' +
                '<button type="button" onclick="deleteFile(' + idx + ')" ' +
                    'class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-danger/90 text-white text-[10.5px] font-semibold hover:bg-danger transition" ' +
                    'title="Delete this image">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>' +
                    'Delete' +
                '</button>' +
            '</div>';
        grid.appendChild(cell);
    });

    if (window.lucide) lucide.createIcons();
}

function deleteFile(index) {
    if (!currentBookingId) return;
    if (!confirm('Delete this reference image? It will be removed from disk and the database.')) return;

    var bookingId = currentBookingId;

    var fd = new FormData();
    fd.append('_csrf', CSRF_TOKEN);
    fd.append('index', index);

    fetch(BASE + '/bookings/' + bookingId + '/images/delete', {
        method:      'POST',
        body:        fd,
        credentials: 'same-origin'
    }).then(function (resp) {
        if (!resp.ok && resp.status !== 302) throw new Error('Delete failed');
        // Update local state
        var entry = FILES[bookingId];
        if (entry && entry.images) entry.images.splice(index, 1);
        renderFiles();

        // If this booking has no images left, drop its card from the page
        if (!entry || !entry.images || entry.images.length === 0) {
            removeBookingCard(bookingId);
        } else {
            updateCardCount(bookingId, entry.images.length, entry.images[0]);
        }
    }).catch(function () {
        alert('Delete failed. Please try again.');
    });
}

function deleteAllFiles() {
    if (!currentBookingId) return;
    var entry = FILES[currentBookingId];
    if (!entry || !entry.images || entry.images.length === 0) return;

    if (!confirm('Delete ALL ' + entry.images.length + ' reference image(s) for this booking? This cannot be undone.')) return;

    var bookingId = currentBookingId;
    var total     = entry.images.length;

    // Delete sequentially from the highest index downward so server-side
    // array indexes stay stable.
    var i = total - 1;

    function step() {
        if (i < 0) {
            FILES[bookingId].images = [];
            renderFiles();
            removeBookingCard(bookingId);
            return;
        }
        var fd = new FormData();
        fd.append('_csrf', CSRF_TOKEN);
        fd.append('index', i);

        fetch(BASE + '/bookings/' + bookingId + '/images/delete', {
            method:      'POST',
            body:        fd,
            credentials: 'same-origin'
        }).then(function () {
            i--;
            step();
        }).catch(function () {
            alert('One of the deletes failed. Reloading…');
            window.location.reload();
        });
    }

    step();
}

function removeBookingCard(bookingId) {
    // Close modal and reload so the page header counters stay accurate.
    closeFilesModal();
    window.location.reload();
}

function updateCardCount(bookingId, newCount, newCoverPath) {
    // Light, optional refresh hint — full reload keeps counters consistent.
    // Doing nothing here is also fine; the next nav/refresh will reflect changes.
}

// ── Lightbox ─────────────────────────────────────────────────────
function openLightbox(url) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
    if (e && e.target && e.target.tagName === 'IMG') return;
    document.getElementById('lightbox').classList.add('hidden');
    // Restore the files modal scroll-lock state if open
    if (!document.getElementById('filesModal').classList.contains('hidden')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('lightbox').classList.contains('hidden')) {
            closeLightbox();
        } else if (!document.getElementById('filesModal').classList.contains('hidden')) {
            closeFilesModal();
        }
    }
});
</script>
