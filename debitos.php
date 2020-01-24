<?php
set_include_path('scripts');
include 'funciones.inc.php';
include 'conexion.inc.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link rel="shortcut icon" href="favicon.ico">

        <script src="js/libs/jquery-3.1.1.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <script src="js/debitos.js"></script>

        <title>D&eacute;bitos</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div  class="navbar-collapse">
                <h2 class="text-white">D&eacute;bitos</h3></h2>
            </div>           
        </nav>
        <div class="container pt-5">
            <div>
                <form id="formDebitos" action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="mes">Mes</label>
                            <select id="mes" name="mes" class="form-control">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">junio</option>
                                <option value="7">julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="anio">A&ntilde;o</label>
                            <input type="number" id="anio" name="anio" class="form-control">
                            <span class="campo-invalido"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="org">Organismo</label>
                            <?php
                            generarOrganismos($conexion, "", "", "org", "");
                            ?>
                            <span class="campo-invalido"></span>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <div id = "btn-form">
                                <div class = "pt-3 clearfix">
                                    <button type="submit" id = "btn-enviar" class = "btn btn-primary float-right m-2">Enviar</button>
                                    <a href = "" id = "btn-cancelar" data-menu = "creditos" class = "btn btn-primary float-right m-2">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <?php
            if ($_POST['org']) {
                extract($_POST);
                $dia = "";
                $fechaIni = $anio . "-" . $mes . "-01";
                if ($mes == "2") {
                    $bisiesto = ($anio % 4 == 0 && (anio % 100 != 0 || anio % 400 == 0));
                    if ($bisiesto) {
                        $dia = 28;
                    } else {
                        $dia = 27;
                    }
                } elseif ($mes == "1" || $mes == "3" || $mes == "5" || $mes == "7" || $mes == "8" || $mes == "10" || $mes == "12") {
                    $dia = "31";
                } elseif ($mes == "4" || $mes == "6" || $mes == "9" || $mes == "11") {
                    $dia = "30";
                }
                $fechaFin = $anio . "-" . $mes . "-" . $dia;

                $consulta = "SELECT cuotas.nro_orden AS nroCuota, cuotas.monto, cuotas.gastos_adm AS gastosAdm, cuotas.seguro AS seg, cuotas.id_plan_de_pago AS idPlan, cuotas.id AS idCuota, cuotas.fecha_venc AS vcto, planes_de_pago.id_credito AS idCred, creditos.id_titular AS idTit, creditos.id_organismo AS idOrg, titulares.id_persona AS idPers, personas.legajo, personas.nro_docu AS dni FROM cuotas LEFT JOIN planes_de_pago ON (cuotas.id_plan_de_pago = planes_de_pago.id) LEFT JOIN creditos ON (planes_de_pago.id_credito = creditos.id) LEFT JOIN titulares ON (creditos.id_titular = titulares.id) LEFT JOIN personas ON (titulares.id_persona = personas.id) WHERE ((cuotas.fecha_venc >= '" . $fechaIni . "') AND (cuotas.fecha_venc <= '" . $fechaFin . "') AND (cuotas.fecha_pago IS NULL) AND (cuotas.id_forma_de_pago = 1) AND (personas.id_organismo = " . $org . "))";
                //SELECT * FROM cuotas WHERE ((fecha_venc >= '2016-6-01') AND (fecha_venc <= '2016-6-30') AND (fecha_pago IS NULL) AND (id_forma_de_pago = 1))    
                $resultado = @mysqli_query($conexion, $consulta);

                if (!$resultado) {
                    echo 'Error de conexi&oacute;n. Intente m&aacute;s tarde.' . $consulta;
                    exit;
                }
                $rutaArch = 'txtDebitos\debitos_' . date("d-m-Y") . '.txt';

                $tablaPl = '';
                if (mysqli_num_rows($resultado) <= 0) {
                    $tablaPl .= '<p>No hay cuotas</p>';
                } else {
                    $tablaPl .= '<div id = "tablaPlanes" class = "form-row text-center col-md-12 pt-5">'
                            . '<table class = "table table-responsive-sm  table-hover top20">'
                            . '<thead class="thead-dark">'
                            . '<tr>'
                            . '<th scope="col">Nº de Cuota</th>'
                            . '<th scope="col">Monto</th>'
                            . '<th scope="col">G.Adm</th>'
                            . '<th scope="col">Seg</th>'
                            . '<th scope="col">vcto</th>'
                            . '<th scope="col">DNI</th>'
                            . '<th scope="col">Legajo</th>'
                            . '<th scope="col">idOrg</th>'
                            . '</tr>'
                            . '</thead>'
                            . '<tbody id="listaTitularesOK">';



                    $archivo = fopen($rutaArch, "w");



                    while ($plan = mysqli_fetch_assoc($resultado)) {

                        fwrite($archivo, $plan['dni'] . " " . $plan['legajo'] . " " . $plan['idOrg'] . " " . $plan['vcto'] . " " . $plan['monto'] . " " . $plan['gastosAdm'] . " " . $plan['seg'] . PHP_EOL);

                        $tablaPl .= '<tr>' . '<td scope="col">' . $plan['nroCuota'] . '</td>'
                                . '<td scope="col">' . $plan['monto'] . '</td>'
                                . '<td scope="col">' . $plan['gastosAdm'] . '</td>'
                                . '<td scope="col">' . $plan['seg'] . '</td>'
                                . '<td scope="col">' . $plan['vcto'] . '</td>'
                                . '<td scope="col">' . $plan['dni'] . '</td>'
                                . '<td scope="col">' . $plan['legajo'] . '</td>'
                                . '<td scope="col">' . $plan['idOrg'] . '</td>'
                                . '</tr>';
                    }
                    $tablaPl .= '</tbody>'
                            . '<tr class="thead-dark">'
                            . '<td colspan="8">'
                            . '&nbsp;'
                            . '</td>'
                            . '</tr>'
                            . '</table>'
                            . '</div>';
                    fclose($archivo);
                }
                echo $tablaPl;
                echo "FechaInicio: $fechaIni </br>FechaFin: $fechaFin ";
            }
            ?>
        </div>
    </body>
</html>