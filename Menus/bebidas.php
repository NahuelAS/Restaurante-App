<?php
    include("cabeceras.php");
    include("../db/conexion.php");

    try {
        $query = "SELECT * FROM bebidas";
        $stmt = $conexion -> prepare($query);
        $stmt -> execute();
        $bebidas = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error en Consulta: ". $e -> getMessage();
    }

        //* ---INSERTAR--- //
    if(isset($_REQUEST['submit'])){
        $id = $_POST['idBebida'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $tag = $_POST['tags'];
        $nombre_imagen = $_FILES['foto']['name'];
        $temporal = $_FILES['foto']['tmp_name'];
        $carpeta = '../img/Menu/bebidas';
        $ruta = $carpeta.'/'.$nombre_imagen;
        move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);

        $insertar = $conexion -> prepare("INSERT INTO bebidas (nombre, precio, descripcion, imagen, tags) VALUES (:nombre, :precio, :descripcion, :ruta, :tags)");

        $insertar -> bindParam(":nombre",$nombre);
        $insertar -> bindParam(":precio",$precio);
        $insertar -> bindParam(":descripcion",$descripcion);
        $insertar -> bindParam(":ruta",$ruta);
        $insertar -> bindParam(":tags",$tag);

        if($insertar -> execute()) {
            echo '<script>
            alert("Ingresado");
            window.location.href = "bebidas.php";
            </script>';
        } else {
            echo '<script>
            alert("No se Pudo Ingresar");
            window.location.href = "bebidas.php";
            </script>';
        }
    
    }

        //* ---ELIMINAR--- //
    if (isset($_GET['idBebida']) && is_numeric($_GET['idBebida'])){
        
        $id = $_GET['idBebida'];

        $eliminar = $conexion -> prepare("DELETE FROM bebidas WHERE idBebida = :idBebida");
        $eliminar -> bindParam(":idBebida", $id, PDO::PARAM_INT);

        if ($eliminar -> execute()) {
            echo '<script>
            alert("Eliminado");
            window.location.href = "bebidas.php";
            </script>';
        } else {
            echo '<script>
            alert("No se Pudo Eliminar");
            window.location.href = "bebidas.php";
            </script>';
        }
    }

        //* ---EDITAR--- //
    if (isset($_GET['modificar'])) {

        $id_modif = $_GET['modificar'];

        $queryEdit = "SELECT * FROM bebidas WHERE idBebida = :idBebida";
        $stmtEditar = $conexion -> prepare($queryEdit);
        $stmtEditar -> bindParam(":idBebida", $id_modif, PDO::PARAM_INT);
        $stmtEditar -> execute();
        
        $cambiar = $stmtEditar -> fetch(PDO::FETCH_ASSOC);
    }

        //* ---ACTUALIZAR--- //
    if (isset($_POST['actualizar'])) {
        $id = $_POST['idBebida'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $tag = $_POST['tags'];
        $nombre_imagen = $_FILES['foto']['name'];
        $temporal = $_FILES['foto']['tmp_name'];
        $carpeta = '../img/Menu/bebidas';
        $ruta = $carpeta.'/'.$nombre_imagen;
        move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);

        $queryActualizar = "UPDATE bebidas SET nombre = :nombre, precio = :precio, descripcion = :descripcion, tags = :tags, imagen = :ruta WHERE idBebida = :idBebida";

        $stmtAct = $conexion -> prepare($queryActualizar);
        $stmtAct -> bindParam(":idBebida", $id, PDO::PARAM_INT);
        $stmtAct -> bindParam(":nombre", $nombre);
        $stmtAct -> bindParam(":precio", $precio);
        $stmtAct -> bindParam(":descripcion", $descripcion);
        $stmtAct -> bindParam(":ruta", $ruta);
        $stmtAct -> bindParam(":tags", $tag);

        if ($stmtAct -> execute()) {
            echo '<script>
            alert("Actualizado");
            window.location.href = "bebidas.php";
            </script>';
        } else {
            echo '<script>
            alert("No se pudo Actualizar");
            window.location.href = "bebidas.php";
            </script>';
        }

    }
?>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../css/estilo.css">    
        <style>
            .icono-basura {
                color: red;
                margin-top: 40px;
                font-size: 1.5em;
            }
            .icono-editar {
                color: green;
                margin-top: 40px;
                font-size: 1.5em;
            }
        </style>
    </head>

    <body>
    
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><strong>Alta de Bebidas</strong></h1>
                            </div>

                            <form class="user" action="bebidas.php" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="idBebida" value="<?php if(isset($_GET['modificar'])) echo $_GET['modificar']; else echo ''; ?>" class="form-control form-control-user">

                                <!-- Nombre y Precio -->
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="nombre" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Nombre" value="<?php if(isset($_GET['modificar'])) echo $cambiar['nombre']; else echo ''; ?>">
                                    </div>
                                    <!-- Nombre del Plato -->                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="precio" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Precio" value="<?php if(isset($_GET['modificar'])) echo $cambiar['precio']; else echo ''; ?>">
                                    </div>
                                    <!-- Apellido de Usuario -->
                                </div>
                                
                                <!-- Descripcion -->
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" name="descripcion" class="form-control form-control-user" id="exampleInputPassword" 
                                            placeholder="Descipcion" value="<?php if(isset($_GET['modificar'])) echo $cambiar['descripcion']; else echo ''; ?>">
                                    </div>
                                </div>
                                <!-- Descripcion -->

                                <!-- Imagen y Tags-->
                                <div class="form-group row">
                                    <!-- Tags -->
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="tags" class="form-control form-control-user" id="exampleInputPassword" 
                                            placeholder="Tags" value="<?php if(isset($_GET['modificar'])) echo $cambiar['tags']; else echo ''; ?>">
                                    </div>
                                    <!-- Tags -->

                                    <!-- Imagen -->
                                    <div class="col-sm-6">
                                        <input type="file" name="foto" class="custom-file" id="file-upload" style="display: none;">
                                        <label for="file-upload" class="custom-file-upload">Seleccionar Archivo</label>
                                        <span id="file-name"><?php if(isset($_GET['modificar'])) echo $cambiar['imagen']; ?></span>
                                    </div>
                                </div>
                                <!-- Imagen -->

                                <!-- Boton de Registro -->
                                <input type="submit" name="<?php if(isset($_GET['modificar'])) echo 'actualizar'; else echo 'submit';?>" 
                                class="btn btn-primary btn-user btn-block" 
                                value="<?php if(isset($_GET['modificar'])) echo 'Modificar'; else echo 'Insertar';?>">
                    
                            </form>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTales -->
                <div class="card shadow mb-4">  <!--  -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabla de Registros</h6>
                            <br>
                            <input type="search" class=" form-control col-4" id="filtro" placeholder= "Filtrar">                           
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-dark font-weight-bold text-center">Nombre</th>
                                            <th class="text-dark font-weight-bold text-center">Precio</th>
                                            <th class="text-dark font-weight-bold text-center">Descripcion</th>
                                            <th class="text-dark font-weight-bold text-center">Tags</th>
                                            <th class="text-dark font-weight-bold text-center">Imagen</th>
                                            <th class="text-dark font-weight-bold text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-body">
                                        <?php foreach ($bebidas as $bebida) : ?>
                                        <tr>
                                            <!-- <td class="text-center"><?php echo $bebida['idBebida']; ?></td> -->
                                            <td class="text-center"><?php echo $bebida['nombre']; ?></td>
                                            <td class="text-center">$<?php echo $bebida['precio']; ?></td>
                                            <td class="text-center"><?php echo $bebida['descripcion']; ?></td>
                                            <td class="text-center"><?php echo $bebida['tags']; ?></td>
                                            <td><img src="<?php echo $bebida['imagen']; ?>" alt="" width="100" height="100"></td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="bebidas.php?modificar=<?php echo $bebida['idBebida']; ?>"><i class="fas fa-pencil-alt fa-1x icono-editar"></i></a> // 
                                                    <a href="bebidas.php?idBebida=<?php echo $bebida['idBebida']; ?>"><i class="fas fa-trash fa-1x icono-basura"></i></a>
                                                </div>                                                
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</div>

<!-- /.container-fluid -->


</div>
<!-- End of Main Content --> 


</div>
<!-- End of Content Wrapper -->
    <!-- Footer -->
    <footer class="sticky-footer bg-dark bg-gray-900">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto text-white" >
                        <span>Copyright <sup>&copy;</sup> - <strong>La Oveja Negra 2024</strong> - Nahuel A. Stella  <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Whatsapp"><i class="fab fa-whatsapp"></i></a> <strong>/</strong> <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Instagram"><i class="fab fa-instagram"></i></a> <strong>/</strong> <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a></span>                                      
                    </div> 
                </div>
        </footer>
    <!-- End of Footer -->
</div>
<!-- End of Page Wrapper -->

<script src="../js/file.js"></script>
<script src="../js/busqueda.js"></script>
</body>
</html>