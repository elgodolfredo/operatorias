<?php
    $path = '/operatorias';

//function generarSelectAnios($inicio, $fin, $nombre = 'anio') {
//    echo "<select name='$nombre'>";
//    for ($anio = $inicio; $anio <= $fin; $anio++) {
//        if ($anio != $fin) {
//            echo "<option value='$anio'>$anio</option>";
//        } else {
//            echo "<option value='$anio' selected='selected'>$anio</option>";
//        }
//    }
//    echo '</select>';
//}

//function generarSelectMeses() {

//    echo '<select id="mes" name="mes">
//                            <option value="1">Enero</option>
//                            <option value="2">Febrero</option>
//                            <option value="3">Marzo</option>
//                            <option value="4">Abril</option>
//                            <option value="5">Mayo</option>
//                            <option value="6">Junio</option>
//                            <option value="7">Julio</option>
//                            <option value="8">Agosto</option>
//                            <option value="9">Septiembre</option>
//                            <option value="10">Octubre</option>
//                            <option value="11">Noviembre</option>
//                            <option value="12">Diciembre</option>                              
//         </select>';
//}

//function generarSelectOperatorias($linkDB, $id_operatoria = 0) {
//    $operatorias = $linkDB->query("select * from operatorias order by nombre");
//    echo '<select id="id_operatoria" name="id_operatoria" class="form-control">';
//    echo '<option value="0">Operatoria</option>';
//
//    if ($operatorias->num_rows > 0) {
//        while ($ope = $operatorias->fetch_assoc()) {
//            $marcado = '';
//            if ($ope['id'] == $id_operatoria) {
//                $marcado = 'selected="selected"';
//            }
//            echo "<option $marcado value='" . $ope['id'] . "'>" . $ope['nombre'] . '</option>';
//        }
//        $operatorias->free();
//    }
//    echo '</select>';
//}

//function generarOrganismos($linkDB, $id_organismo = 0) {
//    $organismos = $linkDB->query("select * from organismos order by nombre");
//    echo '<select id="id_organismo" name="id_organismo" class="form-control">';
//    echo '<option value="0">Organismo</option>';
//
//    if ($organismos->num_rows > 0) {
//        // Mientras haya un departamento mas
//        while ($org = $organismos->fetch_assoc()) {
//            $marcado = '';
//            if ($org['id'] == $id_organismo) {
//                $marcado = 'selected="selected"';
//            }
//            echo "<option $marcado value='" . $org['id'] . "'>" . $org['nombre'] . '</option>';
//        }
//        $organismos->free();
//    }
//    echo '</select>';
//}

//function generarDepartamentos($linkDB, $id_dpto = 0) {
//    $dptos = $linkDB->query("select id, nombre from departamentos order by nombre");
//
//    // Voy imprimiendo el primer select compuesto por los departamentos
//    echo "<select name='id_dpto' id='id_dpto' class='form-control'>";
//    //echo "<option value='0'>Seleccione una opci&oacute;n...</option>";
//    echo "<option value='0'>Departamento</option>";
//
//    if ($dptos->num_rows > 0) {
//        // Mientras haya un departamento mas
//        while ($dpto = $dptos->fetch_assoc()) {
//            $marcado = '';
//            if ($dpto['id'] == $id_dpto) {
//                $marcado = "selected='selected'";
//            }
//            echo "<option $marcado value='" . $dpto['id'] . "'>" . $dpto['nombre'] . "</option>";
//        }
//        $dptos->free();
//    }
//    echo "</select>";
//}

//function generarLocalidales($linkDB, $id_dpto = 0, $id_localidad = 0) {
    //if (($id_dpto) && ($id_localidad)) {
//    $localidades = $linkDB->query("select * from localidades where id_dpto = $id_dpto order by nombre");
//    echo "<select name='id_localidad' id='id_localidad' >";
//    //echo "<option value='0'>Selecciona opci&oacute;n...</option>";
//    echo "<option value='0'>Localidad</option>";
//    if ($localidades->num_rows > 0) {
//        while ($loca = $localidades->fetch_assoc()) {
//            $marcado = '';
//            if ($loca['id'] == $id_localidad) {
//                $marcado = "selected = 'selected'";
//            }
//            echo "<option $marcado value='" . $loca['id'] . "'>" . $loca['nombre'] . "</option>";
//        }
//        $localidades->free();
//    }
//    echo '</select>';
    //}
//}

//function cargarConfiguracion($linkDB) {
//    // Esta funcion obtiene la configuracion almacenada en la tabla config y los almacena en una variable de session
//    $config = mysqli_query($linkDB, "select * from config");
//    $_SESSION['config'] = mysqli_fetch_assoc($config);
//
//    // Almaceno la configuracion en la sesion local
//    $salida = '<script type="text/javascript">';
//    foreach ($_SESSION['config'] as $clave => $valor) {
//        $salida .= ' sessionStorage.' . $clave . '=' . $valor . ';';
//    }
//    $salida .= '</script>';
//
//    return $salida;
//    return 1;
//}
?>