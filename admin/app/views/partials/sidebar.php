<?php
$isAdmin = user_has_role('admin');

// Public website is one level above the admin base path
$_adminBase = rtrim(url('/'), '/');
$_siteUrl   = rtrim(str_replace('\\', '/', dirname($_adminBase)), '/') . '/';

$navGroups = [
    'Overview' => [
        ['label' => 'Dashboard',     'path' => '/dashboard',     'icon' => 'layout-grid'],
    ],
    'Studio' => [
        ['label' => 'Clients',       'path' => '/clients',       'icon' => 'users'],
        ['label' => 'Bookings',      'path' => '/bookings',      'icon' => 'calendar-check'],
        ['label' => 'Enquiries',     'path' => '/enquiries',     'icon' => 'message-square'],
        ['label' => 'Services',      'path' => '/services',      'icon' => 'sparkles'],
        ['label' => 'Gallery',       'path' => '/gallery',       'icon' => 'image'],
        ['label' => 'Events',        'path' => '/events',        'icon' => 'calendar-days'],
        ['label' => 'Popups',        'path' => '/popups',        'icon' => 'message-square-dashed'],
    ],
    'Team' => [
        ['label' => 'Files',         'path' => '/files',         'icon' => 'file-text'],
    ],
    'System' => array_values(array_filter([
        $isAdmin ? ['label' => 'Admin Management', 'path' => '/users',         'icon' => 'shield-check'] : null,
        ['label' => 'Notifications', 'path' => '/notifications', 'icon' => 'bell'],
        ['label' => 'Settings',      'path' => '/settings',      'icon' => 'settings'],
    ])),
];
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
?>
<div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/40 z-30 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col bg-panel border-r border-line -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:z-auto">
    <!-- Brand — matches public website navbar -->
    <div class="h-16 shrink-0 flex items-center px-5 border-b border-line relative">
        <button id="sidebar-close" class="lg:hidden absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 grid place-items-center rounded-lg text-ink-soft hover:bg-line-soft transition">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <a href="<?= e(url('/dashboard')) ?>" class="flex flex-col leading-tight">
            <span class="font-heading flex items-end gap-1 leading-none" style="color:#5c3d2e;">
                <span class="text-[11px] font-body font-medium uppercase tracking-[0.2em]">The</span>
                <span class="text-xl font-semibold">Clayo</span>
            </span>
            <span class="text-[10px] tracking-[0.35em] uppercase font-medium mt-1" style="color:#b8935a;">
                Pottery Studio
            </span>
        </a>
    </div>

    <!-- Nav (scrollable when items overflow) -->
    <nav class="flex-1 min-h-0 px-3 py-4 space-y-5 overflow-y-auto"
         style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
        <?php foreach ($navGroups as $group => $items): ?>
            <div>
                <div class="px-3 mb-1.5 text-[11px] uppercase tracking-[0.16em] text-subtle font-semibold select-none">
                    <?= e($group) ?>
                </div>
                <div class="space-y-0.5">
                    <?php foreach ($items as $item):
                        $isActive = $item['path'] === '/dashboard'
                            ? (preg_match('#/dashboard/?$#', $currentPath) === 1 || rtrim($currentPath, '/') === '' )
                            : str_contains($currentPath, $item['path']);
                        $cls = $isActive
                            ? 'flex items-center justify-between gap-2.5 px-3 py-2 rounded-lg bg-brand-50 text-brand-700 text-[13px] font-semibold border border-brand-100'
                            : 'flex items-center justify-between gap-2.5 px-3 py-2 rounded-lg text-ink-soft hover:bg-line-soft hover:text-ink text-[13px] font-medium transition-colors';
                    ?>
                        <a href="<?= e(url($item['path'])) ?>" class="<?= $cls ?>">
                            <span class="flex items-center gap-2.5">
                                <i data-lucide="<?= e($item['icon']) ?>" class="w-[16px] h-[16px] shrink-0 <?= $isActive ? 'text-brand' : 'text-subtle' ?>"></i>
                                <span><?= e($item['label']) ?></span>
                            </span>
                            <?php if ($isActive): ?>
                                <i data-lucide="chevron-right" class="w-3 h-3 text-brand shrink-0"></i>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>

    <!-- Footer: always pinned to bottom -->
    <div class="shrink-0 p-3 border-t border-line">
        <a href="<?= e($_siteUrl) ?>" class="flex items-center gap-2.5 text-[13px] text-ink-soft hover:text-ink px-3 py-2 rounded-lg hover:bg-line-soft transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 shrink-0 text-subtle"></i>
            <span>Back to Site</span>
        </a>
        <form action="<?= e(url('/logout')) ?>" method="POST" class="mt-0.5">
            <?= csrf_field() ?>
            <button type="submit" class="w-full flex items-center gap-2.5 text-[13px] text-danger hover:bg-danger-50 px-3 py-2 rounded-lg transition-colors">
                <i data-lucide="log-out" class="w-4 h-4 shrink-0"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

