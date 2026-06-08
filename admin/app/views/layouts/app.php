<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <?php require ROOT_PATH . '/app/views/partials/head.php'; ?>
</head>
<body class="h-full bg-surface text-ink antialiased">
    <div class="h-screen flex overflow-hidden">
        <?php require ROOT_PATH . '/app/views/partials/sidebar.php'; ?>
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <?php require ROOT_PATH . '/app/views/partials/topbar.php'; ?>
            <main class="flex-1 p-6 lg:p-8 overflow-y-auto"
                  style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
                <?php if ($msg = flash('success')): ?>
                    <div class="mb-4 rounded-xl bg-success-50 border border-success/20 text-ink px-4 py-3 text-sm flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-success"></i><?= e($msg) ?>
                    </div>
                <?php endif; ?>
                <?php if ($msg = flash('error')): ?>
                    <div class="mb-4 rounded-xl bg-danger-50 border border-danger/20 text-ink px-4 py-3 text-sm flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-danger"></i><?= e($msg) ?>
                    </div>
                <?php endif; ?>
                <?= $content ?>
            </main>
        </div>
    </div>
    <script>
        if (window.lucide) lucide.createIcons();
    </script>
    <script>
    (function () {
        var sidebar   = document.getElementById('sidebar');
        var backdrop  = document.getElementById('sidebar-backdrop');
        var openBtn   = document.getElementById('sidebar-open');
        var closeBtn  = document.getElementById('sidebar-close');
        if (!sidebar) return;

        function openDrawer() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0', 'shadow-pop');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100', 'pointer-events-auto');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0', 'shadow-pop');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-100', 'pointer-events-auto');
            document.body.style.overflow = '';
        }

        if (openBtn)  openBtn.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (backdrop) backdrop.addEventListener('click', closeDrawer);

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDrawer();
        });
    })();
    </script>
</body>
</html>
