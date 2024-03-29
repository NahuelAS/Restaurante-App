<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="img/OvejaIcon.ico"/>
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistema de Gestión - Inicia Sesión</h1>
                                    </div>
                                    
                                    <form class="user" action="index.php" method="POST">

                                        <!-- Nombre de Usuario -->
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleFirstName" name="usuario" aria-describedby="emailHelp"
                                                placeholder="Usuario...">
                                        </div>

                                        <!-- Contraseña -->
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="password" placeholder="Contraseña...">
                                        </div>

                                        <!-- Boton de Logueo -->
                                        <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Iniciar">
                                        <!-- <a name="submit" type="submit" class="btn btn-primary btn-user btn-block">
                                            Log
                                        </a> -->


                                        <?php 

                                        if (isset($_POST["submit"])) {

                                            include("./db/conexion.php");
                                            $usuario = $_POST['usuario'];
                                            $password = $_POST['password'];

                                            $sql = "SELECT * FROM personal WHERE usuario = '$usuario' AND password = '$password'";
                                            if ($resultado = $conexion -> query($sql)) {
                                                if ($resultado -> fetchColumn() > 0) {
                                                    session_start();
                                                    $_SESSION["logueado"] = $usuario;
                                                    header("location: principal.php");
                                                } else {
                                                    echo "<script>
                                                    alert('Error')
                                                    </script>";
                                                }
                                            }

                                            $conexion = null;
                                        }
                                        ?>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>