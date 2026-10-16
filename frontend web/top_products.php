<?php
include "connect.php";

$query = " SELECT 
products.product_id,
products.product_name,
products.product_price,
products.product_image,
products.product_description,
products.product_cat,
SUM(order_items.product_quantity) as total_sold

FROM order_items

JOIN products 
ON order_items.product_id = products.product_id

GROUP BY order_items.product_id

ORDER BY total_sold DESC

LIMIT 10
";

$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 Best Selling Products - Jenny Store</title>
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

        /* Hero Section */
        .top-product-section {
            padding: 4rem 2rem 3rem;
            text-align: center;
            position: relative;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .top-product-heading {
            font-family: var(--font-display);
            font-size: 3.5rem;
            font-weight: 600;
            color: var(--color-primary);
            letter-spacing: 1px;
            animation: fadeInUp 0.8s ease-out;
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

        /* Products Section */
        .top-products-section {
            padding: 4rem 2rem 2rem;
        }

        .top-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2.5rem;
            animation: fadeIn 1s ease-out 0.4s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* ── Product Card ── */
        .top-product-card {
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            animation: slideUp 0.6s ease-out both;
        }

        .top-product-card:nth-child(1) {
            animation-delay: 0.10s;
        }

        .top-product-card:nth-child(2) {
            animation-delay: 0.15s;
        }

        .top-product-card:nth-child(3) {
            animation-delay: 0.20s;
        }

        .top-product-card:nth-child(4) {
            animation-delay: 0.25s;
        }

        .top-product-card:nth-child(5) {
            animation-delay: 0.30s;
        }

        .top-product-card:nth-child(6) {
            animation-delay: 0.35s;
        }

        .top-product-card:nth-child(7) {
            animation-delay: 0.40s;
        }

        .top-product-card:nth-child(8) {
            animation-delay: 0.45s;
        }

        .top-product-card:nth-child(9) {
            animation-delay: 0.50s;
        }

        .top-product-card:nth-child(10) {
            animation-delay: 0.55s;
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

        .top-product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.10);
            border-color: var(--color-accent);
        }

        /* Image */
        .top-product-image-container {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            background: var(--color-secondary);
        }

        .top-product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .top-product-card:hover .top-product-image {
            transform: scale(1.06);
        }

        /* Badge */
        .top-bestseller-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--color-primary);
            color: var(--color-white);
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
        }

        /* Info */
        .top-product-info {
            padding: 1.4rem 1.4rem 1.6rem;
        }

        .top-product-name {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 0.45rem;
            line-height: 1.3;
        }

        .top-product-description {
            font-size: 0.87rem;
            color: var(--color-text-light);
            line-height: 1.6;
            min-height: 3rem;
        }

        .top-product-price {
            font-family: var(--font-display);
            font-size: 1.65rem;
            font-weight: 600;
            color: var(--color-accent);
            margin-bottom: 1.2rem;
            letter-spacing: 0.3px;
        }

        /* ── Buttons ── */
        .top-product-actions {
            display: flex;
            gap: 0.6rem;
        }

        .featured-btn-primary,
        .featured-btn-secondary {
            flex: 1;
            padding: 0.7rem 0.5rem;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-body);
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .featured-btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
            border: 1.5px solid var(--color-primary);
        }

        .featured-btn-primary:hover {
            background: var(--color-accent);
            border-color: var(--color-accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(212, 165, 116, 0.35);
        }

        .featured-btn-secondary {
            background: transparent;
            color: var(--color-primary);
            border: 1.5px solid var(--color-border);
        }

        .featured-btn-secondary:hover {
            border-color: var(--color-primary);
            background: var(--color-primary);
            color: var(--color-white);
            transform: translateY(-2px);
        }

        /* ── Hidden more products ── */
        .more-products {
            display: none;
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .more-products.show {
            display: contents;
            animation: fadeInScale 0.8s ease-out forwards;
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ── View More button ── */
        .top-products-view-more-section {
            text-align: center;
            padding: 3rem 2rem 6rem;
            max-width: 80%;
            margin: 0 auto;
        }

        .top-products-view-more-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 18px 40px;
            background: var(--color-primary);
            color: var(--color-white);
            border: 2px solid var(--color-primary);
            border-radius: 50px;
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }

        .top-products-view-more-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .top-products-view-more-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .top-products-view-more-btn:hover {
            background: var(--color-accent);
            border-color: var(--color-accent);
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(212, 165, 116, 0.4);
        }

        .top-products-view-more-btn .top-products-view-more-icon {
            font-size: 1.2rem;
            transition: transform 0.4s ease;
        }

        .top-products-view-more-btn:hover .top-products-view-more-icon {
            transform: translateY(3px);
        }

        .top-products-view-more-btn.hidden {
            display: none;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .top-products-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 968px) {
            .top-products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .top-product-heading {
                font-size: 2.5rem;
            }

            .top-products-view-more-section {
                max-width: 90%;
            }
        }

        @media (max-width: 768px) {
            .top-product-heading {
                font-size: 2rem;
            }

            .top-products-section {
                padding: 3rem 1.5rem 2rem;
            }

            .top-products-view-more-section {
                max-width: 95%;
                padding: 2rem 1.5rem 4rem;
            }

            .top-products-view-more-btn {
                font-size: 1rem;
                padding: 16px 30px;
            }
        }

        @media (max-width: 576px) {
            .top-products-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .top-product-heading {
                font-size: 1.8rem;
            }

            .top-product-name {
                font-size: 1.2rem;
            }

            .top-product-actions {
                flex-direction: column;
            }

            .featured-btn-primary,
            .featured-btn-secondary {
                width: 100%;
            }

            .top-products-view-more-btn {
                font-size: 0.95rem;
                padding: 14px 25px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="top-product-section">
        <h1 class="top-product-heading">Top Best Selling Products</h1>
    </section>

    <!-- Products Section -->
    <section class="top-products-section">
        <div class="top-products-grid" id="productsGrid">

            <?php
            $count = 0;

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    $count++;

                    if ($count == 5) {
                        echo '<div class="more-products" id="moreProducts">';
                    }
            ?>

                    <div class="top-product-card">

                        <div class="top-product-image-container">

                            <img src="<?php echo $row['product_image']; ?>"
                                class="top-product-image"
                                alt="<?php echo $row['product_name']; ?>">

                            <div class="top-bestseller-badge">🔥 Best Seller</div>
                        </div>

                        <div class="top-product-info">

                            <h3 class="top-product-name">
                                <?php echo $row['product_name']; ?>
                            </h3>

                            <p class="top-product-description">
                                <?php
                                $desc = $row['product_description'];
                                echo strlen($desc) > 120 ? substr($desc, 0, 120) . '...' : $desc;
                                ?>
                            </p>

                            <div class="top-product-price">
                                Rs. <?php echo number_format($row['product_price']); ?>
                            </div>

                            <div class="top-product-actions">

                                <form action="add_to_cart.php" method="POST">

                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

                                    <input type="hidden" name="qty" value="1">

                                    <button class="btn btn-primary featured-btn-primary" name="cart">
                                        Add to Cart
                                    </button>

                                </form>

                                <a href="product-detail.php?id=<?php echo $row['product_id']; ?>"
                                    class="btn btn-secondary featured-btn-secondary">
                                    View Details
                                </a>

                            </div>

                        </div>

                    </div>

            <?php
                }

                if ($count >= 5) {
                    echo '</div>';
                }
            }
            ?>

        </div>
    </section>

    <!-- View More Button Section -->
    <section class="top-products-view-more-section">
        <button class="top-products-view-more-btn" id="topproductsviewMoreBtn" onclick="showMoreProducts()">
            <span>View More Products</span>
            <span class="top-products-view-more-icon">↓</span>
        </button>
    </section>

    <script>
        function showMoreProducts() {
            const moreProducts = document.getElementById('moreProducts');
            const topproductsviewMoreBtn = document.getElementById('topproductsviewMoreBtn');

            // Show hidden products with animation
            moreProducts.classList.add('show');

            // Hide the button after clicking
            topproductsviewMoreBtn.classList.add('hidden');

            // Smooth scroll to the first new product
            setTimeout(() => {
                const firstNewProduct = moreProducts.querySelector('.top-product-card');
                if (firstNewProduct) {
                    firstNewProduct.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }, 100);
        }
    </script>

</body>

</html>