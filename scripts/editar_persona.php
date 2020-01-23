<?php

session_start();
$respuesta['msj'] = "";
$respuesta['resultado'] = 'error';
try {
    if (!isset($_POST['form'])) {
        throw new Exception('Error de autenticaci&oacute;n.');
    }
    include 'chequeos_ajax.inc.php';
    mysqli_autocommit($conexion, FALSE);
    $transaccion = @mysqli_query($conexion, 'BEGIN'); // Inicio una transaccion para actualizar varias tablas

    if (!$transaccion) {
        throw new Exception('No se puede iniciar la transaccion');
    }
    extract($_POST);
    $query = "SET nombre = '$nom', apellido = '$ape', nro_docu = '$dni', domicilio = '$dom', id_localidad = $idLoc, tel_fijo = '$telF', tel_laboral = '$telL', tel_celular = '$telC', observaciones = '$obs', id_organismo = $idOrg, legajo = '$leg', ingresos = $ing";
    //Si id viene vacío es porque es nuevo (cotitular o garante). Se hace un INSERT
    if ($id == '') {
        $tipo_persona = ($form == 'co') ? 'cotitulares' : 'garantes';
        $query = 'INSERT INTO personas ' . $query;
        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) {
            throw new Exception('No se pudo realizar la operaci&oacute;n');
        }
        $ultimo_id = mysqli_insert_id($conexion);

        $query = "INSERT INTO $tipo_persona set id_persona = $ultimo_id, id_titular = $idTit";
    } else {// si no viene vacío es un UPDATE, puede ser titular, cotitular o garante
        $query = "UPDATE personas " . $query . " WHERE id = $id";
    }

    $resultado = @mysqli_query($conexion, $query);
    if (!$resultado) { //'No se pudo realizar la actualizacion';
        throw new Exception('No se pudo realizar la actualizaci&oacute;n');
    }
    @mysqli_query($conexion, 'COMMIT');
    $respuesta['msj'] = 'Los datos se actualizaron correctamente';
    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    if ($transaccion) {
        @mysqli_query($conexion, 'ROLLBACK');
    }
    $respuesta['msj'] = $ex->getMessage();
}

$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
?>