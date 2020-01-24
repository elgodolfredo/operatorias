<?php

$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';

// Validar los datos con php //

try {
    include 'conexion.inc.php';
    if (!$conexion) {
        $respuesta['mensaje'] = 'Sin conexion de datos';
        throw new Exception();
    }

    mysqli_autocommit($conexion, FALSE);
    $transaccion = @mysqli_query($conexion, 'begin');

    if (!$transaccion) {
        $respuesta['mensaje'] = 'No se pudo inciar una transaccion';
        throw new Exception();
    }

    extract($_GET);
    $consulta = "insert into planes_de_pago set id_credito = $id_credito, monto = $monto, gastos_adm = $gastos_adm, pje_interes_punitorio = $pje_interes_punitorio, cantidad_cuotas = $cantidad_cuotas";

    $resultado = @mysqli_query($conexion, $consulta);
    if (!$resultado) {
        $respuesta['mensaje'] = $query; //'No se pudo crear el plan de pago';
        throw new Exception();
    }

    // Ahora se deben crear las cuotas del plan
    $ultimo_id = mysqli_insert_id($conexion);

    // Calculo el monto de la cuota (pura)
    $monto_cuota = $monto / $cantidad_cuotas;
    
    // Calculo los gastos administrativos por cuota
    $gastos_adm_cuota = $gastos_adm / $cantidad_cuotas; 
    

    // Ahora se debe insertar un registro para cada cuota del plan de pago
    for ($i = 0; $i < $cantidad_cuotas; $i++) {
        if ($i == 0) {
            $fecha_venc = $fecha_primer_venc;
        } else {
            // Determinar la fecha del siguiente mes
            $fecha_venc = explode('-', $fecha_venc);
            if ((int)$fecha_venc[1] >= 12) {
                // Si el mes es mayor a 12, lo seteo a 1
                $fecha_venc[1] = 1;

                // Tambien aumento el año en una unidad
                $fecha_venc[0]++;
            } else {
                $fecha_venc[1] = $fecha_venc[1] + 1;
            }

            // Armo el string con el formato de fecha
            $fecha_venc = implode('-', $fecha_venc);
        }

        $consulta = "insert into cuotas set id_plan_de_pago = $ultimo_id, nro_orden = ($i + 1), fecha_venc = '$fecha_venc', monto = $monto_cuota, gastos_adm = $gastos_adm_cuota, seguro = $monto_seguro, id_forma_de_pago = $id_forma_de_pago";
        $resultado = @mysqli_query($conexion, $consulta);
        if (!$resultado) {
            $respuesta['mensaje'] = 'Error generando las cuotas. No se creo el plan de pagos';
            echo $consulta;
            throw new Exception();
        }
    }    

    mysqli_query($conexion, 'commit');
    $respuesta['mensaje'] = 'El plan de pagos se creo correctamente';
    $respuesta['resultado'] = 'ok';
} catch (Exception $exc) {
    if ($transaccion) {
        mysqli_query($conexion, 'rollback');
    }
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>