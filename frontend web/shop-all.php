<?php include "nav.php"; ?>
<?php
include "connect.php";

$query = "SELECT * FROM products ORDER BY product_id DESC";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop All Products - Jenny Store</title>

    <?php include "links.php"; ?>
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
            line-height: 1.6;
            color: var(--color-text);
        }

        .container {
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Banner */
        .shop-banner {
            position: relative;
            height: 500px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
        }

        .shop-banner-image-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .shop-banner-image {
            width: 100%;
            height: 100%;
            background-image: url('https://thumbs.dreamstime.com/b/makeup-products-cosmetic-bag-fashion-concept-set-decorative-cosmetics-white-background-flat-composition-magazines-143971418.jpg');
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
        }

        .shop-banner:hover .shop-banner-image {
            transform: scale(1.1);
        }

        .shop-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .shop-banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .shop-banner h1 {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease-out;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .shop-banner p {
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

        /* Breadcrumb */
        .breadcrumb {
            padding: 1.5rem 0;
            background: var(--color-white);
            border-bottom: 1px solid var(--color-border);
        }

        .breadcrumb-list {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            color: var(--color-text-light);
            flex-wrap: wrap;
        }

        .breadcrumb-list a {
            color: var(--color-text-light);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-list a:hover {
            color: var(--color-accent);
        }

        /* Shop */
        .shop-all-section {
            padding: 3rem 0;
        }

        /* Toolbar */
        .shop-all-products-toolbar {
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            animation: slideUp 0.6s ease-out;
        }

        .shop-all-results-info {
            font-weight: 600;
            color: var(--color-text);
        }

        .shop-all-toolbar-right {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .shop-all-view-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .shop-all-view-btn {
            width: 40px;
            height: 40px;
            border: 1px solid var(--color-border);
            background: var(--color-white);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .shop-all-view-btn:hover,
        .shop-all-view-btn.active {
            background: var(--color-accent);
            color: var(--color-white);
            border-color: var(--color-accent);
        }

        .sho-all-sort-select {
            padding: 0.7rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            font-size: 0.95rem;
            cursor: pointer;
            background: var(--color-white);
            transition: var(--transition);
            min-width: 180px;
        }

        .sho-all-sort-select:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        /* Products Grid */
        .shop-all-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .shop-all-product-card {
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            animation: slideUp 0.6s ease-out both;
        }

        .shop-all-product-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .shop-all-product-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .shop-all-product-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .shop-all-product-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .shop-all-product-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .shop-all-product-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .shop-all-product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-accent);
        }

        .shop-all-product-image {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            background: var(--color-secondary);
        }

        .shop-all-product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .shop-all-product-card:hover .shop-all-product-image img {
            transform: scale(1.1);
        }

        .shop-allproduct-info {
            padding: 1.2rem;
        }

        .shop-all-product-name {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
            min-height: 2.5rem;
        }

        .shop-all-product-rating {
            color: #ffd700;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .shop-all-product-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .shop-all-current-price {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-accent);
        }

        .shop-all-card-btns {
            display: flex;
            gap: 0.5rem;
        }

        .shop-all-add-to-cart {
            flex: 1;
            padding: 0.7rem 0.5rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.82rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .shop-all-add-to-cart:hover {
            background: var(--color-accent);
            transform: translateY(-2px);
        }

        .shop-all-view-details {
            flex: 1;
            padding: 0.7rem 0.5rem;
            background: var(--color-white);
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.82rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            text-align: center;
        }

        .shop-all-view-details:hover {
            background: var(--color-accent);
            color: var(--color-white);
            transform: translateY(-5px);
            border-color: var(--color-accent);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .shop-all-products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .shop-all-products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .shop-banner {
                height: 400px;
            }

            .shop-banner h1 {
                font-size: 2.5rem;
            }

            .shop-banner p {
                font-size: 1.1rem;
            }

            .shop-all-products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.2rem;
            }

            .container {
                padding: 0 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .shop-banner {
                height: 350px;
            }

            .shop-banner h1 {
                font-size: 2rem;
            }

            .container {
                padding: 0 1rem;
            }
        }

        @media (max-width: 400px) {
            .shop-all-products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- Banner -->
    <section class="shop-banner">
        <div class="shop-banner-image-wrapper">
            <div class="shop-banner-image"></div>
        </div>
        <div class="shop-banner-overlay"></div>
        <div class="container">
            <div class="shop-banner-content">
                <h1>Shop All Products</h1>
                <p>Discover Our Complete Collection of Jewelry & Beauty</p>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="container">
            <ul class="breadcrumb-list">
                <li><a href="index.php">Home</a></li>
                <li>›</li>
                <li>Shop All Products</li>
            </ul>
        </div>
    </section>

    <!-- Shop Section -->
    <section class="shop-all-section">
        <div class="container">

            <div class="shop-all-products-toolbar">
                <div class="shop-all-results-info">
                    Showing <span>6</span> of <span>185</span> products
                </div>
                <div class="shop-all-toolbar-right">
                    <div class="shop-all-view-toggle">
                        <button class="shop-all-view-btn active">⊞</button>
                        <button class="shop-all-view-btn">☰</button>
                    </div>
                    <select class="sho-all-sort-select">
                        <option>Sort by: Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="shop-all-products-grid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="shop-all-product-card">
                            <div class="shop-all-product-image">
                                <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                            </div>

                            <div class="shop-allproduct-info">
                                <div class="shop-all-product-name">
                                    <?php echo $row['product_name']; ?>
                                </div>

                                <div class="shop-all-product-disciption">
                                    <?php
                                    echo strlen($row['product_description']) > 120
                                        ? substr($row['product_description'], 0, 120) . '...'
                                        : $row['product_description'];
                                    ?>
                                </div>

                                <div class="shop-all-product-rating">★★★★★</div>

                                <div class="shop-all-product-price">
                                    <span class="shop-all-current-price">
                                        Rs. <?php echo $row['product_price']; ?>
                                    </span>
                                </div>

                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <div class="shop-all-card-btns">
                                        <button type="submit" name="cart" class="shop-all-add-to-cart">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.php?id=<?php echo $row['product_id']; ?>" class="shop-all-view-details">
                                            View Details
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p style='grid-column: 1/-1; text-align:center;'>No products found</p>";
                }
                ?>
            </div>

        </div>
    </section>

    <?php include "footer.php"; ?>

</body>

</html>