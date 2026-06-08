<?php
$u               = current_user();
$recentBookings  = $recentBookings  ?? [];
$monthlyBookings = $monthlyBookings ?? [];
$sourceCounts    = $sourceCounts    ?? [];
?>

<!-- ── Page header ────────────────────────────────────────────── -->
<div class="mb-7 flex items-center justify-between flex-wrap gap-3">
    <p class="text-sm font-medium text-muted"><?= date('l, j F Y') ?></p>
    <div class="flex items-center gap-2 shrink-0">
        <a href="<?= e(url('/bookings')) ?>"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-panel border border-line text-ink-soft hover:bg-line-soft hover:text-ink text-sm font-semibold transition">
            <i data-lucide="calendar-plus" class="w-4 h-4"></i> New Booking
        </a>
        <a href="<?= e(url('/clients')) ?>"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white hover:opacity-95 text-sm font-semibold transition shadow-card">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Add Client
        </a>
    </div>
</div>

<!-- ── KPI tiles ──────────────────────────────────────────────── -->
<?php
$kpis = [
    [
        'label' => 'Total Clients',
        'value' => $stats['total_clients'] ?? 0,
        'sub'   => 'All registered clients',
        'icon'  => 'users',
        'tone'  => 'brand',
        'href'  => url('/clients'),
    ],
    [
        'label' => 'Total Bookings',
        'value' => $stats['total_bookings'] ?? 0,
        'sub'   => ($stats['bookings_this_month'] ?? 0) . ' this month',
        'icon'  => 'calendar-check',
        'tone'  => 'accent',
        'href'  => url('/bookings'),
    ],
    [
        'label' => 'New Orders',
        'value' => $stats['pending_bookings'] ?? 0,
        'sub'   => 'Awaiting confirmation',
        'icon'  => 'clock',
        'tone'  => 'warn',
        'href'  => url('/bookings'),
    ],
    [
        'label' => 'New Enquiries',
        'value' => $stats['new_enquiries'] ?? 0,
        'sub'   => 'General enquiry form',
        'icon'  => 'mail',
        'tone'  => 'success',
        'href'  => url('/enquiries'),
    ],
];
$tones = [
    'brand'   => ['bar' => 'from-brand to-brand-700',     'ibg' => 'bg-brand-50',   'itxt' => 'text-brand',   'lnk' => 'text-brand hover:text-brand-700'],
    'accent'  => ['bar' => 'from-accent to-orange-500',   'ibg' => 'bg-accent-50',  'itxt' => 'text-accent',  'lnk' => 'text-accent hover:text-orange-600'],
    'warn'    => ['bar' => 'from-warn to-yellow-500',     'ibg' => 'bg-warn-50',    'itxt' => 'text-warn',    'lnk' => 'text-warn hover:text-yellow-600'],
    'success' => ['bar' => 'from-success to-emerald-600', 'ibg' => 'bg-success-50', 'itxt' => 'text-success', 'lnk' => 'text-success hover:text-emerald-700'],
];
?>
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
<?php foreach ($kpis as $kpi):
    $t = $tones[$kpi['tone']];
?>
    <div class="bg-panel rounded-2xl border border-line shadow-card hover:shadow-pop transition group overflow-hidden">
        <div class="h-1 bg-gradient-to-r <?= $t['bar'] ?>"></div>
        <div class="p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl <?= $t['ibg'] ?> grid place-items-center <?= $t['itxt'] ?> shrink-0">
                    <i data-lucide="<?= e($kpi['icon']) ?>" class="w-[18px] h-[18px]"></i>
                </div>
                <a href="<?= e($kpi['href']) ?>"
                   class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1 text-[11px] font-semibold <?= $t['lnk'] ?>">
                    View <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="font-display text-[2rem] leading-none font-bold text-ink tracking-tight">
                <?= str_pad((string)(int)$kpi['value'], 2, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="mt-1.5 text-[11px] font-semibold uppercase tracking-wider text-muted"><?= e($kpi['label']) ?></div>
            <div class="mt-0.5 text-xs text-subtle"><?= e($kpi['sub']) ?></div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<!-- ── Charts row ─────────────────────────────────────────────── -->
<?php
$pending   = (int)($stats['pending_bookings']   ?? 0);
$confirmed = (int)($stats['confirmed_bookings'] ?? 0);
$completed = (int)($stats['completed_bookings'] ?? 0);
$delivered = (int)($stats['delivered_bookings'] ?? 0);
$totalB    = $pending + $confirmed + $completed + $delivered;

$srcWebsite = (int)($sourceCounts['website']  ?? 0);
$srcAdmin   = (int)($sourceCounts['admin']    ?? 0);
$srcPhone   = (int)($sourceCounts['phone']    ?? 0);
$srcWalkin  = (int)($sourceCounts['walk_in']  ?? 0);
$totalS     = $srcWebsite + $srcAdmin + $srcPhone + $srcWalkin;
?>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    <!-- Booking Status -->
    <div class="bg-panel rounded-2xl border border-line p-6 shadow-card">
        <div class="flex items-start justify-between mb-1">
            <div>
                <div class="flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-brand"></i>
                    <h3 class="font-display text-base font-bold text-ink">Booking Status</h3>
                </div>
                <p class="text-xs text-muted mt-0.5">Current order pipeline</p>
            </div>
            <a href="<?= e(url('/bookings')) ?>" class="text-xs font-semibold text-brand hover:text-brand-700">View all →</a>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-6 items-center">
            <div class="relative h-52">
                <canvas id="bookingStatusChart"></canvas>
                <div class="absolute inset-0 grid place-items-center pointer-events-none">
                    <div class="text-center">
                        <div class="font-display text-3xl font-bold text-ink leading-none"><?= $totalB ?></div>
                        <div class="text-[10px] uppercase tracking-[0.15em] text-muted mt-1.5 font-semibold">Total</div>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <?php
                $statusRows = [
                    ['New Order',     $pending,   'bg-warn',    $totalB ? round($pending   / $totalB * 100) : 0],
                    ['In Production', $confirmed, 'bg-brand',   $totalB ? round($confirmed / $totalB * 100) : 0],
                    ['Completed',     $completed, 'bg-success', $totalB ? round($completed / $totalB * 100) : 0],
                    ['Delivered',     $delivered, 'bg-teal',    $totalB ? round($delivered / $totalB * 100) : 0],
                ];
                foreach ($statusRows as [$lbl, $val, $dot, $pct]): ?>
                <div>
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="flex items-center gap-2 text-ink-soft font-medium">
                            <span class="w-2 h-2 rounded-full <?= $dot ?> shrink-0"></span>
                            <?= $lbl ?>
                        </span>
                        <span class="font-bold text-ink"><?= $val ?></span>
                    </div>
                    <div class="h-1.5 bg-line rounded-full overflow-hidden">
                        <div class="h-full <?= $dot ?> rounded-full" style="width:<?= $pct ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Booking Sources -->
    <div class="bg-panel rounded-2xl border border-line p-6 shadow-card">
        <div class="flex items-start justify-between mb-1">
            <div>
                <div class="flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-brand"></i>
                    <h3 class="font-display text-base font-bold text-ink">Booking Sources</h3>
                </div>
                <p class="text-xs text-muted mt-0.5">How clients find you</p>
            </div>
            <span class="text-[10px] font-bold tracking-wider uppercase text-muted bg-surface border border-line rounded-md px-2 py-1">All Time</span>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-6 items-center">
            <div class="relative h-52">
                <canvas id="sourceChart"></canvas>
                <div class="absolute inset-0 grid place-items-center pointer-events-none">
                    <div class="text-center">
                        <div class="font-display text-3xl font-bold text-ink leading-none"><?= $totalS ?></div>
                        <div class="text-[10px] uppercase tracking-[0.15em] text-muted mt-1.5 font-semibold">Bookings</div>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <?php
                $srcRows = [
                    ['Website', $srcWebsite, 'bg-brand',   $totalS ? round($srcWebsite / $totalS * 100) : 0],
                    ['Admin',   $srcAdmin,   'bg-accent',  $totalS ? round($srcAdmin   / $totalS * 100) : 0],
                    ['Phone',   $srcPhone,   'bg-success', $totalS ? round($srcPhone   / $totalS * 100) : 0],
                    ['Walk-in', $srcWalkin,  'bg-warn',    $totalS ? round($srcWalkin  / $totalS * 100) : 0],
                ];
                foreach ($srcRows as [$lbl, $val, $dot, $pct]): ?>
                <div>
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="flex items-center gap-2 text-ink-soft font-medium">
                            <span class="w-2 h-2 rounded-full <?= $dot ?> shrink-0"></span>
                            <?= $lbl ?>
                        </span>
                        <span class="font-bold text-ink"><?= $val ?></span>
                    </div>
                    <div class="h-1.5 bg-line rounded-full overflow-hidden">
                        <div class="h-full <?= $dot ?> rounded-full" style="width:<?= $pct ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- ── Monthly Bookings + Recent Bookings ─────────────────────── -->
<?php
$chartLabels    = array_column($monthlyBookings, 'label');
$chartCounts    = array_column($monthlyBookings, 'count');
$totalYear      = array_sum($chartCounts);
$maxCount       = $chartCounts ? max($chartCounts) : 0;
$bestIdx        = $maxCount > 0 ? array_search($maxCount, $chartCounts) : null;
$bestLabel      = $bestIdx !== null ? ($chartLabels[$bestIdx] ?? '—') : '—';
$thisMonthCount = $chartCounts ? end($chartCounts) : 0;
$prevMonthCount = count($chartCounts) > 1 ? $chartCounts[count($chartCounts) - 2] : 0;
$monthTrend     = $prevMonthCount > 0 ? round(($thisMonthCount - $prevMonthCount) / $prevMonthCount * 100) : 0;
?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <!-- Monthly Bookings Bar Chart (2/3) -->
    <div class="lg:col-span-2 bg-panel rounded-2xl border border-line shadow-card overflow-hidden flex flex-col">
        <!-- Card header -->
        <div class="px-6 py-4 border-b border-line flex items-start justify-between shrink-0">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-brand-50 grid place-items-center shrink-0">
                        <i data-lucide="trending-up" class="w-4 h-4 text-brand"></i>
                    </div>
                    <h3 class="font-display text-base font-bold text-ink">Monthly Bookings</h3>
                </div>
                <p class="text-xs text-muted mt-0.5 ml-10">Orders per month · last 12 months</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <?php if ($monthTrend !== 0): ?>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-lg border
                    <?= $monthTrend > 0 ? 'bg-success-50 text-success border-success/20' : 'bg-danger-50 text-danger border-danger/20' ?>">
                    <i data-lucide="<?= $monthTrend > 0 ? 'trending-up' : 'trending-down' ?>" class="w-3 h-3"></i>
                    <?= ($monthTrend > 0 ? '+' : '') . $monthTrend ?>% vs last month
                </span>
                <?php endif; ?>
                <span class="text-[10px] font-bold tracking-wider uppercase text-muted bg-surface border border-line rounded-md px-2 py-1">12 Mo</span>
            </div>
        </div>
        <!-- Chart -->
        <div class="flex-1 px-6 pt-5 pb-2">
            <canvas id="monthlyChart" style="height:200px"></canvas>
        </div>
        <!-- Stats footer -->
        <div class="px-6 py-4 bg-surface/50 border-t border-line grid grid-cols-3 divide-x divide-line shrink-0">
            <div class="text-center px-3">
                <div class="font-display text-2xl font-bold text-ink leading-none"><?= $totalYear ?></div>
                <div class="text-[10px] uppercase tracking-wider text-muted mt-1.5 font-semibold">Year Total</div>
            </div>
            <div class="text-center px-3">
                <div class="flex items-baseline justify-center gap-1.5">
                    <span class="font-display text-2xl font-bold text-ink leading-none"><?= $thisMonthCount ?></span>
                    <?php if ($monthTrend !== 0): ?>
                    <span class="text-xs font-bold <?= $monthTrend > 0 ? 'text-success' : 'text-danger' ?>">
                        <?= ($monthTrend > 0 ? '▲' : '▼') . abs($monthTrend) ?>%
                    </span>
                    <?php endif; ?>
                </div>
                <div class="text-[10px] uppercase tracking-wider text-muted mt-1.5 font-semibold">This Month</div>
            </div>
            <div class="text-center px-3">
                <div class="font-display text-2xl font-bold text-accent leading-none"><?= $maxCount ?></div>
                <div class="text-[10px] uppercase tracking-wider text-muted mt-1.5 font-semibold">Peak · <?= e($bestLabel) ?></div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings (1/3) -->
    <div class="bg-panel rounded-2xl border border-line shadow-card overflow-hidden flex flex-col">
        <div class="px-5 py-4 flex items-center justify-between border-b border-line shrink-0">
            <div>
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar-clock" class="w-4 h-4 text-brand"></i>
                    <h3 class="font-display text-base font-bold text-ink">Recent Bookings</h3>
                </div>
                <p class="text-xs text-muted mt-0.5">Latest orders &amp; sessions</p>
            </div>
            <a href="<?= e(url('/bookings')) ?>"
               class="flex items-center gap-1 text-xs font-semibold text-brand hover:text-brand-700 transition">
                All <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        <?php if ($recentBookings): ?>
        <div class="divide-y divide-line flex-1">
            <?php
            $sm = [
                'pending'   => ['label' => 'New Order',     'cls' => 'bg-warn-50 text-warn border-warn/20'],
                'confirmed' => ['label' => 'In Production', 'cls' => 'bg-brand-50 text-brand border-brand/20'],
                'completed' => ['label' => 'Completed',     'cls' => 'bg-success-50 text-success border-success/20'],
                'delivered' => ['label' => 'Delivered',     'cls' => 'bg-teal-50 text-teal border-teal/20'],
                'cancelled' => ['label' => 'Cancelled',     'cls' => 'bg-danger-50 text-danger border-danger/20'],
                'no_show'   => ['label' => 'No Show',       'cls' => 'bg-line-soft text-muted border-line'],
            ];
            foreach ($recentBookings as $b):
                $badge    = $sm[$b['status']] ?? $sm['pending'];
                $words    = array_filter(explode(' ', trim($b['customer_name'] ?? '')));
                $initials = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice($words, 0, 2)))) ?: '?';
                $bJson    = htmlspecialchars(json_encode($b), ENT_QUOTES);
            ?>
            <div class="px-4 py-3 flex items-center gap-3 hover:bg-surface/60 transition cursor-pointer group"
                 onclick="openBookingDetail(<?= $bJson ?>)">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center text-brand text-[11px] font-bold shrink-0 select-none">
                    <?= e($initials) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-[13px] text-ink truncate group-hover:text-brand transition"><?= e($b['customer_name']) ?></div>
                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-md border text-[10px] font-semibold <?= $badge['cls'] ?>">
                        <?= $badge['label'] ?>
                    </span>
                </div>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-subtle shrink-0 opacity-0 group-hover:opacity-100 transition"></i>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="flex-1 grid place-items-center text-sm text-muted">
            <div class="text-center px-4">
                <i data-lucide="calendar-x" class="w-8 h-8 text-subtle mb-2 mx-auto"></i>
                <p>No bookings yet.</p>
                <a href="<?= e(url('/bookings')) ?>"
                   class="mt-2 inline-block text-xs font-semibold text-brand hover:text-brand-700">
                    Add first booking →
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>

<script>
(function () {
    if (typeof Chart === 'undefined') return;

    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#64748b';

    const baseOpts = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '76%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0f172a',
                titleColor:      '#ffffff',
                bodyColor:       '#e2e8f0',
                padding:         12,
                cornerRadius:    10,
                displayColors:   true,
                boxPadding:      6,
                titleFont:       { weight: '600' },
            },
        },
    };

    const el1 = document.getElementById('bookingStatusChart');
    if (el1) {
        const ds1 = [<?= $pending ?>, <?= $confirmed ?>, <?= $completed ?>, <?= $delivered ?>];
        new Chart(el1, {
            type: 'doughnut',
            data: {
                labels: ['New Order', 'In Production', 'Completed', 'Delivered'],
                datasets: [{
                    data: ds1.every(v => v === 0) ? [1, 1, 1, 1] : ds1,
                    backgroundColor: ['#f59e0b', '#4f46e5', '#10b981', '#0891b2'],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8,
                }],
            },
            options: baseOpts,
        });
    }

    const el2 = document.getElementById('sourceChart');
    if (el2) {
        const ds2 = [<?= $srcWebsite ?>, <?= $srcAdmin ?>, <?= $srcPhone ?>, <?= $srcWalkin ?>];
        new Chart(el2, {
            type: 'doughnut',
            data: {
                labels: ['Website', 'Admin', 'Phone', 'Walk-in'],
                datasets: [{
                    data: ds2.every(v => v === 0) ? [1, 1, 1, 1] : ds2,
                    backgroundColor: ['#4f46e5', '#f97316', '#10b981', '#f59e0b'],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8,
                }],
            },
            options: baseOpts,
        });
    }

    // Monthly bookings bar chart — gradient fill, peak bar highlighted in accent
    const el3 = document.getElementById('monthlyChart');
    if (el3) {
        const ctx3    = el3.getContext('2d');
        const counts3 = <?= json_encode($chartCounts) ?>;
        const labels3 = <?= json_encode($chartLabels) ?>;
        const maxVal3 = counts3.length ? Math.max(...counts3) : 0;
        const peakIdx = maxVal3 > 0 ? counts3.indexOf(maxVal3) : -1;

        const barGrad = ctx3.createLinearGradient(0, 0, 0, 200);
        barGrad.addColorStop(0, 'rgba(79,70,229,0.80)');
        barGrad.addColorStop(1, 'rgba(79,70,229,0.08)');

        const peakGrad = ctx3.createLinearGradient(0, 0, 0, 200);
        peakGrad.addColorStop(0, 'rgba(249,115,22,0.90)');
        peakGrad.addColorStop(1, 'rgba(249,115,22,0.08)');

        new Chart(el3, {
            type: 'bar',
            data: {
                labels: labels3,
                datasets: [{
                    label: 'Bookings',
                    data:  counts3,
                    backgroundColor:      counts3.map((_, i) => i === peakIdx ? peakGrad  : barGrad),
                    hoverBackgroundColor: counts3.map((_, i) => i === peakIdx ? 'rgba(249,115,22,0.95)' : 'rgba(79,70,229,0.92)'),
                    borderWidth:   0,
                    borderRadius:  10,
                    borderSkipped: false,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor:      '#ffffff',
                        bodyColor:       '#e2e8f0',
                        padding:         12,
                        cornerRadius:    10,
                        callbacks: {
                            title: (items) => items[0].label + (items[0].dataIndex === peakIdx ? '  ★ Peak' : ''),
                            label: ctx => '  ' + ctx.parsed.y + (ctx.parsed.y === 1 ? ' booking' : ' bookings'),
                        },
                    },
                },
                scales: {
                    x: {
                        grid:   { display: false },
                        border: { display: false },
                        ticks: {
                            color: (ctx) => ctx.index === peakIdx ? '#f97316' : '#64748b',
                            font:  { size: 11, weight: '500' },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid:   { color: '#f1f3f8', drawBorder: false },
                        border: { display: false },
                        ticks: {
                            color:     '#64748b',
                            font:      { size: 11 },
                            stepSize:  1,
                            precision: 0,
                        },
                    },
                },
            },
        });
    }
})();
</script>

<!-- ── Booking Detail Modal ────────────────────────────────────── -->
<div id="bkDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeBookingDetail()"></div>
    <div class="relative w-full max-w-md bg-panel rounded-2xl shadow-pop overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-line">
            <div class="flex items-center gap-3">
                <div id="bkd_avatar" class="w-10 h-10 rounded-xl bg-brand-50 grid place-items-center text-brand text-sm font-bold shrink-0"></div>
                <div>
                    <div id="bkd_name" class="font-display text-[15px] font-bold text-ink"></div>
                    <div id="bkd_service" class="text-xs text-muted mt-0.5 truncate max-w-[220px]"></div>
                </div>
            </div>
            <button onclick="closeBookingDetail()" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="px-5 py-4 space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-surface rounded-xl p-3">
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-muted mb-1">Date</div>
                    <div id="bkd_date" class="text-sm font-semibold text-ink"></div>
                </div>
                <div class="bg-surface rounded-xl p-3">
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-muted mb-1">Time</div>
                    <div id="bkd_time" class="text-sm font-semibold text-ink"></div>
                </div>
            </div>
            <div class="bg-surface rounded-xl p-3 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-muted mb-1">Status</div>
                    <span id="bkd_status" class="px-2.5 py-1 rounded-lg border text-[11px] font-semibold"></span>
                </div>
                <div class="text-right">
                    <div class="text-[10px] font-semibold uppercase tracking-wider text-muted mb-1">Phone</div>
                    <a id="bkd_phone" href="#" class="text-sm font-semibold text-ink hover:text-brand transition"></a>
                </div>
            </div>
            <div id="bkd_notes_row" class="bg-surface rounded-xl p-3 hidden">
                <div class="text-[10px] font-semibold uppercase tracking-wider text-muted mb-1">Notes</div>
                <div id="bkd_notes" class="text-sm text-ink-soft leading-relaxed"></div>
            </div>
        </div>
        <!-- Footer -->
        <div class="px-5 pb-4 flex gap-2">
            <a id="bkd_wa" href="#" target="_blank" rel="noopener"
               class="flex-1 py-2.5 rounded-xl bg-[#25D366]/10 text-[#128C7E] border border-[#25D366]/20 text-[13px] font-semibold hover:bg-[#25D366]/20 transition flex items-center justify-center gap-2">
                <i data-lucide="message-circle" class="w-4 h-4"></i> WhatsApp
            </a>
            <a id="bkd_viewLink" href="<?= e(url('/bookings')) ?>"
               class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition flex items-center justify-center gap-2">
                <i data-lucide="external-link" class="w-4 h-4"></i> View in Bookings
            </a>
        </div>
    </div>
</div>

<script>
var BOOKING_STATUS_META = {
    pending:   { label: 'New Order',     cls: 'bg-warn-50 text-warn border-warn/20' },
    confirmed: { label: 'In Production', cls: 'bg-brand-50 text-brand border-brand/20' },
    completed: { label: 'Completed',     cls: 'bg-success-50 text-success border-success/20' },
    delivered: { label: 'Delivered',     cls: 'bg-teal-50 text-teal border-teal/20' },
    cancelled: { label: 'Cancelled',     cls: 'bg-danger-50 text-danger border-danger/20' },
    no_show:   { label: 'No Show',       cls: 'bg-line-soft text-muted border-line' },
};

function openBookingDetail(b) {
    var words    = (b.customer_name || '').trim().split(/\s+/).filter(Boolean);
    var initials = words.slice(0, 2).map(function(w) { return w[0].toUpperCase(); }).join('') || '?';
    var meta     = BOOKING_STATUS_META[b.status] || BOOKING_STATUS_META['pending'];
    var digits   = (b.phone || '').replace(/\D+/g, '');

    document.getElementById('bkd_avatar').textContent   = initials;
    document.getElementById('bkd_name').textContent     = b.customer_name || '—';
    document.getElementById('bkd_service').textContent  = b.service || '—';
    document.getElementById('bkd_date').textContent     = b.preferred_date ? formatDate(b.preferred_date) : '—';
    document.getElementById('bkd_time').textContent     = b.preferred_time || '—';

    var statusEl = document.getElementById('bkd_status');
    statusEl.textContent  = meta.label;
    statusEl.className    = 'px-2.5 py-1 rounded-lg border text-[11px] font-semibold ' + meta.cls;

    var phoneEl = document.getElementById('bkd_phone');
    phoneEl.textContent = b.phone || '—';
    phoneEl.href = digits.length >= 8 ? 'tel:+' + digits : '#';

    var waEl = document.getElementById('bkd_wa');
    waEl.href = digits.length >= 8 ? 'https://wa.me/' + digits : '#';

    var notesRow = document.getElementById('bkd_notes_row');
    if (b.notes && b.notes.trim()) {
        document.getElementById('bkd_notes').textContent = b.notes;
        notesRow.classList.remove('hidden');
    } else {
        notesRow.classList.add('hidden');
    }

    document.getElementById('bkDetailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function closeBookingDetail() {
    document.getElementById('bkDetailModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function formatDate(dateStr) {
    var d = new Date(dateStr + 'T00:00:00');
    return d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeBookingDetail();
});
</script>
