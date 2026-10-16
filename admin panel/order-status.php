<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

$id = $_GET['id'];

if(isset($_POST['update_status'])){

$status = $_POST['status'];

mysqli_query($connect,
"UPDATE orders SET status='$status' WHERE order_id='$id'");

header("Location: orders.php");
}

$query = mysqli_query($connect,
"SELECT * FROM orders WHERE order_id='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status - Jenny Store Admin</title>
    <?php include "links.php"; ?>
    <style>
        :root {
            --color-primary:    #1a1a1a;
            --color-secondary:  #f8f8f8;
            --color-accent:     #d4a574;
            --color-white:      #ffffff;
            --color-text:       #2c2c2c;
            --color-text-light: #666666;
            --color-border:     #e8e8e8;
            --color-success:    #10b981;
            --color-warning:    #f59e0b;
            --color-danger:     #ef4444;
            --color-info:       #3b82f6;
            --font-display:     'Cormorant Garamond', serif;
            --font-body:        'Lato', sans-serif;
            --transition:       all 0.3s ease;
            --shadow-soft:      0 2px 20px rgba(0,0,0,0.06);
            --shadow-hover:     0 8px 40px rgba(0,0,0,0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--color-secondary);
            color: var(--color-text);
        }

        .dashboard { display: flex; min-height: 100vh; }

        .dashboard-main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            transition: var(--transition);
        }

        /* ── HEADER ── */
        .dashboard-header {
            background: var(--color-white);
            padding: 1.5rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-header-title {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .btn-back {
            padding: 0.7rem 1.4rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-back:hover { background: var(--color-accent); }

        /* ── CARD ── */
        .status-card {
            background: var(--color-white);
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            padding: 2.5rem;
            max-width: 520px;
        }

        .order-id-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 2rem;
            padding-bottom: 1.2rem;
            border-bottom: 2px solid var(--color-border);
        }

        .order-id-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: rgba(59,130,246,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-info);
            font-size: 1.1rem;
        }

        .order-id-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--color-text-light);
        }

        .order-id-value {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--color-info);
        }

        /* ── CURRENT STATUS ── */
        .current-status-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .current-status-label {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--color-text-light);
        }

        .status-badge {
            padding: 0.35rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending    { background: rgba(245,158,11,0.1);  color: var(--color-warning); }
        .status-processing { background: rgba(59,130,246,0.1);  color: var(--color-info); }
        .status-shipped    { background: rgba(212,165,116,0.15); color: var(--color-accent); }
        .status-delivered  { background: rgba(16,185,129,0.1);  color: var(--color-success); }
        .status-cancelled  { background: rgba(239,68,68,0.1);   color: var(--color-danger); }

        /* ── FIELD ── */
        .field {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            margin-bottom: 1.6rem;
        }

        .field label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--color-text-light);
        }

        select[name="status"] {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid var(--color-border);
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--color-text);
            background: var(--color-white);
            outline: none;
            cursor: pointer;
            transition: var(--transition);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        select[name="status"]:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(212,165,116,0.12);
        }

        /* ── SUBMIT ── */
        button[name="update_status"] {
            width: 100%;
            padding: 0.95rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 10px;
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transition);
        }

        button[name="update_status"]:hover {
            background: #c9965d;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212,165,116,0.35);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 992px) {
            .dashboard-main-content { margin-left: 0; padding: 5rem 1.5rem 1.5rem; }
        }

        @media (max-width: 768px) {
            .dashboard-main-content { padding: 5rem 1rem 1rem; }
            .status-card { padding: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="dashboard">

        <?php include "sidebar.php"; ?>

        <main class="dashboard-main-content">

            <div class="dashboard-header">
                <h1 class="dashboard-header-title">Update Order Status</h1>
                <a href="orders.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>

            <div class="status-card">

                <div class="order-id-row">
                    <div class="order-id-icon"><i class="fas fa-receipt"></i></div>
                    <div>
                        <div class="order-id-label">Order ID</div>
                        <div class="order-id-value">#ORD-<?php echo $data['order_id']; ?></div>
                    </div>
                </div>

                <div class="current-status-row">
                    <span class="current-status-label">Current Status</span>
                    <span class="status-badge status-<?php echo strtolower($data['status']); ?>">
                        <?php echo $data['status']; ?>
                    </span>
                </div>

                <form method="POST">
                    <div class="field">
                        <label>New Status</label>
                        <select name="status">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" name="update_status">Update Status</button>
                </form>

            </div>

        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('dashboardSidebar');
            const overlay = document.querySelector('.mobile-menu-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) toggleSidebar();
            });
        });
    </script>
</body>
</html>