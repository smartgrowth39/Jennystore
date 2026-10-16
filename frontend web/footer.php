<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny Store - Footer</title>
    <?php
    include "links.php"
    ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: white;
            padding: 30px 20px 15px;
            margin-top: 50px;
        }

        .footer-container {
            margin: 0 auto;
        }

        /* Newsletter */
        .newsletter-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .newsletter-section h2 {
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: #d4a574;
        }

        .newsletter-section p {
            font-size: 13px;
            font-weight: 300;
            margin-bottom: 18px;
            color: rgba(255, 255, 255, 0.8);
        }

        .newsletter-form {
            display: flex;
            justify-content: center;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-input {
            flex: 1;
            padding: 12px 18px;
            border: none;
            outline: none;
            font-size: 13px;
            font-family: 'Lato', sans-serif;
            border-radius: 8px 0 0 8px;
            background: white;
        }

        .newsletter-input:focus {
            box-shadow: 0 0 0 2px rgba(212, 165, 116, 0.3);
        }

        .newsletter-btn {
            background: #d4a574;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Lato', sans-serif;
            border-radius: 0 8px 8px 0;
            white-space: nowrap;
        }

        .newsletter-btn:hover {
            background: #c9996b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }

        /* Footer Grid */
        .footer-content {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
        }

        /* ── TEXT LOGO — same as navbar ── */
        .footer-logo-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-text-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-decoration: none;
            margin-bottom: 14px;
            transition: opacity 0.3s ease;
        }

        .footer-text-logo:hover {
            opacity: 0.85;
        }

        .footer-logo-jenny {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 2.6rem;
            font-weight: 600;
            color: #d4a574;
            letter-spacing: 3px;
            line-height: 1;
        }

        .footer-logo-rule {
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, #d4a574, transparent);
            margin: 5px 0 4px;
        }

        .footer-logo-sub {
            font-family: 'Lato', sans-serif;
            font-size: 0.58rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1;
            white-space: nowrap;
        }

        .footer-description {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.6;
        }

        /* Columns */
        .footer-column h3 {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 15px;
            color: #d4a574;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 8px;
        }

        .footer-column ul li a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 13px;
            font-weight: 300;
            transition: all 0.3s;
            display: inline-block;
        }

        .footer-column ul li a:hover {
            color: #d4a574;
            font-size: 15px;
            padding-left: 5px;
        }

        /* Contact */
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.8);
        }

        .contact-item i {
            width: 16px;
            color: #d4a574;
            margin-top: 2px;
            flex-shrink: 0;
            font-size: 15px;
        }

        /* Social */
        .social-media {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(212, 165, 116, 0.15);
            border: 2px solid #d4a574;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-icon:hover {
            background: #d4a574;
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        .social-icon i {
            font-size: 17px;
            color: #d4a574;
            transition: all 0.3s;
        }

        .social-icon:hover i {
            color: white;
        }

        /* Bottom */
        .footer-bottom {
            text-align: center;
            padding-top: 18px;
            border-top: 1px solid rgba(212, 165, 116, 0.3);
        }

        .footer-bottom p {
            font-size: 12px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.6);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }
        }

        @media (max-width: 768px) {
            footer {
                padding: 25px 20px 12px;
            }

            .newsletter-section {
                margin-bottom: 25px;
            }

            .newsletter-section h2 {
                font-size: 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 20px;
                text-align: center;
            }

            .footer-logo-section {
                align-items: center;
            }

            .footer-text-logo {
                align-items: center;
            }

            .footer-logo-rule {
                background: linear-gradient(to right, transparent, #d4a574, transparent);
            }

            .footer-description {
                text-align: center;
            }

            .newsletter-form {
                flex-direction: column;
                gap: 10px;
            }

            .newsletter-input {
                border-radius: 8px;
            }

            .newsletter-btn {
                border-radius: 8px;
                padding: 12px 25px;
            }

            .contact-item {
                justify-content: center;
            }

            .footer-column ul li a:hover {
                padding-left: 0;
            }
        }

        @media (max-width: 480px) {
            footer {
                padding: 20px 15px 10px;
            }

            .newsletter-section h2 {
                font-size: 18px;
                letter-spacing: 1px;
            }

            .newsletter-section p {
                font-size: 12px;
            }

            .footer-logo-jenny {
                font-size: 2.2rem;
            }

            .footer-column h3 {
                font-size: 14px;
            }

            .social-icon {
                width: 38px;
                height: 38px;
            }

            .social-icon i {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <footer>
        <div class="footer-container">

            <!-- Newsletter -->
            <div class="newsletter-section">
                <h2>Get Latest Updates</h2>
                <p>Subscribe to our newsletter for exclusive offers</p>
                <form class="newsletter-form" onsubmit="handleNewsletter(event)">
                    <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                    <button type="submit" class="newsletter-btn">SUBSCRIBE</button>
                </form>
            </div>

            <!-- Footer Grid -->
            <div class="footer-content">

                <!-- Text Logo Column -->
                <div class="footer-logo-section">
                    <a href="index.php" class="footer-text-logo">
                        <span class="footer-logo-jenny">Jenny</span>
                        <div class="footer-logo-rule"></div>
                        <span class="footer-logo-sub">Cosmetics &amp; Jewellery</span>
                    </a>
                    <p class="footer-description">Your trusted destination for exquisite jewelry and premium cosmetics.</p>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop.php">Shop All</a></li>
                        <li><a href="jewellery.php">Jewellery</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>

                <!-- Customer Care -->
                <div class="footer-column">
                    <h3>Customer Care</h3>
                    <ul>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="terms.php">Terms Of Service</a></li>
                        <li><a href="refund.php">Refund Policy</a></li>
                        <li><a href="shipping.php">Shipping</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Clifton, Karachi</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+92-333-1371483</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@jenny.com</span>
                    </div>
                </div>

            </div>

            <!-- Social Media -->
            <div class="social-media">
                <a href="https://wa.me/923331371483" target="_blank" class="social-icon">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p>&copy; 2024 Jenny Store. All Rights Reserved.</p>
            </div>

        </div>
    </footer>

    <script>
        function handleNewsletter(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            alert(`Thank you! We'll send updates to ${email}`);
            event.target.reset();
        }
    </script>

</body>

</html>