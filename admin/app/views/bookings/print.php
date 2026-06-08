<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bookings Export · The Clayo</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    font-size: 12px;
    color: #0f172a;
    background: #fff;
    padding: 28px;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 2px solid #4f46e5;
}
.brand { display: flex; align-items: center; gap: 10px; }
.brand-icon {
    width: 34px; height: 34px;
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 14px;
}
.brand-name { font-size: 17px; font-weight: 800; color: #0f172a; }
.brand-sub  { font-size: 10px; text-transform: uppercase; letter-spacing: 0.2em; color: #64748b; margin-top: 2px; }
.meta { text-align: right; font-size: 11px; color: #64748b; }
.meta strong { color: #0f172a; font-size: 13px; display: block; margin-bottom: 2px; }
.filters {
    display: flex; flex-wrap: wrap; gap: 6px;
    margin-bottom: 18px;
}
.filter-chip {
    padding: 3px 10px;
    background: #eef2ff; color: #4f46e5;
    border-radius: 20px; font-size: 11px; font-weight: 600;
}
table {
    width: 100%; border-collapse: collapse;
    font-size: 11px;
}
thead tr {
    background: #f6f7fb;
    border-bottom: 1px solid #e9ecf3;
}
thead th {
    padding: 8px 10px;
    text-align: left;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #64748b;
}
tbody tr { border-bottom: 1px solid #f1f3f8; }
tbody tr:nth-child(even) { background: #fafbfd; }
tbody td { padding: 8px 10px; color: #0f172a; vertical-align: top; }
.status {
    display: inline-block;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.status-pending   { background: #fffbeb; color: #d97706; }
.status-confirmed { background: #eef2ff; color: #4f46e5; }
.status-completed { background: #ecfdf5; color: #10b981; }
.status-cancelled { background: #fef2f2; color: #ef4444; }
.status-no_show   { background: #f1f3f8; color: #64748b; }
.svc-badge {
    display: inline-block;
    padding: 1px 6px;
    border-radius: 3px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 3px;
}
.svc-workshop { background: #fef3c7; color: #b45309; }
.svc-studio   { background: #e0e7ff; color: #4338ca; }
.footer {
    margin-top: 20px; padding-top: 10px;
    border-top: 1px solid #e9ecf3;
    display: flex; justify-content: space-between;
    font-size: 10px; color: #94a3b8;
}
.no-data { padding: 40px; text-align: center; color: #64748b; }
@media print {
    body { padding: 16px; }
    .no-print { display: none !important; }
    @page { margin: 0.4in; size: landscape; }
}
</style>
</head>
<body>

<?php
use Calyo\Models\Booking;
$statusCss  = ['pending'=>'pending','confirmed'=>'confirmed','completed'=>'completed','cancelled'=>'cancelled','no_show'=>'no_show'];
$workshopSvcs = Booking::WORKSHOP_SERVICES;
?>

<!-- Header -->
<div class="header">
    <div class="brand">
        <div class="brand-icon">C</div>
        <div>
            <div class="brand-name">The Clayo</div>
            <div class="brand-sub">Pottery Studio</div>
        </div>
    </div>
    <div class="meta">
        <strong>Bookings Report</strong>
        Generated <?= e(date('d M Y, g:i A')) ?> &nbsp;·&nbsp; <?= count($bookings) ?> record<?= count($bookings) !== 1 ? 's' : '' ?>
    </div>
</div>

<!-- Active filter chips -->
<?php
$labelMap = [
    'search'        => 'Search',
    'status'        => 'Status',
    'service_group' => 'Category',
    'service'       => 'Service',
    'date_from'     => 'Date From',
    'date_to'       => 'Date To',
    'created_from'  => 'Received From',
    'created_to'    => 'Received To',
];
$activeFilters = array_filter($filters);
if ($activeFilters):
?>
<div class="filters">
    <?php foreach ($activeFilters as $fk => $fv): ?>
        <span class="filter-chip"><?= e($labelMap[$fk] ?? $fk) ?>: <?= e($fv) ?></span>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Table -->
<?php if (empty($bookings)): ?>
    <div class="no-data">No bookings match the selected filters.</div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th style="width:28px">#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Service</th>
            <th>Preferred Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Source</th>
            <th>Received</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $i => $b): ?>
        <tr>
            <td style="color:#94a3b8"><?= $i + 1 ?></td>
            <td style="font-weight:600"><?= e($b['customer_name']) ?></td>
            <td><?= e($b['phone']) ?></td>
            <td style="color:#4f46e5"><?= e($b['email'] ?? '—') ?></td>
            <td>
                <?php $isWorkshop = in_array($b['service'], $workshopSvcs, true); ?>
                <span class="svc-badge <?= $isWorkshop ? 'svc-workshop' : 'svc-studio' ?>">
                    <?= $isWorkshop ? 'Workshop' : 'Service' ?>
                </span><br>
                <?= e($b['service']) ?>
            </td>
            <td><?= e(date('d M Y', strtotime($b['preferred_date']))) ?></td>
            <td><?= e($b['preferred_time']) ?></td>
            <td>
                <span class="status status-<?= e($b['status']) ?>">
                    <?= e(ucfirst(str_replace('_', ' ', $b['status']))) ?>
                </span>
            </td>
            <td style="color:#64748b"><?= e(ucfirst(str_replace('_', '-', $b['source']))) ?></td>
            <td style="color:#64748b"><?= e(date('d M Y', strtotime($b['created_at']))) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<!-- Footer -->
<div class="footer">
    <span>The Clayo Studio Management System</span>
    <span class="no-print">
        <button onclick="window.print()"
            style="padding:5px 16px;background:#4f46e5;color:#fff;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;margin-right:6px">
            Print / Save PDF
        </button>
        <button onclick="window.close()"
            style="padding:5px 12px;background:#f1f3f8;color:#334155;border:none;border-radius:6px;font-size:12px;cursor:pointer">
            Close
        </button>
    </span>
    <span>Page 1</span>
</div>

<script>
setTimeout(function() { window.print(); }, 600);
</script>
</body>
</html>
