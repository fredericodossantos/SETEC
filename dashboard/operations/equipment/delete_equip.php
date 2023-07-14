<?php
session_start();
//use once the database.php file
include_once '../../../db/database.php';



if(isset($_POST['delete_data'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM `equipment` WHERE id=?";
    $stmtdelete = $conn->prepare($sql);
    $result = $stmtdelete->bind_param("i", $id);
    $stmtdelete->execute();
    if($result){
        $_SESSION['status'] = "Equipamento deletado com sucesso";
        header("Location: manage_equipment.php");
    }
    else{
        $_SESSION['status'] = "Equipamento não deletado";
        header("Location: manage_equipment.php");
    }
    $stmtdelete->close();
    $conn->close();
}



?>