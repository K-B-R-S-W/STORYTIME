<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Create a MongoDB client using environment variable
    $mongoClient = new MongoDB\Client($_ENV['MONGODB_URI']);
    
    // Select the database
    $database = $mongoClient->storytime;
    
    // Select the collection
    $collection = $database->feedback;
    
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "MongoDB Connection failed: " . $e->getMessage();
}
?>
