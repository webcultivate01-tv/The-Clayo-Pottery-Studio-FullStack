<?php $user = current_user(); ?>
<header class="h-16 shrink-0 bg-panel border-b border-line flex items-center justify-between px-4 lg:px-8 gap-4 lg:gap-6 z-10" style="box-shadow:0 1px 0 #e9ecf3,0 2px 8px -4px rgba(15,23,42,0.06)">

    <!-- Left: hamburger + live dot + current page -->
    <div class="flex items-center gap-3 flex-shrink-0">
        <button id="sidebar-open" class="lg:hidden w-10 h-10 grid place-items-center rounded-xl text-ink-soft hover:bg-line-soft transition flex-shrink-0" title="Open menu">
            <i data-lucide="menu" class="w-[18px] h-[18px]"></i>
        </button>
        <span class="inline-flex items-center gap-2 text-sm font-semibold text-ink">
            <span class="relative inline-flex">
                <span class="pulse-dot w-2.5 h-2.5 rounded-full bg-success block"></span>
            </span>
            <span class="hidden sm:inline">Live</span>
        </span>
        <span class="w-px h-5 bg-line"></span>
        <span class="text-sm font-medium text-muted"><?= e($title ?? 'Dashboard') ?></span>
    </div>

    <!-- Centre: search -->
    <div class="flex-1 max-w-xl hidden md:block relative" id="search-wrapper">
        <label class="relative block">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-subtle w-4 h-4 pointer-events-none z-10"></i>
            <input id="topbar-search" type="text" autocomplete="off" placeholder="Search or jump to…"
                class="w-full bg-surface border border-line rounded-xl pl-11 pr-16 py-2.5 text-sm text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
            <kbd class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-semibold text-muted bg-panel border border-line rounded-md px-1.5 py-0.5 pointer-events-none">
                Ctrl K
            </kbd>
        </label>
        <!-- Navigation search dropdown -->
        <div id="search-dropdown"
             class="absolute top-full mt-1.5 left-0 right-0 bg-panel border border-line rounded-xl overflow-hidden hidden z-50"
             style="box-shadow:0 8px 32px -4px rgba(15,23,42,0.16),0 2px 8px -2px rgba(15,23,42,0.08)">
            <div id="search-label" class="px-4 pt-3 pb-1 text-[10px] uppercase tracking-[0.18em] font-bold text-subtle select-none">Quick Navigate</div>
            <div id="search-results" class="pb-2 max-h-64 overflow-y-auto" style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent"></div>
        </div>
    </div>

    <!-- Right: fullscreen · notifications · user -->
    <div class="flex items-center gap-1.5 lg:gap-2 flex-shrink-0">

        <!-- Quick new booking shortcut -->
        <a href="<?= e(url('/bookings')) ?>"
           class="hidden lg:inline-flex items-center gap-1.5 text-[13px] font-semibold text-white rounded-xl px-3 py-2 shadow-card hover:opacity-90 transition"
           style="background:linear-gradient(135deg,#4f46e5,#4338ca);"
           title="Go to Bookings">
            <i data-lucide="calendar-plus" class="w-3.5 h-3.5"></i>
            <span>New Booking</span>
        </a>

        <!-- Fullscreen toggle -->
        <button type="button" id="fs-btn"
                class="w-10 h-10 grid place-items-center rounded-xl text-ink-soft hover:bg-line-soft transition"
                title="Toggle fullscreen">
            <i data-lucide="maximize-2" id="fs-icon-expand" class="w-[18px] h-[18px]"></i>
            <i data-lucide="minimize-2" id="fs-icon-shrink" class="w-[18px] h-[18px] hidden"></i>
        </button>

        <!-- Notifications bell — links to notifications page -->
        <a href="<?= e(url('/notifications')) ?>"
           class="relative w-10 h-10 grid place-items-center rounded-xl text-ink-soft hover:bg-line-soft transition"
           title="Notifications">
            <i data-lucide="bell" class="w-[18px] h-[18px]"></i>
            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-danger ring-2 ring-panel"></span>
        </a>

        <!-- User info + avatar + role -->
        <div class="hidden sm:flex items-center gap-3 pl-3 ml-1 border-l border-line">
            <div class="text-right hidden lg:block">
                <div class="text-sm font-semibold text-ink leading-tight"><?= e($user['name'] ?? 'Guest') ?></div>
                <div class="text-[11px] text-muted"><?= e($user['email'] ?? '') ?></div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-brand-700 text-white grid place-items-center font-bold text-sm shadow-card">
                <?= e(strtoupper(substr($user['name'] ?? 'U', 0, 1))) ?>
            </div>
            <span class="text-[10px] font-bold tracking-wider uppercase text-warn bg-warn-50 border border-warn/20 rounded-md px-2 py-1 hidden lg:block">
                <?= e(strtoupper($user['role'] ?? 'admin')) ?>
            </span>
        </div>
    </div>
</header>

<script>
// Ctrl+K / Cmd+K — focus search and open dropdown
document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        var s = document.getElementById('topbar-search');
        if (s) { s.focus(); s.select(); }
    }
});

// Global navigation search dropdown
(function () {
    var navItems = [
        { label: 'Dashboard',     icon: 'layout-grid',   href: '<?= e(url('/dashboard')) ?>',     kw: 'home overview stats analytics' },
        { label: 'Clients',       icon: 'users',          href: '<?= e(url('/clients')) ?>',       kw: 'client customer people contact' },
        { label: 'Bookings',      icon: 'calendar-check', href: '<?= e(url('/bookings')) ?>',      kw: 'booking order appointment session' },
        { label: 'Enquiries',     icon: 'message-square', href: '<?= e(url('/enquiries')) ?>',     kw: 'enquiry inquiry question general' },
        { label: 'Services',      icon: 'sparkles',       href: '<?= e(url('/services')) ?>',      kw: 'service workshop class pottery' },
        { label: 'Events',        icon: 'calendar-days',  href: '<?= e(url('/events')) ?>',        kw: 'event schedule calendar' },
        { label: 'Files',         icon: 'file-text',      href: '<?= e(url('/files')) ?>',         kw: 'file image document photo upload' },
        { label: 'Notifications', icon: 'bell',           href: '<?= e(url('/notifications')) ?>', kw: 'notification alert email broadcast message' },
        { label: 'Settings',      icon: 'settings',       href: '<?= e(url('/settings')) ?>',      kw: 'setting profile password appearance theme' },
    ];

    var input    = document.getElementById('topbar-search');
    var dropdown = document.getElementById('search-dropdown');
    var resultEl = document.getElementById('search-results');
    var labelEl  = document.getElementById('search-label');
    if (!input || !dropdown || !resultEl) return;

    var activeIdx = -1;

    function renderItems(items) {
        if (labelEl) labelEl.textContent = items.length ? 'Quick Navigate' : '';
        if (!items.length) {
            resultEl.innerHTML = '<div class="px-4 py-3 text-xs text-muted text-center">No pages matched — try another term</div>';
            activeIdx = -1;
            return;
        }
        resultEl.innerHTML = items.map(function (item) {
            return '<a href="' + item.href + '" ' +
                'class="nav-item flex items-center gap-3 px-4 py-2.5 text-sm text-ink-soft font-medium hover:bg-brand-50 hover:text-brand transition-colors">' +
                '<span class="w-6 h-6 rounded-md bg-surface border border-line grid place-items-center shrink-0">' +
                '<i data-lucide="' + item.icon + '" class="w-3.5 h-3.5 text-subtle"></i></span>' +
                '<span>' + item.label + '</span>' +
                '<i data-lucide="corner-down-left" class="w-3 h-3 text-subtle ml-auto opacity-0 nav-hint"></i>' +
                '</a>';
        }).join('');
        activeIdx = -1;
        if (window.lucide) lucide.createIcons();
    }

    function setActive(links, idx) {
        links.forEach(function (l, i) {
            var on = i === idx;
            l.classList.toggle('bg-brand-50',   on);
            l.classList.toggle('text-brand',     on);
            l.classList.toggle('text-ink-soft',  !on);
            var hint = l.querySelector('.nav-hint');
            if (hint) hint.classList.toggle('opacity-100', on);
        });
    }

    function openDropdown() {
        var q    = input.value.trim().toLowerCase();
        var list = q
            ? navItems.filter(function (item) { return (item.label + ' ' + item.kw).toLowerCase().indexOf(q) !== -1; })
            : navItems;
        renderItems(list);
        dropdown.classList.remove('hidden');
    }

    function closeDropdown() {
        dropdown.classList.add('hidden');
        activeIdx = -1;
    }

    input.addEventListener('focus', openDropdown);
    input.addEventListener('input', openDropdown);

    input.addEventListener('keydown', function (e) {
        var links = Array.prototype.slice.call(resultEl.querySelectorAll('a.nav-item'));
        if (!links.length) return;
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = (activeIdx + 1) % links.length;
            setActive(links, activeIdx);
            links[activeIdx].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIdx = (activeIdx - 1 + links.length) % links.length;
            setActive(links, activeIdx);
            links[activeIdx].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter') {
            e.preventDefault();
            var tgt = activeIdx >= 0 ? links[activeIdx] : links[0];
            if (tgt) { window.location.href = tgt.href; }
        } else if (e.key === 'Escape') {
            closeDropdown();
            input.blur();
        }
    });

    document.addEventListener('mousedown', function (e) {
        var wrapper = document.getElementById('search-wrapper');
        if (wrapper && !wrapper.contains(e.target)) closeDropdown();
    });
})();

// Fullscreen toggle
(function () {
    var btn    = document.getElementById('fs-btn');
    var expand = document.getElementById('fs-icon-expand');
    var shrink = document.getElementById('fs-icon-shrink');
    if (!btn) return;

    function syncIcon() {
        var isFs = !!document.fullscreenElement;
        expand.classList.toggle('hidden', isFs);
        shrink.classList.toggle('hidden', !isFs);
    }

    btn.addEventListener('click', function () {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(function () {});
        } else {
            document.exitFullscreen();
        }
    });
    document.addEventListener('fullscreenchange', syncIcon);
})();
</script>
