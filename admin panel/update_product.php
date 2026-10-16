
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
   PRODUCT ID GET
========================= */

$id = $_GET['id'] ?? '';

if(!$id){
header("Location: products.php");
exit;
}

/* =========================
   PRODUCT FETCH
========================= */

$query = "SELECT * FROM products WHERE product_id='$id'";
$result = mysqli_query($connect,$query);

$product = mysqli_fetch_assoc($result);

/* =========================
   UPDATE PRODUCT
========================= */

if(isset($_POST['update'])){

$title = $_POST['title'];
$desc  = $_POST['description'];
$cat   = $_POST['category'];
$price = $_POST['price'];

$image = $_POST['image']; // default old image

// agar new image upload hui hai
if(!empty($_FILES['image_file']['name'])){

    $image_name = $_FILES['image_file']['name'];
    $tmp = $_FILES['image_file']['tmp_name'];

    $image = "../assets/" . $image_name;

    move_uploaded_file($tmp,$image);
}

$update = "
UPDATE products SET
product_name='$title',
product_description='$desc',
product_image='$image',
product_cat='$cat',
product_price='$price'
WHERE product_id='$id'
";

mysqli_query($connect,$update);

header("Location: products.php");
exit;

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Update Product</title>

<?php include "links.php"; ?>

<style>

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Lato', 'Segoe UI', sans-serif;
        background: #f8f8f8;
        min-height: 100vh;
        padding: 2.5rem 1.5rem;
    }

    /* ── Back link ── */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #888;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: color 0.2s;
    }

    .back-link:hover { color: #d4a574; }
    .back-link::before { content: '←'; font-size: 1.1rem; }

    .update-box {
        width: 100%;
        max-width: 780px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    /* ── Header strip ── */
    .update-box-header {
        background: #1a1a1a;
        padding: 1.8rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .update-box h2 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.5px;
    }

    .update-box-header span {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: rgba(255,255,255,0.4);
        background: rgba(255,255,255,0.07);
        padding: 0.35rem 0.9rem;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.1);
    }

    /* ── Form body ── */
    .update-box-body {
        padding: 2.5rem;
    }

    /* 2-column grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.4rem;
    }

    .form-grid .form-group-full {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .form-group label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #888;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.85rem 1.1rem;
        border: 1.5px solid #e8e8e8;
        border-radius: 9px;
        font-family: inherit;
        font-size: 0.95rem;
        color: #1a1a1a;
        background: #fafafa;
        outline: none;
        transition: border-color 0.25s, box-shadow 0.25s, background 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #d4a574;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(212,165,116,0.12);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
        line-height: 1.7;
    }

    /* file input */
    .form-group input[type="file"] {
        padding: 0.65rem 1rem;
        cursor: pointer;
        color: #666;
    }

    .form-group input[type="file"]::-webkit-file-upload-button {
        background: #1a1a1a;
        color: #fff;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        margin-right: 0.8rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: background 0.2s;
    }

    .form-group input[type="file"]::-webkit-file-upload-button:hover {
        background: #d4a574;
    }

    /* ── Submit ── */
    .btn-update {
        display: block;
        width: 100%;
        margin-top: 2rem;
        padding: 1rem;
        background: #1a1a1a;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.25s, transform 0.2s, box-shadow 0.2s;
    }

    .btn-update:hover {
        background: #d4a574;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212,165,116,0.35);
    }

    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .update-box-body { padding: 1.5rem; }
        .update-box-header { padding: 1.4rem 1.5rem; }
    }

</style>

</head>

<body>

<a href="products.php" class="back-link">Back to Products</a>

<div class="update-box">

    <div class="update-box-header">
        <h2>Update Product</h2>
        <span>ID: #<?= $id ?></span>
    </div>

    <div class="update-box-body">
        <form method="POST" enctype="multipart/form-data">

        <div class="form-grid">

            <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="title" value="<?= $product['product_name']; ?>">
            </div>

            <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" value="<?= $product['product_cat']; ?>">
            </div>

            <div class="form-group form-group-full">
            <label>Description</label>
            <textarea name="description"><?= $product['product_description']; ?></textarea>
            </div>

            <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="image" value="<?= $product['product_image']; ?>">
            </div>

            <div class="form-group">
            <label>Choose Image File</label>
            <input type="file" name="image_file" accept="image/*">
            </div>

            <div class="form-group">
            <label>Price (Rs.)</label>
            <input type="number" name="price" value="<?= $product['product_price']; ?>">
            </div>

        </div>

        <button type="submit" name="update" class="btn-update">
        Update Product
        </button>

        </form>
    </div>

</div>

</body>
</html>