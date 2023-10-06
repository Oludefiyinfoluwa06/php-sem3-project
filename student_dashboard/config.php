<?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "portal";

    // Create a connection to the database
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed");
    }
?>
