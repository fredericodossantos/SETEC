<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../../../login.php");
    exit();
}
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
                
                <a class="nav-link" href="../../transations/manage_borrow.php">Empréstimos</a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cadastro
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="cadastroDropdown">
                        <li><a class="dropdown-item" href="../../operations/equipment/manage_equipment.php">Cadastro de Equipamentos</a></li>                                            
                        <li><a class="dropdown-item" href="#">Cadastro de Usuários</a></li>                    
                        <li><a class="dropdown-item" href="manage_borrower.php">Cadastro de Clientes</a></li>
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
    <?php include ('message.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Editar Cliente</h4>
                </div>
                <?php
                include_once '../../../db/database.php';

                // Fetching all organizations
                $organization_query = "SELECT id, name FROM organization";
                $organization_result = mysqli_query($conn, $organization_query);
                $organizations = mysqli_fetch_all($organization_result, MYSQLI_ASSOC);

                if (isset($_GET['id'])) {
                    $sql_query = "SELECT * FROM borrowers WHERE id = " . $_GET['id'];
                    $result_set = mysqli_query($conn, $sql_query);
                    $fetched_row = mysqli_fetch_array($result_set);
                } else {
                    $fetched_row = array('id' => '', 'name' => '', 'email' => '', 'phone' => '', 'organization_id' => '');
                }
                ?>
                <div class="card-body">
                    <form action="edit_borrower.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $fetched_row['id']; ?>">
                        <div class="form-group mb-3">
                            <label for="">Nome do Cliente</label>
                            <input type="text" name="name" value="<?php echo $fetched_row['name']; ?>" class="form-control" placeholder="Nome do cliente">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" value="<?php echo $fetched_row['email']; ?>" class="form-control" placeholder="Email do cliente">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Telefone</label>
                            <input type="text" name="phone" value="<?php echo $fetched_row['phone']; ?>" class="form-control" placeholder="Telefone de contato do cliente">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">ID da Organização</label>
                            <select name="organization_id" class="form-control">
                                <?php foreach ($organizations as $org) { ?>
                                    <option value="<?php echo $org['id']; ?>" <?php if ($org['id'] == $fetched_row['organization_id']) echo 'selected'; ?>>
                                        <?php echo $org['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="update_data" class="btn btn-primary">Salvar Edição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>