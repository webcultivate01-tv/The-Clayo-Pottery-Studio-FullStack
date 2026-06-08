<?php
/**
 * Gallery images are managed from the admin panel (Admin → Gallery).
 * Each row is either an uploaded file (stored under /public) or a direct
 * external URL. We read the active ones here and render the masonry grid
 * from the database. Self-contained DB read, mirrors popup.php.
 */
$galleryImages = [];
// Default category labels (slug => label). Overridden below from the
// gallery_categories table when it is available, so the admin's
// "Manage Categories" changes flow through to this page.
$galleryCategoryLabels = [
    'mugs'      => 'Mugs & Cups',
    'bowls'     => 'Bowls',
    'vases'     => 'Vases',
    'sculpture' => 'Sculpture',
    'workshop'  => 'Workshop',
    'studio'    => 'Studio',
];
try {
    $db   = require __DIR__ . '/admin/config/database.php';
    $dsn  = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset={$db['charset']}";
    $pdo  = new PDO($dsn, $db['username'], $db['password'], $db['options']);

    // Pull active categories (own guard: a pre-migration DB keeps the defaults).
    try {
        $catRows = $pdo->query(
            "SELECT slug, label FROM gallery_categories
             WHERE is_active = 1
             ORDER BY sort_order ASC, label ASC"
        )->fetchAll();
        if ($catRows) {
            $galleryCategoryLabels = [];
            foreach ($catRows as $cat) {
                $galleryCategoryLabels[(string) $cat['slug']] = (string) $cat['label'];
            }
        }
    } catch (Throwable $e) {
        // gallery_categories not present — keep the defaults above.
    }

    $stmt = $pdo->query(
        "SELECT title, category, source_type, image_path, image_url
         FROM gallery_images
         WHERE is_active = 1
         ORDER BY sort_order ASC, created_at DESC"
    );
    foreach ($stmt->fetchAll() as $row) {
        $src = ($row['source_type'] === 'url')
            ? trim((string) ($row['image_url'] ?? ''))
            : (!empty($row['image_path']) ? 'public/' . ltrim((string) $row['image_path'], '/') : '');
        if ($src === '') continue;
        $slug = (string) $row['category'];
        $row['src']           = $src;
        $row['slug']          = $slug;
        $row['categoryLabel'] = $galleryCategoryLabels[$slug] ?? ucfirst($slug);
        $galleryImages[]      = $row;
    }
} catch (Throwable $e) {
    $galleryImages = [];
}

if (!function_exists('clayo_e')) {
    function clayo_e(?string $v): string {
        return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Gallery – The Clayo Pottery Studio | Our Handcrafted Creations
    </title>
    <meta
      name="description"
      content="Explore the gallery of handcrafted pottery and ceramic creations from The Clayo Pottery Studio, Amravati. Browse our mugs, bowls, vases, sculptures and studio workspace."
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              cream: "#faf6f0",
              blush: "#f5ede0",
              rose: "#c97c50",
              gold: "#b8793a",
              "gold-light": "#e8d0a8",
              charcoal: "#2c1f14",
              brown: "#5c3820",
              muted: "#8a7060",
              terra: "#c4643a",
              clay: "#a0522d",
              sand: "#e8d5b0",
            },
            fontFamily: {
              heading: ['"Playfair Display"', "serif"],
              body: ["Inter", "sans-serif"],
            },
          },
        },
      };
    </script>
    <style>
      body {
        font-family: "Inter", sans-serif;
        background-color: #faf6f0;
        color: #2c1f14;
        overflow-x: hidden;
      }
      html {
        overflow-x: hidden;
      }
      *,
      *::before,
      *::after {
        box-sizing: border-box;
      }
      h1,
      h2,
      h3,
      h4 {
        font-family: "Playfair Display", serif;
      }

      /* STICKY HEADER */
      .sticky-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        width: 100%;
      }
      #navbar {
        position: relative !important;
        top: auto !important;
        z-index: auto !important;
      }
      body {
        padding-top: var(--header-height, 114px);
      }

      .navbar-scrolled {
        box-shadow: 0 4px 30px rgba(80, 40, 20, 0.1);
      }
      .nav-link {
        position: relative;
        padding: 6px 0 !important;
        margin: 0 16px;
        background: transparent !important;
        border-radius: 0 !important;
      }
      .nav-link::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #b8793a;
        transition: width 0.3s;
        border-radius: 2px;
      }
      .nav-link:hover::after,
      .nav-link.active::after {
        width: 100%;
      }
      .nav-link:hover {
        color: #5c3820 !important;
        background: transparent !important;
      }

      /* Scroll Reveal */
      .reveal {
        opacity: 0;
        transform: translateY(32px);
        transition:
          opacity 0.7s ease,
          transform 0.7s ease;
      }
      .reveal.revealed {
        opacity: 1;
        transform: translateY(0);
      }
      .reveal-left {
        opacity: 0;
        transform: translateX(-36px);
        transition:
          opacity 0.7s ease,
          transform 0.7s ease;
      }
      .reveal-left.revealed {
        opacity: 1;
        transform: translateX(0);
      }
      .reveal-right {
        opacity: 0;
        transform: translateX(36px);
        transition:
          opacity 0.7s ease,
          transform 0.7s ease;
      }
      .reveal-right.revealed {
        opacity: 1;
        transform: translateX(0);
      }
      .reveal-scale {
        opacity: 0;
        transform: scale(0.93);
        transition:
          opacity 0.65s ease,
          transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .reveal-scale.revealed {
        opacity: 1;
        transform: scale(1);
      }

      .section-tag {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #b8793a;
        background: #e8d0a8;
        padding: 6px 18px;
        border-radius: 100px;
        margin-bottom: 14px;
      }
      .btn-primary {
        display: inline-block;
        background: #5c3820;
        color: #faf6f0;
        padding: 14px 32px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        font-family: "Inter", sans-serif;
        letter-spacing: 0.03em;
        transition: all 0.25s;
      }
      .btn-primary:hover {
        background: #b8793a;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(92, 56, 32, 0.3);
      }
      .btn-outline {
        display: inline-block;
        border: 2px solid #5c3820;
        color: #5c3820;
        padding: 12px 30px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        transition: all 0.25s;
      }
      .btn-outline:hover {
        background: #5c3820;
        color: #faf6f0;
        transform: translateY(-2px);
      }

      .hamburger-bar {
        display: block;
        width: 24px;
        height: 2px;
        background: #5c3820;
        border-radius: 2px;
        transition: all 0.3s;
      }
      .hamburger.active .hamburger-bar:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
      }
      .hamburger.active .hamburger-bar:nth-child(2) {
        opacity: 0;
      }
      .hamburger.active .hamburger-bar:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
      }

      .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(44, 31, 20, 0.45);
        z-index: 99998;
        backdrop-filter: blur(2px);
        opacity: 0;
        visibility: hidden;
        transition:
          opacity 0.3s ease,
          visibility 0.3s ease;
      }
      .drawer-overlay.open {
        opacity: 1;
        visibility: visible;
      }
      .mobile-drawer {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        height: 100vh !important;
        width: 280px;
        max-width: 85vw;
        background: #fff;
        z-index: 99999 !important;
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: -8px 0 40px rgba(44, 31, 20, 0.18);
        overflow-y: auto;
      }
      .mobile-drawer.open {
        transform: translateX(0);
      }
      .drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 20px 16px;
        border-bottom: 1px solid #f0e4d0;
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 1001;
      }
      .drawer-close {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #faf6f0;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5c3820;
        font-size: 1rem;
        transition: background 0.2s;
      }
      .drawer-close:hover {
        background: #f5ede0;
      }
      .drawer-nav {
        padding: 12px 16px;
        flex: 1;
      }
      .drawer-nav a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #8a7060;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 4px;
      }
      .drawer-nav a:hover,
      .drawer-nav a.active {
        background: #f5ede0;
        color: #5c3820;
      }
      .drawer-nav a.active {
        font-weight: 600;
      }
      .drawer-nav a i {
        width: 18px;
        text-align: center;
        color: #b8793a;
      }
      .drawer-footer {
        padding: 16px;
        border-top: 1px solid #f0e4d0;
      }

      /* TOPBAR */
      .topbar {
        background: #5c3820;
        color: #e8d0a8;
        font-size: 0.78rem;
        padding: 8px 0;
      }
      .topbar a {
        color: #e8d0a8;
        text-decoration: none;
        transition: color 0.2s;
      }
      .topbar a:hover {
        color: #fff;
      }
      .topbar-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
      }
      .topbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
      }
      .topbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
      }

      /* Gallery Masonry Grid */
      .gallery-grid {
        columns: 3;
        column-gap: 16px;
      }
      @media (max-width: 1024px) {
        .gallery-grid {
          columns: 2;
        }
      }
      @media (max-width: 540px) {
        .gallery-grid {
          columns: 1;
        }
      }
      .gallery-item {
        break-inside: avoid;
        margin-bottom: 16px;
      }

      /* Gallery Card */
      .g-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        display: block;
        background: #e8d5b0;
      }
      .g-card img {
        width: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.5s ease;
        min-height: 180px;
        background: #e8d0a8;
      }
      .g-card:hover img {
        transform: scale(1.06);
      }
      .g-overlay {
        position: absolute;
        inset: 0;
        background: rgba(44, 31, 20, 0);
        transition: background 0.3s;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: flex-end;
        padding: 16px;
      }
      .g-card:hover .g-overlay {
        background: rgba(44, 31, 20, 0.55);
      }
      .g-overlay-content {
        opacity: 0;
        transform: translateY(8px);
        transition: all 0.3s;
        color: white;
        text-align: right;
      }
      .g-card:hover .g-overlay-content {
        opacity: 1;
        transform: translateY(0);
      }
      .g-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.92);
        color: #5c3820;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
      }

      /* Filter Buttons */
      .filter-btn {
        background: white;
        border: 1.5px solid #e8d0a8;
        color: #8a7060;
        padding: 9px 20px;
        border-radius: 100px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-family: "Inter", sans-serif;
        white-space: nowrap;
      }
      .filter-btn.active,
      .filter-btn:hover {
        background: #5c3820;
        color: #faf6f0;
        border-color: #5c3820;
      }

      /* LIGHTBOX */
      .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(10, 6, 3, 0.96);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
      }
      .lightbox.open {
        display: flex;
      }
      .lb-inner {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: min(90vw, 900px);
        width: 100%;
      }
      .lb-img {
        width: 100%;
        max-height: 72vh;
        object-fit: contain;
        border-radius: 14px;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.6);
        display: block;
      }
      .lb-caption {
        margin-top: 18px;
        text-align: center;
        color: white;
        width: 100%;
      }
      .lb-caption h4 {
        font-family: "Playfair Display", serif;
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 4px;
      }
      .lb-caption p {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.55);
        margin: 0;
      }
      .lb-close {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        z-index: 10000;
      }
      .lb-close:hover {
        background: rgba(0, 0, 0, 0.85);
      }
      .lb-prev,
      .lb-next {
        position: fixed;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        z-index: 10000;
      }
      .lb-prev {
        left: 16px;
      }
      .lb-next {
        right: 16px;
      }
      .lb-prev:hover,
      .lb-next:hover {
        background: rgba(0, 0, 0, 0.85);
      }

      .cta-section {
        background: linear-gradient(
          135deg,
          #fdf8f0 0%,
          #f5ede0 50%,
          #ede0cc 100%
        );
        position: relative;
        overflow: hidden;
      }
      .cta-section::before {
        content: "";
        position: absolute;
        top: -60px;
        left: -60px;
        width: 300px;
        height: 300px;
        background: radial-gradient(
          circle,
          rgba(184, 121, 58, 0.15),
          transparent
        );
        border-radius: 50%;
      }
      .cta-section::after {
        content: "";
        position: absolute;
        bottom: -60px;
        right: -60px;
        width: 250px;
        height: 250px;
        background: radial-gradient(
          circle,
          rgba(196, 100, 58, 0.15),
          transparent
        );
        border-radius: 50%;
      }

      .whatsapp-btn {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 997;
        width: 56px;
        height: 56px;
        background: #25d366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        transition: transform 0.2s;
      }
      .whatsapp-btn:hover {
        transform: scale(1.1);
      }

      /* Navbar */
      #navbar {
        background: rgba(255, 255, 255, 0.98) !important;
      }

      @media (max-width: 640px) {
        .topbar-inner {
          justify-content: center;
          padding: 0 16px;
        }
        .topbar-left {
          flex-wrap: wrap;
          justify-content: center;
          gap: 8px 16px;
        }
        .topbar-right {
          display: none !important;
        }
        .topbar {
          text-align: center;
        }
        .lb-img {
          max-height: 60vh;
          border-radius: 10px;
        }
        .lb-caption h4 {
          font-size: 0.95rem;
        }
        section {
          overflow-x: hidden;
          padding: 50px 20px !important;
        }
        .reveal-left,
        .reveal-right {
          transform: translateY(28px) !important;
        }
        .reveal-left.revealed,
        .reveal-right.revealed {
          transform: translateY(0) !important;
        }
        .gallery-grid {
          columns: 1;
        }
        h1 {
          font-size: 2.2rem !important;
          line-height: 1.2 !important;
        }
        h2 {
          font-size: 1.6rem !important;
        }
        .flex.gap-4 {
          flex-direction: column;
          gap: 12px;
        }
        .btn-primary,
        .btn-outline {
          width: 100%;
          text-align: center;
          justify-content: center;
        }
        .filter-btn {
          font-size: 0.78rem;
          padding: 8px 16px;
        }
      }
      @media (max-width: 480px) {
        .topbar {
          display: none;
        }
        h1 {
          font-size: 1.8rem !important;
        }
        .filter-btn {
          font-size: 0.75rem;
          padding: 7px 14px;
        }
      }
      @media (max-width: 768px) {
        .topbar {
          font-size: 0.72rem;
          padding: 6px 0;
        }
        .max-w-6xl.mx-auto.px-6.h-20 {
          height: 64px !important;
        }
        .grid {
          gap: 16px;
        }
      }
      @media (max-width: 540px) {
        .lb-prev {
          left: 8px;
        }
        .lb-next {
          right: 8px;
        }
      }
      @media (max-width: 375px) {
        #navbar .font-heading {
          font-size: 1.2rem !important;
        }
      }
    </style>
  </head>
  <body>
    <!-- STICKY HEADER -->
    <div class="sticky-header">
      <!-- TOPBAR -->
      <div class="topbar">
        <div class="topbar-inner">
          <div class="topbar-left">
            <a href="tel:+919724788561"
              ><i class="fa-solid fa-phone mr-1"></i> +91 9724788561</a
            >
            <a href="mailto:info@theclayo.com" class="hidden sm:inline"
              ><i class="fa-solid fa-envelope mr-1"></i> info@theclayo.com</a
            >
          </div>
          <div class="topbar-right">
            <span
              ><i class="fa-regular fa-clock mr-1"></i> Mon–Sat: 10 AM – 7
              PM</span
            >
            <span
              ><i class="fa-solid fa-location-dot mr-1"></i> The Clayo Pottery
              Studio Sai Nagar, Akoli Road, Amravati-444607, Maharashtra</span
            >
          </div>
        </div>
      </div>

      <!-- NAV -->
      <nav
        id="navbar"
        class="sticky top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-amber-100 transition-all duration-300"
      >
        <div
          class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between"
        >
          <div class="flex flex-col leading-tight">
            <span
              class="font-heading text-brown flex items-end gap-1 leading-none"
            >
              <span class="text-sm font-medium uppercase tracking-[0.2em]">
                The
              </span>

              <span class="text-3xl font-semibold"> Clayo </span>
            </span>

            <span
              class="text-[11px] tracking-[0.35em] uppercase text-gold font-medium mt-1"
            >
              Pottery Studio
            </span>
          </div>
          <ul class="desktop-nav hidden md:flex items-center">
            <li>
              <a
                href="index.php"
                class="nav-link text-sm font-medium text-muted transition-colors"
                >Home</a
              >
            </li>
            <li>
              <a
                href="about.php"
                class="nav-link text-sm font-medium text-muted transition-colors"
                >About</a
              >
            </li>
            <li>
              <a
                href="services.php"
                class="nav-link text-sm font-medium text-muted transition-colors"
                >Workshops</a
              >
            </li>
            <li>
              <a
                href="gallery.php"
                class="nav-link active text-sm font-medium text-brown transition-colors"
                >Gallery</a
              >
            </li>
            <li>
              <a
                href="contact.php"
                class="nav-link text-sm font-medium text-muted transition-colors"
                >Contact</a
              >
            </li>
            <li class="ml-6">
              <a href="contact.php" class="btn-primary text-sm">Book Now</a>
            </li>
          </ul>
          <button
            id="hamburger"
            class="md:hidden hamburger flex flex-col gap-1.5 p-2 bg-none border-none cursor-pointer"
          >
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
          </button>
        </div>
      </nav>
    </div>

    <!-- MOBILE DRAWER OVERLAY -->
    <div class="drawer-overlay" id="drawerOverlay"></div>

    <!-- MOBILE DRAWER -->
    <div class="mobile-drawer" id="mobileDrawer">
      <div class="drawer-header">
          <div class="flex flex-col leading-tight">
            <span
              class="font-heading text-brown flex items-end gap-1 leading-none"
            >
              <span class="text-sm font-medium uppercase tracking-[0.2em]">
                The
              </span>

              <span class="text-3xl font-semibold"> Clayo </span>
            </span>

            <span
              class="text-[11px] tracking-[0.35em] uppercase text-gold font-medium mt-1"
            >
              Pottery Studio
            </span>
          </div>
        <button class="drawer-close" id="drawerClose">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <nav class="drawer-nav">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about.php"><i class="fa-solid fa-circle-info"></i> About</a>
        <a href="services.php"
          ><i class="fa-solid fa-fire-flame-curved"></i> Workshops</a
        >
        <a href="gallery.php" class="active"
          ><i class="fa-solid fa-images"></i> Gallery</a
        >
        <a href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a>
      </nav>
      <div class="drawer-footer">
        <a
          href="contact.php"
          class="btn-primary"
          style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
          "
          ><i class="fa-regular fa-calendar-check"></i> Book now</a
        >
      </div>
    </div>

    <!-- PAGE HERO -->
    <section
      class="relative overflow-hidden"
      style="
        background: linear-gradient(
          135deg,
          #faf6f0 0%,
          #f5ede0 60%,
          #ede0cc 100%
        );
        padding: 80px 0 60px;
      "
    >
      <div
        style="
          position: absolute;
          top: -80px;
          right: -80px;
          width: 360px;
          height: 360px;
          border-radius: 50%;
          background: rgba(184, 121, 58, 0.1);
          pointer-events: none;
        "
      ></div>
      <div
        style="
          position: absolute;
          bottom: -60px;
          left: -60px;
          width: 260px;
          height: 260px;
          border-radius: 50%;
          background: rgba(196, 100, 58, 0.1);
          pointer-events: none;
        "
      ></div>

      <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <!-- LEFT: Text -->
          <div class="reveal-left text-left">
            <span class="section-tag"
              ><i class="fa-solid fa-images mr-1"></i> Our Creations</span
            >
            <h1
              class="font-heading font-bold leading-tight mt-3 mb-5"
              style="font-size: clamp(2.4rem, 5vw, 3.8rem); color: #2c1f14"
            >
              Our
              <span class="font-heading" style="color: #b8793a">Gallery</span>
              of<br />Handcrafted Art
            </h1>
            <p
              class="text-lg leading-relaxed mb-8 max-w-lg"
              style="color: #8a7060"
            >
              From raw earth to timeless ceramic art. Explore our collection of
              handthrown mugs, bowls, vases, sculptures and the beautiful
              workspace where every piece is born.
            </p>
            <div class="flex flex-wrap gap-4">
              <a href="contact.php" class="btn-primary"
                ><i class="fa-solid fa-hands-clapping mr-2"></i>Join a
                Workshop</a
              >
              <a href="services.php" class="btn-outline">View Workshops</a>
            </div>
            <!-- Trust badges -->
            <div class="flex flex-wrap gap-3 mt-8">
              <span
                style="
                  display: inline-flex;
                  align-items: center;
                  gap: 6px;
                  background: #fff;
                  border: 1px solid #e8d0a8;
                  border-radius: 100px;
                  padding: 6px 14px;
                  font-size: 0.78rem;
                  font-weight: 600;
                  color: #5c3820;
                "
              >
                <i class="fa-solid fa-circle-check" style="color: #b8793a"></i>
                Handcrafted Pieces
              </span>
              <span
                style="
                  display: inline-flex;
                  align-items: center;
                  gap: 6px;
                  background: #fff;
                  border: 1px solid #e8d0a8;
                  border-radius: 100px;
                  padding: 6px 14px;
                  font-size: 0.78rem;
                  font-weight: 600;
                  color: #5c3820;
                "
              >
                <i class="fa-solid fa-star" style="color: #b8793a"></i> 4.9
                Rated Studio
              </span>
              <span
                style="
                  display: inline-flex;
                  align-items: center;
                  gap: 6px;
                  background: #fff;
                  border: 1px solid #e8d0a8;
                  border-radius: 100px;
                  padding: 6px 14px;
                  font-size: 0.78rem;
                  font-weight: 600;
                  color: #5c3820;
                "
              >
                <i class="fa-solid fa-users" style="color: #b8793a"></i> 1000+
                Students
              </span>
            </div>
          </div>

          <!-- RIGHT: Circular image desktop -->
          <div
            class="reveal-right hidden lg:flex justify-center items-center"
            style="transition-delay: 0.15s"
          >
            <div style="position: relative">
              <div
                style="
                  width: 340px;
                  height: 340px;
                  border-radius: 50%;
                  overflow: hidden;
                  border: 6px solid #fff;
                  box-shadow: 0 24px 80px rgba(80, 40, 20, 0.2);
                  position: relative;
                "
              >
                <img
                  src="https://lh3.googleusercontent.com/p/AF1QipPYEnyKsB8AslgFyIN_RAP2kESwAbeE-_oYTgM3=s1360-w1360-h1020-rw"
                  alt="Pottery Workshop"
                  style="
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: center;
                  "
                />
              </div>
              <div
                style="
                  position: absolute;
                  inset: -14px;
                  border-radius: 50%;
                  border: 2px dashed rgba(184, 121, 58, 0.35);
                  pointer-events: none;
                "
              ></div>
              <!-- Badge bottom-left -->
              <div
                style="
                  position: absolute;
                  bottom: 20px;
                  left: -30px;
                  background: #fff;
                  border-radius: 16px;
                  padding: 12px 18px;
                  box-shadow: 0 8px 32px rgba(80, 40, 20, 0.16);
                  display: flex;
                  align-items: center;
                  gap: 10px;
                  min-width: 170px;
                "
              >
                <div
                  style="
                    width: 36px;
                    height: 36px;
                    border-radius: 10px;
                    background: linear-gradient(135deg, #b8793a, #8a5a1a);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                  "
                >
                  <i
                    class="fa-solid fa-images"
                    style="color: #fff; font-size: 0.85rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="
                      font-family: &quot;Playfair Display&quot;, serif;
                      font-size: 1.1rem;
                      font-weight: 700;
                      color: #5c3820;
                      line-height: 1;
                    "
                  >
                    1500+
                  </div>
                  <div
                    style="font-size: 0.68rem; color: #8a7060; margin-top: 1px"
                  >
                    Pieces Created
                  </div>
                </div>
              </div>
              <!-- Badge top-right -->
              <div
                style="
                  position: absolute;
                  top: 20px;
                  right: -24px;
                  background: #fff;
                  border-radius: 16px;
                  padding: 10px 16px;
                  box-shadow: 0 8px 32px rgba(80, 40, 20, 0.14);
                  display: flex;
                  align-items: center;
                  gap: 8px;
                "
              >
                <div
                  style="
                    width: 30px;
                    height: 30px;
                    border-radius: 8px;
                    background: #fdf5e8;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                  "
                >
                  <i
                    class="fa-solid fa-star"
                    style="color: #b8793a; font-size: 0.8rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="font-size: 0.85rem; font-weight: 700; color: #5c3820"
                  >
                    4.9 / 5.0
                  </div>
                  <div style="font-size: 0.65rem; color: #8a7060">
                    Student Rating
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Mobile Image -->
          <div
            class="reveal-right lg:hidden flex justify-center items-center mt-8"
            style="transition-delay: 0.15s"
          >
            <div style="position: relative; width: 100%; max-width: 320px">
              <div
                style="
                  width: 100%;
                  aspect-ratio: 1;
                  border-radius: 50%;
                  overflow: hidden;
                  border: 5px solid #fff;
                  box-shadow: 0 20px 60px rgba(80, 40, 20, 0.2);
                  position: relative;
                "
              >
                <img
                  src="https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=700&q=85"
                  alt="Pottery Workshop"
                  style="
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: center;
                  "
                />
              </div>
              <div
                style="
                  position: absolute;
                  inset: -12px;
                  border-radius: 50%;
                  border: 2px dashed rgba(184, 121, 58, 0.35);
                  pointer-events: none;
                "
              ></div>
              <div
                style="
                  position: absolute;
                  bottom: 15px;
                  left: -15px;
                  background: #fff;
                  border-radius: 14px;
                  padding: 10px 14px;
                  box-shadow: 0 6px 24px rgba(80, 40, 20, 0.16);
                  display: flex;
                  align-items: center;
                  gap: 8px;
                  min-width: 140px;
                "
              >
                <div
                  style="
                    width: 32px;
                    height: 32px;
                    border-radius: 8px;
                    background: linear-gradient(135deg, #b8793a, #8a5a1a);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                  "
                >
                  <i
                    class="fa-solid fa-images"
                    style="color: #fff; font-size: 0.75rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="
                      font-family: &quot;Playfair Display&quot;, serif;
                      font-size: 0.95rem;
                      font-weight: 700;
                      color: #5c3820;
                      line-height: 1;
                    "
                  >
                    500+
                  </div>
                  <div
                    style="font-size: 0.6rem; color: #8a7060; margin-top: 1px"
                  >
                    Pieces
                  </div>
                </div>
              </div>
              <div
                style="
                  position: absolute;
                  top: 15px;
                  right: -15px;
                  background: #fff;
                  border-radius: 14px;
                  padding: 8px 12px;
                  box-shadow: 0 6px 24px rgba(80, 40, 20, 0.14);
                  display: flex;
                  align-items: center;
                  gap: 6px;
                "
              >
                <div
                  style="
                    width: 26px;
                    height: 26px;
                    border-radius: 6px;
                    background: #fdf5e8;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                  "
                >
                  <i
                    class="fa-solid fa-star"
                    style="color: #b8793a; font-size: 0.7rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="font-size: 0.75rem; font-weight: 700; color: #5c3820"
                  >
                    4.9/5
                  </div>
                  <div style="font-size: 0.58rem; color: #8a7060">Rating</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- GALLERY SECTION -->
    <section class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-3 justify-center mb-12 reveal">
          <button class="filter-btn active" data-filter="all">All</button>
          <?php foreach ($galleryCategoryLabels as $slug => $label): ?>
          <button class="filter-btn" data-filter="<?= clayo_e($slug) ?>"><?= clayo_e($label) ?></button>
          <?php endforeach; ?>
        </div>

        <!-- Masonry Grid (managed in Admin → Gallery) -->
        <div class="gallery-grid" id="galleryGrid">
          <?php if (empty($galleryImages)): ?>
          <p style="grid-column:1/-1;text-align:center;color:#8a7060;padding:48px 0;">
            No gallery images yet. Please check back soon.
          </p>
          <?php else: ?>
          <?php foreach ($galleryImages as $gi => $g): ?>
          <div
            class="gallery-item reveal"
            data-category="<?= clayo_e($g['slug']) ?>"
            style="transition-delay: <?= number_format(($gi % 3) * 0.06, 2) ?>s"
          >
            <div
              class="g-card"
              data-title="<?= clayo_e($g['title']) ?>"
              data-category="<?= clayo_e($g['categoryLabel']) ?>"
              data-src="<?= clayo_e($g['src']) ?>"
            >
              <img
                src="<?= clayo_e($g['src']) ?>"
                alt="<?= clayo_e($g['title']) ?>"
                loading="lazy"
              />
              <div class="g-overlay">
                <div class="g-overlay-content">
                  <div class="text-sm font-semibold"><?= clayo_e($g['title']) ?></div>
                  <div class="text-xs opacity-70 mt-1">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i>View Photo
                  </div>
                </div>
              </div>
              <div class="g-tag"><?= clayo_e($g['categoryLabel']) ?></div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>


    <!-- LIGHTBOX -->
    <div class="lightbox" id="lightbox">
      <button class="lb-close" id="lbClose">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <button class="lb-prev" id="lbPrev">
        <i class="fa-solid fa-chevron-left"></i>
      </button>
      <button class="lb-next" id="lbNext">
        <i class="fa-solid fa-chevron-right"></i>
      </button>
      <div class="lb-inner">
        <img id="lbImg" src="" alt="" class="lb-img" />
        <div class="lb-caption">
          <h4 id="lbTitle"></h4>
          <p id="lbCategory"></p>
        </div>
      </div>
    </div>

    <!-- COUNT BAND -->
    <section class="py-14 text-center reveal" style="background: #5c3820">
      <div class="max-w-4xl mx-auto px-6">
        <p class="font-heading text-2xl text-white mb-2">
          Join <span style="color: #b8793a">1,200+</span> students who've shaped
          their own pottery at The Clayo
        </p>
        <p class="mb-8" style="color: rgba(255, 255, 255, 0.6)">
          Every piece in this gallery was crafted with love, clay, and
          creativity — right here in Amravati.
        </p>
        <a
          href="contact.php"
          class="px-8 py-4 rounded-full font-semibold inline-block transition-colors"
          style="background: #b8793a; color: #fff"
          onmouseover="this.style.background = '#9a6530'"
          onmouseout="this.style.background = '#b8793a'"
        >
          <i class="fa-solid fa-hands-clapping mr-2"></i>Start Your Pottery
          Journey
        </a>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-section py-24">
      <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
        <span class="section-tag">Enroll Today</span>
        <h2
          class="font-heading text-4xl lg:text-5xl font-bold mt-4 mb-5 leading-tight"
          style="color: #2c1f14"
        >
          Your Creation
          <span class="font-heading" style="color: #b8793a">Starts Here</span>
        </h2>
        <p
          class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed"
          style="color: #8a7060"
        >
          Ready to see your pottery in our gallery? Enroll in a beginner or
          advanced workshop and craft your own ceramic masterpiece under expert
          guidance.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="contact.php" class="btn-primary text-base px-8 py-4"
            ><i class="fa-solid fa-hands-clapping mr-2"></i>Enroll in a
            Workshop</a
          >
          <a href="services.php" class="btn-outline text-base px-8 py-4"
            >Browse Workshops</a
          >
        </div>
      </div>
    </section>

    <!-- FOOTER -->
      <footer style="background: #1a0e06">
      <div class="max-w-6xl mx-auto px-6 pt-14 pb-10">
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 footer-grid"
          style="border-bottom: 1px solid rgba(196, 103, 58, 0.18)"
        >
          <!-- Col 1: Brand -->
          <div>
            <div class="flex items-center gap-3 mb-4">
              <div class="flex flex-col leading-tight">
                <span
                  class="font-heading text-brown flex items-end gap-1 leading-none"
                >
                  <span
                    class="text-sm font-medium uppercase tracking-[0.2em] text-gold"
                  >
                    The
                  </span>

                  <span class="text-3xl font-semibold text-white"> Clayo </span>
                </span>

                <span
                  class="text-[11px] tracking-[0.35em] uppercase text-gold font-medium mt-1"
                >
                  Pottery Studio
                </span>
              </div>
            </div>
            <p
              style="
                font-size: 0.82rem;
                color: rgba(255, 255, 255, 0.5);
                line-height: 1.75;
                margin-bottom: 20px;
              "
            >
              A creative sanctuary in Amravati where clay meets artistry.
              Wheel-throwing workshops, hand-building classes, and custom
              ceramics since 2015.
            </p>
            <div class="flex gap-2">
              <a
                href="https://www.facebook.com/theclayo"
                style="
                  width: 34px;
                  height: 34px;
                  border-radius: 8px;
                  background: rgba(255, 255, 255, 0.07);
                  border: 1px solid rgba(255, 255, 255, 0.12);
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  color: rgba(255, 255, 255, 0.6);
                  font-size: 0.85rem;
                  transition: all 0.2s;
                  text-decoration: none;
                "
                onmouseover="
                  this.style.background = '#c4673a';
                  this.style.borderColor = '#c4673a';
                  this.style.color = '#fff';
                "
                onmouseout="
                  this.style.background = 'rgba(255,255,255,0.07)';
                  this.style.borderColor = 'rgba(255,255,255,0.12)';
                  this.style.color = 'rgba(255,255,255,0.6)';
                "
                ><i class="fa-brands fa-facebook-f"></i
              ></a>
              <a
                href="https://www.instagram.com/theclayo"
                style="
                  width: 34px;
                  height: 34px;
                  border-radius: 8px;
                  background: rgba(255, 255, 255, 0.07);
                  border: 1px solid rgba(255, 255, 255, 0.12);
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  color: rgba(255, 255, 255, 0.6);
                  font-size: 0.85rem;
                  transition: all 0.2s;
                  text-decoration: none;
                "
                onmouseover="
                  this.style.background = '#c4673a';
                  this.style.borderColor = '#c4673a';
                  this.style.color = '#fff';
                "
                onmouseout="
                  this.style.background = 'rgba(255,255,255,0.07)';
                  this.style.borderColor = 'rgba(255,255,255,0.12)';
                  this.style.color = 'rgba(255,255,255,0.6)';
                "
                ><i class="fa-brands fa-instagram"></i
              ></a>
              <a
                href="https://www.youtube.com/theclayo"
                style="
                  width: 34px;
                  height: 34px;
                  border-radius: 8px;
                  background: rgba(255, 255, 255, 0.07);
                  border: 1px solid rgba(255, 255, 255, 0.12);
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  color: rgba(255, 255, 255, 0.6);
                  font-size: 0.85rem;
                  transition: all 0.2s;
                  text-decoration: none;
                "
                onmouseover="
                  this.style.background = '#c4673a';
                  this.style.borderColor = '#c4673a';
                  this.style.color = '#fff';
                "
                onmouseout="
                  this.style.background = 'rgba(255,255,255,0.07)';
                  this.style.borderColor = 'rgba(255,255,255,0.12)';
                  this.style.color = 'rgba(255,255,255,0.6)';
                "
                ><i class="fa-brands fa-youtube"></i
              ></a>
              <a
                href="https://wa.me/919724788561"
                style="
                  width: 34px;
                  height: 34px;
                  border-radius: 8px;
                  background: rgba(255, 255, 255, 0.07);
                  border: 1px solid rgba(255, 255, 255, 0.12);
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  color: rgba(255, 255, 255, 0.6);
                  font-size: 0.85rem;
                  transition: all 0.2s;
                  text-decoration: none;
                "
                onmouseover="
                  this.style.background = '#c4673a';
                  this.style.borderColor = '#c4673a';
                  this.style.color = '#fff';
                "
                onmouseout="
                  this.style.background = 'rgba(255,255,255,0.07)';
                  this.style.borderColor = 'rgba(255,255,255,0.12)';
                  this.style.color = 'rgba(255,255,255,0.6)';
                "
                ><i class="fa-brands fa-whatsapp"></i
              ></a>
            </div>
          </div>

          <!-- Col 2: Quick Links -->
          <div>
            <h5
              style="
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #c4673a;
                margin-bottom: 18px;
              "
            >
              Quick Links
            </h5>
            <ul
              style="
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 10px;
              "
            >
              <li>
                <a
                  href="index.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Home</a
                >
              </li>
              <li>
                <a
                  href="about.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  About Us</a
                >
              </li>
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Workshops</a
                >
              </li>
              <li>
                <a
                  href="gallery.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Gallery</a
                >
              </li>
              <li>
                <a
                  href="contact.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Contact</a
                >
              </li>
              <li>
                <a
                  href="contact.php#bookingForm"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span> Book
                  a Seat</a
                >
              </li>
            </ul>
          </div>

          <!-- Col 3: Our Workshops -->
          <div>
            <h5
              style="
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #c4673a;
                margin-bottom: 18px;
              "
            >
              Our Workshops
            </h5>
            <ul
              style="
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 10px;
              "
            >
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Beginner Wheel Throwing</a
                >
              </li>
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Hand-Building Class</a
                >
              </li>
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span> Kids
                  Pottery Camp</a
                >
              </li>
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Corporate Team Workshop</a
                >
              </li>
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Couples Experience</a
                >
              </li>
              <li>
                <a
                  href="services.php"
                  style="
                    font-size: 0.84rem;
                    color: rgba(255, 255, 255, 0.55);
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: color 0.2s;
                  "
                  onmouseover="this.style.color = '#c4673a'"
                  onmouseout="this.style.color = 'rgba(255,255,255,0.55)'"
                  ><span style="color: #c4673a; font-size: 0.7rem">›</span>
                  Custom Ceramic Orders</a
                >
              </li>
            </ul>
          </div>

          <!-- Col 4: Contact -->
          <div>
            <h5
              style="
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #c4673a;
                margin-bottom: 18px;
              "
            >
              Contact Us
            </h5>
            <ul
              style="
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 14px;
              "
            >
              <li style="display: flex; align-items: flex-start; gap: 12px">
                <div
                  style="
                    width: 32px;
                    height: 32px;
                    border-radius: 8px;
                    background: rgba(196, 103, 58, 0.15);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    margin-top: 1px;
                  "
                >
                  <i
                    class="fa-solid fa-phone"
                    style="color: #c4673a; font-size: 0.8rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="
                      font-size: 0.65rem;
                      font-weight: 700;
                      letter-spacing: 0.1em;
                      text-transform: uppercase;
                      color: rgba(255, 255, 255, 0.35);
                      margin-bottom: 2px;
                    "
                  >
                    Phone
                  </div>
                  <a
                    href="tel:+919724788561"
                    style="
                      font-size: 0.84rem;
                      color: rgba(255, 255, 255, 0.7);
                      text-decoration: none;
                    "
                    >+91 97247 88561</a
                  >
                </div>
              </li>
              <li style="display: flex; align-items: flex-start; gap: 12px">
                <div
                  style="
                    width: 32px;
                    height: 32px;
                    border-radius: 8px;
                    background: rgba(196, 103, 58, 0.15);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    margin-top: 1px;
                  "
                >
                  <i
                    class="fa-solid fa-envelope"
                    style="color: #c4673a; font-size: 0.8rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="
                      font-size: 0.65rem;
                      font-weight: 700;
                      letter-spacing: 0.1em;
                      text-transform: uppercase;
                      color: rgba(255, 255, 255, 0.35);
                      margin-bottom: 2px;
                    "
                  >
                    Email
                  </div>
                  <a
                    href="mailto:info@theclayo.com"
                    style="
                      font-size: 0.84rem;
                      color: rgba(255, 255, 255, 0.7);
                      text-decoration: none;
                    "
                    >info@theclayo.com</a
                  >
                </div>
              </li>
              <li style="display: flex; align-items: flex-start; gap: 12px">
                <div
                  style="
                    width: 32px;
                    height: 32px;
                    border-radius: 8px;
                    background: rgba(196, 103, 58, 0.15);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    margin-top: 1px;
                  "
                >
                  <i
                    class="fa-solid fa-location-dot"
                    style="color: #c4673a; font-size: 0.8rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="
                      font-size: 0.65rem;
                      font-weight: 700;
                      letter-spacing: 0.1em;
                      text-transform: uppercase;
                      color: rgba(255, 255, 255, 0.35);
                      margin-bottom: 2px;
                    "
                  >
                    Address
                  </div>
                  <span
                    style="font-size: 0.84rem; color: rgba(255, 255, 255, 0.7)"
                    >64, Akoli Rd, Usha Colony, Guruchhaya Colony, Sai Nagar,
                    Amravati, Maharashtra 444607</span
                  >
                  >
                </div>
              </li>
              <li style="display: flex; align-items: flex-start; gap: 12px">
                <div
                  style="
                    width: 32px;
                    height: 32px;
                    border-radius: 8px;
                    background: rgba(196, 103, 58, 0.15);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    margin-top: 1px;
                  "
                >
                  <i
                    class="fa-regular fa-clock"
                    style="color: #c4673a; font-size: 0.8rem"
                  ></i>
                </div>
                <div>
                  <div
                    style="
                      font-size: 0.65rem;
                      font-weight: 700;
                      letter-spacing: 0.1em;
                      text-transform: uppercase;
                      color: rgba(255, 255, 255, 0.35);
                      margin-bottom: 2px;
                    "
                  >
                    Hours
                  </div>
                  <span
                    style="font-size: 0.84rem; color: rgba(255, 255, 255, 0.7)"
                    >Mon–Sat: 10:00 AM – 7 PM</span
                  ><br />
                  <span style="font-size: 0.82rem; color: #c4673a"
                    >Sun: Studio Closed</span
                  >
                </div>
              </li>
            </ul>
          </div>
        </div>

        <!-- Bottom Bar -->
        <div
          style="
            padding-top: 18px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
          "
        >
          <p
            style="
              font-size: 0.78rem;
              color: rgba(255, 255, 255, 0.3);
              margin: 0;
            "
          >
            &copy; 2026 The Clayo Pottery Studio. All rights reserved.
          </p>
          <p
            style="
              font-size: 0.78rem;
              color: rgba(255, 255, 255, 0.3);
              margin: 0;
            "
          >
            Designed by
            <a
              href="#"
              style="color: #c4673a; text-decoration: none; font-weight: 600"
              >WebCultivate Software Solutions</a
            >
          </p>
        </div>
      </div>
    </footer>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/919724788561" target="_blank" class="whatsapp-btn"
      ><i class="fa-brands fa-whatsapp text-white text-2xl"></i
    ></a>

    <script>
      // Header height offset
      function updateHeaderOffset() {
        const header = document.querySelector(".sticky-header");
        if (header) {
          document.body.style.setProperty(
            "--header-height",
            header.offsetHeight + "px",
          );
        }
      }
      updateHeaderOffset();
      window.addEventListener("resize", updateHeaderOffset);

      // Navbar scroll shadow
      const navbar = document.getElementById("navbar");
      window.addEventListener("scroll", () => {
        navbar.classList.toggle("navbar-scrolled", window.scrollY > 20);
      });

      // Hamburger / Drawer
      const hamburger = document.getElementById("hamburger");
      const drawer = document.getElementById("mobileDrawer");
      const overlay = document.getElementById("drawerOverlay");
      const drawerClose = document.getElementById("drawerClose");
      function openDrawer() {
        drawer.classList.add("open");
        overlay.classList.add("open");
        document.body.style.overflow = "hidden";
        hamburger.classList.add("active");
      }
      function closeDrawer() {
        drawer.classList.remove("open");
        overlay.classList.remove("open");
        document.body.style.overflow = "";
        hamburger.classList.remove("active");
      }
      hamburger.addEventListener("click", () => {
        drawer.classList.contains("open") ? closeDrawer() : openDrawer();
      });
      drawerClose.addEventListener("click", closeDrawer);
      overlay.addEventListener("click", closeDrawer);
      drawer
        .querySelectorAll("a")
        .forEach((a) => a.addEventListener("click", closeDrawer));

      // Gallery Filter
      const filterBtns = document.querySelectorAll(".filter-btn");
      const galleryItems = document.querySelectorAll(".gallery-item");
      filterBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
          filterBtns.forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          const filter = btn.dataset.filter;
          galleryItems.forEach((item) => {
            if (filter === "all" || item.dataset.category === filter) {
              item.style.display = "";
              item.style.opacity = "0";
              setTimeout(() => {
                item.style.opacity = "1";
                item.style.transition = "opacity 0.4s";
              }, 10);
            } else {
              item.style.opacity = "0";
              setTimeout(() => {
                item.style.display = "none";
              }, 350);
            }
          });
        });
      });

      // Lightbox
      const lightbox = document.getElementById("lightbox");
      const lbImg = document.getElementById("lbImg");
      const lbTitle = document.getElementById("lbTitle");
      const lbCategory = document.getElementById("lbCategory");
      const lbClose = document.getElementById("lbClose");
      const lbPrev = document.getElementById("lbPrev");
      const lbNext = document.getElementById("lbNext");
      let allCards = [],
        currentIdx = 0;

      function buildCardList() {
        allCards = Array.from(
          document.querySelectorAll(
            '.gallery-item:not([style*="display: none"]) .g-card',
          ),
        );
      }
      function openLightbox(idx) {
        buildCardList();
        currentIdx = idx;
        const card = allCards[currentIdx];
        if (!card) return;
        lbImg.src = card.dataset.src;
        lbImg.alt = card.dataset.title;
        lbTitle.textContent = card.dataset.title;
        lbCategory.textContent = card.dataset.category;
        lightbox.classList.add("open");
        document.body.style.overflow = "hidden";
      }
      function closeLightbox() {
        lightbox.classList.remove("open");
        document.body.style.overflow = "";
        lbImg.src = "";
      }
      function showPrev() {
        buildCardList();
        currentIdx = (currentIdx - 1 + allCards.length) % allCards.length;
        const c = allCards[currentIdx];
        lbImg.src = c.dataset.src;
        lbTitle.textContent = c.dataset.title;
        lbCategory.textContent = c.dataset.category;
      }
      function showNext() {
        buildCardList();
        currentIdx = (currentIdx + 1) % allCards.length;
        const c = allCards[currentIdx];
        lbImg.src = c.dataset.src;
        lbTitle.textContent = c.dataset.title;
        lbCategory.textContent = c.dataset.category;
      }

      document.querySelectorAll(".g-card").forEach((card, i) => {
        card.addEventListener("click", () => {
          buildCardList();
          const idx = allCards.indexOf(card);
          openLightbox(idx >= 0 ? idx : 0);
        });
      });
      lbClose.addEventListener("click", closeLightbox);
      lbPrev.addEventListener("click", (e) => {
        e.stopPropagation();
        showPrev();
      });
      lbNext.addEventListener("click", (e) => {
        e.stopPropagation();
        showNext();
      });
      lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) closeLightbox();
      });
      document.addEventListener("keydown", (e) => {
        if (!lightbox.classList.contains("open")) return;
        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowLeft") showPrev();
        if (e.key === "ArrowRight") showNext();
      });

      // Scroll Reveal
      const revealObs = new IntersectionObserver(
        (entries) => {
          entries.forEach((e) => {
            if (e.isIntersecting) {
              e.target.classList.add("revealed");
              revealObs.unobserve(e.target);
            }
          });
        },
        { threshold: 0.07, rootMargin: "0px 0px -20px 0px" },
      );
      document
        .querySelectorAll(".reveal, .reveal-left, .reveal-right, .reveal-scale")
        .forEach((el) => revealObs.observe(el));
    </script>
  <?php include __DIR__ . '/popup.php'; ?>
  </body>
</html>
