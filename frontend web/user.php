<?php
session_start();
include "connect.php";

// ================= SIGNUP =================

if(isset($_POST['signup'])){

$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$password  = $_POST['password'];
$confirm   = $_POST['confirm'];

if($password != $confirm){

echo "<script>alert('Password Not Match');</script>";

}else{

// ================= EMAIL CHECK =================

$check_email = mysqli_query($connect,"SELECT * FROM user_data WHERE user_email='$email'");

if(mysqli_num_rows($check_email) > 0){

echo "<script>alert('This Email Already Exists. Please Login');</script>";

}else{

// PASSWORD HASH
$hash_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO user_data 
(user_firstname,user_lastname,user_email,user_phone,user_pass) 
VALUES 
('$firstname','$lastname','$email','$phone','$hash_password')";

$result = mysqli_query($connect,$query);

if($result){

echo "<script>alert('Account Created Successfully');</script>";

}else{

echo "<script>alert('Signup Failed');</script>";

}

}

}

}



// ================= LOGIN =================

if(isset($_POST['login'])){

$email    = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM user_data WHERE user_email='$email'";

$result = mysqli_query($connect,$query);

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);

$stored_password = $row['user_pass'];

// PASSWORD VERIFY
if(password_verify($password,$stored_password)){

$_SESSION['user'] = $row['user_lastname'];
$_SESSION['email'] = $row['user_email'];

header("Location: buy-now.php");
exit();

}else{

echo "<script>alert('Invalid Password');</script>";

}

}else{

echo "<script>alert('Email Not Found');</script>";

}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In / Sign Up - Jenny Store</title>
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
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* ======= BACK BUTTON ======= */
        .auth-back-btn {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            margin-bottom: 1.2rem;
            padding: 0.5rem 1rem 0.5rem 0.7rem;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            transition: var(--transition);
        }

        .auth-back-btn:hover {
            color: #ffffff;
            border-color: var(--color-accent);
            background: rgba(212, 165, 116, 0.1);
            transform: translateX(-3px);
        }

        .auth-back-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: var(--transition);
        }

        .auth-container {
            background: var(--color-white);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            min-height: 660px;
        }

        /* Left Side - Welcome Panel */
        .welcome-panel {
            background: linear-gradient(135deg, var(--color-primary) 0%, #2c2c2c 100%);
            color: var(--color-white);
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--color-accent), transparent);
        }

        .logo {
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 700;
            color: var(--color-accent);
            margin-bottom: 1.5rem;
        }

        .welcome-panel h2 {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .welcome-panel p {
            font-size: 1.05rem;
            opacity: 0.8;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .toggle-btn {
            padding: 0.8rem 2.5rem;
            background: transparent;
            color: var(--color-white);
            border: 2px solid var(--color-white);
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .toggle-btn:hover {
            background: var(--color-white);
            color: var(--color-primary);
            transform: translateY(-2px);
        }

        /* Right Side - Form Panel */
        .form-panel {
            padding: 3.5rem;
            position: relative;
        }

        .form-wrapper {
            position: relative;
        }

        .auth-form {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            visibility: hidden;
            transform: translateX(50px);
            transition: var(--transition);
        }

        .auth-form.active {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            position: relative;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--color-text);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid var(--color-border);
            border-radius: 10px;
            font-size: 1rem;
            font-family: var(--font-body);
            transition: var(--transition);
            background: var(--color-secondary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-accent);
            background: var(--color-white);
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--color-text-light);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--color-accent);
        }

        .checkbox-group label {
            font-size: 0.9rem;
            color: var(--color-text);
            cursor: pointer;
            margin: 0;
        }

        .forgot-password {
            color: var(--color-accent);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            float: right;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--color-primary) 0%, #2c2c2c 100%);
            color: var(--color-white);
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, var(--color-accent) 0%, #c9996b 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .mobile-toggle {
            display: none;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--color-text-light);
        }

        .mobile-toggle a {
            color: var(--color-accent);
            font-weight: 600;
            text-decoration: none;
        }

        .mobile-toggle a:hover {
            text-decoration: underline;
        }

        .name-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 992px) {
            .auth-container {
                max-width: 700px;
            }

            .welcome-panel h2 {
                font-size: 2rem;
            }

            .welcome-panel p {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .auth-container {
                grid-template-columns: 1fr;
                max-width: 450px;
            }

            .welcome-panel {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .form-panel {
                padding: 2rem 1.5rem;
            }

            .name-group {
                grid-template-columns: 1fr;
            }

            .auth-back-btn {
                align-self: flex-start;
            }
        }

        @media (max-width: 480px) {
            .form-header h2 {
                font-size: 2rem;
            }

            .logo {
                font-size: 2rem;
            }

            .form-panel {
                padding: 2rem 1rem;
            }

            .form-input {
                padding: 0.8rem 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- BACK BUTTON -->
    <a href="index.php" class="auth-back-btn">
        <svg viewBox="0 0 24 24">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Back to Home
    </a>

    <div class="auth-container">
        <!-- Welcome Panel -->
        <div class="welcome-panel" id="welcomePanel">
            <div class="logo">Jenny Store</div>
            <h2 id="welcomeTitle">Welcome Back!</h2>
            <p id="welcomeText">Enter your personal details to continue your shopping journey with us</p>
            <button class="toggle-btn" onclick="toggleForm()">
                <span id="toggleText">Sign Up</span>
            </button>
        </div>

        <!-- Form Panel -->
        <div class="form-panel">
            <div class="form-wrapper">
                <!-- Sign In Form -->
                <form method="POST" class="auth-form active" id="signInForm">
                    <div class="form-header">
                        <h2>Sign In</h2>
                    </div>

                    <div class="form-group">
                        <label for="signin-email">Email Address</label>
                        <input type="email" name="email" id="signin-email" class="form-input" placeholder="your@email.com">
                    </div>

                    <div class="form-group">
                        <label for="signin-password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="signin-password" name="password" class="form-input" placeholder="Enter your password">
                            <button type="button" class="toggle-password" onclick="togglePassword('signin-password')">👁️</button>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="remember-me">
                        <label for="remember-me">Remember me</label>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <button type="submit" name="login" class="submit-btn">Sign In</button>

                    <div class="mobile-toggle">
                        Don't have an account? <a href="#" onclick="toggleForm(); return false;">Sign Up</a>
                    </div>
                </form>

                <!-- Sign Up Form -->
                <form method="POST" class="auth-form" id="signUpForm">
                    <div class="form-header">
                        <h2>Create Your Account</h2>
                    </div>

                    <div class="name-group">
                        <div class="form-group">
                            <label for="signup-firstname">First Name</label>
                            <input name="firstname" type="text" id="signup-firstname" class="form-input" placeholder="John">
                        </div>
                        <div class="form-group">
                            <label for="signup-lastname">Last Name</label>
                            <input type="text" name="lastname" id="signup-lastname" class="form-input" placeholder="Doe">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="signup-email">Email Address</label>
                        <input type="email" name="email" id="signup-email" class="form-input" placeholder="your@email.com">
                    </div>

                    <div class="form-group">
                        <label for="signup-phone">Phone Number</label>
                        <input type="tel" id="signup-phone" name="phone" class="form-input" placeholder="+92-300-1234567">
                    </div>

                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="signup-password" class="form-input" placeholder="Create a password">
                            <button type="button" class="toggle-password" onclick="togglePassword('signup-password')">👁️</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="signup-confirm-password">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="confirm" id="signup-confirm-password" class="form-input" placeholder="Confirm your password">
                            <button type="button" class="toggle-password" onclick="togglePassword('signup-confirm-password')">👁️</button>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="terms">
                        <label for="terms">I agree to the Terms & Conditions</label>
                    </div>

                    <button type="submit" name="signup" class="submit-btn">Sign Up</button>

                    <div class="mobile-toggle">
                        Already have an account? <a href="#" onclick="toggleForm(); return false;">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let isSignIn = true;

        function toggleForm() {
            const signInForm = document.getElementById('signInForm');
            const signUpForm = document.getElementById('signUpForm');
            const welcomeTitle = document.getElementById('welcomeTitle');
            const welcomeText = document.getElementById('welcomeText');
            const toggleText = document.getElementById('toggleText');

            if (isSignIn) {
                signInForm.classList.remove('active');
                signUpForm.classList.add('active');
                welcomeTitle.textContent = 'Hello, Friend!';
                welcomeText.textContent = 'Start your journey with us by creating an account';
                toggleText.textContent = 'Sign In';
                isSignIn = false;
            } else {
                signUpForm.classList.remove('active');
                signInForm.classList.add('active');
                welcomeTitle.textContent = 'Welcome Back!';
                welcomeText.textContent = 'Enter your personal details to continue your shopping journey with us';
                toggleText.textContent = 'Sign Up';
                isSignIn = true;
            }
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</body>

</html>