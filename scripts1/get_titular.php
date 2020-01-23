<?php

/* crea un array con datos que seran enviados de vuelta a la aplicacion */
$respuesta = array();

try {
    include 'conexion.inc.php';

    if (!$conexion) {
        throw new Exception();
    }

    $id = $_GET['id'];
    $tipo_persona = $_GET['tipo_persona'];
    $vista = $tipo_persona . '_full';

    $consulta = "select * from $vista where id = $id";
    $resultado = @mysqli_query($conexion, $consulta);

    if (!$resultado) {
        throw new Exception();
    }

    $titular = mysqli_fetch_assoc($resultado);

    $respuesta = $titular;
    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    $respuesta['resultado'] = 'error';
}

echo json_encode($respuesta);
?>