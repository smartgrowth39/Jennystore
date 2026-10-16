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
    case 'newest':
        $order = "ORDER BY product_id DESC";
        break;
    default:
        $order = "ORDER BY product_id DESC";
        break;
}

$query = "SELECT * FROM products WHERE product_cat = 'jewellery' $order";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewelry & Accessories - Jenny Store</title>

    <?php include "links.php"; ?>
    <style>
        :root {
            --jewellery-gold: #d4a574;
            --jewellery-dark: #1a1a1a;
            --jewellery-light: #f8f8f8;
            --jewellery-white: #ffffff;
            --jewellery-text: #2c2c2c;
            --jewellery-muted: #666666;
            --jewellery-border: #e8e8e8;
            --jewellery-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
            --jewellery-shadow2: 0 8px 40px rgba(0, 0, 0, 0.12);
            --jewellery-ease: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            --jewellery-font-h: 'Cormorant Garamond', serif;
            --jewellery-font-b: 'Lato', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--jewellery-font-b);
            color: var(--jewellery-text);
            background: var(--jewellery-white);
        }

        .jewellery-container { margin: 0 auto; padding: 0 2rem; }

        /* ======= BANNER ======= */
        .jewellery-banner {
            position: relative;
            height: 520px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .jewellery-banner-image-wrapper {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            overflow: hidden;
        }

        .jewellery-banner-image {
            width: 100%; height: 100%;
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXGLZBG8D-sdn4lXbiB0-4QSmEBz-H7C3qyQ&s');
            background-size: cover;
            background-position: center;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .jewellery-banner:hover .jewellery-banner-image { transform: scale(1.08); }

        .jewellery-banner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .jewellery-banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--jewellery-white);
            width: 100%;
        }

        .jewellery-banner-deco {
            color: var(--jewellery-gold);
            font-size: 0.72rem;
            letter-spacing: 6px;
            margin-bottom: 1.4rem;
            opacity: 0.9;
            animation: jewellery-fade-up 0.7s ease-out both;
        }

        .jewellery-banner-title {
            font-family: var(--jewellery-font-h);
            font-size: 5rem;
            font-weight: 700;
            margin-bottom: 1.1rem;
            letter-spacing: 1px;
            text-shadow: 0 4px 28px rgba(0, 0, 0, 0.55);
            line-height: 1.08;
            animation: jewellery-fade-up 0.7s ease-out 0.15s both;
        }

        .jewellery-banner-subtitle {
            font-size: 1rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--jewellery-gold);
            opacity: 0.95;
            margin-bottom: 2rem;
            animation: jewellery-fade-up 0.7s ease-out 0.3s both;
        }

        .jewellery-banner-desc {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.85);
            max-width: 600px;
            margin: 0 auto 2.2rem;
            line-height: 1.7;
            font-weight: 300;
            animation: jewellery-fade-up 0.7s ease-out 0.45s both;
        }

        .jewellery-banner-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            animation: jewellery-fade-up 0.7s ease-out 0.6s both;
        }

        .jewellery-banner-divider-line { width: 60px; height: 1px; background: var(--jewellery-gold); opacity: 0.7; }
        .jewellery-banner-divider-diamond { width: 7px; height: 7px; background: var(--jewellery-gold); transform: rotate(45deg); }

        @keyframes jewellery-fade-up {
            from { opacity: 0; transform: translateY(35px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes jewellery-slide-up {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ======= BREADCRUMB ======= */
        .jewellery-breadcrumb-bar {
            background: var(--jewellery-white);
            border-bottom: 1px solid var(--jewellery-border);
            padding: 0.9rem 0;
        }

        .jewellery-breadcrumb-list {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            color: var(--jewellery-muted);
            font-size: 0.88rem;
            align-items: center;
        }

        .jewellery-breadcrumb-list a { color: var(--jewellery-muted); text-decoration: none; transition: color 0.3s; }
        .jewellery-breadcrumb-list a:hover { color: var(--jewellery-gold); }

        /* ======= SHOP SECTION ======= */
        .jewellery-shop-wrap { padding: 2.5rem 0; }

        /* ======= TOOLBAR ======= */
        .jewellery-toolbar-bar {
            background: var(--jewellery-white);
            padding: 1.2rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: var(--jewellery-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            animation: jewellery-slide-up 0.6s ease-out;
        }

        .jewellery-results-label { font-weight: 600; font-size: 0.95rem; }

        .jewellery-toolbar-actions { display: flex; gap: 1rem; align-items: center; }

        .jewellery-view-switcher { display: flex; gap: 0.4rem; }

        .jewellery-view-switch-btn {
            width: 38px; height: 38px;
            border: 1px solid var(--jewellery-border);
            background: var(--jewellery-white);
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: var(--jewellery-ease);
        }

        .jewellery-view-switch-btn:hover,
        .jewellery-view-switch-btn.jewellery-view-on {
            background: var(--jewellery-gold);
            color: var(--jewellery-white);
            border-color: var(--jewellery-gold);
        }

        .jewellery-sort-select {
            padding: 0.65rem 1rem;
            border: 1px solid var(--jewellery-border);
            border-radius: 8px;
            cursor: pointer;
            background: var(--jewellery-white);
            font-family: var(--jewellery-font-b);
            font-size: 0.9rem;
            min-width: 180px;
            outline: none;
        }

        .jewellery-sort-select:focus { border-color: var(--jewellery-gold); }

        /* ======= PRODUCT GRID ======= */
        .jewellery-product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .jewellery-product-card {
            background: var(--jewellery-white);
            border: 1px solid var(--jewellery-border);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--jewellery-ease);
            cursor: pointer;
            animation: jewellery-slide-up 0.6s ease-out both;
        }

        .jewellery-product-card:nth-child(1) { animation-delay: 0.1s; }
        .jewellery-product-card:nth-child(2) { animation-delay: 0.2s; }
        .jewellery-product-card:nth-child(3) { animation-delay: 0.3s; }
        .jewellery-product-card:nth-child(4) { animation-delay: 0.4s; }
        .jewellery-product-card:nth-child(5) { animation-delay: 0.5s; }
        .jewellery-product-card:nth-child(6) { animation-delay: 0.6s; }

        .jewellery-product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--jewellery-shadow2);
            border-color: var(--jewellery-gold);
        }

        .jewellery-product-img-wrap {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            background: var(--jewellery-light);
        }

        .jewellery-product-img-wrap img {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .jewellery-product-card:hover .jewellery-product-img-wrap img { transform: scale(1.08); }

        .jewellery-product-body { padding: 1.2rem; }

        .jewellery-product-name {
            font-family: var(--jewellery-font-h);
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--jewellery-dark);
            margin-bottom: 0.4rem;
            min-height: 2.4rem;
        }

        .jewellery-product-stars { color: #ffc107; font-size: 0.85rem; margin-bottom: 0.5rem; }

        .jewellery-product-price-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1rem;
        }

        .jewellery-price-main {
            font-family: var(--jewellery-font-h);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--jewellery-gold);
        }

        .jewellery-price-strike { font-size: 0.9rem; color: var(--jewellery-muted); text-decoration: line-through; }

        .jewellery-btn-group { display: flex; gap: 0.5rem; }

        .jewellery-cart-btn {
            flex: 1;
            padding: 0.7rem 0.5rem;
            background: var(--jewellery-dark);
            color: var(--jewellery-white);
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-family: var(--jewellery-font-b);
            cursor: pointer;
            transition: var(--jewellery-ease);
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
        }

        .jewellery-cart-btn:hover { background: var(--jewellery-gold); transform: translateY(-2px); }

        .jewellery-view-btn {
            flex: 1;
            padding: 0.7rem 0.5rem;
            background: var(--jewellery-white);
            color: var(--jewellery-dark);
            border: 2px solid var(--jewellery-dark);
            border-radius: 6px;
            font-weight: 700;
            font-family: var(--jewellery-font-b);
            cursor: pointer;
            transition: var(--jewellery-ease);
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            text-decoration: none;
            text-align: center;
        }

        .jewellery-view-btn:hover {
            background: var(--jewellery-gold);
            color: var(--jewellery-white);
            border-color: var(--jewellery-gold);
            transform: translateY(-5px);
        }

        /* ======= RESPONSIVE ======= */
        @media (max-width: 1200px) {
            .jewellery-product-grid { grid-template-columns: repeat(3, 1fr); }
            .jewellery-banner-title { font-size: 3.8rem; }
        }

        @media (max-width: 992px) { .jewellery-product-grid { grid-template-columns: repeat(2, 1fr); } }

        @media (max-width: 768px) {
            .jewellery-banner { height: 400px; }
            .jewellery-banner-title { font-size: 2.8rem; }
            .jewellery-banner-subtitle { font-size: 0.8rem; letter-spacing: 2px; }
            .jewellery-banner-desc { font-size: 0.92rem; padding: 0 1rem; }
            .jewellery-container { padding: 0 1.25rem; }
        }

        @media (max-width: 576px) {
            .jewellery-banner { height: 340px; }
            .jewellery-banner-title { font-size: 2rem; }
            .jewellery-banner-deco { display: none; }
            .jewellery-banner-desc { display: none; }
            .jewellery-product-grid { grid-template-columns: repeat(2, 1fr); }
            .jewellery-container { padding: 0 1rem; }
            .jewellery-toolbar-bar { padding: 1rem; }
        }

        @media (max-width: 400px) {
            .jewellery-banner-title { font-size: 1.7rem; }
            .jewellery-product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <!-- ===== BANNER ===== -->
    <section class="jewellery-banner">
        <div class="jewellery-banner-image-wrapper">
            <div class="jewellery-banner-image"></div>
        </div>
        <div class="jewellery-banner-overlay"></div>
        <div class="jewellery-container jewellery-banner-content">
            <p class="jewellery-banner-deco">◆ ─── ◆ ─── ◆</p>
            <h1 class="jewellery-banner-title">Jewelry & Accessories</h1>
            <p class="jewellery-banner-subtitle">Timeless Elegance in Every Piece</p>
            <p class="jewellery-banner-desc">
                Discover our exquisite collection of handcrafted jewelry — from sparkling diamonds
                to lustrous pearls, each piece tells a story of beauty and craftsmanship.
            </p>
            <div class="jewellery-banner-divider">
                <div class="jewellery-banner-divider-line"></div>
                <div class="jewellery-banner-divider-diamond"></div>
                <div class="jewellery-banner-divider-line"></div>
            </div>
        </div>
    </section>

    <!-- ===== BREADCRUMB ===== -->
    <div class="jewellery-breadcrumb-bar">
        <div class="jewellery-container">
            <ul class="jewellery-breadcrumb-list">
                <li><a href="index.php">Home</a></li>
                <li>›</li>
                <li>Jewelry</li>
            </ul>
        </div>
    </div>

    <!-- ===== SHOP SECTION ===== -->
    <section class="jewellery-shop-wrap">
        <div class="jewellery-container">

            <div class="jewellery-toolbar-bar">
                <div class="jewellery-results-label">
                    Showing <strong><?php echo mysqli_num_rows($result); ?></strong> products
                </div>
                <div class="jewellery-toolbar-actions">
                    <div class="jewellery-view-switcher">
                        <button class="jewellery-view-switch-btn jewellery-view-on">⊞</button>
                        <button class="jewellery-view-switch-btn">☰</button>
                    </div>
                    <select class="jewellery-sort-select" onchange="window.location.href='jewellery.php?sort='+this.value">
                        <option value="featured" <?php echo $sort == 'featured' ? 'selected' : ''; ?>>Sort by: Featured</option>
                        <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                    </select>
                </div>
            </div>

            <div class="jewellery-product-grid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="jewellery-product-card">
                            <div class="jewellery-product-img-wrap">
                                <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                            </div>

                            <div class="jewellery-product-body">
                                <div class="jewellery-product-name">
                                    <?php echo $row['product_name']; ?>
                                </div>

                                <div class="jwellery-product-disciption">
                                    <?php
                                    echo strlen($row['product_description']) > 120
                                        ? substr($row['product_description'], 0, 120) . '...'
                                        : $row['product_description'];
                                    ?>
                                </div>

                                <div class="jewellery-product-stars">★★★★★</div>

                                <div class="jewellery-product-price-row">
                                    <span class="jewellery-price-main">
                                        Rs. <?php echo $row['product_price']; ?>
                                    </span>
                                </div>

                                <form action="add_to_cart.php" method="POST">
                                    <div class="jewellery-btn-group">
                                        <input type="hidden" name="qty" value="1">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

                                        <button type="submit" name="cart" class="jewellery-cart-btn">
                                            Add to Cart
                                        </button>

                                        <a href="product-detail.php?id=<?php echo $row['product_id']; ?>" class="jewellery-view-btn">
                                            View Details
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p style='grid-column:1/-1;text-align:center;'>No jewellery products found</p>";
                }
                ?>
            </div>

        </div>
    </section>

    <?php include "footer.php"; ?>

</body>

</html>