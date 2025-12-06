<?php
include 'database.php';

// Fetch customers and products
$customers = $conn->query("SELECT * FROM customers");
$products = $conn->query("SELECT * FROM products");

if (isset($_POST['submit'])) {

    $customer_id = $_POST['customer_id'];
    $date = date('Y-m-d H:i:s');

    // INSERT ORDER
    // NOTE: Using prepared statements is highly recommended for security!
    // For this fix, I'm maintaining your original query style.
    $conn->query("INSERT INTO orders (CustomerID, OrderDate) VALUES ('$customer_id', '$date')");
    $order_id = $conn->insert_id;

    // INSERT ORDER ITEMS
    foreach ($_POST['product'] as $item) {

        $product_id = $item['id'];
        // Ensure quantity is treated as an integer and defaults to 0 if not present
        $quantity = (int)($item['quantity'] ?? 0); 
        
        // --- FIX APPLIED HERE ---
        // 1. Check if the quantity is greater than 0
        if ($quantity > 0) { 
            
            $product = $conn->query("
                SELECT price, stock FROM products 
                WHERE ProductID = '$product_id'
            ")->fetch_assoc();

            // 2. Check stock, and skip if quantity exceeds stock
            if ($quantity > $product['Stock']) continue;

            $price = $product['price'];
            $total = $quantity * $price;

            // Insert into order_items
            // NOTE: Security risk with direct variable injection. Use prepared statements in production!
            $conn->query("
                INSERT INTO order_items (OrderID, ProductID, Quantity, price, Total)
                VALUES ('$order_id', '$product_id', '$quantity', '$price', '$total')
            ");

            // Update product stock
            $conn->query("
                UPDATE products SET Stock = Stock - $quantity 
                WHERE ProductID = '$product_id'
            ");
        }
        // --- END FIX ---
    }

    header("Location: view_order.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
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
            background: linear-gradient(90deg,#3b0711,#6a0e25);
            box-shadow: 0 4px 18px rgba(0,0,0,0.45);
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
            max-width: 600px;
            margin: 40px auto;
            background: rgba(255,255,255,0.02);
            padding: 28px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
        }

        h1 {
            text-align: center;
            margin: 0 0 24px 0;
            font-size: 28px;
            color: #fff;
        }

        label, h3 {
            font-weight: 700;
            color: #ffd7bf;
            display: block;
            margin-bottom: 8px;
            margin-top: 12px;
        }
        
        h3 {
             margin-top: 20px;
             margin-bottom: 12px;
        }

        select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            background: rgba(255,255,255,0.01);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        select:focus {
            outline: none;
            border-color: #ff7a45;
            background: rgba(255,255,255,0.02);
        }
        
        input[type="number"] {
            width: 70px;
            padding: 8px;
            border-radius: 6px;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            color: #fff;
            font-size: 14px;
        }

        .product-row {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.01);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            color: #e6e6e6;
            border: 1px solid rgba(255,255,255,0.03);
        }

        .product-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            min-width: 18px;
        }

        .product-row span {
            flex: 1;
            font-size: 14px;
        }

        .product-row strong {
            color: #fff;
        }

        .product-row input[type="number"]:focus {
            outline: none;
            border-color: #ff7a45;
            background: rgba(255,255,255,0.03);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg,#ff7a45,#e0480f);
            color: #fff;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: transform .12s ease, box-shadow .12s ease;
            margin-top: 12px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(224,72,15,0.3);
        }
        
        @media (max-width: 720px) {
            header { padding: 14px 18px; }
            .container { padding: 20px; margin: 20px auto; max-width: 90%; }
            h1 { font-size: 22px; }
            .nav { gap: 18px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">ArtHaven</div>
        <ul class="nav">
            <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF'])=='home.php'?'active':'' ?>">Home</a></li>
            <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF'])=='index.php'?'active':'' ?>">Products</a></li>
            <li><a href="manage_category.php" class="<?= basename($_SERVER['PHP_SELF'])=='manage_category.php'?'active':'' ?>">Categories</a></li>
            <li><a href="manage_customer.php" class="<?= basename($_SERVER['PHP_SELF'])=='manage_customer.php'?'active':'' ?>">Customers</a></li>
            <li><a href="view_order.php" class="<?= basename($_SERVER['PHP_SELF'])=='view_order.php'?'active':'' ?>">Orders</a></li>
        </ul>
    </header>

    <div class="container">
        <h1>Create Order</h1>

        <form method="post">
            <label>Customer:</label>
            <select name="customer_id" required>
                <?php while ($cust = $customers->fetch_assoc()): ?>
                    <option value="<?= $cust['CustomerID'] ?>">
                        <?= $cust['FullName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <h3>Products:</h3>

            <?php while ($prod = $products->fetch_assoc()): ?>
                <div class="product-row">
                    <input type="checkbox" name="product[<?= $prod['ProductID'] ?>][check]">
                    <span>
                        <strong><?= $prod['ProductName'] ?></strong><br>
                        Price: $<?= number_format($prod['price'], 2) ?> | Stock: <?= $prod['stock'] ?>
                    </span>
                    <input type="hidden" name="product[<?= $prod['ProductID'] ?>][id]" value="<?= $prod['ProductID'] ?>">
                    <input type="number" name="product[<?= $prod['ProductID'] ?>][quantity]" value="0" min="0">
                </div>
            <?php endwhile; ?>

            <input type="submit" name="submit" value="Create Order">
        </form>
    </div>

</body>
</html>