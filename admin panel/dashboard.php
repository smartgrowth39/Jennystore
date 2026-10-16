<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<?php
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Jenny Store</title>

    <?php
    include "links.php";
    ?>
    <style>
        :root {
            --color-primary: #1a1a1a;
            --color-secondary: #f8f8f8;
            --color-accent: #d4a574;
            --color-accent-light: rgba(212, 165, 116, 0.12);
            --color-accent-mid: rgba(212, 165, 116, 0.25);
            --color-white: #ffffff;
            --color-text: #2c2c2c;
            --color-text-light: #666666;
            --color-border: #e8e8e8;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.3s ease;
            --shadow-soft: 0 2px 20px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 8px 40px rgba(212, 165, 116, 0.22);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--color-secondary);
            color: var(--color-text);
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            transition: var(--transition);
            width: 100%;
        }

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

        .dashboard-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .dashboard-notification-btn {
            padding: 0.5rem 1rem;
            background: var(--color-secondary);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            text-decoration: none;
            color: var(--color-primary);
        }

        .dashboard-notification-btn:hover {
            background: var(--color-accent);
            color: var(--color-white);
        }

        .dashboard-user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .dashboard-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-stat-card {
            background: var(--color-white);
            padding: 1.8rem;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .dashboard-stat-card.success {
            border-left-color: var(--color-accent);
        }

        .dashboard-stat-card.warning {
            border-left-color: var(--color-primary);
        }

        .dashboard-stat-card.danger {
            border-left-color: var(--color-accent);
        }

        .dashboard-stat-card.info {
            border-left-color: var(--color-primary);
        }

        .dashboard-stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .dashboard-stat-title {
            font-size: 0.9rem;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dashboard-stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .dashboard-stat-card.success .dashboard-stat-icon {
            background: rgba(212, 165, 116, 0.12);
            color: var(--color-accent);
        }

        .dashboard-stat-card.warning .dashboard-stat-icon {
            background: rgba(26, 26, 26, 0.07);
            color: var(--color-primary);
        }

        .dashboard-stat-card.danger .dashboard-stat-icon {
            background: rgba(212, 165, 116, 0.12);
            color: var(--color-accent);
        }

        .dashboard-stat-card.info .dashboard-stat-icon {
            background: rgba(26, 26, 26, 0.07);
            color: var(--color-primary);
        }

        .dashboard-stat-value {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.3rem;
        }

        .dashboard-stat-change {
            font-size: 0.85rem;
            color: var(--color-accent);
        }

        .dashboard-stat-change.negative {
            color: var(--color-primary);
        }


        /* ======= QUICK ACTION BOXES ======= */
        .dashboard-quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-quick-action-card {
            background: var(--color-white);
            border-radius: 14px;
            box-shadow: var(--shadow-soft);
            padding: 2.2rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
            text-decoration: none;
            color: var(--color-text);
            transition: var(--transition);
            border: 1.5px solid transparent;
        }

        .dashboard-quick-action-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-accent);
        }

        .dashboard-quick-action-icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--color-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .dashboard-quick-action-icon-wrap svg {
            width: 28px;
            height: 28px;
            stroke: #888;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: var(--transition);
        }

        .dashboard-quick-action-card:hover .dashboard-quick-action-icon-wrap {
            background: rgba(212, 165, 116, 0.12);
        }

        .dashboard-quick-action-card:hover .dashboard-quick-action-icon-wrap svg {
            stroke: var(--color-accent);
        }

        .dashboard-quick-action-title {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--color-primary);
            transition: var(--transition);
        }

        .dashboard-quick-action-card:hover .dashboard-quick-action-title {
            color: var(--color-accent);
        }

        .dashboard-quick-action-desc {
            font-size: 0.88rem;
            color: var(--color-text-light);
            line-height: 1.5;
        }

        .dashboard-table-section {
            background: var(--color-white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            overflow-x: auto;
        }

        .dashboard-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-table-title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .dashboard-view-all-btn {
            padding: 0.6rem 1.2rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.9rem;
            text-decoration: none;
        }

        .dashboard-view-all-btn:hover {
            background: var(--color-primary);
            transform: translateY(-2px);
        }

        .dashboard-data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .dashboard-data-table thead {
            background: var(--color-secondary);
        }

        .dashboard-data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            color: var(--color-primary);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .dashboard-data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--color-border);
        }

        .dashboard-data-table tbody tr {
            transition: var(--transition);
        }

        .dashboard-data-table tbody tr:hover {
            background: var(--color-secondary);
        }

        .dashboard-status-badge {
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            white-space: nowrap;
        }

        .dashboard-status-badge.completed {
            background: rgba(212, 165, 116, 0.12);
            color: var(--color-accent);
        }

        .dashboard-status-badge.pending {
            background: rgba(26, 26, 26, 0.07);
            color: var(--color-primary);
        }

        .dashboard-status-badge.cancelled {
            background: rgba(212, 165, 116, 0.08);
            color: #a07848;
        }

        @media (max-width: 1200px) {
            .dashboard-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .dashboard-main-content {
                margin-left: 0;
                padding: 5rem 1.5rem 1.5rem;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main-content {
                padding: 5rem 1rem 1rem;
            }

            .dashboard-stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
            }

            .dashboard-quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <?php

        // TOTAL REVENUE
        $revenue_query = mysqli_query($connect, "
SELECT SUM(total_amount) AS revenue 
FROM orders
");

        $revenue = mysqli_fetch_assoc($revenue_query);
        $total_revenue = $revenue['revenue'] ?? 0;


        // TOTAL ORDERS
        $order_query = mysqli_query($connect, "
SELECT COUNT(order_id) AS total_orders 
FROM orders
");

        $order = mysqli_fetch_assoc($order_query);
        $total_orders = $order['total_orders'];


        // TOTAL CUSTOMERS
        $customer_query = mysqli_query($connect, "
SELECT COUNT(DISTINCT user_email) AS total_customers 
FROM orders
");

        $customer = mysqli_fetch_assoc($customer_query);
        $total_customers = $customer['total_customers'];


        // PENDING ORDERS
        $pending_query = mysqli_query($connect, "
SELECT COUNT(order_id) AS pending_orders
FROM orders
WHERE status='pending'
");

        $pending = mysqli_fetch_assoc($pending_query);
        $pending_orders = $pending['pending_orders'];


        // RECENT ORDERS (TOP 10)
        $recent_orders = mysqli_query($connect, "
SELECT o.order_id,
       o.user_name,
       o.total_amount,
       o.status,
       o.created_at,
       oi.product_name
FROM orders o
LEFT JOIN order_items oi ON o.order_id = oi.order_id
ORDER BY o.order_id DESC
LIMIT 10
");

        // RECENT PRODUCTS (TOP 10)
        $recent_products = mysqli_query($connect, "
SELECT product_id, product_name,product_image, product_price, created_at
FROM products
ORDER BY product_id DESC
LIMIT 10
");

        ?>
        <?php include "sidebar.php"; ?>

        <main class="dashboard-main-content">
            <header class="dashboard-header">
                <h1 class="dashboard-header-title">Dashboard Overview</h1>
                <div class="dashboard-header-actions">

                    <form method="post" action="backup_database.php">
                        <button type="submit" name="backup" class="dashboard-notification-btn">Download Backup</button>
                    </form>
                    <a class="dashboard-notification-btn" href="reviews.php">🔔 Notifications</a>
                    <a class="dashboard-notification-btn" href="users.php">👤 Users</a>
                </div>
            </header>

            <div class="dashboard-stats-grid">
                <div class="dashboard-stat-card success">
                    <div class="dashboard-stat-header"><span class="dashboard-stat-title">Total Revenue</span>
                        <div class="dashboard-stat-icon">💰</div>
                    </div>
                    <div class="dashboard-stat-value">Rs. <?php echo $total_revenue; ?></div>
                    <div class="dashboard-stat-change">↑ 12.5% from last month</div>
                </div>
                <div class="dashboard-stat-card info">
                    <div class="dashboard-stat-header"><span class="dashboard-stat-title">Total Orders</span>
                        <div class="dashboard-stat-icon">📦</div>
                    </div>
                    <div class="dashboard-stat-value"><?php echo $total_orders; ?></div>
                    <div class="dashboard-stat-change">↑ 8.3% from last month</div>
                </div>
                <div class="dashboard-stat-card warning">
                    <div class="dashboard-stat-header"><span class="dashboard-stat-title">Total Customers</span>
                        <div class="dashboard-stat-icon">👥</div>
                    </div>
                    <div class="dashboard-stat-value"><?php echo $total_customers; ?></div>
                    <div class="dashboard-stat-change">↑ 15.7% from last month</div>
                </div>
                <div class="dashboard-stat-card danger">
                    <div class="dashboard-stat-header"><span class="dashboard-stat-title">Pending Orders</span>
                        <div class="dashboard-stat-icon">⏱️</div>
                    </div>
                    <div class="dashboard-stat-value"><?php echo $pending_orders; ?></div>
                    <div class="dashboard-stat-change negative">↓ 4.2% from last month</div>
                </div>
            </div>

            <!-- ======= QUICK ACTION BOXES ======= -->
            <div class="dashboard-quick-actions">

                <a href="products.php" class="dashboard-quick-action-card">
                    <div class="dashboard-quick-action-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>
                    </div>
                    <div class="dashboard-quick-action-title">Manage Products</div>
                    <div class="dashboard-quick-action-desc">Add, edit, or remove products</div>
                </a>

                <a href="orders.php" class="dashboard-quick-action-card">
                    <div class="dashboard-quick-action-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                    </div>
                    <div class="dashboard-quick-action-title">View Orders</div>
                    <div class="dashboard-quick-action-desc">Process and manage orders</div>
                </a>

                <a href="add_products.php" class="dashboard-quick-action-card">
                    <div class="dashboard-quick-action-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                        </svg>
                    </div>
                    <div class="dashboard-quick-action-title">Add Product</div>
                    <div class="dashboard-quick-action-desc">Create new product listing</div>
                </a>

            </div>

            <div class="dashboard-table-section">
                <div class="dashboard-table-header">
                    <h3 class="dashboard-table-title">Recent Orders</h3>
                    <a href="orders.php" class="dashboard-view-all-btn">View More Orders</a>
                </div>
                <table class="dashboard-data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($recent_orders)) {
                        ?>

                            <tr>

                                <td>#ORD-<?php echo $row['order_id']; ?></td>

                                <td><?php echo $row['user_name']; ?></td>

                                <td><?php echo $row['product_name']; ?></td>

                                <td>Rs. <?php echo $row['total_amount']; ?></td>

                                <td>
                                    <span class="dashboard-status-badge <?php echo $row['status']; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>

                                <td><?php echo $row['created_at']; ?></td>

                                <td>
                                </td>

                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="dashboard-table-section" style="margin-top:30px;">

                <div class="dashboard-table-header">
                    <h3 class="dashboard-table-title">Recent Products</h3>

                    <a href="products.php" class="dashboard-view-all-btn">
                        View More Products
                    </a>

                </div>

                <table class="dashboard-data-table">

                    <thead>
                        <tr>

                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Date</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        while ($product = mysqli_fetch_assoc($recent_products)) {
                        ?>

                            <tr>

                                <td>#PROD-<?php echo $product['product_id']; ?></td>

                                <td><?php echo $product['product_name']; ?></td>

                                <td>Rs. <?php echo $product['product_price']; ?></td>

                                <td><?php echo $product['created_at']; ?></td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </main>
    </div>
</body>

</html>