<?php
$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';
$respuesta['titulares'] = array();

try {
  include './conexion.inc.php';
  if (!$conexion) {
	$respuesta['mensaje'] = 'Sin conexion de datos';
	throw new Exception();
  }

  $consulta = "select id, fullname, nro_docu, id_organismo from titulares_full where fullname like '%" . $_GET['buscado'] . "%'";
  $resultado = @mysqli_query($conexion, $consulta);
  if (!$resultado) {
	throw new Exception();
  }
  
  while ($titu = mysqli_fetch_assoc($resultado)) {
	$respuesta['titulares'][] = $titu;
  }
  
  $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
  //
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>

