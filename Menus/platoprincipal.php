<?php
    include("cabeceras.php");
    include("../db/conexion.php");

    try {
        $query = "SELECT * FROM platoprincipal";
        $stmt = $conexion -> prepare($query);
        $stmt -> execute();
        $platoprincipal = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error en Consulta: ". $e -> getMessage();
    }

        //* ---INSERTAR--- //
    if(isset($_REQUEST['submit'])){
        $id = $_POST['idPlato'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $tag = $_POST['tags'];
        $nombre_imagen = $_FILES['foto']['name'];
        $temporal = $_FILES['foto']['tmp_name'];
        $carpeta = '../img/Menu/plato-principal';
        $ruta = $carpeta.'/'.$nombre_imagen;
        move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);

        $insertar = $conexion -> prepare("INSERT INTO platoprincipal (nombre, precio, descripcion, imagen, tags) VALUES (:nombre, :precio, :descripcion, :ruta, :tags)");

        $insertar -> bindParam(":nombre",$nombre);
        $insertar -> bindParam(":precio",$precio);
        $insertar -> bindParam(":descripcion",$descripcion);
        $insertar -> bindParam(":ruta",$ruta);
        $insertar -> bindParam(":tags",$tag);

        if($insertar -> execute()) {
            echo '<script>
            alert("Ingresado");
            window.location.href = "platoprincipal.php";
            </script>';
        } else {
            echo '<script>
            alert("No se Pudo Ingresar");
            window.location.href = "platoprincipal.php";
            </script>';
        }
    
    }

        //* ---ELIMINAR--- //
    if (isset($_GET['idPlato']) && is_numeric($_GET['idPlato'])){
        
        $id = $_GET['idPlato'];

        $eliminar = $conexion -> prepare("DELETE FROM platoprincipal WHERE idPlato = :idPlato");
        $eliminar -> bindParam(":idPlato", $id, PDO::PARAM_INT);

        if ($eliminar -> execute()) {
            echo '<script>
            alert("Eliminado");
            window.location.href = "platoprincipal.php";
            </script>';
        } else {
            echo '<script>
            alert("No se Pudo Eliminar");
            window.location.href = "platoprincipal.php";
            </script>';
        }
    }

        //* ---EDITAR--- //
    if (isset($_GET['modificar'])) {

        $id_modif = $_GET['modificar'];

        $queryEdit = "SELECT * FROM platoprincipal WHERE idPlato = :idPlato";
        $stmtEditar = $conexion -> prepare($queryEdit);
        $stmtEditar -> bindParam(":idPlato", $id_modif, PDO::PARAM_INT);
        $stmtEditar -> execute();
        
        $cambiar = $stmtEditar -> fetch(PDO::FETCH_ASSOC);
    }

        //* ---ACTUALIZAR--- //
    if (isset($_POST['actualizar'])) {
        $id = $_POST['idPlato'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $tag = $_POST['tags'];
        $nombre_imagen = $_FILES['foto']['name'];
        $temporal = $_FILES['foto']['tmp_name'];
        $carpeta = '../img/Menu/plato-principal';
        $ruta = $carpeta.'/'.$nombre_imagen;
        move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);

        $queryActualizar = "UPDATE platoprincipal SET nombre = :nombre, precio = :precio, descripcion = :descripcion, tags = :tags, imagen = :ruta WHERE idPlato = :idPlato";

        $stmtAct = $conexion -> prepare($queryActualizar);
        $stmtAct -> bindParam(":idPlato", $id, PDO::PARAM_INT);
        $stmtAct -> bindParam(":nombre", $nombre);
        $stmtAct -> bindParam(":precio", $precio);
        $stmtAct -> bindParam(":descripcion", $descripcion);
        $stmtAct -> bindParam(":ruta", $ruta);
        $stmtAct -> bindParam(":tags", $tag);

        if ($stmtAct -> execute()) {
            echo '<script>
            alert("Actualizado");
            window.location.href = "platoprincipal.php";
            </script>';
        } else {
            echo '<script>
            alert("No se pudo Actualizar");
            window.location.href = "platoprincipal.php";
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
                                <h1 class="h4 text-gray-900 mb-4"><strong>Alta de Platos Principales</strong></h1>
                            </div>

                            <form class="user" action="platoprincipal.php" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="idPlato" value="<?php if(isset($_GET['modificar'])) echo $_GET['modificar']; else echo ''; ?>" class="form-control form-control-user">

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
                                        <?php foreach ($platoprincipal as $plato) : ?>
                                        <tr>
                                            <!-- <td class="text-center"><?php echo $plato['idPlato']; ?></td> -->
                                            <td class="text-center"><?php echo $plato['nombre']; ?></td>
                                            <td class="text-center">$<?php echo $plato['precio']; ?></td>
                                            <td class="text-center"><?php echo $plato['descripcion']; ?></td>
                                            <td class="text-center"><?php echo $plato['tags']; ?></td>
                                            <td><img src="<?php echo $plato['imagen']; ?>" alt="" width="100" height="100"></td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="platoprincipal.php?modificar=<?php echo $plato['idPlato']; ?>"><i class="fas fa-pencil-alt fa-1x icono-editar"></i></a> // 
                                                    <a href="platoprincipal.php?idPlato=<?php echo $plato['idPlato']; ?>"><i class="fas fa-trash fa-1x icono-basura"></i></a>
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


<script>
    const inputFiltro = document.getElementById('filtro');
        const tablaBody = document.getElementById('tabla-body');

        inputFiltro.addEventListener('input', filtrarElementos);

        function filtrarElementos() {
            const filtro = inputFiltro.value.toLowerCase();
            const filas = tablaBody.getElementsByTagName('tr');

            for (let i = 0; i < filas.length; i++) {
                const fila = filas[i];
                const celdas = fila.getElementsByTagName('td');

                let coincide = false;

                for (let j = 0; j < celdas.length; j++) {
                    const texto = celdas[j].textContent.toLowerCase();
                    if (texto.includes(filtro)) {
                        coincide = true;
                        break;
                    }
                }

                if (coincide) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            }
        }
</script>
<script src="../js/file.js"></script>
</body>
</html>