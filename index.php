<?php
session_start();

//error_reporting(0);

set_include_path('scripts');
include 'funciones.inc.php';

if (isset($_REQUEST['accion'])) {
	if ($_REQUEST['accion'] == 'logout') {
		session_destroy();
		header("location: index.php");
		exit();
	}
	$accion = $_REQUEST['accion'];
} else {
	$accion = 'accion';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--<link href="js/libs/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">-->

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/estilos.css?<?php echo time(); ?>" rel="stylesheet">

	<link rel="shortcut icon" href="favicon.ico">

	<!-- <script src="js/libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script> -->

	<script src="js/libs/jquery-3.1.1.min.js"></script>

	<!-- <script src="js/libs/jquery-ui-1.12.1/jquery-ui.min.js"></script> -->

	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/comunes.js"></script>

	<?php
		// if (!isset($_SESSION['username'])) {
		// 	echo '<script src="js/login.js"></script>';
		// }
	?>

	<title>Operatorias</title>
</head>

<body>
	<div>

		<?php
		if (!isset($_SESSION['username'])) {
			include 'login.php';
		} else {
		?>
			<!-- Menu -->
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<!-- 				<div class="navbar-collapse">
					<h2 class="text-white">Cr&eacute;ditos</h2>
				</div> -->

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Cr&eacute;ditos</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Procesos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="index.php?accion=generar_debitos">Generar debitos</a>
                  <a class="dropdown-item" href="index.php?accion=cargar_pagos">Cargar Pagos</a>
                </div>
              </li>
            </ul>
          </div>

				<div class="text-white float-right">
					<?php
					echo '<img src="img/user.png" width="15" height="15" style="margin-bottom:4%;"> ' . $_SESSION['username'] . ' (<a class="enlColor" href="index.php?accion=logout">Salir</a>)';
					?>
				</div>
			</nav>

			<form name="form-nav" id="form-nav" action="index.php" method="post">
				<input type="hidden" id="accion" name="accion">
			</form>

			<div class="container top20">

				<?php
				include_once 'conexion.inc.php';

				if (!$conexion) {
					echo "<div class='container text-danger top20 text-center'><p>Error de conexi&oacute;n. Intente m&aacute;s tarde.!!!</p></div>";
					exit();
				}

				// Cargo la configuracion del sistema
				$scriptSeteaConfig = cargarConfiguracion($conexion); // A partir de aca tengo la variable $_SESSION['config']
				echo $scriptSeteaConfig;

				// Segun sea la accion, muestro el contenido
				switch ($accion) {
					case 'ver':
						include 'ver_credito.php';
						break;
					case 'nuevo':
						include 'nuevo_credito.php';
						break;
          case 'generar_debitos':
            include 'generar_debitos.vista.php';
            break;
          case 'creditos':
					default:
						include 'creditos.php';
						break;
				}
				?>
			</div>
		<?php
		}
		?>

	</div>
	
</body>

</html>