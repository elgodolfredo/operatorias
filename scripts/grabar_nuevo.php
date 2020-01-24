<?php

session_start();

try {
    include 'chequeos_ajax.inc.php';
    $respuesta['resultado'] = 'error';

    mysqli_autocommit($conexion, FALSE);
    $transaccion = @mysqli_query($conexion, 'BEGIN'); // Inicio una transaccion para actualizar varias tablas	

    if (!$transaccion) {
        throw new Exception('No se puede iniciar la transaccion');
    }
    extract($_POST);
    //Agregamos el titular en personas
    $query = "INSERT INTO personas SET nombre = '$nomTit', apellido = '$apeTit', nro_docu = '$dniTit', domicilio = '$domTit', id_localidad = $idLocTit, tel_fijo = '$telFTit', tel_laboral = '$telLTit', tel_celular = '$telCTit', observaciones = '$obsTit', id_organismo = $idOrgTit, legajo = '$legTit', ingresos = $ingTit";
    $resultado = @mysqli_query($conexion, $query);
    if (!$resultado) {
        throw new Exception('No se pudo realizar la operaci&oacute;n. Error al agregar titular' . $query);
    }
    $ultimo_id = mysqli_insert_id($conexion);
    //Le damos de alta como titular
    $query = "INSERT INTO titulares set id_persona = $ultimo_id";

    $resultado = @mysqli_query($conexion, $query);
    if (!$resultado) { //'No se pudo realizar la actualizacion';
        throw new Exception('No se pudo realizar la operaci&oacute;n. Error al agregar titular en personas');
    }
    $ultimo_id_tit = mysqli_insert_id($conexion);
    if (isset($_POST['nomCot'])) {
        //Agregamos el cotitular en personas
        $query = "INSERT INTO personas SET nombre = '$nomCot', apellido = '$apeCot', nro_docu = '$dniCot', domicilio = '$domCot', id_localidad = $idLocCot, tel_fijo = '$telFCot', tel_laboral = '$telLCot', tel_celular = '$telCCot', observaciones = '$obsCot', id_organismo = $idOrgCot, legajo = '$legCot', ingresos = $ingCot";
        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) {
            throw new Exception('No se pudo realizar la operaci&oacute;n. Error al agregar cotitular');
        }
        $ultimo_id = mysqli_insert_id($conexion);
        //Le damos de alta como cotitular
        $query = "INSERT INTO cotitulares set id_persona = $ultimo_id, id_titular = $ultimo_id_tit";

        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) { //'No se pudo realizar la actualizacion';
            throw new Exception('No se pudo realizar la operaci&oacute;n. Error al agregar cotitular en personas');
        }
    }

    if (isset($_POST['nomGar'])) {
        //Agregamos el garante en personas
        $query = "INSERT INTO personas SET nombre = '$nomGar', apellido = '$apeGar', nro_docu = '$dniGar', domicilio = '$domGar', id_localidad = $idLocGar, tel_fijo = '$telFGar', tel_laboral = '$telLGar', tel_celular = '$telCGar', observaciones = '$obsGar', id_organismo = $idOrgGar, legajo = '$legGar', ingresos = $ingGar";
        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) {
            throw new Exception('No se pudo realizar la operaci&oacute;n. Error al agregar garante');
        }
        $ultimo_id = mysqli_insert_id($conexion);
        //Le damos de alta como garante
        $query = "INSERT INTO garantes set id_persona = $ultimo_id, id_titular = $ultimo_id_tit";

        $resultado = @mysqli_query($conexion, $query);
        if (!$resultado) { //'No se pudo realizar la actualizacion';
            throw new Exception('No se pudo realizar la operaci&oacute;n. Error al agregar garante en personas');
        }
    }

    $query = "insert into creditos set id_titular = $ultimo_id_tit, monto_total = $monto, id_operatoria = $idOper";
    $resultado = @mysqli_query($conexion, $query);
    if (!$resultado) {
        $respuesta['mensaje'] = 'No se pudo realizar la operación. Error al agregar cr&eacute;dito';
        throw new Exception();
    }

    if (isset($_POST['cantCuotas'])) {
        //Agregar plan
        $ultimo_id = mysqli_insert_id($conexion);
        $consulta = "insert into planes_de_pago set id_credito = $ultimo_id, monto = $monto, gastos_adm = $gastosAdmin, pje_interes_punitorio = $ipn, cantidad_cuotas = $cantCuotas, nro_plan = 0";
        $resultado = @mysqli_query($conexion, $consulta);
        if (!$resultado) {
            throw new Exception('No se pudo crear el plan de pago' . $consulta);
        }
        // Ahora se deben crear las cuotas del plan
        $ultimo_id = mysqli_insert_id($conexion);

        // Calculo el monto de la cuota (pura)
        $montoCuota = $monto / $cantCuotas;

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
                throw new Exception('Error generando las cuotas. No se creo el plan de pagos' . $consulta);
            }
        }
    }

    @mysqli_query($conexion, 'COMMIT');
    $respuesta['msj'] = 'El crédito se ha creado correctamente';
    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    $respuesta['msj'] = $ex->getMessage();
}

$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
