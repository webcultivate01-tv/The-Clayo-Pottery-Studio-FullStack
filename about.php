<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      About Us – The Clayo Pottery Studio | Our Story & Expert Team | Amravati
    </title>
    <meta
      name="description"
      content="Learn about The Clayo Pottery Studio's journey, our master potters, and our commitment to handcrafted ceramics and immersive pottery workshops in Amravati."
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
      *,
      *::before,
      *::after {
        box-sizing: border-box;
      }
      html {
        overflow-x: hidden;
      }
      body {
        font-family: "Inter", sans-serif;
        background-color: #faf7f2;
        color: #2c2420;
        overflow-x: hidden;
      }
      h1,
      h2,
      h3,
      h4 {
        font-family: "Playfair Display", serif;
      }
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
      .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition:
          opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
          transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .reveal.revealed {
        opacity: 1;
        transform: translateY(0);
      }
      .reveal-left {
        opacity: 0;
        transform: translateX(-50px);
        transition:
          opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
          transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .reveal-left.revealed {
        opacity: 1;
        transform: translateX(0);
      }
      .reveal-right {
        opacity: 0;
        transform: translateX(50px);
        transition:
          opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1),
          transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
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
          transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .reveal-scale.revealed {
        opacity: 1;
        transform: scale(1);
      }
      .section-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.73rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #b8935a;
        background: #e8d5b7;
        padding: 6px 18px;
        border-radius: 100px;
        margin-bottom: 14px;
      }
      .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #5c3d2e;
        color: #faf7f2;
        padding: 14px 32px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        font-family: "Inter", sans-serif;
        letter-spacing: 0.03em;
        transition: all 0.28s;
        text-decoration: none;
      }
      .btn-primary:hover {
        background: #b8935a;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(92, 61, 46, 0.35);
      }
      .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 2px solid #5c3d2e;
        color: #5c3d2e;
        padding: 12px 30px;
        border-radius: 100px;
        font-size: 0.92rem;
        font-weight: 500;
        transition: all 0.28s;
        text-decoration: none;
      }
      .btn-outline:hover {
        background: #5c3d2e;
        color: #faf7f2;
        transform: translateY(-2px);
      }
      .card-hover {
        transition:
          transform 0.3s ease,
          box-shadow 0.3s ease;
      }
      .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(80, 40, 20, 0.14);
      }
      .story-img {
        overflow: hidden;
        border-radius: 28px;
      }
      .story-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
        display: block;
      }
      .story-img:hover img {
        transform: scale(1.04);
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
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.45);
        transition: transform 0.2s;
      }
      .whatsapp-btn:hover {
        transform: scale(1.12);
      }
      .award-card {
        border-left: 3px solid #b8935a;
      }
      .pillar-num {
        font-family: "Playfair Display", serif;
        font-size: 2.8rem;
        font-weight: 700;
        color: #e8d5b7;
        line-height: 1;
      }
      .stat-num {
        font-family: "Playfair Display", serif;
        font-size: 2.4rem;
        font-weight: 700;
        color: #b8935a;
        line-height: 1;
      }
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
        top: -80px;
        left: -80px;
        width: 350px;
        height: 350px;
        background: radial-gradient(
          circle,
          rgba(184, 147, 90, 0.18),
          transparent
        );
        border-radius: 50%;
      }
      .cta-section::after {
        content: "";
        position: absolute;
        bottom: -60px;
        right: -60px;
        width: 280px;
        height: 280px;
        background: radial-gradient(
          circle,
          rgba(193, 101, 74, 0.12),
          transparent
        );
        border-radius: 50%;
      }
      .hero-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
      }
      @media (max-width: 640px) {
        .hero-title {
          font-size: 2.2rem !important;
          line-height: 1.2 !important;
        }
        .section-h2 {
          font-size: 1.6rem !important;
          line-height: 1.3 !important;
        }
        .stat-num {
          font-size: 1.9rem;
        }
        .pillar-num {
          font-size: 2rem;
        }
        section {
          padding: 50px 20px !important;
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
          width: 100%;
          text-align: center;
          justify-content: center;
        }
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
      }
      @media (max-width: 768px) {
        .topbar {
          font-size: 0.72rem;
          padding: 6px 0;
        }
        .story-img {
          height: 280px !important;
        }
        .grid.lg\:grid-cols-2 {
          grid-template-columns: 1fr !important;
        }
        .grid.md\:grid-cols-2 {
          grid-template-columns: 1fr !important;
        }
   .grid.lg\:grid-cols-4 {
  grid-template-columns: 1fr !important;
}
        .absolute.-bottom-5,
        .absolute.top-6 {
          display: none !important;
        }
      }
      @media (max-width: 1024px) {
        .grid.lg\:grid-cols-2 {
          grid-template-columns: 1fr !important;
          gap: 40px !important;
        }
        section {
          padding: 60px 24px !important;
        }
      }
      @media (max-width: 480px) {
        .topbar {
          display: none;
        }
        .hero-title {
          font-size: 1.8rem !important;
        }
        .section-h2 {
          font-size: 1.4rem !important;
        }
        .btn-primary,
        .btn-outline {
          padding: 12px 20px;
          font-size: 0.85rem;
        }
      }
      /* Cert slider mobile */
      @media (max-width: 768px) {
        .cert-slider {
          display: flex !important;
          overflow-x: auto;
          scroll-snap-type: x mandatory;
          gap: 16px;
          padding-bottom: 20px;
          -webkit-overflow-scrolling: touch;
          scrollbar-width: thin;
          scrollbar-color: #b8935a #f5ede6;
        }
        .cert-slider::-webkit-scrollbar {
          height: 6px;
        }
        .cert-slider::-webkit-scrollbar-track {
          background: #f5ede6;
          border-radius: 10px;
        }
        .cert-slider::-webkit-scrollbar-thumb {
          background: #b8935a;
          border-radius: 10px;
        }
        .cert-item {
          display: block !important;
          min-width: 160px;
          flex-shrink: 0;
          scroll-snap-align: start;
        }
      }
      section {
        overflow-x: hidden;
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
                class="nav-link active text-sm font-medium text-brown transition-colors"
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
        <div class="flex items-center gap-2">
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
 
        </div>
        <button class="drawer-close" id="drawerClose">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <nav class="drawer-nav">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about.php" class="active"
          ><i class="fa-solid fa-circle-info"></i> About</a
        >
        <a href="services.php"
          ><i class="fa-solid fa-fire-flame-curved"></i> Workshops</a
        >
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
  class="relative pt-16 pb-20 overflow-hidden"
  style="
    background: linear-gradient(
      135deg,
      #faf7f2 0%,
      #f5ede6 60%,
      #ede0d4 100%
    );
  "
>
  <!-- Background Blobs -->
  <div
    class="hero-blob"
    style="
      width: 420px;
      height: 420px;
      background: rgba(184, 147, 90, 0.12);
      top: -120px;
      right: -80px;
    "
  ></div>

  <div
    class="hero-blob"
    style="
      width: 300px;
      height: 300px;
      background: rgba(193, 101, 74, 0.08);
      bottom: -60px;
      left: -60px;
    "
  ></div>

  <div
    class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center relative z-10"
  >
    <!-- LEFT CONTENT -->
    <div class="reveal">
      <span class="section-tag">
        <i class="fa-solid fa-circle-dot"></i>
        Our Story
      </span>

      <h1
        class="hero-title font-heading font-bold text-charcoal leading-tight mt-3 mb-6"
        style="font-size: 3.5rem"
      >
        About
        <span class="text-gold font-heading">Clayo</span>
        <br />
        Pottery Studio
      </h1>

<p class="text-muted text-lg leading-relaxed mb-4">
  The Clayo Pottery Studio in Amravati is a creative space for pottery,
  ceramics, and handcrafted clay experiences designed for beginners and artists
  alike.
</p>

<p class="text-muted leading-relaxed mb-8">
  Since 2017, we’ve helped students across Amravati discover the art of pottery
  through immersive workshops and premium ceramic training.
</p>
      <div class="flex gap-4 flex-wrap">
        <a href="contact.php" class="btn-primary">
          <i class="fa-regular fa-calendar-check"></i>
          Book a Workshop
        </a>

        <a href="services.php" class="btn-outline">
          Our Workshops
        </a>
      </div>
    </div>

    <!-- RIGHT IMAGE SLIDER -->
    <div
      class="reveal-right relative"
      style="transition-delay: 0.15s"
    >
      <!-- Slider Container -->
      <div
        class="relative overflow-hidden shadow-2xl"
        style="
          height: 480px;
          border-radius: 32px;
          transform: rotate(-2deg);
          box-shadow:
            0 40px 100px rgba(0,0,0,0.12),
            0 10px 40px rgba(184,145,42,0.08);
        "
      >
        <!-- Grain Texture -->
        <div
          style="
            position:absolute;
            inset:0;
            opacity:0.04;
            z-index:3;
            pointer-events:none;
            background-image:url('https://www.transparenttextures.com/patterns/noise.png');
          "
        ></div>

        <!-- Slides -->
        <div
          id="aboutSlider"
          class="relative w-full h-full"
        >
          <!-- Slide 1 -->
          <div
            class="about-slide active"
            style="
              position:absolute;
              inset:0;
              opacity:1;
              transition:opacity 0.8s ease;
            "
          >
            <img
              src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGJktboAfwbGLOBWSxrFXPQeEJ1Pc3anKv2dkYDbs16CQ3yclvhMxWDmsfvIWsNeG2nSgU1O5hXb9ZowrhY0uR_SfzAsSm1Z32kHUp4i76GNkxuKrQTfORQc-LIXIKEYKXVAUEA34EjVrwk=s1360-w1360-h1020-rw"
              alt="Pottery Studio"
              loading="eager"
              style="
                width:100%;
                height:100%;
                object-fit:cover;
                filter:saturate(0.92) contrast(1.03);
              "
            />

            <div
              style="
                position:absolute;
                inset:0;
                background:
                  linear-gradient(
                    to top,
                    rgba(0,0,0,0.25),
                    rgba(0,0,0,0.04)
                  );
              "
            ></div>
          </div>

          <!-- Slide 2 -->
          <div
            class="about-slide"
            style="
              position:absolute;
              inset:0;
              opacity:0;
              transition:opacity 0.8s ease;
            "
          >
            <img
              src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAHJNU35qY3KrrpZlzCVbau_fqNdXj6p9kUAfyoKSRBmvhyikNs1IBo489S90GQqNnR6WEdtM8XMTH-Y6FWrOO9xiCfVG4RXcaQoebTnJkaTpBnVIVksi8IE3ULa-VrMu4FgsSuHh3TiE3U=s1360-w1360-h1020-rw"
              alt="Clay Workshop"
              style="
                width:100%;
                height:100%;
                object-fit:cover;
                filter:saturate(0.92) contrast(1.03);
              "
            />

            <div
              style="
                position:absolute;
                inset:0;
                background:
                  linear-gradient(
                    to top,
                    rgba(0,0,0,0.25),
                    rgba(0,0,0,0.04)
                  );
              "
            ></div>
          </div>

          <!-- Slide 3 -->
          <div
            class="about-slide"
            style="
              position:absolute;
              inset:0;
              opacity:0;
              transition:opacity 0.8s ease;
            "
          >
            <img
              src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAG99aSQ5ZuIpYIJEfs1ADjHKmLZZ3yhhH-RLYkITkgLS6sKZn6uNkw_1J1Q5t8bdl0gsC-Db0Rci8u8NVJCrkVznTd2g37tJiKOnMDhGAWOsNHbqy3Q5Jj4LXBSWkXJQfEZMG9q_-eICDZL=s1360-w1360-h1020-rw"
              alt="Handmade Pottery"
              style="
                width:100%;
                height:100%;
                object-fit:cover;
                filter:saturate(0.92) contrast(1.03);
              "
            />

            <div
              style="
                position:absolute;
                inset:0;
                background:
                  linear-gradient(
                    to top,
                    rgba(0,0,0,0.25),
                    rgba(0,0,0,0.04)
                  );
              "
            ></div>
          </div>
        </div>

        <!-- Prev Button -->
        <button
          onclick="aboutPrevSlide()"
          style="
            position:absolute;
            left:18px;
            top:50%;
            transform:translateY(-50%);
            width:52px;
            height:52px;
            border-radius:50%;
            
            
            
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            z-index:15;
  
            transition:all 0.35s ease;
          "
        >
          <i
            class="fa-solid fa-chevron-left"
            style="color:#7a6759;font-size:15px"
          ></i>
        </button>

        <!-- Next Button -->
        <button
          onclick="aboutNextSlide()"
          style="
            position:absolute;
            right:18px;
            top:50%;
            transform:translateY(-50%);
            width:52px;
            height:52px;
            border-radius:50%;
          
          
    
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            z-index:15;
    
            transition:all 0.35s ease;
          "
        >
          <i
            class="fa-solid fa-chevron-right"
            style="color:#7a6759;font-size:15px"
          ></i>
        </button>

        <!-- Pagination -->
        <div
          class="absolute bottom-6 left-1/2 flex gap-3"
          style="transform:translateX(-50%);z-index:15"
        >
          <button
            class="about-dot active"
            onclick="goToAboutSlide(0)"
          ></button>

          <button
            class="about-dot"
            onclick="goToAboutSlide(1)"
          ></button>

          <button
            class="about-dot"
            onclick="goToAboutSlide(2)"
          ></button>
        </div>
      </div>

      <!-- Floating Card -->
      <div
        class="absolute -bottom-5 -left-5 bg-white rounded-2xl px-5 py-4 shadow-xl border border-amber-100 hidden lg:flex items-center gap-3"
        style="
          z-index: 20;
          background: rgba(255,255,255,0.72);
          backdrop-filter: blur(20px);
          border: 1px solid rgba(255,255,255,0.35);
          box-shadow:
            0 20px 60px rgba(0,0,0,0.08);
        "
      >
        <div
          class="w-10 h-10 rounded-xl flex items-center justify-center"
          style="
            background:linear-gradient(135deg,#c9a86a,#b8912a);
          "
        >
          <i class="fa-solid fa-star text-white"></i>
        </div>

        <div>
          <div class="text-xs text-muted font-medium">
            Studio Rating
          </div>

          <div
            style="font-family:'Playfair Display',serif"
            class="text-brown font-semibold text-lg"
          >
            4.9 / 5.0
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .about-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    background: rgba(255,255,255,0.5);
    transition: all 0.35s ease;
  }

  .about-dot.active {
    width: 30px;
    background: #ffffff;
  }
</style>

<script>
  let aboutIndex = 0;

  const aboutSlides =
    document.querySelectorAll(".about-slide");

  const aboutDots =
    document.querySelectorAll(".about-dot");

  function updateAboutSlider() {
    aboutSlides.forEach((slide, index) => {
      slide.style.opacity =
        index === aboutIndex ? "1" : "0";
    });

    aboutDots.forEach((dot) =>
      dot.classList.remove("active")
    );

    aboutDots[aboutIndex].classList.add("active");
  }

  function aboutNextSlide() {
    aboutIndex = (aboutIndex + 1) % aboutSlides.length;
    updateAboutSlider();
  }

  function aboutPrevSlide() {
    aboutIndex =
      (aboutIndex - 1 + aboutSlides.length) %
      aboutSlides.length;

    updateAboutSlider();
  }

  function goToAboutSlide(index) {
    aboutIndex = index;
    updateAboutSlider();
  }

  setInterval(() => {
    aboutNextSlide();
  }, 2000);
</script>

    <!-- STATS BAND -->
    <section class="py-10 bg-brown">
      <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div class="reveal">
            <div class="stat-num mb-1" data-target="1">0</div>
            <div
              class="text-white/60 text-xs font-medium uppercase tracking-widest"
            >
              Years in Craft
            </div>
          </div>
          <div class="reveal" style="transition-delay: 0.1s">
            <div class="stat-num mb-1" data-target="1000">0</div>
            <div
              class="text-white/60 text-xs font-medium uppercase tracking-widest"
            >
              Students Trained
            </div>
          </div>
          <div class="reveal" style="transition-delay: 0.2s">
            <div class="stat-num mb-1" data-target="10">0</div>
            <div
              class="text-white/60 text-xs font-medium uppercase tracking-widest"
            >
              Workshop Types
            </div>
          </div>
          <div class="reveal" style="transition-delay: 0.3s">
            <div class="stat-num mb-1" data-target="95">0</div>
            <div
              class="text-white/60 text-xs font-medium uppercase tracking-widest"
            >
              Satisfaction Rate
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- STORY SECTION -->
    <section class="py-24 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="reveal-left">
            <div class="relative story-img shadow-xl" style="height: 520px">
              <img
                src="https://lh3.googleusercontent.com/p/AF1QipORz5d_Wk17UiOJjMgt7JkBIXMlo-x5KcL_0neF=s1360-w1360-h1020-rw"
                alt="Priya's pottery journey"
                loading="lazy"
              />
            </div>
            <div
              class="absolute top-6 -right-4 bg-brown text-white rounded-2xl px-5 py-4 shadow-xl hidden lg:block"
              style="z-index: 10"
            >
              <div
                style="font-family: &quot;Playfair Display&quot;, serif"
                class="text-4xl font-bold text-gold"
              >
                2025
              </div>
              <div class="text-xs text-white/70 mt-1">Year Founded</div>
            </div>
          </div>
          <div class="reveal-right" style="transition-delay: 0.15s">
            <span class="section-tag">Our Journey</span>
            <h2
              class="section-h2 font-heading font-bold text-charcoal mt-3 mb-6 leading-tight"
              style="font-size: 2.5rem"
            >
              1 Years of
              <span class="text-gold font-heading">Shaping</span> Clay &
              Community
            </h2>
            <p class="text-muted leading-relaxed mb-5">
              Founded in 2017 by Priya Deshmukh, Clayo Pottery Studio was born
              from a simple belief — that everyone has a maker within them,
              waiting to be awakened through clay. What began as weekend
              wheel-throwing classes in a small rented space has blossomed into
              Amravati's most celebrated ceramic arts studio.
            </p>
            <p class="text-muted leading-relaxed mb-8">
              We blend traditional pottery techniques with modern design
              sensibility. No two pots are ever alike, and neither are our
              students. We listen first, teach second — always meeting you where
              you are in your creative journey.
            </p>
            <div class="flex flex-col gap-6">
              <div class="flex gap-5 items-start">
                <div class="pillar-num flex-shrink-0">01</div>
                <div>
                  <strong class="block text-brown font-semibold mb-1"
                    >Student First, Always</strong
                  >
                  <p class="text-sm text-muted">
                    Your comfort, progress and creative confidence are our only
                    priority. We never rush — we guide, encourage and celebrate
                    every milestone.
                  </p>
                </div>
              </div>
              <div class="flex gap-5 items-start">
                <div class="pillar-num flex-shrink-0">02</div>
                <div>
                  <strong class="block text-brown font-semibold mb-1"
                    >Traditional Craft, Modern Space</strong
                  >
                  <p class="text-sm text-muted">
                    Ancient techniques meet a clean, well-equipped studio with
                    professional-grade wheels, kilns and a warm, inspiring
                    atmosphere.
                  </p>
                </div>
              </div>
              <div class="flex gap-5 items-start">
                <div class="pillar-num flex-shrink-0">03</div>
                <div>
                  <strong class="block text-brown font-semibold mb-1"
                    >Community & Creativity</strong
                  >
                  <p class="text-sm text-muted">
                    Clayo is more than a studio — it's a creative community.
                    Events, open studio days and exhibitions bring our potters
                    together throughout the year.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- TEAM SECTION -->
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

    <!-- VALUES -->
    <section class="py-24 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
          <span class="section-tag">What We Believe</span>
          <h2
            class="font-heading font-bold text-charcoal mt-3 mb-4 section-h2"
            style="font-size: 2.6rem"
          >
            Our Core <span class="text-gold font-heading">Values</span>
          </h2>
          <p class="text-muted max-w-lg mx-auto">
            These principles guide every workshop, every firing, and every
            relationship we build with our creative community.
          </p>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div
            class="reveal reveal-scale bg-cream rounded-2xl p-7 text-center border border-amber-100 card-hover"
          >
            <div
              class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4"
            >
              <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                <path
                  d="M13 2L15.5 9H23L17 13.5L19.5 20.5L13 16L6.5 20.5L9 13.5L3 9H10.5L13 2Z"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-3">
              Craftsmanship
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              We celebrate the imperfect, handmade quality of pottery — every
              fingerprint tells a story and every vessel holds the maker's
              spirit.
            </p>
          </div>
          <div
            class="reveal reveal-scale bg-cream rounded-2xl p-7 text-center border border-amber-100 card-hover"
            style="transition-delay: 0.1s"
          >
            <div
              class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4"
            >
              <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                <path
                  d="M13 2L4 6V13C4 18 8.5 22.5 13 24C17.5 22.5 22 18 22 13V6L13 2Z"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
                <path
                  d="M9 13L11.5 15.5L17 10"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-3">
              Safety First
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Food-safe glazes only. Lead-free, non-toxic materials throughout.
              A clean, well-ventilated studio environment for everyone.
            </p>
          </div>
          <div
            class="reveal reveal-scale bg-cream rounded-2xl p-7 text-center border border-amber-100 card-hover"
            style="transition-delay: 0.2s"
          >
            <div
              class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4"
            >
              <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                <path
                  d="M13 22V12"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linecap="round"
                />
                <path
                  d="M13 12C13 12 8 11 6 6C10 5 14 7 13 12Z"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
                <path
                  d="M13 16C13 16 18 14 20 9C16 8 12 10 13 16Z"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
                <path
                  d="M9 22H17"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linecap="round"
                />
              </svg>
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-3">
              Sustainability
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Local clay sourcing, water recycling, and energy-efficient kilns.
              Pottery by nature is earth-friendly — we keep it that way.
            </p>
          </div>
          <div
            class="reveal reveal-scale bg-cream rounded-2xl p-7 text-center border border-amber-100 card-hover"
            style="transition-delay: 0.3s"
          >
            <div
              class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4"
            >
              <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                <path
                  d="M13 5C13 5 9 8 9 13C9 16 11 18 13 18C15 18 17 16 17 13C17 8 13 5 13 5Z"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linejoin="round"
                />
                <path
                  d="M13 18V22"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linecap="round"
                />
              </svg>
            </div>
            <h4 class="font-heading text-lg font-semibold text-brown mb-3">
              Mindfulness
            </h4>
            <p class="text-sm text-muted leading-relaxed">
              Clay demands your full presence. We create a calm, phone-free zone
              where creativity and mindfulness naturally go hand in hand.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- AWARDS & CERTIFICATIONS -->
    <section class="py-20 bg-cream">
      <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12 reveal">
          <span class="section-tag">Recognition</span>
          <h2
            class="font-heading font-bold text-charcoal mt-3 mb-4 section-h2"
            style="font-size: 2.6rem"
          >
            Awards & <span class="text-gold font-heading">Milestones</span>
          </h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6 mb-10">
          <div
            class="reveal bg-white rounded-2xl p-6 border border-amber-100 card-hover award-card"
          >
            <div class="flex items-start gap-4">
              <div
                class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0"
              >
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M12 2L14.2 8.4H21L15.4 12.2L17.6 18.6L12 14.8L6.4 18.6L8.6 12.2L3 8.4H9.8L12 2Z"
                    stroke="#b8935a"
                    stroke-width="1.8"
                    stroke-linejoin="round"
                  />
                </svg>
              </div>
              <div>
                <h4 class="font-heading text-lg font-semibold text-brown mb-1">
                  Best Studio – Vidarbha 2023
                </h4>
                <p class="text-xs text-muted leading-relaxed">
                  Recognised by the Maharashtra Craft Council for excellence in
                  ceramic arts education and community building.
                </p>
              </div>
            </div>
          </div>
          <div
            class="reveal bg-white rounded-2xl p-6 border border-amber-100 card-hover award-card"
            style="transition-delay: 0.1s"
          >
            <div class="flex items-start gap-4">
              <div
                class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0"
              >
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <circle
                    cx="12"
                    cy="10"
                    r="6"
                    stroke="#b8935a"
                    stroke-width="1.8"
                  />
                  <path
                    d="M8.5 10L11 12.5L15.5 8"
                    stroke="#b8935a"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M8 16L6 22L12 20L18 22L16 16"
                    stroke="#b8935a"
                    stroke-width="1.8"
                    stroke-linejoin="round"
                  />
                </svg>
              </div>
              <div>
                <h4 class="font-heading text-lg font-semibold text-brown mb-1">
                  10000+ Students Trained
                </h4>
                <p class="text-xs text-muted leading-relaxed">
                  From absolute beginners to professional ceramic artists — our
                  community spans all ages and skill levels across Maharashtra.
                </p>
              </div>
            </div>
          </div>
          <div
            class="reveal bg-white rounded-2xl p-6 border border-amber-100 card-hover award-card"
            style="transition-delay: 0.2s"
          >
            <div class="flex items-start gap-4">
              <div
                class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0"
              >
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <rect
                    x="3"
                    y="3"
                    width="18"
                    height="14"
                    rx="3"
                    stroke="#b8935a"
                    stroke-width="1.8"
                  />
                  <path
                    d="M7 21H17"
                    stroke="#b8935a"
                    stroke-width="1.8"
                    stroke-linecap="round"
                  />
                  <path
                    d="M12 17V21"
                    stroke="#b8935a"
                    stroke-width="1.8"
                    stroke-linecap="round"
                  />
                  <path
                    d="M8 9L10.5 11.5L16 7"
                    stroke="#b8935a"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </div>
              <div>
                <h4 class="font-heading text-lg font-semibold text-brown mb-1">
                  Food-Safe Certified Studio
                </h4>
                <p class="text-xs text-muted leading-relaxed">
                  All our glazes and materials are certified food-safe and
                  lead-free, audited annually for student safety and quality
                  assurance.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Cert strip -->
        <div class="reveal">
          <p
            class="text-center text-xs font-semibold text-muted uppercase tracking-widest mb-6"
          >
            Our Recognitions
          </p>
          <div
            class="cert-slider grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4"
          >
            <div
              class="cert-item bg-white rounded-2xl border border-amber-100 overflow-hidden shadow-sm card-hover flex flex-col items-center justify-center p-4 text-center"
              style="aspect-ratio: 3/4"
            >
              <svg
                width="48"
                height="48"
                viewBox="0 0 48 48"
                fill="none"
                class="mb-3"
              >
                <rect
                  x="4"
                  y="4"
                  width="40"
                  height="40"
                  rx="6"
                  fill="#fdf5ea"
                  stroke="#e8d5b7"
                  stroke-width="1.5"
                />
                <path
                  d="M24 10L28 18H37L30 23L33 31L24 26L15 31L18 23L11 18H20L24 10Z"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linejoin="round"
                />
                <path
                  d="M20 38H28"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linecap="round"
                />
              </svg>
              <p class="text-xs font-semibold text-brown leading-tight">
                Best Studio
              </p>
              <p class="text-xs text-muted mt-0.5">Vidarbha 2023</p>
            </div>
            <div
              class="cert-item bg-white rounded-2xl border border-amber-100 overflow-hidden shadow-sm card-hover flex flex-col items-center justify-center p-4 text-center"
              style="aspect-ratio: 3/4"
            >
              <svg
                width="48"
                height="48"
                viewBox="0 0 48 48"
                fill="none"
                class="mb-3"
              >
                <rect
                  x="4"
                  y="4"
                  width="40"
                  height="40"
                  rx="6"
                  fill="#fdf5ea"
                  stroke="#e8d5b7"
                  stroke-width="1.5"
                />
                <path
                  d="M24 10L16 14V24C16 29 19.5 33.5 24 35C28.5 33.5 32 29 32 24V14L24 10Z"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linejoin="round"
                />
                <path
                  d="M20 23L23 26L28 21"
                  stroke="#b8935a"
                  stroke-width="1.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              <p class="text-xs font-semibold text-brown leading-tight">
                Food Safe
              </p>
              <p class="text-xs text-muted mt-0.5">Certified Glazes</p>
            </div>
            <div
              class="cert-item bg-white rounded-2xl border border-amber-100 overflow-hidden shadow-sm card-hover flex flex-col items-center justify-center p-4 text-center"
              style="aspect-ratio: 3/4"
            >
              <svg
                width="48"
                height="48"
                viewBox="0 0 48 48"
                fill="none"
                class="mb-3"
              >
                <rect
                  x="4"
                  y="4"
                  width="40"
                  height="40"
                  rx="6"
                  fill="#fdf5ea"
                  stroke="#e8d5b7"
                  stroke-width="1.5"
                />
                <rect
                  x="10"
                  y="10"
                  width="28"
                  height="20"
                  rx="3"
                  stroke="#b8935a"
                  stroke-width="1.4"
                />
                <path
                  d="M14 16H34M14 20H28"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linecap="round"
                />
                <circle
                  cx="24"
                  cy="35"
                  r="4"
                  stroke="#b8935a"
                  stroke-width="1.4"
                />
                <path
                  d="M21 35L23 37L27 33"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              <p class="text-xs font-semibold text-brown leading-tight">
                NID Trained
              </p>
              <p class="text-xs text-muted mt-0.5">Master Potter</p>
            </div>
            <div
              class="cert-item bg-white rounded-2xl border border-amber-100 overflow-hidden shadow-sm card-hover flex flex-col items-center justify-center p-4 text-center"
              style="aspect-ratio: 3/4"
            >
              <svg
                width="48"
                height="48"
                viewBox="0 0 48 48"
                fill="none"
                class="mb-3"
              >
                <rect
                  x="4"
                  y="4"
                  width="40"
                  height="40"
                  rx="6"
                  fill="#fdf5ea"
                  stroke="#e8d5b7"
                  stroke-width="1.5"
                />
                <circle
                  cx="24"
                  cy="20"
                  r="7"
                  stroke="#b8935a"
                  stroke-width="1.4"
                />
                <path
                  d="M20 35H28M24 27V35"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linecap="round"
                />
                <path
                  d="M21 20L23.5 22.5L28 18"
                  stroke="#b8935a"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              <p class="text-xs font-semibold text-brown leading-tight">
                3,500+
              </p>
              <p class="text-xs text-muted mt-0.5">Students</p>
            </div>
            <div
              class="cert-item bg-white rounded-2xl border border-amber-100 overflow-hidden shadow-sm card-hover flex flex-col items-center justify-center p-4 text-center"
              style="aspect-ratio: 3/4"
            >
              <svg
                width="48"
                height="48"
                viewBox="0 0 48 48"
                fill="none"
                class="mb-3"
              >
                <rect
                  x="4"
                  y="4"
                  width="40"
                  height="40"
                  rx="6"
                  fill="#fdf5ea"
                  stroke="#e8d5b7"
                  stroke-width="1.5"
                />
                <path
                  d="M24 14C24 14 18 19 18 25C18 28.3 20.7 31 24 31C27.3 31 30 28.3 30 25C30 19 24 14 24 14Z"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linejoin="round"
                />
                <path
                  d="M24 31V36M20 38H28"
                  stroke="#b8935a"
                  stroke-width="1.4"
                  stroke-linecap="round"
                />
              </svg>
              <p class="text-xs font-semibold text-brown leading-tight">
                Kiln Fired
              </p>
              <p class="text-xs text-muted mt-0.5">Premium Studio</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- WHY CHOOSE US -->
<section class="py-24 bg-white overflow-hidden">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      
      <!-- LEFT CONTENT -->
      <div class="reveal-left">
        <span class="section-tag">Why Clayo</span>

        <h2
          class="font-heading font-bold text-charcoal mt-3 mb-6 leading-tight section-h2"
          style="font-size: 2.5rem"
        >
          What Makes Us
          <span class="text-gold font-heading">Different</span>
        </h2>

        <div class="flex flex-col gap-5">
          <!-- Card 1 -->
          <div
            class="flex items-start gap-4 p-5 bg-cream rounded-2xl border border-amber-100 card-hover"
          >
            <div
              class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0"
            >
              <i class="fa-solid fa-users text-gold text-lg"></i>
            </div>

            <div>
              <h4
                class="font-heading text-base font-semibold text-brown mb-1"
              >
                Intimate Small-Batch Classes
              </h4>

              <p class="text-sm text-muted leading-relaxed">
                Maximum 8 students per class — you get real hands-on guidance,
                not just a demo watched from the back.
              </p>
            </div>
          </div>

          <!-- Card 2 -->
          <div
            class="flex items-start gap-4 p-5 bg-cream rounded-2xl border border-amber-100 card-hover"
          >
            <div
              class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0"
            >
              <i
                class="fa-solid fa-fire-flame-curved text-gold text-lg"
              ></i>
            </div>

            <div>
              <h4
                class="font-heading text-base font-semibold text-brown mb-1"
              >
                Full Kiln Firing Included
              </h4>

              <p class="text-sm text-muted leading-relaxed">
                Your workshop fee includes bisque firing and glaze firing for
                beautifully finished ceramics.
              </p>
            </div>
          </div>

          <!-- Card 3 -->
          <div
            class="flex items-start gap-4 p-5 bg-cream rounded-2xl border border-amber-100 card-hover"
          >
            <div
              class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0"
            >
              <i class="fa-solid fa-clock text-blue-500 text-lg"></i>
            </div>

            <div>
              <h4
                class="font-heading text-base font-semibold text-brown mb-1"
              >
                Flexible Scheduling
              </h4>

              <p class="text-sm text-muted leading-relaxed">
                Weekday, weekend and evening sessions available for every kind
                of learner and creator.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT IMAGE SLIDER -->
      <div
        class="reveal-right relative"
        style="transition-delay: 0.15s"
      >
        <!-- Soft Glow -->
        <div
          style="
            position:absolute;
            width:320px;
            height:320px;
            background:#d8c2a8;
            filter:blur(120px);
            opacity:0.18;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            z-index:-1;
          "
        ></div>

        <!-- Slider Wrapper -->
        <div
          class="relative overflow-hidden shadow-xl"
          style="
            height: 500px;
            border-radius: 32px;
            transform: rotate(-2deg);
            box-shadow:
              0 40px 100px rgba(0,0,0,0.12),
              0 10px 40px rgba(184,145,42,0.08);
          "
        >
          <!-- Grain Texture -->
          <div
            style="
              position:absolute;
              inset:0;
              opacity:0.04;
              z-index:3;
              pointer-events:none;
              background-image:url('https://www.transparenttextures.com/patterns/noise.png');
            "
          ></div>

          <!-- Slides -->
          <div
            id="whySlider"
            class="relative w-full h-full"
          >
            <!-- Slide 1 -->
            <div
              class="why-slide active"
              style="
                position:absolute;
                inset:0;
                opacity:1;
                transition:opacity 0.8s ease;
              "
            >
              <img
                src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGJktboAfwbGLOBWSxrFXPQeEJ1Pc3anKv2dkYDbs16CQ3yclvhMxWDmsfvIWsNeG2nSgU1O5hXb9ZowrhY0uR_SfzAsSm1Z32kHUp4i76GNkxuKrQTfORQc-LIXIKEYKXVAUEA34EjVrwk=s1360-w1360-h1020-rw"
                alt="Studio pottery"
                loading="lazy"
                style="
                  width:100%;
                  height:100%;
                  object-fit:cover;
                  filter:saturate(0.92) contrast(1.03);
                "
              />

              <div
                style="
                  position:absolute;
                  inset:0;
                  background:
                    linear-gradient(
                      to top,
                      rgba(0,0,0,0.28),
                      rgba(0,0,0,0.04)
                    );
                "
              ></div>
            </div>

            <!-- Slide 2 -->
            <div
              class="why-slide"
              style="
                position:absolute;
                inset:0;
                opacity:0;
                transition:opacity 0.8s ease;
              "
            >
              <img
                src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAEuCdpowxDHI6m0z3APLXdCgnBlJZ8yQ-FEpLmm6J7G6lFytOV77WN3gGTLYA-6TVQloMusbl8USNj75J7FpCaUlekV5tY6kPE5RyXJ28UsBELoVZ5PpDcFQeEzv66vHuRtPWvHgIjrTRip=s1360-w1360-h1020-rw"
                alt="Clay workshop"
                style="
                  width:100%;
                  height:100%;
                  object-fit:cover;
                  filter:saturate(0.92) contrast(1.03);
                "
              />

              <div
                style="
                  position:absolute;
                  inset:0;
                  background:
                    linear-gradient(
                      to top,
                      rgba(0,0,0,0.28),
                      rgba(0,0,0,0.04)
                    );
                "
              ></div>
            </div>

            <!-- Slide 3 -->
            <div
              class="why-slide"
              style="
                position:absolute;
                inset:0;
                opacity:0;
                transition:opacity 0.8s ease;
              "
            >
              <img
                src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAGnUSqxWRraUx35X9fFTndUlcLMaLlh4g3ntZBGa4xtZir2FAdU6gSyICNYZtxVdalLMp8aYf96cEGzrzzEm3Ahg4rdIPt1oudnP72kofPhOlMv3kT3aS_nJ6lnnTlSi-Ui3qhLmzH4HS3r=s1360-w1360-h1020-rw""
                alt="Pottery artist"
                style="
                  width:100%;
                  height:100%;
                  object-fit:cover;
                  filter:saturate(0.92) contrast(1.03);
                "
              />

              <div
                style="
                  position:absolute;
                  inset:0;
                  background:
                    linear-gradient(
                      to top,
                      rgba(0,0,0,0.28),
                      rgba(0,0,0,0.04)
                    );
                "
              ></div>
            </div>
          </div>

          <!-- Prev -->
          <button
            onclick="whyPrevSlide()"
            style="
              position:absolute;
              left:18px;
              top:50%;
              transform:translateY(-50%);
              width:52px;
              height:52px;
              border-radius:50%;
              background:rgba(255,255,255,0.72);
              backdrop-filter:blur(20px);
              border:1px solid rgba(255,255,255,0.35);
              display:flex;
              align-items:center;
              justify-content:center;
              cursor:pointer;
              z-index:15;
              box-shadow:
                0 10px 40px rgba(0,0,0,0.08);
            "
          >
            <i
              class="fa-solid fa-chevron-left"
              style="color:#7a6759;font-size:15px"
            ></i>
          </button>

          <!-- Next -->
          <button
            onclick="whyNextSlide()"
            style="
              position:absolute;
              right:18px;
              top:50%;
              transform:translateY(-50%);
              width:52px;
              height:52px;
              border-radius:50%;
              background:rgba(255,255,255,0.72);
              backdrop-filter:blur(20px);
              border:1px solid rgba(255,255,255,0.35);
              display:flex;
              align-items:center;
              justify-content:center;
              cursor:pointer;
              z-index:15;
              box-shadow:
                0 10px 40px rgba(0,0,0,0.08);
            "
          >
            <i
              class="fa-solid fa-chevron-right"
              style="color:#7a6759;font-size:15px"
            ></i>
          </button>

          <!-- Pagination -->
          <div
            class="absolute bottom-6 left-1/2 flex gap-3"
            style="transform:translateX(-50%);z-index:15"
          >
            <button
              class="why-dot active"
              onclick="goToWhySlide(0)"
            ></button>

            <button
              class="why-dot"
              onclick="goToWhySlide(1)"
            ></button>

            <button
              class="why-dot"
              onclick="goToWhySlide(2)"
            ></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .why-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    background: rgba(255,255,255,0.5);
    transition: all 0.35s ease;
  }

  .why-dot.active {
    width: 30px;
    background: #ffffff;
  }
</style>

<script>
  let whyIndex = 0;

  const whySlides =
    document.querySelectorAll(".why-slide");

  const whyDots =
    document.querySelectorAll(".why-dot");

  function updateWhySlider() {
    whySlides.forEach((slide, index) => {
      slide.style.opacity =
        index === whyIndex ? "1" : "0";
    });

    whyDots.forEach((dot) =>
      dot.classList.remove("active")
    );

    whyDots[whyIndex].classList.add("active");
  }

  function whyNextSlide() {
    whyIndex = (whyIndex + 1) % whySlides.length;
    updateWhySlider();
  }

  function whyPrevSlide() {
    whyIndex =
      (whyIndex - 1 + whySlides.length) %
      whySlides.length;

    updateWhySlider();
  }

  function goToWhySlide(index) {
    whyIndex = index;
    updateWhySlider();
  }

  setInterval(() => {
    whyNextSlide();
  }, 2000);
</script>

    <!-- TESTIMONIALS STRIP -->
    <section class="py-16 bg-brown overflow-hidden">
      <div class="max-w-6xl mx-auto px-6 text-center reveal">
        <p class="font-heading text-2xl text-white mb-2">
          Trusted by <span class="text-gold">1000+</span> happy potters across
          Amravati & Vidarbha
        </p>
        <p class="text-white/60 text-sm mt-2">
          Join our growing creative community and discover the joy of making
          with clay
        </p>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-section py-24 relative">
      <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <span class="section-tag reveal">Start Today</span>
        <h2
          class="font-heading font-bold text-charcoal mt-4 mb-5 leading-tight reveal section-h2"
          style="font-size: 2.8rem"
        >
          Let Us Guide Your
          <span class="text-gold font-heading">Clay Journey</span>
        </h2>
        <p
          class="text-muted text-lg mb-8 max-w-2xl mx-auto leading-relaxed reveal"
        >
          Book a workshop and discover your personalized pottery journey with
          our expert ceramic artists. Your first handmade piece is waiting to be
          born.
        </p>
        <div class="flex flex-wrap gap-4 justify-center reveal">
          <a href="contact.php" class="btn-primary text-base px-8 py-4"
            ><i class="fa-regular fa-calendar-check"></i>Book a Workshop</a
          >
          <a href="tel:+919724788561" class="btn-outline text-base px-8 py-4"
            ><i class="fa-solid fa-phone"></i>Call Now</a
          >
        </div>
      </div>
    </section>

    <!-- FOOTER -->
<footer
  style="background: #1a0e06"
  class="overflow-hidden"
>
  <div class="max-w-6xl mx-auto px-6 pt-14 pb-10">
    
    <!-- Footer Grid -->
    <div
      class="grid grid-cols-1 gap-10 pb-10 footer-grid"
      style="
        border-bottom: 1px solid rgba(196, 103, 58, 0.18);
      "
    >
      <!-- Column 1 -->
      <div>
        <!-- Logo -->
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

              <span
                class="text-3xl font-semibold text-white"
              >
                Clayo
              </span>
            </span>

            <span
              class="text-[11px] tracking-[0.35em] uppercase text-gold font-medium mt-1"
            >
              Pottery Studio
            </span>
          </div>
        </div>

        <!-- Description -->
        <p
          style="
            font-size: 0.82rem;
            color: rgba(255,255,255,0.5);
            line-height: 1.75;
            margin-bottom: 20px;
          "
        >
          Amravati’s premier pottery atelier where earth,
          artistry, and mindfulness come together through
          handcrafted ceramic experiences.
        </p>

        <!-- Social -->
        <div class="flex gap-2 flex-wrap">
          <a
            href="https://www.facebook.com/theclayo"
            class="footer-social"
          >
            <i class="fa-brands fa-facebook-f"></i>
          </a>

          <a
            href="https://www.instagram.com/theclayo"
            class="footer-social"
          >
            <i class="fa-brands fa-instagram"></i>
          </a>

          <a
            href="https://www.youtube.com/theclayo"
            class="footer-social"
          >
            <i class="fa-brands fa-youtube"></i>
          </a>

          <a
            href="https://wa.me/919724788561"
            class="footer-social"
          >
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
      </div>

      <!-- Column 2 -->
      <div>
        <h5 class="footer-title">
          Quick Links
        </h5>

        <ul class="footer-links">
          <li><a href="index.php">› Home</a></li>
          <li><a href="about.php">› About Us</a></li>
          <li><a href="services.php">› Workshops</a></li>
          <li><a href="gallery.php">› Gallery</a></li>
          <li><a href="contact.php">› Contact</a></li>
          <li>
            <a href="contact.php#bookingForm">
              › Book a Seat
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 3 -->
      <div>
        <h5 class="footer-title">
          Our Workshops
        </h5>

        <ul class="footer-links">
          <li>
            <a href="services.php">
              › Beginner Wheel Throwing
            </a>
          </li>

          <li>
            <a href="services.php">
              › Hand-Building Class
            </a>
          </li>

          <li>
            <a href="services.php">
              › Kids Pottery Camp
            </a>
          </li>

          <li>
            <a href="services.php">
              › Corporate Team Workshop
            </a>
          </li>

          <li>
            <a href="services.php">
              › Couples Experience
            </a>
          </li>

          <li>
            <a href="services.php">
              › Custom Ceramic Orders
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 4 -->
      <div>
        <h5 class="footer-title">
          Contact Us
        </h5>

        <div class="footer-contact-list">
          <!-- Phone -->
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fa-solid fa-phone"></i>
            </div>

            <div>
              <div class="footer-contact-label">
                Phone
              </div>

              <a
                href="tel:+919724788561"
                class="footer-contact-text"
              >
                +91 97247 88561
              </a>
            </div>
          </div>

          <!-- Email -->
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fa-solid fa-envelope"></i>
            </div>

            <div>
              <div class="footer-contact-label">
                Email
              </div>

              <a
                href="mailto:info@theclayo.com"
                class="footer-contact-text"
              >
                info@theclayo.com
              </a>
            </div>
          </div>

          <!-- Address -->
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>

            <div>
              <div class="footer-contact-label">
                Address
              </div>

              <span class="footer-contact-text">
                64, Akoli Rd, Usha Colony,
                Guruchhaya Colony, Sai Nagar,
                Amravati, Maharashtra 444607
              </span>
            </div>
          </div>

          <!-- Hours -->
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fa-regular fa-clock"></i>
            </div>

            <div>
              <div class="footer-contact-label">
                Hours
              </div>

              <span class="footer-contact-text">
                Mon–Sat: 10 AM – 7 PM
              </span>

              <br />

              <span
                style="
                  font-size: 0.82rem;
                  color: #c4673a;
                "
              >
                Sun: Studio Closed
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom -->
    <div class="footer-bottom">
      <p class="footer-bottom-text">
        © 2026 The Clayo Pottery Studio.
        All rights reserved.
      </p>

      <p class="footer-bottom-text">
        Designed by
        <a href="#" class="footer-credit">
          WebCultivate Software Solutions
        </a>
      </p>
    </div>
  </div>
</footer>

<style>
  html,
  body {
    overflow-x: hidden;
  }

  /* Footer Title */
  .footer-title {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #c4673a;
    margin-bottom: 18px;
  }

  /* Links */
  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .footer-links a {
    font-size: 0.84rem;
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .footer-links a:hover {
    color: #c4673a;
    padding-left: 4px;
  }

  /* Social */
  .footer-social {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .footer-social:hover {
    background: #c4673a;
    border-color: #c4673a;
    color: #fff;
    transform: translateY(-2px);
  }

  /* Contact */
  .footer-contact-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }

  .footer-contact-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: rgba(196,103,58,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c4673a;
    flex-shrink: 0;
  }

  .footer-contact-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
    margin-bottom: 2px;
  }

  .footer-contact-text {
    font-size: 0.84rem;
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    line-height: 1.6;
    word-break: break-word;
  }

  /* Bottom */
  .footer-bottom {
    padding-top: 18px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .footer-bottom-text {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.3);
    margin: 0;
  }

  .footer-credit {
    color: #c4673a;
    text-decoration: none;
    font-weight: 600;
  }

  /* Desktop Layout */
  @media (min-width: 1024px) {
    .footer-grid {
      grid-template-columns: repeat(4, 1fr);
    }

    .footer-bottom {
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
    }
  }

  /* Tablet Layout */
  @media (min-width: 768px) and (max-width: 1023px) {
    .footer-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  /* Mobile Fix */
  @media (max-width: 767px) {
    .footer-grid {
      grid-template-columns: 1fr !important;
    }

    .footer-grid > div {
      width: 100%;
      min-width: 0;
    }

    .footer-social {
      width: 34px;
      height: 34px;
    }

    .footer-links a,
    .footer-contact-text,
    .footer-bottom-text {
      word-break: break-word;
    }
  }
</style>

    <a href="https://wa.me/919724788561" target="_blank" class="whatsapp-btn"
      ><i class="fa-brands fa-whatsapp text-white text-2xl"></i
    ></a>

    <script>
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
      }
      function closeDrawer() {
        drawer.classList.remove("open");
        overlay.classList.remove("open");
        document.body.style.overflow = "";
        hamburger.classList.remove("active");
      }
      hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
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
        { threshold: 0.08 },
      );
      document
        .querySelectorAll(".reveal, .reveal-left, .reveal-right, .reveal-scale")
        .forEach((el) => revealObs.observe(el));
      document.querySelectorAll(".team-photo-img").forEach((img) => {
        img
          .closest('[class*="card-hover"]')
          .addEventListener("mouseenter", () => {
            img.style.transform = "scale(1.06)";
          });
        img
          .closest('[class*="card-hover"]')
          .addEventListener("mouseleave", () => {
            img.style.transform = "scale(1)";
          });
      });
      function animateCounter(el, target, suffix) {
        let start = 0;
        const duration = 1800;
        const step = (timestamp) => {
          if (!start) start = timestamp;
          const progress = Math.min((timestamp - start) / duration, 1);
          const val = Math.floor(progress * target);
          el.textContent =
            (target >= 1000
              ? val >= 1000
                ? (val / 1000).toFixed(1) + "k"
                : val
              : val) + (suffix || "");
          if (progress < 1) requestAnimationFrame(step);
          else
            el.textContent =
              (target >= 1000 ? (target / 1000).toFixed(1) + "k" : target) +
              (suffix || "");
        };
        requestAnimationFrame(step);
      }
      const statObs = new IntersectionObserver(
        (entries) => {
          entries.forEach((e) => {
            if (e.isIntersecting) {
              const el = e.target;
              const t = parseInt(el.dataset.target);
              const suffix = t === 98 ? "%" : "+";
              animateCounter(el, t, suffix);
              statObs.unobserve(el);
            }
          });
        },
        { threshold: 0.4 },
      );
      document
        .querySelectorAll(".stat-num[data-target]")
        .forEach((el) => statObs.observe(el));
      if (window.innerWidth <= 768) {
        const certSlider = document.querySelector(".cert-slider");
        if (certSlider) {
          let scrollAmount = 0;
          const scrollStep = 176;
          const maxScroll = certSlider.scrollWidth - certSlider.clientWidth;
          setInterval(() => {
            scrollAmount += scrollStep;
            if (scrollAmount > maxScroll) scrollAmount = 0;
            certSlider.scrollTo({ left: scrollAmount, behavior: "smooth" });
          }, 3000);
        }
      }
    </script>
  <?php include __DIR__ . '/popup.php'; ?>
  </body>
</html>
