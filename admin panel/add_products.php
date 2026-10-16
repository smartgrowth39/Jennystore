
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

if (isset($_POST['upload'])) {

    $title = $_POST['title'];
    // $dis   = $_POST['discription'];
    $dis = mysqli_real_escape_string($connect, $_POST['discription']);
    $cat   = $_POST['cat'] ?? '';
    $featured = isset($_POST['featured']) ? 1 : 0;
    $price = $_POST['price'];

    $imagePath = "";

    // CASE 1: File Upload
    if (!empty($_FILES['image']['name'])) {

        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $folder = "../assets/" . $img_name;

        if (move_uploaded_file($tmp_name, $folder)) {
            $imagePath = $folder;
        }
    }
    // CASE 2: Image URL
    else if (!empty($_POST['image_url'])) {

        $imagePath = $_POST['image_url'];
    }

    // Final insert
    if (!empty($imagePath)) {

        $query = "INSERT INTO products
        (product_name, product_description, product_image, product_cat, product_price ,featured_products)
        VALUES
        ('$title','$dis','$imagePath','$cat','$price' , $featured)";

        mysqli_query($connect, $query);

        header("Location: add_products.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <?php include "links.php"; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            --color-primary: #1a1a1a;
            --color-secondary: #f8f8f8;
            --color-accent: #d4a574;
            --color-accent-light: rgba(212, 165, 116, 0.12);
            --color-accent-mid: rgba(212, 165, 116, 0.25);
            --color-white: #ffffff;
            --color-text: #2c2c2c;
            --color-text-light: #666666;
            --color-border: #e8e8e8;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.3s ease;
            --shadow-soft: 0 2px 20px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 8px 40px rgba(212, 165, 116, 0.22);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5ede0 0%, #ede3d5 50%, #e8ddd0 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        .product-add-wrapper {
            width: 100%;
            max-width: 680px;
        }

        .product-add-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .product-add-header {
            background: #1a1a1a;
            padding: 2rem 2.5rem;
            text-align: center;
        }

        .product-add-header h2 {
            color: #ffffff;
            font-size: 1.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .product-add-header-line {
            width: 50px;
            height: 3px;
            background: #d4a574;
            border-radius: 2px;
            margin: 0 auto;
        }

        .product-add-body {
            padding: 2.5rem;
        }

        .product-add-form {
            display: flex;
            flex-direction: column;
            gap: 1.4rem;
        }

        .product-add-field {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .product-add-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #1a1a1a;
        }

        .product-add-input,
        .product-add-textarea {
            width: 100%;
            padding: 0.85rem 1.1rem;
            border: 1.5px solid #e8e0d5;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #2c2c2c;
            background: #f8f6f2;
            transition: all 0.3s ease;
            outline: none;
        }

        .product-add-input:focus,
        .product-add-textarea:focus {
            border-color: #d4a574;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.15);
        }

        .product-add-textarea {
            resize: vertical;
            min-height: 110px;
            line-height: 1.6;
        }

        .product-add-input::placeholder,
        .product-add-textarea::placeholder {
            color: #aaa;
            font-weight: 300;
        }

        /* Checkboxes */
        .product-add-checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }

        .product-add-checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.85rem 1.1rem;
            border: 1.5px solid #e8e0d5;
            border-radius: 10px;
            background: #f8f6f2;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .product-add-checkbox-item:hover {
            border-color: #d4a574;
            background: #fdf8f3;
        }

        .product-add-checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #d4a574;
            cursor: pointer;
            flex-shrink: 0;
        }

        .product-add-checkbox-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c2c2c;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        /* ======= IMAGE SECTION ======= */
        .product-add-image-section {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        /* Upload Drop Zone */
        .product-add-upload-zone {
            position: relative;
            border: 2px dashed #d4a574;
            border-radius: 12px;
            background: #fdf8f3;
            padding: 2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .product-add-upload-zone:hover {
            background: #faf3ea;
            border-color: #c4956a;
        }

        .product-add-upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .product-add-upload-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
        }

        .product-add-upload-hint {
            font-size: 0.8rem;
            color: #aaa;
        }

        /* OR divider */
        .product-add-or-divider {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: #bbb;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-add-or-divider::before,
        .product-add-or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e0d5;
        }

        /* URL input with icon prefix */
        .product-add-url-wrap {
            position: relative;
        }

        .product-add-url-prefix {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            pointer-events: none;
        }

        .product-add-url-input {
            width: 100%;
            padding: 0.95rem 1.1rem 0.95rem 2.7rem;
            border: 1.5px solid #e8e0d5;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #2c2c2c;
            background: #f8f6f2;
            transition: all 0.3s ease;
            outline: none;
        }

        .product-add-url-input:focus {
            border-color: #d4a574;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.15);
        }

        .product-add-url-input::placeholder {
            color: #aaa;
            font-weight: 300;
        }

        /* Submit button */
        .product-add-btn {
            width: 100%;
            padding: 1rem;
            background: #1a1a1a;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.35s ease;
            margin-top: 0.4rem;
        }

        .product-add-btn:hover {
            background: #d4a574;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(212, 165, 116, 0.4);
        }

        .product-add-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 576px) {
            .product-add-body {
                padding: 1.8rem 1.2rem;
            }

            .product-add-header {
                padding: 1.6rem 1.2rem;
            }

            .product-add-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <?php include "sidebar.php"; ?>


    <div class="product-add-wrapper">
        <div class="product-add-card">

            <div class="product-add-header">
                <h2>Add Product</h2>
                <div class="product-add-header-line"></div>
            </div>

            <div class="product-add-body">
                <form class="product-add-form" method="POST" enctype="multipart/form-data">

                    <div class="product-add-field">
                        <label class="product-add-label">Product Title</label>
                        <input class="product-add-input" type="text" name="title" placeholder="Product Title" required>
                    </div>

                    <div class="product-add-field">
                        <label class="product-add-label">Description</label>
                        <textarea class="product-add-textarea" name="discription" placeholder="Product Description"></textarea>
                    </div>

                    <div class="product-add-field">
                        <label class="product-add-label">Category</label>
                        <div class="product-add-checkbox-group">
                            <div class="product-add-checkbox-item">
                                <input type="checkbox" name="cat" value="Jewellery" id="cat-jewellery">
                                <label class="product-add-checkbox-label" for="cat-jewellery">
                                    💍 Jewellery
                                </label>
                            </div>
                            <div class="product-add-checkbox-item">
                                <input type="checkbox" name="cat" value="Cosmetics" id="cat-cosmetics">
                                <label class="product-add-checkbox-label" for="cat-cosmetics">
                                    💄 Cosmetics
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="product-add-field">
                        <label class="product-add-label">Featured Product</label>

                        <div class="product-add-checkbox-item">

                            <input type="checkbox" name="featured" value="1" id="featured-product">

                            <label class="product-add-checkbox-label" for="featured-product">
                                ⭐ Add to Featured Products
                            </label>

                        </div>
                    </div>

                    <div class="product-add-field">
                        <label class="product-add-label">Price</label>
                        <input class="product-add-input" type="number" name="price" placeholder="Price">
                    </div>

                    <!-- IMAGE SECTION -->
                    <div class="product-add-field">
                        <label class="product-add-label">Product Image</label>
                        <div class="product-add-image-section">

                            <!-- Upload Zone -->
                            <div class="product-add-upload-zone">
                                <input type="file" name="image" accept="image/*">
                                <div class="product-add-upload-title">Click to upload image</div>
                                <div class="product-add-upload-hint">PNG, JPG, WEBP supported</div>
                            </div>

                            <!-- OR Divider -->
                            <div class="product-add-or-divider">or paste image URL</div>

                            <!-- URL Input -->
                            <div class="product-add-url-wrap">
                                <span class="product-add-url-prefix">🔗</span>
                                <input class="product-add-url-input" type="text" name="image_url" placeholder="https://example.com/image.jpg">
                            </div>

                        </div>
                    </div>

                    <button class="product-add-btn" name="upload">Add Product</button>

                </form>
            </div>

        </div>
    </div>

</body>

</html>