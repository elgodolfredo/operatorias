<?php
include 'chequear_sesion.inc.php';
$dis = 'disabled';
?>
<link href="css/jquery-ui.min.css" rel="stylesheet">
<script src="js/libs/jquery-ui.min.js" ></script>
<script src="js/libs/jquery-validate/jquery.validate.min.js"></script>
<script src="js/libs/jquery-validate/messages_es.js"></script>
<script src="js/nuevo_credito.js"></script>
<script src="js/formulario.js"></script>

<h2>Cr&eacute;ditos</h2>
<hr>

<div class="container">

    <div id="respuesta" class="invisible">
        <div class="p-2 clearfix">
            <a href="" id="btn-volver" data-menu="creditos" class="badge badge-primary float-right m-2">Volver</a>
        </div>
        <div class="p-2 m-3 alert-secondary text-center">
            <p id="resultado">Respuesta</p>
        </div>
    </div>
    
    <div class="modal" tabindex="-1" role="dialog" id="completarCred" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light">Planes</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Primero debe ingresar monto y operatoria de cr&eacute;dito!</p>
                </div>
                <div class="modal-footer">
                    <button id="btn-aceptar-alerta" type="button" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="cardForm">
        <form id="formNuevo" method="POST">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" href="#tit-card">Titular <span class="campo-invalido" id="errorTit"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" href="#cotit-card">Cotitular <span class="campo-invalido" id="errorCotit"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" href="#gar-card">Garante <span class="campo-invalido" id="errorGar"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" href="#cred-card">Cr&eacute;dito<span class="campo-invalido" id="errorCred"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" role="tab" href="#plan-card">Planes <span class="campo-invalido" id="errorPlan"></span></a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="card-body tab-pane active" role="tabpanel" id="tit-card">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="nomTit">Nombre</label>
                            <input type="text" id="nomTit" name="nomTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="apeTit">Apellido</label>
                            <input type="text" id="apeTit" name="apeTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="dniTit">N° de Doc.</label>
                            <input type="text" id="dniTit" name="dniTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="domTit">Domicilio</label>
                            <input type="text" id="domTit" name="domTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="idDptoTit">Departamento</label>
                            <?php
                              generarDepartamentos($conexion, 0, '', "idDptoTit", '');
                            ?>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="idLocTit">Localidad</label>
                            <?php
                              generarLocalidades($conexion, 0, 0, '', "idLocTit", '');
                            ?>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="telFTit">Tel. Fijo</label>
                            <input type="text" id="telFTit" name="telFTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telLTit">Tel. Laboral</label>
                            <input type="text" id="telLTit" name="telLTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telCTit">Tel. Celular</label>
                            <input type="text" id="telCTit" name="telCTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="obsTit">Observaciones</label>
                            <input type="text" id="obsTit" name="obsTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="idOrgTit">Organismo</label>
                            <?php
                              generarOrganismos($conexion, '', '', "idOrgTit", '');
                            ?>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="legTit">Legajo</label>
                            <input type="text" id="legTit" name="legTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ingTit">Ingresos</label>
                            <input type="text" id="ingTit" name="ingTit" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>
                </div>
                <div class="card-body tab-pane" role="tabpanel" id="cotit-card">
                    <div class="mb-2 bg-light border-bottom">
                        <input type="checkbox" id="btn-agregar-cotit"> <span class="font-weight-bold"> Agregar Cotitular</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="nomCot">Nombre</label>
                            <input type="text" id="nomCot" name="nomCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="apeCot">Apellido</label>
                            <input type="text" id="apeCot" name="apeCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="dniCot">N° de Doc.</label>
                            <input type="text" id="dniCot" name="dniCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="domCot">Domicilio</label>
                            <input type="text" id="domCot" name="domCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="idDptoCot">Departamento</label>
                            <?php
generarDepartamentos($conexion, 0, $dis, "idDptoCot", '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="idLocCot">Localidad</label>
                            <?php
generarLocalidades($conexion, 0, 0, $dis, "idLocCot", '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="telFCot">Tel. Fijo</label>
                            <input type="text" id="telFCot" name="telFCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telLCot">Tel. Laboral</label>
                            <input type="text" id="telLCot" name="telLCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telCCot">Tel. Celular</label>
                            <input type="text" id="telCCot" name="telCCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="obsCot">Observaciones</label>
                            <input type="text" id="obsCot" name="obsCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="idOrgCot">Organismo</label>
                            <?php
generarOrganismos($conexion, 0, $dis, "idOrgCot", '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="legCot">Legajo</label>
                            <input type="text" id="legCot" name="legCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ingCot">Ingresos</label>
                            <input type="text" id="ingCot" name="ingCot" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>
                </div>
                <div class="card-body tab-pane" role="tabpanel" id="gar-card">
                    <div class="mb-2 bg-light border-bottom">
                        <input type="checkbox" id="btn-agregar-garate"> <span class="font-weight-bold"> Agregar Garante</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="nomGar">Nombre</label>
                            <input type="text" id="nomGar" name="nomGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="apeGar">Apellido</label>
                            <input type="text" id="apeGar" name="apeGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="dniGar">N° de Doc.</label>
                            <input type="text" id="dniGar" name="dniGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="domGar">Domicilio</label>
                            <input type="text" id="domGar" name="domGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="idDptoGar">Departamento</label>
                            <?php
generarDepartamentos($conexion, 0, $dis, "idDptoGar", '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="idLocGar">Localidad</label>
                            <?php
generarLocalidades($conexion, 0, 0, $dis, "idLocGar", '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="telFGar">Tel. Fijo</label>
                            <input type="text" id="telFGar" name="telFGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telLGar">Tel. Laboral</label>
                            <input type="text" id="telLGar" name="telLGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telCGar">Tel. Celular</label>
                            <input type="text" id="telCGar" name="telCGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="obsGar">Observaciones</label>
                            <input type="text" id="obsGar" name="obsGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="idOrgGar">Organismo</label>
                            <?php
generarOrganismos($conexion, 0, $dis, "idOrgGar", '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="legGar">Legajo</label>
                            <input type="text" id="legGar" name="legGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ingGar">Ingresos</label>
                            <input type="text" id="ingGar" name="ingGar" class="form-control" disabled/>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>
                </div>
                <div class="card-body tab-pane" role="tabpanel" id="cred-card">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="monto">Monto Total</label>
                            <input type="text" id="monto" name="monto" form="formNuevo" class="form-control"/>
                            <span class="campo-invalido"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="idOper">Operatoria</label>
                            <?php
generarSelectOperatorias($conexion, 0, '');
?>
                            <span class="campo-invalido"></span>
                        </div>
                    </div>
                </div>
                <div class="card-body tab-pane" role="tabpanel" id="plan-card">
                    <div class="mb-2 bg-light border-bottom">
                        <input type="checkbox" id="btn-agregar-plan"> <span class="font-weight-bold"> Agregar Plan</span>
                    </div>
                    <div id="nuevoPlan">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="monto">Monto</label>
                                <span id="montoPlan" class="form-control bg-light" ></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="intPun">Intereses Punitorios</label>
                                <span id="intPun" class="form-control bg-light" ></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cuotaFinal">Monto Total Cuota</label>
                                <span id="cuotaFinal" class="form-control bg-light" ></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cantCuotas">Cantidad de Cuotas</label>
                                <input type="text" id="cantCuotas" name="cantCuotas" class="form-control" value = "" disabled/>
                                <span class="campo-invalido"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="primerVenc">Primer Vencimiento</label>
                                <input data-provide="datepicker-inline" id="primerVenc" name="primerVenc" class="form-control" value = "" disabled/>
                                <span class="campo-invalido"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="seg">Seguro</label>
                                <input type="text" id="seg" name="seg" class="form-control" value = "" disabled/>
                                <span class="campo-invalido"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gastosAdmin">Gastos Administrativos</label>
                                <input type="text" id="gastosAdmin" name="gastosAdmin" class="form-control" value = "" disabled/>
                                <span class="campo-invalido"></span>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="formaPago">Forma de Pago</label>
                                <select id="formaPago" name="formaPago" class="form-control" disabled>
                                    <option value="">Seleccione Una Opci&oacute;n</option>
                                    <option value="1">d&eacute;bito</option>
                                    <option value="2">Chequera</option>
                                    <option value="3">Otros</option>
                                </select>
                                <span class="campo-invalido"></span>
                            </div>
                            <input type="hidden" id="ipn" name="ipn" value="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="btn-form">
        <div class="p-2 clearfix">
            <a href="" id="btn-enviar" class="btn btn-primary float-right m-2">Enviar</a>
            <a href="" id="btn-cancelar" data-menu="creditos" class="btn btn-primary float-right m-2">Cancelar</a>
        </div>
    </div>
</div>

