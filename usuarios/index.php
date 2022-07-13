<?php
    include '../funciones.php';
    csrf();

    if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        die();
    }

    $error = false;
    $config = include '../config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        if (isset($_POST['filtro'])) {
            $consultaSQL = "SELECT * FROM usuarios WHERE CONCAT(nombre, ' ' ,apellidos) LIKE '%" . $_POST['filtro'] . "%'";
        } else {
            $consultaSQL = "SELECT * FROM usuarios";
        }

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $usuarios = $sentencia->fetchAll();

    } catch(PDOException $error) {
        $error = $error->getMessage();
    }

    $titulo = isset($_POST['filtro']) ? 'Lista de usuarios (' . $_POST['filtro'] . ')' : 'Lista de usuarios';
?>

<?php include "../templates/header.php"; ?>

<?php
    if ($error) {
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
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
            <a href="crear.php" class="btn btn-primary mt-4">Crear usuario</a>
            <hr>
            <form method="post" class="form-inline">
                <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                <div class="form-group mr-3">
                    <input type="text" id="filtro" name="filtro" placeholder="Buscar por apellido" class="form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-primary mt-1">Ver resultados</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3"><?= $titulo ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($usuarios && $sentencia->rowCount() > 0) {
                        foreach ($usuarios as $fila) {
                        ?>
                        <tr>
                            <td><?php echo escapar($fila["documento"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td><?php echo escapar($fila["apellidos"]); ?></td>
                            <td><?php echo escapar($fila["email"]); ?></td>
                            <td>
                                <a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                                <a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>">✏️Editar</a>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../templates/footer.php"; ?>