<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
	include 'conexion.inc.php';
	include 'cifrado.inc.php';
	if (!$conexion) {
		$error = 'No se puede acceder a la base de datos';
	} else {
		// proceso de logueo
		extract($_POST);
		$consulta = "select * from usuarios where username = '$username' limit 1";
		$resultado = mysqli_query($conexion, $consulta);
		if ($resultado) {
			if (mysqli_num_rows($resultado) > 0) {
				// Verifico la contraseña
				$registro = mysqli_fetch_assoc($resultado);

				// if ($registro['password'] == cifrar($password)) {
				if ($registro['password'] == cifrar($password)) {
					// usuario y password correctos
					$_SESSION['username'] = $username;
				} else {
					$_SESSION['mensaje'] = 'Usuario o Contraseña incorrectos111';
				}
			} else {
				$_SESSION['mensaje'] = 'Usuario o Contraseña incorrectos222';
			}
		} else {
			$_SESSION['mensaje'] = 'Error de comprobacion de credenciales';
		}

		// header("location: $path");
		header('location: index.php');
		exit();
	}
}
?>

<?php
if (isset($error)) {
	echo "<div class='container text-danger top20 text-center'><p>$error</p></div>";
}
if (isset($_SESSION['mensaje'])) {
	echo "<div class='container text-danger top20 text-center'><p>" . $_SESSION['mensaje'] . "</p></div>";
}
?>
<div>
	<form id="form-login" method="post" action="index.php">
		<div id='img-login'>
		</div>

		<input type="hidden" name="accion" value="login">

		<div class="form-group">
			<label>Usuario</label>
			<input type="text" id="username" name="username" class="form-control" autofocus value="admin">
			<span class="campo-invalido"></span>
		</div>

		<div>
			<div class="form-group">
				<label for="password">Contrase&ntilde;a</label>
				<input type="password" id="password" name="password" class="form-control" value="admin">
				<span class="campo-invalido"></span>
			</div>
		</div>


		<button type="submit" class="btn btn-primary btn-block">Ingresar</button>
	</form>
</div>
<!-- <script src="js/login.js?<?php //echo time(); 
															?>"></script> -->