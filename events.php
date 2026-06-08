<?php
// Pull active Events added through the admin panel.
$eventItems = [];
try {
    $db   = require __DIR__ . '/admin/config/database.php';
    $dsn  = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset={$db['charset']}";
    $pdo  = new PDO($dsn, $db['username'], $db['password'], $db['options']);
    $stmt = $pdo->query(
        "SELECT * FROM events
         WHERE is_active = 1
         ORDER BY event_date IS NULL, event_date ASC, sort_order ASC, created_at DESC"
    );
    $eventItems = $stmt->fetchAll();
} catch (Throwable $e) {
    $eventItems = [];
}

function clayo_e(?string $v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function clayo_img(?string $rel): string {
    return $rel ? 'public/' . ltrim($rel, '/') : '';
}

$today = date('Y-m-d');
$upcoming = array_values(array_filter($eventItems, fn($e) => empty($e['event_date']) || $e['event_date'] >= $today));
$past     = array_values(array_filter($eventItems, fn($e) => !empty($e['event_date']) && $e['event_date'] < $today));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events – The Clayo Pottery Studio | Pottery Events Amravati</title>
    <meta name="description" content="Upcoming events at The Clayo Pottery Studio, Amravati — pottery festivals, exhibitions, themed workshops and community gatherings." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
        body { font-family: "Inter", sans-serif; background-color: #faf6f0; color: #2c1f14; overflow-x: hidden; }
        html { overflow-x: hidden; }
        *, *::before, *::after { box-sizing: border-box; }
        h1, h2, h3, h4 { font-family: "Playfair Display", serif; }

        .sticky-header { position: fixed; top: 0; left: 0; right: 0; z-index: 9999; width: 100%; }
        #navbar { position: relative !important; top: auto !important; z-index: auto !important; background: rgba(255, 255, 255, 0.98) !important; }
        body { padding-top: var(--header-height, 114px); }
        .navbar-scrolled { box-shadow: 0 4px 30px rgba(80, 40, 20, 0.1); }
        .nav-link { position: relative; padding: 6px 0 !important; margin: 0 16px; background: transparent !important; border-radius: 0 !important; }
        .nav-link::after { content: ""; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: #b8793a; transition: width 0.3s; border-radius: 2px; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        .nav-link:hover { color: #5c3820 !important; background: transparent !important; }
        .desktop-nav { display: flex; align-items: center; gap: 0; }

        .topbar { background: #2c1f14; color: rgba(255,255,255,0.78); font-size: 0.78rem; }
        .topbar-inner { max-width: 72rem; margin: 0 auto; padding: 8px 24px; display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
        .topbar a { color: rgba(255,255,255,0.78); text-decoration: none; }
        .topbar a:hover { color: #e8d0a8; }
        .topbar-left, .topbar-right { display:flex; gap:18px; flex-wrap:wrap; align-items:center; }
        @media (max-width: 768px) { .topbar-right { display: none; } }

        /* MOBILE DRAWER */
        .drawer-overlay { position: fixed; inset: 0; background: rgba(28,18,12,0.55); opacity: 0; pointer-events: none; transition: opacity .3s; z-index: 10000; }
        .drawer-overlay.open { opacity: 1; pointer-events: auto; }
        .mobile-drawer { position: fixed; top: 0; right: 0; width: 82%; max-width: 340px; height: 100vh; background: #faf6f0; z-index: 10001; transform: translateX(100%); transition: transform .35s ease; display: flex; flex-direction: column; }
        .mobile-drawer.open { transform: translateX(0); }
        .drawer-header { display:flex; align-items:center; justify-content:space-between; padding: 22px 22px 16px; border-bottom: 1px solid rgba(184,121,58,0.18); }
        .drawer-close { background: none; border: none; font-size: 1.4rem; color: #5c3820; cursor:pointer; padding: 6px 10px; }
        .drawer-nav { display:flex; flex-direction:column; padding: 16px 14px; gap: 4px; flex:1; }
        .drawer-nav a { padding: 12px 14px; border-radius: 12px; color: #5c3820; text-decoration: none; display:flex; align-items:center; gap: 12px; font-size: .92rem; font-weight: 500; }
        .drawer-nav a:hover, .drawer-nav a.active { background: rgba(184,121,58,0.12); color: #b8793a; }
        .drawer-footer { padding: 16px 22px 28px; border-top: 1px solid rgba(184,121,58,0.18); }
        .hamburger { background: none; border: none; cursor: pointer; padding: 8px; display:flex; flex-direction:column; gap: 5px; }
        .hamburger-bar { display:block; width: 22px; height: 2px; background: #5c3820; border-radius: 2px; transition: transform .3s, opacity .3s; }

        .btn-primary { display: inline-block; background: #5c3820; color: #faf6f0; padding: 14px 32px; border-radius: 100px; font-size: 0.92rem; font-weight: 500; letter-spacing: 0.03em; transition: all 0.25s; text-decoration: none; }
        .btn-primary:hover { background: #b8793a; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(92, 56, 32, 0.3); }

        .section-tag { display: inline-block; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: #b8793a; background: #e8d0a8; padding: 6px 18px; border-radius: 100px; margin-bottom: 14px; }

        .reveal { opacity: 0; transform: translateY(36px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.revealed { opacity: 1; transform: translateY(0); }

        /* Event card */
        .event-card { background: rgba(255,255,255,0.78); backdrop-filter: blur(18px); border: 1px solid rgba(184,147,90,0.16); border-radius: 28px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.04), 0 2px 10px rgba(184,147,90,0.06); transition: transform .45s ease, box-shadow .45s ease, border-color .45s ease; display:flex; flex-direction: column; }
        .event-card:hover { transform: translateY(-8px); box-shadow: 0 30px 70px rgba(0,0,0,0.08); border-color: rgba(184,147,90,0.32); }
        .event-card .img-wrap { position: relative; width: 100%; aspect-ratio: 16/10; background: linear-gradient(135deg,#f5ede0,#e8d5b0); overflow: hidden; }
        .event-card .img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
        .event-card:hover .img-wrap img { transform: scale(1.05); }
        .event-card .img-placeholder { position: absolute; inset: 0; display: grid; place-items: center; color: #b07a42; font-size: 2.2rem; }
        .badge-date { position: absolute; top: 14px; left: 14px; background: rgba(255,255,255,0.94); backdrop-filter: blur(8px); border-radius: 14px; padding: 8px 12px; text-align: center; min-width: 60px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
        .badge-date .d { font-family: "Playfair Display", serif; font-size: 1.3rem; font-weight: 700; color: #5c3820; line-height: 1; }
        .badge-date .m { font-size: 0.66rem; letter-spacing: 0.16em; text-transform: uppercase; color: #b8793a; font-weight: 600; margin-top: 3px; }
        .badge-status { position: absolute; top: 14px; right: 14px; background: rgba(92,56,32,0.92); color: #faf6f0; font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; padding: 6px 12px; border-radius: 999px; font-weight: 600; }
        .badge-status.past { background: rgba(70,55,40,0.7); }
        .event-body { padding: 22px 24px 24px; flex: 1; display: flex; flex-direction: column; }
        .event-title { font-size: 1.25rem; font-weight: 600; color: #5c3820; margin-bottom: 10px; line-height: 1.3; }
        .event-desc { font-size: 0.88rem; color: #8a7060; line-height: 1.75; margin-bottom: 16px; }
        .event-meta { display:flex; flex-wrap:wrap; gap: 8px 14px; margin-bottom: 18px; font-size: 0.8rem; color: #5c3820; }
        .event-meta span { display:inline-flex; align-items:center; gap: 6px; }
        .event-meta i { color: #b8793a; }
        .pill { display:inline-flex; align-items:center; gap:6px; padding: 6px 14px; border-radius: 999px; font-size: 0.74rem; font-weight: 600; }
        .pill-price { background: #fef3e8; color: #b8793a; border: 1px solid #f3dcb8; }
        .pill-seats { background: #eef6ec; color: #4d7a3c; border: 1px solid #cfe3c6; }
        .event-cta { display:inline-flex; align-items:center; gap:8px; background: linear-gradient(135deg,#c8a060,#b07a42); color: white; padding: 12px 22px; border-radius: 999px; font-size: 0.86rem; font-weight: 600; text-decoration: none; box-shadow: 0 10px 25px rgba(176,122,66,0.22); transition: all .3s ease; align-self: flex-start; margin-top: auto; }
        .event-cta:hover { transform: translateY(-3px); box-shadow: 0 18px 40px rgba(176,122,66,0.28); }

        .empty-state { background: rgba(255,255,255,0.7); border: 1px dashed rgba(184,147,90,0.4); border-radius: 28px; padding: 70px 30px; text-align: center; color: #8a7060; }
        .empty-state i { font-size: 2.4rem; color: #b8793a; margin-bottom: 14px; }

        footer.site-footer { background: #1a120a; color: rgba(255,255,255,0.7); padding: 60px 0 24px; margin-top: 90px; }
        .footer-inner { max-width: 72rem; margin: 0 auto; padding: 0 24px; display: grid; grid-template-columns: 1.4fr 1fr 1fr; gap: 50px; }
        @media (max-width: 768px) { .footer-inner { grid-template-columns: 1fr; gap: 36px; } }
        .footer-inner h5 { font-size: 0.74rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: #c4673a; margin-bottom: 16px; font-family: "Inter", sans-serif; }
        .footer-inner a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.86rem; }
        .footer-inner a:hover { color: #c4673a; }
        .footer-inner ul { list-style: none; padding: 0; margin: 0; display:flex; flex-direction:column; gap: 10px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); margin: 40px 24px 0; padding-top: 22px; text-align:center; font-size: 0.78rem; color: rgba(255,255,255,0.45); max-width: 72rem; margin-left:auto; margin-right:auto; }
    </style>
</head>
<body>

<!-- STICKY HEADER -->
<div class="sticky-header">
    <div class="topbar">
        <div class="topbar-inner">
            <div class="topbar-left">
                <a href="tel:+919724788561"><i class="fa-solid fa-phone mr-1"></i> +91 9724788561</a>
                <a href="mailto:info@theclayo.com" class="hidden sm:inline"><i class="fa-solid fa-envelope mr-1"></i> info@theclayo.com</a>
            </div>
            <div class="topbar-right">
                <span><i class="fa-regular fa-clock mr-1"></i> Mon–Sat: 10 AM – 7 PM</span>
                <span><i class="fa-solid fa-location-dot mr-1"></i> Sai Nagar, Akoli Road, Amravati</span>
            </div>
        </div>
    </div>

    <nav id="navbar" class="sticky top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-amber-100 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3 flex-shrink-0">
                <div class="flex flex-col leading-tight">
                    <span class="font-heading text-brown flex items-end gap-1 leading-none">
                        <span class="text-sm font-medium uppercase tracking-[0.2em]">The</span>
                        <span class="text-3xl font-semibold">Clayo</span>
                    </span>
                    <span class="text-[11px] tracking-[0.35em] uppercase text-gold font-medium mt-1">Pottery Studio</span>
                </div>
            </a>
            <ul class="desktop-nav hidden md:flex items-center">
                <li><a href="index.php"    class="nav-link text-sm font-medium text-muted transition-colors">Home</a></li>
                <li><a href="about.php"    class="nav-link text-sm font-medium text-muted transition-colors">About</a></li>
                <li><a href="services.php" class="nav-link text-sm font-medium text-muted transition-colors">Workshops</a></li>
                <li><a href="events.php"   class="nav-link active text-sm font-medium text-brown transition-colors">Events</a></li>
                <li><a href="gallery.php"  class="nav-link text-sm font-medium text-muted transition-colors">Gallery</a></li>
                <li><a href="contact.php"  class="nav-link text-sm font-medium text-muted transition-colors">Contact</a></li>
                <li class="ml-6"><a href="contact.php" class="btn-primary text-sm">Book Now</a></li>
            </ul>
            <button id="hamburger" class="md:hidden hamburger">
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
            </button>
        </div>
    </nav>
</div>

<!-- MOBILE DRAWER -->
<div class="drawer-overlay" id="drawerOverlay"></div>
<div class="mobile-drawer" id="mobileDrawer">
    <div class="drawer-header">
        <div class="flex flex-col leading-tight">
            <span class="font-heading text-brown flex items-end gap-1 leading-none">
                <span class="text-sm font-medium uppercase tracking-[0.2em]">The</span>
                <span class="text-3xl font-semibold">Clayo</span>
            </span>
            <span class="text-[11px] tracking-[0.35em] uppercase text-gold font-medium mt-1">Pottery Studio</span>
        </div>
        <button class="drawer-close" id="drawerClose"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <nav class="drawer-nav">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about.php"><i class="fa-solid fa-circle-info"></i> About</a>
        <a href="services.php"><i class="fa-solid fa-fire-flame-curved"></i> Workshops</a>
        <a href="events.php" class="active"><i class="fa-regular fa-calendar"></i> Events</a>
        <a href="gallery.php"><i class="fa-solid fa-images"></i> Gallery</a>
        <a href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a>
    </nav>
    <div class="drawer-footer">
        <a href="contact.php" class="btn-primary" style="display:flex; align-items:center; justify-content:center; gap:8px;">
            <i class="fa-regular fa-calendar-check"></i> Book now
        </a>
    </div>
</div>

<!-- PAGE HERO -->
<section class="relative overflow-hidden" style="min-height: 380px; display:flex; align-items:center;
    background:
      linear-gradient(135deg, rgba(28,18,12,0.62) 0%, rgba(52,32,20,0.54) 45%, rgba(184,121,58,0.22) 100%),
      url('https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?auto=format&fit=crop&w=1600&q=80');
    background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="max-w-6xl mx-auto px-6 w-full text-center text-cream py-20">
        <span class="section-tag" style="background: rgba(232,208,168,0.92);">Studio Events</span>
        <h1 class="font-heading text-5xl md:text-6xl font-semibold leading-tight mb-5" style="letter-spacing: -0.02em;">
            Upcoming Events
        </h1>
        <p class="text-base md:text-lg max-w-2xl mx-auto" style="color: rgba(250,246,240,0.86); line-height:1.85;">
            Themed workshops, exhibitions, pottery festivals and community gatherings —
            handpicked moments to come together over clay at The Clayo Pottery Studio.
        </p>
    </div>
</section>

<!-- EVENTS BODY -->
<main class="max-w-6xl mx-auto px-6 mt-16">

    <?php if (empty($eventItems)): ?>
        <div class="empty-state reveal">
            <i class="fa-regular fa-calendar-xmark"></i>
            <h3 class="font-heading text-2xl mb-2" style="color:#5c3820;">No events scheduled yet</h3>
            <p class="text-sm mb-6">We're cooking up something special. Check back soon, or reach out and we'll let you know first.</p>
            <a href="contact.php" class="btn-primary">Get in touch</a>
        </div>
    <?php else: ?>

        <?php if (!empty($upcoming)): ?>
        <section class="reveal" id="upcoming-events">
            <div class="mb-10 text-center">
                <span class="section-tag">Mark your calendar</span>
                <h2 class="font-heading text-4xl font-semibold" style="color:#5c3820; letter-spacing:-0.02em;">
                    What's coming up
                </h2>
                <p class="text-sm mt-3" style="color:#8a7060;">
                    <?= count($upcoming) ?> upcoming event<?= count($upcoming) !== 1 ? 's' : '' ?>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                <?php foreach ($upcoming as $it):
                    $img        = clayo_img($it['image_path']);
                    $title      = clayo_e($it['title']);
                    $desc       = clayo_e($it['description']);
                    $price      = clayo_e($it['price']);
                    $capacity   = clayo_e($it['capacity']);
                    $location   = clayo_e($it['location']);
                    $timeStr    = clayo_e($it['event_time']);
                    $hasDate    = !empty($it['event_date']);
                    $dateDay    = $hasDate ? date('j', strtotime($it['event_date'])) : '';
                    $dateMonth  = $hasDate ? strtoupper(date('M', strtotime($it['event_date']))) : '';
                    $dateLong   = $hasDate ? date('l, M j, Y', strtotime($it['event_date'])) : 'Date to be announced';
                ?>
                <article class="event-card reveal">
                    <div class="img-wrap">
                        <?php if ($img): ?>
                            <img src="<?= $img ?>" alt="<?= $title ?>" loading="lazy" />
                        <?php else: ?>
                            <div class="img-placeholder"><i class="fa-regular fa-calendar"></i></div>
                        <?php endif; ?>
                        <?php if ($hasDate): ?>
                            <div class="badge-date">
                                <div class="d"><?= $dateDay ?></div>
                                <div class="m"><?= $dateMonth ?></div>
                            </div>
                        <?php endif; ?>
                        <span class="badge-status">Upcoming</span>
                    </div>
                    <div class="event-body">
                        <h3 class="event-title font-heading"><?= $title ?></h3>
                        <?php if ($desc !== ''): ?>
                            <p class="event-desc"><?= nl2br($desc) ?></p>
                        <?php endif; ?>

                        <div class="event-meta">
                            <span><i class="fa-regular fa-calendar"></i><?= $dateLong ?></span>
                            <?php if ($timeStr !== ''): ?>
                                <span><i class="fa-regular fa-clock"></i><?= $timeStr ?></span>
                            <?php endif; ?>
                            <?php if ($location !== ''): ?>
                                <span><i class="fa-solid fa-location-dot"></i><?= $location ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($price !== '' || $capacity !== ''): ?>
                        <div class="flex flex-wrap gap-2 mb-5">
                            <?php if ($price !== ''): ?>
                                <span class="pill pill-price"><i class="fa-solid fa-tag"></i><?= $price ?></span>
                            <?php endif; ?>
                            <?php if ($capacity !== ''): ?>
                                <span class="pill pill-seats"><i class="fa-solid fa-user-group"></i><?= $capacity ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <a href="contact.php?event=<?= urlencode($it['title']) ?>#bookingForm" class="event-cta">
                            Reserve a Spot <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($past)): ?>
        <section class="reveal mt-24" id="past-events">
            <div class="mb-10 text-center">
                <span class="section-tag" style="background:#ece5dc; color:#8a7060;">Look back</span>
                <h2 class="font-heading text-3xl font-semibold" style="color:#5c3820; letter-spacing:-0.02em;">
                    Past Events
                </h2>
                <p class="text-sm mt-3" style="color:#8a7060;">A glimpse of the moments we've shared</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                <?php foreach ($past as $it):
                    $img        = clayo_img($it['image_path']);
                    $title      = clayo_e($it['title']);
                    $desc       = clayo_e($it['description']);
                    $location   = clayo_e($it['location']);
                    $dateDay    = date('j', strtotime($it['event_date']));
                    $dateMonth  = strtoupper(date('M', strtotime($it['event_date'])));
                    $dateLong   = date('M j, Y', strtotime($it['event_date']));
                ?>
                <article class="event-card reveal" style="opacity:.9;">
                    <div class="img-wrap">
                        <?php if ($img): ?>
                            <img src="<?= $img ?>" alt="<?= $title ?>" loading="lazy" style="filter:grayscale(.15);" />
                        <?php else: ?>
                            <div class="img-placeholder"><i class="fa-regular fa-calendar"></i></div>
                        <?php endif; ?>
                        <div class="badge-date">
                            <div class="d"><?= $dateDay ?></div>
                            <div class="m"><?= $dateMonth ?></div>
                        </div>
                        <span class="badge-status past">Past</span>
                    </div>
                    <div class="event-body">
                        <h3 class="event-title font-heading"><?= $title ?></h3>
                        <?php if ($desc !== ''): ?>
                            <p class="event-desc" style="-webkit-line-clamp:3; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;"><?= nl2br($desc) ?></p>
                        <?php endif; ?>
                        <div class="event-meta">
                            <span><i class="fa-regular fa-calendar"></i><?= $dateLong ?></span>
                            <?php if ($location !== ''): ?>
                                <span><i class="fa-solid fa-location-dot"></i><?= $location ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

    <?php endif; ?>

    <!-- CTA -->
    <section class="reveal text-center mt-24 mb-6" style="background: linear-gradient(135deg, #f5ede0, #fff); border:1px solid rgba(184,147,90,0.18); border-radius: 32px; padding: 60px 30px;">
        <span class="section-tag">Stay in the loop</span>
        <h2 class="font-heading text-3xl md:text-4xl font-semibold mb-4" style="color:#5c3820; letter-spacing:-0.02em;">
            Want to host an event with us?
        </h2>
        <p class="text-base max-w-xl mx-auto mb-8" style="color:#8a7060; line-height:1.8;">
            Private celebrations, corporate offsites, birthdays and team gatherings —
            we'd love to craft an unforgettable pottery experience just for you.
        </p>
        <a href="contact.php" class="btn-primary">Contact the Studio</a>
    </section>

</main>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="flex flex-col leading-tight mb-4">
                <span class="font-heading flex items-end gap-1 leading-none" style="color:#faf6f0;">
                    <span class="text-sm font-medium uppercase tracking-[0.2em]">The</span>
                    <span class="text-3xl font-semibold">Clayo</span>
                </span>
                <span class="text-[11px] tracking-[0.35em] uppercase font-medium mt-1" style="color:#c4673a;">Pottery Studio</span>
            </div>
            <p style="font-size:0.86rem; line-height:1.85; color:rgba(255,255,255,0.55);">
                A warm space in Amravati where clay turns into stories. Workshops, events,
                and handcrafted ceramics — made slow, made with love.
            </p>
        </div>

        <div>
            <h5>Quick Links</h5>
            <ul>
                <li><a href="index.php">› Home</a></li>
                <li><a href="about.php">› About</a></li>
                <li><a href="services.php">› Workshops</a></li>
                <li><a href="events.php">› Events</a></li>
                <li><a href="gallery.php">› Gallery</a></li>
                <li><a href="contact.php">› Contact</a></li>
            </ul>
        </div>

        <div>
            <h5>Visit Us</h5>
            <ul>
                <li><i class="fa-solid fa-location-dot" style="color:#c4673a;"></i> Sai Nagar, Akoli Road,<br>Amravati-444607, Maharashtra</li>
                <li><a href="tel:+919724788561"><i class="fa-solid fa-phone" style="color:#c4673a;"></i> +91 9724788561</a></li>
                <li><a href="mailto:info@theclayo.com"><i class="fa-solid fa-envelope" style="color:#c4673a;"></i> info@theclayo.com</a></li>
                <li><i class="fa-regular fa-clock" style="color:#c4673a;"></i> Mon–Sat: 10 AM – 7 PM</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        © <?= date('Y') ?> The Clayo Pottery Studio. All rights reserved.
    </div>
</footer>

<script>
    // Sticky header offset
    function updateHeaderOffset() {
        const header = document.querySelector(".sticky-header");
        if (header) document.body.style.setProperty("--header-height", header.offsetHeight + "px");
    }
    updateHeaderOffset();
    window.addEventListener("resize", updateHeaderOffset);

    const navbar = document.getElementById("navbar");
    window.addEventListener("scroll", () => {
        navbar.classList.toggle("navbar-scrolled", window.scrollY > 20);
    });

    // Mobile drawer
    const hamburger = document.getElementById("hamburger");
    const drawer = document.getElementById("mobileDrawer");
    const overlay = document.getElementById("drawerOverlay");
    const drawerClose = document.getElementById("drawerClose");
    function openDrawer() { drawer.classList.add("open"); overlay.classList.add("open"); document.body.style.overflow = "hidden"; }
    function closeDrawer() { drawer.classList.remove("open"); overlay.classList.remove("open"); document.body.style.overflow = ""; }
    hamburger.addEventListener("click", () => drawer.classList.contains("open") ? closeDrawer() : openDrawer());
    drawerClose.addEventListener("click", closeDrawer);
    overlay.addEventListener("click", closeDrawer);
    drawer.querySelectorAll("a").forEach((a) => a.addEventListener("click", closeDrawer));

    // Reveal-on-scroll
    const revealObs = new IntersectionObserver(
        (entries) => entries.forEach((e) => {
            if (e.isIntersecting) { e.target.classList.add("revealed"); revealObs.unobserve(e.target); }
        }),
        { threshold: 0.08, rootMargin: "0px 0px -30px 0px" }
    );
    document.querySelectorAll(".reveal").forEach((el) => revealObs.observe(el));
</script>

<?php include __DIR__ . '/popup.php'; ?>
</body>
</html>
