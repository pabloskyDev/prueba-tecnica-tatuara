<?php

function escapar($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function csrf() {

    session_start();
  
    if (empty($_SESSION['csrf'])) {
        if (function_exists('random_bytes')) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        } else {
            $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
}

// Funciones creadas para crear una API con todos sus métodos

//Abrir conexion a la base de datos
function connect($db)
{
    try {
        $conn = new PDO(
            "mysql:host={$db['host']};
            dbname={$db['name']};
            charset=utf8", $db['user'], $db['pass']);
        // $conn = new PDO("mysql:host=localhost;dbname=tuatara_test", "root", "root");
        // error_log(print_r($db, true));

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $exception) {
        exit($exception->getMessage());
    }
}

//Obtener parametros para updates
function getParams($input)
{
   $filterParams = [];
   foreach($input as $param => $value)
   {
        $filterParams[] = "$param=:$param";
   }
   return implode(", ", $filterParams);
}

//Asociar todos los parametros a un sql
function bindAllValues($statement, $params)
{
    foreach($params as $param => $value)
    {
        $statement->bindValue(':'.$param, $value);
    }
    return $statement;
}

?>