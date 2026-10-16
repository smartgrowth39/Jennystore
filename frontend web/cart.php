    <?php include "nav.php"; ?>

    <?php
    include "connect.php";

    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    $ip = get_client_ip();


    // UPDATE CART
    if (isset($_POST['update_cart'])) {

        foreach ($_POST['qty'] as $cart_id => $qty) {

            mysqli_query($connect, "
        UPDATE add_to_cart
        SET product_quantity='$qty'
        WHERE cart_id='$cart_id'
        ");
        }

        echo "<script>window.location='cart.php';</script>";
    }



    // DELETE ITEM
    if (isset($_POST['delete_item'])) {

        $cart_id = $_POST['cart_id'];

        mysqli_query($connect, "
    DELETE FROM add_to_cart
    WHERE cart_id='$cart_id'
    ");

        echo "<script>window.location='cart.php';</script>";
    }



    // FETCH CART
    $result = mysqli_query($connect, "
SELECT * FROM add_to_cart
WHERE ip_address='$ip'
");

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Cart - Jenny Store</title>
        <?php include "links.php"; ?>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Lato:wght@300;400;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #1a1a1a;
                --accent: #d4a574;
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

            .cart-page {
                max-width: 1100px;
                margin: 0 auto;
                padding: 3rem 2rem 5rem;
            }

            /* Heading */
            .cart-heading {
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

            .cart-heading::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 50%;
                height: 3px;
                background: var(--accent);
                border-radius: 2px;
            }

            /* Table */
            .cart-table-wrap {
                background: var(--white);
                border-radius: 16px;
                box-shadow: var(--shadow);
                overflow: hidden;
            }

            .cart-table {
                width: 100%;
                border-collapse: collapse;
            }

            .cart-table thead tr {
                background: var(--primary);
            }

            .cart-table thead th {
                padding: 1rem 1.2rem;
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: var(--white);
                text-align: left;
            }

            .cart-table thead th:nth-child(3),
            .cart-table thead th:nth-child(4),
            .cart-table thead th:nth-child(5),
            .cart-table thead th:nth-child(6) {
                text-align: center;
            }

            .cart-table tbody tr {
                border-bottom: 1px solid var(--border);
                transition: var(--transition);
            }

            .cart-table tbody tr:last-child {
                border-bottom: none;
            }

            .cart-table tbody tr:hover {
                background: #fdf9f5;
            }

            .cart-table td {
                padding: 1.1rem 1.2rem;
                vertical-align: middle;
            }

            .cart-table td:nth-child(3),
            .cart-table td:nth-child(4),
            .cart-table td:nth-child(5),
            .cart-table td:nth-child(6) {
                text-align: center;
            }

            /* Product image */
            .cart-img {
                width: 68px;
                height: 68px;
                object-fit: cover;
                border-radius: 10px;
                border: 1.5px solid var(--border);
                display: block;
            }

            /* Product name */
            .cart-name {
                font-size: 0.95rem;
                font-weight: 600;
                color: var(--primary);
            }

            /* Qty input */
            .cart-qty-input {
                width: 68px;
                padding: 0.5rem 0.6rem;
                border: 1.5px solid var(--border);
                border-radius: 8px;
                font-size: 0.9rem;
                font-family: var(--font-body);
                color: var(--primary);
                background: var(--bg);
                text-align: center;
                outline: none;
                transition: var(--transition);
            }

            .cart-qty-input:focus {
                border-color: var(--accent);
                background: var(--white);
                box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.12);
            }

            /* Price / Total text */
            .cart-price {
                font-size: 0.95rem;
                color: var(--text);
            }

            .cart-total {
                font-size: 0.95rem;
                font-weight: 700;
                color: var(--primary);
            }

            /* Delete button */
            .cart-delete-btn {
                background: none;
                border: 1.5px solid var(--border);
                border-radius: 8px;
                padding: 0.45rem 0.55rem;
                cursor: pointer;
                transition: var(--transition);
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .cart-delete-btn svg {
                width: 15px;
                height: 15px;
                stroke: #bbb;
                fill: none;
                stroke-width: 2;
                stroke-linecap: round;
                stroke-linejoin: round;
                transition: var(--transition);
            }

            .cart-delete-btn:hover {
                border-color: #e05555;
                background: rgba(224, 85, 85, 0.07);
            }

            .cart-delete-btn:hover svg {
                stroke: #e05555;
            }

            /* Grand total row */
            .cart-grand-row td {
                padding: 1.1rem 1.2rem;
                background: #fafaf8;
                border-top: 2px solid var(--border);
            }

            .cart-grand-label {
                font-family: var(--font-display);
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--primary);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                text-align: right;
            }

            .cart-grand-value {
                font-family: var(--font-display);
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--accent);
                text-align: center;
            }

            /* Bottom action row */
            .cart-action-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.2rem 1.5rem;
                background: #fafaf8;
                border-top: 1px solid var(--border);
                gap: 1rem;
                flex-wrap: wrap;
            }

            .cart-links {
                display: flex;
                gap: 1rem;
                align-items: center;
                flex-wrap: wrap;
            }

            .cart-link {
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--text-light);
                text-decoration: none;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: var(--transition);
            }

            .cart-link:hover {
                color: var(--accent);
            }

            .cart-btn-group {
                display: flex;
                gap: 0.8rem;
            }

            .cart-update-btn {
                padding: 0.7rem 1.5rem;
                background: transparent;
                color: var(--primary);
                border: 1.5px solid var(--primary);
                border-radius: 8px;
                font-size: 0.78rem;
                font-weight: 700;
                font-family: var(--font-body);
                text-transform: uppercase;
                letter-spacing: 1px;
                cursor: pointer;
                transition: var(--transition);
            }

            .cart-update-btn:hover {
                background: var(--primary);
                color: var(--white);
            }

            .cart-checkout-btn {
                padding: 0.7rem 1.8rem;
                background: var(--primary);
                color: var(--white);
                border: 1.5px solid var(--primary);
                border-radius: 8px;
                font-size: 0.78rem;
                font-weight: 700;
                font-family: var(--font-body);
                text-transform: uppercase;
                letter-spacing: 1px;
                text-decoration: none;
                transition: var(--transition);
            }

            .cart-checkout-btn:hover {
                background: var(--accent);
                border-color: var(--accent);
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(212, 165, 116, 0.25);
            }

            @media (max-width: 640px) {
                .cart-page {
                    padding: 2rem 1rem 4rem;
                }

                .cart-heading {
                    font-size: 2rem;
                }

                .cart-table thead {
                    display: none;
                }

                .cart-table tbody tr {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem;
                    padding: 1rem;
                }

                .cart-table td {
                    display: block;
                    padding: 0;
                    border: none;
                    text-align: left !important;
                }

                .cart-action-row {
                    flex-direction: column;
                    align-items: stretch;
                }

                .cart-btn-group {
                    justify-content: stretch;
                }

                .cart-update-btn,
                .cart-checkout-btn {
                    flex: 1;
                    text-align: center;
                }
            }
        </style>
    </head>

    <body>

        <div class="cart-page">

            <h1 class="cart-heading">Your Cart</h1>

            <form method="POST">

                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $grand = 0;
                            while ($row = mysqli_fetch_assoc($result)):
                                $price = $row['product_price'];
                                $qty   = $row['product_quantity'];
                                $total = (int)$price * (int)$qty;
                                $grand += $total;
                            ?>

                                <tr>
                                    <td>
                                        <img class="cart-img" src="<?= $row['product_image']; ?>" alt="<?= $row['product_name']; ?>">
                                    </td>
                                    <td>
                                        <span class="cart-name"><?= $row['product_name']; ?></span>
                                    </td>
                                    <td>
                                        <input class="cart-qty-input" type="number"
                                            name="qty[<?= $row['cart_id']; ?>]"
                                            value="<?= $qty; ?>"
                                            min="1">
                                    </td>
                                    <td>
                                        <span class="cart-price">Rs. <?= number_format($price); ?></span>
                                    </td>
                                    <td>
                                        <span class="cart-total">Rs. <?= number_format($total); ?></span>
                                    </td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
                                            <button type="submit" name="delete_item" class="cart-delete-btn">
                                                <svg viewBox="0 0 24 24">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                    <path d="M10 11v6M14 11v6" />
                                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                            <!-- Grand Total Row -->
                            <tr class="cart-grand-row">
                                <td colspan="4" class="cart-grand-label">Grand Total</td>
                                <td class="cart-grand-value">Rs. <?= number_format($grand); ?></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>

                    <!-- Bottom Actions -->
                    <div class="cart-action-row">
                        <div class="cart-links">
                            <a href="index.php" class="cart-link">← Continue Shopping</a>
                        </div>
                        <div class="cart-btn-group">
                            <button type="submit" name="update_cart" class="cart-update-btn">Update Cart</button>
                            <a href="buy-now.php" class="cart-checkout-btn">Checkout</a>
                        </div>
                    </div>

                </div>

            </form>

        </div>

        <?php include "footer.php"; ?>

    </body>

    </html>