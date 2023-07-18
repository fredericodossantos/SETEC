<?php
session_start();
// 
include_once '../../../db/database.php';

if (isset($_POST['update_data'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $serial_number = $_POST['serial_number'];
    $id = $_POST['id']; 
    
    $sql = "UPDATE equipment SET name=?, description=?, category=? , serial_number=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $description, $category, $serial_number, $id);
    $result = $stmt->execute();
    
    if ($result) {
        $_SESSION['status'] = "Equipamento atualizado com sucesso";
        header("Location: manage_equipment.php");
        exit();
    } else {
        $_SESSION['status'] = "Equipamento não atualizado";
        header("Location: form_edit_equip.php?id=" . $id);
        exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>
