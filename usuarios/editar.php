<?php
    include '../funciones.php';
    csrf();

    if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        die();
    }

    $config = include '../config.php';

    $resultado = [
        'error' => false,
        'mensaje' => ''
    ];

    if (!isset($_GET['id'])) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El usuario no existe';
    }

    if (isset($_POST['submit'])) {
        try {
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
            
            $usuario = [
                "id"=> $_GET['id'],
                "documento" => $_POST['documento'],
                "nombre"    => $_POST['nombre'],
                "apellidos"  => $_POST['apellidos'],
                "email"     => $_POST['email']
            ];
              
            $consultaSQL = "UPDATE usuarios SET
                documento = :documento,
                nombre = :nombre,
                apellidos = :apellidos,
                email = :email,
                f_actualizacion = NOW()
                WHERE id = :id";
                
            $consulta = $conexion->prepare($consultaSQL);
            $consulta->execute($usuario);
      
        } catch(PDOException $error) {
            $resultado['error'] = true;
            $resultado['mensaje'] = $error->getMessage();
        }
    }

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
            
        $id = $_GET['id'];
        $consultaSQL = "SELECT * FROM usuarios WHERE id =" . $id;

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el usuario';
    }

    } catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
?>

<?php include "../templates/header.php"; ?>

<?php
    if (!$resultado['error']) {
?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>

<?php
    if (isset($_POST['submit']) && $resultado['error']) {
?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    El usuario ha sido actualizado correctamente.
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>

<?php
    if (isset($usuario) && $usuario) {
?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-4">Editando el usuario <?= escapar($usuario['nombre']) . ' ' . escapar($usuario['apellidos'])  ?></h2>
                <hr>
                <form method="post">
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                    <div class="form-group p-1">
                        <label for="documento">Documento</label>
                        <input type="text" name="documento" id="documento" value="<?= escapar($usuario['documento']) ?>" class="form-control">
                    </div>
                    <div class="form-group p-1">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['nombre']) ?>" class="form-control">
                    </div>
                    <div class="form-group p-1">
                        <label for="apellidos">Apellido</label>
                        <input type="text" name="apellidos" id="apellidos" value="<?= escapar($usuario['apellidos']) ?>" class="form-control">
                    </div>
                    <div class="form-group p-1">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= escapar($usuario['email']) ?>" class="form-control">
                    </div>
                    <div class="form-group p-1">
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
                        <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    }
?>

<?php include "../templates/footer.php"; ?>