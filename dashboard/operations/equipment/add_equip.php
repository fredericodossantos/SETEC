<?php
session_start();
//use once the database.php file
include_once '../../../db/database.php';


if(isset($_POST['insert_data'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];       

    $sql = "INSERT INTO equipment (name, description, category) VALUES (?,?,?)";
    $stmtinsert = $conn->prepare($sql);
    $result = $stmtinsert->bind_param("sss", $name, $description, $category);
    $stmtinsert->execute();
    if($result){
        $_SESSION['status'] = "Equipamento inserido com sucesso";
        header("Location: manage_equipment.php");
    }
    else{
        $_SESSION['status'] = "Equipamento não inserido";
        header("Location: form_add_equip.php");
    }
    $stmtinsert->close();
    $conn->close();
}


?>