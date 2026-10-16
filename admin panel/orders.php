
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
// include "connect.php";

// /* =========================
//    DELETE ORDER
// ========================= */
// if (isset($_POST['delete_order'])) {
//     $order_id = $_POST['order_id'];

//     mysqli_query($connect, "DELETE FROM orders WHERE order_id = '$order_id'");

//     header("Location: orders.php");
//     exit;
// }


?>


<?php
include "connect.php";


/* =========================
   ORDER STATS
========================= */

$total_orders = mysqli_fetch_assoc(mysqli_query(
    $connect,
    "SELECT COUNT(*) as total FROM orders"
))['total'];

$delivered_orders = mysqli_fetch_assoc(mysqli_query(
    $connect,
    "SELECT COUNT(*) as total FROM orders WHERE status='Delivered'"
))['total'];

$pending_orders = mysqli_fetch_assoc(mysqli_query(
    $connect,
    "SELECT COUNT(*) as total FROM orders WHERE status='pending'"
))['total'];

$cancelled_orders = mysqli_fetch_assoc(mysqli_query(
    $connect,
    "SELECT COUNT(*) as total FROM orders WHERE status='cancelled'"
))['total'];


if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    // pehle order_items delete karo
    mysqli_query($connect, "DELETE FROM order_items WHERE order_id='$order_id'");

    // phir order delete karo
    mysqli_query($connect, "DELETE FROM orders WHERE order_id='$order_id'");

    header("Location: orders.php");
    exit;
}

$where = "WHERE 1";

if(!empty($_GET['search'])){
    $search = $_GET['search'];
    $where .= " AND (order_id LIKE '%$search%' OR user_name LIKE '%$search%')";
}

if(!empty($_GET['status'])){
    $status = $_GET['status'];
    $where .= " AND status='$status'";
}

if(!empty($_GET['date_from'])){
    $from = $_GET['date_from'];
    $where .= " AND order_date >= '$from'";
}

if(!empty($_GET['date_to'])){
    $to = $_GET['date_to'];
    $where .= " AND order_date <= '$to'";
}

$query = "SELECT * FROM orders $where ORDER BY order_id DESC";
$result = mysqli_query($connect,$query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Jenny Store Admin</title>

    <?php include "links.php"; ?>

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

        .btn-export {
            padding: 0.7rem 1.5rem;
            background: var(--color-info);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.95rem;
            font-family: var(--font-body);
        }

        .btn-export:hover {
            background: #2563eb;
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
            border-left: 4px solid;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .stat-card.total {
            border-left-color: var(--color-info);
        }

        .stat-card.completed {
            border-left-color: var(--color-success);
        }

        .stat-card.pending {
            border-left-color: var(--color-warning);
        }

        .stat-card.cancelled {
            border-left-color: var(--color-danger);
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
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
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

        .form-input,
        .form-select {
            padding: 0.7rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: var(--transition);
            font-family: var(--font-body);
        }

        .form-input:focus,
        .form-select:focus {
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
            font-family: var(--font-body);
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: var(--color-primary);
        }

        .orders-table-section {
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        .orders-table thead tr {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .orders-table th {
            padding: 1rem 1.2rem;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .orders-table thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .orders-table thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .orders-table td {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
            font-size: 0.93rem;
        }

        .orders-table tbody tr:last-child td {
            border-bottom: none;
        }

        .orders-table tbody tr {
            transition: var(--transition);
        }

        .orders-table tbody tr:hover {
            background: #fdf8f4;
        }

        .order-id {
            font-weight: 700;
            color: var(--color-info);
            white-space: nowrap;
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--color-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .customer-details {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 600;
            color: var(--color-primary);
        }

        .customer-email {
            font-size: 0.82rem;
            color: var(--color-text-light);
        }

        .status-badge {
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            white-space: nowrap;
        }

        .status-badge.completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--color-success);
        }

        .status-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--color-warning);
        }

        .status-badge.processing {
            background: rgba(59, 130, 246, 0.1);
            color: var(--color-info);
        }

        .status-badge.cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--color-danger);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
            font-family: var(--font-body);
        }

        .btn-delete {
            background: var(--color-danger);
            color: var(--color-white);
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .no-orders td {
            text-align: center;
            padding: 3rem !important;
            color: var(--color-text-light);
            font-size: 1rem;
        }

        @media (max-width: 992px) {
            .dashboard-sidebar {
                transform: translateX(-100%);
            }

            .dashboard-sidebar.active {
                transform: translateX(0);
            }

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

            <div class="dashboard-header">
                <h1 class="dashboard-header-title">Orders Management</h1>
                <div class="dashboard-header-actions">
                    <button class="btn-export">📥 Export Orders</button>
                </div>
            </div>

            <div class="stats-cards">
                <div class="stat-card total">
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value"><?php echo $total_orders; ?></div>
                </div>
                <div class="stat-card completed">
                    <div class="stat-label">Delivered</div>
                    <div class="stat-value"><?php echo $delivered_orders; ?></div>
                </div>
                <div class="stat-card pending">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value"><?php echo $pending_orders; ?></div>
                </div>
                <div class="stat-card cancelled">
                    <div class="stat-label">Cancelled</div>
                    <div class="stat-value"><?php echo $cancelled_orders; ?></div>
                </div>
            </div>

            <form class="filter-section" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Search Orders</label>
                        <input type="text" name="search" class="form-input" placeholder="Search by Order ID, Customer Name...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-input">
                    </div>
                    <button class="btn-filter" type="submit">Apply Filter</button>
                </div>
            </form>

            <div class="orders-table-section">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Date</th>
                            <th>Country</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $query = "SELECT * FROM orders ORDER BY order_id DESC";
                        // $result = mysqli_query($connect, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td><span class='order-id'>#ORD-" . $row['order_id'] . "</span></td>";
                                echo "<td>
                                        <div class='customer-info'>
                                            <div class='customer-avatar'>" . strtoupper(substr($row['user_name'], 0, 1)) . "</div>
                                            <div class='customer-details'>
                                                <span class='customer-name'>" . $row['user_name'] . "</span>
                                            </div>
                                        </div>
                                      </td>";
                                echo "<td class='customer-email'>" . $row['user_email'] . "</td>";
                                echo "<td>" . $row['user_phone'] . "</td>";
                                echo "<td>" . $row['user_address'] . "</td>";
                                echo "<td>" . $row['city'] . "</td>";
                                echo "<td>" . $row['state'] . "</td>";
                                echo "<td>" . $row['zip_code'] . "</td>";
                                echo "<td>" . $row['order_date'] . "</td>";
                                echo "<td>" . $row['select_country'] . "</td>";
                                echo "<td>" . $row['total_amount'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>
<div class='action-buttons'>

<a href='view-orders.php?id=" . $row['order_id'] . "' 
   class='btn-action' 
   style='background:#3b82f6;color:white;text-decoration:none;'>
   View
</a>

<a href='order-status.php?id=" . $row['order_id'] . "' 
class='btn-action' 
style='background:#10b981;color:white;text-decoration:none;'>
Edit
</a>

<form method='POST' style='display:inline;'>
    <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
    <button type='submit' name='delete_order' class='btn-action btn-delete'>
        Delete
    </button>
</form>

</div>
</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr class='no-orders'><td colspan='11' style='text-align:center'>No orders yet</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
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