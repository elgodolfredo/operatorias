<?php

$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';
$respuesta['cuotas'] = array();

try {
    include 'conexion.inc.php';
    if (!$conexion) {
        $respuesta['mensaje'] = 'Sin conexion de datos';
        throw new Exception();
    }

    $id_plan = $_GET['id'];
    $consulta = "select * from (select @iValor := $id_plan i) lalala, `cuotas_full_by_plan`";
    //$consulta = "select * from cuotas where id_plan_de_pago = $id";
    $resultado = @mysqli_query($conexion, $consulta);
    if (!$resultado) {
        $respuesta['mensaje'] = 'Se produjo un error accediendo a las cuotas de este plan';
        throw new Exception();
    }

    while ($cuota = mysqli_fetch_assoc($resultado)) {
        $respuesta['cuotas'][] = $cuota;
    }

    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    //
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>