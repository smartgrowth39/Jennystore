
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

$current = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM admins WHERE admin_name='" . $_SESSION['admin'] . "'"));

$store_success = "";
$pass_success  = "";
$pass_error    = "";

if (isset($_POST['save_store'])) {
    if ($current['role'] === 'super_admin') {
        $store_success = "Store information saved successfully.";
    }
}

if (isset($_POST['update_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass     = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($current_pass !== $current['admin_password']) {
        $pass_error = "Current password is incorrect.";
    } elseif (strlen($new_pass) < 6) {
        $pass_error = "New password must be at least 6 characters.";
    } elseif ($new_pass !== $confirm_pass) {
        $pass_error = "New passwords do not match.";
    } else {
        mysqli_query($connect, "UPDATE admins SET admin_password='$new_pass' WHERE admin_id='" . $current['admin_id'] . "'");
        $pass_success = "Password updated successfully!";
        $current = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM admins WHERE admin_name='" . $_SESSION['admin'] . "'"));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Jenny Store Admin</title>
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
            margin-left: 260px;
            flex: 1;
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--color-white);
            padding: 1.2rem 1.8rem;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .admin-pill {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--color-secondary);
            border: 1px solid var(--color-border);
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .admin-pill .dot {
            width: 8px;
            height: 8px;
            background: var(--color-success);
            border-radius: 50%;
        }

        .admin-pill .name {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--color-text);
        }

        .role-tag {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.18rem 0.55rem;
            border-radius: 50px;
            background: var(--color-primary);
            color: #fff;
        }

        .role-tag.gold {
            background: var(--color-accent);
        }

        .settings-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .settings-card {
            background: var(--color-white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
        }

        .settings-card-title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.4rem;
        }

        .settings-card-description {
            color: var(--color-text-light);
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
        }

        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.08);
            color: var(--color-success);
            border-left: 4px solid var(--color-success);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            color: var(--color-danger);
            border-left: 4px solid var(--color-danger);
        }

        .form-group {
            margin-bottom: 1.4rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #999;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.82rem 1rem;
            border: 1.5px solid var(--color-border);
            border-radius: 9px;
            font-family: var(--font-body);
            font-size: 0.93rem;
            color: var(--color-text);
            background: #fafafa;
            outline: none;
            transition: var(--transition);
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--color-accent);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .form-input:disabled,
        .form-textarea:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .btn {
            padding: 0.78rem 1.6rem;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            font-weight: 700;
            font-family: var(--font-body);
            font-size: 0.83rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .btn-primary:hover {
            background: var(--color-accent);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.3);
        }

        .locked-note {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #bbb;
            margin-bottom: 1.2rem;
        }

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
            .dashboard-main {
                padding: 5rem 1rem 1rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
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
                <h1 class="page-title">Settings</h1>
                <div class="admin-pill">
                    <div class="dot"></div>
                    <span class="name"><?php echo $current['admin_name']; ?></span>
                    <span class="role-tag <?php echo $current['role'] === 'super_admin' ? 'gold' : ''; ?>">
                        <?php echo $current['role'] === 'super_admin' ? '★ Super Admin' : 'Admin'; ?>
                    </span>
                </div>
            </div>

            <div class="settings-content">

                <!-- Store Info -->
                <div class="settings-card">
                    <h2 class="settings-card-title">Store Information</h2>
                    <p class="settings-card-description">Basic store details and contact info</p>

                    <?php if ($store_success): ?>
                        <div class="alert alert-success">✅ <?php echo $store_success; ?></div>
                    <?php endif; ?>

                    <?php if ($current['role'] !== 'super_admin'): ?>
                        <p class="locked-note">🔒 Only Super Admin can edit store information.</p>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Store Name</label>
                                <input type="text" class="form-input" value="Jenny's Cosmetics & Jewelry" <?php echo $current['role'] !== 'super_admin' ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Email</label>
                                <input type="email" class="form-input" value="jenny.cosmetics@gmail.com" <?php echo $current['role'] !== 'super_admin' ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-input" value="+92 333 1371483" <?php echo $current['role'] !== 'super_admin' ? 'disabled' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="tel" class="form-input" value="+92 333 1371483" <?php echo $current['role'] !== 'super_admin' ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Store Address</label>
                            <textarea class="form-textarea" <?php echo $current['role'] !== 'super_admin' ? 'disabled' : ''; ?>>Shop #12, Main Market, Karachi, Pakistan</textarea>
                        </div>
                        <?php if ($current['role'] === 'super_admin'): ?>
                            <div class="form-actions">
                                <button type="submit" name="save_store" class="btn btn-primary">Save Store Info</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Password Update -->
                <div class="settings-card">
                    <h2 class="settings-card-title">Update Your Password</h2>
                    <p class="settings-card-description">Logged in as <strong><?php echo $current['admin_name']; ?></strong> — you can only change your own password.</p>

                    <?php if ($pass_success): ?>
                        <div class="alert alert-success">✅ <?php echo $pass_success; ?></div>
                    <?php endif; ?>
                    <?php if ($pass_error): ?>
                        <div class="alert alert-error">⚠️ <?php echo $pass_error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-input" placeholder="Enter current password" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-input" placeholder="Min 6 characters" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-input" placeholder="Re-enter new password" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
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