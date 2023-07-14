<?php
session_start();

// Use the database.php file
require_once '../../db/database.php';

// Fetch borrowers from the database
$sqlBorrowers = "SELECT * FROM borrowers";
$resultBorrowers = mysqli_query($conn, $sqlBorrowers);

// Fetch equipment from the database
$sqlEquipment = "SELECT * FROM equipment";
$resultEquipment = mysqli_query($conn, $sqlEquipment);

if (isset($_POST['borrow_equipment'])) {
    $borrowerId = $_POST['borrower_id'];
    $equipmentId = $_POST['equipment_id'];
    $borrowDate = $_POST['borrow_date'];
    $returnDate = $_POST['return_date'];
    $status = 'Borrowed';

    // Insert the borrow transaction into the borrow_log table
    $sql = "INSERT INTO borrow_log (borrower_id, equipment_id, borrow_date, return_date, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $borrowerId, $equipmentId, $borrowDate, $returnDate, $status);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Equipment borrowed successfully";
        header("Location: manage_borrow.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to borrow equipment";
        header("Location: borrow_equipment.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Equipment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
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
                        <li><a class="dropdown-item" href="#">Cadastro de Usuários</a></li>                    
                        <li><a class="dropdown-item" href="../operations/client/manage_borrower.php">Cadastro de Clientes</a></li>
                    </ul>
                </div>
                
                <a class="nav-link" href="transactionlog.php">Log de Empréstimos</a>
                <a class="nav-link" href="reports.php">Reports and Analytics</a>
                <a class="nav-link" href="search.php">Search Functionality</a>
                <a class="nav-link" href="profile.php">User Profile</a>
            </div>
            </div>
        </div>
    </nav>

    

    
    <?php include('message.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Empréstimo de Equipamento</h4>
                </div>
                <div class="card-body">
                    <form action="borrow_equipment.php" method="POST">                        
                        <label for="borrower_id">Borrower:</label>
                        <select name="borrower_id" required>
                            <?php while ($row = mysqli_fetch_assoc($resultBorrowers)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select><br><br>

                        <label for="equipment_id">Equipment:</label>
                        <select name="equipment_id" required>
                            <?php while ($row = mysqli_fetch_assoc($resultEquipment)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select><br><br>

                        <label for="borrow_date">Borrow Date:</label>
                        <input type="datetime-local" name="borrow_date" required><br><br>

                        <label for="return_date">Return Date:</label>
                        <input type="datetime-local" name="return_date" required><br><br>

                        <input type="submit" name="borrow_equipment" value="Borrow">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
