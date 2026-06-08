<?php
use Calyo\Models\Booking;

$enquiries  = $result['data'];
$total      = $result['total'];
$pages      = $result['pages'];
$page       = $result['page'];

$statusMeta = Booking::statusMeta();
$ranges     = Booking::quickRanges();
$sources    = Booking::sourceMeta();
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Enquiries</h2>
        <p class="text-[13px] text-muted mt-0.5">
            <?= $total ?> enquir<?= $total === 1 ? 'y' : 'ies' ?>
            <?php if (array_filter(array_diff_key($filters, ['service' => 1]))): ?><span class="text-brand font-medium">· filtered</span><?php endif; ?>
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button onclick="openAddEnquiry()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Enquiry
        </button>
    </div>
</div>

<!-- Status summary pills -->
<div class="flex flex-wrap gap-2 mb-4">
    <?php
    $statusOrder = ['pending','confirmed','completed','cancelled'];
    $dotColors   = ['pending'=>'#f59e0b','confirmed'=>'#4f46e5','completed'=>'#10b981','cancelled'=>'#ef4444'];
    foreach ($statusOrder as $sk):
        $sm       = $statusMeta[$sk];
        $isActive = ($filters['status'] ?? '') === $sk;
        $params   = $filters;
        unset($params['service']); // don't leak the forced filter into URL
        $href      = url('/enquiries') . '?' . http_build_query(array_filter(array_merge($params, ['status' => $sk, 'page' => 1])));
        $clearHref = url('/enquiries') . '?' . http_build_query(array_filter(array_merge($params, ['status' => '', 'page' => 1])));
    ?>
        <a href="<?= e($isActive ? $clearHref : $href) ?>"
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold border transition <?= $isActive ? $sm['cls'] . ' ring-2 ring-offset-1 ring-current/30' : 'bg-panel border-line text-muted hover:bg-line-soft' ?>">
            <span class="w-1.5 h-1.5 rounded-full" style="background:<?= $dotColors[$sk] ?>"></span>
            <?= $sm['label'] ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Filters -->
<div class="bg-panel rounded-xl border border-line shadow-card mb-5">
    <form method="GET" action="<?= e(url('/enquiries')) ?>">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 p-4">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Search</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-[14px] h-[14px] text-subtle"></i>
                    <input type="text" name="search" value="<?= e($filters['search'] ?? '') ?>"
                        placeholder="Name, phone, email…"
                        class="w-full pl-9 pr-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink placeholder:text-subtle focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition">
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Status</label>
                <select name="status" class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All</option>
                    <?php foreach ($statusMeta as $sk => $sm): ?>
                        <option value="<?= e($sk) ?>" <?= ($filters['status'] ?? '') === $sk ? 'selected' : '' ?>><?= $sm['label'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Source</label>
                <select name="source" class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <option value="">All sources</option>
                    <?php foreach ($sources as $sk => $sm): ?>
                        <option value="<?= e($sk) ?>" <?= ($filters['source'] ?? '') === $sk ? 'selected' : '' ?>><?= e($sm['label']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Received</label>
                <select name="received_range" class="w-full px-3 py-2 bg-surface border border-line rounded-lg text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/25 focus:border-brand transition appearance-none">
                    <?php foreach ($ranges as $rk => $rl): ?>
                        <option value="<?= e($rk) ?>" <?= ($filters['received_range'] ?? 'all') === $rk ? 'selected' : '' ?>><?= e($rl) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="flex items-center justify-between flex-wrap gap-3 px-4 py-3 border-t border-line bg-surface/40 rounded-b-xl">
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand text-white text-[13px] font-semibold hover:opacity-90 transition">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Apply Filters
                </button>
                <?php if (array_filter(array_diff_key($filters, ['service' => 1, 'received_range' => 1]))
                    || ($filters['received_range'] ?? 'all') !== 'all'): ?>
                    <a href="<?= e(url('/enquiries')) ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear All
                    </a>
                <?php endif; ?>
            </div>
            <span class="text-[12px] text-muted hidden sm:inline">Tip: enquiries don't have a preferred date — they're questions, not bookings.</span>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
    <?php if (empty($enquiries)): ?>
        <div class="py-16 text-center">
            <i data-lucide="message-square-dashed" class="w-10 h-10 text-subtle mx-auto mb-3"></i>
            <p class="text-[13px] font-semibold text-ink">No enquiries found</p>
            <p class="text-[12px] text-muted mt-1">
                <?= array_filter(array_diff_key($filters, ['service' => 1])) ? 'Try adjusting your filters.' : 'Customer questions from the website will appear here.' ?>
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
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Subject / Message</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Status</th>
                        <th class="text-left px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted hidden lg:table-cell">Received</th>
                        <th class="text-right px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    <?php
                    foreach ($enquiries as $idx => $b):
                        $initials  = strtoupper(substr($b['customer_name'], 0, 1));
                        $sm        = $statusMeta[$b['status']] ?? $statusMeta['pending'];
                        $rowOffset = ($page - 1) * $result['per_page'];
                        // First line of message becomes the subject preview
                        $subjectLine = strtok((string) $b['message'], "\n") ?: '(no subject)';
                        $bodyPreview = trim(substr((string) $b['message'], strlen($subjectLine)));
                    ?>
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <td class="px-5 py-3.5 text-muted font-medium"><?= $rowOffset + $idx + 1 ?></td>

                            <!-- Customer -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-accent-50 text-accent grid place-items-center text-[12px] font-bold shrink-0">
                                        <?= e($initials) ?>
                                    </div>
                                    <div class="font-semibold text-ink leading-snug"><?= e($b['customer_name']) ?></div>
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

                            <!-- Subject / Message -->
                            <td class="px-4 py-3.5 max-w-[280px]">
                                <div class="font-medium text-ink truncate"><?= e($subjectLine) ?></div>
                                <?php if ($bodyPreview !== ''): ?>
                                    <div class="text-[11px] text-muted mt-0.5 truncate"><?= e($bodyPreview) ?></div>
                                <?php endif; ?>
                            </td>

                            <!-- Status (inline dropdown reuses styling from bookings) -->
                            <td class="px-4 py-3.5">
                                <form method="POST" action="<?= e(url('/enquiries/' . $b['id'] . '/status')) ?>" class="inline-block">
                                    <?= csrf_field() ?>
                                    <select name="status" onchange="this.form.submit()" class="status-select status-<?= e($b['status']) ?>">
                                        <?php foreach (Booking::workflowStatuses() as $sk):
                                            $opt = $statusMeta[$sk]; ?>
                                            <option value="<?= e($sk) ?>" <?= $b['status'] === $sk ? 'selected' : '' ?>><?= e($opt['label']) ?></option>
                                        <?php endforeach; ?>
                                        <?php if (!in_array($b['status'], Booking::workflowStatuses(), true) && isset($statusMeta[$b['status']])): ?>
                                            <option value="<?= e($b['status']) ?>" selected><?= e($statusMeta[$b['status']]['label']) ?></option>
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
                                    <button onclick='openEnquiryView(<?= json_encode($b, JSON_HEX_QUOT|JSON_HEX_APOS|JSON_HEX_TAG) ?>)'
                                        class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-brand-50 hover:text-brand transition" title="View">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button onclick="openEnquiryDelete(<?= (int) $b['id'] ?>, '<?= e(addslashes($b['customer_name'])) ?>')"
                                        class="w-7 h-7 rounded-lg grid place-items-center text-ink-soft hover:bg-danger-50 hover:text-danger transition" title="Delete">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
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
                    $pagerParams = array_filter(array_diff_key($filters, ['service' => 1]));
                    for ($i = 1; $i <= $pages; $i++):
                        $url_i  = url('/enquiries') . '?' . http_build_query($pagerParams + ['page' => $i]);
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
     MODAL: Add Enquiry (centered)
════════════════════════════════════════════════════════ -->
<div id="enquiryAddModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEnquiryModal('enquiryAddModal')"></div>
    <div class="relative w-full max-w-xl flex flex-col bg-panel rounded-2xl shadow-pop overflow-hidden" style="max-height:90vh">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-accent-50 grid place-items-center">
                    <i data-lucide="message-square-plus" class="w-4 h-4 text-accent"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Add Enquiry</h3>
                    <p class="text-[11px] text-muted">Phone, walk-in or referral — log it here</p>
                </div>
            </div>
            <button onclick="closeEnquiryModal('enquiryAddModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form method="POST" action="<?= e(url('/enquiries/store')) ?>"
              class="flex-1 overflow-y-auto px-6 py-5 space-y-4"
              style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="sm:col-span-2">
                    <label class="bk-label">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" required maxlength="150" class="bk-input" placeholder="e.g. Meera Jain">
                </div>
                <div>
                    <label class="bk-label">Phone <span class="text-danger">*</span></label>
                    <input type="tel" name="phone" required maxlength="40" class="bk-input" placeholder="e.g. 9876543210">
                </div>
                <div>
                    <label class="bk-label">Email</label>
                    <input type="email" name="email" maxlength="190" class="bk-input" placeholder="optional">
                </div>
                <div>
                    <label class="bk-label">Source</label>
                    <select name="source" class="bk-input">
                        <option value="phone" selected>Phone enquiry</option>
                        <option value="walk_in">Walk-in</option>
                        <option value="admin">Added by admin</option>
                        <option value="website">Website (manual entry)</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="bk-label">Subject</label>
                    <input type="text" name="subject" maxlength="200" class="bk-input" placeholder="e.g. Custom mug order for corporate gifting">
                </div>
                <div class="sm:col-span-2">
                    <label class="bk-label">Message <span class="text-muted font-normal normal-case tracking-normal">(what they asked)</span></label>
                    <textarea name="message" rows="4" class="bk-input resize-none" placeholder="What did the customer ask? Any details — quantity, dates, group size, etc."></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="bk-label">Internal Notes</label>
                    <textarea name="notes" rows="2" class="bk-input resize-none" placeholder="Internal notes — not shown to customer"></textarea>
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    Save Enquiry
                </button>
                <button type="button" onclick="closeEnquiryModal('enquiryAddModal')" class="px-5 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: View Enquiry
════════════════════════════════════════════════════════ -->
<div id="enquiryViewModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEnquiryModal('enquiryViewModal')"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-lg flex flex-col bg-panel shadow-pop">
        <div class="flex items-center justify-between px-6 py-4 border-b border-line shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-accent-50 grid place-items-center">
                    <i data-lucide="message-square" class="w-4 h-4 text-accent"></i>
                </div>
                <div>
                    <h3 class="font-display text-[15px] font-bold text-ink">Enquiry Details</h3>
                    <p class="text-[11px] text-muted" id="ev_subtitle">Customer enquiry</p>
                </div>
            </div>
            <button onclick="closeEnquiryModal('enquiryViewModal')" class="w-8 h-8 rounded-lg grid place-items-center text-ink-soft hover:bg-line-soft transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-5" style="scrollbar-width:thin;scrollbar-color:#d8dde8 transparent">
            <div class="bg-surface rounded-xl border border-line p-4 mb-5 space-y-2.5">
                <div class="flex items-center gap-2 text-[13px]">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="font-semibold text-ink" id="ev_name"></span>
                </div>
                <div class="flex items-center gap-2 text-[13px]">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="ev_phone"></span>
                    <a id="ev_whatsapp" href="#" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#25D366]/15 text-[#128C7E] text-[11px] font-semibold hover:bg-[#25D366]/25 transition">
                        <i data-lucide="message-circle" class="w-3 h-3"></i> WhatsApp
                    </a>
                </div>
                <div class="flex items-center gap-2 text-[13px]" id="ev_email_row">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="ev_email"></span>
                </div>
                <div class="flex items-start gap-2 text-[13px]" id="ev_address_row">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-subtle shrink-0 mt-0.5"></i>
                    <span class="text-ink-soft" id="ev_address"></span>
                </div>
                <div class="flex items-center gap-2 text-[13px]">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                    <span class="text-ink-soft" id="ev_source"></span>
                    <span class="text-subtle">·</span>
                    <span class="text-muted" id="ev_received"></span>
                </div>
            </div>

            <div class="bg-surface rounded-xl border border-line p-4 mb-5">
                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-1.5">Customer Question</p>
                <p id="ev_message" class="text-[13px] text-ink whitespace-pre-line"></p>
            </div>

            <form id="enquiryUpdateForm" action="" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="bk-label">Status</label>
                    <select name="status" id="ev_status_select" class="bk-input">
                        <option value="pending">New Order</option>
                        <option value="confirmed">In Production</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="bk-label">Internal Notes</label>
                    <textarea name="notes" id="ev_notes" rows="3" placeholder="Add follow-up notes…" class="bk-input resize-none"></textarea>
                </div>
                <div class="pt-2 flex gap-3">
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeEnquiryModal('enquiryViewModal')" class="px-5 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ════════════════════════════════════════════════════════
     MODAL: Delete Confirm
════════════════════════════════════════════════════════ -->
<div id="enquiryDeleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEnquiryModal('enquiryDeleteModal')"></div>
    <div class="relative bg-panel rounded-2xl shadow-pop w-full max-w-sm p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-danger-50 grid place-items-center mx-auto mb-4">
            <i data-lucide="trash-2" class="w-5 h-5 text-danger"></i>
        </div>
        <h3 class="font-display text-[16px] font-bold text-ink mb-1">Delete Enquiry?</h3>
        <p class="text-[13px] text-muted mb-5">
            Enquiry from <strong id="enquiryDeleteName" class="text-ink"></strong> will be permanently removed.
        </p>
        <form id="enquiryDeleteForm" action="" method="POST" class="flex gap-3">
            <?= csrf_field() ?>
            <button type="button" onclick="closeEnquiryModal('enquiryDeleteModal')" class="flex-1 py-2.5 rounded-xl border border-line text-[13px] text-ink-soft hover:bg-line-soft transition">
                Cancel
            </button>
            <button type="submit" class="flex-1 py-2.5 rounded-xl bg-danger text-white text-[13px] font-semibold hover:opacity-90 transition">
                Yes, Delete
            </button>
        </form>
    </div>
</div>


<style>
.bk-label { display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.12em; color:#64748b; margin-bottom:6px; }
.bk-input { width:100%; padding:8px 12px; background:#f6f7fb; border:1px solid #e9ecf3; border-radius:8px; font-size:13px; color:#0f172a; transition:border-color .15s, box-shadow .15s; outline:none; }
.bk-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
.bk-input::placeholder { color:#94a3b8; }

/* Inline status dropdown pill — shared with bookings page */
.status-select { appearance:none; -webkit-appearance:none; background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 20 20' fill='none'><path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.8' d='m6 8 4 4 4-4'/></svg>"); background-position:right 8px center; background-repeat:no-repeat; background-size:10px; padding:4px 24px 4px 12px; font-size:11px; font-weight:600; border-radius:999px; border:1px solid; cursor:pointer; transition:filter .15s, box-shadow .15s; line-height:1.4; min-width:130px; }
.status-select:hover { filter:brightness(0.96); }
.status-select:focus { outline:none; box-shadow:0 0 0 3px rgba(79,70,229,.18); }
.status-pending   { color:#b45309; background-color:#fef3c7; border-color:rgba(245,158,11,.35); }
.status-confirmed { color:#4f46e5; background-color:#eef2ff; border-color:rgba(79,70,229,.35); }
.status-completed { color:#047857; background-color:#d1fae5; border-color:rgba(16,185,129,.35); }
.status-cancelled { color:#b91c1c; background-color:#fee2e2; border-color:rgba(239,68,68,.35); }
.status-no_show   { color:#475569; background-color:#f1f5f9; border-color:rgba(148,163,184,.35); }
.status-select option { color:#0f172a; background:#ffffff; font-weight:500; }
</style>

<script>
var EBASE = '<?= e(rtrim(url(''), '/')) ?>';

function openAddEnquiry() {
    var m = document.getElementById('enquiryAddModal');
    m.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    var form = m.querySelector('form');
    if (form) form.reset();
    if (window.lucide) lucide.createIcons();
}

function openEnquiryView(b) {
    document.getElementById('ev_subtitle').textContent = b.customer_name;
    document.getElementById('ev_name').textContent     = b.customer_name;
    document.getElementById('ev_phone').textContent    = b.phone;

    var wa = document.getElementById('ev_whatsapp');
    var digits = (b.phone || '').replace(/\D+/g, '');
    if (digits.length >= 8) { wa.href = 'https://wa.me/' + digits; wa.style.display = 'inline-flex'; }
    else { wa.style.display = 'none'; }

    var er = document.getElementById('ev_email_row');
    if (b.email) { document.getElementById('ev_email').textContent = b.email; er.style.display = 'flex'; }
    else { er.style.display = 'none'; }

    var ar = document.getElementById('ev_address_row');
    if (b.address) { document.getElementById('ev_address').textContent = b.address; ar.style.display = 'flex'; }
    else { ar.style.display = 'none'; }

    document.getElementById('ev_source').textContent   = (b.source || '').replace('_', '-');
    document.getElementById('ev_received').textContent = new Date(b.created_at).toLocaleString();
    document.getElementById('ev_message').textContent  = b.message || '(no message provided)';

    document.getElementById('ev_status_select').value = b.status || 'pending';
    document.getElementById('ev_notes').value         = b.notes || '';
    document.getElementById('enquiryUpdateForm').action = EBASE + '/enquiries/' + b.id + '/status';

    document.getElementById('enquiryViewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (window.lucide) lucide.createIcons();
}

function openEnquiryDelete(id, name) {
    document.getElementById('enquiryDeleteForm').action       = EBASE + '/enquiries/' + id + '/delete';
    document.getElementById('enquiryDeleteName').textContent  = name;
    document.getElementById('enquiryDeleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEnquiryModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['enquiryAddModal','enquiryViewModal','enquiryDeleteModal'].forEach(closeEnquiryModal);
    }
});
</script>
