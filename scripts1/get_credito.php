<?php

/* crea un array con datos que seran enviados de vuelta a la aplicacion */
$respuesta = array();

try {
  include 'conexion.inc.php';

  if (!$conexion) {
	throw new Exception();
  }

  $id = $_GET['id'];

  $consulta = "select * from creditos_full where id = $id";
  $resultado = @mysqli_query($conexion, $consulta);

  if (!$resultado) {
	throw new Exception();
  }

  $credito = mysqli_fetch_assoc($resultado);

  $respuesta = $credito;
  $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
  $respuesta['resultado'] = 'error';
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>
