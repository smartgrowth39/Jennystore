<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny Store - Carousel & Categories</title>

    <?php
    include "links.php";
    ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .shopbycategory-container-slider,
        .shopbycategory-container-grid {
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Section Styling */
        .shopbycategory-section {
            padding: 60px 0;
        }

        .shopbycategory-section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: #1a1a1a;
            font-weight: 700;
            position: relative;
        }

        .shopbycategory-section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #d4a574, #c9996b);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        /* ======= AUTO CAROUSEL ======= */
        .shopbycategory-slider-section {
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            padding: 80px 0;
        }

        .shopbycategory-slider-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .shopbycategory-slider-item {
            display: flex;
            animation: shopbycategory-slides 20s infinite;
        }

        @keyframes shopbycategory-slides {

            0%,
            23% {
                transform: translateX(0%);
            }

            25%,
            48% {
                transform: translateX(-100%);
            }

            50%,
            73% {
                transform: translateX(-200%);
            }

            75%,
            98% {
                transform: translateX(-300%);
            }

            100% {
                transform: translateX(0%);
            }
        }

        .shopbycategory-slide {
            min-width: 100%;
            position: relative;
        }

        .shopbycategory-slide img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .shopbycategory-slide-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(26, 26, 26, 0.9), transparent);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .shopbycategory-slide-caption h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #d4a574;
        }

        .shopbycategory-slide-caption p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
        }


        /* ======= RESPONSIVE ======= */
        @media (max-width: 1200px) {
            .shopbycategory-categories-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 25px;
            }

            .shopbycategory-slide img {
                height: 450px;
            }
        }

        @media (max-width: 992px) {
            .shopbycategory-categories-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .shopbycategory-slide img {
                height: 400px;
            }

            .shopbycategory-slide-caption h3 {
                font-size: 2rem;
            }

            .shopbycategory-slide-caption p {
                font-size: 1rem;
            }

            .shopbycategory-section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .shopbycategory-section {
                padding: 40px 0;
            }

            .shopbycategory-slider-section {
                padding: 60px 0;
            }

            .shopbycategory-container-slider,
            .shopbycategory-container-grid {
                padding: 0 1.5rem;
            }

            .shopbycategory-slide img {
                height: 350px;
            }

            .shopbycategory-slide-caption {
                padding: 25px 20px;
            }

            .shopbycategory-slide-caption h3 {
                font-size: 1.5rem;
                margin-bottom: 8px;
            }

            .shopbycategory-slide-caption p {
                font-size: 0.9rem;
            }

            .shopbycategory-category-item img {
                height: 250px;
            }

            .shopbycategory-category-name {
                padding: 20px;
                font-size: 1.3rem;
            }

            .shopbycategory-section-title {
                font-size: 1.8rem;
                margin-bottom: 35px;
            }
        }

        @media (max-width: 576px) {
            .shopbycategory-categories-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .shopbycategory-slide img {
                height: 300px;
            }

            .shopbycategory-slide-caption h3 {
                font-size: 1.3rem;
            }

            .shopbycategory-slide-caption p {
                font-size: 0.85rem;
            }

            .shopbycategory-category-item img {
                height: 280px;
            }

            .shopbycategory-category-name {
                font-size: 1.2rem;
                padding: 18px;
            }

            .shopbycategory-section-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 480px) {

            .shopbycategory-container-slider,
            .shopbycategory-container-grid {
                padding: 0 1rem;
            }

            .shopbycategory-slide img {
                height: 250px;
            }

            .shopbycategory-slide-caption {
                padding: 20px 15px;
            }

            .shopbycategory-slide-caption h3 {
                font-size: 1.1rem;
            }

            .shopbycategory-slide-caption p {
                font-size: 0.75rem;
            }

            .shopbycategory-section-title {
                font-size: 1.4rem;
                margin-bottom: 30px;
            }

            .shopbycategory-section-title::after {
                width: 80px;
                height: 3px;
            }
        }
    </style>
</head>

<body>

    <!-- ======= AUTO CAROUSEL SECTION ======= -->
    <section class="shopbycategory-section shopbycategory-slider-section">
        <div class="shopbycategory-container-slider">
            <h2 class="shopbycategory-section-title">Special Collections</h2>
            <div class="shopbycategory-slider-container">
                <div class="shopbycategory-slider-item">
                    <div class="shopbycategory-slide">
                        <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1200&q=80" alt="Jewellery Collection">
                        <div class="shopbycategory-slide-caption">
                            <h3>Exquisite Jewellery Collection</h3>
                            <p>Discover timeless elegance with our premium jewellery range</p>
                        </div>
                    </div>
                    <div class="shopbycategory-slide">
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1200&q=80" alt="Cosmetics Collection">
                        <div class="shopbycategory-slide-caption">
                            <h3>Premium Beauty Products</h3>
                            <p>Enhance your natural beauty with our luxury cosmetics</p>
                        </div>
                    </div>
                    <div class="shopbycategory-slide">
                        <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=1200&q=80" alt="Diamond Collection">
                        <div class="shopbycategory-slide-caption">
                            <h3>Diamond Collection</h3>
                            <p>Shine bright with our stunning diamond pieces</p>
                        </div>
                    </div>
                    <div class="shopbycategory-slide">
                        <img src="https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=1200&q=80" alt="Makeup Collection">
                        <div class="shopbycategory-slide-caption">
                            <h3>Complete Makeup Range</h3>
                            <p>Everything you need for a flawless look</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>