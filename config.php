<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');  // your MySQL username
define('DB_PASSWORD', '');      // your MySQL password
define('DB_NAME', 'patient_management');

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>