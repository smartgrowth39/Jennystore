<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

$total_messages = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as total FROM contact_messages"))['total'];
$today_messages = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as total FROM contact_messages WHERE DATE(created_at) = CURDATE()"))['total'];
$week_messages  = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as total FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)"))['total'];

$where = "WHERE 1";

if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR subject LIKE '%$search%')";
}

if (!empty($_GET['date_from'])) {
    $where .= " AND DATE(created_at) >= '" . $_GET['date_from'] . "'";
}

if (!empty($_GET['date_to'])) {
    $where .= " AND DATE(created_at) <= '" . $_GET['date_to'] . "'";
}

$query  = "SELECT * FROM contact_messages $where ORDER BY id DESC";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Jenny Store Admin</title>

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

        /* ── STATS ── */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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

        .stat-card.today {
            border-left-color: var(--color-success);
        }

        .stat-card.week {
            border-left-color: var(--color-warning);
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

        /* ── FILTER ── */
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
            font-family: var(--font-body);
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
            font-family: var(--font-body);
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: var(--color-primary);
        }

        /* ── TABLE ── */
        .messages-table-section {
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            overflow-x: auto;
        }

        .messages-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .messages-table thead tr {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .messages-table th {
            padding: 1rem 1.2rem;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .messages-table thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .messages-table thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .messages-table td {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
            font-size: 0.93rem;
        }

        .messages-table tbody tr:last-child td {
            border-bottom: none;
        }

        .messages-table tbody tr {
            transition: var(--transition);
        }

        .messages-table tbody tr:hover {
            background: #fdf8f4;
        }

        .msg-id {
            font-weight: 700;
            color: var(--color-info);
            white-space: nowrap;
        }

        .sender-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .sender-avatar {
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

        .sender-name {
            font-weight: 600;
            color: var(--color-primary);
        }

        .sender-email {
            font-size: 0.82rem;
            color: var(--color-text-light);
        }

        .subject-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: rgba(212, 165, 116, 0.12);
            color: var(--color-accent);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .msg-text {
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--color-text-light);
            font-size: 0.88rem;
        }

        .date-cell {
            white-space: nowrap;
            color: var(--color-text-light);
            font-size: 0.88rem;
        }

        .no-messages td {
            text-align: center;
            padding: 3rem !important;
            color: var(--color-text-light);
            font-size: 1rem;
        }

        /* ── RESPONSIVE ── */
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

            <!-- Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-header-title">Contact Messages</h1>
            </div>

            <!-- Stats -->
            <div class="stats-cards">
                <div class="stat-card total">
                    <div class="stat-label">Total Messages</div>
                    <div class="stat-value"><?php echo $total_messages; ?></div>
                </div>
                <div class="stat-card today">
                    <div class="stat-label">Today</div>
                    <div class="stat-value"><?php echo $today_messages; ?></div>
                </div>
                <div class="stat-card week">
                    <div class="stat-label">This Week</div>
                    <div class="stat-value"><?php echo $week_messages; ?></div>
                </div>
            </div>

            <!-- Filter -->
            <form class="filter-section" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Search Messages</label>
                        <input type="text" name="search" class="form-input"
                            placeholder="Search by name, email, subject..."
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-input"
                            value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-input"
                            value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>">
                    </div>
                    <button class="btn-filter" type="submit">Apply Filter</button>
                </div>
            </form>

            <!-- Table -->
            <div class="messages-table-section">
                <table class="messages-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><span class="msg-id">#MSG-<?php echo $row['id']; ?></span></td>
                                    <td>
                                        <div class="sender-info">
                                            <div class="sender-avatar">
                                                <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <div class="sender-name"><?php echo $row['name']; ?></div>
                                                <div class="sender-email"><?php echo $row['email']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><span class="subject-badge"><?php echo $row['subject']; ?></span></td>
                                    <td>
                                        <div class="msg-text"><?php echo $row['message']; ?></div>
                                    </td>
                                    <td class="date-cell"><?php echo $row['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr class="no-messages">
                                <td colspan="6">No messages yet</td>
                            </tr>
                        <?php endif; ?>
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