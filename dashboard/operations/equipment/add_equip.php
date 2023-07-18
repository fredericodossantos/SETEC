<?php
session_start();
include_once '../../../db/database.php';

if (isset($_POST['insert_data'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $serial_number = $_POST['serial_number'];
    $status_id = $_POST['status_id'];
    
    $sql = "INSERT INTO equipment (name, description, category, serial_number, status_id) VALUES (?,?,?,?,?)";
    $stmtinsert = $conn->prepare($sql);

    

    if (!$stmtinsert) {
        $_SESSION['status'] = "Erro ao preparar a consulta: " . $conn->error;
        header("Location: form_add_equip.php");
        exit;
    }
    
    $stmtinsert->bind_param("ssssi", $name, $description, $category, $serial_number, $status_id);
    
    if ($stmtinsert->execute()) {
        $_SESSION['status'] = "Equipamento inserido com sucesso";
        header("Location: manage_equipment.php");
        exit;
    } else {
        $_SESSION['status'] = "Erro ao inserir o equipamento: " . $stmtinsert->error;
        header("Location: form_add_equip.php");
        exit;
    }

    $stmtinsert->close();
    $conn->close();
}


?>