<!DOCTYPE html>
<html>

<head>
    <title>Shoe Inventory</title>
    <link rel="stylesheet" href="home.css">
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


   <section class="hero">
    <div class="hero-text">
        <h4>ART HAVEN</h4>
        <h2>MAKE EVERY<br><span>CANVAS</span><br>A MASTERPIECE.</h2>
        <p>Your creativity starts here. Find tools that inspire your next artwork.</p>

        <a href="index.php" class="explore-btn">Explore now</a>
    </div>
</section>


</body>

</html>