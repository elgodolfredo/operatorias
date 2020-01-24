var hoy = new Date();
var fecha = ((hoy.getDate() < 10) ? '0' : '') + hoy.getDate() + '/' + (((hoy.getMonth() + 1) < 10) ? '0' : '') + (hoy.getMonth() + 1) + '/' + hoy.getFullYear();

function labelError(selector) {
    var retorno = false;
    selector.each(function () {
        if($(this).text() !== '') {
            retorno = true;
            return;
        }
    });
    return retorno;
}

var $opcionesFor = {
    ignore: "",
    rules: {
        nomTit: {
            required: true
        },
        apeTit: {
            required: true
        },
        dniTit: {
            required: true,
            digits: true
        },
        domTit: {
            required: true
        },
        idDptoTit: {
            required: true,
            digits: true
        },
        idLocTit: {
            required: true,
            digits: true
        },
        telFTit: {
            digits: true
        },
        telLTit: {
            digits: true
        },
        telCTit: {
            digits: true
        },
        idOrgTit: {
            required: true,
            digits: true
        },
        ingTit: {
            required: true,
            number: true
        },
        nomCot: {
            required: true
        },
        apeCot: {
            required: true
        },
        dniCot: {
            required: true,
            digits: true
        },
        domCot: {
            required: true
        },
        idDptoCot: {
            required: true,
            digits: true
        },
        idLocCot: {
            required: true,
            digits: true
        },
        telFCot: {
            digits: true
        },
        telLCot: {
            digits: true
        },
        telCCot: {
            digits: true
        },
        idOrgCot: {
            required: true,
            digits: true
        },
        ingCot: {
            required: true,
            number: true
        },
        nomGar: {
            required: true
        },
        apeGar: {
            required: true
        },
        dniGar: {
            required: true,
            digits: true
        },
        domGar: {
            required: true
        },
        idDptoGar: {
            required: true,
            digits: true
        },
        idLocGar: {
            required: true,
            digits: true
        },
        telFGar: {
            digits: true
        },
        telLGar: {
            digits: true
        },
        telCGar: {
            digits: true
        },
        ingGar: {
            required: true,
            number: true
        },
        idOrgGar: {
            required: true,
            digits: true
        },
        monto: {
            required: true
        },
        idOper: {
            required: true,
            digits: true
        },
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
        idDptoTit: {
            digits: 'Por favor, selecciona un departamento'
        },
        idLocTit: {
            digits: 'Por favor, selecciona una localidad'
        },
        idOrgTit: {
            digits: 'Por favor, selecciona un organismo'
        },
        idDptoCot: {
            digits: 'Por favor, selecciona un departamento'
        },
        idLocCot: {
            digits: 'Por favor, selecciona una localidad'
        },
        idOrgCot: {
            digits: 'Por favor, selecciona un organismo'
        },
        idDptoGar: {
            digits: 'Por favor, selecciona un departamento'
        },
        idLocGar: {
            digits: 'Por favor, selecciona una localidad'
        },
        idOrgGar: {
            digits: 'Por favor, selecciona un organismo'
        },
        idOper: {
            digits: 'Por favor, selecciona una operatoria'
        },
        formaPago: {
            digits: 'Por favor, selecciona una forma de pago'
        }

    },
    invalidHandler: function (event, validator) {
        $('#errorTit').text('');
        $('#errorCotit').text('');
        $('#errorGar').text('');
        $('#errorCred').text('');
        $('#errorPlan').text('');
        if(typeof validator.invalid.nomTit !== 'undefined' || typeof validator.invalid.apeTit !== 'undefined' || typeof validator.invalid.dniTit !== 'undefined' || typeof validator.invalid.domTit !== 'undefined' || typeof validator.invalid.idDptoTit !== 'undefined' || typeof validator.invalid.idLocTit !== 'undefined' || typeof validator.invalid.idOrgTit !== 'undefined' || typeof validator.invalid.ingTit !== 'undefined'){
            $('#errorTit').text(' *');
        }
        if(typeof validator.invalid.nomCot !== 'undefined' || typeof validator.invalid.apeCot !== 'undefined' || typeof validator.invalid.dniCot !== 'undefined' || typeof validator.invalid.domCot !== 'undefined' || typeof validator.invalid.idDptoCot !== 'undefined' || typeof validator.invalid.idLocCot !== 'undefined' || typeof validator.invalid.idOrgCot !== 'undefined' || typeof validator.invalid.ingCot !== 'undefined'){
            $('#errorCotit').text(' *');
        }
        if(typeof validator.invalid.nomGar !== 'undefined' || typeof validator.invalid.apeGar !== 'undefined' || typeof validator.invalid.dniGar !== 'undefined' || typeof validator.invalid.domGar !== 'undefined' || typeof validator.invalid.idDptoGar !== 'undefined' || typeof validator.invalid.idLocGar !== 'undefined' || typeof validator.invalid.idOrgGar !== 'undefined' || typeof validator.invalid.ingGar !== 'undefined'){
            $('#errorGar').text(' *');
        }
        if(typeof validator.invalid.monto !== 'undefined' || typeof validator.invalid.idOper !== 'undefined'){
            $('#errorCred').text(' *');
        }
        if(typeof validator.invalid.cantCuotas !== 'undefined' || typeof validator.invalid.formaPago !== 'undefined' || typeof validator.invalid.gastosAdmin !== 'undefined' || typeof validator.invalid.primerVenc !== 'undefined' || typeof validator.invalid.seg !== 'undefined'){
            $('#errorPlan').text(' *');
        }
     },
    submitHandler: function (form) {
        let $resp = $('#resultado');
        let archivoAjax = 'scripts/grabar_nuevo.php';
        let resultAjax = $.post(archivoAjax, $(form).serialize(), null, 'json');
        resultAjax.done(function ($resAjax) {
            $resp.text($resAjax.msj);
        });
        resultAjax.fail(function () {
            $resp.text('No se pudo editar. Intente m&aacute;s tarde.');
        });
        divOff($('#btn-form'));
        divOff($('#btn-el'));
        divOff($('#cardForm'));
        divOn($('#respuesta'));
    },
    errorPlacement: function (error, element) {
        error.appendTo(element.next());
    }
};

function habilitarForm($this, band) {
    $this.prop("disabled", band);
    if (band) {
        $this.val('');
    }
    return;
}
function MostrarCuotaFinal() {
    let cuotaFinal = 0;
    let montoCuota = parseFloat($('#montoPlan').text()) / parseInt($('#cantCuotas').val());
    let seguro = parseFloat($('#seg').val());
    let gastosAdmCuota = parseFloat($('#gastosAdmin').val()) / parseInt($('#cantCuotas').val());
    cuotaFinal = montoCuota + gastosAdmCuota + seguro;
    $('#cuotaFinal').text((isNaN(cuotaFinal)) ? '' : cuotaFinal);
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
            $.validator.messages.fechaESP = "El fecha ingresada es menor que la actual!";
            return false;
        }
        if (anio == fechaActual[2] && mes < fechaActual[1]) {
            $.validator.messages.fechaESP = "El mes ingresado es menor que el actual!";
            return false;
        }
        if (mes == fechaActual[1] && dia < fechaActual[0]) {
            $.validator.messages.fechaESP = "El día ingresado es menor que el actual!";
            return false;
        }
        return true;
    }, "La fecha ingresadan no es válida");
    var validator = $('#formNuevo').validate($opcionesFor);
    $('#btn-cancelar').on('click', menu);
    $('#btn-enviar').on('click', function (event) {
        event.preventDefault();
        $('#formNuevo').submit();
    });
    $('#idDptoTit').on('change', function () {
        $('#idDptoTit option:selected').each(function () {
            generarLocalidades($(this).val(), $("#idLocTit"));
        });
    });
    $('#idDptoCot').on('change', function () {
        $('#idDptoCot option:selected').each(function () {
            generarLocalidades($(this).val(), $("#idLocCot"));
        });
    });
    $('#idDptoGar').on('change', function () {
        $('#idDptoGar option:selected').each(function () {
            generarLocalidades($(this).val(), $("#idLocGar"));
        });
    });
    $('#btn-agregar-cotit').on('change', function () {
        let band = (!$(this).is(':checked'));
        $("#cotit-card .form-control").each(function () {
            habilitarForm($(this), band);
        });
        if (band) {
            $("#cotit-card label.error").each(function () {
                $(this).text('');
            });
        }
    });
    $('#btn-agregar-garate').on('change', function () {
        let band = (!$(this).is(':checked'));
        $("#gar-card .form-control").each(function () {
            habilitarForm($(this), band);
        });
        if (band) {
            $("#gar-card label.error").each(function () {
                $(this).text('');
            });
        }
    });
    $('#btn-agregar-plan').on('change', function () {
        let band = (!$(this).is(':checked'));
        if (!band && ($('#monto').val() === '' || $('#idOper').val() === '')) {
            $(this).prop('checked', false);
            $('#completarCred').modal('show');
        } else {
            $("#plan-card .form-control").each(function () {
                habilitarForm($(this), band);
            });
            if (band) {
                $("#plan-card label.error").each(function () {
                    $(this).text('');
                });
            }
        }
    });
    $('#btn-aceptar-alerta').on('click', function () {
        $('#completarCred').modal('hide');
        $('.nav-item a[href="#cred-card"]').tab('show');
    });
    $('#monto').on('change', function () {
        $('#montoPlan').text($(this).val());
    });
    $('#idOper').on('change', function () {
        let int = $(this).find(':selected').data('pip');
        $('#intPun').text(int);
        $('#ipn').val(int);

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






    /*$('#dniTit').on('focusout', function(){
     verifTitular($(this).val());
     });*/
});
