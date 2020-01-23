<?php
include 'chequear_sesion.inc.php';

try {
    if (!isset($_POST['dni']) || $_POST['dni'] == '') {
        throw new Exception('Error de autenticaci&oacute;n.');
    }

    $consulta = "SELECT titulares_full.id AS id, titulares_full.id_persona AS idTit, titulares_full.nombre AS nomTit, titulares_full.apellido AS apeTit, titulares_full.nro_docu AS dniTit, titulares_full.domicilio AS domTit, titulares_full.id_dpto AS dptoTit, titulares_full.id_localidad AS locTit, titulares_full.tel_fijo AS telFTit, titulares_full.tel_laboral AS telLTit, titulares_full.tel_celular AS telCTit, titulares_full.observaciones AS obsTit, titulares_full.id_organismo AS orgTit, titulares_full.legajo AS legTit, titulares_full.ingresos AS ingTit, cotitulares_full.id_persona AS idCot, cotitulares_full.nombre AS nomCot, cotitulares_full.apellido AS apeCot, cotitulares_full.nro_docu AS dniCot, cotitulares_full.domicilio AS domCot, cotitulares_full.id_dpto AS dptoCot, cotitulares_full.id_localidad AS locCot, cotitulares_full.tel_fijo AS telFCot, cotitulares_full.tel_laboral AS telLCot, cotitulares_full.tel_celular AS telCCot, cotitulares_full.observaciones AS obsCot, cotitulares_full.id_organismo AS orgCot, cotitulares_full.legajo AS legCot, cotitulares_full.ingresos AS ingCot, garantes_full.id_persona AS idGar, garantes_full.nombre AS nomGar, garantes_full.apellido AS apeGar, garantes_full.nro_docu AS dniGar, garantes_full.domicilio AS domGar, garantes_full.id_dpto AS dptoGar, garantes_full.id_localidad AS locGar, garantes_full.tel_fijo AS telFGar, garantes_full.tel_laboral AS telLGar, garantes_full.tel_celular AS telCGar, garantes_full.observaciones AS obsGar, garantes_full.id_organismo AS orgGar, garantes_full.legajo AS legGar, garantes_full.ingresos AS ingGar, creditos.id AS idCred, creditos.monto_total AS monto, creditos.id_operatoria FROM creditos INNER JOIN titulares_full ON (creditos.id_titular = titulares_full.id) LEFT JOIN cotitulares_full ON (titulares_full.id = cotitulares_full.id_titular) LEFT JOIN garantes_full ON (titulares_full.id = garantes_full.id_titular) WHERE titulares_full.nro_docu = " . $_POST['dni'];

    //$consulta = $resultado = @mysqli_query($conexion, $consulta);
    $resultado = @mysqli_query($conexion, $consulta);
    if (!$resultado) {
        throw new Exception('Error de conexi&oacute;n. Intente m&aacute;s tarde.');
    }

    if (mysqli_num_rows($resultado) <= 0) {
        throw new Exception('No se encontraron resultados.');
    }
    $credito = mysqli_fetch_assoc($resultado);

    //consulto saldo, % de int Adm y seguro de la tabla operatorias
    $consultaOper = "SELECT creditos_full.saldo, operatorias.pje_interes_punitorio AS pjePun, operatorias.seguro FROM creditos_full INNER JOIN operatorias ON (creditos_full.id_operatoria = operatorias.id) WHERE creditos_full.id = " . $credito['idCred'];

    $resultado = @mysqli_query($conexion, $consultaOper);

    if (!$resultado) {
        throw new Exception('Error de conexi&oacute;n. Intente m&aacute;s tarde.');
    }
    $operatoria = mysqli_fetch_assoc($resultado);

    include 'cifrado.inc.php';

    // Consulto si el crédito tiene planes
    $consultaPlanes = "SELECT * FROM planes_de_pago WHERE id_credito = " . $credito['idCred'];

    $resultado = @mysqli_query($conexion, $consultaPlanes);

    if (!$resultado) {
        throw new Exception('Error de conexi&oacute;n. Intente m&aacute;s tarde.');
    }
    //Reservo la tabla de planes
    $tablaPl = '';

    //No se encontraron planes asociados al crédito
    if (mysqli_num_rows($resultado) <= 0) {
        $tablaPl .= '<p>No posee planes</p>';
    } else {
        // se encontraron planes. Armo la tabla de planes
        $tablaPl .= '<div id = "tablaPlanes" class = "form-row text-center col-md-12">'
            . '<table class = "table table-responsive-sm  table-hover top20">'
            . '<thead class="thead-dark">'
            . '<tr>'
            . '<th scope="col">Nº de Plan</th>'
            . '<th scope="col">Monto</th>'
            . '<th scope="col">Cuotas</th>'
            . '<th scope="col">% de Inter&eacute;s</th>'
            . '<th scope="col" colspan="2">Gastos Adm.</th>'
            . '<th scope="col" colspan="2">Operaciones</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody id="listaTitularesOK">';
        while ($plan = mysqli_fetch_assoc($resultado)) {
            $tablaPl .= '<tr>'
            . '<td scope="col">' . $plan['nro_plan'] . '</td>'
            . '<td scope="col">' . $plan['monto'] . '</td>'
            . '<td scope="col">' . $plan['cantidad_cuotas'] . '</td>'
            . '<td scope="col">' . $plan['pje_interes_punitorio'] . '</td>'
            . '<td scope="col">' . $plan['gastos_adm'] . '</td>'
            . '<td scope="col" colspan="2">'
            . '<div>'
            . '<a href="" class="badge badge-primary m-2" data-plancuota ="' . $plan['id'] . '">Cuotas</a>'
            . '<a href="" class="badge badge-primary m-2" data-planeditar ="' . $plan['id'] . '">Editar</a>'
            . '<a href="" class="badge badge-danger m-2" data-planeliminar ="' . cifrar($plan['id'] . "ctrlPlan" . $credito['idCred'], "kw%#5*s2") . '">Eliminar</a>'
                . '</div></td></tr>';
        }
        $tablaPl .= '</tbody>'
            . '<tr class="thead-dark">'
            . '<td colspan="7">'
            . '&nbsp;'
            . '</td>'
            . '</tr>'
            . '</table>'
            . '</div>';
    }

    $dis = 'disabled';
    $dptoTit = $credito['dptoTit'];
    $locTit = $credito['locTit'];
    $orgTit = $credito['orgTit'];
    $dptoCot = $credito['dptoCot'];
    $locCot = $credito['locCot'];
    $orgCot = $credito['orgCot'];
    $dptoGar = $credito['dptoGar'];
    $locGar = $credito['locGar'];
    $orgGar = $credito['orgGar'];
    $oper = $credito['id_operatoria'];
    ?>
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<script src="js/libs/jquery-ui.min.js"></script>
	<script src="js/libs/jquery-validate/jquery.validate.min.js"></script>
	<script src="js/libs/jquery-validate/messages_es.js"></script>
	<script src="js/ver_credito.js"></script>
	<script src="js/formulario.js"></script>

  <h2>Cr&eacute;ditos</h2>
  <hr>

	<div class="container">
		<div class="modal" tabindex="-1" role="dialog" id="elimCred" data-backdrop="static">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-light"> Eliminar Cr&eacute;dito</h5>
						<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="text-center">Se eliminarán todos los datos relacionados a &eacute;ste cr&eacute;dito. Desea continuar?</p>
					</div>
					<div class="modal-footer">
						<button id="btn-aceptar-eliminar" type="button" class="btn btn-danger">Aceptar</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="p-2 clearfix" id="btn-editar-cred">
			<a href="" id="btn-volver" data-menu="creditos" class="btn btn-primary btn-sm float-right m-2">Volver</a>
			<div id="btn-el">
				<a href="" id="btn-eliminar" class="btn btn-danger btn-sm float-right m-2">Eliminar cr&eacute;dito</a>
			</div>
		</div>
		<div id="respuesta" class="p-2 m-3 alert-secondary text-center invisible">
		</div>
		<input type="hidden" id="ctr" value="<?php echo cifrarCred($credito['idTit'] . "ctrl" . $credito['idCred'], "gxs5dq5r2") ?>">
		<div class="card" id="cardForm">
			<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" role="tab" href="#tit-card">Titular</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" role="tab" href="#cotit-card">Cotitular</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" role="tab" href="#gar-card">Garante</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" role="tab" href="#cred-card">Cr&eacute;dito</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" role="tab" href="#plan-card">Planes</a>
					</li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="card-body tab-pane active" role="tabpanel" id="tit-card">
					<form id="formTitular">
						<div class="mb-2 bg-light border-bottom">
							<a id="btn-editar-ti" class="nav-link" data-form="ti" href="">Editar Titular</a>
						</div>
						<div class="form-row">
							<div class="form-group col-md-5">
								<label for="nom">Nombre</label>
								<input type="text" id="nom" name="nom" class="form-control" value="<?php echo $credito['nomTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-5">
								<label for="ape">Apellido</label>
								<input type="text" id="apeTit" name="ape" class="form-control" value="<?php echo $credito['apeTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="dni">N° de Doc.</label>
								<input type="text" id="dniTit" name="dni" class="form-control" value="<?php echo $credito['dniTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<input type="hidden" name="form" value="ti" />
							<input type="hidden" id="idTit" name="id" value="<?php echo $credito['idTit']; ?>" />
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="dom">Domicilio</label>
								<input type="text" id="domTit" name="dom" class="form-control" value="<?php echo $credito['domTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="idDpto">Departamento</label>
								<?php
generarDepartamentos($conexion, $dptoTit, $dis, "idDpto", "Ti");
    ?>
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-6">
								<label for="idLoc">Localidad</label>
								<?php
generarLocalidades($conexion, $dptoTit, $locTit, $dis, "idLoc", "Ti");
    ?>
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="telF">Tel. Fijo</label>
								<input type="text" id="telFTit" name="telF" class="form-control" value="<?php echo $credito['telFTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="telL">Tel. Laboral</label>
								<input type="text" id="telLTit" name="telL" class="form-control" value="<?php echo $credito['telLTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="telC">Tel. Celular</label>
								<input type="text" id="telCTit" name="telC" class="form-control" value="<?php echo $credito['telCTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="obs">Observaciones</label>
								<input type="text" id="obsTit" name="obs" class="form-control" value="<?php echo $credito['obsTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="idOrg">Organismo</label>
								<?php
generarOrganismos($conexion, $orgTit, $dis, "idOrg", "Ti");
    ?>
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="leg">Legajo</label>
								<input type="text" id="legTit" name="leg" class="form-control" value="<?php echo $credito['legTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="ing">Ingresos</label>
								<input type="text" id="ingTit" name="ing" class="form-control" value="<?php echo $credito['ingTit']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>
					</form>
				</div>
				<div class="card-body tab-pane" role="tabpanel" id="cotit-card">
					<form id="formCotitular">
						<div class="mb-2 bg-light border-bottom">
							<a id="btn-editar-co" class="nav-link" data-form="co" href="">Editar Cotitular</a>
						</div>
						<div class="form-row">
							<div class="form-group col-md-5">
								<label for="nom">Nombre</label>
								<input type="text" id="nomCot" name="nom" class="form-control" value="<?php echo $credito['nomCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-5">
								<label for="ape">Apellido</label>
								<input type="text" id="apeCot" name="ape" class="form-control" value="<?php echo $credito['apeCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="dni">N° de Doc.</label>
								<input type="text" id="dniCot" name="dni" class="form-control" value="<?php echo $credito['dniCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<input type="hidden" name="form" value="co" />
							<input type="hidden" id="idCot" name="id" value="<?php echo $credito['idCot']; ?>" />
							<input type="hidden" id="idTitCot" name="idTit" value="<?php echo $credito['id']; ?>" />
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="dom">Domicilio</label>
								<input type="text" id="domCot" name="dom" class="form-control" value="<?php echo $credito['domCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="idDpto">Departamento</label>
								<?php
generarDepartamentos($conexion, $dptoCot, $dis, "idDpto", "Co");
    ?>
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-6">
								<label for="idLoc">Localidad</label>
								<?php
generarLocalidades($conexion, $dptoCot, $locCot, $dis, "idLoc", "Co");
    ?>
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="telF">Tel. Fijo</label>
								<input type="text" id="telFCot" name="telF" class="form-control" value="<?php echo $credito['telFCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="telL">Tel. Laboral</label>
								<input type="text" id="telLCot" name="telL" class="form-control" value="<?php echo $credito['telLCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="telC">Tel. Celular</label>
								<input type="text" id="telCCot" name="telC" class="form-control" value="<?php echo $credito['telCCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="obs">Observaciones</label>
								<input type="text" id="obsCot" name="obs" class="form-control" value="<?php echo $credito['obsCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="idOrg">Organismo</label>
								<?php
generarOrganismos($conexion, $orgCot, $dis, "idOrg", "Co");
    ?>
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="leg">Legajo</label>
								<input type="text" id="legCot" name="leg" class="form-control" value="<?php echo $credito['legCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="ing">Ingresos</label>
								<input type="text" id="ingCot" name="ing" class="form-control" value="<?php echo $credito['ingCot']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>
					</form>
				</div>
				<div class="card-body tab-pane" role="tabpanel" id="gar-card">
					<form id="formGarante">
						<div class="mb-2 bg-light border-bottom">
							<a id="btn-editar-ga" class="nav-link" data-form="ga" href="">Editar Garante</a>
						</div>
						<div class="form-row">
							<div class="form-group col-md-5">
								<label for="nom">Nombre</label>
								<input type="text" id="nomGar" name="nom" class="form-control" value="<?php echo $credito['nomGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-5">
								<label for="ape">Apellido</label>
								<input type="text" id="apeGar" name="ape" class="form-control" value="<?php echo $credito['apeGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="dni">N° de Doc.</label>
								<input type="text" id="dniGar" name="dni" class="form-control" value="<?php echo $credito['dniGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<input type="hidden" name="form" value="ga" />
							<input type="hidden" id="idGar" name="id" value="<?php echo $credito['idGar']; ?>" />
							<input type="hidden" id="idTitGar" name="idTit" value="<?php echo $credito['id']; ?>" />
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="dom">Domicilio</label>
								<input type="text" id="domGar" name="dom" class="form-control" value="<?php echo $credito['domGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="idDpto">Departamento</label>
								<?php
generarDepartamentos($conexion, $dptoGar, $dis, "idDpto", "Ga");
    ?>
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-6">
								<label for="idLoc">Localidad</label>
								<?php
generarLocalidades($conexion, $dptoGar, $locGar, $dis, "idLoc", "Ga");
    ?>
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="telF">Tel. Fijo</label>
								<input type="text" id="telFGar" name="telF" class="form-control" value="<?php echo $credito['telFGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="telL">Tel. Laboral</label>
								<input type="text" id="telLGar" name="telL" class="form-control" value="<?php echo $credito['telLGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="telC">Tel. Celular</label>
								<input type="text" id="telCGar" name="telC" class="form-control" value="<?php echo $credito['telCGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="obs">Observaciones</label>
								<input type="text" id="obsGar" name="obs" class="form-control" value="<?php echo $credito['obsGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="idOrg">Organismo</label>
								<?php
generarOrganismos($conexion, $orgGar, $dis, "idOrg", "Ga");
    ?>
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="leg">Legajo</label>
								<input type="text" id="legGar" name="leg" class="form-control" value="<?php echo $credito['legGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-2">
								<label for="ing">Ingresos</label>
								<input type="text" id="ingGar" name="ing" class="form-control" value="<?php echo $credito['ingGar']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>
					</form>
				</div>
				<div class="card-body tab-pane" role="tabpanel" id="cred-card">
					<form id="formCredito">
						<div class="mb-2 bg-light border-bottom">
							<a id="btn-editar-cr" class="nav-link" data-form="cr" href="">Editar Cr&eacute;dito</a>
						</div>
						<div class="form-row">
							<input type="hidden" id="cred" name="cred" value="<?php echo $credito['idCred']; ?>" />
							<input type="hidden" name="form" value="cr" />
							<div class="form-group col-md-6">
								<label for="montoCred">Monto Total</label>
								<input type="text" id="montoCred" name="montoCred" class="form-control" value="<?php echo $credito['monto']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-6">
								<label for="saldoCred">Saldo</label>
								<input type="text" id="saldoCred" name="saldoCred" class="form-control" value="<?php echo $operatoria['saldo']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="idOper">Operatoria</label>
								<?php
generarSelectOperatorias($conexion, $oper, $dis);
    ?>
								<p class="campo-invalido"></p>
							</div>
							<div class="form-group col-md-4">
								<label for="intAdmCred">% Int. Admin.</label>
								<input type="text" id="intAdmCred" name="intAdmCred" class="form-control" value="<?php echo $operatoria['pjePun']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
							<div class="form-group col-md-4">
								<label for="segCred">Seguro</label>
								<input type="text" id="segCred" name="segCred" class="form-control" value="<?php echo $operatoria['seguro']; ?>" disabled />
								<span class="campo-invalido"></span>
							</div>
						</div>
					</form>
				</div>
				<div class="card-body tab-pane" role="tabpanel" id="plan-card">
					<div class="mb-2 bg-light border-bottom">
						<a id="btn-nuevo-plan" class="nav-link" data-form="pl" href="">Nuevo Plan</a>
					</div>
					<div id="nuevoPlan" class="invisible">
						<form id="formNuevoPlan">
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="monto">Monto</label>
									<span id="monto" class="form-control bg-light"><?php echo $operatoria['saldo']; ?></span>
								</div>
								<div class="form-group col-md-4">
									<label for="intPun">Intereses Punitorios</label>
									<span id="intPun" class="form-control bg-light"><?php echo $operatoria['pjePun']; ?></span>
								</div>
								<div class="form-group col-md-4">
									<label for="cuotaFinal">Monto Total Cuota</label>
									<span id="cuotaFinal" class="form-control bg-light"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="cantCuotas">Cantidad de Cuotas</label>
									<input type="text" id="cantCuotas" name="cantCuotas" class="form-control" value="" />
									<span class="campo-invalido"></span>
								</div>
								<div class="form-group col-md-6">
									<label for="primerVenc">Primer Vencimiento</label>
									<input data-provide="datepicker-inline" id="primerVenc" name="primerVenc" class="form-control" value="" />
									<span class="campo-invalido"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-3">
									<label for="seg">Seguro</label>
									<input type="text" id="seg" name="seg" class="form-control" value="" />
									<span class="campo-invalido"></span>
								</div>
								<div class="form-group col-md-4">
									<label for="gastosAdmin">Gastos Administrativos</label>
									<input type="text" id="gastosAdmin" name="gastosAdmin" class="form-control" value="" />
									<span class="campo-invalido"></span>
								</div>
								<div class="form-group col-md-5">
									<label for="formaPago">Forma de Pago</label>
									<select id="formaPago" name="formaPago" class="form-control">
										<option value="">Seleccione Una Opci&oacute;n</option>
										<option value="1">Debito</option>
										<option value="2">Chequera</option>
										<option value="3">Otros</option>
									</select>
									<span class="campo-invalido"></span>
								</div>
								<input type="hidden" id="cdt" name="cdt" value="<?php echo $credito['idCred']; ?>">
								<input type="hidden" id="mnt" name="mnt" value="<?php echo $operatoria['saldo']; ?>">
								<input type="hidden" id="ipn" name="ipn" value="<?php echo $operatoria['pjePun']; ?>">
								<input type="hidden" id="mct" name="mct" value="">
							</div>
						</form>
					</div>
					<?php
//Imprimo la tabla de planes reservada
    echo $tablaPl;
    ?>
				</div>
			</div>
		</div>

		<div id="btn-form" class='invisible'>
			<div class="p-2 clearfix">
				<a href="" id="btn-enviar" class="btn btn-primary float-right m-2">Enviar</a>
				<a href="" id="btn-cancelar" data-menu="creditos" class="btn btn-primary float-right m-2">Cancelar</a>
			</div>
		</div>
	</div>
<?php
} catch (Exception $e) {
    echo '<div class="p-2 m-3 text-success bg-light text-center">' . $e->getMessage() . '</div>';
}
