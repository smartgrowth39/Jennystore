
    <?php include "nav.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Jenny Store</title>
    <?php
    include "links.php";
    ?>

    <style>
        /* compalsory styling start */
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

        /* compalsory styling end */

        .about-container {
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ======= HERO SECTION - CROSSFADE BACKGROUND ======= */
        .about-hero {
            position: relative;
            height: 500px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* har ek background image alag div hai */
        .about-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .about-hero-bg.about-hero-bg-active {
            opacity: 1;
        }

        /* dark overlay */
        .about-hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* center content */
        .about-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--color-white);
            padding: 0 2rem;
        }

        .about-hero h1 {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease-out;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .about-hero p {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        /* about animation */
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

        /* about heading */
        .about-section-title {
            font-family: var(--font-display);
            text-align: center;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 4rem;
            position: relative;
            animation: fadeInUp 0.8s ease-out;
        }

        .about-section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: var(--color-accent);
            margin: 1rem auto 0;
        }

        /* about story section */
        .about-our-story {
            padding: 6rem 0;
            background: var(--color-white);
        }

        .about-story-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-story-text {
            animation: slideUp 0.6s ease-out 0.2s both;
        }

        .about-story-text h2 {
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 2rem;
            position: relative;
        }

        .about-story-text h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--color-accent);
            margin-top: 1rem;
        }

        .about-story-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--color-text-light);
            margin-bottom: 1.5rem;
        }

        .about-story-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-hover);
            animation: slideUp 0.6s ease-out 0.4s both;
        }

        .about-story-image img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        /* about mission and vision section */
        .about-mission-vision {
            padding: 6rem 0;
            background: var(--color-secondary);
        }

        .about-mission-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .about-mission-card {
            background: var(--color-white);
            padding: 3rem;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            animation: slideUp 0.6s ease-out both;
        }

        .about-mission-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .about-mission-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .about-mission-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .about-mission-card h3 {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .about-mission-card p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--color-text-light);
        }

        /* about ka values section */
        .about-values-section {
            padding: 6rem 0;
            background: var(--color-white);
        }

        .about-values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2.5rem;
        }

        .about-value-card {
            text-align: center;
            padding: 2rem 1.5rem;
            border: 2px solid var(--color-border);
            border-radius: 12px;
            transition: var(--transition);
            animation: slideUp 0.6s ease-out both;
        }

        .about-value-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .about-value-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .about-value-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .about-value-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .about-value-card:hover {
            border-color: var(--color-accent);
            transform: translateY(-5px);
        }

        .about-value-card h4 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.8rem;
        }

        .about-value-card p {
            font-size: 0.95rem;
            color: var(--color-text-light);
            line-height: 1.6;
        }

        /* about stats section */
        .about-stats-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--color-primary) 0%, #2c2c2c 100%);
            color: var(--color-white);
        }

        .about-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
        }

        .about-stat-item {
            text-align: center;
            animation: fadeInUp 0.8s ease-out both;
        }

        .about-stat-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .about-stat-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .about-stat-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .about-stat-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .about-stat-number {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 700;
            color: var(--color-accent);
            margin-bottom: 0.5rem;
        }

        .about-stat-label {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.95;
        }

        /* about fAQ section */
        .about-faq-section {
            padding: 6rem 0;
            background: var(--color-secondary);
        }

        .about-faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .about-faq-item {
            background: var(--color-white);
            margin-bottom: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            animation: slideUp 0.6s ease-out both;
        }

        .about-faq-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .about-faq-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .about-faq-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .about-faq-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .about-faq-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        .about-faq-item:nth-child(6) {
            animation-delay: 0.6s;
        }

        .about-faq-item:nth-child(7) {
            animation-delay: 0.7s;
        }

        .about-faq-item:nth-child(8) {
            animation-delay: 0.8s;
        }

        .about-faq-item:hover {
            box-shadow: var(--shadow-hover);
        }

        .about-faq-question {
            padding: 1.5rem 2rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
            font-weight: 600;
            font-size: 1.1rem;
            user-select: none;
        }

        .about-faq-question:hover {
            background: var(--color-secondary);
        }

        .about-faq-icon {
            font-size: 1.5rem;
            color: var(--color-accent);
            transition: var(--transition);
            font-weight: 700;
        }

        .about-faq-item.about-active .about-faq-icon {
            transform: rotate(45deg);
        }

        .about-faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0 2rem;
        }

        .about-faq-item.about-active .about-faq-answer {
            max-height: 500px;
            padding: 0 2rem 1.5rem 2rem;
        }

        .about-faq-answer p {
            color: var(--color-text-light);
            line-height: 1.8;
            font-size: 1rem;
        }

        /* about responsive */
        @media (max-width: 992px) {
            .about-hero {
                height: 400px;
            }

            .about-story-layout {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .about-mission-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .about-values-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }

            .about-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .about-hero {
                height: 400px;
            }

            .about-hero h1 {
                font-size: 2.5rem;
            }

            .about-hero p {
                font-size: 1rem;
                padding: 0 1rem;
            }

            .about-our-story,
            .about-mission-vision,
            .about-values-section,
            .about-faq-section {
                padding: 3rem 0;
            }

            .about-story-image img {
                height: 350px;
            }

            .about-values-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .about-stats-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .about-section-title {
                font-size: 2.5rem;
                margin-bottom: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .about-hero {
                height: 350px;
            }

            .about-hero h1 {
                font-size: 2rem;
            }

            .about-hero p {
                font-size: 0.95rem;
                padding: 0 0.5rem;
            }
        }

        @media (max-width: 400px) {
            .about-hero {
                height: 300px;
            }

            .about-hero h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>

    <!-- hero section -->
    <section class="about-hero">

        <!-- Background Images - crossfade hoti hain -->
        <div class="about-hero-bg about-hero-bg-active" style="background-image: url('https://plus.unsplash.com/premium_photo-1661645440995-de46bfd972bc?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDE2fHx8ZW58MHx8fHx8');"></div>
        <div class="about-hero-bg" style="background-image: url('https://static.vecteezy.com/system/resources/thumbnails/075/650/564/small/gold-and-rose-gold-rings-and-chain-jewelry-on-a-light-blue-surface-showcasing-luxury-accessories-and-fashion-details-horizontal-banner-copy-space-free-space-for-text-photo.jpg');"></div>
        <div class="about-hero-bg" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpcAkQp3zFaSorjNmNl2iB1ycK8op7vsAGWw&s');"></div>
        <div class="about-hero-bg" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjhH9vVbre0FSRnvKtmVrFv94FcDqwLRVqdQ&s');"></div>

        <!-- dark overlay -->
        <div class="about-hero-overlay"></div>

        <!-- centered text -->
        <div class="about-hero-content">
            <h1>About Jenny Store</h1>
            <p>Your trusted destination for exquisite jewelry and premium cosmetics since 2015</p>
        </div>

    </section>

    <!-- our story section -->
    <section class="about-our-story">
        <div class="about-container">
            <div class="about-story-layout">
                <div class="about-story-text">
                    <h2>Our Story</h2>
                    <p>Founded in 2015, Jenny Store began with a simple vision: to bring the finest jewelry and cosmetics to discerning customers who appreciate quality and elegance.</p>
                    <p>What started as a small boutique has grown into a trusted name in luxury retail, serving thousands of satisfied customers across Pakistan.</p>
                    <p>Our commitment to excellence, authentic products, and exceptional customer service has made us a beloved destination for those seeking the perfect piece of jewelry or premium beauty products.</p>
                    <p>Today, we continue to curate the most exquisite collections, ensuring that every item meets our rigorous standards of quality and craftsmanship.</p>
                </div>
                <div class="about-story-image">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8pxKTEka_ngdnMwvFGICw5gqCgqhPlo03aQ&s" alt="Our Store">
                </div>
            </div>
        </div>
    </section>

    <!-- mission and vision section -->
    <section class="about-mission-vision">
        <div class="about-container">
            <h2 class="about-section-title">Mission & Vision</h2>
            <div class="about-mission-grid">
                <div class="about-mission-card">
                    <h3>Our Mission</h3>
                    <p>At Jenny Store, our mission is to make luxury feel personal. We carefully source and curate every jewelry piece and cosmetic product to ensure it meets the highest standards of quality and authenticity. We believe that every customer deserves not just a product, but an experience — one built on trust, warmth, and expert guidance. From the moment you browse our collection to the day your order arrives at your door, we are committed to making that journey seamless, joyful, and truly worth your while.</p>
                </div>
                <div class="about-mission-card">
                    <h3>Our Vision</h3>
                    <p>Our vision is to redefine the way Pakistan shops for fine jewelry and premium beauty. We dream of a future where every woman, regardless of her city or background, has access to authentic luxury without compromise. We are building more than a store — we are building a community of confident, elegant individuals who know their worth. Through continuous innovation, honest relationships, and an unwavering passion for beauty, Jenny Store aims to become the most loved and trusted name in luxury retail across the country.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- about core values -->
    <section class="about-values-section">
        <div class="about-container">
            <h2 class="about-section-title">Our Core Values</h2>
            <div class="about-values-grid">
                <div class="about-value-card">
                    <h4>Quality First</h4>
                    <p>Every single product on our shelves goes through a strict verification process. We partner only with authorized distributors and trusted brands, so you never have to second-guess what you are buying. Quality is not a promise for us — it is a standard we refuse to lower.</p>
                </div>
                <div class="about-value-card">
                    <h4>Trust</h4>
                    <p>We know that trust is earned, not given. That is why we are transparent about our pricing, our sourcing, and our policies. Thousands of customers come back to Jenny Store not just for our products, but because they know we will always be honest with them — no matter what.</p>
                </div>
                <div class="about-value-card">
                    <h4>Excellence</h4>
                    <p>From the packaging of your order to the way our team responds to your queries, we pursue excellence in every detail. We constantly improve, listen to feedback, and raise our standards — because you deserve nothing less than the very best.</p>
                </div>
                <div class="about-value-card">
                    <h4>Customer Care</h4>
                    <p>Our customers are the heart of everything we do. Whether you need help choosing the right shade of foundation or want advice on a jewelry gift, our team is always here for you. Your happiness does not end at checkout — it is where our relationship begins.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- about stat section -->
    <section class="about-stats-section">
        <div class="about-container">
            <div class="about-stats-grid">
                <div class="about-stat-item">
                    <div class="about-stat-number">10K+</div>
                    <div class="about-stat-label">Happy Customers</div>
                </div>
                <div class="about-stat-item">
                    <div class="about-stat-number">500+</div>
                    <div class="about-stat-label">Premium Products</div>
                </div>
                <div class="about-stat-item">
                    <div class="about-stat-number">9</div>
                    <div class="about-stat-label">Years of Excellence</div>
                </div>
                <div class="about-stat-item">
                    <div class="about-stat-number">98%</div>
                    <div class="about-stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- about faq section -->
    <section class="about-faq-section">
        <div class="about-container">
            <h2 class="about-section-title">Frequently Asked Questions</h2>
            <div class="about-faq-container">
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>Are all your products authentic?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>Yes, absolutely! We guarantee 100% authentic products. All our jewelry and cosmetics come directly from authorized distributors and brands. We never sell counterfeit or fake items.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>What is your return policy?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>We offer a 7-day return policy on most items. Products must be in original condition with tags attached. Jewelry items can be exchanged within 3 days if unworn. Custom or personalized items cannot be returned.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>Do you offer jewelry customization?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>Yes! We offer custom jewelry design services. Our expert craftsmen can create unique pieces based on your specifications. Contact us to discuss your requirements and get a personalized quote.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>How long does delivery take?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>We offer same-day delivery in Karachi for orders placed before 2 PM. For other cities, delivery takes 2-5 business days. Free shipping is available on orders above Rs. 5,000.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>Do you have a physical store?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>Yes, our flagship showroom is located in Clifton, Karachi. You're welcome to visit us to browse our collection in person. Our team is available to assist you with your selections.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>What payment methods do you accept?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>We accept multiple payment methods including cash on delivery, credit/debit cards, bank transfers, and mobile payment apps. All online transactions are secured with SSL encryption.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>Do you offer gift wrapping services?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>Yes, we provide complimentary luxury gift wrapping for all jewelry purchases. For special occasions, we also offer premium gift packaging options at an additional cost.</p>
                    </div>
                </div>
                <div class="about-faq-item">
                    <div class="about-faq-question" onclick="toggleFAQ(this)">
                        <span>Can I track my order?</span>
                        <span class="about-faq-icon">+</span>
                    </div>
                    <div class="about-faq-answer">
                        <p>Absolutely! Once your order is shipped, you'll receive a tracking number via SMS and email. You can use this to track your order in real-time on our website or the courier's tracking portal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>

    <script>
        // FAQ accordion
        function toggleFAQ(element) {
            const faqItem = element.parentElement;
            const allItems = document.querySelectorAll('.about-faq-item');
            allItems.forEach(item => {
                if (item !== faqItem) item.classList.remove('about-active');
            });
            faqItem.classList.toggle('about-active');
        }

        // Hero background crossfade - sirf image change hogi, koi slide nahi
        let currentAboutBg = 0;
        const aboutBgs = document.querySelectorAll('.about-hero-bg');
        const totalAboutBgs = aboutBgs.length;

        function nextAboutBg() {
            aboutBgs[currentAboutBg].classList.remove('about-hero-bg-active');
            currentAboutBg = (currentAboutBg + 1) % totalAboutBgs;
            aboutBgs[currentAboutBg].classList.add('about-hero-bg-active');
        }

        setInterval(nextAboutBg, 5000);
    </script>

</body>

</html>