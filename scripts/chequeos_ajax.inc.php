<?php

if (!isset($_SESSION['username'])) {
    throw new Exception('Error de autenticaci&oacute;n.');
}
include 'conexion.inc.php';
if (!$conexion) {
    throw new Exception('Error de conexi&oacute;n. Intente m&aacute;s tarde.');
}

