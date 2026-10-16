<?php
include "connect.php";

// function of add to cart (as you want)
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if (isset($_POST['cart'])) {

    $product_id = $_POST['product_id'];
    $quantity   = $_POST['qty'];   // make sure form me qty field ho
    $ip_address = get_client_ip(); // yahin function call

    // Product fetch
    $product_query = mysqli_query($connect, "SELECT * FROM products WHERE product_id='$product_id'");
    $product = mysqli_fetch_assoc($product_query);

    $product_name  = $product['product_name'];
    $product_image = $product['product_image'];
    $product_price = $product['product_price'];

    // Insert into cart
    // CHECK product already cart me hai ya nahi
    $check = mysqli_query($connect, "
SELECT * FROM add_to_cart
WHERE product_id='$product_id'
AND ip_address='$ip_address'
");

    if (mysqli_num_rows($check) > 0) {

        echo "<script>
    alert('Product already added in cart!');
    window.location.href='$redirect';
    </script>";
    } else {

        // INSERT product
        mysqli_query($connect, "
    INSERT INTO add_to_cart 
    (ip_address, product_id, product_name, product_image, product_quantity, product_price)
    VALUES 
    ('$ip_address', '$product_id', '$product_name', '$product_image', '$quantity', '$product_price')
    ");

        echo "<script>
    alert('Product successfully added to cart!');
    window.location.href='$redirect';
    </script>";
    }

    // echo "<script>
    //     alert('Product added in a cart!');
    //     window.location.href='index.php';
    // </script>";

    $redirect = $_POST['redirect_url'];
    header("Location: $redirect");
    exit;
}
