
<?php
include 'database.php';

if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO customers (FullName, Email, Phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $phone);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_customer.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
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

        /* Form Container */
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

        label {
            font-weight: 700;
            color: #ffd7bf;
            display: block;
            margin-bottom: 8px;
            margin-top: 12px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
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
        input[type="email"]:focus,
        input[type="tel"]:focus {
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
            margin-top: 12px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(224,72,15,0.3);
        }

        /* Responsive */
        @media (max-width: 720px) {
            header { padding: 14px 18px; }
            .container { padding: 20px; margin: 20px auto; }
            h1 { font-size: 22px; }
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
        <h1>Add Customer</h1>
        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="tel" name="phone" required>

            <input type="submit" name="submit" value="Add Customer">
        </form>
    </div>

</body>
</html>