<?php
$recipientCount   = (int) ($recipientCount ?? 0);
$totalClients     = (int) ($totalClients ?? 0);
$sampleRecipients = $sampleRecipients ?? [];
$inactiveOrMissing = max(0, $totalClients - $recipientCount);
?>

<!-- Page header -->
<div class="mb-5 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="font-display text-2xl font-bold text-ink">Notifications</h2>
        <p class="text-[13px] text-muted mt-0.5">
            Send a one-off email broadcast to every active client on file.
        </p>
    </div>
</div>

<!-- Stat cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
    <div class="bg-panel rounded-xl border border-line shadow-card p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand grid place-items-center shrink-0">
            <i data-lucide="mail-check" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-[22px] font-bold text-ink leading-none"><?= $recipientCount ?></div>
            <div class="text-[12px] text-muted mt-1">Will receive email</div>
        </div>
    </div>
    <div class="bg-panel rounded-xl border border-line shadow-card p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-accent-50 text-accent grid place-items-center shrink-0">
            <i data-lucide="users" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-[22px] font-bold text-ink leading-none"><?= $totalClients ?></div>
            <div class="text-[12px] text-muted mt-1">Total clients</div>
        </div>
    </div>
    <div class="bg-panel rounded-xl border border-line shadow-card p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-warning-50 text-warning grid place-items-center shrink-0">
            <i data-lucide="mail-x" class="w-5 h-5"></i>
        </div>
        <div>
            <div class="text-[22px] font-bold text-ink leading-none"><?= $inactiveOrMissing ?></div>
            <div class="text-[12px] text-muted mt-1">No email / inactive</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <!-- Compose card -->
    <div class="lg:col-span-2 bg-panel rounded-xl border border-line shadow-card overflow-hidden">
        <div class="px-5 py-4 border-b border-line flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-brand-50 grid place-items-center">
                <i data-lucide="send" class="w-4 h-4 text-brand"></i>
            </div>
            <div>
                <h3 class="font-display text-[15px] font-bold text-ink">Compose Broadcast</h3>
                <p class="text-[11px] text-muted">All recipients are placed in BCC — they won't see each other.</p>
            </div>
        </div>

        <form method="POST" action="<?= e(url('/notifications/send')) ?>" class="p-5 space-y-4"
              onsubmit="return confirmBroadcast(this);">
            <?= csrf_field() ?>

            <div>
                <label class="bk-label">Audience</label>
                <select name="audience" class="bk-input">
                    <option value="active" selected>Active clients with email (<?= $recipientCount ?>)</option>
                    <option value="all">Every client with an email on file</option>
                </select>
            </div>

            <div>
                <label class="bk-label">Subject <span class="text-danger">*</span></label>
                <input type="text" name="subject" maxlength="200" required class="bk-input"
                       placeholder="e.g. New workshop dates for August">
            </div>

            <div>
                <label class="bk-label">Message <span class="text-danger">*</span></label>
                <textarea name="message" rows="10" required class="bk-input resize-y"
                          placeholder="Write the message you want every client to receive. Line breaks are preserved."></textarea>
                <p class="text-[11px] text-muted mt-1.5">
                    The message is wrapped in a branded email template. Avoid pasting HTML — plain text works best.
                </p>
            </div>

            <div class="pt-2 flex items-center gap-3 flex-wrap">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand to-brand-700 text-white text-[13px] font-semibold hover:opacity-90 transition shadow-card">
                    <i data-lucide="send" class="w-4 h-4"></i> Send to <?= $recipientCount ?> client<?= $recipientCount === 1 ? '' : 's' ?>
                </button>
                <span class="text-[12px] text-muted inline-flex items-center gap-1.5">
                    <i data-lucide="shield-alert" class="w-3.5 h-3.5"></i>
                    This action emails real customers — please double-check before sending.
                </span>
            </div>
        </form>
    </div>

    <!-- Recipient preview card -->
    <div class="bg-panel rounded-xl border border-line shadow-card overflow-hidden">
        <div class="px-5 py-4 border-b border-line flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-accent-50 grid place-items-center">
                <i data-lucide="contact" class="w-4 h-4 text-accent"></i>
            </div>
            <div>
                <h3 class="font-display text-[15px] font-bold text-ink">Recipient Preview</h3>
                <p class="text-[11px] text-muted">A sample of who will be emailed</p>
            </div>
        </div>

        <div class="p-5">
            <?php if (empty($sampleRecipients)): ?>
                <div class="py-8 text-center">
                    <i data-lucide="mail-x" class="w-8 h-8 text-subtle mx-auto mb-2"></i>
                    <p class="text-[13px] font-semibold text-ink">No eligible recipients</p>
                    <p class="text-[12px] text-muted mt-1">Add clients with email addresses to enable broadcasts.</p>
                </div>
            <?php else: ?>
                <ul class="space-y-2">
                    <?php foreach ($sampleRecipients as $email): ?>
                        <li class="flex items-center gap-2 text-[13px] text-ink-soft px-3 py-2 rounded-lg bg-surface border border-line">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-subtle shrink-0"></i>
                            <span class="truncate"><?= e((string) $email) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if ($recipientCount > count($sampleRecipients)): ?>
                    <p class="text-[12px] text-muted mt-3 text-center">
                        + <?= $recipientCount - count($sampleRecipients) ?> more
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.bk-label { display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.12em; color:#64748b; margin-bottom:6px; }
.bk-input { width:100%; padding:9px 12px; background:#f6f7fb; border:1px solid #e9ecf3; border-radius:8px; font-size:13px; color:#0f172a; transition:border-color .15s, box-shadow .15s; outline:none; }
.bk-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
.bk-input::placeholder { color:#94a3b8; }
</style>

<script>
function confirmBroadcast(form) {
    var sel = form.querySelector('[name="audience"]');
    var label = sel.options[sel.selectedIndex].text;
    return confirm('Send this email to: ' + label + '?\n\nThis cannot be undone.');
}
</script>
