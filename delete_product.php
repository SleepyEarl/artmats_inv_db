<?php
include "database.php";

$id = $_GET['id'];

$conn->query("DELETE FROM products WHERE ProductID=$id");

echo "<script>alert('Product deleted'); window.location='index.php';</script>";
?>
