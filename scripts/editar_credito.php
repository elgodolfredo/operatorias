<?php

session_start();
$respuesta['msj'] = "";
$respuesta['resultado'] = 'error';
try {
    if (!isset($_POST['form'])) {
        throw new Exception('Error de autenticaci&oacute;n.');
    }
    include 'chequeos_ajax.inc.php';
    include 'cifrado.inc.php';
   
    extract($_POST);
    $query = "UPDATE creditos SET monto_total = $monto, id_operatoria = $idOper WHERE id = $cred";

    $resultado = @mysqli_query($conexion, $query);
    if (!$resultado) { 
        throw new Exception('No se pudo realizar la actualizaci&oacute;n');
    }
    $respuesta['msj'] = 'Los datos se actualizaron correctamente';
    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    $respuesta['msj'] = $ex->getMessage();
}

$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
?>