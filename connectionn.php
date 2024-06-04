<?php
    try {
        $con = new PDO("mysql:host=localhost;dbname=eclasse", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test the connection by running a simple query
        $result = $con->query("SELECT 1");
        if ($result !== false) {
            echo "Database connection is working.";
        } else {
            echo "Database query failed.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
}
