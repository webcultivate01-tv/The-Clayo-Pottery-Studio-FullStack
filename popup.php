<?php
/**
 * Website promotional popup.
 *
 * Drop-in partial included before </body> on every public page. It pulls the
 * single "live" popup configured in the admin panel (Admin → Popups) and renders
 * it as a centered modal with a close button. Each visitor sees it once per
 * browser session (sessionStorage), keyed to the popup's id + updated_at so an
 * edited popup re-appears.
 *
 * Self-contained: its own DB read, its own scoped CSS (clayo- prefix) and JS.
 * Safe to include even when no popup is configured — it simply renders nothing.
 */

$clayoPopup = null;
try {
    $db   = require __DIR__ . '/admin/config/database.php';
    $dsn  = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset={$db['charset']}";
    $pdo  = new PDO($dsn, $db['username'], $db['password'], $db['options']);
    $stmt = $pdo->query(
        "SELECT * FROM popups
         WHERE is_active = 1
           AND (starts_at  IS NULL OR starts_at  <= CURDATE())
           AND (expires_at IS NULL OR expires_at >= CURDATE())
         ORDER BY sort_order ASC, created_at DESC
         LIMIT 1"
    );
    $clayoPopup = $stmt->fetch() ?: null;
} catch (Throwable $e) {
    $clayoPopup = null;
}

if ($clayoPopup):
    if (!function_exists('clayo_e')) {
        function clayo_e(?string $v): string {
            return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }
    }

    $pImg   = !empty($clayoPopup['image_path']) ? 'public/' . ltrim($clayoPopup['image_path'], '/') : '';
    $pUrl   = trim((string) ($clayoPopup['button_url'] ?? ''));
    $pLabel = trim((string) ($clayoPopup['button_label'] ?? ''));
    // Unique key so an edited popup shows again even within the same session.
    $pKey   = 'clayoPopup-' . (int) $clayoPopup['id'] . '-' . strtotime((string) ($clayoPopup['updated_at'] ?? 'now'));
?>
<div id="clayoPopupOverlay" class="clayo-popup-overlay" data-key="<?= clayo_e($pKey) ?>" aria-hidden="true">
    <div class="clayo-popup" role="dialog" aria-modal="true" aria-labelledby="clayoPopupTitle">
        <button type="button" class="clayo-popup-close" aria-label="Close" onclick="clayoClosePopup()">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <?php if ($pImg): ?>
            <div class="clayo-popup-media">
                <img src="<?= clayo_e($pImg) ?>" alt="<?= clayo_e($clayoPopup['title']) ?>" loading="lazy">
            </div>
        <?php endif; ?>

        <div class="clayo-popup-body">
            <?php if (!empty($clayoPopup['subtitle'])): ?>
                <span class="clayo-popup-eyebrow"><?= clayo_e($clayoPopup['subtitle']) ?></span>
            <?php endif; ?>
            <h3 id="clayoPopupTitle" class="clayo-popup-title"><?= clayo_e($clayoPopup['title']) ?></h3>
            <?php if (!empty($clayoPopup['description'])): ?>
                <p class="clayo-popup-text"><?= nl2br(clayo_e($clayoPopup['description'])) ?></p>
            <?php endif; ?>
            <?php if ($pLabel !== '' && $pUrl !== ''): ?>
                <a href="<?= clayo_e($pUrl) ?>" class="clayo-popup-btn"><?= clayo_e($pLabel) ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .clayo-popup-overlay {
        position: fixed; inset: 0; z-index: 100000;
        display: none; align-items: center; justify-content: center;
        padding: 20px;
        background: rgba(28, 18, 12, 0.6);
        backdrop-filter: blur(4px);
        opacity: 0; transition: opacity .3s ease;
    }
    .clayo-popup-overlay.clayo-open { display: flex; opacity: 1; }
    .clayo-popup {
        position: relative; width: 100%; max-width: 440px;
        max-height: 90vh; overflow: hidden;
        background: #faf6f0; border-radius: 24px;
        box-shadow: 0 30px 80px rgba(28, 18, 12, 0.35);
        transform: translateY(16px) scale(.98);
        transition: transform .35s cubic-bezier(.2,.8,.2,1);
        border: 1px solid rgba(184, 121, 58, 0.18);
    }
    .clayo-popup-overlay.clayo-open .clayo-popup { transform: translateY(0) scale(1); }
    .clayo-popup-close {
        position: absolute; top: 12px; right: 12px; z-index: 2;
        width: 36px; height: 36px; border-radius: 50%;
        display: grid; place-items: center;
        background: rgba(255, 255, 255, 0.92); color: #5c3820;
        border: none; cursor: pointer;
        box-shadow: 0 4px 14px rgba(28, 18, 12, 0.18);
        transition: background .2s, transform .2s, color .2s;
    }
    .clayo-popup-close:hover { background: #b8793a; color: #fff; transform: rotate(90deg); }
    .clayo-popup-media { width: 100%; aspect-ratio: 16 / 10; overflow: hidden;
        border-radius: 24px 24px 0 0; background: linear-gradient(135deg, #f5ede0, #e8d5b0); }
    .clayo-popup-media img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .clayo-popup-body { padding: 26px 28px 30px; text-align: center; }
    .clayo-popup-eyebrow {
        display: inline-block; font-size: 0.7rem; font-weight: 600;
        letter-spacing: 0.16em; text-transform: uppercase;
        color: #b8793a; background: #e8d0a8;
        padding: 5px 14px; border-radius: 100px; margin-bottom: 12px;
    }
    .clayo-popup-title {
        font-family: "Playfair Display", serif;
        font-size: 1.55rem; line-height: 1.2; font-weight: 700;
        color: #2c1f14; margin: 0 0 10px;
    }
    .clayo-popup-text {
        font-family: "Inter", sans-serif; font-size: 0.92rem; line-height: 1.6;
        color: #8a7060; margin: 0 0 20px;
    }
    .clayo-popup-btn {
        display: inline-block; background: #5c3820; color: #faf6f0;
        padding: 13px 34px; border-radius: 100px;
        font-family: "Inter", sans-serif; font-size: 0.9rem; font-weight: 500;
        letter-spacing: 0.03em; text-decoration: none;
        transition: background .25s, transform .25s, box-shadow .25s;
    }
    .clayo-popup-btn:hover {
        background: #b8793a; transform: translateY(-2px);
        box-shadow: 0 10px 26px rgba(92, 56, 32, 0.32);
    }
    @media (max-width: 480px) {
        .clayo-popup-title { font-size: 1.35rem; }
        .clayo-popup-body { padding: 22px 22px 26px; }
    }
</style>

<script>
(function () {
    var overlay = document.getElementById('clayoPopupOverlay');
    if (!overlay) return;
    var key = overlay.getAttribute('data-key');

    // Show once per browser session.
    try {
        if (sessionStorage.getItem(key) === 'seen') return;
    } catch (e) { /* storage blocked — show anyway */ }

    function openPopup() {
        overlay.classList.add('clayo-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    window.clayoClosePopup = function () {
        overlay.classList.remove('clayo-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        try { sessionStorage.setItem(key, 'seen'); } catch (e) {}
    };

    // Close on overlay click (but not when clicking the popup itself).
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) window.clayoClosePopup();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('clayo-open')) window.clayoClosePopup();
    });

    // Small delay so the page settles before the popup appears.
    setTimeout(openPopup, 900);
})();
</script>
<?php endif; ?>
