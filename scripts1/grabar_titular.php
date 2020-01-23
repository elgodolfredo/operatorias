<?php

$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';

// Validar los datos con php

try {
    include './conexion.inc.php';
    if (!$conexion) {
        $respuesta['mensaje'] = 'Sin conexion de datos';
        throw new Exception();
    }

    mysqli_autocommit($conexion, FALSE);
    $transaccion = @mysqli_query($conexion, 'BEGIN'); // Inicio una transaccion para actualizar varias tablas

    if (!$transaccion) {
        $respuesta['mensaje'] = 'No se puede iniciar la transaccion';
        throw new Exception();
    }

    extract($_POST);
    $query = "set nombre = '$nombre', apellido = '$apellido', nro_docu = '$nro_docu', domicilio = '$domicilio', id_localidad = $id_localidad, tel_fijo = '$tel_fijo', tel_laboral = '$tel_laboral', tel_celular = '$tel_celular', observaciones = '$observaciones', id_organismo = $id_organismo, legajo = '$legajo', ingresos = $ingresos";

    if ($id == '') {
        // nueva persona y titular
        $query = 'insert into personas ' . $query;
        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) {
            $respuesta['mensaje'] = $query; // 'No se pudo realizar la operación';
            throw new Exception();
        }
        $ultimo_id = mysqli_insert_id($conexion);

        $query = "insert into $tipo_persona set id_persona = $ultimo_id";
        if ($tipo_persona != 'titulares') {
            $query = $query . ", id_titular = $id_titular";
        }

        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) {
            $respuesta['mensaje'] = $query; // 'No se pudo realizar la operación';
            throw new Exception();
        }
    } else {
        $query = 'update personas ' . $query . " where id = $id_persona";
        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) {
            $respuesta['mensaje'] = $query; //'No se pudo realizar la actualizacion';
            throw new Exception();
        }
    }

    @mysqli_query($conexion, 'COMMIT');
    $respuesta['mensaje'] = 'Los datos se actualizaron correctamente';
    $respuesta['resultado'] = 'ok';
} catch (Exception $exc) {
    if ($transaccion) {
        @mysqli_query($conexion, 'ROLLBACK');
    }
}

$resultadosJson = json_encode($respuesta);
//echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
echo $resultadosJson;
?>
