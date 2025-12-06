
<?php
include 'database.php';
$id = $_GET['id'];

$category = $conn->query("SELECT * FROM categories WHERE CategoryID='$id'")->fetch_assoc();

if(isset($_POST['submit'])){
    $name = $_POST['CategoryName'];

    $stmt = $conn->prepare("UPDATE categories SET CategoryName=? WHERE CategoryID=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_category.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
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
            padding: 14px 28px;
            background: #4a0a16;
        }

        .logo {
            font-weight: 700;
            font-size: 20px;
        }

        .nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 18px;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
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

        .container h1 {
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
        }

        input[type="text"] {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            background: rgba(255,255,255,0.01);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #ff7a45;
            background: rgba(255,255,255,0.02);
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
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(224,72,15,0.3);
        }

        @media (max-width: 720px) {
            .container { padding: 20px; margin: 20px auto; }
            .container h1 { font-size: 22px; }
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
            <li><a href="view_order.php" class="<?= basename($_SERVER['PHP_SELF'])=='create_order.php'?'active':'' ?>">Orders</a></li>
        </ul>
    </header>

    <div class="container">
        <h1>Edit Category</h1>
        <form method="post">
            <label>Category Name:</label>
            <input type="text" name="CategoryName" value="<?= htmlspecialchars($category['CategoryName']) ?>" required>
            <input type="submit" name="submit" value="Update Category">
        </form>
    </div>
</body>
</html>