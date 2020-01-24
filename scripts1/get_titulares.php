<?php

/* crea un array con datos que seran enviados de vuelta a la aplicacion */
$respuesta              = array();
$respuesta['items']     = array();
$respuesta['resultado'] = 'ok';
$respuesta['mensaje']   = '';

try {
    include 'conexion.inc.php';

    if (!$conexion) {
        throw new Exception();
    }

    $tipo_persona = $_GET['tipo_persona'];
    $vista = $tipo_persona . '_full';

    $consulta = "select * from $vista order by id";
    $resultado = @mysqli_query($conexion, $consulta);

    if (!$resultado) {
        throw new Exception();
    }

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $respuesta['items'][] = $fila;
    } 
} catch (Exception $ex) {
    $respuesta['Se produjo un error inesperado'];
    $respuesta['resultado'] = 'error';
}

echo json_encode($respuesta);
?>