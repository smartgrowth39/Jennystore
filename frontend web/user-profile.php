<?php
session_start();
include "connect.php";

if(!isset($_SESSION['email'])){
header("Location:user.php");
exit();
}

$email = $_SESSION['email'];

$query = mysqli_query($connect,"SELECT * FROM user_data WHERE user_email='$email'");
$user = mysqli_fetch_assoc($query);


if(isset($_POST['update_password'])){

$current = $_POST['current_password'];
$new = $_POST['new_password'];

$db_pass = $user['user_pass'];

if(password_verify($current,$db_pass)){

$new_hash = password_hash($new,PASSWORD_DEFAULT);

mysqli_query($connect,"
UPDATE user_data 
SET user_pass='$new_hash' 
WHERE user_email='$email'
");

echo "<script>alert('Password Updated Successfully')</script>";

}else{

echo "<script>alert('Current Password Incorrect')</script>";

}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Jenny Store</title>
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
            --font-display:     'Cormorant Garamond', serif;
            --font-body:        'Lato', sans-serif;
            --transition:       all 0.3s ease;
            --shadow-soft:      0 2px 20px rgba(0,0,0,0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--color-secondary);
            color: var(--color-text);
        }

        .profile-page {
            min-height: 80vh;
            padding: 4rem 1.5rem;
        }

        .profile-container {
            max-width: 860px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        .profile-page-title {
            grid-column: 1 / -1;
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 600;
            color: var(--color-primary);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .profile-page-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--color-accent);
            margin: 12px auto 0;
            border-radius: 2px;
        }

        .profile-card {
            background: var(--color-white);
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            padding: 2rem;
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--color-border);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .card-title i { color: var(--color-accent); font-size: 1.2rem; }

        .profile-avatar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.8rem;
            gap: 0.6rem;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: var(--color-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--color-white);
        }

        .profile-avatar-name {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-primary);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 0;
            border-bottom: 1px solid var(--color-border);
            gap: 1rem;
        }

        .info-row:last-child { border-bottom: none; }

        .info-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--color-text-light);
            white-space: nowrap;
        }

        .info-value {
            font-size: 0.97rem;
            color: var(--color-primary);
            font-weight: 500;
            text-align: right;
            word-break: break-all;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1.1rem;
        }

        .field label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--color-text-light);
        }

        .field input[type="password"] {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid var(--color-border);
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--color-text);
            outline: none;
            transition: var(--transition);
            background: var(--color-white);
        }

        .field input[type="password"]:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(212,165,116,0.12);
        }

        .field input[type="password"]::placeholder { color: #bbb; }

        button[name="update_password"] {
            width: 100%;
            padding: 0.9rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 10px;
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.4rem;
        }

        button[name="update_password"]:hover {
            background: #c9965d;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212,165,116,0.35);
        }

        @media (max-width: 768px) {
            .profile-container { grid-template-columns: 1fr; }
            .profile-page { padding: 3rem 1rem; }
            .profile-page-title { font-size: 2.2rem; }
        }
    </style>
</head>
<body>

    <?php include "nav.php"; ?>

    <div class="profile-page">
        <div class="profile-container">

            <h2 class="profile-page-title">My Profile</h2>

            <!-- Info Card -->
            <div class="profile-card">
                <div class="card-title">
                    <i class="fas fa-user"></i> Account Details
                </div>

                <div class="profile-avatar-wrap">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($user['user_firstname'], 0, 1)); ?>
                    </div>
                    <div class="profile-avatar-name">
                        <?php echo $user['user_firstname'] . ' ' . $user['user_lastname']; ?>
                    </div>
                </div>

                <div class="info-row">
                    <span class="info-label">First Name</span>
                    <span class="info-value"><?php echo $user['user_firstname']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Name</span>
                    <span class="info-value"><?php echo $user['user_lastname']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?php echo $user['user_email']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value"><?php echo $user['user_phone']; ?></span>
                </div>
            </div>

            <!-- Password Card -->
            <div class="profile-card">
                <div class="card-title">
                    <i class="fas fa-lock"></i> Change Password
                </div>

                <form method="POST">
                    <div class="field">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="Current Password" required>
                    </div>
                    <div class="field">
                        <label>New Password</label>
                        <input type="password" name="new_password" placeholder="New Password" required>
                    </div>
                    <button type="submit" name="update_password">Update Password</button>
                </form>
            </div>

        </div>
    </div>

    <?php include "footer.php"; ?>

</body>
</html>