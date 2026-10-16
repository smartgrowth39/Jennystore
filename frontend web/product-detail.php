<?php
    include "nav.php";
    ?>

    <?php
    include "connect.php";

    $id = $_GET['id'] ?? null;
    if (!$id) {
        header("Location: products.php");
        exit;
    }

    // Product fetch
    $product = mysqli_fetch_assoc(
        mysqli_query($connect, "SELECT * FROM products WHERE product_id='$id'")
    );


    $reviews = mysqli_query($connect, "
SELECT * FROM reviews
WHERE product_id='$id'
ORDER BY review_date DESC
");

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $product['product_name']; ?> - Jenny Store</title>
        <?php include "links.php"; ?>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Lato:wght@300;400;600;700&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Lato', sans-serif;
                background: #f8f6f2;
                color: #2c2c2c;
                min-height: 100vh;
            }

            /* ======= WRAPPER ======= */
            .product-detail-wrapper {
                margin: 5rem auto;
                padding: 0 4rem;
            }

            /* ======= GRID ======= */
            .product-detail-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 200px;
                align-items: start;
                animation: product-detail-fadein 0.6s ease-out both;
            }

            @keyframes product-detail-fadein {
                from { opacity: 0; transform: translateY(25px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* ======= LEFT IMAGE ======= */
            .product-detail-img-wrap {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                background: #edeae4;
            }

            .product-detail-img-wrap img {
                width: 100%;
                height: 500px;
                object-fit: cover;
                display: block;
                transition: transform 0.7s ease;
            }

            .product-detail-img-wrap:hover img {
                transform: scale(1.04);
            }

            .product-detail-cat-badge {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: #1a1a1a;
                color: #d4a574;
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 2px;
                text-transform: uppercase;
                padding: 0.35rem 0.9rem;
                border-radius: 50px;
            }

            /* ======= RIGHT CONTENT ======= */
            .product-detail-content {
                background: transparent;
                border-radius: 16px;
                padding: 0.5rem 0;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .product-detail-title {
                font-family: 'Cormorant Garamond', serif;
                font-size: 2.15rem;
                font-weight: 700;
                color: #1a1a1a;
                line-height: 1.15;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: relative;
                padding-bottom: 0.75rem;
                width: fit-content;
            }

            .product-detail-title::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 50%;
                height: 3px;
                background: #d4a574;
                border-radius: 2px;
            }

            .product-detail-description {
                font-size: 1.05rem;
                color: #4a4a4a;
                line-height: 1.9;
                max-height: 90px;
                overflow: hidden;
                transition: 0.3s;
                font-weight: 400;
            }

            .product-detail-description.show {
                max-height: 1000px;
            }

            .read-btn {
                background: none;
                border: none;
                color: #d4a574;
                font-weight: 600;
                font-size: larger;
                cursor: pointer;
                margin-top: 5px;
                text-align: left;
            }

            .product-detail-price-wrap {
                display: flex;
                align-items: center;
                gap: 0.6rem;
            }

            .product-detail-price-label {
                font-size: 0.78rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #bbb;
            }

            .product-detail-price {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1.6rem;
                font-weight: 700;
                color: #1a1a1a;
            }

            .product-detail-divider {
                border: none;
                border-top: 1px solid #ede8e0;
            }

            /* ======= QTY + RATING ROW ======= */
            .product-detail-qty-rating-row {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 1rem;
            }

            /* ======= FORM ======= */
            .product-detail-form {
                display: flex;
                flex-direction: column;
                gap: 1.3rem;
            }

            .product-detail-qty-label {
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #1a1a1a;
                display: block;
                margin-bottom: 0.4rem;
            }

            .product-detail-qty-input {
                width: 100px;
                padding: 0.7rem 1rem;
                border: 1.5px solid #e0d8cc;
                border-radius: 8px;
                font-size: 0.95rem;
                font-family: 'Lato', sans-serif;
                color: #2c2c2c;
                background: #f8f6f2;
                outline: none;
                transition: all 0.3s ease;
            }

            .product-detail-qty-input:focus {
                border-color: #d4a574;
                background: #fff;
                box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.15);
            }

            /* ======= BUTTONS ======= */
            .product-detail-btn-group {
                display: flex;
                gap: 1rem;
            }

            .product-detail-btn-cart {
                flex: 1;
                padding: 0.9rem;
                background: #1a1a1a;
                color: #ffffff;
                border: 2px solid #1a1a1a;
                border-radius: 10px;
                font-size: 0.82rem;
                font-weight: 700;
                font-family: 'Lato', sans-serif;
                text-transform: uppercase;
                letter-spacing: 1px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .product-detail-btn-cart:hover {
                background: #d4a574;
                border-color: #d4a574;
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(212, 165, 116, 0.3);
            }

            /* ======= REVIEW SECTION ======= */
            .product-detail-review-section {
                margin: 5rem auto;
                padding: 0 5rem;
            }

            .product-detail-review-heading {
                font-family: 'Cormorant Garamond', serif;
                font-size: 2.15rem;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 0.5rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: relative;
                padding-bottom: 0.75rem;
                width: fit-content;
            }

            .product-detail-review-heading::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 50%;
                height: 3px;
                background: #d4a574;
                border-radius: 2px;
            }

            .product-detail-review-subheading {
                font-size: 0.88rem;
                color: #aaa;
                margin-bottom: 2rem;
                letter-spacing: 0.3px;
            }

            .product-detail-review-divider {
                border: none;
                border-top: 1px solid #ede8e0;
                margin-bottom: 2rem;
            }

            .product-detail-review-form {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.2rem;
            }

            .product-detail-review-field {
                display: flex;
                flex-direction: column;
                gap: 0.45rem;
            }

            .product-detail-review-field.product-detail-review-field-full {
                grid-column: 1 / -1;
            }

            .product-detail-review-label {
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #1a1a1a;
            }

            .product-detail-review-input,
            .product-detail-review-textarea {
                padding: 0.75rem 1rem;
                border: 1.5px solid #e0d8cc;
                border-radius: 8px;
                font-size: 0.92rem;
                font-family: 'Lato', sans-serif;
                color: #2c2c2c;
                background: #ffffff;
                outline: none;
                transition: all 0.3s ease;
                width: 100%;
            }

            .product-detail-review-input:focus,
            .product-detail-review-textarea:focus {
                border-color: #d4a574;
                box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.15);
            }

            .product-detail-review-textarea {
                resize: vertical;
                min-height: 130px;
                line-height: 1.7;
            }

            /* ======= RATING DISPLAY (static/aesthetic) ======= */
            .product-detail-rating-display {
                display: flex;
                align-items: center;
                gap: 0.6rem;
            }

            .product-detail-rating-stars {
                display: flex;
                gap: 0.1rem;
            }

            .product-detail-rating-stars span {
                font-size: 1.15rem;
                color: #d4a574;
                line-height: 1;
            }

            .product-detail-rating-stars span.product-detail-star-empty {
                color: #e0d8cc;
            }

            .product-detail-rating-text {
                font-size: 0.82rem;
                font-weight: 700;
                color: #aaa;
                letter-spacing: 0.3px;
            }

            /* Review section average */
            .product-detail-review-avg {
                display: flex;
                align-items: center;
                gap: 0.8rem;
                margin-bottom: 1.5rem;
            }

            .product-detail-review-avg-score {
                font-family: 'Cormorant Garamond', serif;
                font-size: 2.8rem;
                font-weight: 700;
                color: #1a1a1a;
                line-height: 1;
            }

            .product-detail-review-avg-right {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .product-detail-review-avg-stars {
                display: flex;
                gap: 0.1rem;
            }

            .product-detail-review-avg-stars span {
                font-size: 1.3rem;
                color: #d4a574;
            }

            .product-detail-review-avg-stars span.product-detail-star-empty {
                color: #e0d8cc;
            }

            .product-detail-review-avg-label {
                font-size: 0.78rem;
                color: #aaa;
                font-weight: 600;
                letter-spacing: 0.5px;
                text-transform: uppercase;
            }

            /* ======= STAR RATING (form) ======= */
            .product-detail-review-stars {
                display: flex;
                flex-direction: row-reverse;
                gap: 0.3rem;
                width: fit-content;
            }

            .product-detail-review-stars input {
                display: none;
            }

            .product-detail-review-stars label {
                font-size: 1.7rem;
                color: #e0d8cc;
                cursor: pointer;
                transition: color 0.2s ease;
                line-height: 1;
            }

            .product-detail-review-stars input:checked~label,
            .product-detail-review-stars label:hover,
            .product-detail-review-stars label:hover~label {
                color: #d4a574;
            }

            .product-detail-review-submit {
                grid-column: 1 / -1;
                padding: 0.9rem 2.5rem;
                background: #1a1a1a;
                color: #ffffff;
                border: 2px solid #1a1a1a;
                border-radius: 10px;
                font-size: 0.82rem;
                font-weight: 700;
                font-family: 'Lato', sans-serif;
                text-transform: uppercase;
                letter-spacing: 1.2px;
                cursor: pointer;
                transition: all 0.3s ease;
                width: fit-content;
            }

            .product-detail-review-submit:hover {
                background: #d4a574;
                border-color: #d4a574;
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(212, 165, 116, 0.3);
            }

            /* ======= CUSTOMER REVIEWS DISPLAY ======= */
            .cr-section {
                margin-bottom: 40px;
                padding: 0 4rem;
            }

            .cr-heading {
                font-family: 'Cormorant Garamond', serif;
                font-size: 2.15rem;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 1.5rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: relative;
                padding-bottom: 0.75rem;
                width: fit-content;
            }

            .cr-heading::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 50%;
                height: 3px;
                background: #d4a574;
                border-radius: 2px;
            }

            .cr-card {
                background: #ffffff;
                border: 1.5px solid #ede8e0;
                border-radius: 14px;
                padding: 1.5rem 1.8rem;
                margin-bottom: 1.2rem;
                transition: all 0.3s ease;
            }

            .cr-card:hover {
                border-color: #d4a574;
                box-shadow: 0 6px 24px rgba(212, 165, 116, 0.12);
                transform: translateY(-3px);
            }

            .cr-name {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1.15rem;
                text-transform: capitalize;
                font-weight: 700;
                color: #1a1a1a;
                display: block;
                margin-bottom: 0.3rem;
            }

            .cr-email {
                font-size: 0.8rem;
                color: #aaa;
                margin-top: 5px;
                margin-bottom: 0.6rem;
            }

            .cr-text {
                font-size: 0.93rem;
                color: #4a4a4a;
                line-height: 1.8;
                margin-top: 5px;
                margin-bottom: 0.8rem;
            }

            .cr-stars {
                color: #d4a574;
                font-size: 18px;
                letter-spacing: 2px;
            }

            /* ======= RESPONSIVE ======= */
            @media (max-width: 1024px) {
                .product-detail-grid {
                    grid-template-columns: 1fr 1fr;
                    gap: 2.5rem;
                }

                .product-detail-img-wrap img {
                    height: 420px;
                }
            }

            @media (max-width: 768px) {
                .product-detail-grid {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }

                .product-detail-wrapper {
                    padding: 0 1.2rem;
                    margin: 1rem auto 3rem;
                }

                .product-detail-img-wrap img {
                    height: 360px;
                }

                .product-detail-content {
                    padding: 0;
                }

                .product-detail-title {
                    font-size: 1.7rem;
                }

                .product-detail-review-section {
                    padding: 0 1.2rem;
                }

                .product-detail-review-form {
                    grid-template-columns: 1fr;
                }

                .product-detail-review-field.product-detail-review-field-full {
                    grid-column: 1;
                }

                .cr-section {
                    padding: 0 1.2rem;
                }
            }

            @media (max-width: 480px) {
                .product-detail-img-wrap img {
                    height: 280px;
                }

                .product-detail-content {
                    gap: 1.2rem;
                }

                .product-detail-title {
                    font-size: 1.5rem;
                }

                .product-detail-btn-group {
                    flex-direction: column;
                }
            }
        </style>
    </head>

    <body>

        <!-- Wrapper -->
        <div class="product-detail-wrapper">
            <div class="product-detail-grid">

                <!-- LEFT: Image -->
                <div class="product-detail-img-wrap">
                    <?php if (!empty($product['product_cat'])): ?>
                        <span class="product-detail-cat-badge"><?= $product['product_cat']; ?></span>
                    <?php endif; ?>
                    <img src="<?= $product['product_image']; ?>" alt="<?= $product['product_name']; ?>">
                </div>

                <!-- RIGHT: Content -->
                <div class="product-detail-content">

                    <h2 class="product-detail-title"><?= $product['product_name']; ?></h2>

                    <p class="product-detail-description" id="desc">
                        <?= $product['product_description']; ?>
                    </p>

                    <button id="readBtn" class="read-btn">Read More</button>

                    <div class="product-detail-price-wrap">
                        <span class="product-detail-price-label">Price</span>
                        <span class="product-detail-price">Rs. <?= number_format($product['product_price']); ?></span>
                    </div>

                    <hr class="product-detail-divider">

                    <form class="product-detail-form" action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?= $product['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?= $product['product_price']; ?>">
                        <input type="hidden" name="product_image" value="<?= $product['product_image']; ?>">

                        <div class="product-detail-qty-rating-row">
                            <div>
                                <label class="product-detail-qty-label">Quantity:</label>
                                <input class="product-detail-qty-input" type="number" name="qty" value="1" min="1" required>
                            </div>
                            <div class="product-detail-rating-display">
                                <div class="product-detail-rating-stars">
                                    <span>★</span><span>★</span><span>★</span><span>★</span><span class="product-detail-star-empty">★</span>
                                </div>
                                <span class="product-detail-rating-text">4.0 / 5 &nbsp;·&nbsp; 24 Reviews</span>
                            </div>
                        </div>

                        <div class="product-detail-btn-group">
                            <button class="product-detail-btn-cart" type="submit" name="cart">Add to Cart</button>

                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- ======= CUSTOMER REVIEWS DISPLAY ======= -->
        <div class="cr-section">

            <h3 class="cr-heading">Customer Reviews</h3>

            <?php
            while ($row = mysqli_fetch_assoc($reviews)) {

                $name = $row['reviewer_name'];
                $email = $row['reviewer_email'];
                $rating = $row['rating'];
                $review = $row['review_text'];

                $stars = str_repeat("★", $rating);

            ?>

                <div class="cr-card">

                    <strong class="cr-name"><?php echo $name; ?></strong>

                    <p class="cr-email"><?php echo $email; ?></p>

                    <p class="cr-text"><?php echo $review; ?></p>

                    <div class="cr-stars"><?php echo $stars; ?></div>

                </div>

            <?php } ?>

        </div>

        <div class="product-detail-review-section">
            <h3 class="product-detail-review-heading">Leave a Review</h3>
            <p class="product-detail-review-subheading">Share your experience with this product</p>

            <!-- Average rating display (aesthetic) -->
            <div class="product-detail-review-avg">
                <span class="product-detail-review-avg-score">4.0</span>
                <div class="product-detail-review-avg-right">
                    <div class="product-detail-review-avg-stars">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span class="product-detail-star-empty">★</span>
                    </div>
                    <span class="product-detail-review-avg-label">Based on 24 reviews</span>
                </div>
            </div>

            <hr class="product-detail-review-divider">

            <form class="product-detail-review-form" action="submit_review.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">

                <!-- Name -->
                <div class="product-detail-review-field">
                    <label class="product-detail-review-label">Your Name</label>
                    <input class="product-detail-review-input" type="text" name="reviewer_name" placeholder="e.g. Ayesha Khan">
                </div>

                <!-- Email -->
                <div class="product-detail-review-field">
                    <label class="product-detail-review-label">Email Address</label>
                    <input class="product-detail-review-input" type="email" name="reviewer_email" placeholder="e.g. ayesha@gmail.com">
                </div>

                <!-- Star Rating -->
                <div class="product-detail-review-field product-detail-review-field-full">
                    <label class="product-detail-review-label">Your Rating</label>
                    <div class="product-detail-review-stars">
                        <input type="radio" id="product-detail-star5" name="rating" value="5">
                        <label for="product-detail-star5">★</label>
                        <input type="radio" id="product-detail-star4" name="rating" value="4">
                        <label for="product-detail-star4">★</label>
                        <input type="radio" id="product-detail-star3" name="rating" value="3">
                        <label for="product-detail-star3">★</label>
                        <input type="radio" id="product-detail-star2" name="rating" value="2">
                        <label for="product-detail-star2">★</label>
                        <input type="radio" id="product-detail-star1" name="rating" value="1">
                        <label for="product-detail-star1">★</label>
                    </div>
                </div>

                <!-- Review Text -->
                <div class="product-detail-review-field product-detail-review-field-full">
                    <label class="product-detail-review-label">Your Review</label>
                    <textarea class="product-detail-review-textarea" name="review_text" placeholder="Tell us what you think about this product..."></textarea>
                </div>

                <!-- Submit -->
                <button class="product-detail-review-submit" type="submit" name="submit_review">
                    Submit Review
                </button>
            </form>
        </div>

        <?php
        include "footer.php";
        ?>

    </body>

    <script>
        let btn = document.getElementById("readBtn");
        let desc = document.getElementById("desc");

        btn.onclick = function() {

            if (desc.classList.contains("show")) {
                desc.classList.remove("show");
                btn.innerText = "Read More";
            } else {
                desc.classList.add("show");
                btn.innerText = "Read Less";
            }

        }
    </script>

    </html>