//var hoy = new Date();
//var fecha = ((hoy.getDate() < 10) ? '0' : '') + hoy.getDate() + '/' + (((hoy.getMonth() + 1) < 10) ? '0' : '') + (hoy.getMonth() + 1) + '/' + hoy.getFullYear();
function errorForm(error, element) {
    error.appendTo(element.next());
}
// Opciones para validate() de persona
var $opcionesPers = {
    rules: {
        nom: {
            required: true
        },
        ape: {
            required: true
        },
        dni: {
            required: true,
            digits: true
        },
        dom: {
            required: true
        },
        idDpto: {
            required: true,
            digits: true
        },
        idLoc: {
            required: true,
            digits: true
        },
        telF: {
            digits: true
        },
        telL: {
            digits: true
        },
        telC: {
            digits: true
        },
        ing: {
            required: true,
            number: true
        },
        idOrg: {
            digits: true
        }
    },
    messages: {
        idDpto: {
            digits: 'Por favor, selecciona un departamento'
        },
        idLoc: {
            digits: 'Por favor, selecciona una localidad'
        },
        idOrg: {
            digits: 'Por favor, selecciona un organismo'
        }

    },
    submitHandler: function (form) {
        let $resp = $('#respuesta');
        let archivoAjax = 'scripts/editar_persona.php';
        let resultAjax = $.post(archivoAjax, $(form).serialize(), null, 'json');
        resultAjax.done(function ($resAjax) {
            $resp.html('<p>' + $resAjax.msj + '</p>');
        });
        resultAjax.fail(function () {
            $resp.html('<p>No se pudo editar. Intente m&aacute;s tarde.</p>');
        });
        divOff($('#btn-form'));
        divOff($('#btn-el'));
        divOff($('#cardForm'));
        divOn($resp);
    },
    errorPlacement: errorForm
};
// Opciones para validate() de crédito
var $opcionesCred = {
    rules: {
        montoCred: {
            required: true
        },
        idOper: {
            required: true,
            digits: true
        }
    },
    messages: {
        idOper: {
            digits: 'Por favor, selecciona una operatoria'
        }
    },
    submitHandler: function (form) {
        let $resp = $('#respuesta');
        let archivoAjax = 'scripts/editar_credito.php';
        let resultAjax = $.post(archivoAjax, $(form).serialize(), null, 'json');
        resultAjax.done(function ($resAjax) {
            $resp.html('<p>' + $resAjax.msj + '</p>');
        });
        resultAjax.fail(function () {
            $resp.html('<p>No se pudo editar. Intente m&aacute;s tarde.</p>');
        });
        divOff($('#btn-form'));
        divOff($('#btn-el'));
        divOff($('#cardForm'));
        divOn($resp);
    },
    errorPlacement: errorForm
};
//Opciones para validate() de plan nuevo
var $opcionesPlan = {
    rules: {
        cantCuotas: {
            required: true,
            number: true
        },
        gastosAdmin: {
            required: true,
            number: true
        },
        seg: {
            required: true,
            number: true
        },
        primerVenc: {
            required: true,
            fechaESP: true
        },
        formaPago: {
            required: true,
            digits: true
        }
    },
    messages: {
        formaPago: {
            digits: 'Por favor, selecciona una forma de pago'
        }
    },
    submitHandler: function (form) {
        let $resp = $('#respuesta');
        let archivoAjax = 'scripts/grabar_plan.php';
        let resultAjax = $.post(archivoAjax, $(form).serialize(), null, 'json');
        resultAjax.done(function ($resAjax) {
            $resp.html('<p>' + $resAjax.msj + '</p>');
        });
        resultAjax.fail(function () {
            $resp.html('<p>No se pudo editar. Intente m&aacute;s tarde.</p>');
        });
        divOff($('#btn-form'));
        divOff($('#btn-el'));
        divOff($('#cardForm'));
        divOn($resp);
    },
    errorPlacement: errorForm
};
function navOff($enl) { // deshabilita las tarjetas habilitadas menos la actual
    $enl.addClass('disabled text-uppercase text-primary font-weight-bold');
    $("div.card-header a").not('.active').each(function () {
        $(this).addClass('disabled');
    });
}
function navOn() {//habilita las tarjetas que estaban deshabilitadas
//$("div.card-body.tab-pane.active.show").find('form'); FALTA COMPLETAR ACCIÓN obtengo el formulario del panel habilitado
    $("div.card-header a.disabled").each(function () {
        $(this).removeClass("disabled");
    });
}
/*function generarLocalidades($idDpto, $idLoc) {//genera las localidades según sea el dpto elegido
 let archivoAjax = 'scripts/localidades.php';
 let resultAjax = $.post(archivoAjax, {id_dpto: $idDpto}, null, 'json');
 resultAjax.done(function (data) {
 $idLoc.empty();
 $.each(data.localidades, function (loca) {
 $idLoc.append('<option value="' + loca.id + '">' + loca.nombre + '</option>');
 });
 });
 resultAjax.fail(function () {
 alert('error localidades');
 });
 }*/
function editar(e, $element, $form) {//Solo deja habilitada la tarjeta que se va a editar
    e.preventDefault();
    navOff($element);
    divOn($('#btn-form'));
    //muestra los botones de envío y cancelación del form
    $('#btn-enviar').attr('data-form', $element.data('form'));
    //quita la propiedad 'deshabilitado' de los imputs del form
    $form.prop("disabled", false);
}

function MostrarCuotaFinal() {
    let cuotaFinal = 0;
    let montoCuota = parseFloat($('#monto').text()) / parseInt($('#cantCuotas').val());
    let seguro = parseFloat($('#seg').val());
    let gastosAdmCuota = parseFloat($('#gastosAdmin').val()) / parseInt($('#cantCuotas').val());
    cuotaFinal = montoCuota + gastosAdmCuota + seguro;
    $('#cuotaFinal').text((isNaN(cuotaFinal)) ? '' : cuotaFinal);
    $('#mct').val((isNaN(cuotaFinal)) ? '' : cuotaFinal);
}

$(function () {
    jQuery.validator.addMethod("fechaESP", function (value, element)
    {
        var validator = this;
        var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
        var fechaCompleta = value.match(datePat);
        if (fechaCompleta == null) {
            $.validator.messages.fechaESP = "La fecha ingresada no es válida";
            return false;
        }
        let dia = fechaCompleta[1];
        let mes = fechaCompleta[3];
        let anio = fechaCompleta[5];
        if (dia < 1 || dia > 31) {
            $.validator.messages.fechaESP = "El valor del día debe estar comprendido entre 1 y 31.";
            return false;
        }
        if (mes < 1 || mes > 12) {
            $.validator.messages.fechaESP = "El valor del mes debe estar comprendido entre 1 y 12.";
            return false;
        }
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) {
            $.validator.messages.fechaESP = "El mes " + mes + " no tiene 31 días!";
            return false;
        }
        if (mes == 2) { // bisiesto
            var bisiesto = (anio % 4 == 0 && (anio % 100 != 0 || anio % 400 == 0));
            if (dia > 29 || (dia == 29 && !bisiesto)) {
                $.validator.messages.fechaESP = "Febrero del " + anio + " no contiene " + dia + " dias!";
                return false;
            }
        }
        let fechaActual = fecha.split('/');
        if (anio < fechaActual[2]) {
            $.validator.messages.fechaESP = "El fecha ingresada en menor que la actual!";
            return false;
        }
        if (anio == fechaActual[2] && mes < fechaActual[1]) {
            $.validator.messages.fechaESP = "El mes ingresado en menor que el actual!";
            return false;
        }
        if (mes == fechaActual[1] && dia < fechaActual[0]) {
            $.validator.messages.fechaESP = "El día ingresado en menor que el actual!";
            return false;
        }
        return true;
    }, "La fecha ingresadan no es válida");

    $('#idDptoTi').on('change', function () {
        $('#idDptoTi option:selected').each(function () {
            generarLocalidades($(this).val(), $("#idLocTi"));
        });
    });
    $('#idDptoCo').on('change', function () {
        $('#idDptoCo option:selected').each(function () {
            generarLocalidades($(this).val(), $("#idLocCo"));
        });
    });
    $('#idDptoGa').on('change', function () {
        $('#idDptoGa option:selected').each(function () {
            generarLocalidades($(this).val(), $("#idLocGa"));
        });
    });
    $('#btn-volver').on('click', menu);
    $('#btn-eliminar').on('click', function (event) {//muestra el modal para confirmar la eliminación
        event.preventDefault();
        $('#elimCred').modal('show');
    });
    $('#btn-aceptar-eliminar').on('click', function (event) {//si se acepta eliminar el crédito
        event.preventDefault();
        let $resp = $('#respuesta');
        let archivoAjax = 'scripts/eliminar_credito.php';
        let resultAjax = $.post(archivoAjax, {t: $('#idTit').val(), c: $('#cred').val(), ctr: $('#ctr').val()}, null, 'json');
        resultAjax.done(function ($resAjax) {
            $resp.html('<p>' + $resAjax.msj + '</p>');
            divOn($resp);
        });
        resultAjax.fail(function () {
            $resp.html('<p>No se pudo efectuar la eliminaci&oacute;n. Intente m&aacute;s tarde.</p>');
            divOn($resp);
        });
        divOff($('#btn-el'));
        divOff($('#cardForm'));
        $('#elimCred').modal('hide');
    });
    $('#btn-editar-ti').on('click', function (event) {
        editar(event, $(this), $("#formTitular :disabled"));
    });
    $('#btn-editar-co').on('click', function (event) {
        editar(event, $(this), $("#formCotitular :disabled"));
    });
    $('#btn-editar-ga').on('click', function (event) {
        editar(event, $(this), $("#formGarante :disabled"));
    });
    $('#btn-editar-cr').on('click', function (event) {
        editar(event, $(this), $("#formCredito :disabled"));
    });
    $('#btn-cancelar').on('click', function (event) {
        event.preventDefault();
        location.reload();
    });
    $('#formTitular').validate($opcionesPers);
    $('#formCotitular').validate($opcionesPers);
    $('#formGarante').validate($opcionesPers);
    $('#formCredito').validate($opcionesCred);
    $('#formNuevoPlan').validate($opcionesPlan);
    $('#btn-enviar').on('click', function (event) {//si elijo enviar el formulario de edición 
        event.preventDefault();
        switch ($(this).data('form')) {//determino cuál form se quiere enviar
            case 'ti':
                $('#formTitular').submit();
                break;
            case 'co':
                $('#formCotitular').submit();
                break;
            case 'ga':
                $('#formGarante').submit();
                break;
            case 'cr':
                $('#formCredito').submit();
                break;
            case 'pl':
                $('#formNuevoPlan').submit();
                break;
            default:
                let $resp = $('#respuesta');
                $resp.html('<p>No se pudo editar. Intente m&aacute;s tarde.</p>');
                divOff($('#btn-form'));
                divOff($('#btn-el'));
                divOff($('#cardForm'));
                divOn($resp);
                break;
        }
    });
    $('#btn-nuevo-plan').on('click', function (event) {
        event.preventDefault();
        navOff($(this));
        divOff($("#tablaPlanes"));
        divOn($("#nuevoPlan"));
        divOn($('#btn-form'));
        $('#btn-enviar').attr('data-form', $(this).data('form'));
    });
    $('[data-plancuota]').on('click', function (event) {
        event.preventDefault();
    });
    $('[data-planeditar]').on('click', function (event) {
        event.preventDefault();
    });
    $('[data-planeliminar]').on('click', function (event) {
        event.preventDefault();
    });
    $('#cantCuotas').on('focusout', MostrarCuotaFinal);
    $('#seg').on('focusout', MostrarCuotaFinal);
    $('#gastosAdmin').on('focusout', MostrarCuotaFinal);
    $('#primerVenc').datepicker({
        closeText: "Cerrar",
        prevText: "&#x3C;Ant",
        nextText: "Sig&#x3E;",
        currentText: "Hoy",
        monthNames: ["enero", "febrero", "marzo", "abril", "mayo", "junio",
            "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"],
        monthNamesShort: ["ene", "feb", "mar", "abr", "may", "jun",
            "jul", "ago", "sep", "oct", "nov", "dic"],
        dayNames: ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"],
        dayNamesShort: ["dom", "lun", "mar", "mié", "jue", "vie", "sáb"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        weekHeader: "Sm",
        dateFormat: "dd/mm/yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: "",
        minDate: fecha});
});

