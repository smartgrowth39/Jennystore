    <?php
    include "nav.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            --transition: all 0.4s ease;
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
            color: var(--color-text);
        }

        /* ======= HERO BANNER SLIDER ======= */
        .main-hero-banner-slider {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
        }

        .main-hero-banner-slides {
            display: flex;
            width: 200%;
            height: 100%;
            transition: transform 0.8s ease-in-out;
        }

        .main-hero-banner-slide-image {
            min-width: 50%;
            height: 100%;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .main-hero-banner-slide-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
        }

        .main-hero-banner-slide-content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            color: var(--color-white);
            max-width: 600px;
            z-index: 2;
        }

        .main-hero-banner-slide-subtitle {
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            color: var(--color-text);
            font-weight: 600;
        }

        .main-hero-banner-slide-title {
            font-family: var(--font-display);
            font-size: 4.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .main-hero-banner-slide-description {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .main-hero-banner-shop-now-btn {
            display: inline-block;
            padding: 15px 40px;
            background: var(--color-accent);
            color: var(--color-white);
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 4px;
            transition: var(--transition);
        }

        .main-hero-banner-shop-now-btn:hover {
            background: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

    </style>
</head>
<body>
    <!-- Hero Banner Slider -->
    <section class="main-hero-banner-slider">
        <div class="main-hero-banner-slides" id="bannerslides">
            <!-- Slide 1 - Cosmetics -->
            <div class="main-hero-banner-slide-image" style="background-image: url('https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1600&q=80');">
                <div class="main-hero-banner-slide-content">
                    <p class="main-hero-banner-slide-subtitle">Premium Beauty Collection</p>
                    <h1 class="main-hero-banner-slide-title">Discover Luxury Cosmetics</h1>
                    <p class="main-hero-banner-slide-description">Elevate your beauty routine with our curated selection of premium cosmetics and skincare products.</p>
                    <a href="cosmetics.php" class="main-hero-banner-shop-now-btn">Shop Now</a>
                </div>
            </div>

            <!-- Slide 2 - Jewelry -->
            <div class="main-hero-banner-slide-image" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8pxKTEka_ngdnMwvFGICw5gqCgqhPlo03aQ&s');">
                <div class="main-hero-banner-slide-content">
                    <p class="main-hero-banner-slide-subtitle">Exquisite Jewelry</p>
                    <h1 class="main-hero-banner-slide-title">Timeless Elegance</h1>
                    <p class="main-hero-banner-slide-description">Explore our stunning collection of handcrafted jewelry designed to make every moment special.</p>
                    <a href="jewellery.php" class="main-hero-banner-shop-now-btn">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

    <?php
    include "top_products.php";
    ?>
    <?php
    include "our products.php";
    ?>
    <!-- is ko responsive karna hai  -->
    <?php
    include "shop-by-category.php";
    ?>
    <?php
    include "featured-testimonial.php";
    ?>
    <?php
    include "footer.php";
    ?>
    
<script>
        // Auto-sliding banner
        let currentSlide = 0;
        const bannerslides = document.getElementById('bannerslides');
        const totalbannerSlides = 2;

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalbannerSlides;
            bannerslides.style.transform = `translateX(-${currentSlide * 50}%)`;
        }

        // Auto-slide every 5 seconds
        setInterval(nextSlide, 5000);
</script>

</body>
</html>