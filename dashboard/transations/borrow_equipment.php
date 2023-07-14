<?php
session_start();

// Use the database.php file

require_once '../../db/database.php';


// Fetch borrowers from the database
$sqlBorrowers = "SELECT * FROM borrowers";
$resultBorrowers = mysqli_query($conn, $sqlBorrowers);

// Fetch equipment from the database
$sqlEquipment = "SELECT * FROM equipment";
$resultEquipment = mysqli_query($conn, $sqlEquipment);

if (isset($_POST['borrow_equipment'])) {
    $borrowerId = $_POST['borrower_id'];
    $equipmentId = $_POST['equipment_id'];
    $borrowDate = $_POST['borrow_date'];
    $returnDate = $_POST['return_date'];
    $status = 'Borrowed';

    // Insert the borrow transaction into the borrow_log table
    $sql = "INSERT INTO borrow_log (borrower_id, equipment_id, borrow_date, return_date, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $borrowerId, $equipmentId, $borrowDate, $returnDate, $status);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Equipment borrowed successfully";
        header("Location: manage_borrow.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to borrow equipment";
        header("Location: borrow_equipment.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
