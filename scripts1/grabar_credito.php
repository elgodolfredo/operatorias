<?php

$respuesta = array();
$respuesta['resultado'] = 'error';
$respuesta['mensaje'] = '';

// Validar los datos con php //

try {
  include 'conexion.inc.php';
  if (!$conexion) {
	$respuesta['mensaje'] = 'Sin conexion de datos';
	throw new Exception();
  }

  extract($_GET);
  
  if ($id == '') {
	$query = "insert into creditos set id_titular = $id_titular, monto_total = $monto_total, id_operatoria = $id_operatoria";
  }
  else {
	$query = "update creditos set id_titular = $id_titular, monto_total = $monto_total, id_operatoria = $id_operatoria where id = $id";
  }
  
  $resultado = @mysqli_query($conexion, $query);
  if (!$resultado) {
	$respuesta['mensaje'] = 'No se pudo realizar la operación';
	throw new Exception();
  }

  $respuesta['mensaje'] = 'Los datos se actualizaron correctamente';
  $respuesta['resultado'] = 'ok';
} catch (Exception $exc) {
  //
}

$resultadosJson = json_encode($respuesta);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
?>