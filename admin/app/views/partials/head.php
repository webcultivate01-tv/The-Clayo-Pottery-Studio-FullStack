<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="referrer" content="strict-origin-when-cross-origin">
<title><?= e($title ?? 'Dashboard') ?> · The Clayo Admin</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          surface:       '#f6f7fb',
          panel:         '#ffffff',
          line:          '#e9ecf3',
          'line-soft':   '#f1f3f8',
          ink:           '#0f172a',
          'ink-soft':    '#334155',
          muted:         '#64748b',
          subtle:        '#94a3b8',
          brand:         '#4f46e5',
          'brand-50':    '#eef2ff',
          'brand-100':   '#e0e7ff',
          'brand-600':   '#4f46e5',
          'brand-700':   '#4338ca',
          accent:        '#f97316',
          'accent-50':   '#fff7ed',
          success:       '#10b981',
          'success-50':  '#ecfdf5',
          warn:          '#f59e0b',
          'warn-50':     '#fffbeb',
          danger:        '#ef4444',
          'danger-50':   '#fef2f2',
          teal:          '#0891b2',
          'teal-50':     '#ecfeff',
          'teal-700':    '#0e7490',
        },
        fontFamily: {
          sans:    ['Inter', 'system-ui', '-apple-system', 'Segoe UI', 'sans-serif'],
          display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          heading: ['"Playfair Display"', 'Georgia', 'serif'],
        },
        boxShadow: {
          'card':  '0 1px 2px rgba(15, 23, 42, 0.04), 0 1px 3px rgba(15, 23, 42, 0.04)',
          'pop':   '0 8px 24px -6px rgba(15, 23, 42, 0.12), 0 2px 6px rgba(15, 23, 42, 0.06)',
          'ring':  '0 0 0 4px rgba(79, 70, 229, 0.12)',
        },
        borderRadius: {
          'xl2': '0.875rem',
        },
      },
    },
  };
</script>

<style>
  html { -webkit-text-size-adjust: 100%; }
  body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    font-feature-settings: 'cv11','ss01','ss03';
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;
  }
  h1, h2, h3, h4, .font-display {
    font-family: 'Plus Jakarta Sans', Inter, sans-serif;
    letter-spacing: -0.01em;
  }
  ::-webkit-scrollbar { width: 8px; height: 8px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #d8dde8; border-radius: 8px; }
  ::-webkit-scrollbar-thumb:hover { background: #b8c0d0; }

  /* Pulse dot */
  .pulse-dot { position: relative; }
  .pulse-dot::after {
    content: ''; position: absolute; inset: -4px; border-radius: 9999px;
    background: rgba(16, 185, 129, 0.35); animation: pulse 1.8s ease-out infinite;
  }
  @keyframes pulse { 0%{transform:scale(.6);opacity:.9} 100%{transform:scale(1.6);opacity:0} }

  /* Lucide icon defaults: refined 1.75 stroke, non-shrinking in flex */
  [data-lucide], svg.lucide { stroke-width: 1.75; flex-shrink: 0; }
</style>
