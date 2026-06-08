<?php
function error_page(int $code, string $message, string $icon): void {
    $title = 'Error ' . $code;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require ROOT_PATH . '/app/views/partials/head.php'; ?>
</head>
<body class="bg-cream text-charcoal min-h-screen grid place-items-center relative overflow-hidden">
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-blush opacity-50 blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-gold-light opacity-30 blur-3xl"></div>
    <div class="text-center relative max-w-md px-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-brown to-charcoal text-gold-light mb-6 shadow-soft">
            <i data-lucide="<?= e($icon) ?>" class="w-8 h-8"></i>
        </div>
        <div class="font-heading text-7xl text-charcoal leading-none"><?= (int) $code ?></div>
        <p class="mt-3 text-muted"><?= e($message) ?></p>
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 mt-8 px-5 py-3 rounded-xl bg-brown hover:bg-charcoal text-cream text-sm font-semibold transition shadow-soft">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Go back
        </a>
    </div>
    <script>
        if (window.lucide) lucide.createIcons();
    </script>
</body>
</html>
<?php } ?>
