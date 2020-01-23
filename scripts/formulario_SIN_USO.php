<?php
include 'chequear_sesion.inc.php';

function isIsset($val) {
    echo (isset($val)) ? $val : '';
    return;
}

function btnEditar($idBtn, $tit) {
    if (isset($idBtn)) {
        echo '<div class="p-2 mb-2 bg-light border-bottom">
                <a id="btn-editar-' . $idBtn . '" data-form="' . $idBtn . '" href="">Editar ' . $tit . '</a>
            </div>';
    }
    return;
}
?>
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
        </ul>
    </div>
    <div class="tab-content">
        <div class="card-body tab-pane active" role="tabpanel" id="tit-card">
            <form id="formTitular">
                <?php
                btnEditar($idBtnTit, $titular);
                ?>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="nomTit">Nombre</label>
                        <input type="text" id="nomTit" name="nomTit" class="form-control" <?php
                        isIsset($nomTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="apeTit">Apellido</label>
                        <input type="text" id="apeTit" name="apeTit" class="form-control" <?php
                        isIsset($apeTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="dniTit">N° de Doc.</label>
                        <input type="text" id="dniTit" name="dniTit" class="form-control" <?php
                        isIsset($dniTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <input type="hidden" id="idTit" name="idTit" <?php isIsset($idTit); ?> >
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="domTit">Domicilio</label>
                        <input type="text" id="domTit" name="domTit" class="form-control" <?php
                        isIsset($domTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idDptoTit">Departamento</label>
                        <?php
                        generarDepartamentos($conexion, $dptoTit, $dis, "idDptoTit");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="idLocTit">Localidad</label>
                        <?php
                        generarLocalidades($conexion, $dptoTit, $locTit, $dis, "idLocTit");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="telFTit">Tel. Fijo</label>
                        <input type="text" id="telFTit" name="telFTit" class="form-control" <?php
                        isIsset($telFTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telLTit">Tel. Laboral</label>
                        <input type="text" id="telLTit" name="telLTit" class="form-control" <?php
                        isIsset($telLTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telCTit">Tel. Celular</label>
                        <input type="text" id="telCTit" name="telCTit" class="form-control" <?php
                        isIsset($telCTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="obsTit">Observaciones</label>
                        <input type="text" id="obsTit" name="obsTit" class="form-control" <?php
                        isIsset($obsTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="idOrgTit">Organismo</label>
                        <?php
                        generarOrganismos($conexion, $orgTit, $dis, "idOrgTit");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="legTit">Legajo</label>
                        <input type="text" id="legTit" name="legTit" class="form-control" <?php
                        isIsset($legTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="ingTit">Ingresos</label>
                        <input type="text" id="ingTit" name="ingTit" class="form-control" <?php
                        isIsset($ingTit);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body tab-pane" role="tabpanel" id="cotit-card">
            <form id="formCotitular">
                <?php
                btnEditar($idBtnCo, $cotitular);
                ?>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="nomCot">Nombre</label>
                        <input type="text" id="nomCot" name="nomCot" class="form-control" <?php
                        isIsset($nomCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="apeCot">Apellido</label>
                        <input type="text" id="apeCot" name="apeCot" class="form-control" <?php
                        isIsset($apeCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="dniCot">N° de Doc.</label>
                        <input type="text" id="dniCot" name="dniCot" class="form-control" <?php
                        isIsset($dniCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <input type="hidden" id="idCot" name="idCot" <?php isIsset($idCot); ?> >
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="domCot">Domicilio</label>
                        <input type="text" id="domCot" name="domCot" class="form-control" <?php
                        isIsset($domCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idDptoCot">Departamento</label>
                        <?php
                        generarDepartamentos($conexion, $dptoCot, $dis, "idDptoCot");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="idLocCot">Localidad</label>
                        <?php
                        generarLocalidades($conexion, $dptoCot, $locCot, $dis, "idLocCot");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="telFCot">Tel. Fijo</label>
                        <input type="text" id="telFCot" name="telFCot" class="form-control" <?php
                        isIsset($telFCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telLCot">Tel. Laboral</label>
                        <input type="text" id="telLCot" name="telLCot" class="form-control" <?php
                        isIsset($telLCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telCCot">Tel. Celular</label>
                        <input type="text" id="telCCot" name="telCCot" class="form-control" <?php
                        isIsset($telCCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="obsCot">Observaciones</label>
                        <input type="text" id="obsCot" name="obsCot" class="form-control" <?php
                        isIsset($obsCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="idOrgCot">Organismo</label>
                        <?php
                        generarOrganismos($conexion, $orgCot, $dis, "idOrgCot");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="legCot">Legajo</label>
                        <input type="text" id="legCot" name="legCot" class="form-control" <?php
                        isIsset($legCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="ingCot">Ingresos</label>
                        <input type="text" id="ingCot" name="ingCot" class="form-control" <?php
                        isIsset($ingCot);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body tab-pane" role="tabpanel" id="gar-card">
            <form id="formGarante">
                <?php
                btnEditar($idBtnGa, $garante);
                ?>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="nomGar">Nombre</label>
                        <input type="text" id="nomGar" name="nomGar" class="form-control" <?php
                        isIsset($nomGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="apeGar">Apellido</label>
                        <input type="text" id="apeGar" name="apeGar" class="form-control" <?php
                        isIsset($apeGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="dniGar">N° de Doc.</label>
                        <input type="text" id="dniGar" name="dniGar" class="form-control" <?php
                        isIsset($dniGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <input type="hidden" id="idGar" name="idGar" <?php isIsset($idGar); ?> >
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="domGar">Domicilio</label>
                        <input type="text" id="domGar" name="domGar" class="form-control" <?php
                        isIsset($domGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idDptoGar">Departamento</label>
                        <?php
                        generarDepartamentos($conexion, $dptoGar, $dis, "idDptoGar");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="idLocGar">Localidad</label>
                        <?php
                        generarLocalidades($conexion, $dptoGar, $locGar, $dis, "idLocGar");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="telFGar">Tel. Fijo</label>
                        <input type="text" id="telFGar" name="telFGar" class="form-control" <?php
                        isIsset($telFGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telLGar">Tel. Laboral</label>
                        <input type="text" id="telLGar" name="telLGar" class="form-control" <?php
                        isIsset($telLGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telCGar">Tel. Celular</label>
                        <input type="text" id="telCGar" name="telCGar" class="form-control" <?php
                        isIsset($telCGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="obsGar">Observaciones</label>
                        <input type="text" id="obsGar" name="obsGar" class="form-control" <?php
                        isIsset($obsGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="idOrgGar">Organismo</label>
                        <?php
                        generarOrganismos($conexion, $orgGar, $dis, "idOrgGar");
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="legGar">Legajo</label>
                        <input type="text" id="legGar" name="legGar" class="form-control" <?php
                        isIsset($legGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="ingGar">Ingresos</label>
                        <input type="text" id="ingGar" name="ingGar" class="form-control" <?php
                        isIsset($ingGar);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body tab-pane" role="tabpanel" id="cred-card">
            <form id="formCredito">
                <?php
                btnEditar($idBtnCr, $titCred);
                ?>
                <div class="form-row">
                    <input type="hidden" id="cred" name="cred" <?php isIsset($cred); ?> >
                    <div class="form-group col-md-12">
                        <label for="monto">Monto Total</label>
                        <input type="text" id="monto" name="monto" class="form-control" <?php
                        isIsset($monto);
                        echo $dis;
                        ?>/>
                        <span class="campo-invalido"></span>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="idOper">Operatoria</label>
                        <?php
                        generarSelectOperatorias($conexion, $oper, $dis);
                        ?>
                        <span class="campo-invalido"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="btn-form" <?php isIsset($btnsInvisibles); ?>>
    <div class="p-2 clearfix">       
        <a href="" id="btn-enviar" class="btn btn-primary float-right m-2">Enviar</a>
        <a href="" id="btn-cancelar" data-menu="creditos" class="btn btn-primary float-right m-2">Cancelar</a>
    </div>
</div>
