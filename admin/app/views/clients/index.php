<?php
use Calyo\Models\Client;

$clients = $result['data'];
$total   = $result['total'];
$pages   = $result['pages'];
$page    = $result['page'];

$statusMeta = [
    'active'   => ['label' => 'Active',   'cls' => 'bg-success-50 text-success border-success/20'],
    'inactive' => ['label' => 'Inactive', 'cls' => 'bg-warn-50    text-warn    border-warn/20'],
    'archived' => ['label' => 'Archived', 'cls' => 'bg-line-soft  text-muted   border-line'],
];

$avatarColors = [
    'brand'   => ['bg' => 'bg-brand-50',   'text' => 'text-brand'],
    'accent'  => ['bg' => 'bg-accent-50',  'text' => 'text-accent'],
    'success' => ['bg' => 'bg-success-50', 'text' => 'text-success'],
    'warn'    => ['bg' => 'bg-warn-50',    'text' => 'text-warn'],
];
$colorKeys = array_keys($avatarColors);

$exportBase = url('/clients/export');
$fq         = array_filter($filters);
$filterQs   = $fq ? '&' . http_build_query($fq) : '';
$csvUrl     = $exportBase . '?format=csv' . $filterQs;
$pdfUrl     = $exportBase . '?format=pdf' . $filterQs;
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Clients</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> client<?= $total !== 1 ? 's' : '' ?> total
            <?php if (array_filter($filters)): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
        </p>
    </div>
    <button onclick="openAddModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white hover:opacity-90 text-[13px] font-semibold transition shadow-card">
        <i data-lucide="user-plus" class="w-4 h-4"></i> Add Client
    </button>
</div>

<!-- Filter panel -->
<div class="bg-panel rounded-xl border border-line p-4 mb-5 shadow-card">
    <form method="GET" action="<?= e(url('/clients')) ?>" id="filterForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search']) ?>"
                        placeholder="Name, email, phone…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <!-- Status -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Status</label>
                <select name="status"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All Status</option>
                    <?php foreach (['active','inactive','archived'] as $s): ?>
                        <option value="<?= e($s) ?>" <?= $filters['status'] === $s ? 'selected' : '' ?>>
                            <?= ucfirst($s) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Date From -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Joined From</label>
                <input type="date" name="date_from" value="<?= e($filters['date_from']) ?>"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
            </div>
            <!-- Date To -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Joined To</label>
                <input type="date" name="date_to" value="<?= e($filters['date_to']) ?>"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
            </div>
        </div>

        <div class="flex items-center justify-between flex-wrap gap-3 mt-3 pt-3 border-t border-line">
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand text-white text-[13px] font-semibold hover:opacity-90 transition">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Apply
                </button>
                <?php if (array_filter($filters)): ?>
                    <a href="<?= e(url('/clients')) ?>"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
                    </a>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?= e($csvUrl) ?>"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-line bg-panel text-[13px] text-ink-soft hover:bg-line-soft hover:text-ink transition">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5 text-success"></i> Excel
                </a>
                <a href="<?= e($pdfUrl) ?>" target="_blank"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-line bg-panel text-[13px] text-ink-soft hover:bg-line-soft hover:text-ink transition">
                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-danger"></i> PDF
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
    <?php if (empty($clients)): ?>
        <div class="py-16 text-center">
            <i data-lucide="users" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
            <p class="text-[13px] font-semibold text-ink">No clients found</p>
            <p class="text-[12px] text-muted mt-1">
                <?= array_filter($filters) ? 'Try adjusting your filters.' : 'Add your first client to get started.' ?>
            </p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-line bg-surface/60">
                        <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted w-8">#</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Client</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Email</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Phone</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden lg:table-cell">Company</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Status</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden md:table-cell">Joined</th>
                        <th class="text-right px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    <?php foreach ($clients as $idx => $c):
                        $colorKey  = $colorKeys[($c['id'] - 1) % count($colorKeys)];
                        $color     = $avatarColors[$colorKey];
                        $initials  = Client::initials($c);
                        $fullName  = Client::fullName($c);
                        $sm        = $statusMeta[$c['status']] ?? $statusMeta['active'];
                        $waPhone   = Client::waPhone($c['phone'] ?? '');
                        $rowOffset = ($page - 1) * $result['per_page'];
                    ?>
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <!-- # -->
                            <td class="px-5 py-3.5 text-muted font-medium"><?= $rowOffset + $idx + 1 ?></td>

                            <!-- Client -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg <?= $color['bg'] ?> <?= $color['text'] ?> grid place-items-center text-[11px] font-bold shrink-0">
                                        <?= e($initials) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-ink leading-snug"><?= e($fullName) ?></div>
                                        <?php if ($c['company']): ?>
                                            <div class="text-[11px] text-muted leading-snug"><?= e($c['company']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-ink-soft truncate max-w-[180px]"><?= e($c['email'] ?? '—') ?></span>
                                    <?php if ($c['email']): ?>
                                        <a href="mailto:<?= e($c['email']) ?>"
                                            class="opacity-0 group-hover:opacity-100 w-6 h-6 rounded-md bg-brand-50 grid place-items-center text-brand hover:bg-brand hover:text-white transition shrink-0"
                                            title="Send email">
                                            <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Phone -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-ink-soft"><?= e($c['phone'] ?? '—') ?></span>
                                    <?php if ($waPhone): ?>
                                        <a href="https://wa.me/<?= e($waPhone) ?>" target="_blank" rel="noopener"
                                            class="opacity-0 group-hover:opacity-100 w-6 h-6 rounded-md grid place-items-center transition shrink-0"
                                            style="background:#e7f9ee;color:#25d366"
                                            onmouseover="this.style.background='#25d366';this.style.color='#fff'"
                                            onmouseout="this.style.background='#e7f9ee';this.style.color='#25d366'"
                                            title="WhatsApp">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Company (hidden on small) -->
                            <td class="px-4 py-3.5 text-ink-soft hidden lg:table-cell">
                                <?= e($c['company'] ?? '—') ?>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold border <?= $sm['cls'] ?>">
                                    <?= $sm['label'] ?>
                                </span>
                            </td>

                            <!-- Joined -->
                            <td class="px-4 py-3.5 text-muted hidden md:table-cell">
                                <?= e(date('d M Y', strtotime($c['created_at']))) ?>
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($c), ENT_QUOTES) ?>)"
                                        class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-brand-50 hover:text-brand transition"
                                        title="Edit">
                                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button
                                        onclick="openDeleteModal(<?= (int) $c['id'] ?>, '<?= e(addslashes($fullName)) ?>')"
                                        class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-danger-50 hover:text-danger transition"
                                        title="Delete">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($pages > 1): ?>
            <div class="flex items-center justify-between px-5 py-3.5 border-t border-line bg-surface/40">
                <p class="text-[12px] text-muted">
                    Showing <?= (($page - 1) * $result['per_page']) + 1 ?>–<?= min($page * $result['per_page'], $total) ?> of <?= $total ?>
                </p>
                <div class="flex items-center gap-1">
                    <?php
                    $baseUrl = url('/clients') . '?' . http_build_query(array_filter($filters) + ['page' => 1]);
                    for ($i = 1; $i <= $pages; $i++):
                        $url_i = url('/clients') . '?' . http_build_query(array_filter($filters) + ['page' => $i]);
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
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL: Add Client
════════════════════════════════════════════════════════════ -->
<div id="addModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('addModal')"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-md flex flex-col bg-panel shadow-pop">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                    <i data-lucide="user-plus" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add Client</h3>
                    <p class="text-[11px] text-muted">Fill in the client details below</p>
                </div>
            </div>
            <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <!-- Form -->
        <form action="<?= e(url('/clients/store')) ?>" method="POST" class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" required placeholder="e.g. Priya"
                        class="form-input">
                </div>
                <div>
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" placeholder="e.g. Sharma"
                        class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Email Address</label>
                <input type="email" name="email" placeholder="hello@example.com"
                    class="form-input">
            </div>
            <div>
                <label class="form-label">Mobile Number</label>
                <div class="relative">
                    <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="tel" name="phone" placeholder="+91 98765 43210"
                        class="form-input pl-9">
                </div>
            </div>
            <div>
                <label class="form-label">Company / Organisation</label>
                <input type="text" name="company" placeholder="e.g. Artisan Co."
                    class="form-input">
            </div>
            <div>
                <label class="form-label">Address</label>
                <textarea name="address" rows="2" placeholder="Street, City, State"
                    class="form-input resize-none"></textarea>
            </div>
            <div>
                <label class="form-label">Notes</label>
                <textarea name="notes" rows="2" placeholder="Any additional notes…"
                    class="form-input resize-none"></textarea>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Save Client
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
     MODAL: Edit Client
════════════════════════════════════════════════════════════ -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('editModal')"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-md flex flex-col bg-panel shadow-pop">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-warn-50 grid place-items-center">
                    <i data-lucide="pencil" class="w-4 h-4 text-warn"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Edit Client</h3>
                    <p class="text-[11px] text-muted" id="editModalSubtitle">Update client information</p>
                </div>
            </div>
            <button onclick="closeModal('editModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form id="editForm" action="" method="POST" class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="edit_first_name" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="edit_last_name" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Email Address</label>
                <input type="email" name="email" id="edit_email" class="form-input">
            </div>
            <div>
                <label class="form-label">Mobile Number</label>
                <div class="relative">
                    <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="tel" name="phone" id="edit_phone" class="form-input pl-9">
                </div>
            </div>
            <div>
                <label class="form-label">Company / Organisation</label>
                <input type="text" name="company" id="edit_company" class="form-input">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-input">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div>
                <label class="form-label">Address</label>
                <textarea name="address" id="edit_address" rows="2" class="form-input resize-none"></textarea>
            </div>
            <div>
                <label class="form-label">Notes</label>
                <textarea name="notes" id="edit_notes" rows="2" class="form-input resize-none"></textarea>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Update Client
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
     MODAL: Delete Confirm
════════════════════════════════════════════════════════════ -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
    <div class="relative bg-panel rounded-2xl shadow-pop w-full max-w-sm p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-danger-50 grid place-items-center mx-auto mb-4">
            <i data-lucide="trash-2" class="w-5 h-5 text-danger"></i>
        </div>
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete Client?</h3>
        <p class="text-[13px] text-muted mb-5">
            <strong id="deleteClientName" class="text-ink"></strong> will be permanently removed.<br>
            This cannot be undone.
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
</style>

<script>
var BASE = '<?= e(rtrim(url(''), '/')) ?>';

function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openEditModal(c) {
    var f = document.getElementById('editForm');
    f.action = BASE + '/clients/' + c.id + '/update';
    document.getElementById('edit_first_name').value = c.first_name || '';
    document.getElementById('edit_last_name').value  = c.last_name  || '';
    document.getElementById('edit_email').value      = c.email      || '';
    document.getElementById('edit_phone').value      = c.phone      || '';
    document.getElementById('edit_company').value    = c.company    || '';
    document.getElementById('edit_status').value     = c.status     || 'active';
    document.getElementById('edit_address').value    = c.address    || '';
    document.getElementById('edit_notes').value      = c.notes      || '';
    document.getElementById('editModalSubtitle').textContent =
        ((c.first_name || '') + ' ' + (c.last_name || '')).trim();
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = BASE + '/clients/' + id + '/delete';
    document.getElementById('deleteClientName').textContent = name;
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
