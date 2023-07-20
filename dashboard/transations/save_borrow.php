<?php
session_start();
include_once '../../db/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipmentId = $_POST['equipment_id'];
    $organizationName = $_POST['organization'];
    $borrowDate = $_POST['borrow_date'];
    $returnDate = $_POST['return_date'];
    $statusIdBorrowed = 1; // Assuming status_id 1 represents "borrowed" status

    $borrowerId = fetchBorrowerIdByName($organizationName);

    if ($borrowerId === null) {
        $_SESSION['status'] = "Organização não encontrada";
        header("Location: form_borrow_equip.php?id=" . $equipmentId);
        exit;
    }

    $sql = "INSERT INTO borrow_log (organization_id, equipment_id, borrow_date, return_date) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sql);

    if (!$stmtInsert) {
        $_SESSION['status'] = "Erro ao preparar a consulta: " . $conn->error;
        header("Location: form_borrow_equip.php?id=" . $equipmentId);
        exit;
    }

    $stmtInsert->bind_param("iiss", $borrowerId, $equipmentId, $borrowDate, $returnDate);

    if ($stmtInsert->execute()) {
        // Update the status of the equipment to "borrowed"
        $sqlUpdateStatus = "UPDATE equipment SET status_id = ? WHERE id = ?";
        $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
        $stmtUpdateStatus->bind_param("ii", $statusIdBorrowed, $equipmentId);
        $stmtUpdateStatus->execute();
        $stmtUpdateStatus->close();

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

function fetchBorrowerIdByName($organizationName) {
    global $conn;
    $sql = "SELECT id FROM organization WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $organizationName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    } else {
        return null;
    }
}
?>
