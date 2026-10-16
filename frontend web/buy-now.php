    <?php
    session_start();

    include "connect.php";

    if (!isset($_SESSION['user'])) {
        header("Location: user.php");
        exit();
    }

    include "nav.php"; 

    function get_client_ip()
    {
        return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }

    $ip = get_client_ip();


    // CART FETCH (for summary)
    $cart_items = mysqli_query($connect, "SELECT * FROM add_to_cart WHERE ip_address='$ip'");

    $grand_total = 0;



    if (isset($_POST['confirm_order'])) {

        $name    = $_POST['user_name'];
        $email   = $_POST['user_email'];
        $phone   = $_POST['user_phone'];
        $address = $_POST['user_address'];
        $street  = $_POST['street_address'];
        $city    = $_POST['city'];
        $state   = $_POST['state'];
        $zip     = $_POST['zip_code'];
        $country = $_POST['select_country'];



        // CALCULATE TOTAL
        $cart = mysqli_query($connect, "SELECT * FROM add_to_cart WHERE ip_address='$ip'");

        $total = 0;

        while ($item = mysqli_fetch_assoc($cart)) {

            $total += $item['product_price'] * $item['product_quantity'];
        }



        // INSERT ORDER
        mysqli_query($connect, "INSERT INTO orders
    (user_name,user_email,user_phone,user_address,city,state,zip_code,select_country,total_amount)
    VALUES
    ('$name','$email','$phone','$address','$city','$state','$zip','$country','$total')");



        $order_id = mysqli_insert_id($connect);



        // INSERT ORDER ITEMS
        $cart2 = mysqli_query($connect, "SELECT * FROM add_to_cart WHERE ip_address='$ip'");

        while ($item = mysqli_fetch_assoc($cart2)) {

            mysqli_query($connect, "INSERT INTO order_items
        (order_id,product_id,product_name,product_image,product_price,product_quantity)
        VALUES
        ('$order_id',
        '" . $item['product_id'] . "',
        '" . $item['product_name'] . "',
        '" . $item['product_image'] . "',
        '" . $item['product_price'] . "',
        '" . $item['product_quantity'] . "')");
        }



        // CLEAR CART
        mysqli_query($connect, "DELETE FROM add_to_cart WHERE ip_address='$ip'");



        echo "<script>
    alert('Order Placed Successfully');
    window.location='index.php';
    </script>";
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout - Jenny Store</title>
        <?php include "links.php"; ?>
        <style>
            :root {
                --primary: #1a1a1a;
                --accent: #d4a574;
                --accent-light: rgba(212, 165, 116, 0.1);
                --white: #ffffff;
                --bg: #f8f6f2;
                --text: #2c2c2c;
                --text-light: #888;
                --border: #ede8e0;
                --shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
                --font-display: 'Cormorant Garamond', serif;
                --font-body: 'Lato', sans-serif;
                --transition: all 0.3s ease;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: var(--font-body);
                background: var(--bg);
                color: var(--text);
                min-height: 100vh;
            }

            /* ======= PAGE WRAPPER ======= */
            .checkout-page {
                max-width: 1400px;
                margin: 0 auto;
                padding: 3rem 2rem 5rem;
            }

            .checkout-heading {
                font-family: var(--font-display);
                font-size: 2.6rem;
                font-weight: 700;
                color: var(--primary);
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 2rem;
                width: fit-content;
                position: relative;
                padding-bottom: 0.7rem;
            }

            .checkout-heading::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 50%;
                height: 3px;
                background: var(--accent);
                border-radius: 2px;
            }

            /* ======= LAYOUT ======= */
            .checkout-layout {
                display: grid;
                grid-template-columns: 1.6fr 420px;
                gap: 2rem;
                align-items: start;
            }

            /* ======= SHARED CARD ======= */
            .checkout-card {
                background: var(--white);
                border-radius: 16px;
                box-shadow: var(--shadow);
                overflow: hidden;
            }

            .checkout-card-header {
                background: var(--primary);
                padding: 1rem 1.8rem;
            }

            .checkout-card-header h2,
            .checkout-card-header h3 {
                font-family: var(--font-display);
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--white);
                letter-spacing: 0.5px;
            }

            .checkout-card-body {
                padding: 1.8rem;
            }

            /* ======= FORM ======= */
            .checkout-form {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .checkout-field-label {
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--primary);
                margin-bottom: 0.35rem;
                display: block;
            }

            .checkout-field {
                display: flex;
                flex-direction: column;
            }

            .checkout-input {
                width: 100%;
                padding: 0.85rem 1.1rem;
                border: 1.5px solid var(--border);
                border-radius: 10px;
                font-size: 0.95rem;
                font-family: var(--font-body);
                color: var(--text);
                background: var(--bg);
                outline: none;
                transition: var(--transition);
            }

            .checkout-input:focus {
                border-color: var(--accent);
                background: var(--white);
                box-shadow: 0 0 0 3px var(--accent-light);
            }

            .checkout-input::placeholder {
                color: #bbb;
                font-weight: 300;
            }

            /* Two column row */
            .checkout-row-2 {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            /* Submit */
            .checkout-submit-btn {
                width: 100%;
                padding: 1rem;
                background: var(--primary);
                color: var(--white);
                border: none;
                border-radius: 10px;
                font-size: 0.88rem;
                font-weight: 700;
                font-family: var(--font-body);
                text-transform: uppercase;
                letter-spacing: 1.2px;
                cursor: pointer;
                transition: var(--transition);
                margin-top: 0.5rem;
            }

            .checkout-submit-btn:hover {
                background: var(--accent);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(212, 165, 116, 0.3);
            }

            /* ======= ORDER SUMMARY ======= */
            .order-summary-card {
                position: sticky;
                top: 2rem;
            }

            .cart-item {
                display: flex;
                gap: 1rem;
                align-items: center;
                padding: 1rem 0;
                border-bottom: 1px solid var(--border);
            }

            .cart-item:last-of-type {
                border-bottom: none;
            }

            .cart-item img {
                width: 62px;
                height: 62px;
                object-fit: cover;
                border-radius: 10px;
                border: 1.5px solid var(--border);
                flex-shrink: 0;
            }

            .cart-item-info {
                flex: 1;
            }

            .cart-item-name {
                font-size: 0.92rem;
                font-weight: 700;
                color: var(--primary);
                margin-bottom: 0.25rem;
            }

            .cart-item-meta {
                font-size: 0.82rem;
                color: var(--text-light);
                line-height: 1.6;
            }

            .cart-item-total {
                font-size: 0.95rem;
                font-weight: 700;
                color: var(--primary);
                white-space: nowrap;
            }

            /* Grand total */
            .order-grand {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.2rem 0 0;
                margin-top: 0.8rem;
                border-top: 2px solid var(--primary);
            }

            .order-grand-label {
                font-family: var(--font-display);
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--primary);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .order-grand-value {
                font-family: var(--font-display);
                font-size: 1.7rem;
                font-weight: 700;
                color: var(--accent);
            }

            /* ======= RESPONSIVE ======= */
            @media (max-width: 900px) {
                .checkout-layout {
                    grid-template-columns: 1fr;
                }

                .order-summary-card {
                    position: static;
                }
            }

            @media (max-width: 600px) {
                .checkout-page {
                    padding: 2rem 1rem 4rem;
                }

                .checkout-heading {
                    font-size: 2rem;
                }

                .checkout-row-2 {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>

    <body>

        <div class="checkout-page">

            <h1 class="checkout-heading">Checkout</h1>

            <div class="checkout-layout">

                <!-- LEFT: FORM -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <h2>Shipping Information</h2>
                    </div>
                    <div class="checkout-card-body">
                        <form method="POST" class="checkout-form">

                            <div class="checkout-field">
                                <label class="checkout-field-label">Full Name</label>
                                <input class="checkout-input" type="text" name="user_name" placeholder="Full Name" required>
                            </div>

                            <div class="checkout-row-2">
                                <div class="checkout-field">
                                    <label class="checkout-field-label">Email</label>
                                    <input class="checkout-input" type="email" name="user_email" placeholder="Email" required>
                                </div>
                                <div class="checkout-field">
                                    <label class="checkout-field-label">Phone</label>
                                    <input class="checkout-input" type="text" name="user_phone" placeholder="Phone" required>
                                </div>
                            </div>

                            <div class="checkout-field">
                                <label class="checkout-field-label">House / Flat No</label>
                                <input class="checkout-input" type="text" name="user_address" placeholder="House / Flat No" required>
                            </div>

                            <div class="checkout-field">
                                <label class="checkout-field-label">Street Address</label>
                                <input class="checkout-input" type="text" name="street_address" placeholder="Street Address" required>
                            </div>

                            <div class="checkout-row-2">
                                <div class="checkout-field">
                                    <label class="checkout-field-label">City</label>
                                    <input class="checkout-input" type="text" name="city" placeholder="City" required>
                                </div>
                                <div class="checkout-field">
                                    <label class="checkout-field-label">State</label>
                                    <input class="checkout-input" type="text" name="state" placeholder="State" required>
                                </div>
                            </div>

                            <div class="checkout-row-2">
                                <div class="checkout-field">
                                    <label class="checkout-field-label">Zip Code</label>
                                    <input class="checkout-input" type="text" name="zip_code" placeholder="Zip Code" required>
                                </div>
                                <div class="checkout-field">
                                    <label class="checkout-field-label">Country</label>
                                    <input class="checkout-input" type="text" name="select_country" placeholder="Country" required>
                                </div>
                            </div>

                            <button type="submit" name="confirm_order" class="checkout-submit-btn">Confirm Order</button>

                        </form>
                    </div>
                </div>

                <!-- RIGHT: ORDER SUMMARY -->
                <div class="checkout-card order-summary-card">
                    <div class="checkout-card-header">
                        <h3>Your Order</h3>
                    </div>
                    <div class="checkout-card-body">

                        <?php while ($item = mysqli_fetch_assoc($cart_items)):
                            $total = $item['product_price'] * $item['product_quantity'];
                            $grand_total += $total;
                        ?>
                            <div class="cart-item">
                                <img src="<?= $item['product_image'] ?>" alt="<?= $item['product_name'] ?>">
                                <div class="cart-item-info">
                                    <div class="cart-item-name"><?= $item['product_name'] ?></div>
                                    <div class="cart-item-meta">
                                        Rs. <?= number_format($item['product_price']) ?> &nbsp;×&nbsp; <?= $item['product_quantity'] ?>
                                    </div>
                                </div>
                                <div class="cart-item-total">Rs. <?= number_format($total) ?></div>
                            </div>
                        <?php endwhile; ?>

                        <div class="order-grand">
                            <span class="order-grand-label">Grand Total</span>
                            <span class="order-grand-value">Rs. <?= number_format($grand_total) ?></span>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <?php include "footer.php"; ?>

    </body>

    </html>