<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "connect.php";

function nav_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$ip = nav_client_ip();
$count = "SELECT SUM(product_quantity) as total_items FROM add_to_cart WHERE ip_address='$ip'";
$count_query = mysqli_query($connect, $count);

$count_data = mysqli_fetch_assoc($count_query);

$cart_count = $count_data['total_items'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny Store - Home</title>

    <?php
    include "links.php";
    ?>
    <style>
        :root {
            --color-primary: #1a1a1a;
            --color-secondary: #f8f8f8;
            --color-accent: #d4a574;
            --color-accent-dark: #b8895a;
            --color-white: #ffffff;
            --color-text: #2c2c2c;
            --color-text-light: #666666;
            --color-border: #e8e8e8;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.4s ease;
            --shadow-soft: 0 2px 20px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 8px 40px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            color: var(--color-text);
            background: var(--color-white);
        }

        /* ══════════════════════════════
           MARQUEE
        ══════════════════════════════ */
        .navbar-marquee-bar {
            background: var(--color-primary);
            color: var(--color-white);
            padding: 10px 0;
            overflow: hidden;
            height: 40px;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 999;
        }

        .navbar-marquee-content {
            display: flex;
            animation: navbar-scroll 30s linear infinite;
            white-space: nowrap;
        }

        .navbar-marquee-text {
            padding: 0 50px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .navbar-marquee-text::after {
            content: '✦';
            margin-left: 50px;
            opacity: 0.5;
        }

        @keyframes navbar-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* ══════════════════════════════
           TEXT LOGO
        ══════════════════════════════ */
        .navbar-logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            transition: opacity 0.4s ease, transform 0.4s ease;
            padding: 4px 0;
            user-select: none;
            flex-shrink: 0;
        }

        .navbar-logo-wrap:hover {
            opacity: 0.88;
            transform: scale(1.015);
        }

        .navbar-logo-jenny {
            font-family: var(--font-display);
            font-style: italic;
            font-size: 2.6rem;
            font-weight: 600;
            color: var(--color-accent);
            letter-spacing: 3px;
            line-height: 1;
        }

        .navbar-logo-rule {
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--color-accent), transparent);
            margin: 5px 0 4px;
        }

        .navbar-logo-sub {
            font-family: var(--font-body);
            font-size: 0.58rem;
            font-weight: 700;
            color: var(--color-text-light);
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1;
            white-space: nowrap;
        }

        /* ══════════════════════════════
           MAIN NAVBAR
        ══════════════════════════════ */
        .navbar-main {
            background: var(--color-white);
            border-bottom: 1px solid var(--color-border);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100px;
        }

        .navbar-main.navbar-scrolled {
            box-shadow: var(--shadow-hover);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: var(--color-primary);
            transition: var(--transition);
        }

        .navbar-menu-toggle:hover {
            color: var(--color-accent);
        }

        /* ── Center nav links ── */
        .navbar-nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            list-style: none;
        }

        .navbar-nav-link {
            color: var(--color-text);
            text-decoration: none;
            font-size: 15.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 0;
            position: relative;
            transition: var(--transition);
            white-space: nowrap;
        }

        .navbar-nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--color-accent);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .navbar-nav-link:hover {
            color: var(--color-accent);
        }

        .navbar-nav-link:hover::after {
            width: 80%;
        }

        /* ── Right: actions ── */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1.4rem;
        }

        /* ── User greeting ── */
        .navbar-user-greeting {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            line-height: 1.2;
            text-decoration: none;
        }

        .navbar-user-hi {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar-user-name {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--color-accent);
            letter-spacing: 0.5px;
            line-height: 1;
        }

        .navbar-action-icon {
            font-size: 18px;
            color: var(--color-primary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar-action-icon:hover {
            color: var(--color-accent);
            transform: translateY(-2px);
        }

        .navbar-cart-link {
            position: relative;
        }

        .navbar-cart-counter {
            position: absolute;
            top: -10px;
            right: -12px;
            background: #d4a574;
            color: white;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 50%;
        }

        /* ══════════════════════════════
           HIDDEN CHECKBOXES
        ══════════════════════════════ */
        #navbar-search-toggle,
        #navbar-menu-toggle {
            display: none;
        }

        /* ══════════════════════════════
           SEARCH BAR
        ══════════════════════════════ */
        .navbar-search-bar {
            position: fixed;
            top: -160px;
            left: 0;
            width: 100%;
            background: var(--color-white);
            border-bottom: 2px solid var(--color-accent);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.10);
            z-index: 10002;
            padding: 2.2rem 2rem 1.6rem;
            display: flex;
            align-items: flex-end;
            gap: 1rem;
            transition: top 0.42s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #navbar-search-toggle:checked~.navbar-search-bar {
            top: 0;
        }

        .navbar-search-inner {
            display: flex;
            align-items: center;
            flex: 1;
            border: 1.5px solid var(--color-border);
            border-radius: 8px;
            overflow: hidden;
            transition: var(--transition);
            max-width: 700px;
            margin: 0 auto;
        }

        .navbar-search-inner:focus-within {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.15);
        }

        .navbar-search-input {
            flex: 1;
            padding: 0.78rem 1.1rem;
            border: none;
            outline: none;
            font-size: 1rem;
            font-family: var(--font-body);
            color: var(--color-text);
            background: transparent;
        }

        .navbar-search-submit {
            padding: 0.78rem 1.3rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
            font-family: var(--font-body);
            font-weight: 600;
        }

        .navbar-search-submit:hover {
            background: var(--color-primary);
        }

        .navbar-search-close {
            background: none;
            border: none;
            font-size: 1.8rem;
            line-height: 1;
            color: var(--color-text-light);
            cursor: pointer;
            transition: var(--transition);
            padding: 0 0.3rem;
            flex-shrink: 0;
        }

        .navbar-search-close:hover {
            color: var(--color-primary);
            transform: rotate(90deg);
        }

        /* ══════════════════════════════
           MOBILE MENU SIDEBAR
        ══════════════════════════════ */
        .navbar-mobile-menu {
            position: fixed;
            top: 0;
            left: -290px;
            width: 290px;
            height: 100vh;
            background: var(--color-white);
            z-index: 10002;
            transition: var(--transition);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.18);
            overflow-y: auto;
        }

        #navbar-menu-toggle:checked~.navbar-mobile-menu {
            left: 0;
        }

        .navbar-mobile-header {
            background: var(--color-primary);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-mobile-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar-mobile-logo-jenny {
            font-family: var(--font-display);
            font-style: italic;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--color-accent);
            letter-spacing: 2px;
            line-height: 1;
        }

        .navbar-mobile-logo-sub {
            font-family: var(--font-body);
            font-size: 0.5rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.55);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .navbar-mobile-close {
            background: none;
            border: none;
            font-size: 26px;
            color: var(--color-white);
            cursor: pointer;
            transition: var(--transition);
            line-height: 1;
        }

        .navbar-mobile-close:hover {
            transform: rotate(90deg);
            color: var(--color-accent);
        }

        .navbar-mobile-menu-list {
            list-style: none;
        }

        .navbar-mobile-menu-item {
            border-bottom: 1px solid var(--color-border);
        }

        .navbar-mobile-menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            color: var(--color-text);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            transition: var(--transition);
        }

        .navbar-mobile-menu-link:hover {
            background: var(--color-secondary);
            color: var(--color-accent);
            padding-left: 28px;
        }

        /* Mobile user greeting */
        .navbar-mobile-user-greeting {
            padding: 14px 22px;
            background: rgba(212, 165, 116, 0.08);
            border-bottom: 1px solid var(--color-border);
            text-decoration: none;
        }

        .navbar-mobile-user-hi {
            font-size: 0.65rem;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .navbar-mobile-user-name {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--color-accent);
        }

        /* ══════════════════════════════
           OVERLAYS
        ══════════════════════════════ */
        .navbar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.48);
            z-index: 10001;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        #navbar-search-toggle:checked~.navbar-search-overlay,
        #navbar-menu-toggle:checked~.navbar-menu-overlay {
            opacity: 1;
            pointer-events: all;
        }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 1300px) {
            .navbar-nav-links {
                gap: 1.2rem;
            }

            .navbar-nav-link {
                font-size: 14.5px;
            }
        }

        @media (max-width: 1100px) {
            .navbar-nav-links {
                gap: 0.9rem;
            }

            .navbar-nav-link {
                font-size: 13.5px;
                letter-spacing: 0.3px;
            }

            .navbar-main {
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 900px) {
            .navbar-nav-links {
                gap: 0.7rem;
            }

            .navbar-nav-link {
                font-size: 12.5px;
                letter-spacing: 0.2px;
            }
        }

        @media (max-width: 768px) {
            .navbar-main {
                padding: 0 1rem;
            }

            .navbar-menu-toggle {
                display: block;
            }

            .navbar-nav-links {
                display: none;
            }

            .navbar-actions {
                gap: 1rem;
            }

            .navbar-action-icon {
                font-size: 17px;
            }

            .navbar-search-bar {
                padding: 0.9rem 1rem;
            }

            .navbar-user-greeting {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .navbar-main {
                padding: 0 0.75rem;
            }

            .navbar-marquee-text {
                font-size: 11px;
                padding: 0 35px;
            }
        }

        @media (max-width: 400px) {
            .navbar-main {
                padding: 0 0.5rem;
                height: 90px;
            }

            .navbar-marquee-text {
                font-size: 10px;
                padding: 0 28px;
            }

            .navbar-actions {
                gap: 0.75rem;
            }

            .navbar-action-icon {
                font-size: 16px;
            }
        }

        @media (max-width: 320px) {
            .navbar-main {
                padding: 0 0.4rem;
                height: 85px;
            }

            .navbar-actions {
                gap: 0.6rem;
            }
        }

        @media (hover: none) and (pointer: coarse) {
            .navbar-action-icon {
                padding: 6px;
            }

            .navbar-mobile-menu-link {
                padding: 18px 22px;
            }
        }
    </style>
</head>

<body>

    <!-- ── Marquee ── -->
    <div class="navbar-marquee-bar">
        <div class="navbar-marquee-content">
            <span class="navbar-marquee-text">Welcome To Jenny Cosmetics and Jwellery Store</span>
            <span class="navbar-marquee-text">We Have a Best Products Of Cosmetics and Jwellery</span>
            <span class="navbar-marquee-text">Welcome To Jenny Cosmetics and Jwellery Store</span>
            <span class="navbar-marquee-text">We Have a Best Products Of Cosmetics and Jwellery</span>
            <span class="navbar-marquee-text">Welcome To Jenny Cosmetics and Jwellery Store</span>
            <span class="navbar-marquee-text">We Have a Best Products Of Cosmetics and Jwellery</span>
        </div>
    </div>

    <!-- ── Hidden Checkboxes ── -->
    <input type="checkbox" id="navbar-search-toggle">
    <input type="checkbox" id="navbar-menu-toggle">

    <!-- ── Overlays ── -->
    <label for="navbar-search-toggle" class="navbar-overlay navbar-search-overlay"></label>
    <label for="navbar-menu-toggle" class="navbar-overlay navbar-menu-overlay"></label>

    <!-- ── Search Bar ── -->
    <div class="navbar-search-bar">
        <div class="navbar-search-inner">
            <input type="text" class="navbar-search-input" placeholder="Search for jewellery, cosmetics...">
            <button class="navbar-search-submit"><i class="fas fa-search"></i></button>
        </div>
        <label for="navbar-search-toggle" class="navbar-search-close" title="Close">×</label>
    </div>

    <!-- ── Mobile Menu ── -->
    <div class="navbar-mobile-menu">
        <div class="navbar-mobile-header">
            <div class="navbar-mobile-logo">
                <span class="navbar-mobile-logo-jenny">Jenny</span>
                <span class="navbar-mobile-logo-sub">Cosmetics &amp; Jewellery</span>
            </div>
            <label for="navbar-menu-toggle" class="navbar-mobile-close">×</label>
        </div>
        <ul class="navbar-mobile-menu-list">

            <?php if (isset($_SESSION['user'])): ?>
                <li>
                    <a href="user-profile.php" class="navbar-mobile-user-greeting">
                        <span class="navbar-mobile-user-hi">Welcome</span>
                        <span class="navbar-mobile-user-name"><?php echo $_SESSION['user']; ?></span>
                    </a>

                </li>
            <?php endif; ?>

            <li class="navbar-mobile-menu-item"><a href="index.php" class="navbar-mobile-menu-link">HOME <i class="fas fa-chevron-right"></i></a></li>
            <li class="navbar-mobile-menu-item"><a href="shop-all.php" class="navbar-mobile-menu-link">SHOP ALL <i class="fas fa-chevron-right"></i></a></li>
            <li class="navbar-mobile-menu-item"><a href="cosmetics.php" class="navbar-mobile-menu-link">COSMETICS <i class="fas fa-chevron-right"></i></a></li>
            <li class="navbar-mobile-menu-item"><a href="jewellery.php" class="navbar-mobile-menu-link">JEWELLERY <i class="fas fa-chevron-right"></i></a></li>
            <li class="navbar-mobile-menu-item"><a href="about.php" class="navbar-mobile-menu-link">ABOUT US <i class="fas fa-chevron-right"></i></a></li>
            <li class="navbar-mobile-menu-item"><a href="contact.php" class="navbar-mobile-menu-link">CONTACT US <i class="fas fa-chevron-right"></i></a></li>

            <?php if (isset($_SESSION['user'])): ?>
                <li class="navbar-mobile-menu-item">
                    <a href="logout.php" class="navbar-mobile-menu-link">LOGOUT <i class="fas fa-chevron-right"></i></a>
                </li>
            <?php else: ?>
                <li class="navbar-mobile-menu-item">
                    <a href="user.php" class="navbar-mobile-menu-link">LOGIN <i class="fas fa-chevron-right"></i></a>
                </li>
            <?php endif; ?>

        </ul>
    </div>

    <!-- ── Main Navbar ── -->
    <nav class="navbar-main" id="navbar-main">

        <div class="navbar-left">
            <label for="navbar-menu-toggle" class="navbar-menu-toggle">
                <i class="fas fa-bars"></i>
            </label>
            <a href="index.php" class="navbar-logo-wrap">
                <span class="navbar-logo-jenny">Jenny</span>
                <div class="navbar-logo-rule"></div>
                <span class="navbar-logo-sub">Cosmetics &amp; Jewellery</span>
            </a>
        </div>

        <ul class="navbar-nav-links">
            <li><a href="index.php" class="navbar-nav-link">HOME</a></li>
            <li><a href="shop-all.php" class="navbar-nav-link">SHOP ALL</a></li>
            <li><a href="cosmetics.php" class="navbar-nav-link">COSMETICS</a></li>
            <li><a href="jewellery.php" class="navbar-nav-link">JEWELLERY</a></li>
            <li><a href="about.php" class="navbar-nav-link">ABOUT</a></li>
            <li><a href="contact.php" class="navbar-nav-link">CONTACT</a></li>

            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="logout.php" class="navbar-nav-link">LOGOUT</a></li>
            <?php else: ?>
                <li><a href="user.php" class="navbar-nav-link">LOGIN</a></li>
            <?php endif; ?>
        </ul>

        <div class="navbar-actions">

            <!-- User greeting — right side, no link -->
            <?php if (isset($_SESSION['user'])): ?>
                <a href="user-profile.php" class="navbar-user-greeting">
                    <span class="navbar-user-hi">Welcome</span>
                    <span class="navbar-user-name"><?php echo $_SESSION['user']; ?></span>
                </a>
            <?php endif; ?>

            <label for="navbar-search-toggle" class="navbar-action-icon" title="Search">
                <i class="fas fa-search"></i>
            </label>
            <a href="cart.php" class="navbar-action-icon navbar-cart-link" title="Cart">
                <i class="fas fa-shopping-bag"></i>
                <?php if ($cart_count > 0): ?>
                    <span class="navbar-cart-counter"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </a>
        </div>

    </nav>

    <script>
        window.addEventListener('scroll', () => {
            document.getElementById('navbar-main')
                .classList.toggle('navbar-scrolled', window.pageYOffset > 50);
        });
    </script>

</body>

</html>