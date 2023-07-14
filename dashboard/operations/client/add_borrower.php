<?php
session_start();
// Include the database.php file
include_once '../../../db/database.php';

if (isset($_POST['insert_data'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $organization_id = $_POST['organization_id'];

    $sql = "INSERT INTO borrowers (name, email, phone, organization_id) VALUES (?,?,?,?)";
    $stmtinsert = $conn->prepare($sql);
    $stmtinsert->bind_param("sssi", $name, $email, $phone, $organization_id);
    $stmtinsert->execute();

    if ($stmtinsert->affected_rows > 0) {
        $_SESSION['status'] = "Cliente inserido com sucesso";
        header("Location: manage_borrower.php");
        exit();
    } else {
        $_SESSION['status'] = "Cliente não inserido";
        header("Location: form_add_borr.php");
        exit();
    }

    $stmtinsert->close();
    $conn->close();
}
?>
