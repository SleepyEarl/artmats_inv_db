<?php
include 'database.php';
$customers = $conn->query("SELECT * FROM customers");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
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
            display: flex;
            gap: 28px;
            margin: 0;
            padding: 0;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: color .18s ease;
            opacity: .95;
        }

        .nav a:hover { color: #ffd6c2; }
        .nav a.active { color: #ff7a45; }

        /* Container */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .container h1 {
            margin: 0 0 20px 0;
            font-size: 24px;
            color: #fff;
        }

        .btn-main {
            display: inline-block;
            padding: 10px 18px;
            background: #2e7d32;
            color: #fff;
            text-decoration: none;
            border-radius: 999px;
            font-weight: 700;
            margin-bottom: 16px;
            border: none;
            cursor: pointer;
        }

        .btn-main:hover {
            background: #27663d;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.02);
            border-radius: 8px;
            overflow: hidden;
        }

        table thead {
            background: rgba(255,255,255,0.03);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            color: #e6e6e6;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }

        table th {
            font-weight: 700;
            color: #fff;
            font-size: 13px;
            letter-spacing: .4px;
        }

        table tbody tr:hover {
            background: rgba(255,255,255,0.01);
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons a {
            text-decoration: none;
        }

        .btn-edit {
            display: inline-block;
            padding: 6px 12px;
            background: #2d6cdf;
            color: #fff;
            border-radius: 6px;
            border: none;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-edit:hover {
            background: #1e52b8;
        }

        .btn-delete {
            display: inline-block;
            padding: 6px 12px;
            background: #c62828;
            color: #fff;
            border-radius: 6px;
            border: none;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #a01f1f;
        }

        /* Responsive */
        @media (max-width: 720px) {
            header { padding: 14px 18px; }
            .container { padding: 0 12px; }
            table, table thead, table tbody, table th, table td, table tr {
                display: block;
            }
            table thead { display: none; }
            table tr { margin-bottom: 12px; background: rgba(255,255,255,0.02); padding: 10px; border-radius: 8px; }
            table td { border: none; padding: 6px 8px; }
            table td[data-label]::before {
                content: attr(data-label) ": ";
                font-weight: 700;
                color: #fff;
            }
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
        <h1>Customers</h1>
        <a href="add_customer.php"><button class="btn-main">Add Customer</button></a>

        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($cust = $customers->fetch_assoc()): ?>
                <tr>
                    <td data-label="Customer ID"><?= $cust['CustomerID'] ?></td>
                    <td data-label="Full Name"><?= $cust['FullName'] ?></td>
                    <td data-label="Email"><?= $cust['Email'] ?></td>
                    <td data-label="Phone"><?= $cust['Phone'] ?></td>
                    <td data-label="Actions">
                        <div class="action-buttons">
                            <a href="edit_customer.php?id=<?= $cust['CustomerID'] ?>">
                                <button class="btn-edit">Edit</button>
                            </a>
                            <a href="delete_customer.php?id=<?= $cust['CustomerID'] ?>" 
                               onclick="return confirm('Delete this customer?')">
                                <button class="btn-delete">Delete</button>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>