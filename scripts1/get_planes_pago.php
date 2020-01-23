<?php
$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';
$respuesta['planes'] = array();

try {
  include 'conexion.inc.php';
  if (!$conexion) {
	$respuesta['mensaje'] = 'Sin conexion de datos';
	throw new Exception();
  }

  $id = $_GET['id'];
  $consulta = "select * from planes_de_pago where id_credito = $id";
  $resultado = @mysqli_query($conexion, $consulta);
  if (!$resultado) {
	$respuesta['mensaje'] = 'No se puede acceder a los planes de pago';
	throw new Exception();
  }
  
  while ($plan = mysqli_fetch_assoc($resultado)) {
	$respuesta['planes'][] = $plan;
  }
  
  $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
  //
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>