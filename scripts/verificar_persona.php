<?php

session_start();
include 'chequeos_ajax.inc.php';
$respuesta['resultado'] = 'error';
$respuesta['msj'] = "";
$respuesta['res'] = 0;

try {
    if (isset($_POST['tipo'])) {
        
    }
} catch (Exception $ex) {
    $respuesta['msj'] = $ex->getMessage();
}


$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
?>