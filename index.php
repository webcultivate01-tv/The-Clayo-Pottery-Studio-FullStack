!<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      The Clayo Pottery Studio – Handcrafted Ceramics & Pottery Workshops |
      Amravati
    </title>
    <meta
      name="description"
      content="Clayo Pottery Studio in Amravati offers handcrafted ceramics, pottery workshops, clay sculpting classes, and custom ceramic pieces by expert potters."
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
              cream: "#faf7f2",
              blush: "#f5ede6",
              rose: "#d4a09a",
              gold: "#b8935a",
              "gold-light": "#e8d5b7",
              sage: "#8fa88a",
              charcoal: "#2c2420",
              brown: "#5c3d2e",
              muted: "#8a7a70",
              terracotta: "#c1654a",
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
        background-color: #faf7f2;
        color: #2c2420;
        overflow-x: hidden;
      }
      html {
        overflow-x: hidden;
      }
      h1,
      h2,
      h3,
      h4 {
        font-family: "Playfair Display", serif;
      }

      /* ---- NAVBAR ---- */
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
        background: #b8935a;
        transition: width 0.3s;
        border-radius: 2px;
      }
      .nav-link:hover::after,
      .nav-link.active::after {
        width: 100%;
      }
      .nav-link:hover {
        color: #5c3d2e !important;
        background: transparent !important;
      }
      .desktop-nav {
        display: flex;
        align-items: center;
        gap: 0;
      }

      /* ---- HERO ---- */
      .hero-section {
        min-height: auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 60px;
        max-width: 1180px;
        margin: 0 auto;
        padding: 0;
        position: relative;
      }
      @media (max-width: 1024px) {
        .hero-section {
          grid-template-columns: 1fr;
          text-align: center;
          padding: 0;
          min-height: auto;
        }
      }
      @media (max-width: 768px) {
        .hero-section {
          gap: 28px;
          padding: 0;
        }
      }

      /* ---- MARQUEE ---- */
      .marquee-wrap {
        background: #5c3d2e;
        overflow: hidden;
        padding: 14px 0;
      }
      .marquee-track {
        display: flex;
        gap: 40px;
        width: max-content;
        animation: marqueeScroll 30s linear infinite;
      }
      @keyframes marqueeScroll {
        from {
          transform: translateX(0);
        }
        to {
          transform: translateX(-50%);
        }
      }

      /* ---- CARDS ---- */
      .card-hover {
        transition:
          transform 0.3s ease,
          box-shadow 0.3s ease;
      }
      .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 60px rgba(80, 40, 20, 0.14);
      }

      /* ---- SCROLL ANIMATIONS ---- */
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
        transform: scale(0.92);
        transition:
          opacity 0.7s ease,
          transform 0.7s ease;
      }
      .reveal-scale.revealed {
        opacity: 1;
        transform: scale(1);
      }
      .fade-in {
        opacity: 0;
        transform: translateY(28px);
        transition:
          opacity 0.6s ease,
          transform 0.6s ease;
      }
      .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
      }

      /* ---- BADGE FLOAT ---- */
      .badge-float {
        animation: badgeFloat 4s ease-in-out infinite;
      }
      @keyframes badgeFloat {
        0%,
        100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-8px);
        }
      }

      /* ---- STATS ---- */
      .stat-num {
        font-family: "Playfair Display", serif;
      }

      /* ---- SERVICE CARDS ---- */
      .srv-img-wrap {
        overflow: hidden;
        border-radius: 16px 16px 0 0;
        height: 200px;
      }
      .srv-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
      }
      .srv-card:hover .srv-img-wrap img {
        transform: scale(1.07);
      }

      /* ---- HAMBURGER ---- */
      .hamburger-bar {
        display: block;
        width: 24px;
        height: 2px;
        background: #5c3d2e;
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

      .testimonial-stars {
        color: #b8935a;
      }

      /* HERO SLIDER BUTTONS */
      .hero-slider-btn {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
      }
      .hero-slider-btn:hover {
        background: rgba(255, 255, 255, 0.95) !important;
        border-color: #b8935a !important;
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 6px 20px rgba(184, 147, 90, 0.25) !important;
      }
      .hero-slider-btn:hover i {
        color: #b8935a !important;
      }
      .hero-slider-btn:active {
        transform: translateY(-50%) scale(0.98);
      }

      /* TESTIMONIAL SLIDER */
      @media (max-width: 768px) {
        .testimonial-slider {
          display: block !important;
          position: relative;
        }
        .testimonial-card {
          display: none;
          animation: fadeIn 0.5s ease-in-out;
        }
        .testimonial-card.active {
          display: block;
        }
      }
      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* MOBILE DRAWER */
      .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(44, 36, 32, 0.45);
        z-index: 99998 !important;
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
        height: 100vh !important;
        width: 280px;
        max-width: 85vw;
        background: #fff;
        z-index: 99999 !important;
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: -8px 0 40px rgba(44, 36, 32, 0.18);
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
        border-bottom: 1px solid #f0e6d8;
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 1001;
      }
      .drawer-close {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #faf7f2;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5c3d2e;
        font-size: 1rem;
        transition: background 0.2s;
      }
      .drawer-close:hover {
        background: #f5ede6;
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
        color: #8a7a70;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 4px;
      }
      .drawer-nav a:hover,
      .drawer-nav a.active {
        background: #f5ede6;
        color: #5c3d2e;
      }
      .drawer-nav a.active {
        font-weight: 600;
      }
      .drawer-nav a i {
        width: 18px;
        text-align: center;
        color: #b8935a;
      }
      .drawer-footer {
        padding: 16px;
        border-top: 1px solid #f0e6d8;
      }

      /* TOPBAR */
      .topbar {
        background: #5c3d2e;
        color: #e8d5b7;
        font-size: 0.78rem;
        padding: 8px 0;
      }
      .topbar a {
        color: #e8d5b7;
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

      .section-tag {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #b8935a;
        background: #e8d5b7;
        padding: 6px 18px;
        border-radius: 100px;
        margin-bottom: 14px;
        position: relative;
        top: -8px;
      }
      .btn-primary {
        display: inline-block;
        background: #5c3d2e;
        color: #faf7f2;
        padding: 14px 32px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        font-family: "Inter", sans-serif;
        letter-spacing: 0.03em;
        transition: all 0.25s;
      }
      .btn-primary:hover {
        background: #b8935a;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(92, 61, 46, 0.3);
      }
      .btn-outline {
        display: inline-block;
        border: 2px solid #5c3d2e;
        color: #5c3d2e;
        padding: 12px 30px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        font-family: "Inter", sans-serif;
        transition: all 0.25s;
      }
      .btn-outline:hover {
        background: #5c3d2e;
        color: #faf7f2;
        transform: translateY(-2px);
      }
      .whatsapp-btn {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 999;
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

      /* MOBILE HERO */
      .hero-img-mobile {
        display: none;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        border-radius: 16px;
        overflow: visible;
        box-shadow: 0 12px 40px rgba(80, 40, 20, 0.15);
        position: relative;
      }
      .hero-img-mobile img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        object-position: center;
        display: block;
      }

      /* TEAM CARDS */
      .team-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f0e6d8;
        transition:
          transform 0.3s ease,
          box-shadow 0.3s ease;
      }
      .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 60px rgba(80, 40, 20, 0.14);
      }
      .team-photo {
        width: 100%;
        height: 220px;
        object-fit: cover;
        object-position: top;
      }
      .team-specialty {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #b8935a;
        background: #fdf5ea;
        padding: 4px 12px;
        border-radius: 100px;
        border: 1px solid #e8d5b7;
        margin-bottom: 10px;
      }

      /* WHY CHOOSE US CARDS */
      .why-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f0e6d8;
        transition:
          transform 0.3s ease,
          box-shadow 0.3s ease;
      }
      .why-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 50px rgba(80, 40, 20, 0.12);
      }
      .why-card-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        transition: transform 0.5s ease;
      }
      .why-card:hover .why-card-img {
        transform: scale(1.06);
      }
      .why-card-body {
        padding: 22px 20px;
      }

      /* WHY IMAGE */
      .why-img-wrap {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(80, 40, 20, 0.18);
        height: 480px;
        transform: translateY(20px);
        opacity: 0;
        transition:
          transform 0.8s ease,
          opacity 0.8s ease;
      }
      .why-img-wrap.revealed {
        transform: translateY(0);
        opacity: 1;
      }
      .why-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
      }
      .why-img-wrap:hover img {
        transform: scale(1.05);
      }

      /* STEPS */
      .step-img-wrap {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 16px;
        border: 3px solid #e8d5b7;
        box-shadow: 0 8px 24px rgba(80, 40, 20, 0.12);
      }
      .step-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      /* CTA */
      .cta-section {
        background: linear-gradient(
          135deg,
          #fdf6f0 0%,
          #f5ede6 50%,
          #ede0d6 100%
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
          rgba(184, 147, 90, 0.15),
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
          rgba(193, 101, 74, 0.12),
          transparent
        );
        border-radius: 50%;
      }

      /* MOBILE SLIDER */
      @media (max-width: 768px) {
        .why-cards-slider {
          display: flex !important;
          overflow-x: auto;
          scroll-snap-type: x mandatory;
          gap: 16px;
          padding-bottom: 20px;
          -webkit-overflow-scrolling: touch;
          scrollbar-width: thin;
          scrollbar-color: #b8935a #f5ede6;
        }
        .why-cards-slider::-webkit-scrollbar {
          height: 6px;
        }
        .why-cards-slider::-webkit-scrollbar-track {
          background: #f5ede6;
          border-radius: 10px;
        }
        .why-cards-slider::-webkit-scrollbar-thumb {
          background: #b8935a;
          border-radius: 10px;
        }
        .why-card {
          min-width: 280px;
          flex-shrink: 0;
          scroll-snap-align: start;
        }
      }

      /* GENERAL RESPONSIVE */
      * {
        box-sizing: border-box;
      }
      @media (max-width: 768px) {
        .drawer-nav a {
          padding: 14px 16px;
          min-height: 48px;
        }
        button,
        .btn-primary,
        .btn-outline {
          min-height: 44px;
        }
        .topbar {
          font-size: 0.72rem;
          padding: 6px 0;
        }
      }
      @media (max-width: 640px) {
        .topbar-right {
          display: none !important;
        }
        .topbar {
          text-align: center;
        }
        .topbar-inner {
          justify-content: center;
          padding: 0 16px;
        }
        .topbar-left {
          flex-wrap: wrap;
          justify-content: center;
          gap: 8px 16px;
        }
        .hero-img-mobile {
          display: block;
          margin-bottom: 20px;
        }
        .badge-float {
          display: none !important;
        }
        .hero-section {
          overflow: visible;
          padding: 30px 20px 40px;
        }
        .hero-section h1 {
          font-size: 2rem !important;
          line-height: 1.2;
        }
        section {
          padding: 60px 20px !important;
        }
        .max-w-6xl {
          padding-left: 20px !important;
          padding-right: 20px !important;
        }
        .flex.gap-4 {
          flex-direction: column;
          gap: 12px;
        }
        .btn-primary,
        .btn-outline {
          padding: 12px 24px;
          font-size: 0.88rem;
          width: 100%;
          text-align: center;
          justify-content: center;
        }
      }
      @media (max-width: 480px) {
        .topbar {
          display: none;
        }
        h1 {
          font-size: 1.8rem !important;
        }
      }
      @media (max-width: 1024px) {
        .hero-section {
          grid-template-columns: 1fr;
          text-align: center;
          padding: 60px 24px 50px;
        }
      }
    </style>
  </head>
  <body>
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
          <a href="index.php" class="flex items-center gap-3 flex-shrink-0">
            <!-- <div
              class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-700 to-amber-500 flex items-center justify-center"
            >
              <i class="fa-solid fa-fire-flame-curved text-white text-sm"></i>
            </div> -->
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
          </a>
          <ul class="desktop-nav hidden md:flex items-center">
            <li>
              <a
                href="index.php"
                class="nav-link active text-sm font-medium text-brown transition-colors"
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
        <a href="index.php" class="active"
          ><i class="fa-solid fa-house"></i> Home</a
        >
        <a href="about.php"><i class="fa-solid fa-circle-info"></i> About</a>
        <a href="services.php"
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

    <!-- HERO -->
    <section
      style="
        background: linear-gradient(135deg, #faf7f2 0%, #f5ede6 100%);
        overflow: hidden;
        padding: 70px 0 40px;
      "
      class="relative"
    >
      <div class="hero-section" style="padding: 0 24px 0">
        <div class="relative z-10 reveal-left" style="transition-delay: 0.1s">
          <span class="section-tag" style="top: -15px"
            ><i class="fa-solid fa-circle-dot mr-1"></i> Handcrafted
            Ceramics</span
          >
          <h1
            class="font-heading text-5xl md:text-6xl lg:text-7xl font-bold text-charcoal leading-tight mt-1 mb-6"
          >
            Shape Your<br /><span class="text-gold font-heading"
              >Clay Story</span
            >
          </h1>
          <p
            class="text-muted text-lg leading-relaxed mb-10 max-w-lg mx-auto md:mx-0"
          >
      A luxury pottery studio in Amravati dedicated to handcrafted ceramics, slow artistry, and meaningful creative experiences.
          </p>
          <div
            class="flex flex-wrap gap-4 mb-12 justify-center md:justify-start"
          >
            <a href="contact.php" class="btn-primary">
              <i class="fa-regular fa-calendar-check mr-2"></i>Book a Workshop
            </a>
            <a href="services.php" class="btn-outline">
              <i class="fa-solid fa-arrow-right mr-2"></i>Our Workshops
            </a>
          </div>
          <!-- STATS -->
          <div
            class="flex items-center gap-6 justify-center md:justify-start flex-wrap"
          >
            <div
              class="text-center reveal-scale"
              style="transition-delay: 0.3s"
            >
              <div
                class="stat-num text-3xl font-bold text-brown"
                data-count="1"
                data-suffix="+"
              >
                0+
              </div>
              <div
                class="text-xs text-muted mt-1 font-medium uppercase tracking-widest"
              >
                Years
              </div>
            </div>
            <div class="w-px h-10 bg-amber-200 hidden sm:block"></div>
            <div
              class="text-center reveal-scale"
              style="transition-delay: 0.4s"
            >
              <div
                class="stat-num text-3xl font-bold text-brown"
                data-count="1000"
                data-suffix="+"
              >
                0+
              </div>
              <div
                class="text-xs text-muted mt-1 font-medium uppercase tracking-widest"
              >
                Students
              </div>
            </div>
            <div class="w-px h-10 bg-amber-200 hidden sm:block"></div>
            <div
              class="text-center reveal-scale"
              style="transition-delay: 0.5s"
            >
              <div
                class="stat-num text-3xl font-bold text-brown"
                data-count="95"
                data-suffix="%"
              >
                0%
              </div>
              <div
                class="text-xs text-muted mt-1 font-medium uppercase tracking-widest"
              >
                Satisfaction
              </div>
            </div>
            <div class="w-px h-10 bg-amber-200 hidden sm:block"></div>
            <div
              class="text-center reveal-scale"
              style="transition-delay: 0.6s"
            >
              <div
                class="stat-num text-3xl font-bold text-brown"
                data-count="15"
                data-suffix="+"
              >
                0+
              </div>
              <div
                class="text-xs text-muted mt-1 font-medium uppercase tracking-widest"
              >
                Workshops
              </div>
            </div>
          </div>
        </div>

        <!-- Mobile Hero Image -->
        <div
          class="hero-img-mobile reveal-scale"
          style="transition-delay: 0.2s"
        >
          <div
            class="mobile-hero-slider"
            style="
              position: relative;
              height: 240px;
              border-radius: 16px;
              overflow: visible;
            "
          >
            <div
              style="
                border-radius: 16px;
                overflow: hidden;
                height: 100%;
                position: relative;
              "
            >
              <div
                class="mobile-hero-slide"
                style="
                  position: absolute;
                  inset: 0;
                  opacity: 0;
                  transition: opacity 0.8s ease;
                "
              >
                <img
                  src="https://lh3.googleusercontent.com/p/AF1QipM8GHMzFOjTtxeNOyKNrFp3zZzkJc1Rr_kQ2gSn=s1360-w1360-h1020-rw"
                  alt="Potter at wheel"
                  style="width: 100%; height: 100%; object-fit: cover"
                />
              </div>
              <div
                class="mobile-hero-slide"
                style="
                  position: absolute;
                  inset: 0;
                  opacity: 0;
                  transition: opacity 0.8s ease;
                "
              >
                <img
                  src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGdXOLQZgVPBbUtxm2nO71n12ExnvbRX6FLm4BWt3hFQTkSej5ap4HNGJMg1rmFw2jezfrS9VK0qR9n0AFKV-5-OGT3U8de3MSwc-suqLWR1MGL86_chSdh8NxfB2XNTlXR0UzbjSqMsFpO=s1360-w1360-h1020-rw"
                  alt="Clay workshop"
                  style="width: 100%; height: 100%; object-fit: cover"
                />
              </div>
              <div
                class="mobile-hero-slide"
                style="
                  position: absolute;
                  inset: 0;
                  opacity: 0;
                  transition: opacity 0.8s ease;
                "
              >
                <img
                  src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAEBSuG42UWitHuP0FYM8UolfxPts3TTn74VbsiwwFKN1xbLTBun4wvIJBIlPVvdno69meumdIcoag-FCgMfgbw3xWxaN0_ine_5OkXClS9oNF4HVGOFXzCZ3N9fO-KcoS_FF6yBIAAJ-SEs=s1360-w1360-h1020-rw"
                  alt="Ceramic pieces"
                  style="width: 100%; height: 100%; object-fit: cover"
                />
              </div>
              <div
                class="mobile-hero-slide"
                style="
                  position: absolute;
                  inset: 0;
                  opacity: 0;
                  transition: opacity 0.8s ease;
                "
              >
                <img
                  src="https://lh3.googleusercontent.com/p/AF1QipMek6DSF0mIfrXIZiRgf0exIC4W2-NcorfnzIm3=s1360-w1360-h1020-rw"
                  alt="Pottery studio"
                  style="width: 100%; height: 100%; object-fit: cover"
                />
              </div>
            </div>
            <!-- Floating badges -->
            <div
              style="
                position: absolute;
                top: -8px;
                right: -20px;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                border-radius: 12px;
                padding: 8px 14px;
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
                z-index: 15;
                border: 1px solid rgba(232, 213, 183, 0.4);
              "
            >
              <div
                style="
                  width: 28px;
                  height: 28px;
                  border-radius: 8px;
                  background: linear-gradient(135deg, #ffd700, #ffa500);
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  flex-shrink: 0;
                "
              >
                <i
                  class="fa-solid fa-star"
                  style="color: #fff; font-size: 12px"
                ></i>
              </div>
              <div>
                <div
                  style="
                    font-size: 0.65rem;
                    color: #8a7a70;
                    font-weight: 500;
                    line-height: 1;
                  "
                >
                  Rating
                </div>
                <div
                  style="
                    font-size: 0.85rem;
                    font-weight: 700;
                    color: #5c3d2e;
                    line-height: 1.2;
                    margin-top: 1px;
                  "
                >
                  4.9/5
                </div>
              </div>
            </div>
            <div
              style="
                position: absolute;
                bottom: -8px;
                left: -20px;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                border-radius: 12px;
                padding: 8px 14px;
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
                z-index: 15;
                border: 1px solid rgba(232, 213, 183, 0.4);
              "
            >
              <div
                style="
                  width: 28px;
                  height: 28px;
                  border-radius: 8px;
                  background: linear-gradient(135deg, #b8935a, #8a6a3a);
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  flex-shrink: 0;
                "
              >
                <i
                  class="fa-solid fa-fire-flame-curved"
                  style="color: #fff; font-size: 12px"
                ></i>
              </div>
              <div>
                <div
                  style="
                    font-size: 0.65rem;
                    color: #8a7a70;
                    font-weight: 500;
                    line-height: 1;
                    white-space: nowrap;
                  "
                >
                  Kiln
                </div>
                <div
                  style="
                    font-size: 0.75rem;
                    font-weight: 700;
                    color: #5c3d2e;
                    line-height: 1.2;
                    margin-top: 1px;
                    white-space: nowrap;
                  "
                >
                  Fired
                </div>
              </div>
            </div>
            <!-- Mobile Slider Controls -->
            <button
              onclick="mobileHeroSliderPrev()"
              style="
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.85);
                border: 1.5px solid rgba(232, 213, 183, 0.5);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                z-index: 10;
                backdrop-filter: blur(8px);
                transition: all 0.3s ease;
              "
            >
              <i
                class="fa-solid fa-chevron-left"
                style="color: #8a7a70; font-size: 13px"
              ></i>
            </button>
            <button
              onclick="mobileHeroSliderNext()"
              style="
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.85);
                border: 1.5px solid rgba(232, 213, 183, 0.5);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                z-index: 10;
                backdrop-filter: blur(8px);
                transition: all 0.3s ease;
              "
            >
              <i
                class="fa-solid fa-chevron-right"
                style="color: #8a7a70; font-size: 13px"
              ></i>
            </button>
          </div>
        </div>

        <!-- Desktop Hero Image -->
        <div
          class="relative justify-center items-center hidden md:flex reveal-right"
          style="transition-delay: 0.2s"
        >
          <div class="relative w-full max-w-lg" style="margin-top: -20px">
            <!-- Soft Background Glow -->
            <div
              style="
                position: absolute;
                width: 320px;
                height: 320px;
                background: #d8c2a8;
                filter: blur(120px);
                opacity: 0.2;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: -1;
              "
            ></div>

            <!-- Slider Wrapper -->
            <div
              class="hero-slider-wrap overflow-visible"
              style="
                height: 500px;
                position: relative;
                border-radius: 34px;
                transform: rotate(-2deg);
                box-shadow:
                  0 40px 100px rgba(0, 0, 0, 0.12),
                  0 10px 40px rgba(184, 145, 42, 0.08);
              "
            >
              <!-- Image Container -->
              <div
                style="
                  border-radius: 34px;
                  overflow: hidden;
                  height: 100%;
                  width: 100%;
                  position: relative;
                "
              >
                <!-- Grain Texture -->
                <div
                  style="
                    position: absolute;
                    inset: 0;
                    opacity: 0.04;
                    z-index: 3;
                    pointer-events: none;
                    background-image: url(&quot;https://www.transparenttextures.com/patterns/noise.png&quot;);
                  "
                ></div>

                <!-- Slide 1 -->
                <div
                  class="hero-slide active"
                  style="
                    position: absolute;
                    inset: 0;
                    opacity: 1;
                    transition: opacity 0.8s ease;
                  "
                >
                  <img
                    src="https://lh3.googleusercontent.com/p/AF1QipM8GHMzFOjTtxeNOyKNrFp3zZzkJc1Rr_kQ2gSn=s1360-w1360-h1020-rw"
                    alt="Potter at wheel"
                    style="
                      width: 100%;
                      height: 100%;
                      object-fit: cover;
                      object-position: center;
                      filter: saturate(0.92) contrast(1.03);
                    "
                  />

                  <!-- Overlay -->
                  <div
                    style="
                      position: absolute;
                      inset: 0;
                      background: linear-gradient(
                        to top,
                        rgba(0, 0, 0, 0.25),
                        rgba(0, 0, 0, 0.04)
                      );
                      z-index: 2;
                    "
                  ></div>
                </div>

                <!-- Slide 2 -->
                <div
                  class="hero-slide"
                  style="
                    position: absolute;
                    inset: 0;
                    opacity: 0;
                    transition: opacity 0.8s ease;
                  "
                >
                  <img
                    src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGdXOLQZgVPBbUtxm2nO71n12ExnvbRX6FLm4BWt3hFQTkSej5ap4HNGJMg1rmFw2jezfrS9VK0qR9n0AFKV-5-OGT3U8de3MSwc-suqLWR1MGL86_chSdh8NxfB2XNTlXR0UzbjSqMsFpO=s1360-w1360-h1020-rw"
                    alt="Ceramic workshop"
                    style="
                      width: 100%;
                      height: 100%;
                      object-fit: cover;
                      object-position: center;
                      filter: saturate(0.92) contrast(1.03);
                    "
                  />

                  <div
                    style="
                      position: absolute;
                      inset: 0;
                      background: linear-gradient(
                        to top,
                        rgba(0, 0, 0, 0.25),
                        rgba(0, 0, 0, 0.04)
                      );
                      z-index: 2;
                    "
                  ></div>
                </div>

                <!-- Slide 3 -->
                <div
                  class="hero-slide"
                  style="
                    position: absolute;
                    inset: 0;
                    opacity: 0;
                    transition: opacity 0.8s ease;
                  "
                >
                  <img
                    src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAEBSuG42UWitHuP0FYM8UolfxPts3TTn74VbsiwwFKN1xbLTBun4wvIJBIlPVvdno69meumdIcoag-FCgMfgbw3xWxaN0_ine_5OkXClS9oNF4HVGOFXzCZ3N9fO-KcoS_FF6yBIAAJ-SEs=s1360-w1360-h1020-rw"
                    alt="Handmade pottery"
                    style="
                      width: 100%;
                      height: 100%;
                      object-fit: cover;
                      object-position: center;
                      filter: saturate(0.92) contrast(1.03);
                    "
                  />

                  <div
                    style="
                      position: absolute;
                      inset: 0;
                      background: linear-gradient(
                        to top,
                        rgba(0, 0, 0, 0.25),
                        rgba(0, 0, 0, 0.04)
                      );
                      z-index: 2;
                    "
                  ></div>
                </div>

                <!-- Slide 4 -->
                <div
                  class="hero-slide"
                  style="
                    position: absolute;
                    inset: 0;
                    opacity: 0;
                    transition: opacity 0.8s ease;
                  "
                >
                  <img
                    src="https://lh3.googleusercontent.com/p/AF1QipMek6DSF0mIfrXIZiRgf0exIC4W2-NcorfnzIm3=s1360-w1360-h1020-rw"
                    alt="Clay art"
                    style="
                      width: 100%;
                      height: 100%;
                      object-fit: cover;
                      object-position: center;
                      filter: saturate(0.92) contrast(1.03);
                    "
                  />

                  <div
                    style="
                      position: absolute;
                      inset: 0;
                      background: linear-gradient(
                        to top,
                        rgba(0, 0, 0, 0.25),
                        rgba(0, 0, 0, 0.04)
                      );
                      z-index: 2;
                    "
                  ></div>
                </div>
              </div>

              <!-- Floating Rating Card -->
              <div
                style="
                  position: absolute;
                  top: -16px;
                  right: -45px;
                  background: rgba(255, 255, 255, 0.72);
                  backdrop-filter: blur(20px);
                  border-radius: 18px;
                  padding: 14px 22px;
                  display: flex;
                  align-items: center;
                  gap: 12px;
                  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
                  z-index: 15;
                  border: 1px solid rgba(255, 255, 255, 0.35);
                  animation: luxuryFloat 5s ease-in-out infinite;
                "
              >
                <div
                  style="
                    width: 42px;
                    height: 42px;
                    border-radius: 14px;
                    background: linear-gradient(135deg, #c9a86a, #b8912a);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                  "
                >
                  <i
                    class="fa-solid fa-star"
                    style="color: #fff; font-size: 15px"
                  ></i>
                </div>

                <div>
                  <div
                    style="
                      font-size: 0.68rem;
                      color: #8a7a70;
                      font-weight: 500;
                      text-transform: uppercase;
                      letter-spacing: 0.18em;
                    "
                  >
                    Studio Rating
                  </div>

                  <div
                    style="
                      font-size: 1.05rem;
                      font-weight: 700;
                      color: #3b2a20;
                      margin-top: 4px;
                    "
                  >
                    4.9 / 5.0
                  </div>
                </div>
              </div>

              <!-- Floating Premium Card -->
              <div
                style="
                  position: absolute;
                  bottom: -16px;
                  left: -45px;
                  background: rgba(255, 255, 255, 0.72);
                  backdrop-filter: blur(20px);
                  border-radius: 18px;
                  padding: 14px 22px;
                  display: flex;
                  align-items: center;
                  gap: 12px;
                  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
                  z-index: 15;
                  border: 1px solid rgba(255, 255, 255, 0.35);
                  animation: luxuryFloat 5s ease-in-out infinite;
                  animation-delay: 1.5s;
                "
              >
                <div
                  style="
                    width: 42px;
                    height: 42px;
                    border-radius: 14px;
                    background: linear-gradient(135deg, #8b5e3c, #5f3d2b);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                  "
                >
                  <i
                    class="fa-solid fa-fire-flame-curved"
                    style="color: #fff; font-size: 15px"
                  ></i>
                </div>

                <div>
                  <div
                    style="
                      font-size: 0.68rem;
                      color: #8a7a70;
                      font-weight: 500;
                      text-transform: uppercase;
                      letter-spacing: 0.18em;
                    "
                  >
                    Kiln Fired
                  </div>

                  <div
                    style="
                      font-size: 0.95rem;
                      font-weight: 700;
                      color: #3b2a20;
                      margin-top: 4px;
                    "
                  >
                    Premium Ceramics
                  </div>
                </div>
              </div>
            </div>

            <!-- Slider Controls -->
            <button
              onclick="heroSliderPrev()"
              class="hero-slider-btn"
              style="
                position: absolute;
                left: -24px;
                top: 50%;
                transform: translateY(-50%);
                width: 54px;
                height: 54px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.72);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.35);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                z-index: 20;
                transition: all 0.35s ease;
              "
            >
              <i
                class="fa-solid fa-chevron-left"
                style="color: #7a6759; font-size: 16px"
              ></i>
            </button>

            <button
              onclick="heroSliderNext()"
              class="hero-slider-btn"
              style="
                position: absolute;
                right: -24px;
                top: 50%;
                transform: translateY(-50%);
                width: 54px;
                height: 54px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.72);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.35);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                z-index: 20;
                transition: all 0.35s ease;
              "
            >
              <i
                class="fa-solid fa-chevron-right"
                style="color: #7a6759; font-size: 16px"
              ></i>
            </button>
          </div>
        </div>

        <style>
          @keyframes luxuryFloat {
            0% {
              transform: translateY(0px);
            }

            50% {
              transform: translateY(-10px);
            }

            100% {
              transform: translateY(0px);
            }
          }
        </style>
      </div>
    </section>

    <!-- MARQUEE -->
    <div
      class="marquee-wrap reveal"
      style="
        opacity: 0;
        transform: translateY(0);
        transition: opacity 0.8s ease;
      "
    >
      <div
        class="marquee-track text-gold-light text-sm font-medium tracking-widest uppercase"
      >
        <span class="text-amber-200">Wheel Throwing</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Hand Building</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Glaze Painting</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Clay Sculpting</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Raku Firing</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Custom Ceramics</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Kids Workshops</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Corporate Sessions</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <!-- duplicate for loop -->
        <span class="text-amber-200">Wheel Throwing</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Hand Building</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Glaze Painting</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Clay Sculpting</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Raku Firing</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Custom Ceramics</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Kids Workshops</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
        <span class="text-amber-200">Corporate Sessions</span
        ><span class="text-gold mx-2 opacity-60"
          ><i class="fa-solid fa-diamond text-xs"></i
        ></span>
      </div>
    </div>

    <!-- WHY CHOOSE US -->
    <section class="py-20 bg-white overflow-hidden">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Heading -->
    <div class="text-center mb-14 reveal">
      <span class="section-tag">Why Choose Us</span>

      <h2
        class="font-heading text-4xl lg:text-5xl font-bold text-charcoal mt-3 mb-4"
      >
        The Clayo
        <span class="text-gold font-heading">Difference</span>
      </h2>

      <p class="text-muted max-w-xl mx-auto">
        Art meets mindfulness — every workshop is immersive, every piece is
        personal, and every visit leaves you with both a creation and a memory.
      </p>
    </div>

    <!-- Cards -->
    <div
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12"
    >
      <!-- Card 1 -->
      <div
        class="why-card reveal bg-white rounded-3xl overflow-hidden border border-amber-100 transition-all duration-500 hover:-translate-y-2"
        style="
          transition-delay: 0.05s;
          box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        "
      >
        <div
          class="overflow-hidden"
          style="height: 160px"
        >
          <img
            src="https://images.unsplash.com/photo-1609881583302-61548332039c?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8RXhwZXJ0JTIwQXJ0aXNhbnMlMjBwb3R0cnl8ZW58MHx8MHx8fDA%3D"
            alt="Expert potters"
            class="why-card-img"
          />
        </div>

        <div class="p-6">
          <h4
            class="font-heading text-lg font-semibold text-brown mb-2"
          >
            Expert Artisans
          </h4>

          <p class="text-sm text-muted leading-relaxed">
            All workshops led by master potters with 10+ years of craft
            experience — patient, passionate, and deeply skilled.
          </p>
        </div>
      </div>

      <!-- Card 2 -->
      <div
        class="why-card reveal bg-white rounded-3xl overflow-hidden border border-amber-100 transition-all duration-500 hover:-translate-y-2"
        style="
          transition-delay: 0.1s;
          box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        "
      >
        <div
          class="overflow-hidden"
          style="height: 160px"
        >
          <img
            src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGJktboAfwbGLOBWSxrFXPQeEJ1Pc3anKv2dkYDbs16CQ3yclvhMxWDmsfvIWsNeG2nSgU1O5hXb9ZowrhY0uR_SfzAsSm1Z32kHUp4i76GNkxuKrQTfORQc-LIXIKEYKXVAUEA34EjVrwk=s1360-w1360-h1020-rw"
            alt="Small batch classes"
            class="why-card-img"
          />
        </div>

        <div class="p-6">
          <h4
            class="font-heading text-lg font-semibold text-brown mb-2"
          >
            Small Batch Classes
          </h4>

          <p class="text-sm text-muted leading-relaxed">
            Maximum 8 students per session — ensuring personal attention,
            hands-on learning, and a premium studio experience.
          </p>
        </div>
      </div>

      <!-- Card 3 -->
      <div
        class="why-card reveal bg-white rounded-3xl overflow-hidden border border-amber-100 transition-all duration-500 hover:-translate-y-2"
        style="
          transition-delay: 0.15s;
          box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        "
      >
        <div
          class="overflow-hidden"
          style="height: 160px"
        >
          <img
            src="https://images.unsplash.com/photo-1595351298020-038700609878?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8UG90dGVyeSUyMG1hdGVyaWFsfGVufDB8fDB8fHww"
            alt="Premium clay"
            class="why-card-img"
          />
        </div>

        <div class="p-6">
          <h4
            class="font-heading text-lg font-semibold text-brown mb-2"
          >
            Premium Materials
          </h4>

          <p class="text-sm text-muted leading-relaxed">
            We use only the finest stoneware, terracotta and porcelain clays
            with food-safe, lead-free glazes throughout.
          </p>
        </div>
      </div>

      <!-- Card 4 -->
      <div
        class="why-card reveal bg-white rounded-3xl overflow-hidden border border-amber-100 transition-all duration-500 hover:-translate-y-2"
        style="
          transition-delay: 0.2s;
          box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        "
      >
        <div
          class="overflow-hidden"
          style="height: 160px"
        >
          <img
            src="https://images.unsplash.com/photo-1730382624709-81e52dd294d4?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="All skill levels"
            class="why-card-img"
          />
        </div>

        <div class="p-6">
          <h4
            class="font-heading text-lg font-semibold text-brown mb-2"
          >
            All Skill Levels
          </h4>

          <p class="text-sm text-muted leading-relaxed">
            Whether you've never touched clay or are an advanced ceramicist, we
            have a workshop perfectly suited for you.
          </p>
        </div>
      </div>
    </div>

    <!-- Button -->
    <div
      class="text-center mt-10 reveal"
      style="transition-delay: 0.4s"
    >
      <a href="about.php" class="btn-primary">
        Our Story
        <i class="fa-solid fa-arrow-right ml-2"></i>
      </a>
    </div>
  </div>
    </section>

    <style>
  html,
  body {
    overflow-x: hidden;
  }

  .why-card {
    width: 100%;
    max-width: 100%;
  }

  .why-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
  }

  .why-card:hover .why-card-img {
    transform: scale(1.06);
  }

  @media (max-width: 768px) {
    .why-card {
      transform: none !important;
    }

    .reveal,
    .reveal-left,
    .reveal-right {
      transform: none !important;
    }

    .why-card:hover {
      transform: none !important;
    }
  }
    </style>

    <!-- WORKSHOPS PREVIEW -->
    <section class="py-24 bg-cream">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
          <span class="section-tag">Our Workshops</span>
          <h2
            class="font-heading text-4xl lg:text-5xl font-bold text-charcoal mt-3 mb-4"
          >
            Most Popular <span class="text-gold font-heading">Classes</span>
          </h2>
          <p class="text-muted max-w-xl mx-auto">
            Explore our most-loved pottery workshops, each designed to awaken
            your creative spirit and develop lasting ceramic skills.
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <!-- Card 1 -->
          <div
            class="reveal bg-white rounded-2xl overflow-hidden border border-amber-100 card-hover srv-card"
            style="transition-delay: 0.05s"
          >
            <div class="srv-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1641658517560-c07cb9849143?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fFdoZWVsJTIwVGhyb3dpbmclMjBCYXNpY3N8ZW58MHx8MHx8fDA%3D"
                alt="Wheel Throwing"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 mb-3">
                <span
                  class="text-xs font-semibold text-gold uppercase tracking-widest"
                  >Beginner</span
                >
              </div>
              <h3 class="font-heading text-xl font-semibold text-brown mb-2">
                Wheel Throwing Basics
              </h3>
              <p class="text-sm text-muted leading-relaxed mb-4">
                Learn to centre, open, and raise clay on the potter's wheel.
                Walk away with your very first bowl or cylinder — a tactile,
                meditative experience you'll never forget.
              </p>
              <div class="flex items-center justify-between">
                <span class="text-xs text-muted bg-cream px-3 py-1 rounded-full"
                  >Starting ₹1,200</span
                >
                <a
                  href="services.php"
                  class="text-sm font-semibold text-gold hover:text-brown transition-colors"
                  >Explore <i class="fa-solid fa-arrow-right text-xs ml-1"></i
                ></a>
              </div>
            </div>
          </div>
          <!-- Card 2 -->
          <div
            class="reveal bg-white rounded-2xl overflow-hidden border border-amber-100 card-hover srv-card relative"
            style="transition-delay: 0.1s"
          >
            <div
              class="absolute top-4 right-4 z-10 bg-gold text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full"
            >
              Most Popular
            </div>
            <div class="srv-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1496769843785-93aa0be525dc?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8SGFuZCUyMEJ1aWxkaW5nJTIwJTI2JTIwU2N1bHB0aW5nfGVufDB8fDB8fHww"
                alt="Hand Building"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 mb-3">
                <span
                  class="text-xs font-semibold text-gold uppercase tracking-widest"
                  >All Levels</span
                >
              </div>
              <h3 class="font-heading text-xl font-semibold text-brown mb-2">
                Hand Building & Sculpting
              </h3>
              <p class="text-sm text-muted leading-relaxed mb-4">
                Pinch, coil, and slab techniques to create unique vessels,
                plates and sculptural forms. No wheel needed — pure hand and
                imagination.
              </p>
              <div class="flex items-center justify-between">
                <span class="text-xs text-muted bg-cream px-3 py-1 rounded-full"
                  >Starting ₹900</span
                >
                <a
                  href="services.php"
                  class="text-sm font-semibold text-gold hover:text-brown transition-colors"
                  >Explore <i class="fa-solid fa-arrow-right text-xs ml-1"></i
                ></a>
              </div>
            </div>
          </div>
          <!-- Card 3 -->
          <div
            class="reveal bg-white rounded-2xl overflow-hidden border border-amber-100 card-hover srv-card"
            style="transition-delay: 0.15s"
          >
            <div class="srv-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1595351298020-038700609878?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8R2xhemUlMjAmJTIwRmlyZSUyMG1hc3RlcmNsYXNzfGVufDB8fDB8fHww"
                alt="Glaze & Fire"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 mb-3">
                <span
                  class="text-xs font-semibold text-gold uppercase tracking-widest"
                  >Intermediate</span
                >
              </div>
              <h3 class="font-heading text-xl font-semibold text-brown mb-2">
                Glaze & Fire Masterclass
              </h3>
              <p class="text-sm text-muted leading-relaxed mb-4">
                Dive deep into glaze chemistry, surface decoration techniques,
                and the magic of kiln firing. Transform your raw pieces into
                finished ceramic art.
              </p>
              <div class="flex items-center justify-between">
                <span class="text-xs text-muted bg-cream px-3 py-1 rounded-full"
                  >Starting ₹1,500</span
                >
                <a
                  href="services.php"
                  class="text-sm font-semibold text-gold hover:text-brown transition-colors"
                  >Explore <i class="fa-solid fa-arrow-right text-xs ml-1"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-12 reveal" style="transition-delay: 0.2s">
          <a href="services.php" class="btn-primary"
            >View All 15+ Workshops <i class="fa-solid fa-arrow-right ml-2"></i
          ></a>
        </div>
      </div>
    </section>

    <!-- PROCESS -->
    <section class="py-24 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
          <span class="section-tag">How It Works</span>
          <h2 class="font-heading text-4xl font-bold text-charcoal mt-3 mb-4">
            Your Clay Journey in
            <span class="text-gold font-heading">4 Simple Steps</span>
          </h2>
          <p class="text-muted max-w-lg mx-auto">
            From choosing your first workshop to firing your finished piece — we
            guide you through every stage of the ceramic process.
          </p>
        </div>
        <div class="grid md:grid-cols-4 gap-8 relative">
          <div class="reveal text-center" style="transition-delay: 0.05s">
            <div class="step-img-wrap">
              <img
                src="https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=300&q=80"
                alt="Book Workshop"
              />
            </div>
            <div
              class="text-xs font-bold text-gold uppercase tracking-widest mb-2"
            >
              Step 01
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-2">
              Book a Workshop
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Choose your preferred session, skill level and date. Beginners
              always welcome — no experience needed.
            </p>
          </div>
          <div class="reveal text-center" style="transition-delay: 0.15s">
            <div class="step-img-wrap" style="border-color: #d4a09a">
              <img
                src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=300&q=80"
                alt="Meet the Clay"
              />
            </div>
            <div
              class="text-xs font-bold text-gold uppercase tracking-widest mb-2"
            >
              Step 02
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-2">
              Meet the Clay
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Arrive, get your apron, and dive into the tactile world of clay
              guided by our expert instructors.
            </p>
          </div>
          <div class="reveal text-center" style="transition-delay: 0.25s">
            <div class="step-img-wrap" style="border-color: #b8935a">
              <img
                src="https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=300&q=80"
                alt="Create & Fire"
              />
            </div>
            <div
              class="text-xs font-bold text-gold uppercase tracking-widest mb-2"
            >
              Step 03
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-2">
              Create & Fire
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Shape, glaze and kiln-fire your piece. We handle all the technical
              steps and keep your art safe.
            </p>
          </div>
          <div class="reveal text-center" style="transition-delay: 0.35s">
            <div class="step-img-wrap" style="border-color: #8fa88a">
              <img
                src="https://images.unsplash.com/photo-1504198266287-1659872e6590?w=300&q=80"
                alt="Take Home"
              />
            </div>
            <div
              class="text-xs font-bold text-gold uppercase tracking-widest mb-2"
            >
              Step 04
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-2">
              Take It Home
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Collect your fired, glazed ceramic masterpiece. A unique piece of
              art made entirely by your own hands.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- MEET OUR TEAM -->
 <section
  class="py-24 relative overflow-hidden"
  style="
    background:
      linear-gradient(
        180deg,
        #fffdf9 0%,
        #f7efe5 100%
      );
  "
>
  <!-- Background Glow -->
  <div
    style="
      position:absolute;
      top:-180px;
      right:-120px;
      width:500px;
      height:500px;
      border-radius:999px;
      background:rgba(232,192,128,0.12);
      filter:blur(120px);
      pointer-events:none;
    "
  ></div>

  <div
    style="
      position:absolute;
      bottom:-180px;
      left:-120px;
      width:420px;
      height:420px;
      border-radius:999px;
      background:rgba(184,147,90,0.08);
      filter:blur(120px);
      pointer-events:none;
    "
  ></div>

  <div class="max-w-6xl mx-auto px-6 relative z-10">

    <!-- Layout -->
    <div
      class="grid lg:grid-cols-2 gap-20 items-center"
    >

      <!-- LEFT CONTENT -->
      <div class="reveal">

        <!-- Small Tag -->
        <div
          style="
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:rgba(255,255,255,0.72);
            border:1px solid rgba(198,155,93,0.18);
            backdrop-filter:blur(12px);
            padding:10px 18px;
            border-radius:999px;
            margin-bottom:24px;
            box-shadow:
              0 10px 30px rgba(0,0,0,0.04);
          "
        >
          <div
            style="
              width:10px;
              height:10px;
              border-radius:999px;
              background:#c69b5d;
              animation:pulseGlow 2s infinite;
            "
          ></div>

          <span
            style="
              font-size:0.78rem;
              letter-spacing:0.12em;
              text-transform:uppercase;
              color:#7a5c42;
              font-weight:600;
            "
          >
            Meet Our Instructor
          </span>
        </div>

        <!-- Heading -->
        <h2
          class="font-heading"
          style="
            font-size:clamp(2.5rem,5vw,5rem);
            line-height:1.04;
            color:#4f2f1f;
            margin-bottom:20px;
            letter-spacing:-0.03em;
          "
        >
          The Artist
          <span style="color:#c69b5d">
            Behind
          </span>
          The Clayo
        </h2>

        <!-- Description -->
        <p
          style="
            color:#7d6a5c;
            line-height:1.95;
            margin-bottom:34px;
            font-size:1rem;
            max-width:520px;
          "
        >
          Experience pottery workshops guided by creativity, mindfulness, and
          artistic expression. Every session is designed to make clay feel
          calming, immersive, and beginner friendly.
        </p>

        <!-- Features -->
        <div class="flex flex-wrap gap-3 mb-10">

          <span
            style="
              background:#fff;
              border:1px solid #f0dfc7;
              padding:11px 18px;
              border-radius:999px;
              font-size:0.84rem;
              color:#7a5c42;
              box-shadow:
                0 8px 22px rgba(0,0,0,0.03);
            "
          >
            Wheel Throwing
          </span>

          <span
            style="
              background:#fff;
              border:1px solid #f0dfc7;
              padding:11px 18px;
              border-radius:999px;
              font-size:0.84rem;
              color:#7a5c42;
              box-shadow:
                0 8px 22px rgba(0,0,0,0.03);
            "
          >
            Hand Building
          </span>

          <span
            style="
              background:#fff;
              border:1px solid #f0dfc7;
              padding:11px 18px;
              border-radius:999px;
              font-size:0.84rem;
              color:#7a5c42;
              box-shadow:
                0 8px 22px rgba(0,0,0,0.03);
            "
          >
            Creative Workshops
          </span>

          <!-- <span
            style="
              background:#fff;
              border:1px solid #f0dfc7;
              padding:11px 18px;
              border-radius:999px;
              font-size:0.84rem;
              color:#7a5c42;
              box-shadow:
                0 8px 22px rgba(0,0,0,0.03);
            "
          >
            Beginner Friendly
          </span> -->
        </div>

        <!-- CTA -->
        <a
          href="contact.php"
          style="
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            background:
              linear-gradient(
                135deg,
                #c8a060,
                #b07a42
              );
            color:white;
            padding:15px 30px;
            border-radius:999px;
            font-size:0.95rem;
            font-weight:600;
            text-decoration:none;
            box-shadow:
              0 14px 35px rgba(176,122,66,0.22);
            transition:all 0.35s ease;
          "
          onmouseover="
            this.style.transform='translateY(-3px)';
            this.style.boxShadow='0 22px 50px rgba(176,122,66,0.30)';
          "
          onmouseout="
            this.style.transform='translateY(0px)';
            this.style.boxShadow='0 14px 35px rgba(176,122,66,0.22)';
          "
        >
          Book Workshop
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>

      <!-- RIGHT IMAGE SECTION -->
  <!-- RIGHT IMAGE SECTION -->
<div
  class="reveal-right flex justify-center"
  style="position:relative"
>
  <!-- Wrapper -->
  <div
    style="
      position:relative;
      width:520px;
      display:flex;
      flex-direction:column;
      align-items:center;
    "
  >
    <!-- Soft Glow -->
    <div
      style="
        position:absolute;
        top:60px;
        width:320px;
        height:320px;
        border-radius:999px;
        background:rgba(232,192,128,0.18);
        filter:blur(90px);
        z-index:0;
      "
    ></div>

    <!-- Image -->
    <div
      style="
        width:320px;
        height:320px;
        border-radius:999px;
        overflow:hidden;
        position:relative;
        z-index:2;
        border:12px solid rgba(255,255,255,0.82);
        box-shadow:
          0 35px 80px rgba(0,0,0,0.16);
        animation:floatRing 6s ease-in-out infinite;
      "
    >
      <img
        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=900&q=90"
        alt="Sakshi Chavan"
        style="
          width:100%;
          height:100%;
          object-fit:cover;
          transition:transform 0.8s ease;
        "
        onmouseover="
          this.style.transform='scale(1.07)';
        "
        onmouseout="
          this.style.transform='scale(1)';
        "
      />
    </div>

    <!-- Text Outside Image -->
    <div
      style="
        margin-top:38px;
        text-align:center;
        max-width:420px;
      "
    >
      <!-- Name -->
      <h4
        class="font-heading"
        style="
          font-size:2rem;
          color:#5c3820;
          margin-bottom:10px;
          letter-spacing:-0.03em;
        "
      >
        Sakshi Chavan
      </h4>

      <!-- Description -->
      <p
        style="
          color:#7d6a5c;
          font-size:0.98rem;
          line-height:1.8;
          margin-bottom:16px;
        "
      >
        Guiding students through mindful pottery experiences, handcrafted
        ceramics, and creative clay workshops in Amravati.
      </p>

      <!-- Instagram -->
      <div
        style="
          display:flex;
          align-items:center;
          justify-content:center;
          gap:8px;
          color:#8b6a52;
          font-size:0.95rem;
          font-weight:500;
        "
      >
        <i
          class="fa-brands fa-instagram"
          style="
            color:#c69b5d;
            font-size:1rem;
          "
        ></i>

        @sakshichavan.art
      </div>
    </div>
  </div>
</div>
    </div>
  </div>

  <!-- Animations -->
  <style>
    @keyframes rotateRing {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    @keyframes floatRing {
      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-12px);
      }
    }

    @keyframes pulseGlow {
      0%,
      100% {
        opacity: 1;
        transform: scale(1);
      }

      50% {
        opacity: 0.6;
        transform: scale(1.3);
      }
    }

    @media (max-width: 1024px) {
      .grid.lg\:grid-cols-2 {
        grid-template-columns: 1fr !important;
      }
    }

    @media (max-width: 768px) {
      .reveal-right > div {
        width: 340px !important;
        height: 340px !important;
      }

      .reveal-right img {
        width: 240px !important;
        height: 240px !important;
      }

      .reveal-right h4 {
        font-size: 1.1rem !important;
      }
    }
  </style>
</section>

    <!-- TESTIMONIALS -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
          <span class="section-tag">Student Stories</span>
          <h2 class="font-heading text-4xl font-bold text-charcoal mt-3 mb-4">
            What Our Students <span class="text-gold font-heading">Say</span>
          </h2>
          <p class="text-muted max-w-lg mx-auto">
            Real experiences, real transformations. Hear from the hands that
            shaped their first pots with us.
          </p>
        </div>
        <div class="testimonial-slider-wrapper relative">
          <div class="testimonial-slider grid md:grid-cols-3 gap-8">
            <div
              class="testimonial-card reveal bg-white rounded-2xl p-8 border border-amber-100 card-hover"
              style="transition-delay: 0.05s"
            >
              <div class="testimonial-stars text-lg mb-4">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i
                ><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i
                ><i class="fa-solid fa-star"></i>
              </div>
              <p class="text-muted text-sm leading-relaxed italic mb-6">
                "I came in knowing nothing about pottery and left with a
                beautiful bowl I made myself. Priya is an incredibly patient
                teacher. Clayo Studio has genuinely changed how I spend my
                weekends!"
              </p>
              <div class="flex items-center gap-4">
                <div
                  class="w-12 h-12 rounded-full bg-amber-50 border-2 border-gold flex items-center justify-center font-heading text-lg font-bold text-gold"
                >
                  A
                </div>
                <div>
                  <div class="font-semibold text-charcoal text-sm">
                    Ananya Joshi
                  </div>
                  <div class="text-xs text-muted">
                    Amravati — Wheel Throwing
                  </div>
                </div>
              </div>
            </div>
            <div
              class="testimonial-card reveal bg-white rounded-2xl p-8 border border-amber-100 card-hover"
              style="transition-delay: 0.1s"
            >
              <div class="testimonial-stars text-lg mb-4">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i
                ><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i
                ><i class="fa-solid fa-star"></i>
              </div>
              <p class="text-muted text-sm leading-relaxed italic mb-6">
                "We booked a corporate workshop for our team and it was the best
                team-building activity we've ever done. Everyone was laughing,
                creating and completely off their phones for 3 hours. Magical!"
              </p>
              <div class="flex items-center gap-4">
                <div
                  class="w-12 h-12 rounded-full bg-amber-50 border-2 border-gold flex items-center justify-center font-heading text-lg font-bold text-gold"
                >
                  S
                </div>
                <div>
                  <div class="font-semibold text-charcoal text-sm">
                    Saurabh Bhagat
                  </div>
                  <div class="text-xs text-muted">
                    Nagpur — Corporate Session
                  </div>
                </div>
              </div>
            </div>
            <div
              class="testimonial-card reveal bg-white rounded-2xl p-8 border border-amber-100 card-hover"
              style="transition-delay: 0.15s"
            >
              <div class="testimonial-stars text-lg mb-4">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i
                ><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i
                ><i class="fa-solid fa-star"></i>
              </div>
              <p class="text-muted text-sm leading-relaxed italic mb-6">
                "My daughter's 10th birthday party at Clayo was absolutely
                wonderful. All the kids made their own clay animals and the
                instructors made it so fun and safe. Every parent was
                impressed!"
              </p>
              <div class="flex items-center gap-4">
                <div
                  class="w-12 h-12 rounded-full bg-amber-50 border-2 border-gold flex items-center justify-center font-heading text-lg font-bold text-gold"
                >
                  N
                </div>
                <div>
                  <div class="font-semibold text-charcoal text-sm">
                    Neha Thakur
                  </div>
                  <div class="text-xs text-muted">Amravati — Kids Workshop</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section py-20 relative" style="overflow: hidden">
      <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <!-- LEFT: Image -->
          <div
            class="reveal-left flex justify-center lg:justify-start"
            style="transition-delay: 0.05s"
          >
            <div
              style="
                position: relative;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 24px 80px rgba(80, 40, 20, 0.22);
                max-width: 440px;
                width: 100%;
              "
            >
              <img
                src="https://images.unsplash.com/photo-1673252414896-50825d7bbc18?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fFJlYWR5JTIwdG8lMjBCZWdpbiUyMFlvdXIlMjBDbGF5JTIwSm91cm5leSUzRnxlbnwwfHwwfHx8MA%3D%3D"
                alt="Potter at work"
                style="
                  width: 100%;
                  height: 480px;
                  object-fit: cover;
                  object-position: center;
                  display: block;
                  border-radius: 24px;
                "
              />
            </div>
          </div>
          <!-- RIGHT: Text -->
          <div class="reveal-right" style="transition-delay: 0.15s">
            <span class="section-tag">Start Creating Today</span>
            <h2
              class="font-heading text-4xl lg:text-5xl font-bold text-charcoal mt-4 mb-5 leading-tight"
            >
              Ready to Begin Your
              <span class="text-gold font-heading">Clay Journey?</span>
            </h2>
            <p class="text-muted text-lg mb-8 leading-relaxed">
              Book a workshop today and let our master potters guide you through
              the ancient, meditative art of ceramics. Your first handmade piece
              is just one session away.
            </p>
            <div class="flex flex-wrap gap-4 mb-8">
              <a href="contact.php" class="btn-primary text-base px-8 py-4">
                <i class="fa-regular fa-calendar-check mr-2"></i>Book a Workshop
              </a>
              <a
                href="tel:+919876543210"
                class="btn-outline text-base px-8 py-4"
              >
                <i class="fa-solid fa-phone mr-2"></i>Call Now
              </a>
            </div>
            <div class="flex flex-col gap-3 text-sm text-muted">
              <div class="flex items-center gap-3">
                <i
                  class="fa-solid fa-circle-check text-green-500 text-base"
                ></i>
                All materials provided
              </div>
              <div class="flex items-center gap-3">
                <i
                  class="fa-solid fa-circle-check text-green-500 text-base"
                ></i>
                Take your piece home after firing
              </div>
              <div class="flex items-center gap-3">
                <i
                  class="fa-solid fa-circle-check text-green-500 text-base"
                ></i>
                No experience required whatsoever
              </div>
            </div>
          </div>
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

    <!-- WhatsApp Floating Button -->
    <a
      href="https://wa.me/919724788561"
      target="_blank"
      class="whatsapp-btn"
      title="Chat on WhatsApp"
    >
      <i class="fa-brands fa-whatsapp text-white text-2xl"></i>
    </a>

    <script>
      // Dynamic body offset for fixed header
      function updateHeaderOffset() {
        const header = document.querySelector(".sticky-header");
        if (header) {
          document.body.style.setProperty(
            "--header-height",
            header.offsetHeight + "px",
          );
          document.body.style.paddingTop = header.offsetHeight + "px";
        }
      }
      updateHeaderOffset();
      window.addEventListener("resize", updateHeaderOffset);

      // Navbar scroll effect
      const navbar = document.getElementById("navbar");
      window.addEventListener("scroll", () => {
        navbar.classList.toggle("navbar-scrolled", window.scrollY > 20);
      });

      // Drawer
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

      // Scroll Reveal
      const revealObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("revealed");
              revealObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.08, rootMargin: "0px 0px -40px 0px" },
      );
      document
        .querySelectorAll(
          ".reveal, .reveal-left, .reveal-right, .reveal-scale, .why-img-wrap",
        )
        .forEach((el) => revealObserver.observe(el));

      // Marquee reveal
      document.querySelectorAll(".marquee-wrap.reveal").forEach((el) => {
        const mo = new IntersectionObserver(
          (entries) => {
            entries.forEach((e) => {
              if (e.isIntersecting) {
                e.target.style.opacity = "1";
                mo.unobserve(e.target);
              }
            });
          },
          { threshold: 0.2 },
        );
        mo.observe(el);
      });

      const fadeObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("visible");
              fadeObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.12 },
      );
      document
        .querySelectorAll(".fade-in")
        .forEach((el) => fadeObserver.observe(el));

      // Counter Animation
      function animateCounter(el) {
        const target = parseInt(el.dataset.count);
        const suffix = el.dataset.suffix || "";
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        const timer = setInterval(() => {
          current += step;
          if (current >= target) {
            current = target;
            clearInterval(timer);
          }
          const formatted =
            target >= 1000
              ? Math.floor(current).toLocaleString("en-IN")
              : Math.floor(current);
          el.textContent = formatted + suffix;
        }, 16);
      }
      const statObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              animateCounter(entry.target);
              statObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.5 },
      );
      document
        .querySelectorAll("[data-count]")
        .forEach((el) => statObserver.observe(el));

      // Testimonial Slider (Mobile)
      if (window.innerWidth <= 768) {
        const cards = document.querySelectorAll(".testimonial-card");
        let currentIndex = 0;
        function showCard(index) {
          cards.forEach((card, i) => {
            card.classList.toggle("active", i === index);
          });
        }
        function nextCard() {
          currentIndex = (currentIndex + 1) % cards.length;
          showCard(currentIndex);
        }
        showCard(0);
        setInterval(nextCard, 2000);
      }

      // Hero Image Slider
      let heroCurrentSlide = 0;
      const heroSlides = document.querySelectorAll(".hero-slide");
      function showHeroSlide(index) {
        heroSlides.forEach((slide, i) => {
          slide.style.opacity = i === index ? "1" : "0";
          slide.classList.toggle("active", i === index);
        });
      }
      function heroSliderNext() {
        heroCurrentSlide = (heroCurrentSlide + 1) % heroSlides.length;
        showHeroSlide(heroCurrentSlide);
      }
      function heroSliderPrev() {
        heroCurrentSlide =
          (heroCurrentSlide - 1 + heroSlides.length) % heroSlides.length;
        showHeroSlide(heroCurrentSlide);
      }
      showHeroSlide(0);
      setInterval(heroSliderNext, 3000);
      window.heroSliderNext = heroSliderNext;
      window.heroSliderPrev = heroSliderPrev;

      // Mobile Hero Slider
      let mobileHeroCurrentSlide = 0;
      const mobileHeroSlides = document.querySelectorAll(".mobile-hero-slide");
      function showMobileHeroSlide(index) {
        mobileHeroSlides.forEach((slide, i) => {
          slide.style.opacity = i === index ? "1" : "0";
        });
      }
      function mobileHeroSliderNext() {
        mobileHeroCurrentSlide =
          (mobileHeroCurrentSlide + 1) % mobileHeroSlides.length;
        showMobileHeroSlide(mobileHeroCurrentSlide);
      }
      function mobileHeroSliderPrev() {
        mobileHeroCurrentSlide =
          (mobileHeroCurrentSlide - 1 + mobileHeroSlides.length) %
          mobileHeroSlides.length;
        showMobileHeroSlide(mobileHeroCurrentSlide);
      }
      if (mobileHeroSlides.length > 0) {
        showMobileHeroSlide(0);
        setInterval(mobileHeroSliderNext, 3000);
      }
      window.mobileHeroSliderNext = mobileHeroSliderNext;
      window.mobileHeroSliderPrev = mobileHeroSliderPrev;
    </script>
  <?php include __DIR__ . '/popup.php'; ?>
  </body>
</html>
