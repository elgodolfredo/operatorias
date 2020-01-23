<?php
include 'chequear_sesion.inc.php'
?>
<script src="js/creditos.js"></script>

<h2>Cr&eacute;ditos</h2>
<hr>

<div>
	<a id="btn-nuevo-credito" data-menu="nuevo" class='btn btn-secondary'>Nuevo</a>
</div>

<div class="mt-5">
	<form>
		<div class="form-group">
			<label for="dni_tit">DNI del Titular</label>
			<input type="number" class="form-control" id="dni-titular">
		</div>
		<button id="btn-buscar-credito" type="submit" class="btn btn-primary">Buscar</button>
	</form>
</div>

</div>

<div id="respuesta" class="container p-2 m-3 alert-secondary text-center invisible">
	<p>Respuesta</p>
</div>

<div id="buscar_credito" class="invisible container">

</div>