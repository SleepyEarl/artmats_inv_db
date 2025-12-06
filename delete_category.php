<?php
include 'database.php';
$id = $_GET['id'];
$conn->query("DELETE FROM categories WHERE CategoryID='$id'");
header("Location: manage_category.php");
?>