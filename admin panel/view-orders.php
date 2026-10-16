
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

$id = $_GET['id'];

$order = mysqli_query(
    $connect,
    "SELECT * FROM orders WHERE order_id='$id'"
);
$data = mysqli_fetch_assoc($order);

$items = mysqli_query(
    $connect,
    "SELECT * FROM order_items WHERE order_id='$id'"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #ORD-<?php echo $data['order_id']; ?> — Jenny Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a1a;
            --secondary: #f8f8f8;
            --accent: #d4a574;
            --white: #ffffff;
            --text: #2c2c2c;
            --text-light: #888888;
            --border: #e8e8e8;
            --font-d: 'Cormorant Garamond', serif;
            --font-b: 'Lato', sans-serif;
            --shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            --radius: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-b);
            background: var(--secondary);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Page wrapper ── */
        .od-wrap {
            max-width: 860px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* ── Back link ── */
        .od-back {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-light);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-decoration: none;
            margin-bottom: 1.8rem;
            transition: color 0.2s;
        }

        .od-back:hover {
            color: var(--accent);
        }

        .od-back::before {
            content: '←';
            font-size: 1rem;
        }

        /* ── Order header ── */
        .od-header {
            background: var(--primary);
            border-radius: var(--radius);
            padding: 1.6rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-bottom: 1.8rem;
        }

        .od-header h1 {
            font-family: var(--font-d);
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--white);
        }

        .od-header-meta {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.2rem;
        }

        .od-header-meta span:last-child {
            color: var(--accent);
            font-weight: 600;
        }

        /* ── Info grid ── */
        .od-info {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.8rem 2rem;
            margin-bottom: 1.8rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.4rem 2rem;
        }

        .od-info-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }

        .od-info-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary);
        }

        /* ── Products table ── */
        .od-table-wrap {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .od-table {
            width: 100%;
            border-collapse: collapse;
        }

        .od-table thead tr {
            background: var(--primary);
            color: var(--white);
        }

        .od-table thead th {
            padding: 0.9rem 1.2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            text-align: left;
        }

        .od-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
        }

        .od-table tbody tr:last-child {
            border-bottom: none;
        }

        .od-table tbody tr:hover {
            background: #fdf8f4;
        }

        .od-table tbody td {
            padding: 1rem 1.2rem;
            vertical-align: middle;
            font-size: 0.93rem;
        }

        .od-img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 7px;
            border: 1px solid var(--border);
            display: block;
        }

        .od-name {
            font-weight: 700;
            color: var(--primary);
        }

        .od-price {
            font-family: var(--font-d);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .od-qty {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.88rem;
        }

        .od-total {
            font-family: var(--font-d);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--accent);
        }

        /* grand total row */
        .od-grand td {
            background: var(--secondary);
            padding: 1.1rem 1.2rem;
        }

        .od-grand-label {
            text-align: right;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-light);
        }

        .od-grand-value {
            font-family: var(--font-d);
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--accent);
        }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .od-info {
                grid-template-columns: 1fr 1fr;
            }

            .od-header h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .od-info {
                grid-template-columns: 1fr;
            }

            .od-wrap {
                padding: 1.5rem 1rem 3rem;
            }
        }
    </style>
</head>

<body>

    <div class="od-wrap">

        <a href="javascript:history.back()" class="od-back">Back to Orders</a>

        <!-- Header -->
        <div class="od-header">
            <h1>#ORD-<?php echo $data['order_id']; ?></h1>
            <div class="od-header-meta">
                <span><?php echo $data['order_date']; ?></span>
                <span><?php echo $data['city']; ?>, <?php echo $data['select_country']; ?></span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="od-info">
            <div class="od-info-item">
                <div class="od-info-label">Full Name</div>
                <div class="od-info-value"><?php echo $data['user_name']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">Email</div>
                <div class="od-info-value"><?php echo $data['user_email']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">Phone</div>
                <div class="od-info-value"><?php echo $data['user_phone']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">Address</div>
                <div class="od-info-value"><?php echo $data['user_address']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">City</div>
                <div class="od-info-value"><?php echo $data['city']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">State</div>
                <div class="od-info-value"><?php echo $data['state']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">ZIP Code</div>
                <div class="od-info-value"><?php echo $data['zip_code']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">Country</div>
                <div class="od-info-value"><?php echo $data['select_country']; ?></div>
            </div>
            <div class="od-info-item">
                <div class="od-info-label">Order Status</div>
                <div class="od-info-value"><?php echo $data['status']; ?></div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="od-table-wrap">
            <table class="od-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand = 0;

                    while ($row = mysqli_fetch_assoc($items)) {
                        $total = $row['product_price'] * $row['product_quantity'];
                        $grand += $total;
                    ?>
                        <tr>
                            <td><img src="<?php echo $row['product_image']; ?>" class="od-img" alt="<?php echo $row['product_name']; ?>"></td>
                            <td><span class="od-name"><?php echo $row['product_name']; ?></span></td>
                            <td><span class="od-price">Rs. <?php echo $row['product_price']; ?></span></td>
                            <td><span class="od-qty"><?php echo $row['product_quantity']; ?></span></td>
                            <td><span class="od-total">Rs. <?php echo $total; ?></span></td>
                        </tr>
                    <?php } ?>

                    <tr class="od-grand">
                        <td colspan="4" class="od-grand-label">Grand Total</td>
                        <td class="od-grand-value">Rs. <?php echo $grand; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>