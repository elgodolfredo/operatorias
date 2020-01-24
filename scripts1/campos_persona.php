<!--
  Contiene el HTML de los campos de la tabla persona, para ser usados en titular, cotitular y garante
-->

<div class="form-row">
    <div class="form-group col-md-5">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control"/>
        <span class="campo-invalido"></span>
    </div>

    <div class="form-group col-md-5">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" class="form-control"/>
        <span class="campo-invalido"></span>
    </div>

    <div class="form-group col-md-2">
        <label for="nro_docu">N° de Doc.</label>
        <input type="text" id="nro_docu" name="nro_docu" class="form-control"/>
        <span class="campo-invalido"></span>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="domicilio">Domicilio</label>
        <input type="text" id="domicilio" name="domicilio" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="id_dpto">Departamento</label>
        <?php
        generarDepartamentos($conexion);
        ?>
        <span class="campo-invalido"></span>
    </div>
    <div class="form-group col-md-6">
        <label for="id_localidad">Localidad</label>
        <?php
        generarLocalidades($conexion);
        ?>
        <span class="campo-invalido"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="tel_fijo">Tel. Fijo</label>
        <input type="text" id="tel_fijo" name="tel_fijo" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
    <div class="form-group col-md-4">
        <label for="tel_laboral">Tel. Laboral</label>
        <input type="text" id="tel_laboral" name="tel_laboral" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
    <div class="form-group col-md-4">
        <label for="tel_celular">Tel. Celular</label>
        <input type="text" id="tel_celular" name="tel_celular" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="observaciones">Observaciones</label>
        <input type="text" id="observaciones" name="observaciones" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-8">
        <label for="organismo">Organismo</label>
        <?php
        generarOrganismos($conexion);
        ?>
        <span class="campo-invalido"></span>
    </div>
    <div class="form-group col-md-2">
        <label for="legajo">Legajo</label>
        <input type="text" id="legajo" name="legajo" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
    <div class="form-group col-md-2">
        <label for="ingresos">Ingresos</label>
        <input type="text" id="ingresos" name="ingresos" class="form-control" />
        <span class="campo-invalido"></span>
    </div>
</div>
