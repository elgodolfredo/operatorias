<?php

session_start();

/* crea un array con datos que seran enviados de vuelta a la aplicacion */
$respuesta = array();
$respuesta['resultado'] = 'error';
try {
    if (!isset($_POST['dni'])) {
        throw new Exception('Error de autenticaci&oacute;n.');
    }
    // Verifica la sesión y la conexión
    include 'chequeos_ajax.inc.php';

    if ($_POST['dni'] == '') {
        throw new Exception('Debe ingresar un valor de b&uacute;squeda.');
    }

    $dniTit = $_POST['dni'];

    $consulta = "select creditos_full.id, concat(apellido, ', ', creditos_full.nombre) as persona, nro_docu, monto_total, saldo, operatorias.pje_interes_punitorio as int_pun, operatorias.seguro, operatorias.nombre as operatoria from creditos_full inner join operatorias on (creditos_full.id_operatoria = operatorias.id) where nro_docu like '%$dniTit%'";
    $resultado = @mysqli_query($conexion, $consulta);

    if (!$resultado) {
        throw new Exception('Error de conexi&oacute;n. Intente m&aacute;s tarde.');
    }

    if (mysqli_num_rows($resultado) <= 0) {
        throw new Exception('No se encontraron resultados para el valor ingresado.');
    }

    include 'funciones.inc.php';

    $tabla = '
              <h2>Cr&eacute;ditosaaa</h2>
              <hr>
    ';

    $tabla = "<div class='table-responsive-sm'>
                <table id='listadoCreditos' class='table table-hover top20 text-center'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>N&deg; Cred</th>
                            <th>Titular</th>
                            <th>DNI Titular</th>
                            <th>Operatoria</th>
                            <th>Monto Total</th>
                            <th>Saldo</th>
                            <th>% Int. Adm.</th>
                            <th>Seguro</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
    while ($credito = mysqli_fetch_assoc($resultado)) {
        $tabla = $tabla . "<tr>
                                <td>" . $credito['id'] . "</td>
                                <td>" . $credito['persona'] . "</td>
                                <td>" . $credito['nro_docu'] . "</td>
                                <td>" . $credito['operatoria'] . "</td>
                                <td>" . formatearMoneda($credito['monto_total']) . "</td>
                                <td>" . formatearMoneda($credito['saldo']) . "</td>
                                <td>" . formatearMoneda($credito['int_pun']) . "</td>
                                <td>" . formatearMoneda($credito['seguro']) . "</td>
                                <td><a href='' id='btn-ver-credito' data-menu='ver' data-dni='" . $credito['nro_docu'] . "' class='btn btn-primary'>Ver</a></td>
                            </tr>";
    }
    $tabla = $tabla . "</tbody></table></div>";
    $respuesta['list'] = $tabla;

    $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
    $respuesta['msj'] = $ex->getMessage();
}

$resultadosJson = json_encode($respuesta);
echo $resultadosJson;
