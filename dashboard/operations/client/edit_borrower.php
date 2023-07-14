<?php
session_start();

include_once '../../../db/database.php';

if (isset($_POST['update_data'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $organization_id = $_POST['organization_id'];
    $id = $_POST['id'];

    $sql = "UPDATE borrowers SET name=?, email=?, phone=?, organization_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $name, $email, $phone, $organization_id, $id);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Cliente atualizado com sucesso";
        header("Location: manage_borrower.php");
        exit();
    } else {
        $_SESSION['status'] = "Cliente não atualizado";
        header("Location: form_edit_borr.php?id=" . $id);
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: manage_borrower.php");
    exit();
}
?>
