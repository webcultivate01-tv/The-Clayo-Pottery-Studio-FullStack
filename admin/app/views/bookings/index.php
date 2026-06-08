<?php
use Calyo\Models\Booking;

$bookings   = $result['data'];
$total      = $result['total'];
$pages      = $result['pages'];
$page       = $result['page'];

$statusMeta = Booking::statusMeta();
$allSvcs    = Booking::allServices();

$exportBase = url('/bookings/export');
$fq         = array_filter($filters);
$filterQs   = $fq ? '&' . http_build_query($fq) : '';
$csvUrl     = $exportBase . '?format=csv' . $filterQs;
$pdfUrl     = $exportBase . '?format=pdf' . $filterQs;

$statusCounts = [];
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Bookings</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> booking<?= $total !== 1 ? 's' : '' ?> total
            <?php if (array_filter($filters)): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
        </p>
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
        <button onclick="openAddModal()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Booking
        </button>
    </div>
</div>

<!-- Status Summary Pills -->
<div class="flex flex-wrap gap-2 mb-4">
    <?php
    $statusOrder = ['pending','confirmed','completed','delivered','cancelled','no_show'];
    $dotColors   = ['pending'=>'#f59e0b','confirmed'=>'#4f46e5','completed'=>'#10b981','delivered'=>'#0891b2','cancelled'=>'#ef4444','no_show'=>'#94a3b8'];
    foreach ($statusOrder as $sk):
        $sm    = $statusMeta[$sk];
        $isActive = ($filters['status'] === $sk);
        $href = url('/bookings') . '?' . http_build_query(array_filter(array_merge($filters, ['status' => $sk, 'page' => 1])));
        $clearHref = url('/bookings') . '?' . http_build_query(array_filter(array_merge($filters, ['status' => '', 'page' => 1])));
    ?>
        <a href="<?= e($isActive ? $clearHref : $href) ?>"
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold border transition <?= $isActive ? $sm['cls'] . ' ring-2 ring-offset-1 ring-current/30' : 'bg-panel border-line text-muted hover:bg-line-soft' ?>">
            <span class="w-1.5 h-1.5 rounded-full" style="background:<?= $dotColors[$sk] ?>"></span>
            <?= $sm['label'] ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Filter Panel -->
<div class="bg-panel rounded-xl border border-line shadow-card mb-5">
    <form method="GET" action="<?= e(url('/bookings')) ?>" id="filterForm">
        <!-- Row 1 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 p-4 pb-3">
            <!-- Search -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search']) ?>"
                        placeholder="Name, phone, email…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <!-- Status -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Status</label>
                <select name="status"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All Statuses</option>
                    <?php foreach ($statusMeta as $sk => $sm): ?>
                        <option value="<?= e($sk) ?>" <?= $filters['status'] === $sk ? 'selected' : '' ?>><?= $sm['label'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Service Group -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Category</label>
                <select name="service_group" id="serviceGroupSelect" onchange="updateServiceOptions()"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All Categories</option>
                    <option value="workshop" <?= $filters['service_group'] === 'workshop' ? 'selected' : '' ?>>Pottery Workshops</option>
                    <option value="studio"   <?= $filters['service_group'] === 'studio'   ? 'selected' : '' ?>>Studio Services</option>
                </select>
            </div>
            <!-- Specific Service -->
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Service</label>
                <select name="service" id="serviceSelect"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All Services</option>
                    <optgroup label="Pottery Workshops">
                        <?php foreach (Booking::WORKSHOP_SERVICES as $s): ?>
                            <option value="<?= e($s) ?>" <?= $filters['service'] === $s ? 'selected' : '' ?>><?= e($s) ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Studio Services">
                        <?php foreach (array_diff(Booking::STUDIO_SERVICES, [Booking::ENQUIRY_SERVICE]) as $s): ?>
                            <option value="<?= e($s) ?>" <?= $filters['service'] === $s ? 'selected' : '' ?>><?= e($s) ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>
        </div>
        <!-- Row 2: quick range + preferred date window -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 px-4 pb-4">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Show</label>
                <select name="quick_range"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <?php foreach (Booking::quickRanges() as $rk => $rl): ?>
                        <option value="<?= e($rk) ?>" <?= ($filters['quick_range'] ?? 'all') === $rk ? 'selected' : '' ?>><?= e($rl) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Preferred Date From</label>
                <input type="date" name="date_from" value="<?= e($filters['date_from']) ?>"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Preferred Date To</label>
                <input type="date" name="date_to" value="<?= e($filters['date_to']) ?>"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
            </div>
        </div>
        <!-- Actions row -->
        <div class="flex items-center justify-between flex-wrap gap-3 px-4 py-3 border-t border-line bg-surface/40 rounded-b-xl">
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand text-white text-[13px] font-semibold hover:opacity-90 transition">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Apply Filters
                </button>
                <?php if (array_filter($filters)): ?>
                    <a href="<?= e(url('/bookings')) ?>"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear All
                    </a>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?= e($csvUrl) ?>"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-line bg-panel text-[13px] text-ink-soft hover:bg-line-soft hover:text-ink transition">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5 text-success"></i> Export Excel
                </a>
                <a href="<?= e($pdfUrl) ?>" target="_blank"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-line bg-panel text-[13px] text-ink-soft hover:bg-line-soft hover:text-ink transition">
                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-danger"></i> Export PDF
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
    <?php if (empty($bookings)): ?>
        <div class="py-16 text-center">
            <i data-lucide="calendar-x" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
            <p class="text-[13px] font-semibold text-ink">No bookings found</p>
            <p class="text-[12px] text-muted mt-1">
                <?= array_filter($filters) ? 'Try adjusting your filters.' : 'Bookings from the website will appear here.' ?>
            </p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-line bg-surface/60">
                        <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted w-8">#</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Customer</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden md:table-cell">Contact</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Service</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden lg:table-cell">Preferred Date</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Status</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden lg:table-cell">Received</th>
                        <th class="text-right px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    <?php
                    $avatarColors = ['brand','accent','success','warn'];
                    $bgMap = ['brand'=>'bg-brand-50 text-brand','accent'=>'bg-accent-50 text-accent','success'=>'bg-success-50 text-success','warn'=>'bg-warn-50 text-warn'];
                    foreach ($bookings as $idx => $b):
                        $colorKey  = $avatarColors[($b['id'] - 1) % count($avatarColors)];
                        $colorCls  = $bgMap[$colorKey];
                        $initials  = strtoupper(substr($b['customer_name'], 0, 1));
                        $sm        = $statusMeta[$b['status']] ?? $statusMeta['pending'];
                        $rowOffset = ($page - 1) * $result['per_page'];
                        $isWorkshop = in_array($b['service'], Booking::WORKSHOP_SERVICES, true);
                    ?>
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <td class="px-5 py-3.5 text-muted font-medium"><?= $rowOffset + $idx + 1 ?></td>

                            <!-- Customer -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg <?= $colorCls ?> grid place-items-center text-[12px] font-bold shrink-0">
                                        <?= e($initials) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-ink leading-snug"><?= e($b['customer_name']) ?></div>
                                        <?php if ($b['dob']): ?>
                                            <div class="text-[11px] text-muted leading-snug">DOB: <?= e(date('d M Y', strtotime($b['dob']))) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact -->
                            <td class="px-4 py-3.5 hidden md:table-cell">
                                <div class="text-ink-soft leading-relaxed">
                                    <?php $waNumber = preg_replace('/\D+/', '', (string) $b['phone']); ?>
                                    <div class="flex items-center gap-1.5">
                                        <?php if (strlen($waNumber) >= 8): ?>
                                            <a href="https://wa.me/<?= e($waNumber) ?>" target="_blank" rel="noopener"
                                                title="Open WhatsApp chat"
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#25D366]/15 text-[#128C7E] hover:bg-[#25D366]/25 transition shrink-0">
                                                <i data-lucide="message-circle" class="w-3 h-3"></i>
                                            </a>
                                        <?php else: ?>
                                            <i data-lucide="phone" class="w-3 h-3 text-subtle shrink-0"></i>
                                        <?php endif; ?>
                                        <?= e($b['phone']) ?>
                                    </div>
                                    <?php if ($b['email']): ?>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <i data-lucide="mail" class="w-3 h-3 text-subtle shrink-0"></i>
                                            <span class="truncate max-w-[150px]"><?= e($b['email']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Service -->
                            <td class="px-4 py-3.5">
                                <div class="max-w-[180px]">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold mb-1
                                        <?= $isWorkshop ? 'bg-accent-50 text-accent' : 'bg-brand-50/60 text-brand-600' ?>">
                                        <i data-lucide="<?= $isWorkshop ? 'layers' : 'wrench' ?>" class="w-2.5 h-2.5"></i>
                                        <?= $isWorkshop ? 'Workshop' : 'Service' ?>
                                    </span>
                                    <div class="text-ink font-medium text-[12px] leading-snug"><?= e($b['service']) ?></div>
                                </div>
                            </td>

                            <!-- Preferred Date -->
                            <td class="px-4 py-3.5 hidden lg:table-cell">
                                <div class="text-ink font-medium"><?= e(date('d M Y', strtotime($b['preferred_date']))) ?></div>
                                <div class="text-[11px] text-muted mt-0.5 flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    <?= e($b['preferred_time']) ?>
                                </div>
                            </td>

                            <!-- Status (inline workflow dropdown: New Order → In Production → Completed) -->
                            <td class="px-4 py-3.5">
                                <form method="POST" action="<?= e(url('/bookings/' . $b['id'] . '/status')) ?>" class="inline-block">
                                    <?= csrf_field() ?>
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="status-select status-<?= e($b['status']) ?>"
                                        aria-label="Change booking status"
                                    >
                                        <?php foreach (Booking::workflowStatuses() as $sk):
                                            $optMeta = $statusMeta[$sk];
                                        ?>
                                            <option value="<?= e($sk) ?>" <?= $b['status'] === $sk ? 'selected' : '' ?>>
                                                <?= e($optMeta['label']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <?php
                                        // If the booking is in an exceptional state (cancelled / no_show),
                                        // include it so the dropdown faithfully reflects the actual value.
                                        if (!in_array($b['status'], Booking::workflowStatuses(), true) && isset($statusMeta[$b['status']])):
                                            $optMeta = $statusMeta[$b['status']];
                                        ?>
                                            <option value="<?= e($b['status']) ?>" selected>
                                                <?= e($optMeta['label']) ?>
                                            </option>
                                        <?php endif; ?>
                                    </select>
                                </form>
                                <?php if (!empty($b['notes'])): ?>
                                    <div class="text-[10px] text-muted mt-1.5 max-w-[140px] truncate" title="<?= e($b['notes']) ?>">
                                        <?= e($b['notes']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Received -->
                            <td class="px-4 py-3.5 text-muted hidden lg:table-cell">
                                <div><?= e(date('d M Y', strtotime($b['created_at']))) ?></div>
                                <div class="text-[11px] mt-0.5 flex items-center gap-1">
                                    <i data-lucide="globe" class="w-3 h-3"></i>
                                    <?= e(ucfirst(str_replace('_', '-', $b['source']))) ?>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        onclick="openViewModal(<?= htmlspecialchars(json_encode($b), ENT_QUOTES) ?>)"
                                        class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-brand-50 hover:text-brand transition"
                                        title="View & Update">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button
                                        onclick="openDeleteModal(<?= (int) $b['id'] ?>, '<?= e(addslashes($b['customer_name'])) ?>')"
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
                    <?php for ($i = 1; $i <= $pages; $i++):
                        $url_i  = url('/bookings') . '?' . http_build_query(array_filter($filters) + ['page' => $i]);
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
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: Add Walk-in Booking (mirrors website form)
════════════════════════════════════════════════════════ -->
<div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('addModal')"></div>
    <div class="relative w-full max-w-2xl flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden" style="max-height:90vh">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-success-50 grid place-items-center">
                    <i data-lucide="user-plus" class="w-4 h-4 text-success"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add Walk-in Booking</h3>
                    <p class="text-[11px] text-muted">Customer arrived in person · same data as the public form</p>
                </div>
            </div>
            <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Scrollable body -->
        <form method="POST" action="<?= e(url('/bookings/store')) ?>"
              class="flex-1 overflow-y-auto px-6 py-5 space-y-5"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>

            <!-- Customer block -->
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-2.5">Customer</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="sm:col-span-2">
                        <label class="bk-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" required maxlength="150"
                            class="bk-input" placeholder="Customer's full name">
                    </div>
                    <div>
                        <label class="bk-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" required maxlength="40"
                            class="bk-input" placeholder="e.g. 9876543210">
                    </div>
                    <div>
                        <label class="bk-label">Email</label>
                        <input type="email" name="email" maxlength="190"
                            class="bk-input" placeholder="optional">
                    </div>
                    <div>
                        <label class="bk-label">Date of Birth</label>
                        <input type="date" name="dob" class="bk-input">
                    </div>
                    <div>
                        <label class="bk-label">Source</label>
                        <select name="source" class="bk-input">
                            <option value="walk_in" selected>Walk-in</option>
                            <option value="phone">Phone enquiry</option>
                            <option value="admin">Added by admin</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="bk-label">Address</label>
                        <textarea name="address" rows="2" class="bk-input resize-none" placeholder="optional"></textarea>
                    </div>
                </div>
            </div>

            <!-- Booking block -->
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-2.5">Booking Details</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="sm:col-span-2">
                        <label class="bk-label">Service <span class="text-danger">*</span></label>
                        <select name="service" required class="bk-input">
                            <option value="">— Select a service —</option>
                            <optgroup label="Pottery Workshops">
                                <?php foreach (Booking::WORKSHOP_SERVICES as $s): ?>
                                    <option value="<?= e($s) ?>"><?= e($s) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Studio Services">
                                <?php foreach (array_diff(Booking::STUDIO_SERVICES, [Booking::ENQUIRY_SERVICE]) as $s): ?>
                                    <option value="<?= e($s) ?>"><?= e($s) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label class="bk-label">Preferred Date <span class="text-danger">*</span></label>
                        <input type="date" name="preferred_date" required class="bk-input"
                            value="<?= e(date('Y-m-d')) ?>" min="<?= e(date('Y-m-d')) ?>">
                    </div>
                    <div>
                        <label class="bk-label">Preferred Time <span class="text-danger">*</span></label>
                        <select name="preferred_time" required class="bk-input">
                            <option value="">— Select a slot —</option>
                            <?php
                            $slots = ['10:00 AM','11:00 AM','12:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM'];
                            foreach ($slots as $slot): ?>
                                <option value="<?= e($slot) ?>"><?= e($slot) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="bk-label">Customer Message</label>
                        <textarea name="message" rows="2" class="bk-input resize-none"
                            placeholder="Anything the customer said (special requests, group size, …)"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="bk-label">Admin Notes <span class="text-muted font-normal normal-case tracking-normal">(internal)</span></label>
                        <textarea name="notes" rows="2" class="bk-input resize-none"
                            placeholder="Internal notes — not shown to customer"></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Save Booking
                </button>
                <button type="button" onclick="closeModal('addModal')"
                    class="px-5 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: View & Update Booking
════════════════════════════════════════════════════════ -->
<div id="viewModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('viewModal')"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-lg flex flex-col bg-panel shadow-pop">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                    <i data-lucide="calendar-check" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Booking Details</h3>
                    <p class="text-[11px] text-muted" id="viewModalSubtitle">Update status and notes</p>
                </div>
            </div>
            <button onclick="closeModal('viewModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Scrollable body -->
        <div class="flex-1 overflow-y-auto px-6 py-5" style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">

            <!-- Customer info card -->
            <div class="bg-surface rounded-xl border border-line p-4 mb-5 space-y-2.5">
                <div class="flex items-center gap-2 text-[13px]">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="font-semibold text-ink" id="vw_name"></span>
                </div>
                <div class="flex items-center gap-2 text-[13px]">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="vw_phone"></span>
                    <a id="vw_whatsapp" href="#" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#25D366]/15 text-[#128C7E] text-[11px] font-semibold hover:bg-[#25D366]/25 transition">
                        <i data-lucide="message-circle" class="w-3 h-3"></i> WhatsApp
                    </a>
                </div>
                <div class="flex items-center gap-2 text-[13px]" id="vw_email_row">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="vw_email"></span>
                </div>
                <div class="flex items-center gap-2 text-[13px]" id="vw_dob_row">
                    <i data-lucide="cake" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="vw_dob"></span>
                </div>
                <div class="flex items-start gap-2 text-[13px]" id="vw_address_row">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-subtle shrink-0 mt-0.5"></i>
                    <span class="text-ink-soft" id="vw_address"></span>
                </div>
            </div>

            <!-- Booking details card -->
            <div class="bg-surface rounded-xl border border-line p-4 mb-5 space-y-2.5">
                <div class="flex items-start gap-2 text-[13px]">
                    <i data-lucide="layers" class="w-3.5 h-3.5 text-subtle shrink-0 mt-0.5"></i>
                    <span class="text-ink font-medium" id="vw_service"></span>
                </div>
                <div class="flex items-center gap-2 text-[13px]">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="vw_date"></span>
                    <span class="text-subtle mx-1">·</span>
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="vw_time"></span>
                </div>
                <div class="flex items-start gap-2 text-[13px]" id="vw_message_row">
                    <i data-lucide="message-square" class="w-3.5 h-3.5 text-subtle shrink-0 mt-0.5"></i>
                    <span class="text-muted italic" id="vw_message"></span>
                </div>
            </div>

            <!-- Reference images (up to 3) -->
            <div class="mb-5">
                <div class="flex items-center justify-between mb-2">
                    <label class="bk-label !mb-0">Reference Images</label>
                    <span class="text-[11px] text-muted"><span id="vw_img_count">0</span> / <?= Booking::MAX_REFERENCE_IMAGES ?></span>
                </div>

                <!-- Thumbnails grid -->
                <div id="vw_img_grid" class="grid grid-cols-3 gap-2 mb-3"></div>

                <!-- Add image -->
                <button type="button" id="vw_img_add_btn"
                    onclick="document.getElementById('vw_img_input').click()"
                    class="w-full py-2.5 rounded-xl border border-dashed border-line text-[12px] text-muted hover:bg-surface hover:text-ink hover:border-brand/40 transition flex items-center justify-center gap-2">
                    <i data-lucide="image-plus" class="w-4 h-4"></i>
                    Add reference image
                </button>
                <input type="file" id="vw_img_input" accept="image/*" class="hidden" onchange="onPickImage(event)">

                <p class="text-[10px] text-muted mt-1.5">
                    JPG / PNG / WebP · resized to 1600px max · auto-converted to WebP for fast loading.
                </p>
            </div>

            <!-- Update status form -->
            <form id="updateForm" action="" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="bk-label">Update Status</label>
                    <select name="status" id="vw_status_select"
                        class="bk-input">
                        <option value="pending">New Order</option>
                        <option value="confirmed">In Production</option>
                        <option value="completed">Completed</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="no_show">No Show</option>
                    </select>
                </div>
                <div>
                    <label class="bk-label">Admin Notes</label>
                    <textarea name="notes" id="vw_notes" rows="3" placeholder="Internal notes (not shown to customer)…"
                        class="bk-input resize-none"></textarea>
                </div>
                <div class="pt-2 flex gap-3">
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeModal('viewModal')"
                        class="px-5 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: Crop & Upload Reference Image
════════════════════════════════════════════════════════ -->
<div id="cropModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCrop()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative bg-panel rounded-2xl shadow-pop w-full max-w-2xl flex flex-col" style="max-height:90vh">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-line shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-accent-50 grid place-items-center">
                        <i data-lucide="crop" class="w-4 h-4 text-accent"></i>
                    </div>
                    <div>
                        <h3 class="font-display text-[15px] font-bold text-ink">Crop Reference Image</h3>
                        <p class="text-[11px] text-muted">Adjust the frame, then upload</p>
                    </div>
                </div>
                <button onclick="closeCrop()" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <div class="px-5 py-4 overflow-hidden flex-1">
                <div class="bg-slate-900 rounded-xl overflow-hidden" style="max-height:60vh">
                    <img id="cropImage" alt="" style="display:block;max-width:100%;max-height:60vh">
                </div>
            </div>

            <div class="px-5 py-3 border-t border-line flex items-center justify-between gap-2 bg-surface/40 rounded-b-2xl shrink-0">
                <div class="flex items-center gap-1.5">
                    <button onclick="cropper && cropper.rotate(-90)" title="Rotate left"
                        class="w-9 h-9 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </button>
                    <button onclick="cropper && cropper.rotate(90)" title="Rotate right"
                        class="w-9 h-9 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                    </button>
                    <button onclick="cropper && cropper.reset()" title="Reset"
                        class="w-9 h-9 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="closeCrop()" type="button"
                        class="px-4 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        Cancel
                    </button>
                    <button onclick="confirmCrop()" type="button" id="cropConfirmBtn"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        <span id="cropConfirmLabel">Upload</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: Lightbox – view full image
════════════════════════════════════════════════════════ -->
<div id="lightbox" class="fixed inset-0 z-[60] hidden bg-slate-900/85 backdrop-blur-sm" onclick="closeLightbox(event)">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 text-white grid place-items-center hover:bg-white/20 transition">
        <i data-lucide="x" class="w-5 h-5"></i>
    </button>
    <div class="absolute inset-0 flex items-center justify-center p-6 pointer-events-none">
        <img id="lightboxImg" src="" alt="" class="max-w-full max-h-full rounded-xl shadow-pop pointer-events-auto">
    </div>
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: Delete Confirm
════════════════════════════════════════════════════════ -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
    <div class="relative bg-panel rounded-2xl shadow-pop w-full max-w-sm p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-danger-50 grid place-items-center mx-auto mb-4">
            <i data-lucide="trash-2" class="w-5 h-5 text-danger"></i>
        </div>
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete Booking?</h3>
        <p class="text-[13px] text-muted mb-5">
            Booking from <strong id="deleteBookingName" class="text-ink"></strong> will be permanently removed.<br>
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
.bk-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #64748b;
    margin-bottom: 6px;
}
.bk-input {
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
.bk-input:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
}
.bk-input::placeholder { color: #94a3b8; }

/* ── Inline status dropdown pill ────────────────────────────────── */
.status-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 20 20' fill='none'><path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.8' d='m6 8 4 4 4-4'/></svg>");
    background-position: right 8px center;
    background-repeat: no-repeat;
    background-size: 10px;
    padding: 4px 24px 4px 12px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 999px;
    border: 1px solid;
    cursor: pointer;
    transition: filter .15s, box-shadow .15s;
    line-height: 1.4;
    min-width: 130px;
}
.status-select:hover { filter: brightness(0.96); }
.status-select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.18);
}
.status-pending   { color:#b45309; background-color:#fef3c7; border-color:rgba(245,158,11,.35); }
.status-confirmed { color:#4f46e5; background-color:#eef2ff; border-color:rgba(79,70,229,.35); }
.status-completed { color:#047857; background-color:#d1fae5; border-color:rgba(16,185,129,.35); }
.status-delivered { color:#0e7490; background-color:#ecfeff; border-color:rgba(8,145,178,.35); }
.status-cancelled { color:#b91c1c; background-color:#fee2e2; border-color:rgba(239,68,68,.35); }
.status-no_show   { color:#475569; background-color:#f1f5f9; border-color:rgba(148,163,184,.35); }
.status-select option { color:#0f172a; background:#ffffff; font-weight:500; }
</style>

<!-- Cropper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.css">
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.js"></script>

<script>
var BASE        = '<?= e(rtrim(url(''), '/')) ?>';
var PUBLIC_BASE = '<?= e(rtrim(public_url(''), '/')) ?>';
var CSRF_TOKEN  = '<?= e(csrf_token()) ?>';
var MAX_IMAGES  = <?= (int) Booking::MAX_REFERENCE_IMAGES ?>;

// Pre-decoded reference images, keyed by booking id
var BOOKING_IMAGES = <?= json_encode(array_column(array_map(function ($b) {
    return ['id' => (int) $b['id'], 'images' => Booking::decodeImages($b['reference_images'] ?? null)];
}, $bookings), 'images', 'id')) ?: '{}' ?>;

var currentBookingId = null;

var workshopServices = <?= json_encode(Booking::WORKSHOP_SERVICES) ?>;
var studioServices   = <?= json_encode(array_values(array_diff(Booking::STUDIO_SERVICES, [Booking::ENQUIRY_SERVICE]))) ?>;

function updateServiceOptions() {
    var group  = document.getElementById('serviceGroupSelect').value;
    var select = document.getElementById('serviceSelect');
    var current = select.value;

    // Clear
    while (select.options.length > 1) select.remove(1);

    var list = group === 'workshop' ? workshopServices : (group === 'studio' ? studioServices : null);
    if (!list) {
        // Rebuild both groups
        var wg = document.createElement('optgroup');
        wg.label = 'Pottery Workshops';
        workshopServices.forEach(function(s) {
            var o = new Option(s, s); if (s === current) o.selected = true;
            wg.appendChild(o);
        });
        var sg = document.createElement('optgroup');
        sg.label = 'Studio Services';
        studioServices.forEach(function(s) {
            var o = new Option(s, s); if (s === current) o.selected = true;
            sg.appendChild(o);
        });
        select.appendChild(wg);
        select.appendChild(sg);
    } else {
        list.forEach(function(s) {
            var o = new Option(s, s); if (s === current) o.selected = true;
            select.appendChild(o);
        });
    }
}

function openViewModal(b) {
    currentBookingId = b.id;

    document.getElementById('viewModalSubtitle').textContent = b.customer_name;
    document.getElementById('vw_name').textContent    = b.customer_name;
    document.getElementById('vw_phone').textContent   = b.phone;

    // WhatsApp link (only digits, drop leading + and spaces)
    var waLink = document.getElementById('vw_whatsapp');
    var digits = (b.phone || '').replace(/\D+/g, '');
    if (digits.length >= 8) {
        waLink.href = 'https://wa.me/' + digits;
        waLink.style.display = 'inline-flex';
    } else {
        waLink.style.display = 'none';
    }

    renderReferenceImages(b.id);

    var emailRow = document.getElementById('vw_email_row');
    if (b.email) {
        document.getElementById('vw_email').textContent = b.email;
        emailRow.style.display = 'flex';
    } else {
        emailRow.style.display = 'none';
    }

    var dobRow = document.getElementById('vw_dob_row');
    if (b.dob) {
        document.getElementById('vw_dob').textContent = 'DOB: ' + b.dob;
        dobRow.style.display = 'flex';
    } else {
        dobRow.style.display = 'none';
    }

    var addrRow = document.getElementById('vw_address_row');
    if (b.address) {
        document.getElementById('vw_address').textContent = b.address;
        addrRow.style.display = 'flex';
    } else {
        addrRow.style.display = 'none';
    }

    document.getElementById('vw_service').textContent = b.service;
    document.getElementById('vw_date').textContent    = b.preferred_date;
    document.getElementById('vw_time').textContent    = b.preferred_time;

    var msgRow = document.getElementById('vw_message_row');
    if (b.message) {
        document.getElementById('vw_message').textContent = b.message;
        msgRow.style.display = 'flex';
    } else {
        msgRow.style.display = 'none';
    }

    document.getElementById('vw_status_select').value = b.status || 'pending';
    document.getElementById('vw_notes').value          = b.notes || '';
    document.getElementById('updateForm').action       = BASE + '/bookings/' + b.id + '/status';

    document.getElementById('viewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action         = BASE + '/bookings/' + id + '/delete';
    document.getElementById('deleteBookingName').textContent = name;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}

function openAddModal() {
    var modal = document.getElementById('addModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    // Reset form so reopening shows fresh fields
    var form = modal.querySelector('form');
    if (form) form.reset();
    if (window.lucide) lucide.createIcons();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['addModal','viewModal','deleteModal','cropModal','lightbox'].forEach(closeModal);
        closeCrop();
    }
});

// ═════════════════════════════════════════════════════════════════
// Reference Images — list, upload (with crop), delete, lightbox
// ═════════════════════════════════════════════════════════════════

function renderReferenceImages(bookingId) {
    var imgs   = BOOKING_IMAGES[bookingId] || [];
    var grid   = document.getElementById('vw_img_grid');
    var count  = document.getElementById('vw_img_count');
    var addBtn = document.getElementById('vw_img_add_btn');

    count.textContent = imgs.length;
    grid.innerHTML = '';

    imgs.forEach(function(path, idx) {
        var url   = PUBLIC_BASE + '/' + path;
        var cell  = document.createElement('div');
        cell.className = 'relative group aspect-square rounded-lg overflow-hidden border border-line bg-surface';
        cell.innerHTML =
            '<img src="' + url + '" alt="" class="w-full h-full object-cover cursor-pointer" onclick="openLightbox(\'' + url + '\')">' +
            '<button type="button" onclick="deleteReferenceImage(' + bookingId + ',' + idx + ')" ' +
                'class="absolute top-1 right-1 w-6 h-6 rounded-full bg-slate-900/75 text-white grid place-items-center opacity-0 group-hover:opacity-100 transition" ' +
                'title="Remove image">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>' +
            '</button>';
        grid.appendChild(cell);
    });

    // Hide the "add" button when limit reached
    addBtn.style.display = imgs.length >= MAX_IMAGES ? 'none' : 'flex';

    // Reset file input value so picking the same file again re-fires `change`
    document.getElementById('vw_img_input').value = '';
}

// ── Cropper.js wiring ────────────────────────────────────────────

var cropper = null;

function onPickImage(e) {
    var file = e.target.files && e.target.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
        alert('Please choose an image file.');
        return;
    }
    var reader = new FileReader();
    reader.onload = function(ev) {
        var img = document.getElementById('cropImage');
        img.src = ev.target.result;
        document.getElementById('cropModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (window.lucide) lucide.createIcons();

        if (cropper) { cropper.destroy(); cropper = null; }
        cropper = new Cropper(img, {
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.92,
            background: false,
            responsive: true,
            zoomable: true
        });
    };
    reader.readAsDataURL(file);
}

function closeCrop() {
    var m = document.getElementById('cropModal');
    if (m.classList.contains('hidden')) return;
    m.classList.add('hidden');
    document.body.style.overflow = '';
    if (cropper) { cropper.destroy(); cropper = null; }
    document.getElementById('vw_img_input').value = '';
}

function confirmCrop() {
    if (!cropper || !currentBookingId) return;

    var btn   = document.getElementById('cropConfirmBtn');
    var label = document.getElementById('cropConfirmLabel');
    btn.disabled = true;
    label.textContent = 'Uploading…';

    cropper.getCroppedCanvas({
        maxWidth:  1600,
        maxHeight: 1600,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    }).toBlob(function(blob) {
        if (!blob) {
            alert('Could not generate cropped image.');
            btn.disabled = false; label.textContent = 'Upload';
            return;
        }
        var fd = new FormData();
        fd.append('_csrf', CSRF_TOKEN);
        fd.append('image', blob, 'reference.jpg');

        fetch(BASE + '/bookings/' + currentBookingId + '/images', {
            method:      'POST',
            body:        fd,
            credentials: 'same-origin'
        }).then(function(resp) {
            // Controller redirects on success; reload to pick up the new image.
            window.location.reload();
        }).catch(function() {
            alert('Upload failed. Please try again.');
            btn.disabled = false; label.textContent = 'Upload';
        });
    }, 'image/jpeg', 0.92);
}

function deleteReferenceImage(bookingId, index) {
    if (!confirm('Remove this reference image?')) return;

    var fd = new FormData();
    fd.append('_csrf', CSRF_TOKEN);
    fd.append('index', index);

    fetch(BASE + '/bookings/' + bookingId + '/images/delete', {
        method:      'POST',
        body:        fd,
        credentials: 'same-origin'
    }).then(function() {
        window.location.reload();
    }).catch(function() {
        alert('Delete failed. Please try again.');
    });
}

// ── Lightbox ─────────────────────────────────────────────────────

function openLightbox(url) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
    if (e && e.target && e.target.tagName === 'IMG') return; // don't close on image click
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
