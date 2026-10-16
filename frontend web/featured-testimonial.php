<?php
include "connect.php";

if (isset($_POST['submit_review'])) {

    $name = $_POST['name'];
    $review = $_POST['review_text'];
    $rating = $_POST['rating'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $image);

    $query = "INSERT INTO testimonials(name,review_text,rating,image)
VALUES('$name','$review','$rating','$image')";

    mysqli_query($connect, $query);

    if ($name == "" || $review == "" || $rating == "") {
        header("Location: featured-testimonials.php?error=1");
        exit();
    }
}


$featured_products = mysqli_query($connect, "
SELECT * FROM products
WHERE featured_products = 1
ORDER BY product_id DESC
LIMIT 10
");

$testimonial_query = mysqli_query($connect, "
SELECT * FROM testimonials
ORDER BY created_at DESC
LIMIT 10
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products & Testimonials - Jenny Store</title>
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
            line-height: 1.6;
            color: var(--color-text);
        }

        /* ===================== */
        /* FEATURED PRODUCTS     */
        /* ===================== */

        .featured-product-section {
            background: var(--color-secondary);
            padding: 5rem 0;
        }

        .featured-product-container {
            margin: 0 auto;
            padding: 0 2rem;
        }

        .featured-product-section-title {
            font-family: var(--font-display);
            text-align: center;
            font-size: 3.5rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 3rem;
        }

        .featured-product-section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: var(--color-accent);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        .featured-product-slider {
            position: relative;
            overflow: hidden;
            padding: 0 65px;
        }

        .featured-product-track {
            display: flex;
            gap: 1.5rem;
            transition: transform 0.5s ease;
        }

        .featured-product-item {
            min-width: calc(20% - 1.2rem);
            flex-shrink: 0;
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }

        .featured-product-item:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-accent);
        }

        /* ── FIXED: image height in px, uniform across all cards ── */
        .featured-product-img-wrap {
            width: 300px;
            height: 200px;
            overflow: hidden;
            background: var(--color-secondary);
        }

        .featured-product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center top;
            display: block;
            transition: var(--transition);
        }

        .featured-product-item:hover .featured-product-img {
            transform: scale(1.08);
        }

        .featured-product-info {
            padding: 1.2rem;
            text-align: center;
        }

        .featured-product-name {
            font-family: var(--font-display);
            font-size: 1.1rem;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .featured-product-price {
            font-family: var(--font-display);
            font-size: 1.4rem;
            color: var(--color-accent);
            font-weight: 600;
        }

        .featured-product-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .featured-product-slider-btn:hover {
            background: var(--color-accent);
        }

        .featured-product-slider-btn-prev {
            left: 5px;
        }

        .featured-product-slider-btn-next {
            right: 5px;
        }

        /* ===================== */
        /* TESTIMONIALS SECTION  */
        /* ===================== */

        .testimonials-section {
            padding: 5rem 0;
        }

        .testimonials-container {
            margin: 0 auto;
            padding: 0 2rem;
        }

        .testimonials-section-title {
            font-family: var(--font-display);
            text-align: center;
            font-size: 3.5rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 3rem;
        }

        .testimonials-section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: var(--color-accent);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        .testimonials-slider {
            position: relative;
            padding: 0 60px;
        }

        .testimonials-slides-wrapper {
            overflow: hidden;
        }

        .testimonials-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        /* ===================== */
        /* TESTIMONIAL CARD      */
        /* ===================== */

        .testimonials-card {
            flex-shrink: 0;
            background: var(--color-white);
            border: 1.5px solid var(--color-border);
            border-radius: 16px;
            padding: 2.4rem 1.8rem 2rem;
            text-align: center;
            transition: var(--transition);
            box-sizing: border-box;
        }

        .testimonials-card:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.09);
        }

        /* ── FIXED: uniform circle image in px ── */
        .testimonials-img-wrap {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 1.3rem;
            background: var(--color-secondary);
        }

        .testimonials-customer-img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        .testimonials-stars {
            color: var(--color-accent);
            font-size: 1.2rem;
            letter-spacing: 3px;
            margin-bottom: 0.65rem;
        }

        .testimonials-customer-name {
            font-family: var(--font-display);
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        .testimonials-name-divider {
            width: 36px;
            height: 2px;
            background: var(--color-accent);
            border-radius: 2px;
            margin: 0 auto 1rem;
            opacity: 0.5;
        }

        .testimonials-review {
            font-size: 0.93rem;
            line-height: 1.85;
            color: var(--color-text-light);
        }

        /* ===================== */
        /* SLIDER BUTTONS        */
        /* ===================== */

        .testimonials-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
        }

        .testimonials-slider-btn:hover {
            background: var(--color-accent);
        }

        .testimonials-slider-btn-prev {
            left: 0;
        }

        .testimonials-slider-btn-next {
            right: 0;
        }

        /* ===================== */
        /* ADD TESTIMONIAL       */
        /* ===================== */

        .add-testimonial-section {
            background: var(--color-secondary);
            padding: 6rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .add-testimonial-inner {
            max-width: 780px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .add-testimonial-title {
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 600;
            color: var(--color-primary);
            text-align: center;
            margin-bottom: 0.6rem;
        }

        .add-testimonial-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--color-accent);
            margin: 14px auto 0;
            border-radius: 2px;
        }

        .add-testimonial-subtitle {
            text-align: center;
            color: var(--color-text-light);
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            margin-bottom: 3rem;
        }

        .add-testimonial-form {
            display: flex;
            flex-direction: column;
            gap: 1.4rem;
        }

        .add-testimonial-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.4rem;
        }

        .add-testimonial-field {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .add-testimonial-field label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--color-text-light);
        }

        .add-testimonial-field input,
        .add-testimonial-field textarea {
            background: var(--color-white);
            border: 1.5px solid var(--color-border);
            border-radius: 10px;
            padding: 0.85rem 1.1rem;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--color-text);
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
            width: 100%;
        }

        .add-testimonial-field input::placeholder,
        .add-testimonial-field textarea::placeholder {
            color: #bbb;
        }

        .add-testimonial-field input:focus,
        .add-testimonial-field textarea:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.12);
        }

        .add-testimonial-field textarea {
            resize: none;
            height: 120px;
            line-height: 1.7;
        }

        .add-testimonial-stars-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .add-testimonial-stars-wrap label:first-child {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--color-text-light);
        }

        .at-stars {
            display: flex;
            gap: 0.3rem;
        }

        .at-stars input[type="radio"] {
            display: none;
        }

        .at-stars label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
            line-height: 1;
        }

        .at-stars {
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .at-stars label:hover,
        .at-stars label:hover~label,
        .at-stars input:checked~label {
            color: var(--color-accent);
            transform: scale(1.15);
        }

        .add-testimonial-submit {
            align-self: center;
            padding: 1rem 3.5rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 50px;
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 20px rgba(212, 165, 116, 0.3);
            margin-top: 0.5rem;
        }

        .add-testimonial-submit:hover {
            background: #c9965d;
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(212, 165, 116, 0.45);
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
        }

        /* ===================== */
        /* RESPONSIVE            */
        /* ===================== */

        @media (max-width: 1400px) {
            .featured-product-container,
            .testimonials-container {
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 1200px) {
            .featured-product-item {
                min-width: calc(25% - 1.125rem);
            }
        }

        @media (max-width: 992px) {
            .featured-product-section,
            .testimonials-section {
                padding: 4rem 0;
            }

            .featured-product-section-title,
            .testimonials-section-title {
                font-size: 2.8rem;
                margin-bottom: 2.5rem;
            }

            .featured-product-item {
                min-width: calc(33.333% - 1rem);
            }
        }

        @media (max-width: 768px) {
            .featured-product-section,
            .testimonials-section {
                padding: 3rem 0;
            }

            .featured-product-container,
            .testimonials-container {
                padding: 0 1rem;
            }

            .featured-product-section-title,
            .testimonials-section-title {
                font-size: 2.2rem;
                margin-bottom: 2rem;
            }

            .featured-product-slider {
                padding: 0 55px;
            }

            .featured-product-item {
                min-width: calc(50% - 0.75rem);
            }

            .featured-product-track {
                gap: 1.2rem;
            }

            .featured-product-slider-btn {
                width: 42px;
                height: 42px;
                font-size: 1.2rem;
            }

            .testimonials-slider {
                padding: 0 50px;
            }

            .testimonials-slider-btn {
                width: 42px;
                height: 42px;
                font-size: 1.2rem;
            }

            .testimonials-card {
                padding: 2rem;
            }

            .testimonials-img-wrap { width: 90px; height: 90px; }
            .testimonials-customer-img { width: 90px; height: 90px; }

            .add-testimonial-row {
                grid-template-columns: 1fr;
            }

            .add-testimonial-title {
                font-size: 2.2rem;
            }

            .add-testimonial-section {
                padding: 4rem 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .featured-product-item {
                min-width: calc(50% - 0.6rem);
            }

            .featured-product-slider {
                padding: 0 50px;
            }

            .featured-product-track {
                gap: 1rem;
            }

            .featured-product-name {
                font-size: 1rem;
            }

            .featured-product-price {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .featured-product-section,
            .testimonials-section {
                padding: 2.5rem 0;
            }

            .featured-product-section-title,
            .testimonials-section-title {
                font-size: 1.9rem;
                margin-bottom: 1.8rem;
            }

            .featured-product-slider {
                padding: 0 45px;
            }

            .featured-product-item {
                min-width: calc(50% - 0.5rem);
            }

            .featured-product-slider-btn {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }

            .testimonials-slider {
                padding: 0 45px;
            }

            .testimonials-slider-btn {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }

            .featured-product-info {
                padding: 0.9rem;
            }

            .featured-product-name {
                font-size: 0.95rem;
            }

            .featured-product-price {
                font-size: 1.1rem;
            }

            .testimonials-card {
                padding: 1.5rem;
            }

            .add-testimonial-title {
                font-size: 1.9rem;
            }
        }

        @media (max-width: 480px) {
            .featured-product-container,
            .testimonials-container {
                padding: 0 0.8rem;
            }

            .featured-product-section-title,
            .testimonials-section-title {
                font-size: 1.7rem;
            }

            .featured-product-slider {
                padding: 0 42px;
            }

            .featured-product-item {
                min-width: calc(50% - 0.4rem);
            }

            .featured-product-track {
                gap: 0.8rem;
            }

            .featured-product-slider-btn {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .featured-product-container,
            .testimonials-container {
                padding: 0 0.6rem;
            }

            .featured-product-section,
            .testimonials-section {
                padding: 2rem 0;
            }

            .featured-product-section-title,
            .testimonials-section-title {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .featured-product-slider {
                padding: 0 38px;
            }

            .featured-product-slider-btn {
                width: 32px;
                height: 32px;
                font-size: 0.95rem;
            }

            .featured-product-info {
                padding: 0.8rem;
            }

            .featured-product-name {
                font-size: 0.9rem;
            }

            .featured-product-price {
                font-size: 1rem;
            }
        }

        @media (max-width: 360px) {
            .featured-product-slider {
                padding: 0 34px;
            }

            .featured-product-slider-btn {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }

            .featured-product-section-title,
            .testimonials-section-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

    <?php if (isset($_GET['success'])) { ?>
        <div class="success-message">
            Thank you! Your review has been submitted successfully.
        </div>
    <?php } ?>

    <!-- ===================== -->
    <!-- FEATURED PRODUCTS     -->
    <!-- ===================== -->
    <section class="featured-product-section">
        <div class="featured-product-container">
            <h2 class="featured-product-section-title">Featured Products</h2>
            <div class="featured-product-slider">
                <button class="featured-product-slider-btn featured-product-slider-btn-prev" onclick="moveFeaturedProducts(-1)">‹</button>
                <div class="featured-product-track" id="featuredProductTrack">

                    <?php while ($row = mysqli_fetch_assoc($featured_products)) {

                        $id = $row['product_id'];
                        $name = $row['product_name'];
                        $image = $row['product_image'];
                        $price = $row['product_price'];

                    ?>

                        <a href="product-detail.php?id=<?php echo $id; ?>" style="text-decoration:none;color:inherit;">

                            <div class="featured-product-item">

                                <div class="featured-product-img-wrap">

                                    <img src="<?php echo $image; ?>" class="featured-product-img">

                                </div>

                                <div class="featured-product-info">

                                    <div class="featured-product-name"><?php echo $name; ?></div>

                                    <div class="featured-product-price">Rs. <?php echo $price; ?></div>

                                </div>

                            </div>

                        </a>

                    <?php } ?>

                </div>
                <button class="featured-product-slider-btn featured-product-slider-btn-next" onclick="moveFeaturedProducts(1)">›</button>
            </div>
        </div>
    </section>

    <!-- ===================== -->
    <!-- TESTIMONIALS          -->
    <!-- ===================== -->
    <section class="testimonials-section">
        <div class="testimonials-container">
            <h2 class="testimonials-section-title">What Our Customers Say</h2>
            <div class="testimonials-slider">
                <button class="testimonials-slider-btn testimonials-slider-btn-prev" onclick="moveTestimonials(-1)">‹</button>
                <div class="testimonials-slides-wrapper">
                    <div class="testimonials-track" id="testimonialsTrack">

                        <?php while ($row = mysqli_fetch_assoc($testimonial_query)) {
                            $image  = $row['image'];
                            $name   = $row['name'];
                            $review = $row['review_text'];
                            $rating = $row['rating'];
                            $stars  = str_repeat("★", $rating);
                        ?>

                            <div class="testimonials-card">

                                <div class="testimonials-img-wrap">
                                    <img src="uploads/<?php echo $image; ?>"
                                        alt="<?php echo $name; ?>"
                                        class="testimonials-customer-img">
                                </div>

                                <div class="testimonials-stars"><?php echo $stars; ?></div>

                                <div class="testimonials-customer-name"><?php echo $name; ?></div>

                                <div class="testimonials-name-divider"></div>

                                <p class="testimonials-review">"<?php echo $review; ?>"</p>

                            </div>

                        <?php } ?>

                    </div>
                </div>
                <button class="testimonials-slider-btn testimonials-slider-btn-next" onclick="moveTestimonials(1)">›</button>
            </div>
        </div>
    </section>

    <!-- ========================= -->
    <!-- ADD YOUR TESTIMONIAL      -->
    <!-- ========================= -->
    <section class="add-testimonial-section">
        <div class="add-testimonial-inner">

            <h2 class="add-testimonial-title">Share Your Experience</h2>
            <p class="add-testimonial-subtitle">We'd love to hear what you think about Jenny Store</p>

            <form class="add-testimonial-form" method="POST" enctype="multipart/form-data">

                <div class="add-testimonial-row">
                    <div class="add-testimonial-field">
                        <label>Your Name</label>
                        <input type="text" name="name" placeholder="e.g. Ayesha Khan">
                    </div>
                    <div class="add-testimonial-field">
                        <label>Profile Photo</label>
                        <input type="file" name="image">
                    </div>
                </div>

                <div class="add-testimonial-stars-wrap">
                    <label>Your Rating</label>
                    <div class="at-stars">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                    </div>
                </div>

                <div class="add-testimonial-field">
                    <label>Your Review</label>
                    <textarea name="review_text" placeholder="Tell us about your shopping experience at Jenny Store..."></textarea>
                </div>

                <button class="add-testimonial-submit" type="submit" name="submit_review">Submit Review</button>

            </form>
        </div>
    </section>

    <script>
        /* ======================== */
        /* FEATURED PRODUCTS SLIDER */
        /* ======================== */
        let featuredProductIndex = 0;
        const featuredProductTrack = document.getElementById('featuredProductTrack');
        const featuredProductItems = document.querySelectorAll('.featured-product-item');
        const featuredProductTotal = featuredProductItems.length;

        function getVisibleFeaturedProducts() {
            const w = window.innerWidth;
            if (w <= 480) return 2;
            if (w <= 768) return 2;
            if (w <= 992) return 3;
            if (w <= 1200) return 4;
            return 5;
        }

        function getFeaturedProductGap() {
            const w = window.innerWidth;
            if (w <= 480) return 8;
            if (w <= 640) return 10;
            if (w <= 768) return 12;
            return 16;
        }

        function moveFeaturedProducts(dir) {
            const visible = getVisibleFeaturedProducts();
            const maxIndex = featuredProductTotal - visible;
            featuredProductIndex += dir;
            if (featuredProductIndex < 0) featuredProductIndex = 0;
            if (featuredProductIndex > maxIndex) featuredProductIndex = maxIndex;
            const itemWidth = featuredProductItems[0].offsetWidth;
            const gap = getFeaturedProductGap();
            featuredProductTrack.style.transform = `translateX(-${featuredProductIndex * (itemWidth + gap)}px)`;
        }

        /* ======================== */
        /* TESTIMONIALS SLIDER      */
        /* ======================== */
        let testimonialsIndex = 0;
        const testimonialsTrack = document.getElementById('testimonialsTrack');
        const testimonialsCards = document.querySelectorAll('.testimonials-card');
        const testimonialsTotal = testimonialsCards.length;

        function getVisibleTestimonials() {
            const w = window.innerWidth;
            if (w <= 768) return 1;
            if (w <= 1200) return 2;
            return 3;
        }

        function setTestimonialsWidth() {
            const visible = getVisibleTestimonials();
            const gap = 24;
            const wrapper = document.querySelector('.testimonials-slides-wrapper');
            const total = wrapper.offsetWidth;
            const w = (total - gap * (visible - 1)) / visible;
            testimonialsCards.forEach(c => c.style.minWidth = w + 'px');
            testimonialsTrack.style.gap = gap + 'px';
        }

        function moveTestimonials(dir) {
            const visible = getVisibleTestimonials();
            const maxIndex = testimonialsTotal - visible;
            testimonialsIndex += dir;
            if (testimonialsIndex < 0) testimonialsIndex = 0;
            if (testimonialsIndex > maxIndex) testimonialsIndex = maxIndex;
            const cardWidth = testimonialsCards[0].offsetWidth;
            testimonialsTrack.style.transform = `translateX(-${testimonialsIndex * (cardWidth + 24)}px)`;
        }

        setTestimonialsWidth();
        window.addEventListener('resize', () => {
            setTestimonialsWidth();
            testimonialsIndex = 0;
            testimonialsTrack.style.transform = 'translateX(0)';
        });
    </script>

</body>

</html>