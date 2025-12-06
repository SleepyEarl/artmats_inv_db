<?php
include 'database.php';

// Get customer ID from URL
$id = $_GET['id'];

// Fetch customer info from database
$customer = $conn->query("SELECT * FROM customers WHERE CustomerID='$id'")->fetch_assoc();

// Handle form submission
if(isset($_POST['submit'])){
    $name = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];

    $stmt = $conn->prepare("UPDATE customers SET FullName=?, Email=?, Phone=? WHERE CustomerID=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_customer.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" href="all.css">
</head>
 <style>
        /* Form styles */
        .container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #111322;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.4);
        }
        h1 {
            color: #28e0b9;
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            font-weight: bold;
            color: #28e0b9;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="email"], input[type="tel"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #444;
            font-size: 14px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28e0b9;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: transparent;
            color: #28e0b9;
            border: 2px solid #28e0b9;
        }
        </style>
<body>
   <header>
    <div class="logo">JUMPSHOT</div>
    <ul class="nav">
    <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF'])=='home.php'?'active':'' ?>">Home</a></li>
    <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF'])=='index.php'?'active':'' ?>">Products</a></li>
    <li><a href="manage_category.php" class="<?= basename($_SERVER['PHP_SELF'])=='manage_category.php'?'active':'' ?>">Categories</a></li>
    <li><a href="manage_customer.php" class="<?= basename($_SERVER['PHP_SELF'])=='manage_customer.php'?'active':'' ?>">Customers</a></li>
    <li><a href="view_order.php" class="<?= basename($_SERVER['PHP_SELF'])=='create_order.php'?'active':'' ?>">Orders</a></li>
    <li><a href="create_order.php" class="<?= basename($_SERVER['PHP_SELF'])=='create_order.php'?'active':'' ?>">Create Orders</a></li>
</ul>

</header>

<div class="container">
    <h1>Edit Customer</h1>
    <form method="post">
        <label>Full Name:</label>
        <input type="text" name="FullName" value="<?php echo htmlspecialchars($customer['FullName']); ?>" required>

        <label>Email:</label>
        <input type="email" name="Email" value="<?php echo htmlspecialchars($customer['Email']); ?>" required>

        <label>Phone:</label>
        <input type="text" name="Phone" value="<?php echo htmlspecialchars($customer['Phone']); ?>" required>

        <input type="submit" name="submit" value="Update Customer" class="btn-main">
    </form>
</div>
</body>
</html>
