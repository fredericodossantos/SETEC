<?php
session_start();
// 
include_once '../../../db/database.php';

if (isset($_POST['update_data'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $id = $_POST['id']; 
    
    $sql = "UPDATE equipment SET name=?, description=?, category=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $description, $category, $id);
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
