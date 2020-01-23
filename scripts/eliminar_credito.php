<?php

session_start();
$respuesta['msj'] = "";
$respuesta['resultado'] = 'error';
try {
    if (!isset($_POST['ctr'])) {
        throw new Exception('Error de autenticaci&oacute;n.');
    }
    include 'chequeos_ajax.inc.php';
    include 'cifrado.inc.php';

    if (!descrifrarCred($_POST['t'] . "ctrl" . $_POST['c'], $_POST['ctr'], "gxs5dq5r2")) {
        throw new Exception('Error de autenticaci&oacute;n.');
    }

    
    
    //      CÓDIGO DE ELIMINACIÓN
    
    
    
    $respuesta['msj'] = "El cr&eacute;dito fue eliminado con &eacute;xito.";
    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    $respuesta['msj'] = $ex->getMessage();
}

$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
?>