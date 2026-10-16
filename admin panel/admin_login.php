<?php
session_start();
include "connect.php";

$login_error = "";
$reg_success = "";
$reg_error   = "";
$active_form = "signin";

// ================= ADMIN LOGIN =================
if (isset($_POST['login'])) {
    $active_form = "signin";
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query  = "SELECT * FROM admins WHERE admin_name='$username' AND admin_password='$password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        if ($admin['status'] === 'pending')
            $login_error = "pending";
        elseif ($admin['status'] === 'rejected')
            $login_error = "rejected";
        else {
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $login_error = "wrong";
    }
}

// ================= ADMIN REGISTER =================
if (isset($_POST['register'])) {
    $active_form = "signup";
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $email    = trim($_POST['email']);

    $check = mysqli_query($connect, "SELECT * FROM admins WHERE admin_name='$username'");

    if (mysqli_num_rows($check) > 0)
        $reg_error = "This username is already taken.";
    elseif ($password !== $confirm)
        $reg_error = "Passwords do not match.";
    elseif (strlen($password) < 6)
        $reg_error = "Password must be at least 6 characters.";
    else {
        mysqli_query($connect, "
            INSERT INTO admins (admin_name, admin_password, admin_email, role, status)
            VALUES ('$username', '$password', '$email', 'admin', 'pending')
        ");
        $reg_success = "Request submitted! Waiting for super admin approval.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Jenny Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #d4a574;
            --primary: #1a1a1a;
            --secondary: #f8f8f8;
            --border: #e8e8e8;
            --text: #2c2c2c;
            --text-light: #888;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* back link */
        .back-link {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
            padding: 0.45rem 1rem 0.45rem 0.6rem;
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            border-radius: 50px;
            transition: var(--transition);
        }

        .back-link:hover {
            color: #fff;
            border-color: var(--accent);
            background: rgba(212, 165, 116, 0.1);
            transform: translateX(-3px);
        }

        /* container */
        .auth-box {
            width: 100%;
            max-width: 980px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            min-height: 580px;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: linear-gradient(160deg, #1a1a1a 0%, #2c2c2c 100%);
            padding: 3.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }

        .panel-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .panel-sub {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3.5px;
            color: rgba(255, 255, 255, 0.28);
            margin-top: 0.3rem;
            margin-bottom: 2.2rem;
        }

        .panel-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.9rem;
        }

        .panel-text {
            font-size: 0.93rem;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .panel-btn {
            padding: 0.78rem 2.4rem;
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 50px;
            font-family: 'Lato', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .panel-btn:hover {
            background: #fff;
            color: var(--primary);
            border-color: #fff;
            transform: translateY(-2px);
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            padding: 3rem 3rem 2.5rem;
            position: relative;
        }

        /* form switching */
        .auth-form {
            position: absolute;
            inset: 3rem;
            opacity: 0;
            visibility: hidden;
            transform: translateX(30px);
            transition: var(--transition);
        }

        .auth-form.active {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            position: relative;
            inset: auto;
        }

        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        /* alerts */
        .alert {
            padding: 0.82rem 1rem;
            border-radius: 9px;
            font-size: 0.82rem;
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: 1.2rem;
        }

        .a-error {
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            border-left: 4px solid #ef4444;
        }

        .a-pending {
            background: rgba(245, 158, 11, 0.08);
            color: #f59e0b;
            border-left: 4px solid #f59e0b;
        }

        .a-success {
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
            border-left: 4px solid #10b981;
        }

        /* fields */
        .field {
            margin-bottom: 1.1rem;
        }

        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #aaa;
            margin-bottom: 0.38rem;
        }

        .pw-wrap {
            position: relative;
        }

        .field input {
            width: 100%;
            padding: 0.82rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Lato', sans-serif;
            font-size: 0.93rem;
            color: var(--text);
            background: var(--secondary);
            outline: none;
            transition: var(--transition);
        }

        .field input:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .eye-btn {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #bbb;
        }

        /* submit */
        .submit-btn {
            display: block;
            width: 100%;
            padding: 0.92rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'Lato', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: var(--transition);
        }

        .submit-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(212, 165, 116, 0.32);
        }

        /* mobile toggle */
        .mob-toggle {
            display: none;
            text-align: center;
            margin-top: 1.3rem;
            font-size: 0.84rem;
            color: var(--text-light);
        }

        .mob-toggle a {
            color: var(--accent);
            font-weight: 700;
            text-decoration: none;
        }

        /* panel height */
        .right-inner {
            min-height: 460px;
            position: relative;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .auth-box {
                max-width: 680px;
            }

            .panel-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 700px) {
            .auth-box {
                grid-template-columns: 1fr;
                max-width: 440px;
                min-height: auto;
            }

            .left-panel {
                display: none;
            }

            .mob-toggle {
                display: block;
            }

            .right-panel {
                padding: 2rem 1.5rem;
            }

            .auth-form {
                inset: 2rem 1.5rem;
            }
        }

        @media (max-width: 440px) {
            .right-panel {
                padding: 1.8rem 1rem;
            }

            .auth-form {
                inset: 1.8rem 1rem;
            }

            .form-title {
                font-size: 1.9rem;
            }
        }
    </style>
</head>

<body>

    <a href="../frontend web/index.php" class="back-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6" />
        </svg>
        Back to Store
    </a>

    <div class="auth-box">

        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="panel-brand">Jenny Store</div>
            <div class="panel-sub">Admin Panel</div>
            <div class="panel-title" id="panelTitle">Welcome Back!</div>
            <div class="panel-text" id="panelText">Sign in to manage your store, orders, products and more.</div>
            <button class="panel-btn" onclick="toggleForm()"><span id="panelBtnText">Request Access</span></button>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="right-inner">

                <!-- SIGN IN -->
                <form method="POST" class="auth-form <?php echo $active_form === 'signin' ? 'active' : ''; ?>" id="signInForm">

                    <div class="form-title">Sign In</div>

                    <?php if ($login_error === 'wrong'): ?>
                        <div class="alert a-error">⚠️ Wrong username or password.</div>
                    <?php elseif ($login_error === 'pending'): ?>
                        <div class="alert a-pending">⏳ <strong>Approval Pending</strong> — Please wait for super admin to approve your account.</div>
                    <?php elseif ($login_error === 'rejected'): ?>
                        <div class="alert a-error">🚫 <strong>Request Rejected</strong> — Contact the super admin.</div>
                    <?php endif; ?>

                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Enter username" required>
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="si-pw" placeholder="Enter password" required>
                            <button type="button" class="eye-btn" onclick="togglePw('si-pw')">👁️</button>
                        </div>
                    </div>

                    <button type="submit" name="login" class="submit-btn">Sign In</button>

                    <div class="mob-toggle">
                        New admin? <a href="#" onclick="showForm('signup');return false;">Request Access</a>
                    </div>
                </form>

                <!-- REGISTER -->
                <form method="POST" class="auth-form <?php echo $active_form === 'signup' ? 'active' : ''; ?>" id="signUpForm">

                    <div class="form-title">Request Access</div>

                    <?php if ($reg_success): ?>
                        <div class="alert a-success">✅ <?php echo $reg_success; ?></div>
                    <?php endif; ?>
                    <?php if ($reg_error): ?>
                        <div class="alert a-error">⚠️ <?php echo $reg_error; ?></div>
                    <?php endif; ?>

                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Choose a username" required>
                    </div>

                    <div class="field">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="your@email.com" required>
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="ru-pw" placeholder="Min 6 characters" required>
                            <button type="button" class="eye-btn" onclick="togglePw('ru-pw')">👁️</button>
                        </div>
                    </div>

                    <div class="field">
                        <label>Confirm Password</label>
                        <div class="pw-wrap">
                            <input type="password" name="confirm_password" id="ru-cf" placeholder="Re-enter password" required>
                            <button type="button" class="eye-btn" onclick="togglePw('ru-cf')">👁️</button>
                        </div>
                    </div>

                    <button type="submit" name="register" class="submit-btn">Submit Request</button>

                    <div class="mob-toggle">
                        Already have access? <a href="#" onclick="showForm('signin');return false;">Sign In</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        var cur = '<?php echo $active_form; ?>';
        updatePanel(cur);

        function showForm(which) {
            cur = which;
            document.getElementById('signInForm').classList.toggle('active', which === 'signin');
            document.getElementById('signUpForm').classList.toggle('active', which === 'signup');
            updatePanel(which);
        }

        function toggleForm() {
            showForm(cur === 'signin' ? 'signup' : 'signin');
        }

        function updatePanel(which) {
            const t = document.getElementById('panelTitle');
            const p = document.getElementById('panelText');
            const b = document.getElementById('panelBtnText');
            if (which === 'signin') {
                t.textContent = 'Welcome Back!';
                p.textContent = 'Sign in to manage your store, orders, products and more.';
                b.textContent = 'Request Access';
            } else {
                t.textContent = 'Already an Admin?';
                p.textContent = 'Sign in to your existing account to access the dashboard.';
                b.textContent = 'Sign In';
            }
        }

        function togglePw(id) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>