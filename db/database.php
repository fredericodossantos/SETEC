<?php
// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sipam_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8
mysqli_set_charset($conn, "utf8");
?>


