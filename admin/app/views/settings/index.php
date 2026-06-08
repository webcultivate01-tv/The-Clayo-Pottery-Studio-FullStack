<?php
use Calyo\Models\User;

$isAdmin = user_has_role('admin');
$initials = User::initials($me);
$role = $me['role'] ?? 'staff';

$tabs = [
    ['key' => 'profile',    'label' => 'Profile',         'icon' => 'user',         'admin' => false, 'desc' => 'Your account details'],
    ['key' => 'password',   'label' => 'Password',        'icon' => 'lock',         'admin' => false, 'desc' => 'Change your password'],
    ['key' => 'studio',     'label' => 'Studio',          'icon' => 'building-2',   'admin' => true,  'desc' => 'Public business info'],
    ['key' => 'appearance', 'label' => 'Appearance',      'icon' => 'palette',      'admin' => true,  'desc' => 'Theme & branding'],
    ['key' => 'security',   'label' => 'Security',        'icon' => 'shield-check', 'admin' => false, 'desc' => 'Recent activity'],
];

$s = $settings ?? [];
?>

<!-- Page header -->
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Settings</h2>
        <p class="text-[13px] text-muted mt-0.5">Manage your account and studio preferences</p>
    </div>
    <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-panel border border-line shadow-card">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-brand-700 text-white grid place-items-center text-[13px] font-bold">
            <?= e($initials) ?>
        </div>
        <div class="text-right">
            <div class="text-[13px] font-semibold text-ink leading-tight"><?= e($me['name'] ?? '') ?></div>
            <div class="text-[11px] text-muted mt-0.5 flex items-center gap-1.5 justify-end">
                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-[0.1em] <?= $role === 'admin' ? 'bg-brand-50 text-brand-700 border border-brand-100' : 'bg-accent-50 text-accent border border-accent/20' ?>">
                    <i data-lucide="<?= $role === 'admin' ? 'shield-check' : 'user' ?>" class="w-2.5 h-2.5"></i><?= e(strtoupper($role)) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6">
    <!-- Tab nav -->
    <aside class="bg-panel rounded-xl border border-line shadow-card p-2 h-fit">
        <nav class="space-y-0.5">
            <?php foreach ($tabs as $t):
                if ($t['admin'] && !$isAdmin) continue;
                $active = $tab === $t['key'];
                $cls = $active
                    ? 'flex items-start gap-3 px-3 py-2.5 rounded-lg bg-brand-50 text-brand-700 border border-brand-100'
                    : 'flex items-start gap-3 px-3 py-2.5 rounded-lg text-ink-soft hover:bg-line-soft hover:text-ink transition-colors';
            ?>
                <a href="<?= e(url('/settings?tab=' . $t['key'])) ?>" class="<?= $cls ?>">
                    <i data-lucide="<?= e($t['icon']) ?>" class="w-4 h-4 mt-0.5 shrink-0 <?= $active ? 'text-brand' : 'text-subtle' ?>"></i>
                    <div class="min-w-0">
                        <div class="text-[13px] font-semibold leading-tight"><?= e($t['label']) ?></div>
                        <div class="text-[11px] mt-0.5 <?= $active ? 'text-brand-700/70' : 'text-muted' ?>"><?= e($t['desc']) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <!-- Tab content -->
    <section>
    <?php if ($tab === 'profile'): ?>
        <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
            <header class="px-6 py-4 border-b border-line flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                    <i data-lucide="user" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Profile Information</h3>
                    <p class="text-[12px] text-muted">Update your name, email, and contact details</p>
                </div>
            </header>
            <form action="<?= e(url('/settings/profile')) ?>" method="POST" class="px-6 py-6 space-y-5">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" required value="<?= e($me['name'] ?? '') ?>" class="form-input" placeholder="e.g. Priya Sharma">
                    </div>
                    <div>
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" required value="<?= e($me['email'] ?? '') ?>" class="form-input" placeholder="you@example.com">
                    </div>
                    <div>
                        <label class="form-label">Mobile Number</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                            <input type="tel" name="phone" value="<?= e($me['phone'] ?? '') ?>" class="form-input pl-9" placeholder="+91 98765 43210">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Role</label>
                        <input type="text" value="<?= e(ucfirst($role)) ?>" class="form-input" disabled>
                        <p class="text-[11px] text-muted mt-1.5 flex items-center gap-1">
                            <i data-lucide="info" class="w-3 h-3"></i>Only an admin can change roles
                        </p>
                    </div>
                </div>

                <?php if (!empty($me['last_login_at'])): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-line">
                    <div class="text-[12px]">
                        <div class="text-muted">Last sign-in</div>
                        <div class="text-ink font-medium mt-0.5"><?= e(date('d M Y, H:i', strtotime($me['last_login_at']))) ?></div>
                    </div>
                    <?php if (!empty($me['last_login_ip'])): ?>
                    <div class="text-[12px]">
                        <div class="text-muted">From IP</div>
                        <div class="text-ink font-medium mt-0.5 font-mono"><?= e($me['last_login_ip']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-line">
                    <a href="<?= e(url('/settings')) ?>" class="px-4 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

    <?php elseif ($tab === 'password'): ?>
        <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
            <header class="px-6 py-4 border-b border-line flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-warn-50 grid place-items-center">
                    <i data-lucide="lock" class="w-4 h-4 text-warn"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Change Password</h3>
                    <p class="text-[12px] text-muted">Pick a strong password you don't use anywhere else</p>
                </div>
            </header>
            <form action="<?= e(url('/settings/password')) ?>" method="POST" class="px-6 py-6 space-y-5" id="passwordForm">
                <?= csrf_field() ?>
                <div>
                    <label class="form-label">Current Password <span class="text-danger">*</span></label>
                    <div class="relative">
                        <input type="password" name="current_password" required class="form-input pr-10" placeholder="Enter your current password" data-pw>
                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 grid place-items-center text-subtle hover:text-ink-soft transition" data-pw-toggle>
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <div class="relative">
                            <input type="password" name="new_password" required minlength="8" class="form-input pr-10" placeholder="At least 8 characters" data-pw id="newPassword">
                            <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 grid place-items-center text-subtle hover:text-ink-soft transition" data-pw-toggle>
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <div id="pwStrength" class="mt-2 hidden">
                            <div class="flex gap-1 mb-1">
                                <span class="h-1 flex-1 rounded-full bg-line" data-bar></span>
                                <span class="h-1 flex-1 rounded-full bg-line" data-bar></span>
                                <span class="h-1 flex-1 rounded-full bg-line" data-bar></span>
                                <span class="h-1 flex-1 rounded-full bg-line" data-bar></span>
                            </div>
                            <p class="text-[11px] text-muted" id="pwLabel">Too weak</p>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <div class="relative">
                            <input type="password" name="confirm_password" required minlength="8" class="form-input pr-10" placeholder="Re-enter new password" data-pw id="confirmPassword">
                            <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 grid place-items-center text-subtle hover:text-ink-soft transition" data-pw-toggle>
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <p id="pwMatch" class="text-[11px] mt-1.5 hidden"></p>
                    </div>
                </div>

                <div class="rounded-lg bg-brand-50 border border-brand-100 p-3 text-[12px] text-brand-700 flex items-start gap-2">
                    <i data-lucide="info" class="w-3.5 h-3.5 mt-0.5 shrink-0"></i>
                    <div>
                        <strong>Tips for a strong password:</strong>
                        At least 8 characters, mix upper and lower case, add a number or symbol, and avoid reusing passwords from other sites.
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-line">
                    <button type="reset" class="px-4 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">Clear</button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        <i data-lucide="key-round" class="w-3.5 h-3.5"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

    <?php elseif ($tab === 'studio' && $isAdmin): ?>
        <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
            <header class="px-6 py-4 border-b border-line flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-accent-50 grid place-items-center">
                    <i data-lucide="building-2" class="w-4 h-4 text-accent"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Studio Information</h3>
                    <p class="text-[12px] text-muted">Used in customer emails and public-facing content</p>
                </div>
            </header>
            <form action="<?= e(url('/settings/studio')) ?>" method="POST" class="px-6 py-6 space-y-5">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Studio Name <span class="text-danger">*</span></label>
                        <input type="text" name="studio_name" required value="<?= e($s['studio_name'] ?? '') ?>" class="form-input" placeholder="Clayo Pottery Studio">
                    </div>
                    <div>
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="studio_email" value="<?= e($s['studio_email'] ?? '') ?>" class="form-input" placeholder="hello@clayo.in">
                    </div>
                    <div>
                        <label class="form-label">Phone Number</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                            <input type="tel" name="studio_phone" value="<?= e($s['studio_phone'] ?? '') ?>" class="form-input pl-9" placeholder="+91 98765 43210">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Business Hours</label>
                        <input type="text" name="studio_hours" value="<?= e($s['studio_hours'] ?? '') ?>" class="form-input" placeholder="Mon–Sat · 10:00 AM – 7:00 PM">
                    </div>
                </div>
                <div>
                    <label class="form-label">Studio Address</label>
                    <textarea name="studio_address" rows="2" class="form-input" placeholder="Street, area, city, pincode"><?= e($s['studio_address'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="form-label">About / Tagline</label>
                    <textarea name="studio_about" rows="3" class="form-input" placeholder="A short description shown on customer emails and the website footer"><?= e($s['studio_about'] ?? '') ?></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-line">
                    <a href="<?= e(url('/settings?tab=studio')) ?>" class="px-4 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i> Save Studio Info
                    </button>
                </div>
            </form>
        </div>

    <?php elseif ($tab === 'appearance' && $isAdmin): ?>
        <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
            <header class="px-6 py-4 border-b border-line flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-teal-50 grid place-items-center">
                    <i data-lucide="palette" class="w-4 h-4 text-teal"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Appearance</h3>
                    <p class="text-[12px] text-muted">Pick a theme and accent color for the admin panel</p>
                </div>
            </header>
            <form action="<?= e(url('/settings/appearance')) ?>" method="POST" class="px-6 py-6 space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label class="form-label mb-3">Theme</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php $theme = $s['theme'] ?? 'light'; ?>
                        <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition <?= $theme === 'light' ? 'border-brand bg-brand-50' : 'border-line hover:bg-line-soft' ?>">
                            <input type="radio" name="theme" value="light" class="sr-only" <?= $theme === 'light' ? 'checked' : '' ?>>
                            <div class="w-10 h-10 rounded-lg bg-white border border-line grid place-items-center">
                                <i data-lucide="sun" class="w-4 h-4 text-warn"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-[13px] font-semibold text-ink">Light</div>
                                <div class="text-[11px] text-muted">Clean and bright</div>
                            </div>
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-brand <?= $theme === 'light' ? '' : 'opacity-0' ?>"></i>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition <?= $theme === 'dark' ? 'border-brand bg-brand-50' : 'border-line hover:bg-line-soft' ?>">
                            <input type="radio" name="theme" value="dark" class="sr-only" <?= $theme === 'dark' ? 'checked' : '' ?>>
                            <div class="w-10 h-10 rounded-lg bg-ink grid place-items-center">
                                <i data-lucide="moon" class="w-4 h-4 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-[13px] font-semibold text-ink">Dark</div>
                                <div class="text-[11px] text-muted">Easy on the eyes</div>
                            </div>
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-brand <?= $theme === 'dark' ? '' : 'opacity-0' ?>"></i>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="form-label">Brand Accent Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="brand_color" value="<?= e($s['brand_color'] ?? '#4f46e5') ?>" class="w-14 h-10 rounded-lg border border-line cursor-pointer">
                        <input type="text" value="<?= e($s['brand_color'] ?? '#4f46e5') ?>" readonly class="form-input font-mono text-[12px] max-w-[140px]" id="colorHex">
                        <p class="text-[11px] text-muted">Used for buttons, links and highlights</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-line">
                    <a href="<?= e(url('/settings?tab=appearance')) ?>" class="px-4 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i> Save Appearance
                    </button>
                </div>
            </form>
        </div>

    <?php elseif ($tab === 'security'): ?>
        <div class="space-y-5">
            <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
                <header class="px-6 py-4 border-b border-line flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-success-50 grid place-items-center">
                        <i data-lucide="shield-check" class="w-4 h-4 text-success"></i>
                    </div>
                    <div>
                        <h3 class="font-display text-[15px] font-bold text-ink">Account Security</h3>
                        <p class="text-[12px] text-muted">Quick overview of your account state</p>
                    </div>
                </header>
                <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-xl border border-line p-4">
                        <div class="text-[11px] text-muted uppercase tracking-[0.12em] font-semibold">Status</div>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full <?= ((int)($me['is_active'] ?? 1) === 1) ? 'bg-success' : 'bg-danger' ?>"></span>
                            <span class="text-[14px] font-semibold text-ink"><?= ((int)($me['is_active'] ?? 1) === 1) ? 'Active' : 'Disabled' ?></span>
                        </div>
                    </div>
                    <div class="rounded-xl border border-line p-4">
                        <div class="text-[11px] text-muted uppercase tracking-[0.12em] font-semibold">Member Since</div>
                        <div class="mt-1 text-[14px] font-semibold text-ink">
                            <?= !empty($me['created_at']) ? e(date('d M Y', strtotime($me['created_at']))) : '—' ?>
                        </div>
                    </div>
                    <div class="rounded-xl border border-line p-4">
                        <div class="text-[11px] text-muted uppercase tracking-[0.12em] font-semibold">Last Sign-in</div>
                        <div class="mt-1 text-[14px] font-semibold text-ink">
                            <?= !empty($me['last_login_at']) ? e(date('d M Y, H:i', strtotime($me['last_login_at']))) : '—' ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
                <header class="px-6 py-4 border-b border-line flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-warn-50 grid place-items-center">
                            <i data-lucide="activity" class="w-4 h-4 text-warn"></i>
                        </div>
                        <div>
                            <h3 class="font-display text-[15px] font-bold text-ink">Recent Activity</h3>
                            <p class="text-[12px] text-muted">Last <?= count($recent) ?> events on your account</p>
                        </div>
                    </div>
                    <a href="<?= e(url('/settings?tab=password')) ?>" class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-brand hover:text-brand-700 transition">
                        <i data-lucide="key-round" class="w-3.5 h-3.5"></i> Change Password
                    </a>
                </header>
                <?php if (empty($recent)): ?>
                    <div class="py-14 text-center">
                        <i data-lucide="activity" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
                        <p class="text-[13px] font-semibold text-ink">No recent activity</p>
                        <p class="text-[12px] text-muted mt-1">Sign-ins and account changes will show up here.</p>
                    </div>
                <?php else: ?>
                    <ul class="divide-y divide-line">
                        <?php foreach ($recent as $r):
                            $action = (string) $r['action'];
                            $meta = match (true) {
                                str_contains($action, 'login.success')   => ['icon' => 'log-in',       'cls' => 'bg-success-50 text-success', 'label' => 'Signed in'],
                                str_contains($action, 'login.failed')    => ['icon' => 'shield-alert', 'cls' => 'bg-danger-50 text-danger',   'label' => 'Failed sign-in'],
                                str_contains($action, 'logout')          => ['icon' => 'log-out',      'cls' => 'bg-line-soft text-muted',    'label' => 'Signed out'],
                                str_contains($action, 'password')        => ['icon' => 'key-round',    'cls' => 'bg-warn-50 text-warn',       'label' => 'Password change'],
                                str_contains($action, 'profile')         => ['icon' => 'user-cog',     'cls' => 'bg-brand-50 text-brand',     'label' => 'Profile update'],
                                str_contains($action, 'studio')          => ['icon' => 'building-2',   'cls' => 'bg-accent-50 text-accent',   'label' => 'Studio settings'],
                                default                                  => ['icon' => 'circle-dot',   'cls' => 'bg-line-soft text-muted',    'label' => $action],
                            };
                        ?>
                            <li class="px-6 py-3.5 flex items-center gap-4">
                                <div class="w-9 h-9 rounded-lg <?= $meta['cls'] ?> grid place-items-center shrink-0">
                                    <i data-lucide="<?= e($meta['icon']) ?>" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[13px] font-semibold text-ink"><?= e($meta['label']) ?></div>
                                    <div class="text-[11px] text-muted mt-0.5 font-mono truncate">
                                        <?= e($action) ?> · <?= e($r['ip_address'] ?? '—') ?>
                                    </div>
                                </div>
                                <div class="text-[11px] text-muted text-right shrink-0">
                                    <?= e(date('d M Y', strtotime($r['created_at']))) ?><br>
                                    <span class="text-subtle"><?= e(date('H:i', strtotime($r['created_at']))) ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <div class="bg-panel rounded-xl border border-line shadow-card p-10 text-center">
            <i data-lucide="lock" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
            <p class="text-[13px] font-semibold text-ink">This section is admin-only</p>
            <p class="text-[12px] text-muted mt-1">Contact an administrator for access.</p>
        </div>
    <?php endif; ?>
    </section>
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
    padding: 9px 12px;
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
    background: #ffffff;
}
.form-input::placeholder { color: #94a3b8; }
.form-input:disabled { opacity: 0.6; cursor: not-allowed; background: #f1f3f8; }
textarea.form-input { resize: vertical; min-height: 80px; }
</style>

<script>
(function () {
    // Password visibility toggles
    document.querySelectorAll('[data-pw-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = btn.parentElement.querySelector('[data-pw]');
            if (!input) return;
            var hide = input.type === 'password';
            input.type = hide ? 'text' : 'password';
            var icon = btn.querySelector('[data-lucide]');
            if (icon) {
                icon.setAttribute('data-lucide', hide ? 'eye-off' : 'eye');
                if (window.lucide) lucide.createIcons();
            }
        });
    });

    // Password strength meter
    var newPw = document.getElementById('newPassword');
    var confirmPw = document.getElementById('confirmPassword');
    var strength = document.getElementById('pwStrength');
    var label = document.getElementById('pwLabel');
    var matchEl = document.getElementById('pwMatch');

    function score(pw) {
        var s = 0;
        if (!pw) return 0;
        if (pw.length >= 8) s++;
        if (pw.length >= 12) s++;
        if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) s++;
        if (/\d/.test(pw) && /[^A-Za-z0-9]/.test(pw)) s++;
        return s;
    }

    if (newPw) {
        newPw.addEventListener('input', function () {
            var val = newPw.value;
            if (!val) { strength.classList.add('hidden'); return; }
            strength.classList.remove('hidden');
            var n = score(val);
            var bars = strength.querySelectorAll('[data-bar]');
            var palette = ['#ef4444', '#f59e0b', '#3b82f6', '#10b981'];
            var labels = ['Too weak', 'Weak', 'Good', 'Strong'];
            bars.forEach(function (b, i) {
                b.style.background = i < n ? palette[Math.min(n - 1, 3)] : '#e9ecf3';
            });
            label.textContent = labels[Math.max(0, Math.min(n - 1, 3))];
            label.style.color = n >= 3 ? '#10b981' : '#64748b';
        });
    }

    function checkMatch() {
        if (!newPw || !confirmPw || !matchEl) return;
        if (!confirmPw.value) { matchEl.classList.add('hidden'); return; }
        matchEl.classList.remove('hidden');
        if (newPw.value === confirmPw.value) {
            matchEl.textContent = '✓ Passwords match';
            matchEl.style.color = '#10b981';
        } else {
            matchEl.textContent = '✗ Passwords do not match';
            matchEl.style.color = '#ef4444';
        }
    }
    if (newPw) newPw.addEventListener('input', checkMatch);
    if (confirmPw) confirmPw.addEventListener('input', checkMatch);

    // Color picker sync
    var colorInput = document.querySelector('input[name="brand_color"]');
    var colorHex = document.getElementById('colorHex');
    if (colorInput && colorHex) {
        colorInput.addEventListener('input', function () {
            colorHex.value = colorInput.value;
        });
    }
})();
</script>
