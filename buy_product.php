<?php
include 'database.php';

// Demo customer ID (replace with session in real app)
$customerID = 1;

if (!isset($_GET['id'])) {
    die("No product selected.");
}

$productID = $_GET['id'];

// Get product info
$product = $conn->query("SELECT * FROM products WHERE ProductID = $productID")->fetch_assoc();
if (!$product) die("Product not found.");

// Handle form submission
if (isset($_POST['place_order'])) {
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) $quantity = 1;

    if ($quantity > $product['Stock']) {
        $error = "Not enough stock. Available: {$product['Stock']}";
    } else {
        // Reduce stock
        $conn->query("UPDATE products SET Stock = Stock - $quantity WHERE ProductID = $productID");

        // Create order (if none today)
        $orderCheck = $conn->query("
            SELECT OrderID FROM orders 
            WHERE CustomerID = $customerID AND DATE(OrderDate) = CURDATE()
            LIMIT 1
        ");
        if ($orderCheck->num_rows > 0) {
            $orderID = $orderCheck->fetch_assoc()['OrderID'];
        } else {
            $conn->query("INSERT INTO orders (CustomerID, OrderDate) VALUES ($customerID, NOW())");
            $orderID = $conn->insert_id;
        }

        // Insert into order_details
        $conn->query("INSERT INTO order_details (OrderID, ProductID, Quantity, Price) 
                      VALUES ($orderID, $productID, $quantity, {$product['Price']})");

        // Redirect to orders
        header("Location: view_order.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Buy Product: <?php echo $product['ProductName']; ?></h1>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <p>Available Stock: <?php echo $product['Stock']; ?></p>
        <label>Quantity:</label>
        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['Stock']; ?>" required>
        <br><br>
        <button type="submit" name="place_order" class="btn-main">Place Order</button>
    </form>
</div>
</body>
</html>
