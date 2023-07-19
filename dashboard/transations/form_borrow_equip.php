<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../../../login.php");
    exit();
}

require_once '../../db/database.php';

// Retrieve the equipment ID from the URL parameter
if (isset($_GET['id'])) {
    $equipmentId = $_GET['id'];
} else {
    // Redirect if the ID is not provided
    header("Location: available_equipment.php");
    exit();
}

// Use the $equipmentId to fetch the equipment details from the database
$query = "SELECT * FROM equipment WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $equipmentId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the equipment details
if ($row = $result->fetch_assoc()) {
    // Extract the equipment details
    $equipmentName = $row['name'];
    $equipmentDescription = $row['description'];
    $equipmentCategory = $row['category'];
    $equipmentSerialNumber = $row['serial_number'];
    // ... Add more fields if needed
} else {
    // Redirect if the equipment ID is invalid or not found
    header("Location: available_equipment.php");
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
    <title>Formulário de Empréstimo</title>    
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
                    <a class="nav-link" href="#">User Profile</a>
                </div>
            </div>
        </div>
    </nav>
    <?php include('message.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Formulário de Empréstimo</h4>   
                </div>
                <div class="card-body">
                    <form action="save_borrow.php" method="POST" id="borrowForm">
                        <input type="hidden" name="equipment_id" value="<?php echo $equipmentId; ?>">
                        <div class="form-group mb-3">
                            <label for="">Equipamento</label>
                            <input type="text" name="equipment" class="form-control" value="<?php echo $equipmentName; ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Descrição</label>
                            <textarea name="description" class="form-control" readonly><?php echo $equipmentDescription; ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Categoria</label>
                            <input type="text" name="category" class="form-control" value="<?php echo $equipmentCategory; ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Número de Série</label>
                            <input type="text" name="serial_number" class="form-control" value="<?php echo $equipmentSerialNumber; ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Borrower</label>
                            <!-- Assuming "borrowers" is the table for organizations -->
                            <select name="organization" class="form-control">
                                <option value="">Selecione a organização</option>
                                <?php
                                $orgQuery = "SELECT id, name FROM organization";
                                $orgResult = mysqli_query($conn, $orgQuery);
                                while ($orgRow = mysqli_fetch_assoc($orgResult)) {
                                    echo '<option value="' . $orgRow['name'] . '">' . $orgRow['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Data de Empréstimo</label>
                            <input type="date" name="borrow_date" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Data de Devolução</label>
                            <input type="date" name="return_date" class="form-control">
                        </div>
                        <!-- Add other necessary input fields for the borrowing form -->
                        <button type="submit" class="btn btn-success">Emprestar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
