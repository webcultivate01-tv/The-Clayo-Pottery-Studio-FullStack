<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact & Book a Workshop – Clayo Pottery Studio | Amravati</title>
    <meta
      name="description"
      content="Contact Clayo Pottery Studio in Guruchhaya Colony, Amravati. Book a wheel-throwing class, enquire about ceramic workshops, or visit our studio. Open Tue–Sun 9 AM–7 PM."
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
              terracotta: "#c4673a",
              gold: "#b8935a",
              "gold-light": "#e8d5b7",
              charcoal: "#2c2118",
              clay: "#6b3d2a",
              muted: "#8a7a6a",
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
        color: #2c2118;
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

      /* STICKY HEADER */
      .sticky-header {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 9999;
        width: 100%;
      }
      #navbar {
        position: relative !important;
        top: auto !important;
        z-index: auto !important;
      }
      .navbar-scrolled {
        box-shadow: 0 4px 30px rgba(60, 30, 10, 0.1);
      }

      /* NAV LINKS */
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
        background: #c4673a;
        transition: width 0.3s;
        border-radius: 2px;
      }
      .nav-link:hover::after,
      .nav-link.active::after {
        width: 100%;
      }
      .nav-link:hover {
        color: #6b3d2a !important;
        background: transparent !important;
      }

      /* SCROLL REVEAL */
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
          opacity 0.65s ease,
          transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .reveal-scale.revealed {
        opacity: 1;
        transform: scale(1);
      }

      /* CARDS & BUTTONS */
      .card-hover {
        transition:
          transform 0.3s ease,
          box-shadow 0.3s ease;
      }
      .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(60, 30, 10, 0.12);
      }
      .section-tag {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #c4673a;
        background: #f5ede0;
        padding: 6px 18px;
        border-radius: 100px;
        margin-bottom: 14px;
        border: 1px solid rgba(196, 103, 58, 0.2);
      }
      .btn-primary {
        display: inline-block;
        background: #6b3d2a;
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
        background: #c4673a;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(107, 61, 42, 0.3);
      }
      .btn-outline {
        display: inline-block;
        border: 2px solid #6b3d2a;
        color: #6b3d2a;
        padding: 12px 30px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        transition: all 0.25s;
      }
      .btn-outline:hover {
        background: #6b3d2a;
        color: #faf6f0;
        transform: translateY(-2px);
      }

      /* HAMBURGER */
      .hamburger-bar {
        display: block;
        width: 24px;
        height: 2px;
        background: #6b3d2a;
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

      /* MOBILE DRAWER */
      .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(44, 33, 24, 0.45);
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
        width: 280px;
        max-width: 85vw;
        background: #fff;
        z-index: 99999 !important;
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: -8px 0 40px rgba(44, 33, 24, 0.18);
        overflow-y: auto;
        height: 100vh !important;
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
        background: #faf6f0;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b3d2a;
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
        color: #8a7a6a;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 4px;
      }
      .drawer-nav a:hover,
      .drawer-nav a.active {
        background: #f5ede0;
        color: #6b3d2a;
      }
      .drawer-nav a.active {
        font-weight: 600;
      }
      .drawer-nav a i {
        width: 18px;
        text-align: center;
        color: #c4673a;
      }
      .drawer-footer {
        padding: 16px;
        border-top: 1px solid #f0e6d8;
      }

      /* TOPBAR */
      .topbar {
        background: #6b3d2a;
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
      @media (max-width: 640px) {
        .topbar-inner {
          justify-content: center;
          padding: 0 16px;
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
      }

      /* FORM */
      .form-input {
        width: 100%;
        padding: 13px 16px;
        border: 1.5px solid #e8d5b7;
        border-radius: 12px;
        font-family: "Inter", sans-serif;
        font-size: 0.92rem;
        color: #2c2118;
        background: #faf6f0;
        outline: none;
        transition:
          border-color 0.2s,
          background 0.2s;
        appearance: none;
        -webkit-appearance: none;
      }
      .form-input:focus {
        border-color: #c4673a;
        background: white;
        box-shadow: 0 0 0 3px rgba(196, 103, 58, 0.12);
      }
      .form-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: #6b3d2a;
        margin-bottom: 7px;
        letter-spacing: 0.02em;
      }

      /* FAQ */
      .faq-item {
        border-radius: 14px;
        overflow: hidden;
      }
      .faq-btn {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        background: white;
        border: 1.5px solid #e8d5b7;
        border-radius: 14px;
        cursor: pointer;
        font-family: "Inter", sans-serif;
        font-size: 0.95rem;
        font-weight: 500;
        color: #2c2118;
        text-align: left;
        gap: 16px;
        transition: all 0.2s;
      }
      .faq-btn:hover,
      .faq-btn.open {
        border-color: #c4673a;
        background: #fdf9f4;
      }
      .faq-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f5ede0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition:
          transform 0.3s,
          background 0.2s;
        color: #6b3d2a;
      }
      .faq-btn.open .faq-icon {
        transform: rotate(45deg);
        background: #c4673a;
        color: white;
      }
      .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition:
          max-height 0.35s ease,
          padding 0.2s;
        padding: 0 24px;
        font-size: 0.9rem;
        color: #8a7a6a;
        line-height: 1.8;
        background: #fdf9f4;
        border: 1.5px solid transparent;
        border-top: none;
        border-radius: 0 0 14px 14px;
      }
      .faq-answer.open {
        max-height: 300px;
        padding-bottom: 18px;
        border-color: #c4673a;
        padding-top: 12px;
      }

      /* INFO ICON */
      .info-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }

      /* CTA */
      .cta-section {
        background: linear-gradient(
          135deg,
          #fdf6ee 0%,
          #f5ede0 50%,
          #edddd0 100%
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
          rgba(196, 103, 58, 0.15),
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
          rgba(184, 147, 90, 0.15),
          transparent
        );
        border-radius: 50%;
      }

      /* WHATSAPP */
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
        text-decoration: none;
      }
      .whatsapp-btn:hover {
        transform: scale(1.1);
      }

      /* SUCCESS POPUP */
      .success-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.2s ease;
      }
      .success-overlay.show {
        display: flex;
        opacity: 1;
      }
      .success-popup {
        background: #fff;
        border-radius: 20px;
        padding: 40px 32px 32px;
        max-width: 420px;
        width: 100%;
        text-align: center;
        position: relative;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
        transform: scale(0.92);
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
      }
      .success-overlay.show .success-popup {
        transform: scale(1);
      }
      .success-popup-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: none;
        background: #f1f5f9;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, color 0.15s;
      }
      .success-popup-close:hover {
        background: #e2e8f0;
        color: #0f172a;
      }
      .success-popup-icon {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: linear-gradient(135deg, #34d399, #10b981);
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
        animation: pop-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      }
      @keyframes pop-in {
        0%   { transform: scale(0); }
        100% { transform: scale(1); }
      }
      .success-popup h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px;
      }
      .success-popup p {
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0 0 22px;
      }
      .success-popup-btn {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s;
      }
      .success-popup-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
      }
      @keyframes spin { to { transform: rotate(360deg); } }

      /* MOBILE RESPONSIVE */
      @media (max-width: 1024px) {
        section {
          padding: 60px 24px !important;
        }
        .contact-main-grid {
          grid-template-columns: 1fr !important;
          gap: 48px !important;
        }
      }
      @media (max-width: 768px) {
        .max-w-6xl {
          padding-left: 20px !important;
          padding-right: 20px !important;
        }
        #navbar .h-20 {
          height: 60px;
        }
      }
      @media (max-width: 640px) {
        .hero-title {
          font-size: 2.2rem !important;
          line-height: 1.2 !important;
        }
        h2 {
          font-size: 1.6rem !important;
        }
        .quick-cards-grid {
          grid-template-columns: 1fr !important;
        }
        .contact-main-grid {
          grid-template-columns: 1fr !important;
          gap: 2rem !important;
        }
        .form-2col {
          grid-template-columns: 1fr !important;
        }
        .faq-btn {
          font-size: 0.88rem;
          padding: 14px 16px;
        }
        .faq-answer {
          padding: 0 16px;
        }
        .faq-answer.open {
          padding-bottom: 14px;
          padding-top: 10px;
        }
        .footer-grid {
          grid-template-columns: 1fr 1fr !important;
          gap: 2rem !important;
        }
        .py-24 {
          padding-top: 3.5rem !important;
          padding-bottom: 3.5rem !important;
        }
        .py-16 {
          padding-top: 3rem !important;
          padding-bottom: 3rem !important;
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
      }
      @media (max-width: 480px) {
        .footer-grid {
          grid-template-columns: 1fr !important;
        }
        .hero-title {
          font-size: 1.8rem !important;
        }
        h2 {
          font-size: 1.4rem !important;
        }
      }
    </style>
  </head>
  <body>
    <!-- STICKY HEADER WRAPPER -->
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
                class="nav-link text-sm font-medium text-muted transition-colors"
                >Gallery</a
              >
            </li>
            <li>
              <a
                href="contact.php"
                class="nav-link active text-sm font-medium text-brown transition-colors"
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
        <a href="gallery.php"><i class="fa-solid fa-images"></i> Gallery</a>
        <a href="contact.php" class="active"
          ><i class="fa-solid fa-envelope"></i> Contact</a
        >
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
        rgba(28, 18, 12, 0.60) 0%,
        rgba(52, 32, 20, 0.52) 45%,
        rgba(196, 103, 58, 0.18) 100%
      ),
      url('https://lh3.googleusercontent.com/p/AF1QipPMKTbob9-fvJ4X8FvkRdFVR4nWsmtCS0S4WonR=s1360-w1360-h1020-rw');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  "
>
  <!-- Soft Blur Overlay -->
  <div
    style="
      position:absolute;
      inset:0;
      z-index:0;
      backdrop-filter: blur(2px);
      background:
        radial-gradient(
          circle at top right,
          rgba(255,255,255,0.06),
          transparent 40%
        );
    "
  ></div>

  <!-- Decorative Glow -->
  <div
    style="
      position:absolute;
      width:420px;
      height:420px;
      border-radius:999px;
      background:rgba(232,192,128,0.08);
      filter:blur(90px);
      top:-120px;
      right:-100px;
      z-index:0;
    "
  ></div>

  <div
    style="
      position:absolute;
      width:320px;
      height:320px;
      border-radius:999px;
      background:rgba(255,255,255,0.04);
      filter:blur(80px);
      bottom:-120px;
      left:-80px;
      z-index:0;
    "
  ></div>

  <!-- Content -->
  <div
    class="max-w-3xl mx-auto px-6 text-center relative z-10 reveal"
    style="
      padding-top: 110px;
      padding-bottom: 80px;
      width: 100%;
    "
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
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        backdrop-filter: blur(12px);
        padding: 8px 18px;
        border-radius: 999px;
        margin-bottom: 18px;
      "
    >
      <i class="fa-solid fa-circle-dot"></i>
      Get in Touch
    </span>

    <!-- Heading -->
    <h1
      class="font-heading font-bold leading-tight hero-title mt-3 mb-5"
      style="
        color: #fff;
        font-size: clamp(2.6rem, 7vw, 5.5rem);
        line-height: 1.05;
        letter-spacing: -0.03em;
      "
    >
      Contact
      <span
        class="font-heading"
        style="
          color: #e8c080;
          text-shadow:
            0 0 18px rgba(232,192,128,0.16);
        "
      >
        the Studio
      </span>
    </h1>

    <!-- Description -->
    <p
      style="
        color: rgba(255,255,255,0.88);
        font-size: 1.03rem;
        line-height: 1.85;
        max-width: 620px;
        margin: 0 auto 2.2rem;
      "
    >
      Visit The Clayo Pottery Studio in Amravati to book immersive pottery
      workshops, handcrafted ceramic experiences, and creative clay sessions
      guided by expert artists.
    </p>

    <!-- Buttons -->
    <div class="flex flex-wrap gap-4 justify-center">
      <!-- Primary -->
      <a
        href="#bookingForm"
        class="btn-primary"
        style="
          box-shadow:
            0 12px 40px rgba(0,0,0,0.22);
        "
      >
        <i class="fa-solid fa-calendar-check mr-2"></i>
        Book a Workshop
      </a>

      <!-- Secondary -->
      <a
        href="#contact-info"
        style="
          display: inline-flex;
          align-items: center;
          justify-content: center;
          border: 1.5px solid rgba(255,255,255,0.28);
          background: rgba(255,255,255,0.06);
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
          this.style.background='rgba(255,255,255,0.14)';
          this.style.transform='translateY(-2px)';
        "
        onmouseout="
          this.style.background='rgba(255,255,255,0.06)';
          this.style.transform='translateY(0px)';
        "
      >
        Visit Our Studio
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

    <!-- QUICK CONTACT CARDS -->
    <section class="py-10 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-6 quick-cards-grid">
          <!-- Call -->
          <a
            href="tel:+9197247 88561"
            class="reveal bg-cream rounded-2xl p-6 border border-amber-100 card-hover flex items-center gap-4 group"
            style="background: #faf6f0; text-decoration: none"
          >
            <div
              class="w-14 h-14 rounded-2xl flex items-center justify-center transition-colors flex-shrink-0"
              style="background: #f5ede0"
              onmouseover="this.style.background = '#6b3d2a'"
              onmouseout="this.style.background = '#f5ede0'"
            >
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4 4.5C4 4.5 5.8 4 7.2 6.3C8.6 8.5 8 10 8 10L6.2 12.2C6.2 12.2 8 16 12 18L14.2 16.2C14.2 16.2 15.5 15.8 17.8 17.2C20.1 18.5 19.5 20.5 19.5 20.5C19.5 20.5 18.5 22.5 16 21.5C13.5 20.5 5.5 16 3 9.5C1.8 6.5 4 4.5 4 4.5Z"
                  stroke="#c4673a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <div>
              <div
                class="text-xs font-semibold uppercase tracking-widest mb-1"
                style="color: #c4673a"
              >
                Call Us
              </div>
              <div class="font-semibold" style="color: #6b3d2a">
                +91 97247 88561
              </div>
              <div class="text-xs" style="color: #8a7a6a">
                MOn–Sat, 9 AM – 7 PM
              </div>
            </div>
          </a>

          <!-- WhatsApp -->
          <a
            href="https://wa.me/919724788561"
            target="_blank"
            class="reveal bg-cream rounded-2xl p-6 border border-amber-100 card-hover flex items-center gap-4 group"
            style="
              background: #faf6f0;
              text-decoration: none;
              transition-delay: 0.1s;
            "
          >
            <div
              class="w-14 h-14 rounded-2xl flex items-center justify-center transition-colors flex-shrink-0"
              style="background: #f5ede0"
            >
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                  d="M12 2C6.477 2 2 6.477 2 12C2 13.776 2.474 15.441 3.293 16.877L2 22L7.293 20.744C8.695 21.538 10.296 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z"
                  stroke="#c4673a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
                <path
                  d="M9 9.5C9 9.5 8.5 11 10 13C11.5 15 13.5 16 13.5 16L15 14.5C15 14.5 16 14.8 17 15.5C18 16.2 17.5 17 17.5 17C17.5 17 16.5 18.5 14 17C11.5 15.5 9 12 9 10.5C9 10.5 8.8 9.5 9 9.5Z"
                  stroke="#c4673a"
                  stroke-width="1.5"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <div>
              <div
                class="text-xs font-semibold uppercase tracking-widest mb-1"
                style="color: #c4673a"
              >
                WhatsApp
              </div>
              <div class="font-semibold" style="color: #6b3d2a">
                Chat Instantly
              </div>
              <div class="text-xs" style="color: #8a7a6a">
                Quick replies within minutes
              </div>
            </div>
          </a>

          <!-- Email -->
          <a
            href="mailto:info@theclayo.com"
            class="reveal bg-cream rounded-2xl p-6 border border-amber-100 card-hover flex items-center gap-4 group"
            style="
              background: #faf6f0;
              text-decoration: none;
              transition-delay: 0.2s;
            "
          >
            <div
              class="w-14 h-14 rounded-2xl flex items-center justify-center transition-colors flex-shrink-0"
              style="background: #f5ede0"
            >
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect
                  x="2"
                  y="5"
                  width="20"
                  height="14"
                  rx="3"
                  stroke="#c4673a"
                  stroke-width="1.8"
                />
                <path
                  d="M2 8.5L10.5 13.5C11.4 14.1 12.6 14.1 13.5 13.5L22 8.5"
                  stroke="#c4673a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <div>
              <div
                class="text-xs font-semibold uppercase tracking-widest mb-1"
                style="color: #c4673a"
              >
                Email Us
              </div>
              <div class="font-semibold" style="color: #6b3d2a">
                info@theclayo.com
              </div>
              <div class="text-xs" style="color: #8a7a6a">
                We reply within 24 hours
              </div>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- CONTACT MAIN SECTION -->
    <section id="bookingForm" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-10 items-start contact-main-grid">
          <!-- INFO SIDE -->
          <div class="reveal-left">
            <span class="section-tag">Visit Our Studio</span>
            <h2
              class="font-heading text-3xl font-bold mt-3 mb-4"
              style="color: #2c2118"
            >
              Studio
              <span class="font-heading" style="color: #c4673a"
                >Information</span
              >
            </h2>
            <p style="color: #8a7a6a" class="leading-relaxed mb-8">
              Whether you want to join a weekend wheel-throwing class,
              commission a custom piece, or simply explore the studio, we'd love
              to see you. Walk-ins welcome based on availability.
            </p>

            <div class="flex flex-col gap-6 mb-10">
              <!-- Address -->
              <div class="flex gap-4 items-start">
                <div class="info-icon-box" style="background: #f5ede0">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path
                      d="M11 2C7.686 2 5 4.686 5 8C5 12.5 11 20 11 20C11 20 17 12.5 17 8C17 4.686 14.314 2 11 2Z"
                      stroke="#c4673a"
                      stroke-width="1.8"
                      stroke-linejoin="round"
                    />
                    <circle
                      cx="11"
                      cy="8"
                      r="2.5"
                      stroke="#c4673a"
                      stroke-width="1.6"
                    />
                  </svg>
                </div>
                <div>
                  <strong
                    class="block font-heading text-base font-semibold mb-1"
                    style="color: #6b3d2a"
                    >Studio Location</strong
                  >
                  <p class="text-sm leading-relaxed" style="color: #8a7a6a">
                    64, Akoli Rd, Usha Colony, Guruchhaya Colony, Sai Nagar,
                    Amravati, Maharashtra 444607
                  </p>
                  <a
                    href="https://maps.google.com/?q=Guruchhaya+Colony+Amravati"
                    target="_blank"
                    class="text-xs font-semibold mt-1 inline-block transition-colors"
                    style="color: #c4673a"
                  >
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i
                    >Get Directions
                  </a>
                </div>
              </div>

              <!-- Phone -->
              <div class="flex gap-4 items-start">
                <div class="info-icon-box" style="background: #f5ede0">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path
                      d="M3.5 3.5C3.5 3.5 5.3 3 6.7 5.3C8.1 7.5 7.5 9 7.5 9L5.7 11.2C5.7 11.2 7.5 15 11.5 17L13.7 15.2C13.7 15.2 15 14.8 17.3 16.2C19.6 17.5 19 19.5 19 19.5C19 19.5 18 21.5 15.5 20.5C13 19.5 5 15 2.5 8.5C1.3 5.5 3.5 3.5 3.5 3.5Z"
                      stroke="#c4673a"
                      stroke-width="1.8"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
                <div>
                  <strong
                    class="block font-heading text-base font-semibold mb-1"
                    style="color: #6b3d2a"
                    >Phone & WhatsApp</strong
                  >
                  <p class="text-sm" style="color: #8a7a6a">
                    +91 97247 88561<br />
                  </p>
                </div>
              </div>

              <!-- Email -->
              <div class="flex gap-4 items-start">
                <div class="info-icon-box" style="background: #f5ede0">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <rect
                      x="2"
                      y="5"
                      width="18"
                      height="12"
                      rx="2.5"
                      stroke="#c4673a"
                      stroke-width="1.8"
                    />
                    <path
                      d="M2 8L9.5 12.5C10.4 13.1 11.6 13.1 12.5 12.5L20 8"
                      stroke="#c4673a"
                      stroke-width="1.8"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
                <div>
                  <strong
                    class="block font-heading text-base font-semibold mb-1"
                    style="color: #6b3d2a"
                    >Email</strong
                  >
                  <p class="text-sm" style="color: #8a7a6a">
                    info@theclayo.com<br />
                  </p>
                </div>
              </div>

              <!-- Hours -->
              <div class="flex gap-4 items-start">
                <div class="info-icon-box" style="background: #f5ede0">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <circle
                      cx="11"
                      cy="11"
                      r="8.5"
                      stroke="#c4673a"
                      stroke-width="1.8"
                    />
                    <path
                      d="M11 6.5V11.5L14.5 14"
                      stroke="#c4673a"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
                <div>
                  <strong
                    class="block font-heading text-base font-semibold mb-1"
                    style="color: #6b3d2a"
                    >Studio Hours</strong
                  >
                  <p class="text-sm" style="color: #8a7a6a">
                    Monday – Saturday: 10:00 AM – 7:00 PM<br />Sunday: Closed
                  </p>
                </div>
              </div>
            </div>

            <!-- Social Links -->
            <div class="mb-8">
              <h4
                class="font-heading text-base font-semibold mb-4"
                style="color: #6b3d2a"
              >
                Follow Our Journey
              </h4>
              <div class="flex gap-3 flex-wrap">
                <a
                  href="https://www.instagram.com/theclayo/"
                  class="flex items-center gap-2 border text-sm px-4 py-2 rounded-full font-medium transition-all"
                  style="
                    background: #faf6f0;
                    border-color: #e8d5b7;
                    color: #6b3d2a;
                  "
                  onmouseover="
                    this.style.background = '#6b3d2a';
                    this.style.color = '#faf6f0';
                    this.style.borderColor = '#6b3d2a';
                  "
                  onmouseout="
                    this.style.background = '#faf6f0';
                    this.style.color = '#6b3d2a';
                    this.style.borderColor = '#e8d5b7';
                  "
                >
                  <i class="fa-brands fa-instagram text-sm"></i> Instagram
                </a>
                <a
                  href="https://www.facebook.com/theclayo"
                  class="flex items-center gap-2 border text-sm px-4 py-2 rounded-full font-medium transition-all"
                  style="
                    background: #faf6f0;
                    border-color: #e8d5b7;
                    color: #6b3d2a;
                  "
                  onmouseover="
                    this.style.background = '#6b3d2a';
                    this.style.color = '#faf6f0';
                    this.style.borderColor = '#6b3d2a';
                  "
                  onmouseout="
                    this.style.background = '#faf6f0';
                    this.style.color = '#6b3d2a';
                    this.style.borderColor = '#e8d5b7';
                  "
                >
                  <i class="fa-brands fa-facebook-f text-sm"></i> Facebook
                </a>
                <a
                  href="#"
                  class="flex items-center gap-2 border text-sm px-4 py-2 rounded-full font-medium transition-all"
                  style="
                    background: #faf6f0;
                    border-color: #e8d5b7;
                    color: #6b3d2a;
                  "
                  onmouseover="
                    this.style.background = '#6b3d2a';
                    this.style.color = '#faf6f0';
                    this.style.borderColor = '#6b3d2a';
                  "
                  onmouseout="
                    this.style.background = '#faf6f0';
                    this.style.color = '#6b3d2a';
                    this.style.borderColor = '#e8d5b7';
                  "
                >
                  <i class="fa-brands fa-youtube text-sm"></i> YouTube
                </a>
              </div>
            </div>

            <!-- Map Placeholder -->
            <div
              class="rounded-2xl overflow-hidden border border-amber-100 h-56 relative shadow-lg"
              style="
                background: linear-gradient(135deg, #f5ede0, #edddd0, #e0cdb8);
              "
            >
              <!-- Google Map -->
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.4458578153994!2d77.74083107471083!3d20.894374392381753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd6bb5cfb4e9265%3A0xa8c88df580f3a4b4!2sThe%20Clayo%20Pottery%20Studio!5e0!3m2!1sen!2sin!4v1778490497740!5m2!1sen!2sin"
                width="100%"
                height="100%"
                style="border: 0; filter: saturate(0.9) contrast(1.02)"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>

              <!-- Overlay Card -->
              <div
                class="absolute bottom-4 left-4 right-4 bg-white/85 backdrop-blur-md rounded-2xl p-4 border border-white/40 shadow-xl"
              >
                <div class="flex items-start gap-4">
                  <!-- Icon -->
                  <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: #6b3d2a"
                  >
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                      <path
                        d="M12 2C8.134 2 5 5.134 5 9C5 13.5 12 22 12 22C12 22 19 13.5 19 9C19 5.134 15.866 2 12 2Z"
                        stroke="white"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                      />
                      <circle
                        cx="12"
                        cy="9"
                        r="2.8"
                        stroke="white"
                        stroke-width="1.6"
                      />
                    </svg>
                  </div>

                  <!-- Content -->
                  <div class="flex-1">
                    <h4
                      class="font-heading text-base font-semibold mb-1"
                      style="color: #6b3d2a"
                    >
                      Clayo Pottery Studio
                    </h4>

                    <p
                      class="text-xs mb-3 leading-relaxed"
                      style="color: #8a7a6a"
                    >
                      Guruchhaya Colony, Amravati, Maharashtra
                    </p>

                    <a
                      href="https://maps.google.com/?q=The+Clayo+Pottery+Studio+Amravati"
                      target="_blank"
                      class="inline-flex items-center gap-2 text-sm font-medium"
                      style="color: #6b3d2a"
                    >
                      <svg
                        width="14"
                        height="14"
                        viewBox="0 0 18 18"
                        fill="none"
                      >
                        <path
                          d="M9 1C5.686 1 3 3.686 3 7C3 11.5 9 17 9 17C9 17 15 11.5 15 7C15 3.686 12.314 1 9 1Z"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linejoin="round"
                        />
                        <circle
                          cx="9"
                          cy="7"
                          r="2"
                          stroke="currentColor"
                          stroke-width="1.4"
                        />
                      </svg>

                      Open in Google Maps
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- FORM SIDE -->
          <div id="formFields">
            <!-- Full Name -->
            <div class="mb-4">
              <label class="form-label">
                Full Name
                <span style="color: #e87040">*</span>
              </label>

              <input
                type="text"
                id="fname"
                class="form-input"
                placeholder="Your full name"
              />
            </div>

            <!-- Phone + Email -->
            <div class="grid grid-cols-2 gap-3 mb-4 form-2col">
              <!-- Phone -->
              <div>
                <label class="form-label">
                  Phone
                  <span style="color: #e87040">*</span>
                </label>

                <input
                  type="tel"
                  id="fphone"
                  class="form-input"
                  placeholder="+91 XXXXX XXXXX"
                />
              </div>

              <!-- Email -->
              <div>
                <label class="form-label">Email</label>

                <input
                  type="email"
                  id="femail"
                  class="form-input"
                  placeholder="you@email.com"
                />
              </div>
            </div>

            <!-- Date of Birth -->
            <div class="mb-4">
              <label class="form-label">
                Date of Birth
                <span style="color: #e87040">*</span>
              </label>

              <input type="date" id="fdob" class="form-input" />
            </div>

            <!-- Address -->
            <div class="mb-4">
              <label class="form-label">
                Address
                <span style="color: #e87040">*</span>
              </label>

              <textarea
                id="faddress"
                class="form-input"
                rows="3"
                placeholder="Enter your full address"
              ></textarea>
            </div>

            <!-- Workshop -->
            <div class="mb-4">
              <label class="form-label">
                Workshop / Service
                <span style="color: #e87040">*</span>
              </label>

              <select id="fservice" class="form-input">
                <option value="">Select a workshop or service...</option>

                <optgroup label="Pottery Workshops">
                  <option>Beginner Wheel Throwing Class</option>
                  <option>Intermediate Wheel Throwing</option>
                  <option>Advanced Throwing & Trimming</option>
                  <option>Hand-Building (Coil & Slab)</option>
                  <option>Kids Pottery Camp (Age 7–14)</option>
                  <option>Corporate Team Workshop</option>
                  <option>Couples Pottery Experience</option>
                  <option>Weekend Intensive (2 Days)</option>
                </optgroup>

                <optgroup label="Studio Services">
                  <option>Custom Ceramic Piece Order</option>
                  <option>Open Studio Access</option>
                  <option>Kiln Firing Service</option>
                  <option>Private Tuition (1-on-1)</option>
                  <option>Birthday / Event Package</option>
                  <option>General Enquiry</option>
                </optgroup>
              </select>
            </div>

            <!-- Preferred Date + Time -->
            <!-- Preferred Date + Time -->
            <div class="grid grid-cols-2 gap-3 mb-4 form-2col">
              <!-- Date -->
              <div>
                <label class="form-label">
                  Preferred Date
                  <span style="color: #e87040">*</span>
                </label>

                <input type="date" id="fdate" class="form-input" required />
              </div>

              <!-- Time -->
              <div>
                <label class="form-label">
                  Preferred Time
                  <span style="color: #e87040">*</span>
                </label>

                <select id="ftime" class="form-input" required>
                  <option value="">Select Time</option>

                  <option>9:00 AM</option>
                  <option>10:00 AM</option>
                  <option>11:00 AM</option>
                  <option>12:00 PM</option>
                  <option>2:00 PM</option>
                  <option>3:00 PM</option>
                  <option>4:00 PM</option>
                  <option>5:00 PM</option>
                  <option>6:00 PM</option>
                </select>
              </div>
            </div>

            <!-- Message -->
            <div class="mb-5">
              <label class="form-label"> Message / Special Requests </label>

              <textarea
                id="fmessage"
                class="form-input"
                rows="3"
                placeholder="Any experience level, allergies, special requests or questions about the studio..."
              ></textarea>
            </div>

            <!-- Checkbox -->
            <div class="flex items-start gap-3 mb-5">
              <input
                type="checkbox"
                id="fagree"
                class="mt-1 w-4 h-4 flex-shrink-0"
                style="accent-color: #6b3d2a"
              />

              <label
                for="fagree"
                class="text-xs leading-relaxed"
                style="color: #8a7a6a"
              >
                I agree to be contacted by Clayo Pottery Studio via
                phone/WhatsApp to confirm my booking. I understand this is a
                reservation request and not a confirmed seat until validated by
                the studio.
              </label>
            </div>

            <!-- Submit -->
            <button
              onclick="submitForm()"
              class="btn-primary w-full text-center text-base py-4 flex items-center justify-center gap-2"
            >
              <svg width="17" height="17" viewBox="0 0 22 22" fill="none">
                <rect
                  x="3"
                  y="2"
                  width="16"
                  height="18"
                  rx="3"
                  stroke="currentColor"
                  stroke-width="1.8"
                />

                <path
                  d="M7 7H15M7 11H15M7 15H11"
                  stroke="currentColor"
                  stroke-width="1.8"
                  stroke-linecap="round"
                />
              </svg>

              Reserve My Seat
            </button>

            <!-- Security -->
            <p
              class="text-xs text-center mt-4 flex items-center justify-center gap-1"
              style="color: #8a7a6a"
            >
              <svg width="12" height="12" viewBox="0 0 18 18" fill="none">
                <rect
                  x="4"
                  y="8"
                  width="10"
                  height="8"
                  rx="2"
                  stroke="#8a7a6a"
                  stroke-width="1.4"
                />

                <path
                  d="M6 8V6C6 4.343 7.343 3 9 3C10.657 3 12 4.343 12 6V8"
                  stroke="#8a7a6a"
                  stroke-width="1.4"
                  stroke-linecap="round"
                />
              </svg>

              Your information is secure and will never be shared.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-24" style="background: #faf6f0">
      <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-14 reveal">
          <span class="section-tag">Common Questions</span>
          <h2
            class="font-heading text-4xl font-bold mt-3 mb-4"
            style="color: #2c2118"
          >
            Frequently Asked
            <span class="font-heading" style="color: #c4673a">Questions</span>
          </h2>
          <p style="color: #8a7a6a" class="max-w-lg mx-auto">
            Everything you need to know before your first workshop.
          </p>
        </div>
        <div class="flex flex-col gap-3">
          <div class="faq-item reveal">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>Do I need any prior experience to join a workshop?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Not at all! Our Beginner Wheel Throwing and Hand-Building classes
              are specifically designed for complete beginners. Our instructors
              guide you step by step — from centring the clay to shaping your
              first vessel. All materials, tools, and aprons are provided. Just
              bring an open mind and a willingness to get your hands dirty!
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.05s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>Is the first trial class really free?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Yes! Your first introductory pottery session is completely free of
              charge. It's a 60-minute experience where you'll get on the wheel,
              feel the clay, and discover whether pottery is for you — no
              commitment required. Spaces for free trial slots are limited, so
              we recommend booking at least 3–4 days in advance.
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.1s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>How many sessions does a course typically run?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Our standard beginner course runs over 6 weekly sessions of 2
              hours each. Advanced courses and intensive weekend workshops are
              also available. Each session builds on the last — by the end of a
              full course, you'll have thrown, trimmed, and glazed your own
              pieces, which are then kiln-fired and ready for collection.
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.15s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>What happens to the pieces I make?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Every piece you create goes through a bisque firing in our
              electric kiln, followed by glazing (your choice of colours) and a
              final glaze firing. The whole process takes 7–10 days. Once ready,
              we'll notify you via WhatsApp and your pieces can be picked up
              from the studio or arranged for local delivery in Amravati.
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.2s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>Are workshops suitable for children?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Absolutely! We run dedicated Kids Pottery Camps for ages 7–14,
              with age-appropriate projects and patient instructors. For
              children under 10, a parent or guardian is welcome to participate
              alongside. We also offer special birthday pottery party packages —
              contact us for custom pricing and availability.
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.25s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>Do you offer corporate or group bookings?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Yes! Our Corporate Team Workshop is a popular team-building
              experience — groups of 8–20 people can book the full studio for a
              private 3-hour session. We've hosted companies, college groups,
              and family reunions. Custom packages, including materials,
              instructor, refreshments, and branded keepsakes, are available.
              Reach out for a tailored quote.
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.3s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span>What should I wear to a pottery class?</span>
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Wear clothes you don't mind getting clay on — pottery is
              wonderfully messy! We provide studio aprons and disposable gloves
              if needed. Avoid wearing jewellery on your hands and wrists.
              Closed-toe shoes are recommended. The studio is well-ventilated
              and maintained at a comfortable temperature year-round.
            </div>
          </div>

          <div class="faq-item reveal" style="transition-delay: 0.35s">
            <button class="faq-btn" onclick="toggleFaq(this)">
              <span
                >Can I order custom ceramic pieces without joining a
                class?</span
              >
              <span class="faq-icon text-sm"
                ><i class="fa-solid fa-plus"></i
              ></span>
            </button>
            <div class="faq-answer">
              Of course! Our studio artisans accept custom ceramic commissions —
              from dinner sets and planters to personalised gifts and home
              décor. Simply describe your vision, reference images, dimensions,
              and glaze preferences, and we'll provide a quote with an estimated
              lead time (typically 3–4 weeks). Contact us via WhatsApp or email
              to start your commission.
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section py-24">
      <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
        <span class="section-tag">Start Creating</span>
        <h2
          class="font-heading text-4xl lg:text-5xl font-bold mt-4 mb-5 leading-tight"
          style="color: #2c2118"
        >
          Come Shape Something
          <span class="font-heading" style="color: #c4673a">Beautiful</span>
        </h2>
        <p
          class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed"
          style="color: #8a7a6a"
        >
          Call us, WhatsApp us, or book your seat online. Our studio in Amravati
          is ready to welcome you into the timeless world of hand-crafted
          pottery — one lump of clay at a time.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a
            href="tel:+919724788561"
            class="btn-primary text-base px-8 py-4 flex items-center gap-2"
          >
            <svg width="18" height="18" viewBox="0 0 22 22" fill="none">
              <path
                d="M3.5 3.5C3.5 3.5 5.3 3 6.7 5.3C8.1 7.5 7.5 9 7.5 9L5.7 11.2C5.7 11.2 7.5 15 11.5 17L13.7 15.2C13.7 15.2 15 14.8 17.3 16.2C19.6 17.5 19 19.5 19 19.5C19 19.5 18 21.5 15.5 20.5C13 19.5 5 15 2.5 8.5C1.3 5.5 3.5 3.5 3.5 3.5Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
              />
            </svg>
            Call: +91 97247 88561
          </a>
          <a
            href="https://wa.me/919724788561"
            target="_blank"
            class="flex items-center gap-2 text-white text-base font-semibold px-8 py-4 rounded-full transition-colors"
            style="background: #6b3d2a"
            onmouseover="this.style.background = '#c4673a'"
            onmouseout="this.style.background = '#6b3d2a'"
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path
                d="M12 2C6.477 2 2 6.477 2 12C2 13.776 2.474 15.441 3.293 16.877L2 22L7.293 20.744C8.695 21.538 10.296 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linejoin="round"
              />
              <path
                d="M9 9.5C9 9.5 8.5 11 10 13C11.5 15 13.5 16 13.5 16L15 14.5C15 14.5 16 14.8 17 15.5C18 16.2 17.5 17 17.5 17C17.5 17 16.5 18.5 14 17C11.5 15.5 9 12 9 10.5C9 10.5 8.8 9.5 9 9.5Z"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linejoin="round"
              />
            </svg>
            WhatsApp Us
          </a>
        </div>
        <div
          class="flex items-center justify-center gap-8 mt-10 text-sm flex-wrap"
          style="color: #8a7a6a"
        >
          <div class="flex items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
              <circle
                cx="10"
                cy="10"
                r="8.5"
                stroke="#c4673a"
                stroke-width="1.6"
              />
              <path
                d="M6.5 10L8.8 12.3L13.5 7.5"
                stroke="#c4673a"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            Free Trial Class
          </div>
          <div class="flex items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
              <circle
                cx="10"
                cy="10"
                r="8.5"
                stroke="#c4673a"
                stroke-width="1.6"
              />
              <path
                d="M6.5 10L8.8 12.3L13.5 7.5"
                stroke="#c4673a"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            All Materials Included
          </div>
          <div class="flex items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
              <circle
                cx="10"
                cy="10"
                r="8.5"
                stroke="#c4673a"
                stroke-width="1.6"
              />
              <path
                d="M6.5 10L8.8 12.3L13.5 7.5"
                stroke="#c4673a"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            Expert Instructors
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

    <!-- WHATSAPP FAB -->
    <a href="https://wa.me/919724788561" target="_blank" class="whatsapp-btn">
      <i class="fa-brands fa-whatsapp text-white text-2xl"></i>
    </a>

    <!-- BOOKING SUCCESS POPUP -->
    <div id="successOverlay" class="success-overlay" role="dialog" aria-modal="true" aria-labelledby="successTitle">
      <div class="success-popup">
        <button type="button" class="success-popup-close" onclick="closeSuccessPopup()" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="success-popup-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h3 id="successTitle">Booking Successful</h3>
        <p>We've received your booking request. Our team will contact you on WhatsApp/phone shortly to confirm your seat.</p>
        <button type="button" class="success-popup-btn" onclick="closeSuccessPopup()">Done</button>
      </div>
    </div>

    <script>
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
      const drawerBookBtn = document.getElementById("drawerBookBtn");

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

      hamburger.addEventListener("click", () =>
        drawer.classList.contains("open") ? closeDrawer() : openDrawer(),
      );
      drawerClose.addEventListener("click", closeDrawer);
      overlay.addEventListener("click", closeDrawer);
      drawer
        .querySelectorAll("a")
        .forEach((a) => a.addEventListener("click", closeDrawer));
      if (drawerBookBtn) drawerBookBtn.addEventListener("click", closeDrawer);

      // FAQ Accordion
      function toggleFaq(btn) {
        const answer = btn.nextElementSibling;
        const isOpen = btn.classList.contains("open");
        document.querySelectorAll(".faq-btn.open").forEach((q) => {
          q.classList.remove("open");
          q.nextElementSibling.classList.remove("open");
        });
        if (!isOpen) {
          btn.classList.add("open");
          answer.classList.add("open");
        }
      }
      window.toggleFaq = toggleFaq;

      // Prefill service from ?service=... (set when arriving from the Enroll
      // button on services.php). Selects a matching option, or prepends one
      // when no match exists so any admin-added item is honoured.
      (function prefillServiceFromQuery() {
        const params = new URLSearchParams(window.location.search);
        const requested = (params.get('service') || '').trim();
        if (!requested) return;

        const select = document.getElementById('fservice');
        if (!select) return;

        const wanted = requested.toLowerCase();
        let matched = null;
        for (const opt of select.options) {
          if (opt.value && opt.text.trim().toLowerCase() === wanted) {
            matched = opt;
            break;
          }
        }

        if (matched) {
          select.value = matched.value || matched.text;
        } else {
          const opt = document.createElement('option');
          opt.text = requested;
          opt.value = requested;
          opt.selected = true;
          const firstGroup = select.querySelector('optgroup');
          if (firstGroup) {
            select.insertBefore(opt, firstGroup);
          } else {
            select.appendChild(opt);
          }
          select.value = requested;
        }

        const target = document.getElementById('bookingForm');
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      })();

      // Form Submit
      async function submitForm() {
        const name    = document.getElementById("fname").value.trim();
        const phone   = document.getElementById("fphone").value.trim();
        const service = document.getElementById("fservice").value;
        const pdate   = document.getElementById("fdate").value;
        const ptime   = document.getElementById("ftime").value;
        const agree   = document.getElementById("fagree").checked;

        if (!name)    { alert("Please enter your full name."); return; }
        if (!phone)   { alert("Please enter your phone number."); return; }
        if (!service) { alert("Please select a workshop or service."); return; }
        if (!pdate)   { alert("Please select your preferred date."); return; }
        if (!ptime)   { alert("Please select your preferred time."); return; }
        if (!agree)   { alert("Please agree to our contact terms to proceed."); return; }

        const btn = document.querySelector('[onclick="submitForm()"]');
        const origHTML = btn.innerHTML;
        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="animation:spin 0.8s linear infinite;display:inline-block;margin-right:6px"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5" stroke-dasharray="42" stroke-dashoffset="14" stroke-linecap="round"/></svg> Sending…';
        btn.disabled = true;

        try {
          const res = await fetch('./booking-submit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              customer_name:  name,
              phone:          phone,
              email:          document.getElementById("femail").value.trim(),
              dob:            document.getElementById("fdob").value,
              address:        document.getElementById("faddress").value.trim(),
              service:        service,
              preferred_date: pdate,
              preferred_time: ptime,
              message:        document.getElementById("fmessage").value.trim(),
            }),
          });

          const data = await res.json();
          if (data.ok) {
            openSuccessPopup();
            ["fname","fphone","femail","fdob","faddress","fservice","fdate","ftime","fmessage"].forEach(id => {
              const el = document.getElementById(id);
              if (el) el.value = "";
            });
            const agreeEl = document.getElementById("fagree");
            if (agreeEl) agreeEl.checked = false;
            btn.innerHTML = origHTML;
            btn.disabled = false;
          } else {
            alert(data.message || "Something went wrong. Please try again.");
            btn.innerHTML = origHTML;
            btn.disabled = false;
          }
        } catch (err) {
          alert("Could not connect to the server. Please call us directly at +91 97247 88561.");
          btn.innerHTML = origHTML;
          btn.disabled = false;
        }
      }
      window.submitForm = submitForm;

      // Success popup controls
      function openSuccessPopup() {
        const overlay = document.getElementById("successOverlay");
        overlay.classList.add("show");
        document.body.style.overflow = "hidden";
      }
      function closeSuccessPopup() {
        const overlay = document.getElementById("successOverlay");
        overlay.classList.remove("show");
        document.body.style.overflow = "";
      }
      window.closeSuccessPopup = closeSuccessPopup;
      document.getElementById("successOverlay").addEventListener("click", (e) => {
        if (e.target.id === "successOverlay") closeSuccessPopup();
      });
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeSuccessPopup();
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
        { threshold: 0.07, rootMargin: "0px 0px -30px 0px" },
      );
      document
        .querySelectorAll(".reveal, .reveal-left, .reveal-right, .reveal-scale")
        .forEach((el) => revealObs.observe(el));
    </script>
  <?php include __DIR__ . '/popup.php'; ?>
  </body>
</html>
