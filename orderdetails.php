<?php
include 'database.php';

$order_id = $_GET['id'] ?? 0;

$order = $conn->query("
    SELECT o.*, c.FullName 
    FROM orders o 
    LEFT JOIN customers c ON o.CustomerID = c.CustomerID 
    WHERE o.OrderID = '$order_id'
")->fetch_assoc();

$items = $conn->query("
    SELECT oi.*, p.ProductName 
    FROM order_items oi 
    LEFT JOIN products p ON oi.ProductID = p.ProductID 
    WHERE oi.OrderID = '$order_id'
");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="all.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #0D0A0B;
            color: #fff;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 48px;
            background: linear-gradient(90deg, #3b0711, #6a0e25);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.45);
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.6px;
        }

        .nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 28px;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: color .18s ease;
            opacity: .95;
        }

        .nav a.active {
            color: #ff7a45;
        }

        .nav a:hover {
            color: #ffd6c2;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.02);
            padding: 28px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
        }

        h1 {
            text-align: center;
            margin: 0 0 24px 0;
            font-size: 28px;
            color: #fff;
        }

        p {
            font-size: 16px;
            color: #e6e6e6;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.05);
        }

        p strong {
            color: #ffd7bf;
            font-weight: 700;
            display: inline-block;
            min-width: 90px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 15px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background: rgba(255, 255, 255, 0.05);
            color: #ff7a45;
            font-weight: 700;
            text-transform: uppercase;
        }

        table tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.01);
        }
        
        /* --- CSS FIX APPLIED HERE --- */
        table tfoot th {
            background: linear-gradient(90deg, #4a0a16, #6a0e25); /* Corrected gradient syntax */
            color: #fff;
            font-size: 17px;
            border-bottom: none;
        }
        /* --- END FIX --- */

        table tfoot th:last-child {
            color: #ffd6c2;
        }

        @media (max-width: 720px) {
            header {
                padding: 14px 18px;
            }

            .container {
                padding: 20px;
                margin: 20px auto;
                max-width: 90%;
            }

            h1 {
                font-size: 22px;
            }

            th,
            td {
                padding: 10px;
                font-size: 13px;
            }

            .nav {
                gap: 18px;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">ArtHaven</div>
        <ul class="nav">
            <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>">Home</a></li>
            <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Products</a>
            </li>
            <li><a href="manage_category.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'manage_category.php' ? 'active' : '' ?>">Categories</a></li>
            <li><a href="manage_customer.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'manage_customer.php' ? 'active' : '' ?>">Customers</a></li>
            <li><a href="view_order.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'view_order.php' ? 'active' : '' ?>">Orders</a></li>
        </ul>
    </header>

    <div class="container">
        <h1>Order #<?php echo $order['OrderID']; ?> Details</h1>
        <p><strong>Customer:</strong> <?php echo $order['FullName']; ?></p>
        <p><strong>Date:</strong> <?php echo $order['OrderDate']; ?></p>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price ($)</th>
                    <th>Subtotal ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                while ($item = $items->fetch_assoc()):
                    $subtotal = $item['Total'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $item['ProductName']; ?></td>
                        <td><?php echo $item['Quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th><?php echo number_format($total, 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>