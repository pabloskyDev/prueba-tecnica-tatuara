<?php
    include '../config.php';
    include '../funciones.php';

    $config = include '../config.php';
    $db = $config['db'];
    $dbConn =  connect($db);
    
    // listar todos los usuarios o solo uno.
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if (isset($_GET['id']))
        {
            //Mostrar un usuario
            $sql = $dbConn->prepare("SELECT * FROM usuarios WHERE id=:id");
            $sql->bindValue(':id', $_GET['id']);
            $sql->execute();
            header("HTTP/1.1 200 OK");
            echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
            exit();
        }
        else {
            //Mostrar lista de usuarios
            $sql = $dbConn->prepare("SELECT * FROM usuarios");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode( $sql->fetchAll()  );
            exit();
        }
    }

    // Crear un nuevo usuario
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $input = $_POST;
        $sql = "INSERT INTO usuarios
            (documento, nombre, apellidos, email)
            VALUES
            (:documento, :nombre, :apellidos, :email)";
        $statement = $dbConn->prepare($sql);
        bindAllValues($statement, $input);
        $statement->execute();
        
        $usuarioId = $dbConn->lastInsertId();
        if($usuarioId)
        {
            $input['id'] = $usuarioId;
            header("HTTP/1.1 200 OK");
            echo json_encode($input);
            exit();
        }else{
            header("HTTP/1.1 404 Not found");
            exit();
        }
    }

    //Borrar
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        $id = $_GET['id'];
        $statement = $dbConn->prepare("DELETE FROM usuarios WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();

        $deleted = $statement->rowCount();
        if($deleted > 0){
            header("HTTP/1.1 200 OK");
            echo json_encode('eliminado exitosamente');
            exit();
        }else {
            header("HTTP/1.1 404 Not found");
        }
        exit();
    }

    //Actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $input = $_POST;
        $usuarioId = $input['id'];
        $fields = getParams($input);
        $sql = "
            UPDATE usuarios
            SET $fields, f_actualizacion = NOW()
            WHERE id='$usuarioId'
            ";
        $statement = $dbConn->prepare($sql);
        bindAllValues($statement, $input);
        $statement->execute();

        $updated = $statement->rowCount();
        if($updated > 0){
            header("HTTP/1.1 200 OK");
            echo json_encode('actualizado exitosamente');
            exit();
        }else {
            header("HTTP/1.1 404 Not found");
        }
        exit();
    }

    //En caso de que ninguna de las opciones anteriores se haya ejecutado
    header("HTTP/1.1 400 Bad Request");

?>