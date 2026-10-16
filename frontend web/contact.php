<?php
include "nav.php";
?>

<?php

include "connect.php";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $query = "INSERT INTO contact_messages(name,email,phone,subject,message)
VALUES('$name','$email','$phone','$subject','$message')";

    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "<script>alert('Message sent successfully')</script>";
    } else {
        echo "<script>alert('Message not sent')</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Jenny Store</title>
    <?php
    include "links.php";
    ?>
    <style>
        /* main complasory style */
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
            line-height: 1.6;
            color: var(--color-text);
        }

        .contact-container {
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* top banner image hai*/
        .contact-banner {
            position: relative;
            height: 500px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-banner-image-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .contact-banner-image {
            width: 100%;
            height: 100%;
            background-image: url(../testimonials/contactbanner.jpeg);
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
        }

        .contact-banner:hover .contact-banner-image {
            transform: scale(1.1);
        }

        .contact-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* contact ka  banner content  */
        .contact-banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--color-white);
        }

        .contact-banner h1 {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease-out;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .contact-banner p {
            font-size: 1.3rem;
            opacity: 0.95;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* contact info cards */
        .contact-info-section {
            padding: 4rem 0;
            background: var(--color-secondary);
            margin-top: -3rem;
            position: relative;
            z-index: 10;
        }

        .contact-info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .contact-info-card {
            background: var(--color-white);
            padding: 2.5rem 2rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            animation: slideUp 0.6s ease-out both;
        }

        .contact-info-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .contact-info-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .contact-info-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact-info-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .contact-info-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--color-accent) 0%, #c9996b 100%);
            color: var(--color-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .contact-info-card:hover .contact-info-icon {
            transform: scale(1.1) rotate(10deg);
        }

        .contact-info-card h3 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 0.8rem;
        }

        .contact-info-card p {
            color: var(--color-text-light);
            font-size: 1rem;
            line-height: 1.8;
        }

        .contact-info-card a {
            color: var(--color-accent);
            text-decoration: none;
            font-weight: 600;
        }

        .contact-info-card a:hover {
            text-decoration: underline;
        }

        /* main contact section */
        .contact-main-section {
            padding: 5rem 0;
            background: var(--color-white);
        }

        .contact-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        /* contact form */
        .contact-form-wrapper h2 {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .contact-form-wrapper p {
            color: var(--color-text-light);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .contact-form-group {
            display: flex;
            flex-direction: column;
        }

        .contact-form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--color-text);
        }

        .contact-form-group input,
        .contact-form-group textarea,
        .contact-form-group select {
            padding: 1rem;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: var(--font-body);
            transition: var(--transition);
        }

        .contact-form-group input:focus,
        .contact-form-group textarea:focus,
        .contact-form-group select:focus {
            outline: none;
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .contact-form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .contact-submit-btn {
            padding: 1rem 3rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-submit-btn:hover {
            background: var(--color-accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* map section */
        .contact-map-container {
            width: 100%;
            height: 450px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }


        .google-map {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* newsletter section */
        .contact-newsletter-section {
            background: linear-gradient(135deg, var(--color-accent) 0%, #c9996b 100%);
            padding: 5rem 0;
            color: var(--color-white);
            text-align: center;
        }

        .contact-newsletter-content h2 {
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .contact-newsletter-content p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }

        .contact-newsletter-form {
            display: flex;
            gap: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-newsletter-input {
            flex: 1;
            padding: 1.2rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-family: var(--font-body);
        }

        .contact-newsletter-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .contact-newsletter-btn {
            padding: 1.2rem 3rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .contact-newsletter-btn:hover {
            background: var(--color-white);
            color: var(--color-primary);
            transform: scale(1.05);
        }

        /* contact ki  responsive */
        @media (max-width: 992px) {
            .contact-info-cards {
                grid-template-columns: 1fr;
            }

            .contact-layout {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
        }

        @media (max-width: 768px) {
            .contact-banner {
                height: 400px;
            }

            .contact-banner h1 {
                font-size: 2.5rem;
            }

            .contact-banner p {
                font-size: 1.1rem;
            }

            .contact-newsletter-form {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .contact-container {
                padding: 0 1rem;
            }

            .contact-banner {
                height: 350px;
            }

            .contact-banner h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- top banner image section -->
    <section class="contact-banner">
        <div class="contact-banner-image-wrapper">
            <div class="contact-banner-image"></div>
        </div>

        <!-- background image kay liyay dark overlay -->
        <div class="contact-banner-overlay"></div>
        <div class="contact-container">
            <div class="contact-banner-content">
                <h1>Get In Touch</h1>
                <p>We'd love to hear from you! Reach out with any questions or concerns.</p>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="contact-info-section">
        <div class="contact-container">
            <div class="contact-info-cards">
                <div class="contact-info-card">
                    <div class="contact-info-icon">📞</div>
                    <h3>Call Us</h3>
                    <p>
                        +92-300-1234567<br>
                        +92-321-7654321
                    </p>
                    <p style="margin-top: 0.5rem;">Mon - Sat, 9:00 AM - 8:00 PM</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon">📧</div>
                    <h3>Email Us</h3>
                    <p>
                        <a href="/cdn-cgi/l/email-protection#aec7c0c8c1eec4cbc0c0d7dddac1dccb80cdc1c3"><span class="__cf_email__" data-cfemail="80e9eee6efc0eae5eeeef9f3f4eff2e5aee3efed">[email&#160;protected]</span></a><br>
                        <a href="/cdn-cgi/l/email-protection#5724222727382523173d3239392e24233825327934383a"><span class="__cf_email__" data-cfemail="32414742425d40467258575c5c4b41465d40571c515d5f">[email&#160;protected]</span></a>
                    </p>
                    <p style="margin-top: 0.5rem;">We reply within 24 hours</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon">📍</div>
                    <h3>Visit Us</h3>
                    <p>
                        Block 7, Clifton<br>
                        Karachi, Sindh<br>
                        Pakistan
                    </p>
                    <p style="margin-top: 0.5rem;">Come visit our showroom!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Contact Section -->
    <section class="contact-main-section">
        <div class="contact-container">
            <div class="contact-layout">
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2>Send Us a Message</h2>
                    <p>Fill out the form below and we'll get back to you as soon as possible.</p>

                    <form class="contact-form" method="POST">
                        <div class="contact-form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Enter your name">
                        </div>

                        <div class="contact-form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="your@email.com">
                        </div>

                        <div class="contact-form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+92-300-1234567">
                        </div>

                        <div class="contact-form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="product">Product Question</option>
                                <option value="order">Order Status</option>
                                <option value="complaint">Complaint</option>
                                <option value="feedback">Feedback</option>
                            </select>
                        </div>

                        <div class="contact-form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" required placeholder="Write your message here..."></textarea>
                        </div>

                        <button type="submit" name="submit" class="contact-submit-btn">Send Message</button>
                    </form>
                </div>

                <!-- map section-->
                <!-- <div class="contact-map-wrapper">
                    <h2>Find Us Here</h2>
                    <p>Visit our showroom in Clifton, Karachi to explore our complete collection.</p>

                    <div class="contact-map-container">
                        <div class="contact-map-placeholder">
                            <span class="contact-icon">🗺️</span>
                            <p>Map Location: Block 7, Clifton, Karachi</p>
                            <p style="font-size: 0.9rem;">(Embed Google Maps iframe here)</p>
                        </div>
                    </div>
                </div> -->

                <div class="contact-map-container">
                    <iframe
                        src="https://www.google.com/maps?q=Block+7+Clifton+Karachi&output=embed"
                        loading="lazy"
                        allowfullscreen
                        class="google-map">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- newsletter section -->
    <section class="contact-newsletter-section">
        <div class="contact-container">
            <div class="contact-newsletter-content">
                <h2>Subscribe to Our Newsletter</h2>
                <p>Get the latest updates on new products, exclusive offers, and beauty tips!</p>

                <form class="contact-newsletter-form">
                    <input type="email" class="contact-newsletter-input" placeholder="Enter your email address" required>
                    <button type="submit" class="contact-newsletter-btn">Subscribe</button>
                </form>
            </div>
        </div>
    </section>


    <?php
    include "footer.php";
    ?>

</body>

</html>