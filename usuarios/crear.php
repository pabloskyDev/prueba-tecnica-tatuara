<?php
    include '../funciones.php';

    if (isset($_POST['submit'])) {
        
        $resultado = [
            'error' => false,
            'mensaje' => 'El usuario ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
        ];
        $config = include '../config.php';
        
        try {
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        
            $usuario = [
                "documento" =>  $_POST['documento'],
                "nombre" =>     $_POST['nombre'],
                "apellidos" =>  $_POST['apellidos'],
                "email" =>      $_POST['email'],
            ];

            $consultaSQL = "INSERT INTO usuarios (documento, nombre, apellidos, email)";
            $consultaSQL .= "values (:" . implode(", :", array_keys($usuario)) . ")";

            $sentencia = $conexion-> prepare($consultaSQL);
            $sentencia->execute($usuario);
    
        } catch(PDOException $error) {
            $resultado['error'] = true;
            $resultado['mensaje'] = $error->getMessage();
        }
    }
?>

<?php include "../templates/header.php"; ?>

<?php
    if(isset($resultado)) {
?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                <?= $resultado['mensaje'] ?>
            </div>
            </div>
        </div>
    </div>
<?php
    }
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Crea un usuario</h2>
            <hr>
            <form method="post">
                <div class="form-group p-1">
                    <label for="documento">Documento</label>
                    <input type="text" name="documento" id="documento" class="form-control">
                </div>
                <div class="form-group p-1">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>
                <div class="form-group p-1">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control">
                </div>
                <div class="form-group p-1">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group mt-4">
                    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
                    <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../templates/footer.php"; ?>