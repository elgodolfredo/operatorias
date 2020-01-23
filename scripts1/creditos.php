<?php
//session_start();
include 'chequear_sesion.php'
?>
<!--<script type="text/javascript" src="js/jsTitular.js?<?php //echo time();                                                                                                   ?>"></script>-->
<script src="js/libs/jquery-validate/jquery.validate.min.js"></script>
<script src="js/libs/jquery-validate/messages_es.js"></script>
<script src="js/libs/jquery.datetimepicker.js"></script>

<link href="css/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
<script>
    var id_credito_maestro;
    var monto;
    var pje_gastos_adm;
    var pje_interes_punitorio;
    var monto_seguro;
    pje_gastos_adm = sessionStorage.pje_gastos_adm;


    function setearClickBtnCuotas() {
        $('.btn-cuotas-plan').on('click', function () {
            var id = $(this).attr('data-id');
            id_plan_maestro = id; // recordar el credito seleccionado
            var archivoAjax = 'scripts/get_cuotas_plan.php?jsoncallback=?';
            var resultAjax = $.getJSON(archivoAjax, {id: id});

            resultAjax.done(function (data) {  // formatNumber.new(plan.pje_interes_punitorio)
                var filasCuotas = '';
                if (data.resultado == 'ok') {
                    var filasPlanes = '';
                    $('#tbl-cuotas-plan tbody').empty();
                    $.each(data.cuotas, function (l, cuota) {
                        var interes_punitorio = (cuota.a_pagar_sin_puni * cuota.pje_interes_punitorio / 100) * cuota.dias_en_mora;
                        var a_pagar = cuota.a_pagar_sin_puni + interes_punitorio;
                        cuota.fecha_pago = (cuota.fecha_pago == null) ? '' : cuota.fecha_pago;
                        filasCuotas = filasCuotas + '<tr> <td>' + cuota.nro_orden + '</td> <td>' + cuota.fecha_venc + '</td> <td>' + cuota.fecha_pago + '</td> <td>' + cuota.forma_de_pago + ' </td> <td>' + formatNumber.new(cuota.monto) + '</td> <td> Gastos adm.. </td> <td> ' + formatNumber.new(cuota.seguro) + '</td> <td>' + formatNumber.new(cuota.a_pagar_sin_puni) + '</td> <td>' + cuota.dias_en_mora + '</td> <td>' + formatNumber.new(interes_punitorio) + '</td> <td>' + formatNumber.new(a_pagar) + '</td> <td> <a class="w3-btn w3-yellow w3-small" data-id="' + cuota.id + '">Editar</a> <a class="w3-btn w3-red w3-small" data-id="' + cuota.id + '">Eliminar</a> </td> </tr>';
                    });
                    $('#tbl-cuotas-plan tbody').append(filasCuotas);
                } else {
                    alertar(data.mensaje);
                }

                var alto = $(window).height() * 0.8;
                $('#dialog-cuotas-plan').dialog('option', 'width', '80%');
                $('#dialog-cuotas-plan').dialog('option', 'height', alto);
                $('#dialog-cuotas-plan').dialog('open');
            });

            resultAjax.fail(function () {
                alertar('No se puede acceder a las cuotas en este momento');
            });
        });
    }
    ;

    $(function () {
        // Config dialogo editar credito
        $('#dialog-edit-credito').dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            closeOnEscape: false,
            open: function (event, ui) {
                //hide close button.
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },
            buttons: {
                "Aceptar": function () {
                    // Ejecuto la validacion del formulario
                    $('#form-credito').validate({
                        rules: {
                            titular: {
                                required: true
                            },
                            monto_total: {
                                required: true,
                                number: true
                            },
                            id_operatoria: {
                                required: true,
                                range: [1, 1000] // Para validar que sea mayor a cero
                            }
                        },
                        messages: {
                            id_operatoria: {
                                range: 'Selecciones una de las operatorias'
                            }
                        },
                        errorPlacement: function (error, element) {
                            error.appendTo(element.prev());
                        }
                    });

                    // Si el form es valido, envio los datos y cierro el dialogo
                    if ($('#form-credito').valid()) {
                        var id = document.querySelector('#id').value;
                        var id_titular = document.querySelector('#id_titular').value;
                        var monto_total = document.querySelector('#monto_total').value;
                        var id_operatoria = document.querySelector('#id_operatoria').value;

                        // Envio los datos al servidor via ajax
                        var archivoAjax = 'scripts/grabar_credito.php?jsoncallback=?';
                        var resultadoAjax = $.getJSON(archivoAjax, {id: id, id_titular: id_titular, monto_total: monto_total, id_operatoria: id_operatoria});

                        resultadoAjax.done(function (data) {
                            alertar(data.mensaje);
                            location.reload(true); // Refresco la pagina
                        });

                        resultadoAjax.fail(function () {
                            alertar('No se pudo registrar el credito');
                        });

                        //$('#form-titular').submit();
                        $(this).dialog("close");
                        document.querySelector('#form-credito').reset();
                    }
                },
                "Cerrar": function () {
                    // Finalmente, cierro el dialogo
                    $(this).dialog("close");
                    document.querySelector('#form-credito').reset();
                }
            }
        });

        // Dialogo de buscar titular
        $('#dialog-buscar-titular').dialog({
            autoOpen: false,
            modal: true,
            width: 'auto',
            height: 'auto',
            rezisable: false
        });

        // Click del boton buscar titular
        $('#btn-buscar-titular').on('click', function () {
            //$("#dialog-buscar-titular").dialog("option", "width", 500);
            //$("#dialog-buscar-titular").dialog("option", "height", 200);

            document.querySelector('#txt-titular-buscado').value = '';
            $('#tbl-titulares-buscados').empty();
            $("#dialog-buscar-titular").dialog("open");
        });

        // Al pulsar ENTER en la txt de busqueda de titular, busco y muestro el resultado
        $('#txt-titular-buscado').on('keypress', function (e) {
            if (e.keyCode == 13) {
                var buscado = $('#txt-titular-buscado').val();
                var archivoAjax = 'scripts/obtener_titulares.php?jsoncallback=?';
                var resultAjax = $.getJSON(archivoAjax, {buscado: buscado});

                resultAjax.done(function (data) {
                    if (data.resultado == 'ok') {
                        $('#tbl-titulares-buscados').empty();
                        $.each(data.titulares, function (i, titu) {
                            $('#tbl-titulares-buscados').append('<tr> <td><a class="titular-elegido" href="#" data-id="' + titu.id + '">' + titu.fullname + '</a></td> <td>' + titu.nro_docu + '</td> </tr>');
                        });

                        $('.titular-elegido').on('click', function () {
                            $('#id_titular').val($(this).attr('data-id'));
                            $('#titular').val($(this).text());
                            $('#dialog-buscar-titular').dialog('close');
                        });
                    }
                });
            }
        });

        // Click del boton nuevo credito
        $('#btn-nuevo-credito').on('click', function () {
            document.querySelector('#form-credito').reset();
            $("#dialog-edit-credito").dialog("option", "width", 600);
            $("#dialog-edit-credito").dialog("option", "height", 400);
            $("#dialog-edit-credito").dialog("open");
        });

        // Click de los botones editar
        $('.btn-editar-credito').on('click', function () {
            // Consulto con ajax, los datos del registro que quiero editar y relleno el fomulario antes de mostrarlo
            var id = $(this).attr('data-id');
            var archivoAjax = 'scripts/get_credito.php?jsoncallback=?';
            var resultAjax = $.getJSON(archivoAjax, {id: id});

            resultAjax.done(function (data) {
                document.querySelector('#id').value = data.id;
                document.querySelector('#id_titular').value = data.id_titular;
                document.querySelector('#titular').value = data.fullname;
                document.querySelector('#monto_total').value = data.monto_total;
                document.querySelector('#id_operatoria').value = data.id_operatoria;
                //$('#gastos_adm').val(montoGastosAdm);

                $("#dialog-edit-credito").dialog("option", "width", 600);
                $("#dialog-edit-credito").dialog("option", "height", 400);
                $("#dialog-edit-credito").dialog("open");
            });
        });

        $('.btn-planes-pago').on('click', function () {
            var id = $(this).attr('data-id');
            id_credito_maestro = id; // recordar el credito seleccionado
            monto = $(this).attr('data-saldo');
            montoGastosAdm = (monto * pje_gastos_adm / 100);
            pje_interes_punitorio = $(this).attr('data-pje_int_pun');
            monto_seguro = $(this).attr('data-seguro');

            var archivoAjax = 'scripts/get_planes_pago.php?jsoncallback=?';
            var resultAjax = $.getJSON(archivoAjax, {id: id});

            resultAjax.done(function (data) {
                if (data.resultado == 'ok') {
                    var filasPlanes = '';
                    $('#tbl-planes-pago tbody').empty();
                    $.each(data.planes, function (l, plan) {
                        filasPlanes = filasPlanes + '<tr> <td>' + formatNumber.new(plan.monto) + '</td> <td>' + plan.cantidad_cuotas + '</td> <td>' + formatNumber.new(plan.pje_interes_punitorio) + '</td>  <td> <a class="btn-cuotas-plan w3-btn w3-blue w3-small" data-id="' + plan.id + '">Cuotas</a> </td> </tr>';
                    });
                    $('#tbl-planes-pago tbody').append(filasPlanes);

                    // Creo el manejador del evento click de los botones de ver las cuotas (no lo hago el ready ya que en ese momento estos botones todavia no existen
                    setearClickBtnCuotas();
                } else {
                    alertar(data.mensaje);
                }

                $('#dialog-planes-pago').dialog("option", "width", 1000);
                $("#dialog-planes-pago").dialog("open", "height", 'auto');
            });

            resultAjax.fail(function () {
                //
            });
        });




        /*********************************************** scripts de planes de pago *******************************************/

        $('#fecha_primer_venc').datetimepicker({
            lang: 'es',
//        i18n: {
//            de: {
//                months: [
//                    'Enero', 'Febrero', 'Marzo', 'Abril',
//                    'Mayo', 'Junio', 'Julio', 'Agosto',
//                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
//                ],
//                dayOfWeek: [
//                    "Do.", "Lu", "Ma", "Mi",
//                    "Ju", "Vi", "Sa.",
//                ]
//            }
//        },
            timepicker: false,
            format: 'Y-m-d'
        });


        $('#dialog-edit-plan').dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            closeOnEscape: false,
            open: function (event, ui) {
                //hide close button.
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },
            buttons: {
                "Aceptar": function () {
                    // Ejecuto la validacion del formulario
                    $('#form-plan').validate({
                        rules: {
                            monto: {
                                required: true,
                                number: true
                            },
                            cantidad_cuotas: {
                                required: true,
                                number: true
                            },
                            gastos_adm: {
                                required: true,
                                number: true
                            },
                            pje_interes_punitorio: {
                                required: true,
                                number: true
                            },
                            monto_seguro: {
                                required: true,
                                number: true
                            },
                            fecha_primer_venc: {
                                required: true
                            },
                            id_forma_de_pago: {
                                required: true
                            }
                        },
                        errorPlacement: function (error, element) {
                            error.appendTo(element.prev());
                        }
                    });

                    // Si el form es valido, envio los datos y cierro el dialogo
                    if ($('#form-plan').valid()) {
                        var id_credito = document.querySelector('#id_credito').value;
                        var monto = document.querySelector('#monto').value;
                        var gastos_adm = document.querySelector('#gastos_adm').value;
                        var pje_interes_punitorio = document.querySelector('#pje_interes_punitorio').value;
                        var cantidad_cuotas = document.querySelector('#cantidad_cuotas').value;
                        var monto_cuota = document.querySelector('#cuota_final').value;
                        var fecha_primer_venc = document.querySelector('#fecha_primer_venc').value;
                        var monto_seguro = document.querySelector('#monto_seguro').value;
                        var id_forma_de_pago = document.querySelector('#id_forma_de_pago').value;

                        // Envio los datos al servidor via ajax
                        var archivoAjax = 'scripts/grabar_plan.php?jsoncallback=?';
                        var resultadoAjax = $.getJSON(archivoAjax, {id_credito: id_credito, monto: monto, gastos_adm: gastos_adm, pje_interes_punitorio: pje_interes_punitorio, cantidad_cuotas: cantidad_cuotas, monto_cuota: monto_cuota, fecha_primer_venc: fecha_primer_venc, monto_seguro: monto_seguro, id_forma_de_pago: id_forma_de_pago});


                        resultadoAjax.done(function (data) {
                            alertar(data.mensaje);
                            location.reload(true); // Refresco la pagina
                        });

                        resultadoAjax.fail(function () {
                            alertar('No se pudo crear el plan de pago 2');
                        });

                        $(this).dialog("close");
                        document.querySelector('#form-plan').reset();
                    }
                },
                "Cerrar": function () {
                    // Finalmente, cierro el dialogo
                    $(this).dialog("close");
                    document.querySelector('#form-plan').reset();
                }
            }
        });

        // Click del boton nuevo plan
        $('#btn-nuevo-plan').on('click', function () {
            document.querySelector('#form-plan').reset();
            $('.campo-invalido').val('');
            $('#id_credito').val(id_credito_maestro);
            $('#monto').val(monto);
            $('#gastos_adm').val(montoGastosAdm);
            $('#pje_interes_punitorio').val(pje_interes_punitorio);
            $('#monto_seguro').val(monto_seguro);
            $('#txt-info-credito').val('Credito N&deg;: ' + id_credito_maestro);

            $("#dialog-edit-plan").dialog("option", "width", 500);
            //$("#dialog-edit-plan").dialog("option", "height", 400);
            $("#dialog-edit-plan").dialog("open");
        });

        // Dialogo planes de pago
        $('#dialog-planes-pago').dialog({
            autoOpen: false,
            modal: true
        });

        // Dialogo planes de pago
        $('#dialog-cuotas-plan').dialog({
            autoOpen: false,
            modal: true
        });


    });
</script>
<script>
    // Script para calcular y mostrar el monto final a abonar por cuota
    function MostrarCuotaFinal() {
        cuota_final = 0;
        monto_cuota = parseFloat(document.getElementById('monto').value) / parseInt(document.getElementById('cantidad_cuotas').value);
        seguro = parseFloat(document.getElementById('monto_seguro').value);
        gastos_adm_cuota = parseFloat(document.getElementById('gastos_adm').value) / parseInt(document.getElementById('cantidad_cuotas').value);
        cuota_final = monto_cuota + gastos_adm_cuota + seguro;
        document.getElementById('cuota_final').value = (isNaN(cuota_final)) ? '' : cuota_final;
    }
</script>
<?php
if (!$conexion) {
    $error = 'Error de conexion';
} else {
// Cargo la configuracion del sistema
    $scriptSeteaConfig = cargarConfiguracion($mysqli); // A partir de aca tengo la variable $_SESSION['config']

    $accion = $_REQUEST['accion'];

    $consulta = "select `creditos_full`.`id`, concat(apellido, ', ', `creditos_full`.`nombre`) as persona, nro_docu, monto_total, saldo, `operatorias`.`pje_interes_punitorio`, `operatorias`.`seguro`, `operatorias`.`nombre` as `operatoria` from creditos_full inner join `operatorias` on (creditos_full.`id_operatoria` = `operatorias`.id)";

    $resultado = @mysqli_query($conexion, $consulta);
    if (!$resultado) {
        $error = 'No se puede acceder a los datos.';
    } else {
        ?>
        <!-- Aca se coloca el boton para agregar un registro y la lista de titulares -->
        <div>
            <?php
            if (isset($error)) {
                echo "<div class='w3-panel w3-pale-red'><p>$error</p></div>";
            } else {
                ?>
                <!-- Dialogo para buscar un titular para el credito -->
                <div id="dialog-buscar-titular" title="Buscar titular" class="w3-container">
                    <label for="txt-titular-buscado" class="w3-label">Ingrese el nombre, apellido o documento del titular del credito</label>
                    <input type="text" id="txt-titular-buscado" class="w3-input w3-border">
                    <p>
                    <table class="w3-table w3-border" id="tbl-titulares-buscados">
                    </table>
                </div>

                <!-- Dialogo con formulario para editar un credito -->
                <div id="dialog-edit-credito" title="Editar credito" class="w3-container">
                    <form id="form-credito">
                        <input type="hidden" id="accion" name="accion" />
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="id_titular" name="id_titular" value="0" >

                        <label for="titular" class="w3-label">Titular</label>
                        <span class="campo-invalido"></span>					
                        <input type="text" id="titular" name="titular" value="" readonly="readonly" class="w3-input w3-border">
                        <!-- Boton para abrir el dialogo de busqueda de titular -->
                        <a id="btn-buscar-titular" class="w3-btn w3-teal w3-tiny">...</a>
                        <p></p>
                        <label for="monto_total" class="w3-label">Monto Total</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="monto_total" name="monto_total" class="w3-input w3-border"/>		  			
                        <p></p>
                        <label for="id_operatoria" class="w3-label">Operatoria</label>
                        <span class="campo-invalido"></span>
                        <?php
                        generarSelectOperatorias($conexion);
                        ?>

                    </form>				
                </div>

                <!-- Dialogo con formulario para editar un plan -->
                <div id="dialog-edit-plan" title="Editar plan" class="w3-container">
                    <form id="form-plan">
                        <input type="hidden" id="id" name="id" value="0" class="w3-input w3-border">
                        <input type="hidden" id="id_credito" name="id_credito" class="w3-input w3-border">

                        <label for="monto" class="w3-label">Monto</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="monto" name="monto" value="<?php echo $_POST['saldo']; ?>" readonly="readonly" disabled="disabled" class="w3-input w3-border w3-right-align"/>

                        <label for="cantidad_cuotas" class="w3-label">Cantidad de Cuotas</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="cantidad_cuotas" name="cantidad_cuotas" class="w3-input w3-border w3-right-align" onchange="MostrarCuotaFinal()"/>

                        <label for="gastos_adm" class="w3-label">Gastos administrativos</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="gastos_adm" name="gastos_adm" value="<?php echo $montoGastosAdm; ?>" class="w3-input w3-border w3-right-align" onchange="MostrarCuotaFinal()"/>

                        <label for="pje_interes_punitorio" class="w3-label">Interes Punitorio (%)</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="pje_interes_punitorio" name="pje_interes_punitorio" value="<?php echo $_POST['pje_interes_punitorio']; ?>" readonly="readonly" disabled="disabled" class="w3-input w3-border w3-right-align"/>

                        <label for="monto_seguro" class="w3-label">Seguro</label>
                        <input type="text" id="monto_seguro" name="monto_seguro" value="<?php echo $_POST['seguro']; ?>" class="w3-input w3-border w3-right-align" onchange="MostrarCuotaFinal()"/>

                        <label for="fecha_primer_venc" class="w3-label">Primer vencimiento</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="fecha_primer_venc" name="fecha_primer_venc" placeholder="Primer vencimiento" class="w3-input w3-border"/>

                        <label for="id_forma_de_pago" class="w3-label">Forma de Pago</label>
                        <span class="campo-invalido"></span>
                        <select id="id_forma_de_pago" name="id_forma_de_pago" class="w3-input w3-border">
                            <option value="">Seleccione Una Opci&oacute;n</option>
                            <option value="1">Debito</option>
                            <option value="2">Chequera</option>
                            <option value="3">Otros</option>
                        </select>

                        <label for="cuota_final" class="w3-label">Monto total de la cuota</label>
                        <span class="campo-invalido"></span>
                        <input type="text" id="cuota_final" readonly="readonly" disabled="disabled" class="w3-input w3-border w3-right-align">
                    </form>				
                </div>		

                <!-- Dialogo con listado de planes de pago para un credito especifico -->
                <div id="dialog-planes-pago" title="Planes de Pago" class="w3-container">
                    <p id="txt-info-credito"></p>
                    <a id="btn-nuevo-plan" class='w3-btn w3-grey w3-small'>Nuevo</a>
                    <div class="w3-padding-16">
                        <table id="tbl-planes-pago" class="w3-table w3-striped w3-hoverable w3-centered">
                            <thead>
                                <tr class="w3-teal">
                                    <th style="width: 25%;">Monto</th>
                                    <th style="width: 25%;">Cuotas</th>
                                    <th style="width: 25%;">Pje. de Interes</th>
                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>	
                    </div>
                </div>

                <!-- Dialogo con listado de cuotas para un plan de pago especifico -->
                <div id="dialog-cuotas-plan" title="Cuotas" class="w3-container">
                    <p id="txt-info-plan"></p>
                    <div class="w3-padding-16">
                        <table id="tbl-cuotas-plan" class="w3-table w3-striped w3-hoverable w3-centered">
                            <thead>
                                <tr class="w3-teal">
                                    <th>Cuota N&deg;</th>
                                    <th>Fecha Vto.</th>
                                    <th>Fecha pago</th>
                                    <th>Forma de pago</th>
                                    <th>Monto</th>
                                    <th>Gastos Adm.</th>
                                    <th>Seguro</th>
                                    <th>Subtotal</th>
                                    <th>Dias en mora</th>
                                    <th>Interes punitorio</th>
                                    <th>A pagar</th>
                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>	
                    </div>
                </div>                

                <h3>Creditos</h3>
                <a id="btn-nuevo-credito" class='w3-btn w3-grey w3-small'>Nuevo</a>

                <div class="w3-padding-16">
                    <table id="listadoCreditos" class="w3-table w3-striped w3-hoverable w3-centered">
                        <thead>
                            <tr class="w3-teal">
                                <th>N&deg; de Credito</th>
                                <th>Titular</th>
                                <th>Nro. Docu</th>
                                <th>Operatoria</th>
                                <th>Monto Total</th>
                                <th>Saldo</th>
                                <th>% Int. Adm.</th>
                                <th>Seguro</th>
                                <th colspan="3">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                extract($fila);
                                echo "<tr> <td>$id</td> <td>$persona</td> <td>$nro_docu</td> <td>$operatoria</td> <td class='w3-right-align'>" . formatearMoneda($monto_total) . "</td> <td class='w3-right-align'>" . formatearMoneda($saldo) . "</td> <td class='w3-right-align'>" . formatearMoneda($pje_interes_punitorio) . "</td> <td class='w3-right-align'>" . formatearMoneda($seguro) . "</td> <td><a class='btn-planes-pago w3-btn w3-teal w3-small' data-id='$id' data-saldo='$saldo' data-pje_int_pun='$pje_interes_punitorio' data-seguro='$seguro'>Planes de Pago</a></td> <td><a data-id='$id' class='btn-editar-credito w3-btn w3-teal w3-small'>Editar</a></td> <td><a data-id='$id' class='btn-eliminar-credito w3-btn w3-red w3-small'>Eliminar</a></td> </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>

        </div>
        <?php
    }
}
?>