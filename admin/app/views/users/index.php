<?php
use Calyo\Models\User;

$users   = $result['data'];
$total   = $result['total'];
$pages   = $result['pages'];
$page    = $result['page'];
$me      = current_user();
$myId    = (int) ($me['id'] ?? 0);

$roleMeta = [
    'admin' => ['label' => 'Admin', 'cls' => 'bg-brand-50 text-brand-700 border-brand-100', 'icon' => 'shield-check'],
    'staff' => ['label' => 'Staff', 'cls' => 'bg-accent-50 text-accent border-accent/20', 'icon' => 'user'],
];

$avatarColors = [
    'brand'   => ['bg' => 'bg-brand-50',   'text' => 'text-brand'],
    'accent'  => ['bg' => 'bg-accent-50',  'text' => 'text-accent'],
    'success' => ['bg' => 'bg-success-50', 'text' => 'text-success'],
    'warn'    => ['bg' => 'bg-warn-50',    'text' => 'text-warn'],
];
$colorKeys = array_keys($avatarColors);
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Admin Management</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> user<?= $total !== 1 ? 's' : '' ?> total
            <?php if (array_filter($filters, fn($v) => $v !== '' && $v !== null)): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
        </p>
    </div>
    <button onclick="openAddModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white hover:opacity-90 text-[13px] font-semibold transition shadow-card">
        <i data-lucide="user-plus" class="w-4 h-4"></i> Add User
    </button>
</div>

<!-- Filter panel -->
<div class="bg-panel rounded-xl border border-line p-4 mb-5 shadow-card">
    <form method="GET" action="<?= e(url('/users')) ?>" id="filterForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search']) ?>"
                        placeholder="Name, email, phone…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Role</label>
                <select name="role"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All Roles</option>
                    <?php foreach (['admin', 'staff'] as $r): ?>
                        <option value="<?= e($r) ?>" <?= $filters['role'] === $r ? 'selected' : '' ?>>
                            <?= ucfirst($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Status</label>
                <select name="is_active"
                    class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All</option>
                    <option value="1" <?= $filters['is_active'] === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $filters['is_active'] === '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between flex-wrap gap-3 mt-3 pt-3 border-t border-line">
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand text-white text-[13px] font-semibold hover:opacity-90 transition">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Apply
                </button>
                <?php if (array_filter($filters, fn($v) => $v !== '' && $v !== null)): ?>
                    <a href="<?= e(url('/users')) ?>"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
    <?php if (empty($users)): ?>
        <div class="py-16 text-center">
            <i data-lucide="users" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
            <p class="text-[13px] font-semibold text-ink">No users found</p>
            <p class="text-[12px] text-muted mt-1">Add a user to get started.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-line bg-surface/60">
                        <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted w-8">#</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">User</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Email</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden md:table-cell">Phone</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Role</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Status</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden lg:table-cell">Last Login</th>
                        <th class="text-right px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    <?php foreach ($users as $idx => $u):
                        $colorKey  = $colorKeys[((int)$u['id'] - 1) % count($colorKeys)];
                        $color     = $avatarColors[$colorKey];
                        $initials  = User::initials($u);
                        $rm        = $roleMeta[$u['role']] ?? $roleMeta['staff'];
                        $rowOffset = ($page - 1) * $result['per_page'];
                        $isMe      = ((int) $u['id']) === $myId;
                    ?>
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <td class="px-5 py-3.5 text-muted font-medium"><?= $rowOffset + $idx + 1 ?></td>

                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg <?= $color['bg'] ?> <?= $color['text'] ?> grid place-items-center text-[11px] font-bold shrink-0">
                                        <?= e($initials) ?>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-ink leading-snug flex items-center gap-1.5">
                                            <?= e($u['name']) ?>
                                            <?php if ($isMe): ?>
                                                <span class="text-[10px] font-semibold uppercase tracking-[0.1em] px-1.5 py-0.5 rounded bg-brand-50 text-brand-700 border border-brand-100">You</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-[11px] text-muted leading-snug">
                                            Joined <?= e(date('d M Y', strtotime($u['created_at']))) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3.5">
                                <span class="text-ink-soft truncate max-w-[200px] inline-block"><?= e($u['email']) ?></span>
                            </td>

                            <td class="px-4 py-3.5 text-ink-soft hidden md:table-cell">
                                <?= e($u['phone'] ?? '—') ?>
                            </td>

                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold border <?= $rm['cls'] ?>">
                                    <i data-lucide="<?= e($rm['icon']) ?>" class="w-3 h-3"></i>
                                    <?= $rm['label'] ?>
                                </span>
                            </td>

                            <td class="px-4 py-3.5">
                                <?php if ((int) $u['is_active'] === 1): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold border bg-success-50 text-success border-success/20">Active</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold border bg-line-soft text-muted border-line">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-3.5 text-muted hidden lg:table-cell">
                                <?= $u['last_login_at'] ? e(date('d M Y, H:i', strtotime($u['last_login_at']))) : '—' ?>
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($u), ENT_QUOTES) ?>)"
                                        class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-brand-50 hover:text-brand transition"
                                        title="Edit">
                                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <?php if (!$isMe): ?>
                                        <button
                                            onclick="openDeleteModal(<?= (int) $u['id'] ?>, '<?= e(addslashes($u['name'])) ?>')"
                                            class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-danger-50 hover:text-danger transition"
                                            title="Delete">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pages > 1): ?>
            <div class="flex items-center justify-between px-5 py-3.5 border-t border-line bg-surface/40">
                <p class="text-[12px] text-muted">
                    Showing <?= (($page - 1) * $result['per_page']) + 1 ?>–<?= min($page * $result['per_page'], $total) ?> of <?= $total ?>
                </p>
                <div class="flex items-center gap-1">
                    <?php
                    for ($i = 1; $i <= $pages; $i++):
                        $url_i = url('/users') . '?' . http_build_query(array_filter($filters, fn($v) => $v !== '' && $v !== null) + ['page' => $i]);
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
     MODAL: Add User
════════════════════════════════════════════════════════════ -->
<div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('addModal')"></div>
    <div class="relative w-full max-w-lg max-h-[90vh] flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                    <i data-lucide="user-plus" class="w-4 h-4 text-brand"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add User</h3>
                    <p class="text-[11px] text-muted">Create a new admin or staff account</p>
                </div>
            </div>
            <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form action="<?= e(url('/users/store')) ?>" method="POST" class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div>
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Priya Sharma" class="form-input">
            </div>
            <div>
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" required placeholder="user@example.com" class="form-input">
            </div>
            <div>
                <label class="form-label">Mobile Number</label>
                <div class="relative">
                    <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="tel" name="phone" placeholder="+91 98765 43210" class="form-input pl-9">
                </div>
            </div>
            <div>
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" required minlength="8" placeholder="At least 8 characters" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-input">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-input">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Create User
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
     MODAL: Edit User
════════════════════════════════════════════════════════════ -->
<div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal('editModal')"></div>
    <div class="relative w-full max-w-lg max-h-[90vh] flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-warn-50 grid place-items-center">
                    <i data-lucide="pencil" class="w-4 h-4 text-warn"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Edit User</h3>
                    <p class="text-[11px] text-muted" id="editModalSubtitle">Update user details</p>
                </div>
            </div>
            <button onclick="closeModal('editModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <form id="editForm" action="" method="POST" class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>
            <div id="editSelfNotice" class="hidden rounded-lg bg-brand-50 border border-brand-100 text-brand-700 px-3 py-2 text-[12px] flex items-center gap-2">
                <i data-lucide="info" class="w-3.5 h-3.5"></i>
                You can't change your own role or deactivate yourself.
            </div>
            <div>
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="edit_name" required class="form-input">
            </div>
            <div>
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" id="edit_email" required class="form-input">
            </div>
            <div>
                <label class="form-label">Mobile Number</label>
                <div class="relative">
                    <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="tel" name="phone" id="edit_phone" class="form-input pl-9">
                </div>
            </div>
            <div>
                <label class="form-label">New Password</label>
                <input type="password" name="password" id="edit_password" minlength="8" placeholder="Leave blank to keep current" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" id="edit_role" class="form-input">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" id="edit_is_active" class="form-input">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Update User
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
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete User?</h3>
        <p class="text-[13px] text-muted mb-5">
            <strong id="deleteUserName" class="text-ink"></strong> will lose access immediately.<br>
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
.form-input:disabled { opacity: 0.6; cursor: not-allowed; }
</style>

<script>
var BASE   = '<?= e(rtrim(url(''), '/')) ?>';
var MY_ID  = <?= (int) $myId ?>;

function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openEditModal(u) {
    var f = document.getElementById('editForm');
    f.action = BASE + '/users/' + u.id + '/update';
    document.getElementById('edit_name').value      = u.name      || '';
    document.getElementById('edit_email').value     = u.email     || '';
    document.getElementById('edit_phone').value     = u.phone     || '';
    document.getElementById('edit_password').value  = '';
    document.getElementById('edit_role').value      = u.role      || 'staff';
    document.getElementById('edit_is_active').value = String(u.is_active);
    document.getElementById('editModalSubtitle').textContent = u.name || 'Update user details';

    var isMe = parseInt(u.id, 10) === MY_ID;
    document.getElementById('edit_role').disabled      = isMe;
    document.getElementById('edit_is_active').disabled = isMe;
    document.getElementById('editSelfNotice').classList.toggle('hidden', !isMe);

    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = BASE + '/users/' + id + '/delete';
    document.getElementById('deleteUserName').textContent = name;
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
