<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$mongoUri = $_ENV['MONGO_URI'];

// MongoDB connection setup using MongoDB\Driver\Manager
$manager = new MongoDB\Driver\Manager($mongoUri);


// Utility function to execute queries and return results
function executeQuery($collection, $filter = [], $options = []) {
    global $manager;
    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = $manager->executeQuery("pharmacy.$collection", $query);
    return iterator_to_array($cursor); // Return the result as an array
}

// Utility function to execute bulk write operations
function executeBulkWrite($collection, $bulk) {
    global $manager;
    $manager->executeBulkWrite("pharmacy.$collection", $bulk);
}
?>