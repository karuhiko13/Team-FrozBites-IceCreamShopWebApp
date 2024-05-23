<?php
    $db_name = 'mysql:host=localhost; dbname=db_icecreamshop'; // Database connection details
    $user_name = 'root'; // Database username
    $user_password = ''; // Database password

    try {
        $conn = new PDO($db_name, $user_name, $user_password); // Creating a PDO database connection
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Setting error mode to exception
    } catch (PDOException $e) { // Catching any PDO exceptions
        echo "Connection failed: " . $e->getMessage(); // Displaying connection failure message
    }

    function unique_id() { // Function to generate a unique ID
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Characters to use for ID generation
        $charLength = strlen($chars); // Length of the character set
        $randomString = ''; // Initialize the variable to store the ID
        for ($i = 0; $i < 20; $i++) { // Generating a 20-character random string
            $randomString .= $chars[mt_rand(0, $charLength - 1)]; // Appending a random character from the set
        }
        return $randomString; // Returning the generated unique ID
    }
?>
