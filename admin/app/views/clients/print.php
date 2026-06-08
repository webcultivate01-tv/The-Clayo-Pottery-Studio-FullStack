<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clients Export · The Clayo</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    font-size: 13px;
    color: #0f172a;
    background: #fff;
    padding: 32px;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #4f46e5;
}
.brand { display: flex; align-items: center; gap: 10px; }
.brand-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 14px;
}
.brand-name { font-size: 18px; font-weight: 800; color: #0f172a; }
.brand-sub  { font-size: 10px; text-transform: uppercase; letter-spacing: 0.2em; color: #64748b; margin-top: 2px; }
.meta { text-align: right; font-size: 11px; color: #64748b; }
.meta strong { color: #0f172a; font-size: 13px; display: block; margin-bottom: 2px; }
.filters {
    display: flex; flex-wrap: wrap; gap: 8px;
    margin-bottom: 20px;
}
.filter-chip {
    padding: 3px 10px;
    background: #eef2ff; color: #4f46e5;
    border-radius: 20px; font-size: 11px; font-weight: 600;
}
table {
    width: 100%; border-collapse: collapse;
    font-size: 12px;
}
thead tr {
    background: #f6f7fb;
    border-bottom: 1px solid #e9ecf3;
}
thead th {
    padding: 9px 12px;
    text-align: left;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #64748b;
}
tbody tr { border-bottom: 1px solid #f1f3f8; }
tbody tr:nth-child(even) { background: #fafbfd; }
tbody td { padding: 9px 12px; color: #0f172a; }
.status {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.status-active   { background: #ecfdf5; color: #10b981; }
.status-inactive { background: #fffbeb; color: #f59e0b; }
.status-archived { background: #f1f3f8; color: #64748b; }
.footer {
    margin-top: 24px; padding-top: 12px;
    border-top: 1px solid #e9ecf3;
    display: flex; justify-content: space-between;
    font-size: 10px; color: #94a3b8;
}
.no-clients { padding: 40px; text-align: center; color: #64748b; }
@media print {
    body { padding: 20px; }
    .no-print { display: none !important; }
    @page { margin: 0.5in; }
}
</style>
</head>
<body>

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
        <strong>Clients Report</strong>
        Generated <?= e(date('d M Y, g:i A')) ?> &nbsp;·&nbsp; <?= count($clients) ?> record<?= count($clients) !== 1 ? 's' : '' ?>
    </div>
</div>

<!-- Active filters summary -->
<?php $activeFilters = array_filter($filters); if ($activeFilters): ?>
<div class="filters">
    <?php if (!empty($filters['search'])): ?>
        <span class="filter-chip">Search: <?= e($filters['search']) ?></span>
    <?php endif; ?>
    <?php if (!empty($filters['status'])): ?>
        <span class="filter-chip">Status: <?= e(ucfirst($filters['status'])) ?></span>
    <?php endif; ?>
    <?php if (!empty($filters['date_from'])): ?>
        <span class="filter-chip">From: <?= e($filters['date_from']) ?></span>
    <?php endif; ?>
    <?php if (!empty($filters['date_to'])): ?>
        <span class="filter-chip">To: <?= e($filters['date_to']) ?></span>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Table -->
<?php if (empty($clients)): ?>
    <div class="no-clients">No clients match the selected filters.</div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th style="width:32px">#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company</th>
            <th>Status</th>
            <th>Joined</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $i => $c): ?>
        <tr>
            <td style="color:#94a3b8"><?= $i + 1 ?></td>
            <td><?= e($c['first_name']) ?></td>
            <td><?= e($c['last_name'] ?? '') ?></td>
            <td style="color:#4f46e5"><?= e($c['email'] ?? '—') ?></td>
            <td><?= e($c['phone'] ?? '—') ?></td>
            <td style="color:#64748b"><?= e($c['company'] ?? '—') ?></td>
            <td>
                <span class="status status-<?= e($c['status']) ?>">
                    <?= e(ucfirst($c['status'])) ?>
                </span>
            </td>
            <td style="color:#64748b"><?= e(date('d M Y', strtotime($c['created_at']))) ?></td>
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
            style="padding:6px 18px;background:#4f46e5;color:#fff;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;margin-right:8px">
            Print / Save PDF
        </button>
        <button onclick="window.close()"
            style="padding:6px 14px;background:#f1f3f8;color:#334155;border:none;border-radius:6px;font-size:12px;cursor:pointer">
            Close
        </button>
    </span>
    <span>Page 1</span>
</div>

<script>
// Auto-print after a short delay so the page renders first
setTimeout(function() { window.print(); }, 600);
</script>
</body>
</html>
