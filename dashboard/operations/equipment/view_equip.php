


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
                        <li><a class="dropdown-item" href="manage_equipment.php">Cadastro de Equipamentos</a></li>                    
                        <!-- <li><a class="dropdown-item" href="manage_components.php">Cadastro de Componentes</a></li> -->
                        <li><a class="dropdown-item" href="#">Cadastro de Usuários</a></li>                    
                        <li><a class="dropdown-item" href="../client/manage_borrower.php">Cadastro de Clientes</a></li>
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

    <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Detalhes de Equipamento</h4>
                    </div>
                    <?php
                    if(isset($_GET['id'])){
                        include_once '../../../db/database.php';
                        $sql_query = "SELECT * FROM equipment WHERE id = " . $_GET['id'];
                        $result_set = mysqli_query($conn, $sql_query);
                        $fetched_row = mysqli_fetch_array($result_set);
                    }  

                    ?>
                    <div class="card-body">
                    <form>
                        <div class="form-group mb-3">
                            <label for="">Nome Equipamento</label>                            
                            <p class="form-control"> 
                                <?=$fetched_row['name'];?>
                            </p>
                        </div>
                        <div class="form-group mb-3">                            
                            <label for="">Descrição</label>                            
                            <p class="form-control"> 
                                <?=$fetched_row['description'];?>
                            </p>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Categoria</label>                            
                            <p class="form-control"> 
                                <?=$fetched_row['category'];?>
                            </p>
                        </div>
                    </form>
                    </div>


                </div>

            </div>

        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
