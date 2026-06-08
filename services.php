<?php
// Pull active Services & Workshops added through the admin panel.
$studioItems = [];
try {
    $db   = require __DIR__ . '/admin/config/database.php';
    $dsn  = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset={$db['charset']}";
    $pdo  = new PDO($dsn, $db['username'], $db['password'], $db['options']);
    $stmt = $pdo->query(
        "SELECT * FROM services
         WHERE is_active = 1
         ORDER BY type DESC, sort_order ASC, created_at DESC"
    );
    $studioItems = $stmt->fetchAll();
} catch (Throwable $e) {
    // Fail open: empty list, page still renders.
    $studioItems = [];
}

function clayo_e(?string $v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function clayo_img(?string $rel): string {
    return $rel ? 'public/' . ltrim($rel, '/') : '';
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Workshops – The Clayo Pottery Studio | Pottery & Ceramic Classes Amravati
    </title>
    <meta
      name="description"
      content="Explore all pottery workshops at The Clayo Pottery Studio, Amravati. Wheel Throwing, Hand Building, Glazing, Sculpture, Kids Pottery and Corporate Sessions."
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
        background: rgba(255, 255, 255, 0.98) !important;
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
        transform: translateY(36px);
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
        transform: translateX(-40px);
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
        transform: translateX(40px);
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
          opacity 0.7s ease,
          transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .reveal-scale.revealed {
        opacity: 1;
        transform: scale(1);
      }

      .card-hover {
        transition:
          transform 0.3s ease,
          box-shadow 0.3s ease;
      }
      .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(80, 40, 20, 0.12);
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
      .btn-sm {
        display: inline-block;
        background: #5c3820;
        color: #faf6f0;
        padding: 10px 22px;
        border-radius: 100px;
        font-size: 0.82rem;
        font-weight: 500;
        transition: all 0.2s;
        white-space: nowrap;
      }
      .btn-sm:hover {
        background: #b8793a;
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

      /* Workshop card styles */
      .srv-detail {
        border-left: 4px solid transparent;
        transition: all 0.3s;
      }
      .srv-detail:hover {
        border-left-color: #b8793a;
      }
      .cat-divider {
        border-bottom: 2px solid #e8d0a8;
        padding-bottom: 14px;
        margin-bottom: 28px;
      }
      .cat-divider h2 {
        font-family: "Playfair Display", serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #5c3820;
      }
      .price-badge {
        background: #faf6f0;
        color: #5c3820;
        font-size: 0.8rem;
        padding: 4px 14px;
        border-radius: 100px;
        font-weight: 500;
        border: 1px solid #e8d0a8;
      }
      .time-badge {
        background: #f5ede0;
        color: #8a7060;
        font-size: 0.8rem;
        padding: 4px 14px;
        border-radius: 100px;
      }
      .srv-img-sm {
        width: 80px;
        height: 80px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
      }

      /* Why choose cards */
      .why-img-card {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
      }
      .why-img-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
      }
      .why-img-card:hover img {
        transform: scale(1.06);
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

      @media (max-width: 1024px) {
        section {
          padding: 60px 24px !important;
        }
      }
      @media (max-width: 768px) {
        .srv-detail {
          flex-direction: column !important;
          gap: 16px !important;
        }
        .srv-img-sm {
          width: 100% !important;
          height: 200px !important;
          border-radius: 12px !important;
        }
        .btn-sm {
          align-self: flex-start;
          width: 100%;
          text-align: center;
        }
        .topbar {
          font-size: 0.72rem;
          padding: 6px 0;
        }
        .grid {
          gap: 16px;
        }
      }
      @media (max-width: 640px) {
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
        h1 {
          font-size: 2.2rem !important;
          line-height: 1.2 !important;
        }
        h2 {
          font-size: 1.6rem !important;
        }
        .srv-detail {
          padding: 20px !important;
        }
        .srv-img-sm {
          height: 180px !important;
        }
        .btn-primary,
        .btn-outline,
        .btn-sm {
          font-size: 0.88rem;
          padding: 12px 24px;
        }
        .topbar-right {
          display: none !important;
        }
        .topbar {
          text-align: center;
        }
      }
      @media (max-width: 480px) {
        .topbar {
          display: none;
        }
        h1 {
          font-size: 1.8rem !important;
        }
        .srv-img-sm {
          height: 160px !important;
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
                class="nav-link active text-sm font-medium text-brown transition-colors"
                >Workshops</a
              >
            </li>
            <li>
              <a
                href="events.php"
                class="nav-link text-sm font-medium text-muted transition-colors"
                >Events</a
              >
            </li>
            <li>
              <a
                href="gallery.php"
                class="nav-link text-sm font-medium text-muted transition-colors"
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
        <a href="services.php" class="active"
          ><i class="fa-solid fa-fire-flame-curved"></i> Workshops</a
        >
        <a href="events.php"><i class="fa-regular fa-calendar"></i> Events</a>
        <a href="gallery.php"><i class="fa-solid fa-images"></i> Gallery</a>
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
        min-height: 420px;
        display: flex;
        align-items: center;
        background:
          linear-gradient(
            135deg,
            rgba(28, 18, 12, 0.62) 0%,
            rgba(52, 32, 20, 0.54) 45%,
            rgba(184, 121, 58, 0.22) 100%
          ),
          url(&quot;https://lh3.googleusercontent.com/gps-cs-s/APNQkAGJktboAfwbGLOBWSxrFXPQeEJ1Pc3anKv2dkYDbs16CQ3yclvhMxWDmsfvIWsNeG2nSgU1O5hXb9ZowrhY0uR_SfzAsSm1Z32kHUp4i76GNkxuKrQTfORQc-LIXIKEYKXVAUEA34EjVrwk=s1360-w1360-h1020-rw&quot;);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
      "
    >
      <!-- Luxury Blur Overlay -->
      <div
        style="
          position: absolute;
          inset: 0;
          z-index: 0;
          backdrop-filter: blur(2px);
          background: radial-gradient(
            circle at top right,
            rgba(255, 255, 255, 0.06),
            transparent 40%
          );
        "
      ></div>

      <!-- Decorative Glow -->
      <div
        style="
          position: absolute;
          width: 420px;
          height: 420px;
          border-radius: 999px;
          background: rgba(232, 192, 128, 0.08);
          filter: blur(90px);
          top: -120px;
          right: -100px;
          z-index: 0;
        "
      ></div>

      <div
        style="
          position: absolute;
          width: 320px;
          height: 320px;
          border-radius: 999px;
          background: rgba(255, 255, 255, 0.04);
          filter: blur(80px);
          bottom: -120px;
          left: -80px;
          z-index: 0;
        "
      ></div>

      <!-- Content -->
      <div
        class="max-w-3xl mx-auto px-6 text-center relative z-10 reveal"
        style="padding-top: 110px; padding-bottom: 80px; width: 100%"
      >
        <!-- Tag -->
        <span
          style="
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.74rem;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #f3ddbb;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(12px);
            padding: 8px 18px;
            border-radius: 999px;
            margin-bottom: 18px;
          "
        >
          <i class="fa-solid fa-circle-dot"></i>
          What We Offer
        </span>

        <!-- Heading -->
        <h1
          class="font-heading font-bold leading-tight mt-3 mb-5"
          style="
            color: #fff;
            font-size: clamp(2.6rem, 7vw, 5.5rem);
            line-height: 1.05;
            letter-spacing: -0.03em;
          "
        >
          Our
          <span
            style="
              color: #e8c080;
              text-shadow: 0 0 18px rgba(232, 192, 128, 0.16);
            "
            class="font-heading"
          >
            Workshops
          </span>
        </h1>

        <!-- Description -->
        <p
          style="
            color: rgba(255, 255, 255, 0.88);
            font-size: 1.03rem;
            line-height: 1.85;
            max-width: 620px;
            margin: 0 auto 2.2rem;
          "
        >
          Discover immersive pottery workshops in Amravati from beginner wheel
          throwing to advanced ceramic artistry, handcrafted with creativity,
          mindfulness, and expert guidance.
        </p>

        <!-- Buttons -->
        <div class="flex flex-wrap gap-4 justify-center">
          <!-- Primary -->
          <a
            href="contact.php"
            class="btn-primary"
            style="box-shadow: 0 12px 40px rgba(0, 0, 0, 0.22)"
          >
            <i class="fa-solid fa-hands-clapping mr-2"></i>
            Enroll Now
          </a>

          <!-- Secondary -->
          <a
            href="#beginner-workshops"
            style="
              display: inline-flex;
              align-items: center;
              justify-content: center;
              border: 1.5px solid rgba(255, 255, 255, 0.28);
              background: rgba(255, 255, 255, 0.06);
              backdrop-filter: blur(10px);
              color: #fff;
              padding: 12px 30px;
              border-radius: 100px;
              font-size: 0.92rem;
              font-weight: 500;
              transition: all 0.3s ease;
              text-decoration: none;
            "
            onmouseover="
              this.style.background = 'rgba(255,255,255,0.14)';
              this.style.transform = 'translateY(-2px)';
            "
            onmouseout="
              this.style.background = 'rgba(255,255,255,0.06)';
              this.style.transform = 'translateY(0px)';
            "
          >
            Browse Workshops
          </a>
        </div>
      </div>

      <!-- Mobile Optimization -->
      <style>
        @media (max-width: 768px) {
          section {
            background-attachment: scroll !important;
          }
        }
      </style>
    </section>

    <!-- WORKSHOPS LIST -->
<section
  class="py-24 relative overflow-hidden"
  style="
    background:
      linear-gradient(
        180deg,
        #fffdf9 0%,
        #f8f1e8 100%
      );
  "
>
  <!-- Premium Background Glow -->
  <div
    style="
      position:absolute;
      top:-200px;
      right:-120px;
      width:500px;
      height:500px;
      border-radius:999px;
      background:rgba(232,192,128,0.10);
      filter:blur(120px);
      pointer-events:none;
    "
  ></div>

  <div
    style="
      position:absolute;
      bottom:-200px;
      left:-120px;
      width:450px;
      height:450px;
      border-radius:999px;
      background:rgba(184,147,90,0.08);
      filter:blur(120px);
      pointer-events:none;
    "
  ></div>

  <div class="max-w-5xl mx-auto px-6 relative z-10">

    <!-- ===================================== -->
    <!-- DYNAMIC: From the Studio (admin-managed) -->
    <!-- ===================================== -->
    <?php if (!empty($studioItems)): ?>
    <div class="mb-24" id="from-the-studio">
      <div class="cat-divider reveal relative" style="margin-bottom: 42px">
        <h2 class="font-heading"
            style="font-size:clamp(2rem,3vw,3rem); color:#5c3820; letter-spacing:-0.03em; position:relative; display:inline-block;">
          From the Studio
          <span style="position:absolute; left:0; bottom:-10px; width:72%; height:3px; border-radius:999px;
                       background:linear-gradient(90deg,#c8a060,transparent);"></span>
        </h2>
        <p class="text-sm mt-6" style="color:#8a7060; max-width:640px; line-height:1.85;">
          Our latest workshops and services — curated and updated by our studio team.
        </p>
      </div>

      <div class="flex flex-col gap-7">
        <?php foreach ($studioItems as $it):
          $img       = clayo_img($it['image_path']);
          $title     = clayo_e($it['title']);
          $desc      = clayo_e($it['description']);
          $price     = clayo_e($it['price']);
          $duration  = clayo_e($it['duration']);
          $isWorkshop = $it['type'] === 'workshop';
          $badgeCls  = $isWorkshop
              ? 'bg-amber-50 text-amber-700 border-amber-100'
              : 'bg-green-50 text-green-700 border-green-100';
          $badgeLbl  = $isWorkshop ? 'Workshop' : 'Service';
        ?>
        <div class="reveal srv-detail flex flex-col md:flex-row items-start gap-6 relative overflow-hidden"
             style="background:rgba(255,255,255,0.74); backdrop-filter:blur(18px);
                    border:1px solid rgba(184,147,90,0.14); border-radius:30px; padding:28px;
                    box-shadow:0 10px 40px rgba(0,0,0,0.04), 0 2px 10px rgba(184,147,90,0.06);
                    transition:transform .45s ease, box-shadow .45s ease, border-color .45s ease;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 30px 70px rgba(0,0,0,0.08)'; this.style.borderColor='rgba(184,147,90,0.28)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.04)'; this.style.borderColor='rgba(184,147,90,0.14)';">

          <div style="position:absolute; top:-80px; right:-80px; width:220px; height:220px;
                      border-radius:999px; background:rgba(232,192,128,0.10); filter:blur(70px); pointer-events:none;"></div>

          <?php if ($img): ?>
            <img src="<?= $img ?>" alt="<?= $title ?>" loading="lazy"
                 style="width:185px; height:185px; object-fit:cover; border-radius:24px; flex-shrink:0;
                        box-shadow:0 18px 40px rgba(0,0,0,0.12); transition:transform .5s ease, filter .5s ease;"
                 onmouseover="this.style.transform='scale(1.05)'; this.style.filter='brightness(1.03)';"
                 onmouseout="this.style.transform='scale(1)'; this.style.filter='brightness(1)';" />
          <?php else: ?>
            <div style="width:185px; height:185px; border-radius:24px; flex-shrink:0;
                        background:linear-gradient(135deg,#f5ede0,#e8d5b0); display:grid; place-items:center;
                        color:#b07a42; font-size:2rem;">
              <i class="fa-solid fa-hands"></i>
            </div>
          <?php endif; ?>

          <div class="flex-1 min-w-0 relative z-10">
            <h3 class="font-heading text-xl font-semibold mb-3" style="color:#5c3820"><?= $title ?></h3>

            <?php if ($desc !== ''): ?>
              <p class="text-sm leading-relaxed mb-4" style="color:#8a7060; line-height:1.9;"><?= nl2br($desc) ?></p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-2 mb-5">
              <?php if ($duration !== ''): ?>
                <span class="time-badge">
                  <i class="fa-regular fa-clock mr-1"></i><?= $duration ?>
                </span>
              <?php endif; ?>
              <?php if ($price !== ''): ?>
                <span class="price-badge">
                  <i class="fa-solid fa-indian-rupee-sign mr-1"></i><?= $price ?>
                </span>
              <?php endif; ?>
              <span class="text-xs <?= $badgeCls ?> px-3 py-1 rounded-full border">
                <?= $badgeLbl ?>
              </span>
            </div>

            <a href="contact.php?service=<?= urlencode($it['title']) ?>#bookingForm"
               style="display:inline-flex; align-items:center; justify-content:center; gap:8px;
                      background:linear-gradient(135deg,#c8a060,#b07a42); color:white;
                      padding:13px 24px; border-radius:999px; font-size:.88rem; font-weight:600;
                      text-decoration:none; box-shadow:0 10px 25px rgba(176,122,66,0.22); transition:all .35s ease;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 18px 40px rgba(176,122,66,0.28)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(176,122,66,0.22)';">
              Enroll <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- ===================================== -->
    <!-- CATEGORY 1 -->
    <!-- ===================================== -->

    <div class="mb-24" id="beginner-workshops">

      <!-- Heading -->
      <div
        class="cat-divider reveal relative"
        style="margin-bottom: 42px"
      >
        <h2
          class="font-heading"
          style="
            font-size: clamp(2rem, 3vw, 3rem);
            color: #5c3820;
            letter-spacing: -0.03em;
            position: relative;
            display: inline-block;
          "
        >
          Beginner Workshops

          <span
            style="
              position:absolute;
              left:0;
              bottom:-10px;
              width:72%;
              height:3px;
              border-radius:999px;
              background:
                linear-gradient(
                  90deg,
                  #c8a060,
                  transparent
                );
            "
          ></span>
        </h2>
      </div>

      <!-- Cards -->
      <div class="flex flex-col gap-7">

        <!-- CARD 1 -->
        <div
          class="reveal srv-detail flex items-start gap-6 relative overflow-hidden"
          style="
            background: rgba(255,255,255,0.74);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(184,147,90,0.14);
            border-radius: 30px;
            padding: 28px;
            box-shadow:
              0 10px 40px rgba(0,0,0,0.04),
              0 2px 10px rgba(184,147,90,0.06);
            transition:
              transform 0.45s ease,
              box-shadow 0.45s ease,
              border-color 0.45s ease;
          "
          onmouseover="
            this.style.transform='translateY(-8px)';
            this.style.boxShadow='0 30px 70px rgba(0,0,0,0.08)';
            this.style.borderColor='rgba(184,147,90,0.28)';
          "
          onmouseout="
            this.style.transform='translateY(0px)';
            this.style.boxShadow='0 10px 40px rgba(0,0,0,0.04)';
            this.style.borderColor='rgba(184,147,90,0.14)';
          "
        >
          <!-- Glow -->
          <div
            style="
              position:absolute;
              top:-80px;
              right:-80px;
              width:220px;
              height:220px;
              border-radius:999px;
              background:rgba(232,192,128,0.10);
              filter:blur(70px);
              pointer-events:none;
            "
          ></div>

          <!-- Image -->
          <img
            src="https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=200&q=90"
            alt="Wheel Throwing"
            loading="lazy"
            style="
              width:185px;
              height:185px;
              object-fit:cover;
              border-radius:24px;
              flex-shrink:0;
              box-shadow:
                0 18px 40px rgba(0,0,0,0.12);
              transition:
                transform 0.5s ease,
                filter 0.5s ease;
            "
            onmouseover="
              this.style.transform='scale(1.05)';
              this.style.filter='brightness(1.03)';
            "
            onmouseout="
              this.style.transform='scale(1)';
              this.style.filter='brightness(1)';
            "
          />

          <!-- Content -->
          <div class="flex-1 min-w-0 relative z-10">

            <h3
              class="font-heading text-xl font-semibold mb-3"
              style="color:#5c3820"
            >
              Intro to Wheel Throwing
            </h3>

            <p
              class="text-sm leading-relaxed mb-4"
              style="
                color:#8a7060;
                line-height:1.9;
              "
            >
              The perfect first step into pottery. Learn to center clay on
              the wheel, pull walls, and shape your very first bowl or mug.
              Our instructors guide you every step of the way — no
              experience needed, just curiosity and willingness to get your
              hands dirty.
            </p>

            <!-- Badges -->
            <div class="flex flex-wrap gap-2 mb-5">

              <span class="time-badge">
                <i class="fa-regular fa-clock mr-1"></i>
                2 hrs / session
              </span>

              <span class="price-badge">
                <i class="fa-solid fa-indian-rupee-sign mr-1"></i>
                Starting ₹800/session
              </span>

              <span
                class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full border border-green-100"
              >
                No Experience Needed
              </span>
            </div>

            <!-- Button -->
            <a
              href="contact.php"
              style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                background:
                  linear-gradient(
                    135deg,
                    #c8a060,
                    #b07a42
                  );
                color:white;
                padding:13px 24px;
                border-radius:999px;
                font-size:0.88rem;
                font-weight:600;
                text-decoration:none;
                box-shadow:
                  0 10px 25px rgba(176,122,66,0.22);
                transition:all 0.35s ease;
              "
              onmouseover="
                this.style.transform='translateY(-3px)';
                this.style.boxShadow='0 18px 40px rgba(176,122,66,0.28)';
              "
              onmouseout="
                this.style.transform='translateY(0px)';
                this.style.boxShadow='0 10px 25px rgba(176,122,66,0.22)';
              "
            >
              Enroll
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>

        <!-- CARD 2 -->
        <div
          class="reveal srv-detail flex items-start gap-6 relative overflow-hidden"
          style="
            background: rgba(255,255,255,0.74);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(184,147,90,0.14);
            border-radius: 30px;
            padding: 28px;
            box-shadow:
              0 10px 40px rgba(0,0,0,0.04),
              0 2px 10px rgba(184,147,90,0.06);
            transition:
              transform 0.45s ease,
              box-shadow 0.45s ease,
              border-color 0.45s ease;
          "
        >
          <div
            style="
              position:absolute;
              top:-80px;
              right:-80px;
              width:220px;
              height:220px;
              border-radius:999px;
              background:rgba(232,192,128,0.10);
              filter:blur(70px);
              pointer-events:none;
            "
          ></div>

          <img
            src="https://images.unsplash.com/photo-1528396518501-b53b655eb9b3?w=200&q=90"
            alt="Hand Building"
            loading="lazy"
            style="
              width:185px;
              height:185px;
              object-fit:cover;
              border-radius:24px;
              flex-shrink:0;
              box-shadow:
                0 18px 40px rgba(0,0,0,0.12);
            "
          />

          <div class="flex-1 min-w-0 relative z-10">

            <h3
              class="font-heading text-xl font-semibold mb-3"
              style="color:#5c3820"
            >
              Hand Building Basics
            </h3>

            <p
              class="text-sm leading-relaxed mb-4"
              style="
                color:#8a7060;
                line-height:1.9;
              "
            >
              Build beautiful ceramic pieces without a wheel using coil,
              slab, and pinch techniques. Create plates, trays, planters,
              and decorative items entirely by hand.
            </p>

            <div class="flex flex-wrap gap-2 mb-5">

              <span class="time-badge">
                <i class="fa-regular fa-clock mr-1"></i>
                2 hrs / session
              </span>

              <span class="price-badge">
                <i class="fa-solid fa-indian-rupee-sign mr-1"></i>
                Starting ₹700/session
              </span>

              <span
                class="text-xs bg-amber-50 text-amber-700 px-3 py-1 rounded-full border border-amber-100"
              >
                All Ages Welcome
              </span>
            </div>

            <a
              href="contact.php"
              style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                background:
                  linear-gradient(
                    135deg,
                    #c8a060,
                    #b07a42
                  );
                color:white;
                padding:13px 24px;
                border-radius:999px;
                font-size:0.88rem;
                font-weight:600;
                text-decoration:none;
              "
            >
              Enroll
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- ===================================== -->
    <!-- CATEGORY 2 -->
    <!-- ===================================== -->

    <div class="mb-24" id="advanced-workshops">

      <div
        class="cat-divider reveal relative"
        style="margin-bottom: 42px"
      >
        <h2
          class="font-heading"
          style="
            font-size: clamp(2rem, 3vw, 3rem);
            color: #5c3820;
            letter-spacing: -0.03em;
            position: relative;
            display: inline-block;
          "
        >
          Intermediate & Advanced

          <span
            style="
              position:absolute;
              left:0;
              bottom:-10px;
              width:72%;
              height:3px;
              border-radius:999px;
              background:
                linear-gradient(
                  90deg,
                  #c8a060,
                  transparent
                );
            "
          ></span>
        </h2>
      </div>

      <div class="flex flex-col gap-7">

        <!-- Advanced Card -->
        <div
          class="reveal srv-detail flex items-start gap-6 relative overflow-hidden"
          style="
            background: rgba(255,255,255,0.74);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(184,147,90,0.14);
            border-radius: 30px;
            padding: 28px;
            box-shadow:
              0 10px 40px rgba(0,0,0,0.04);
          "
        >
          <div
            style="
              position:absolute;
              top:-80px;
              right:-80px;
              width:220px;
              height:220px;
              border-radius:999px;
              background:rgba(232,192,128,0.10);
              filter:blur(70px);
            "
          ></div>

          <img
            src="https://images.unsplash.com/photo-1493932484895-752d1471eab5?w=200&q=90"
            alt="Glazing"
            loading="lazy"
            style="
              width:185px;
              height:185px;
              object-fit:cover;
              border-radius:24px;
              flex-shrink:0;
              box-shadow:
                0 18px 40px rgba(0,0,0,0.12);
            "
          />

          <div class="flex-1 min-w-0 relative z-10">

            <h3
              class="font-heading text-xl font-semibold mb-3"
              style="color:#5c3820"
            >
              Glazing & Kiln Firing Masterclass
            </h3>

            <p
              class="text-sm leading-relaxed mb-4"
              style="
                color:#8a7060;
                line-height:1.9;
              "
            >
              Dive deep into the science and art of ceramic glazes. Learn to
              mix, layer, and apply glazes using brush, dip, and pour
              methods.
            </p>

            <div class="flex flex-wrap gap-2 mb-5">

              <span class="time-badge">
                <i class="fa-regular fa-clock mr-1"></i>
                3 hrs / session
              </span>

              <span class="price-badge">
                <i class="fa-solid fa-indian-rupee-sign mr-1"></i>
                Starting ₹1,200/session
              </span>

              <span
                class="text-xs bg-purple-50 text-purple-700 px-3 py-1 rounded-full border border-purple-100"
              >
                Kiln Access Included
              </span>
            </div>

            <a
              href="contact.php"
              style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                background:
                  linear-gradient(
                    135deg,
                    #c8a060,
                    #b07a42
                  );
                color:white;
                padding:13px 24px;
                border-radius:999px;
                font-size:0.88rem;
                font-weight:600;
                text-decoration:none;
              "
            >
              Enroll
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- ===================================== -->
    <!-- CATEGORY 3 -->
    <!-- ===================================== -->

    <div class="mb-24" id="special-programs">

      <div
        class="cat-divider reveal relative"
        style="margin-bottom: 42px"
      >
        <h2
          class="font-heading"
          style="
            font-size: clamp(2rem, 3vw, 3rem);
            color: #5c3820;
            letter-spacing: -0.03em;
            position: relative;
            display: inline-block;
          "
        >
          Special Programs

          <span
            style="
              position:absolute;
              left:0;
              bottom:-10px;
              width:72%;
              height:3px;
              border-radius:999px;
              background:
                linear-gradient(
                  90deg,
                  #c8a060,
                  transparent
                );
            "
          ></span>
        </h2>
      </div>

      <div class="flex flex-col gap-7">

        <!-- Kids -->
        <div
          class="reveal srv-detail flex items-start gap-6 relative overflow-hidden"
          style="
            background: rgba(255,255,255,0.74);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(184,147,90,0.14);
            border-radius: 30px;
            padding: 28px;
            box-shadow:
              0 10px 40px rgba(0,0,0,0.04);
          "
        >
          <div
            style="
              position:absolute;
              top:-80px;
              right:-80px;
              width:220px;
              height:220px;
              border-radius:999px;
              background:rgba(232,192,128,0.10);
              filter:blur(70px);
            "
          ></div>

          <img
            src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=200&q=90"
            alt="Kids Pottery"
            loading="lazy"
            style="
              width:185px;
              height:185px;
              object-fit:cover;
              border-radius:24px;
              flex-shrink:0;
              box-shadow:
                0 18px 40px rgba(0,0,0,0.12);
            "
          />

          <div class="flex-1 min-w-0 relative z-10">

            <h3
              class="font-heading text-xl font-semibold mb-3"
              style="color:#5c3820"
            >
              Kids Pottery (Ages 6–14)
            </h3>

            <p
              class="text-sm leading-relaxed mb-4"
              style="
                color:#8a7060;
                line-height:1.9;
              "
            >
              A fun, safe, and supervised pottery class designed specially
              for children. Kids get to play, create, and bring home their
              own fired ceramic piece.
            </p>

            <div class="flex flex-wrap gap-2 mb-5">

              <span class="time-badge">
                <i class="fa-regular fa-clock mr-1"></i>
                1.5 hrs / session
              </span>

              <span class="price-badge">
                <i class="fa-solid fa-indian-rupee-sign mr-1"></i>
                ₹500 per child
              </span>

              <span
                class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full border border-green-100"
              >
                Ages 6–14
              </span>
            </div>

            <a
              href="contact.php"
              style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                background:
                  linear-gradient(
                    135deg,
                    #c8a060,
                    #b07a42
                  );
                color:white;
                padding:13px 24px;
                border-radius:999px;
                font-size:0.88rem;
                font-weight:600;
                text-decoration:none;
              "
            >
              Enroll
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- ===================================== -->
    <!-- CATEGORY 4 -->
    <!-- ===================================== -->

    <div class="mb-12" id="monthly-courses">

      <div
        class="cat-divider reveal relative"
        style="margin-bottom: 42px"
      >
        <h2
          class="font-heading"
          style="
            font-size: clamp(2rem, 3vw, 3rem);
            color: #5c3820;
            letter-spacing: -0.03em;
            position: relative;
            display: inline-block;
          "
        >
          Monthly Membership Courses

          <span
            style="
              position:absolute;
              left:0;
              bottom:-10px;
              width:72%;
              height:3px;
              border-radius:999px;
              background:
                linear-gradient(
                  90deg,
                  #c8a060,
                  transparent
                );
            "
          ></span>
        </h2>
      </div>

      <div class="flex flex-col gap-7">

        <!-- Membership -->
        <div
          class="reveal srv-detail flex items-start gap-6 relative overflow-hidden"
          style="
            background: rgba(255,255,255,0.74);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(184,147,90,0.14);
            border-radius: 30px;
            padding: 28px;
            box-shadow:
              0 10px 40px rgba(0,0,0,0.04);
          "
        >
          <div
            style="
              position:absolute;
              top:-80px;
              right:-80px;
              width:220px;
              height:220px;
              border-radius:999px;
              background:rgba(232,192,128,0.10);
              filter:blur(70px);
            "
          ></div>

          <img
            src="https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=200&q=90"
            alt="Membership"
            loading="lazy"
            style="
              width:185px;
              height:185px;
              object-fit:cover;
              border-radius:24px;
              flex-shrink:0;
              box-shadow:
                0 18px 40px rgba(0,0,0,0.12);
            "
          />

          <div class="flex-1 min-w-0 relative z-10">

            <h3
              class="font-heading text-xl font-semibold mb-3"
              style="color:#5c3820"
            >
              Studio Membership (8 Sessions/Month)
            </h3>

            <p
              class="text-sm leading-relaxed mb-4"
              style="
                color:#8a7060;
                line-height:1.9;
              "
            >
              Our most popular plan. Get 8 open-studio sessions per month
              with full access to wheels, tools, clay, and kiln firings.
            </p>

            <div class="flex flex-wrap gap-2 mb-5">

              <span class="time-badge">
                <i class="fa-regular fa-clock mr-1"></i>
                8 sessions / month
              </span>

              <span class="price-badge">
                <i class="fa-solid fa-indian-rupee-sign mr-1"></i>
                ₹3,500 / month
              </span>

              <span
                class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full border border-green-100"
              >
                Best Value
              </span>
            </div>

            <a
              href="contact.php"
              style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                background:
                  linear-gradient(
                    135deg,
                    #c8a060,
                    #b07a42
                  );
                color:white;
                padding:13px 24px;
                border-radius:999px;
                font-size:0.88rem;
                font-weight:600;
                text-decoration:none;
              "
            >
              Join
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Mobile Responsive -->
  <style>
    @media (max-width: 768px) {
      .srv-detail {
        flex-direction: column !important;
      }

      .srv-detail img {
        width: 100% !important;
        height: 240px !important;
      }
    }
  </style>
</section>

    <!-- WHY THE CLAYO -->
    <section class="py-20 overflow-hidden" style="background: #faf6f0">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14 reveal">
          <span class="section-tag">Why Choose Us</span>
          <h2
            class="font-heading text-4xl font-bold mt-3 mb-4"
            style="color: #2c1f14"
          >
            The Clayo
            <span class="font-heading" style="color: #b8793a">Difference</span>
          </h2>
          <p style="color: #8a7060" class="max-w-lg mx-auto">
            What sets our studio apart every single session, every piece of
            clay.
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div
            class="reveal why-img-card card-hover border border-amber-100 bg-white rounded-2xl overflow-hidden"
            style="transition-delay: 0.05s"
          >
            <div style="overflow: hidden; height: 200px">
              <img
                src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGSyVRnUK4tdKg906MBv6p51UYyMESD4zPSs4vu3imB3NnHP7eLoiclLrudONMwDnYevUPC8lanpKVJQ4Av6QATzV4Y0JK_giJzdT-MmsvdKMcKidBBlwAFW5GjDzsaf9tzwRNuKlrlXoeI=s1360-w1360-h1020-rw"
                alt="Expert Instructors"
                style="
                  width: 100%;
                  height: 100%;
                  object-fit: cover;
                  transition: transform 0.5s ease;
                "
              />
            </div>
            <div class="p-7">
              <h4
                class="font-heading text-xl font-semibold mb-3"
                style="color: #5c3820"
              >
                Expert Instructors
              </h4>
              <p class="text-sm leading-relaxed" style="color: #8a7060">
                Our instructors are practising ceramic artists with over 10
                years of experience. Each session is guided, encouraging, and
                crafted to help you truly learn — not just follow instructions.
              </p>
            </div>
          </div>

          <div
            class="reveal why-img-card card-hover border border-amber-100 bg-white rounded-2xl overflow-hidden"
            style="transition-delay: 0.12s"
          >
            <div style="overflow: hidden; height: 200px">
              <img
                src="https://lh3.googleusercontent.com/p/AF1QipPMKTbob9-fvJ4X8FvkRdFVR4nWsmtCS0S4WonR=s1360-w1360-h1020-rw"
                alt="Professional Studio"
                style="
                  width: 100%;
                  height: 100%;
                  object-fit: cover;
                  transition: transform 0.5s ease;
                "
              />
            </div>
            <div class="p-7">
              <h4
                class="font-heading text-xl font-semibold mb-3"
                style="color: #5c3820"
              >
                Professional Studio &amp; Kiln
              </h4>
              <p class="text-sm leading-relaxed" style="color: #8a7060">
                Our studio is equipped with Japanese pottery wheels, a
                professional electric kiln, full clay body options, and premium
                glazes. Everything you need to create real, lasting ceramic work
                — right here in Amravati.
              </p>
            </div>
          </div>

          <div
            class="reveal why-img-card card-hover border border-amber-100 bg-white rounded-2xl overflow-hidden"
            style="transition-delay: 0.2s"
          >
            <div style="overflow: hidden; height: 200px">
              <img
                src="https://lh3.googleusercontent.com/p/AF1QipN9FxAr0aFLkIQL9-VhMeCjgsoB5CLy32EDXTN4=s1360-w1360-h1020-rw"
                alt="Take Home Your Work"
                style="
                  width: 100%;
                  height: 100%;
                  object-fit: cover;
                  transition: transform 0.5s ease;
                "
              />
            </div>
            <div class="p-7">

              <h4
                class="font-heading text-xl font-semibold mb-3"
                style="color: #5c3820"
              >
                You Take Your Art Home
              </h4>
              <p class="text-sm leading-relaxed" style="color: #8a7060">
                Every piece you create is fully fired and glazed by our team. We
                handle the kiln runs, and your finished ceramic is ready to
                collect — a real, usable piece of art made entirely by you, to
                keep forever.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-section py-24">
      <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
        <span class="section-tag">Not Sure Where to Start?</span>
        <h2
          class="font-heading text-4xl lg:text-5xl font-bold mt-4 mb-5 leading-tight"
          style="color: #2c1f14"
        >
          We'll Help You
          <span class="font-heading" style="color: #b8793a"
            >Find the Right Workshop!</span
          >
        </h2>
        <p
          class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed"
          style="color: #8a7060"
        >
          Not sure which class is right for you? Book a free 15-minute chat with
          our instructors. We'll understand your goals, availability, and skill
          level — and recommend the perfect starting point.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="contact.php" class="btn-primary text-base px-8 py-4"
            ><i class="fa-solid fa-hands-clapping mr-2"></i>Enroll in a
            Workshop</a
          >
          <a href="tel:+917276000000" class="btn-outline text-base px-8 py-4"
            ><i class="fa-solid fa-phone mr-2"></i>Call Us Now</a
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

    <a href="https://wa.me/919724788561" target="_blank" class="whatsapp-btn"
      ><i class="fa-brands fa-whatsapp text-white text-2xl"></i
    ></a>

    <script>
      function updateHeaderOffset() {
        const header = document.querySelector(".sticky-header");
        if (header)
          document.body.style.setProperty(
            "--header-height",
            header.offsetHeight + "px",
          );
      }
      updateHeaderOffset();
      window.addEventListener("resize", updateHeaderOffset);

      const navbar = document.getElementById("navbar");
      window.addEventListener("scroll", () => {
        navbar.classList.toggle("navbar-scrolled", window.scrollY > 20);
      });

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

      const revealObs = new IntersectionObserver(
        (entries) => {
          entries.forEach((e) => {
            if (e.isIntersecting) {
              e.target.classList.add("revealed");
              revealObs.unobserve(e.target);
            }
          });
        },
        { threshold: 0.08, rootMargin: "0px 0px -30px 0px" },
      );
      document
        .querySelectorAll(".reveal, .reveal-left, .reveal-right, .reveal-scale")
        .forEach((el) => revealObs.observe(el));

      document.querySelectorAll(".why-img-card").forEach((card) => {
        const img = card.querySelector("img");
        card.addEventListener("mouseenter", () => {
          if (img) img.style.transform = "scale(1.06)";
        });
        card.addEventListener("mouseleave", () => {
          if (img) img.style.transform = "scale(1)";
        });
      });
    </script>
  <?php include __DIR__ . '/popup.php'; ?>
  </body>
</html>
