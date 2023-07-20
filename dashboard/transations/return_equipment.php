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
    // Update the actual_return_date of the equipment in the borrow_log table
    $updateQuery = "UPDATE borrow_log SET actual_return_date = NOW() WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $borrowLogId);

    if ($stmt->execute()) {
        // Successfully returned the equipment
        // Now, update the equipment status to "Disponível" (Available)
        $updateEquipmentStatusQuery = "UPDATE equipment SET status_id = 2 WHERE id = ?";
        $stmtUpdateEquipment = $conn->prepare($updateEquipmentStatusQuery);
        $stmtUpdateEquipment->bind_param("i", $equipmentId);

        // Get the equipment ID from the borrow_log
        $equipmentIdQuery = "SELECT equipment_id FROM borrow_log WHERE id = ?";
        $stmtEquipmentId = $conn->prepare($equipmentIdQuery);
        $stmtEquipmentId->bind_param("i", $borrowLogId);
        $stmtEquipmentId->execute();
        $equipmentIdResult = $stmtEquipmentId->get_result();

        if ($equipmentIdRow = $equipmentIdResult->fetch_assoc()) {
            $equipmentId = $equipmentIdRow['equipment_id'];
            $stmtUpdateEquipment->execute();
            $_SESSION['success_message'] = "Equipamento devolvido com sucesso.";
            header("Location: manage_borrow.php");
            exit();
        } else {
            // Error occurred during the update
            $_SESSION['error_message'] = "Ocorreu um erro ao devolver o equipamento. Por favor, tente novamente.";
        }

        // Close the statement
        $stmtUpdateEquipment->close();
    } else {
        // Error occurred during the update
        $_SESSION['error_message'] = "Ocorreu um erro ao devolver o equipamento. Por favor, tente novamente.";
    }

    // Close the statement
    $stmt->close();
}

// Retrieve the equipment details from the borrow_log and equipment tables
$query = "SELECT borrow_log.id, organization.name AS organization_name, borrow_log.borrow_date, borrow_log.return_date, equipment.name AS equipment_name, equipment.status_id 
        FROM borrow_log
        INNER JOIN organization ON borrow_log.organization_id = organization.id
        INNER JOIN equipment ON borrow_log.equipment_id = equipment.id
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
    $statusId = $row['status_id'];

    // Display the status based on the status_id from the equipment table
    if ($statusId == 1) {
        $status = "Emprestado";
    } else {
        $status = "Disponível";
    }
} else {
    // Redirect if the borrow log ID is invalid or not found
    $_SESSION['error_message'] = "Registro de empréstimo não encontrado.";
    header("Location: manage_borrow.php");
    exit();
}

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Equipment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h3>Detalhes do Empréstimo</h3>
        <p><strong>ID do Empréstimo:</strong> <?php echo $borrowLogId; ?></p>
        <p><strong>Organização:</strong> <?php echo $organizationName; ?></p>
        <p><strong>Data de Empréstimo:</strong> <?php echo $borrowDate; ?></p>
        <p><strong>Data para Devolução:</strong> <?php echo $returnDate; ?></p>
        <p><strong>Equipamento:</strong> <?php echo $equipmentName; ?></p>
        <p><strong>Status:</strong> <?php echo $status; ?></p>

        <form action="return_equipment.php?id=<?php echo $borrowLogId; ?>" method="POST">
            <button type="submit" class="btn btn-danger">Devolver</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
