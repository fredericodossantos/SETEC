<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connect to the database
    include 'database.php';

    // Check if the email and password are valid
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Valid login, set session variable and redirect to main.php
        $_SESSION['loggedin'] = true;
        header("Location: ../dashboard/main.php");
        echo "Login successful";
        exit();
    } else {
        // Invalid login, redirect back to login.php with an error message
        header("Location: ../login.php?error=invalid");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
