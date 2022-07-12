<?php
    // error_log(print_r($_POST, true));
    if (isset($_POST['submit'])) {
        
        $resultado = [
            'error' => false,
            'mensaje' => 'Usuario agregado con éxito'
        ];
          
          $config = include 'config.php';
        
        try {
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        
            // Código que insertará un usuario
    
        } catch(PDOException $error) {
            $resultado['error'] = true;
            $resultado['mensaje'] = $error->getMessage();
        }
    }
?>

<?php include "../templates/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Crea un usuario</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <input type="text" name="documento" id="documento" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nombre_completo">Nombre completo</label>
                    <input type="text" name="nombre_completo" id="nombre_completo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control">
                </div>
                <div class="form-group">
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