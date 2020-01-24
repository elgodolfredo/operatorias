<?php

session_start();
try {
    include 'chequeos_ajax.inc.php';
    $respuesta['resultado'] = 'error';

    mysqli_autocommit($conexion, FALSE);
    $transaccion = @mysqli_query($conexion, 'begin');

    if (!$transaccion) {
        throw new Exception('No se pudo inciar una transacci&oacute;n');
    }
    extract($_POST);
    $consulta = "select max(nro_plan) AS nroPlan from planes_de_pago where id_credito = $cdt";
    $resultado = @mysqli_query($conexion, $consulta);
    if (!$resultado) {
        throw new Exception('No se pudo crear el plan de pago' . $consulta);
    }
    $max = mysqli_fetch_assoc($resultado);
    $nroPlan = $max['nroPlan'] + 1;

    $consulta = "insert into planes_de_pago set id_credito = $cdt, monto = $mnt, gastos_adm = $gastosAdmin, pje_interes_punitorio = $ipn, cantidad_cuotas = $cantCuotas, nro_plan = $nroPlan";
    $resultado = @mysqli_query($conexion, $consulta);
    if (!$resultado) {
        throw new Exception('No se pudo crear el plan de pago');
    }

    // Ahora se deben crear las cuotas del plan
    $ultimo_id = mysqli_insert_id($conexion);

    // Calculo el monto de la cuota (pura)
    $montoCuota = $mnt / $cantCuotas;

    // Calculo los gastos administrativos por cuota
    $gastosAdmCuota = $gastosAdmin / $cantCuotas;

    //cambio formato de fecha de dd/mm/aaaa a aaaa-mm-dd
    $fechaVenc = implode('-', array_reverse(explode('/', $primerVenc)));

    // Ahora se debe insertar un registro para cada cuota del plan de pago
    for ($i = 0; $i < $cantCuotas; $i++) {

        if ($i != 0) {
            // Determinar la fecha del siguiente mes
            $fechaVenc = explode('-', $fechaVenc);
            if ((int) $fechaVenc[1] >= 12) {
                // Si el mes es mayor a 12, lo seteo a 1
                $fechaVenc[1] = 1;

                // Tambien aumento el año en una unidad
                $fechaVenc[0] ++;
            } else {
                $fechaVenc[1] = $fechaVenc[1] + 1;
            }
            // Armo el string con el formato de fecha
            $fechaVenc = implode('-', $fechaVenc);
        }
        $consulta = "insert into cuotas set id_plan_de_pago = $ultimo_id, nro_orden = ($i + 1), fecha_venc = '$fechaVenc', monto = $montoCuota, gastos_adm = $gastosAdmCuota, seguro = $seg, id_forma_de_pago = $formaPago";
        $resultado = @mysqli_query($conexion, $consulta);
        if (!$resultado) {
            throw new Exception('Error generando las cuotas. No se creo el plan de pagos');
        }
    }

    mysqli_query($conexion, 'commit');
    $respuesta['msj'] = 'El plan de pagos se cre&oacute;ditos se ha creado correctamente';
    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    if ($transaccion) {
        @mysqli_query($conexion, 'ROLLBACK');
    }
    $respuesta['msj'] = $ex->getMessage();
}

$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
