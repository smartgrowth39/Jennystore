
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

/* =========================
   DELETE PRODUCT
========================= */
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $deletequery = "DELETE FROM products WHERE product_id = '$id'";
    mysqli_query($connect, $deletequery);

    header("Location: products.php");
    exit;
}

/* =========================
   UPDATE PRODUCT
========================= */
if (isset($_POST['update'])) {

    $id           = $_POST['id'];
    $update_title = $_POST['title'];
    $update_dis   = $_POST['dis'];
    $update_image = $_POST['image'];
    $update_cat   = $_POST['cat'];
    $update_price = $_POST['price'];

    $updatequery = "
        UPDATE products SET
            product_name        = '$update_title',
            product_description = '$update_dis',
            product_image       = '$update_image',
            product_cat         = '$update_cat',
            product_price       = '$update_price'
        WHERE product_id = '$id'
    ";

    mysqli_query($connect, $updatequery);

    header("Location: products.php");
    exit;
}
//  yay search ki query hai 
$search = $_POST['search'] ?? '';
$category = $_POST['category'] ?? '';

if ($search && $category) {

    $searchquery = "SELECT * FROM products 
              WHERE product_name LIKE '%$search%' 
              AND product_cat='$category'";
} elseif ($search) {

    $searchquery = "SELECT * FROM products 
              WHERE product_name LIKE '%$search%'";
} elseif ($category) {

    $searchquery = "SELECT * FROM products 
              WHERE product_cat='$category'";
} else {

    $searchquery = "SELECT * FROM products ORDER BY product_id";
}

$result = mysqli_query($connect, $searchquery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Jenny Store Admin</title>
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
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
            --color-info: #3b82f6;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.3s ease;
            --shadow-soft: 0 2px 20px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 8px 40px rgba(0, 0, 0, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--color-secondary);
            color: var(--color-text);
        }

        .dashboard { display: flex; min-height: 100vh; }

        .dashboard-main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            transition: var(--transition);
        }

        .dashboard-header {
            background: var(--color-white);
            padding: 1.5rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-header-title {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .dashboard-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 0.7rem 1.5rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: var(--color-primary);
            transform: translateY(-2px);
        }

        .search-filter-section {
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
        }

        .search-filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group { display: flex; flex-direction: column; }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.5rem;
        }

        .form-input,
        .form-select {
            padding: 0.7rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: var(--transition);
            font-family: var(--font-body);
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        .btn-filter {
            padding: 0.7rem 1.5rem;
            background: var(--color-accent);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            font-family: var(--font-body);
            white-space: nowrap;
        }

        .btn-filter:hover { background: var(--color-primary); }

        /* ── Products Grid ── */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        /* ── Card ── */
        .product-card {
            background: var(--color-white);
            border-radius: 16px;
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.13);
            border-color: var(--color-accent);
        }

        /* ── Image wrap ── */
        .product-image-wrap {
            position: relative;
            width: 100%;
            height: 260px;
            overflow: hidden;
            background: var(--color-secondary);
            flex-shrink: 0;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }

        .product-card:hover .product-image {
            transform: scale(1.07);
        }

        /* ── Category badge ── */
        .product-cat {
            position: absolute;
            top: 14px;
            left: 14px;
            background: var(--color-primary);
            color: var(--color-white);
            padding: 0.32rem 0.9rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        /* ── Info ── */
        .product-info {
            padding: 1.6rem 1.7rem 1.8rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-info h3 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .product-info p {
            font-size: 0.88rem;
            color: var(--color-text-light);
            line-height: 1.7;
            margin-bottom: 1.1rem;
            flex: 1;
        }

        /* price row */
        .product-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.3rem;
            padding-bottom: 1.1rem;
            border-bottom: 1px dashed var(--color-border);
        }

        .product-info h4 {
            font-family: var(--font-display);
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--color-accent);
            margin: 0;
        }

        .product-id-badge {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--color-text-light);
            background: var(--color-secondary);
            border: 1px solid var(--color-border);
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            letter-spacing: 0.4px;
        }

        /* ── Actions ── */
        .card-actions {
            display: flex;
            gap: 0.7rem;
            margin-top: auto;
        }

        .card-actions form {
            flex: 1;
            display: flex;
        }

        .btn-update {
            flex: 1;
            text-align: center;
            padding: 0.75rem 0;
            background: var(--color-primary);
            color: var(--color-white);
            border: 1.5px solid var(--color-primary);
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-update:hover {
            background: var(--color-accent);
            border-color: var(--color-accent);
        }

        .btn-delete {
            width: 100%;
            padding: 0.75rem 0;
            background: transparent;
            color: var(--color-danger);
            border: 1.5px solid rgba(239,68,68,0.35);
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            cursor: pointer;
            font-family: var(--font-body);
            transition: var(--transition);
        }

        .btn-delete:hover {
            background: var(--color-danger);
            border-color: var(--color-danger);
            color: var(--color-white);
        }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .dashboard-main-content {
                margin-left: 0;
                padding: 5rem 1.5rem 1.5rem;
            }

            .search-filter-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">

        <?php include "sidebar.php"; ?>

        <main class="dashboard-main-content">
            <header class="dashboard-header">
                <h1 class="dashboard-header-title">Products Management</h1>
                <div class="dashboard-header-actions">
                    <a href="add_products.php" class="btn-primary">+ Add New Product</a>
                </div>
            </header>

            <form method="POST">
                <div class="search-filter-section">
                    <div class="search-filter-grid">
                        <div class="form-group">
                            <label class="form-label">Search Products</label>
                            <input type="text" class="form-input" name="search" placeholder="Search by name...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="jewellery">jwellry</option>
                                <option value="cosmetics">Cosmetics</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-filter">Apply Filter</button>
                    </div>
                </div>
            </form>

            <div class="products-grid">

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <div class="product-card">

                        <div class="product-image-wrap">
                            <img src="<?= $row['product_image']; ?>" class="product-image" alt="<?= $row['product_name']; ?>">
                            <span class="product-cat"><?= $row['product_cat']; ?></span>
                        </div>

                        <div class="product-info">

                            <h3><?= $row['product_name']; ?></h3>

                            <p><?php
                                echo strlen($row['product_description']) > 120
                                    ? substr($row['product_description'], 0, 120) . '...'
                                    : $row['product_description'];
                            ?></p>

                            <div class="product-price-row">
                                <h4>Rs. <?= $row['product_price']; ?></h4>
                                <span class="product-id-badge">#<?= $row['product_id']; ?></span>
                            </div>

                            <div class="card-actions">

                                <a href="update_product.php?id=<?= $row['product_id']; ?>" class="btn-update">
                                    Update
                                </a>

                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $row['product_id']; ?>">
                                    <button type="submit" name="delete" class="btn-delete">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>
        </main>
    </div>
</body>

</html>