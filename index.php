<?php include "database.php"; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Shoe Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="logo">ArtHaven</div>
        <ul class="nav">
            <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>">Home</a>
            </li>
            <li><a href="index.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Products</a></li>
            <li><a href="manage_category.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'manage_category.php' ? 'active' : '' ?>">Categories</a>
            </li>
            <li><a href="manage_customer.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'manage_customer.php' ? 'active' : '' ?>">Customers</a>
            </li>
            <li><a href="view_order.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'create_order.php' ? 'active' : '' ?>">Orders</a></li>
        </ul>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h4>ART HAVEN</h4>
            <h1>SHOP THE BEST<br><span>ART MATERIALS</span></h1>
            <p>Hand-picked supplies for artists of every level. Browse products below and find what sparks your next
                masterpiece.</p>

        </div>
    </section>

    <section id="products" class="product-wrapper">
        <div class="products-header">
            <h2>Product List</h2>
            <a class="add-btn" href="add_product.php">Add Product</a>
        </div>

        <div class="product-container">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $image = (!empty($row['ImagePath'])) ? htmlspecialchars($row['ImagePath']) : 'img/canvas.jfif';
                    $brand = htmlspecialchars($row['Brand']);
                    $name = htmlspecialchars($row['ProductName']);
                    $price = htmlspecialchars($row['price']);
                    $stock = htmlspecialchars($row['stock']);
                    $id = (int) $row['ProductID'];
            

                    echo "
    <div class='product-card'>
        <p class='brand'>Brand: {$brand}</p>
        <h3 class='product-name'>{$name}</h3>
        <div class='product-image'>
            <img src='{$image}' alt='product image'>
        </div>
        <div class='card-details'>
            <p>Price: {$price}</p>
            <p>Stock: {$stock}</p>
        </div>
        <div class='card-buttons'>
            <a class='buy-btn' href='create_order.php?productID={$id}'>Buy</a>
            <a class='edit-btn' href='edit_product.php?id={$id}'>Edit</a>
            <a class='delete-btn' href='delete_product.php?id={$id}'>Delete</a>
        </div>
    </div>
    ";
                }
            } else {
                echo "<p style='color:#e6e6e6'>No products found.</p>";
            }
            ?>
        </div>
    </section>

</body>

</html>