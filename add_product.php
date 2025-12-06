<?php include "database.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
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

        /* Container */
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: rgba(255,255,255,0.02);
            padding: 28px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
        }

        .form-title {
            text-align: center;
            margin: 0 0 24px 0;
            font-size: 28px;
            color: #fff;
        }

        label {
            font-weight: 700;
            color: #ffd7bf;
            margin-bottom: 8px;
            display: block;
            margin-top: 12px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
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

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus,
        select:focus {
            outline: none;
            border-color: #ff7a45;
            background: rgba(255,255,255,0.02);
        }

        select option {
            background: #0D0A0B;
            color: #fff;
        }

        button[type="submit"] {
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

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(224,72,15,0.3);
        }

        /* Responsive */
        @media (max-width: 720px) {
            header { padding: 14px 18px; }
            .container { padding: 20px; margin: 20px auto; }
            .form-title { font-size: 22px; }
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
        <form method="POST" enctype="multipart/form-data">
            <h2 class="form-title">Add Product</h2>

            <label>Product Name:</label>
            <input type="text" name="ProductName" required>

            <label>Brand:</label>
            <input type="text" name="Brand">

            <label>Price:</label>
            <input type="number" step="0.01" name="Price" required>

            <label>Stock:</label>
            <input type="number" name="Stock" required>

            <label>Category:</label>
            <select name="CategoryID" required>
                <?php
                $cat = $conn->query("SELECT * FROM categories");
                while ($c = $cat->fetch_assoc()) {
                    echo "<option value='{$c['CategoryID']}'>{$c['CategoryName']}</option>";
                }
                ?>
            </select>

            <label>Product Image:</label>
            <input type="file" name="image" required>

            <button type="submit" name="submit">Add Product</button>
        </form>
    </div>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['ProductName'];
    $brand = $_POST['Brand'];
    $price = $_POST['Price'];
    $stock = $_POST['Stock'];
    $category = $_POST['CategoryID'];

    // IMAGE UPLOAD
    $imageName = $_FILES["image"]["name"];
    $imageTmp = $_FILES["image"]["tmp_name"];

    if (!empty($imageName)) {

        if (!is_dir("product_images")) {
            mkdir("product_images", 0777, true);
        }

        // unique file name
        $newImageName = time() . "_" . basename($imageName);
        $imagePath = "product_images/" . $newImageName;

        if (!move_uploaded_file($imageTmp, $imagePath)) {
            echo "<script>alert('Image upload failed!');</script>";
        }

    } else {
        $imagePath = "";
    }

    // INSERT PRODUCT
    $sql = "INSERT INTO products (ProductName, Brand, Price, Stock, CategoryID, ImagePath)
            VALUES ('$name', '$brand', '$price', '$stock', '$category', '$imagePath')";

    if ($conn->query($sql)) {
        echo "<script>alert('Product Added!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

</body>
</html>