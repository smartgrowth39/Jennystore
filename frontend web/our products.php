<?php
include "connect.php";

// Handle search
$search = $_POST['search'] ?? '';
if ($search) {
    $query = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
} else {
    $query = "SELECT * FROM products ORDER BY product_id limit 20";
}
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - Jenny Store</title>
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
            color: var(--color-text);
            line-height: 1.6;
        }

        /* Hero Section */
        .product-hero {
            padding: 4rem 2rem 3rem;
            text-align: center;
            margin: 0 auto;
        }

        .product-section-title {
            font-family: var(--font-display);
            font-size: 3.5rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 1rem;
            letter-spacing: 1px;
            position: relative;
            animation: fadeInUp 0.8s ease-out;
        }

        .product-section-subtitle {
            font-size: 1.1rem;
            color: var(--color-text-light);
            font-weight: 300;
            letter-spacing: 0.5px;
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .product-section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: var(--color-accent);
            margin: 15px auto 0;
            border-radius: 2px;
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
        .our-main-products {
            background: var(--color-white);
            padding: 2rem 2rem 6rem;
        }

        .main-product-container {
            margin: 0 auto;
        }

        .home-products-grid {
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

        /* Product Card */
        .product-card {
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: 8px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            animation: slideUp 0.6s ease-out both;
        }

        .product-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .product-card:nth-child(2) {
            animation-delay: 0.15s;
        }

        .product-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .product-card:nth-child(4) {
            animation-delay: 0.25s;
        }

        .product-card:nth-child(5) {
            animation-delay: 0.3s;
        }

        .product-card:nth-child(6) {
            animation-delay: 0.35s;
        }

        .product-card:nth-child(7) {
            animation-delay: 0.4s;
        }

        .product-card:nth-child(8) {
            animation-delay: 0.45s;
        }

        .product-card:nth-child(9) {
            animation-delay: 0.5s;
        }

        .product-card:nth-child(10) {
            animation-delay: 0.55s;
        }

        .product-card:nth-child(11) {
            animation-delay: 0.6s;
        }

        .product-card:nth-child(12) {
            animation-delay: 0.65s;
        }

        .product-card:nth-child(13) {
            animation-delay: 0.7s;
        }

        .product-card:nth-child(14) {
            animation-delay: 0.75s;
        }

        .product-card:nth-child(15) {
            animation-delay: 0.8s;
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

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-accent);
        }

        .product-image-container {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            background: var(--color-secondary);
        }

        .product-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-img {
            transform: scale(1.08);
        }

        .product-info {
            padding: 1.5rem;
            text-align: center;
        }

        .product-name {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--color-primary);
            margin-bottom: 0.8rem;
            line-height: 1.3;
        }

        .product-price {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--color-accent);
            margin-bottom: 1rem;
        }

        .product-actions {
            display: flex;
            gap: 0.8rem;
        }

        .our-product-btn-primary,
        .our-product-btn-secondary {
            flex: 1;
            padding: 5px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-body);
            text-decoration: none;
        }

        .our-product-btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .our-product-btn-primary:hover {
            background: var(--color-accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .our-product-btn-secondary {
            background: transparent;
            color: var(--color-primary);
            border: 1px solid var(--color-primary);
        }

        .our-product-btn-secondary:hover {
            background: var(--color-primary);
            color: var(--color-white);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .home-products-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 992px) {
            .home-products-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }

            .product-section-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .home-products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .product-hero {
                padding: 3rem 1.5rem 2rem;
            }

            .product-section-title {
                font-size: 2rem;
            }

            .product-section-subtitle {
                font-size: 1rem;
            }

            .our-main-products {
                padding: 3rem 1.5rem 4rem;
            }
        }

        @media (max-width: 576px) {
            .home-products-grid {
                grid-template-columns: 1fr;
            }

            .product-section-title {
                font-size: 1.8rem;
            }

            .product-actions {
                flex-direction: column;
            }

            .our-product-btn-primary,
            .our-product-btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <div class="product-hero">
        <h1 class="product-section-title">Our Products</h1>
        <p class="product-section-subtitle">Discover our exquisite collection of fine jewelry and premium cosmetics</p>
    </div>

    <!-- Products Section -->
    <section class="our-main-products">
        <div class="container-fluid main-product-container">
            <div class="home-products-grid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="<?php echo $row['product_image']; ?>"
                                    alt="<?php echo $row['product_name']; ?>"
                                    class="product-img">
                            </div>

                            <div class="product-info">
                                <div class="product-name">
                                    <?php echo $row['product_name']; ?>
                                </div>

                                <div class="product-disciption">
                                    <?php
                                    // 120 characters se lamba ho to truncate karo
                                    echo strlen($row['product_description']) > 120
                                        ? substr($row['product_description'], 0, 120) . '...'
                                        : $row['product_description'];
                                    ?>
                                </div>


                                <div class="product-price">
                                    Rs. <?php echo $row['product_price']; ?>
                                </div>

                                <!-- Form start -->
                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <div class="product-actions">
                                        <button type="submit" name="cart" class="btn btn-primary our-product-btn-primary">Add to Cart</button>
                                        <a href="product-detail.php?id=<?php echo $row['product_id']; ?>" class="btn btn-secondary our-product-btn-secondary">
                                            View Details
                                        </a>
                                    </div>
                                </form>
                                <!-- Form end -->

                            </div>
                        </div>
                <?php
                    }
                } // else {
                //     echo "<p style='grid-column: 1/-1; text-align:center;'>No products found</p>";
                // }
                ?>
            </div>
        </div>
        </div>
    </section>
</body>

</html>