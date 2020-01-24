<?php

// Este archivo se ejecuta con ajax enviandole id_dpto por post
//include('mainFunctions.inc.php');
$respuesta = array();
$respuesta['localidades'] = array();

include 'conexion.inc.php';

$consulta = "select id, nombre from localidades where id_dpto = " . $_GET['id_dpto'];
$localidades = @mysqli_query($conexion, $consulta);

if ($localidades) {
    if (mysqli_num_rows($localidades) > 0) {
        while ($loca = mysqli_fetch_assoc($localidades)) {
            $respuesta['localidades'][] = $loca;
        }
    }
    $resultadosJson = json_encode($respuesta);
    //echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
    echo $resultadosJson;
} else {
    echo 'error';
}

?>

