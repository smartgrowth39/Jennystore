
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

// Only super_admin can access this page
$current = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM admins WHERE admin_name='" . $_SESSION['admin'] . "'"));
if ($current['role'] !== 'super_admin') {
    header("Location: dashboard.php");
    exit();
}

// Approve
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    mysqli_query($connect, "UPDATE admins SET status='active' WHERE admin_id='$id'");
    header("Location: manage-admins.php");
    exit();
}

// Reject
if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    mysqli_query($connect, "UPDATE admins SET status='rejected' WHERE admin_id='$id'");
    header("Location: manage-admins.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($id != $current['admin_id']) { // can't delete yourself
        mysqli_query($connect, "DELETE FROM admins WHERE admin_id='$id'");
    }
    header("Location: manage-admins.php");
    exit();
}

$pending  = mysqli_query($connect, "SELECT * FROM admins WHERE status='pending' ORDER BY created_at DESC");
$all      = mysqli_query($connect, "SELECT * FROM admins WHERE status != 'pending' ORDER BY created_at DESC");
$pcount   = mysqli_num_rows($pending);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - Jenny Store</title>
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
            --color-danger: #ef4444;
            --color-warning: #f59e0b;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.3s ease;
            --shadow-soft: 0 2px 20px rgba(0, 0, 0, 0.06);
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

        .dashboard-main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        /* page header */
        .page-header {
            background: var(--color-white);
            padding: 1.3rem 1.8rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .pending-badge {
            background: var(--color-warning);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
        }

        /* section */
        .section-block {
            margin-bottom: 2.5rem;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .section-label h2 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        /* table card */
        .table-card {
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            overflow: hidden;
        }

        .table-title-row {
            padding: 1.3rem 1.8rem;
            border-bottom: 1px solid var(--color-border);
        }

        .table-title-row h2 {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        thead tr {
            background: var(--color-primary);
        }

        thead th {
            padding: 1rem 1.2rem;
            text-align: left;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--color-border);
            transition: background 0.2s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody td {
            padding: 1rem 1.2rem;
            vertical-align: middle;
        }

        .td-id {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--color-text-light);
            background: var(--color-secondary);
            border: 1px solid var(--color-border);
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
        }

        .td-name {
            font-weight: 700;
            color: var(--color-primary);
        }

        .td-email {
            font-size: 0.85rem;
            color: var(--color-text-light);
        }

        .td-date {
            font-size: 0.8rem;
            color: var(--color-text-light);
            white-space: nowrap;
        }

        /* role badge */
        .role-badge {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.22rem 0.7rem;
            border-radius: 50px;
        }

        .role-super {
            background: #1a1a1a;
            color: #fff;
        }

        .role-admin {
            background: #e8e8e8;
            color: #555;
        }

        /* status badge */
        .status-badge {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.22rem 0.7rem;
            border-radius: 50px;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* action buttons */
        .btn-approve {
            display: inline-block;
            padding: 0.38rem 0.9rem;
            background: transparent;
            color: var(--color-success);
            border: 1.5px solid rgba(16, 185, 129, 0.35);
            border-radius: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: var(--transition);
            margin-right: 0.4rem;
        }

        .btn-approve:hover {
            background: var(--color-success);
            border-color: var(--color-success);
            color: #fff;
        }

        .btn-reject {
            display: inline-block;
            padding: 0.38rem 0.9rem;
            background: transparent;
            color: var(--color-warning);
            border: 1.5px solid rgba(245, 158, 11, 0.35);
            border-radius: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: var(--transition);
            margin-right: 0.4rem;
        }

        .btn-reject:hover {
            background: var(--color-warning);
            border-color: var(--color-warning);
            color: #fff;
        }

        .btn-delete {
            display: inline-block;
            padding: 0.38rem 0.9rem;
            background: transparent;
            color: var(--color-danger);
            border: 1.5px solid rgba(239, 68, 68, 0.35);
            border-radius: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-delete:hover {
            background: var(--color-danger);
            border-color: var(--color-danger);
            color: #fff;
        }

        .empty-row td {
            text-align: center;
            padding: 2.5rem;
            color: var(--color-text-light);
            font-style: italic;
        }

        /* mobile */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--color-accent);
            color: #fff;
            border: none;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            box-shadow: var(--shadow-soft);
        }

        .mobile-menu-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .mobile-menu-overlay.active {
            display: block;
        }

        @media (max-width: 992px) {
            .mobile-menu-toggle {
                display: block;
            }

            .dashboard-main {
                margin-left: 0;
                padding: 5rem 1.5rem 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-title {
                font-size: 1.6rem;
            }

            thead th,
            tbody td {
                padding: 0.8rem 1rem;
            }
        }
    </style>
</head>

<body>
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰ Menu</button>
    <div class="mobile-menu-overlay" onclick="toggleSidebar()"></div>

    <div class="dashboard">

        <?php include "sidebar.php"; ?>

        <main class="dashboard-main">

            <div class="page-header">
                <h1 class="page-title">Manage Admins</h1>
                <?php if ($pcount > 0): ?>
                    <span class="pending-badge">⏳ <?php echo $pcount; ?> Pending Request<?php echo $pcount > 1 ? 's' : ''; ?></span>
                <?php endif; ?>
            </div>

            <!-- Pending Requests -->
            <div class="section-block">
                <div class="table-card">
                    <div class="table-title-row">
                        <h2>⏳ Pending Requests</h2>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Requested</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pending = mysqli_query($connect, "SELECT * FROM admins WHERE status='pending' ORDER BY created_at DESC");
                                if (mysqli_num_rows($pending) == 0): ?>
                                    <tr class="empty-row">
                                        <td colspan="5">No pending requests</td>
                                    </tr>
                                    <?php else:
                                    while ($row = mysqli_fetch_assoc($pending)): ?>
                                        <tr>
                                            <td><span class="td-id">#<?php echo $row['admin_id']; ?></span></td>
                                            <td><span class="td-name"><?php echo $row['admin_name']; ?></span></td>
                                            <td><span class="td-email"><?php echo $row['admin_email']; ?></span></td>
                                            <td><span class="td-date"><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></span></td>
                                            <td>
                                                <a href="?approve=<?php echo $row['admin_id']; ?>" class="btn-approve" onclick="return confirm('Approve this admin?')">✓ Approve</a>
                                                <a href="?reject=<?php echo $row['admin_id']; ?>" class="btn-reject" onclick="return confirm('Reject this request?')">✕ Reject</a>
                                            </td>
                                        </tr>
                                <?php endwhile;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- All Admins -->
            <div class="section-block">
                <div class="table-card">
                    <div class="table-title-row">
                        <h2>All Admins</h2>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $all = mysqli_query($connect, "SELECT * FROM admins WHERE status != 'pending' ORDER BY admin_id ASC");
                                while ($row = mysqli_fetch_assoc($all)): ?>
                                    <tr>
                                        <td><span class="td-id">#<?php echo $row['admin_id']; ?></span></td>
                                        <td><span class="td-name"><?php echo $row['admin_name']; ?></span></td>
                                        <td><span class="td-email"><?php echo $row['admin_email'] ?? '—'; ?></span></td>
                                        <td>
                                            <span class="role-badge <?php echo $row['role'] === 'super_admin' ? 'role-super' : 'role-admin'; ?>">
                                                <?php echo $row['role'] === 'super_admin' ? '★ Super Admin' : 'Admin'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $row['status']; ?>">
                                                <?php echo ucfirst($row['status']); ?>
                                            </span>
                                        </td>
                                        <td><span class="td-date"><?php echo $row['created_at'] ? date('d M Y', strtotime($row['created_at'])) : '—'; ?></span></td>
                                        <td>
                                            <?php if ($row['admin_id'] != $current['admin_id']): ?>
                                                <a href="?delete=<?php echo $row['admin_id']; ?>" class="btn-delete" onclick="return confirm('Delete this admin permanently?')">Delete</a>
                                            <?php else: ?>
                                                <span style="font-size:0.78rem;color:#bbb;">You</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    </script>

</body>

</html>