<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<?php
include "connect.php";

// Delete review
if (isset($_GET['delete_review'])) {

    $delete_id = $_GET['delete_review'];

    mysqli_query($connect, "DELETE FROM reviews WHERE review_id='$delete_id'");

    header("Location: reviews.php");
    exit();
}

// Delete testimonial
if (isset($_GET['delete_testimonial'])) {

    $delete_id = $_GET['delete_testimonial'];

    mysqli_query($connect, "DELETE FROM testimonials WHERE id='$delete_id'");

    header("Location: reviews.php");
    exit();
}

$query = mysqli_query($connect, "
SELECT reviews.*, products.product_name
FROM reviews
JOIN products ON reviews.product_id = products.product_id
ORDER BY review_date DESC
");

$testimonials = mysqli_query($connect, "
SELECT * FROM testimonials
ORDER BY created_at DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Jenny Store Admin</title>
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
            --color-danger: #ef4444;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;
            --transition: all 0.3s ease;
            --shadow-soft: 0 2px 20px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--color-secondary);
            color: var(--color-text);
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            transition: var(--transition);
        }

        /* ── Page Header ── */
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

        /* ── Section ── */
        .section-block {
            margin-bottom: 2.5rem;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .section-label h2 {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .section-pill {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.25rem 0.8rem;
            border-radius: 50px;
        }

        .section-pill.dark {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .section-pill.gold {
            background: var(--color-accent);
            color: var(--color-white);
        }

        /* ── Table Card ── */
        .table-card {
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            overflow: hidden;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        thead tr {
            background: var(--color-primary);
        }

        thead th {
            padding: 1rem 1.2rem;
            text-align: left;
            color: var(--color-white);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--color-border);
            transition: background 0.2s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody td {
            padding: 1rem 1.2rem;
            color: var(--color-text);
            vertical-align: middle;
        }

        .td-id {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--color-text-light);
            background: var(--color-secondary);
            border: 1px solid var(--color-border);
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            white-space: nowrap;
        }

        .td-product {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-primary);
        }

        .td-name {
            font-weight: 600;
            color: var(--color-text);
        }

        .td-email {
            color: var(--color-text-light);
            font-size: 0.85rem;
        }

        .td-stars {
            color: #f59e0b;
            font-size: 0.95rem;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .td-review {
            color: var(--color-text-light);
            font-size: 0.88rem;
            line-height: 1.6;
            max-width: 280px;
        }

        .td-date {
            font-size: 0.8rem;
            color: var(--color-text-light);
            white-space: nowrap;
        }

        .btn-delete {
            display: inline-block;
            background: transparent;
            color: var(--color-danger);
            border: 1.5px solid rgba(239, 68, 68, 0.35);
            padding: 0.38rem 0.9rem;
            border-radius: 7px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: var(--transition);
            white-space: nowrap;
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
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
            }

            .dashboard-header-title {
                font-size: 1.6rem;
            }

            thead th,
            tbody td {
                padding: 0.8rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">

        <?php include "sidebar.php"; ?>

        <main class="dashboard-main-content">

            <header class="dashboard-header">
                <h1 class="dashboard-header-title">Reviews & Testimonials</h1>
            </header>

            <!-- ═══ Product Reviews ═══ -->
            <div class="section-block">
                <div class="section-label">
                    <h2>Product Reviews</h2>
                    <span class="section-pill dark">Reviews</span>
                </div>
                <div class="table-card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><span class="td-id">#<?php echo $row['review_id']; ?></span></td>
                                        <td><span class="td-product"><?php echo $row['product_name']; ?></span></td>
                                        <td><span class="td-name"><?php echo $row['reviewer_name']; ?></span></td>
                                        <td><span class="td-email"><?php echo $row['reviewer_email']; ?></span></td>
                                        <td><span class="td-stars"><?php echo str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']); ?></span></td>
                                        <td><span class="td-review"><?php echo $row['review_text']; ?></span></td>
                                        <td><span class="td-date"><?php echo date('d M Y', strtotime($row['review_date'])); ?></span></td>
                                        <td>
                                            <a href="?delete_review=<?php echo $row['review_id']; ?>" class="btn-delete">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ═══ Customer Testimonials ═══ -->
            <div class="section-block">
                <div class="section-label">
                    <h2>Customer Testimonials</h2>
                    <span class="section-pill gold">Testimonials</span>
                </div>
                <div class="table-card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($t = mysqli_fetch_assoc($testimonials)) { ?>
                                    <tr>
                                        <td><span class="td-id">#<?php echo $t['id']; ?></span></td>
                                        <td><span class="td-name"><?php echo $t['name']; ?></span></td>
                                        <td><span class="td-stars"><?php echo str_repeat('★', $t['rating']); ?></span></td>
                                        <td><span class="td-review"><?php echo $t['review_text']; ?></span></td>
                                        <td><span class="td-date"><?php echo date('d M Y', strtotime($t['created_at'])); ?></span></td>
                                        <td>
                                            <a href="?delete_testimonial=<?php echo $t['id']; ?>" class="btn-delete">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>

</html>