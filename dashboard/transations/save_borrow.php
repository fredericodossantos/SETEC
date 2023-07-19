<?php
session_start();
include_once '../../db/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $equipmentId = $_POST['equipment_id'];
    $borrowerName = $_POST['borrower'];
    $borrowDate = $_POST['borrow_date'];
    $returnDate = $_POST['return_date'];

    // Assuming the status_id for a newly borrowed equipment is '1 - emprestado'
    $statusId = 1;

    // Insert the borrowing information into the borrow_log table
    $sql = "INSERT INTO borrow_log (borrower_id, equipment_id, borrow_date, return_date, status_id) VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sql);

    if (!$stmtInsert) {
        $_SESSION['status'] = "Erro ao preparar a consulta: " . $conn->error;
        header("Location: form_borrow_equip.php?id=" . $equipmentId);
        exit;
    }

    $stmtInsert->bind_param("iissi", $borrowerId, $equipmentId, $borrowDate, $returnDate, $statusId);

    // You need to fetch the borrower ID based on the provided borrower name from the organization table
    $borrowerId = fetchBorrowerIdByName($borrowerName); // Create a function to fetch the borrower ID

    if ($stmtInsert->execute()) {
        $_SESSION['status'] = "Equipamento emprestado com sucesso";
        header("Location: manage_borrow.php");
        exit;
    } else {
        $_SESSION['status'] = "Erro ao emprestar o equipamento: " . $stmtInsert->error;
        header("Location: form_borrow_equip.php?id=" . $equipmentId);
        exit;
    }

    $stmtInsert->close();
    $conn->close();
}

// Function to fetch the borrower ID based on the provided borrower name
function fetchBorrowerIdByName($borrowerName) {
    global $conn;
    $sql = "SELECT id FROM organization WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $borrowerName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    } else {
        return null;
    }
}
?>
