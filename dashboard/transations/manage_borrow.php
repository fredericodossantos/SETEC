<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../../../login.php");
    exit();
}
?>

<?php
require_once '../../db/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="manage_borrow.php">Empréstimos</a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cadastro
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="cadastroDropdown">
                            <li><a class="dropdown-item" href="../operations/equipment/manage_equipment.php">Cadastro de Equipamentos</a></li>
                            <!-- <li><a class="dropdown-item" href="manage_components.php">Cadastro de Componentes</a></li> -->
                            <li><a class="dropdown-item" href="#">Cadastro de Usuários</a></li>
                            <li><a class="dropdown-item" href="../operations/client/manage_borrower.php">Cadastro de Clientes</a></li>
                        </ul>
                    </div>
                    <a class="nav-link" href="#">Log de Empréstimos</a>
                    <a class="nav-link" href="#">Reports and Analytics</a>
                    <a class="nav-link" href="#">Search Functionality</a>
                    <a class="nav-link" href="#p">User Profile</a>
                </div>
            </div>
        </div>
    </nav>
    <?php include ('message.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Equipamentos em Empréstimo
                        <a href="available_equipment.php" class="btn btn-primary float-end">Novo Empréstimo</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Organização</th>
                                <th scope="col">Data de Empréstimo</th>
                                <th scope="col">Data para Devolução</th>
                                <th scope="col">Equipamento</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Fetch borrow_log details along with equipment status
                            $sql = "SELECT borrow_log.id, organization.name AS organization_name, borrow_log.borrow_date, borrow_log.return_date, equipment.name AS equipment_name
                                    FROM borrow_log
                                    INNER JOIN organization ON borrow_log.organization_id = organization.id
                                    INNER JOIN equipment ON borrow_log.equipment_id = equipment.id";

                            $result = mysqli_query($conn, $sql);
                            if (!$result) {
                                die('Query Failed' . mysqli_error($conn));
                            }

                            while ($row = mysqli_fetch_assoc($result)) {
                                // Check the status of the equipment
                                $status = "Disponível";
                                $equipmentId = $row['equipment_id'];
                                $equipmentStatusQuery = "SELECT status_id FROM equipment WHERE id = ?";
                                $stmt = $conn->prepare($equipmentStatusQuery);
                                $stmt->bind_param("i", $equipmentId);
                                $stmt->execute();
                                $equipmentStatusResult = $stmt->get_result();

                                if ($equipmentStatusRow = $equipmentStatusResult->fetch_assoc()) {
                                    $equipmentStatusId = $equipmentStatusRow['status_id'];
                                    if ($equipmentStatusId == 1) {
                                        $status = "Emprestado";
                                    }
                                }

                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['organization_name']; ?></td>
                                <td><?php echo $row['borrow_date']; ?></td>
                                <td><?php echo $row['return_date']; ?></td>
                                <td><?php echo $row['equipment_name']; ?></td>
                                <td>                                        
                                    <a href="return_equipment.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Devolver</a>
                                </td>                                    
                            </tr>
                        <?php 
                            // Close the statement
                            $stmt->close();
                            } // End of while loop
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
