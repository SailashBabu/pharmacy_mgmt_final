<?php
try {
    $manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");
    echo "MongoDB connection successful!";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Connection error: " . $e->getMessage();
}
?>
