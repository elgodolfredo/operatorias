<?php

$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';

try {
  include 'conexion.inc.php';

  if (!$conexion) {
	throw new Exception();
  }

  mysqli_autocommit($conexion, FALSE);
  $transaccion = @mysqli_query($conexion, 'BEGIN');
  if(!$transaccion){
	throw new Exception();
  }

  $id = $_GET['id'];
  $tabla = $_GET['tipo_persona'];
  $consulta = "delete from personas where id = (select id_persona from $tabla where id = $id)";
  $resultado = @mysqli_query($conexion, $consulta);

  if (!$resultado) {
	throw new Exception();
  }

  $consulta = "delete from $tabla where id = $id";
  $resultado = @mysqli_query($conexion, $consulta);

  if (!$resultado) {
	throw new Exception();
  }  
  
  @mysqli_query($conexion, 'COMMIT');
  $respuesta['mensaje'] = 'El registro fue eliminado';
  $respuesta['resultado'] = 'ok';
} catch (Exception $ex) {
  if ($transaccion) {
	$respuesta['mensaje'] = 'No se pudo realizar el borrado';
	@mysqli_query($conexion, 'ROLLBACK');
  }
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>

