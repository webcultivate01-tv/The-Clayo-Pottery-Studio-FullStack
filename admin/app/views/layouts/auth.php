<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <title><?= e($title ?? 'Sign In') ?> · The Clayo Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>

    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              cream:       '#faf7f2',
              blush:       '#f5ede6',
              'blush-100': '#ede0d6',
              rose:        '#d4a09a',
              gold:        '#b8935a',
              'gold-50':   '#fdf6ec',
              'gold-100':  '#f5e6cc',
              'gold-700':  '#9a7340',
              sage:        '#8fa88a',
              charcoal:    '#2c2420',
              brown:       '#5c3d2e',
              muted:       '#8a7a70',
              terra:       '#c1654a',
              'terra-50':  '#fdf2ef',
              'terra-600': '#a8503a',
            },
            fontFamily: {
              heading: ['"Playfair Display"', 'Georgia', 'serif'],
              body:    ['Inter', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
              'warm':  '0 8px 32px -8px rgba(44, 36, 32, 0.14), 0 2px 8px rgba(44, 36, 32, 0.06)',
              'card':  '0 1px 3px rgba(44, 36, 32, 0.06), 0 1px 2px rgba(44, 36, 32, 0.04)',
            },
          },
        },
      };
    </script>

    <style>
      html { -webkit-text-size-adjust: 100%; }
      body {
        font-family: 'Inter', system-ui, sans-serif;
        background-color: #faf7f2;
        color: #2c2420;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }
      h1, h2, h3, .font-heading { font-family: 'Playfair Display', Georgia, serif; }

      [data-lucide], svg.lucide { stroke-width: 1.75; flex-shrink: 0; }

      .grain-overlay {
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        background-repeat: repeat;
        background-size: 128px 128px;
      }

      input:focus { outline: none; }
    </style>
</head>
<body class="h-full bg-cream">
    <main class="min-h-screen flex items-center justify-center px-4 py-12 relative overflow-hidden">

        <!-- Warm decorative blobs -->
        <div class="absolute inset-0 -z-10 pointer-events-none">
            <div class="absolute -top-40 -left-40 w-[28rem] h-[28rem] rounded-full opacity-50 blur-3xl"
                 style="background: radial-gradient(circle, #e8d5b7 0%, #f5ede6 60%, transparent 100%);"></div>
            <div class="absolute -bottom-40 -right-32 w-[26rem] h-[26rem] rounded-full opacity-40 blur-3xl"
                 style="background: radial-gradient(circle, #d4a09a 0%, #f5ede6 55%, transparent 100%);"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[40rem] h-[40rem] rounded-full opacity-20 blur-3xl"
                 style="background: radial-gradient(circle, #c1654a 0%, transparent 65%);"></div>
        </div>

        <!-- Grain texture overlay -->
        <div class="absolute inset-0 -z-10 grain-overlay pointer-events-none"></div>

        <?= $content ?>
    </main>

    <script>
        if (window.lucide) lucide.createIcons();
    </script>
</body>
</html>
