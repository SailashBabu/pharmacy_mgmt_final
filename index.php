<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // or wherever the user lands
    exit();
}


// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sri Sai Suriya Medicals</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require "navbar.php";
    ?>
    <header>
        <h1>Sri Sai Suriya Medicals</h1>
    </header>
    <main>
    <div class="navigation">
        <div class="overlay-container"></div>
            <!-- <a href="inventory.php" class="button">Inventory</a>
            <a href="billing.php" class="button">Customer Billing</a> -->
        </div>
       
    </main>
</body>
<style>
    .overlay-container {
    position: relative;
    width: 100%;
    height: 100vh; /* Full viewport height */
    background-image: url('iStock-1369520834.jpg'); /* Add your image URL here */
    background-size: cover; /* Ensure the background covers the entire container */
    background-position: center; /* Center the background image */
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
}

/* Overlay */
.overlay-container::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Light black overlay with 50% opacity */
    z-index: 1;
}

/* Text styling */
.overlay-container h1, .overlay-container p {
    z-index: 2; /* Ensure the text is above the overlay */
    text-align: center;
    color: white;
}
</style>
</html>