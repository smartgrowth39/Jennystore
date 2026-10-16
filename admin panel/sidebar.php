<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* ── Sidebar Core Styles (As per your provided CSS) ── */
        .dashboard-sidebar {
            width: 260px;
            background: var(--color-primary); /* #1a1a1a */
            color: var(--color-white);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 999;
            transition: var(--transition);
        }

        .sidebar-close-btn {
            display: none;
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            background: transparent;
            border: none;
            color: var(--color-white);
            font-size: 1.8rem;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 1000;
        }

        .dashboard-logo {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            color: var(--color-accent); /* #d4a574 */
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin: 0.5rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.9rem 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--color-accent);
            color: var(--color-white);
        }

        .nav-icon {
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        /* ── Mobile Menu Toggle Button (Visible only on mobile) ── */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 998;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            box-shadow: var(--shadow-soft);
        }

        /* ── Mobile Overlay ── */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 997;
            backdrop-filter: blur(2px);
        }

        .mobile-menu-overlay.active {
            display: block;
        }

        /* ── Responsive Queries ── */
        @media (max-width: 992px) {
            .mobile-menu-toggle {
                display: block;
            }

            .dashboard-sidebar {
                transform: translateX(-100%);
            }

            .dashboard-sidebar.active {
                transform: translateX(0);
                box-shadow: 10px 0 30px rgba(0,0,0,0.3);
            }

            .sidebar-close-btn {
                display: block;
            }
        }
    </style>
</head>
<body>

    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰ Menu</button>
    
    <div class="mobile-menu-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <button class="sidebar-close-btn" onclick="toggleSidebar()">✕</button>
        
        <div class="dashboard-logo">Jenny Store</div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="products.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">🛍️</span> Products
                </a>
            </li>
            <li class="nav-item">
                <a href="orders.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'orders.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">📦</span> Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="users.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">👥</span> Users
                </a>
            </li>
            <li class="nav-item">
                <a href="reviews.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'reviews.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">⭐</span> Reviews
                </a>
            </li>
            <li class="nav-item">
                <a href="user_contact.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'user_contact.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">✉️</span> Contact Messages
                </a>
            </li>
            <li class="nav-item">
                <a href="manage-admins.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-admins.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">🛡️</span> Manage Admins
                </a>
            </li>
            <li class="nav-item">
                <a href="settings.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
                    <span class="nav-icon">⚙️</span> Admin Profile
                </a>
            </li>
            <li class="nav-item" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                <a href="admin_logout.php" class="nav-link" style="color: #ef4444;">
                    <span class="nav-icon">🚪</span> Logout
                </a>
            </li>
        </ul>
    </aside>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('dashboardSidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Auto-close sidebar on mobile when a link is clicked
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>