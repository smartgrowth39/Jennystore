<?php
include "nav.php";
?>

<?php
include "connect.php";

// Sort parameter handle karo
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'featured';

switch($sort) {
    case 'price_low':
        $order = "ORDER BY CAST(product_price AS UNSIGNED) ASC";
        break;
    case 'price_high':
        $order = "ORDER BY CAST(product_price AS UNSIGNED) DESC";
        break;
    default:
        $order = "ORDER BY product_id DESC";
        break;
}

$query = "SELECT * FROM products WHERE product_cat = 'cosmetics' $order";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetics & Beauty Products - Jenny Store</title>
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

        .cosmetics-container {
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Banner */
        .cosmetics-banner {
            position: relative;
            color: var(--color-white);
            padding: 5rem 0;
            text-align: center;
            overflow: hidden;
            min-height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cosmetics-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1612817288484-6f916006741a?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YmVhdXR5JTIwcHJvZHVjdHN8ZW58MHx8MHx8fDA%3D');
            background-size: cover;
            background-position: center;
            transition: transform 0.8s ease-out;
            z-index: 0;
        }

        .cosmetics-banner:hover::before {
            transform: scale(1.08);
        }

        .cosmetics-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .cosmetics-banner-content {
            position: relative;
            z-index: 2;
        }

        .cosmetics-banner h1 {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease-out;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .cosmetics-banner p {
            font-size: 1.3rem;
            opacity: 0.95;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Breadcrumb */
        .cosmetics-breadcrumb {
            padding: 1.5rem 0;
            background: var(--color-white);
            border-bottom: 1px solid var(--color-border);
        }

        .cosmetics-breadcrumb-list {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            color: var(--color-text-light);
            flex-wrap: wrap;
        }

        .cosmetics-breadcrumb-list a {
            color: var(--color-text-light);
            text-decoration: none;
            transition: var(--transition);
        }

        .cosmetics-breadcrumb-list a:hover { color: var(--color-accent); }

        /* Shop */
        .cosmetics-shop-section { padding: 3rem 0; }

        /* Toolbar */
        .cosmetics-products-toolbar {
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

        .cosmetics-results-info { font-weight: 600; color: var(--color-text); }

        .cosmetics-toolbar-right {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .cosmetics-view-toggle { display: flex; gap: 0.5rem; }

        .cosmetics-view-btn {
            width: 40px;
            height: 40px;
            border: 1px solid var(--color-border);
            background: var(--color-white);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .cosmetics-view-btn:hover,
        .cosmetics-view-btn.cosmetics-active {
            background: var(--color-accent);
            color: var(--color-white);
            border-color: var(--color-accent);
        }

        .cosmetics-sort-select {
            padding: 0.7rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            cursor: pointer;
            background: var(--color-white);
            font-size: 0.95rem;
            transition: var(--transition);
            min-width: 180px;
        }

        .cosmetics-sort-select:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        /* Products Grid */
        .cosmetics-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .cosmetics-product-card {
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            animation: slideUp 0.6s ease-out both;
        }

        .cosmetics-product-card:nth-child(1) { animation-delay: 0.1s; }
        .cosmetics-product-card:nth-child(2) { animation-delay: 0.2s; }
        .cosmetics-product-card:nth-child(3) { animation-delay: 0.3s; }
        .cosmetics-product-card:nth-child(4) { animation-delay: 0.4s; }
        .cosmetics-product-card:nth-child(5) { animation-delay: 0.5s; }
        .cosmetics-product-card:nth-child(6) { animation-delay: 0.6s; }

        .cosmetics-product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--color-accent);
        }

        .cosmetics-product-image {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            background: var(--color-secondary);
        }

        .cosmetics-product-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .cosmetics-product-card:hover .cosmetics-product-image img { transform: scale(1.1); }

        .cosmetics-product-info { padding: 1.2rem; }

        .cosmetics-product-brand {
            font-size: 0.8rem;
            color: var(--color-accent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.3rem;
            font-weight: 700;
        }

        .cosmetics-product-name {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
            min-height: 2.5rem;
        }

        .cosmetics-product-rating {
            color: #ffd700;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .cosmetic-product-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .cosmetic-current-price {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-accent);
        }

        .cosmetics-card-btns { display: flex; gap: 0.5rem; }

        .cosmetics-add-to-cart {
            flex: 1;
            padding: 0.7rem 0.5rem;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.5px;
        }

        .cosmetics-add-to-cart:hover {
            background: var(--color-accent);
            transform: translateY(-2px);
        }

        .cosmetics-view-details {
            flex: 1;
            padding: 0.7rem 0.5rem;
            background: var(--color-white);
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.5px;
            text-align: center;
            text-decoration: none;
        }

        .cosmetics-view-details:hover {
            background: var(--color-accent);
            color: var(--color-white);
            transform: translateY(-5px);
            border-color: var(--color-accent);
        }

        /* Responsive */
        @media (max-width: 1200px) { .cosmetics-products-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 992px) { .cosmetics-products-grid { grid-template-columns: repeat(2, 1fr); } }

        @media (max-width: 768px) {
            .cosmetics-banner h1 { font-size: 2.5rem; }
            .cosmetics-banner p { font-size: 1.1rem; }
            .cosmetics-banner { padding: 4rem 0; min-height: 350px; }
            .cosmetics-products-grid { grid-template-columns: repeat(2, 1fr); gap: 1.2rem; }
            .cosmetics-container { padding: 0 1.25rem; }
        }

        @media (max-width: 576px) {
            .cosmetics-banner h1 { font-size: 2rem; }
            .cosmetics-banner { padding: 3rem 0; min-height: 300px; }
            .cosmetics-products-grid { grid-template-columns: repeat(2, 1fr); }
            .cosmetics-container { padding: 0 1rem; }
        }

        @media (max-width: 400px) { .cosmetics-products-grid { grid-template-columns: 1fr; } }
    </style>
</head>

<body>

    <!-- Banner -->
    <section class="cosmetics-banner">
        <div class="cosmetics-container">
            <div class="cosmetics-banner-content">
                <h1>Cosmetics & Beauty</h1>
                <p>Discover Your Perfect Look with Premium Beauty Products</p>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <section class="cosmetics-breadcrumb">
        <div class="cosmetics-container">
            <ul class="cosmetics-breadcrumb-list">
                <li><a href="index.php">Home</a></li>
                <li>›</li>
                <li>Cosmetics</li>
            </ul>
        </div>
    </section>

    <!-- Shop Section -->
    <section class="cosmetics-shop-section">
        <div class="cosmetics-container">

            <div class="cosmetics-products-toolbar">
                <div class="cosmetics-results-info">
                    Showing <span><?php echo mysqli_num_rows($result); ?></span> products
                </div>
                <div class="cosmetics-toolbar-right">
                    <div class="cosmetics-view-toggle">
                        <button class="cosmetics-view-btn cosmetics-active">⊞</button>
                        <button class="cosmetics-view-btn">☰</button>
                    </div>
                    <select class="cosmetics-sort-select" onchange="window.location.href='cosmetics.php?sort='+this.value">
                        <option value="featured" <?php echo $sort == 'featured' ? 'selected' : ''; ?>>Sort by: Featured</option>
                        <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="cosmetics-products-grid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="cosmetics-product-card">
                            <div class="cosmetics-product-image">
                                <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                            </div>

                            <div class="cosmetics-product-info">
                                <div class="cosmetics-product-brand">
                                    <?php echo $row['product_cat']; ?>
                                </div>

                                <div class="cosmetics-product-name">
                                    <?php echo $row['product_name']; ?>
                                </div>

                                <div class="cosmetics-product-disciption">
                                    <?php
                                    echo strlen($row['product_description']) > 120
                                        ? substr($row['product_description'], 0, 120) . '...'
                                        : $row['product_description'];
                                    ?>
                                </div>

                                <div class="cosmetics-product-rating">★★★★★</div>

                                <div class="cosmetic-product-price">
                                    <span class="cosmetic-current-price">
                                        Rs. <?php echo $row['product_price']; ?>
                                    </span>
                                </div>

                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                    <input type="hidden" name="qty" value="1">

                                    <div class="cosmetics-card-btns">
                                        <button type="submit" name="cart" class="cosmetics-add-to-cart">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.php?id=<?php echo $row['product_id']; ?>" class="cosmetics-view-details">
                                            View Details
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p style='grid-column:1/-1;text-align:center;'>No cosmetics products found</p>";
                }
                ?>
            </div>

        </div>
    </section>

    <?php include "footer.php"; ?>

</body>

</html>