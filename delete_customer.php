<?php
include 'database.php';

// Get the CustomerID from URL
$id = $_GET['id'];

// Delete the customer from the database
$conn->query("DELETE FROM customers WHERE CustomerID='$id'");

// Redirect back to the Manage Customers page
header("Location: manage_customer.php");
exit;
?>