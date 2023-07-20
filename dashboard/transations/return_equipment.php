<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../../../login.php");
    exit();
}

require_once '../../db/database.php';

// Check if the ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $borrowLogId = $_GET['id'];
} else {
    // Redirect if the ID is not provided
    header("Location: manage_borrow.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform the actions for returning the equipment
    // Update the status of the equipment in the borrow_log table
    $updateQuery = "UPDATE borrow_log SET status_id = 2 WHERE id = ?"; // Set status_id to 2 (disponivel)
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $borrowLogId);

    if ($stmt->execute()) {
        // Successfully returned the equipment

        // Now update the equipment table's status_id to 2 (disponivel)
        $updateEquipmentStatusQuery = "UPDATE equipment SET status_id = 2 WHERE id = ?";
        $stmt2 = $conn->prepare($updateEquipmentStatusQuery);
        $stmt2->bind_param("i", $borrowLogId);
        $stmt2->execute();
        $stmt2->close();

        $_SESSION['success_message'] = "Equipamento devolvido com sucesso.";
        header("Location: manage_borrow.php");
        exit();
    } else {
        // Error occurred during the update
        $_SESSION['error_message'] = "Ocorreu um erro ao devolver o equipamento. Por favor, tente novamente.";
    }

    // Close the statement
    $stmt->close();
}

// Retrieve the equipment details from the borrow_log table
$query = "SELECT borrow_log.id, organization.name AS organization_name, borrow_log.borrow_date, borrow_log.return_date, equipment.name AS equipment_name, status_lookup.status 
        FROM borrow_log
        INNER JOIN organization ON borrow_log.organization_id = organization.id
        INNER JOIN equipment ON borrow_log.equipment_id = equipment.id
        INNER JOIN status_lookup ON borrow_log.status_id = status_lookup.id
        WHERE borrow_log.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $borrowLogId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the equipment details
if ($row = $result->fetch_assoc()) {
    // Extract the equipment details
    $borrowLogId = $row['id'];
    $organizationName = $row['organization_name'];
    $borrowDate = $row['borrow_date'];
    $returnDate = $row['return_date'];
    $equipmentName = $row['equipment_name'];
    $status = $row['status'];
} else {
    // Redirect if the borrow log ID is invalid or not found
    $_SESSION['error_message'] = "Registro de empréstimo não encontrado.";
    header("Location: manage_borrow.php");
    exit();
}

// Close the statement
$stmt->close();

include 'return_equipment.html';
?>
