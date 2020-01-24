<?php
$path = '/operatorias';

/*function cifrar($p) {
    return sha1(md5($p));
}*/

//function urls_amigables($url) {
//      /*
//      Necesitamos limpiar �stas direcciones de car�cteres inv�lidos como las t�ldes, e�es y dem�s car�cteres especiales.
//      Esta funci�n la usaremos a la hora de crear los enlaces en nuestra p�gina web, para evitar posibles problemas.
//      */
//
//      // Tranformamos todo a minusculas
//      $url = strtolower($url);
//
//      //Rememplazamos caracteres especiales latinos
//      $find = array('�', '�', '�', '�', '�', '�');
//      $repl = array('a', 'e', 'i', 'o', 'u', 'n');
//      $url = str_replace ($find, $repl, $url);
//
//      // A�adimos los guiones
//      $find = array(' ', '&', '\r\n', '\n', '+');
//      $url = str_replace ($find, '-', $url);
//
//      // Eliminamos y Reemplazamos otros car�cteres especiales
//      $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
//      $repl = array('', '-', '');
//      $url = preg_replace ($find, $repl, $url);
//
//      return $url;
//}

function generarSelectAnios($inicio, $fin, $nombre = 'anio') {
    echo "<select name='$nombre' class='form-control'>";
    for ($anio = $inicio; $anio <= $fin; $anio++) {
        if ($anio != $fin) {
            echo "<option value='$anio'>$anio</option>";
        } else {
            echo "<option value='$anio' selected='selected'>$anio</option>";
        }
    }
    echo '</select>';
}

function generarSelectMeses() {

    echo '<select id="mes" name="mes" class="form-control">
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>                              
    </select>';
}

function generarSelectOperatorias($linkDB, $id_operatoria, $dis) {
    $operatorias = $linkDB->query("select * from operatorias order by nombre");
    echo '<select id="idOper" name="idOper" class="form-control" '.$dis.'>';
    echo '<option value="" data-pip="">Operatoria</option>';

    if ($operatorias->num_rows > 0) {
        while ($ope = $operatorias->fetch_assoc()) {
            $marcado = '';
            if ($ope['id'] == $id_operatoria) {
                $marcado = 'selected="selected"';
            }
            echo "<option $marcado value='" . $ope['id'] . "' data-pip='" . $ope['pje_interes_punitorio'] . "'>" . $ope['nombre'] . '</option>';
        }
        $operatorias->free();
    }
    echo '</select>';
}

function generarOrganismos($linkDB, $id_organismo, $dis, $name, $pers) {
    $organismos = $linkDB->query("select * from organismos order by nombre");
    echo '<select id="'.$name.$pers.'" name="'.$name.'" class="form-control" '.$dis.'>';
    echo '<option value="">Organismo</option>';

    if ($organismos->num_rows > 0) {
        // Mientras haya un departamento mas
        while ($org = $organismos->fetch_assoc()) {
            $marcado = '';
            if ($org['id'] == $id_organismo) {
                $marcado = 'selected="selected"';
            }
            echo "<option $marcado value='" . $org['id'] . "'>" . $org['nombre'] . '</option>';
        }
        $organismos->free();
    }
    echo '</select>';
}

function generarDepartamentos($linkDB, $id_dpto, $dis, $name, $pers) {
    $dptos = $linkDB->query("select id, nombre from departamentos order by nombre");
    // Voy imprimiendo el primer select compuesto por los departamentos
    echo '<select name="'.$name.'" id="'.$name.$pers.'" class="form-control" '.$dis.'>';
    //echo "<option value='0'>Seleccione una opci&oacute;n...</option>";
    echo '<option value="">Departamento</option>';

    if ($dptos->num_rows > 0) {
        // Mientras haya un departamento mas
        while ($dpto = $dptos->fetch_assoc()) {
            $marcado = '';
            if ($dpto['id'] == $id_dpto) {
                $marcado = 'selected="selected" ';
            }
            echo "<option $marcado value='" . $dpto['id'] . "'>" . $dpto['nombre'] . "</option>";
        }
        $dptos->free();
    }
    echo '</select>';
}

function generarLocalidades($linkDB, $id_dpto, $id_localidad, $dis, $name, $pers) {
    //if (($id_dpto) && ($id_localidad)) {
    $localidades = $linkDB->query("select * from localidades where id_dpto = $id_dpto order by nombre");
    echo '<select name="'.$name.'" id="'.$name.$pers.'" class="form-control" '.$dis.'>';
    //echo "<option value='0'>Selecciona opci&oacute;n...</option>";
    echo '<option value="">Localidad</option>';
    if ($localidades->num_rows > 0) {
        while ($loca = $localidades->fetch_assoc()) {
            $marcado = '';
            if ($loca['id'] == $id_localidad) {
                $marcado = 'selected = "selected"';
            }
            echo "<option $marcado value='" . $loca['id'] . "'>" . $loca['nombre'] . "</option>";
        }
        $localidades->free();
    }
    echo '</select>';
    //}
}

function cargarConfiguracion($conexion) {
    // Esta funcion obtiene la configuracion almacenada en la tabla config y los almacena en una variable de session
    $config = mysqli_query($conexion, "select * from config");
    $_SESSION['config'] = mysqli_fetch_assoc($config);

    // Almaceno la configuracion en la sesion local
    $salida = '<script type="text/javascript">';
    foreach ($_SESSION['config'] as $clave => $valor) {
        $salida .= ' sessionStorage.' . $clave . '=' . $valor . ';';
    }
    $salida .= '</script>';

    return $salida;
}

function formatearMoneda($moneda) {
    if (is_null($moneda)) {
        return $moneda;
    } else {
        return number_format((round($moneda, 2)), 2, ",", ".");
    }
}
