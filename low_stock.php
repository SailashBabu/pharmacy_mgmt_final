<?php
session_start();
include('connect.php');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// Fetch low stock medicines from the database
$low_stock_medicines = executeQuery('lowStock', []); // Adjust this query as necessary

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Medicines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php require "navbar.php";?>

<div class="container">
<h1>Low Stock Medicines</h1>

<!-- Low Stock Medicines Table -->
<table border='1'>
<thead>
<tr style='background-color: #4CAF50; color: white;'>
<th>Name</th><th>Type</th><th>Manufacturer</th><th>Batch No</th><th>Expiry Date</th><th>MRP</th></tr></thead><tbody><?php 
foreach ($low_stock_medicines as $medicine): 
?>
<?php 
echo "<tr><td>" . htmlspecialchars($medicine->Name) . "</td><td>" . htmlspecialchars($medicine->Type) . "</td><td>" . htmlspecialchars($medicine->Manufacturer) . "</td><td>" . htmlspecialchars($medicine->Batch_No) . "</td><td>" . htmlspecialchars($medicine->Expiry_Date) . "</td><td>" . htmlspecialchars($medicine->MRP) . "</td></tr>"; 
endforeach; 
?>
</tbody></table>

<!-- Back Button -->
<a href='inventory.php' class='button'>Back to Inventory</a>

</div></body></html>

