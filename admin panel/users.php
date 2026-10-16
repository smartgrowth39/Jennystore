
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php

include "connect.php";

$search = $_GET['search'] ?? '';

// $query = "SELECT * FROM user_data ORDER BY user_firstname ASC";

$query = "SELECT * FROM user_data WHERE 1=1";

if ($search != '') {
    $query .= " AND (user_firstname LIKE '%$search%' 
OR user_lastname LIKE '%$search%' 
OR user_email LIKE '%$search%' 
OR user_phone LIKE '%$search%')";
}

$query .= " ORDER BY user_firstname ASC";

$result = mysqli_query($connect, $query);

$total_customers = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Jenny Store Admin</title>
    <?php
    include "links.php";
    ?>
    <style>
        :root {
            --color-primary: #1a1a1a;
            --color-secondary: #f8f8f8;
            --color-accent: #d4a574;
            --color-white: #ffffff;
            --color-text: #2c2c2c;
            --color-text-light: #666666;
            --color-border: #e8e8e8;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --color-info: #3b82f6;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.3s ease;
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

        .btn-primary {
            padding: 0.7rem 1.5rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            background: var(--color-primary);
            transform: translateY(-2px);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: rgba(59, 130, 246, 0.1);
            color: var(--color-info);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: rgba(16, 185, 129, 0.1);
            color: var(--color-success);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--color-warning);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: rgba(239, 68, 68, 0.1);
            color: var(--color-danger);
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .filter-section {
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.5rem;
        }

        .form-input {
            padding: 0.7rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        .btn-filter {
            padding: 0.7rem 1.5rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-filter:hover {
            background: var(--color-primary);
        }

        .customers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .customer-card {
            background: var(--color-white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
        }

        .customer-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .customer-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--color-border);
        }

        .customer-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--color-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .customer-info {
            flex: 1;
        }

        .customer-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.3rem;
        }

        .customer-email {
            font-size: 0.9rem;
            color: var(--color-text-light);
        }

        .customer-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .customer-stat-item {
            text-align: center;
        }

        .customer-stat-label {
            font-size: 0.8rem;
            color: var(--color-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.3rem;
        }

        .customer-stat-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--color-accent);
        }

        .customer-details {
            margin-bottom: 1rem;
        }

        .customer-detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
            color: var(--color-text);
        }

        .detail-icon {
            color: var(--color-primary);
            font-size: 1rem;
        }

        .customer-detail {
            color: var(--color-accent);
            font-size: larger;
        }

        .badge-vip {
            background: rgba(212, 165, 116, 0.2);
            color: var(--color-accent);
        }

        .badge-new {
            background: rgba(16, 185, 129, 0.1);
            color: var(--color-success);
        }

        .btn-view-orders {
            display: block;
            text-align: center;
            margin-top: 2rem;
            padding: 8px;
            background: var(--color-primary);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-view-orders:hover {
            background: var(--color-accent);
        }

        @media (max-width: 992px) {

            .dashboard-main-content {
                margin-left: 0;
                padding: 5rem 1.5rem 1.5rem;
            }

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main-content {
                padding: 5rem 1rem 1rem;
            }

            .customers-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">

        <?php include "sidebar.php"; ?>

        <main class="dashboard-main-content">
            <header class="dashboard-header">
                <h1 class="dashboard-header-title">Customers Management</h1>
                <div class="dashboard-header-actions">
                    <button class="btn-primary">📥 Export Customers</button>
                </div>
            </header>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-value"><?php echo $total_customers; ?></div>
                </div>
            </div>

            <form class="filter-section" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Search Customers</label>
                        <input type="text" name="search" class="form-input" placeholder="Search by name, email, or phone...">
                    </div>
                    <button class="btn-filter" type="submit">Apply Filters</button>
                </div>
            </form>

            <div class="customers-grid">

                <?php

                while ($row = mysqli_fetch_assoc($result)) {

                    $firstname = $row['user_firstname'];
                    $lastname  = $row['user_lastname'];
                    $email     = $row['user_email'];
                    $phone     = $row['user_phone'];

                    $order_query = "SELECT 
COUNT(order_id) as total_orders,
SUM(total_amount) as total_spent
FROM orders
WHERE user_email = '$email'";

                    $order_result = mysqli_query($connect, $order_query);
                    $order_data = mysqli_fetch_assoc($order_result);

                    $total_orders = $order_data['total_orders'];
                    $total_spent  = $order_data['total_spent'];

                    if ($total_spent == NULL) {
                        $total_spent = 0;
                    }


                    $initial = strtoupper(substr($firstname, 0, 1) . substr($lastname, 0, 1));

                ?>

                    <div class="customer-card">

                        <div class="customer-header">
                            <div class="customer-avatar"><?php echo $initial; ?></div>

                            <div class="customer-info">
                                <h3 class="customer-name"><?php echo $firstname . " " . $lastname; ?></h3>
                                <p class="customer-email"><?php echo $email; ?></p>
                            </div>
                        </div>

                        <div class="customer-stats">

                            <div class="customer-stat-item">
                                <div class="customer-stat-label">Orders</div>
                                <div class="customer-stat-value"><?php echo "$total_orders" ?></div>
                            </div>

                            <div class="customer-stat-item">
                                <div class="customer-stat-label">Spent</div>
                                <div class="customer-stat-value"><?php echo "$total_spent" ?></div>
                            </div>

                        </div>

                        <div class="customer-details">

                            <div class="customer-detail-item">
                                <span class="detail-icon">Phone Number</span>
                                <span class="customer-detail"><?php echo $phone; ?></span>
                            </div>

                            <div class="customer-detail-item">
                                <span class="detail-icon">Country</span>
                                <span class="customer-detail">Pakistan</span>
                            </div>

                        </div>

                        <a href="orders.php?email=<?php echo $email; ?>" class="btn-view-orders">
                            View Orders
                        </a>

                    </div>

                <?php } ?>

            </div>
        </main>
    </div>

</body>

</html>