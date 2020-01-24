function listarTitulares(accion) {
    var archivoAjax = 'scripts/get_titulares.php';
    var resultAjax = $.getJSON(archivoAjax, {
        tipo_persona: accion
    });

    console.log('antes...');

    resultAjax.done(function (data) {

        var fragmento = '';

        if (data.resultado === 'ok') {

            // Generar el html con los resultados de la consulta
            $.each(data.items, function (i, item) {
                //fragmento = fragmento + "<tr> <td>" + item.nombre + "</td> <td>" + item.apellido + "</td><td class='text-right'>" + item.nro_docu + "</td> <td> <a data-id='" + item.id + "' class='btn btn-sm btn-success btn-editar-titular'>Editar</a> <a data-id='" + item.id + "' class='btn btn-sm btn-danger btn-eliminar-titular'>Eliminar</a> </td> </tr>";
                fragmento = fragmento + "<tr> <td>" + item.nombre + "</td> <td>" + item.apellido + "</td><td class='text-right'>" + item.nro_docu + "</td>";
                fragmento = fragmento + "<td> <button type='button' data-id='" + item.id + "' class='btn btn-sm btn-success btn-editar-titular' data-toggle='modal' data-target='#dialog-edit-tit'>Editar</button> <button type='button' data-id='" + item.id + "' class='btn btn-sm btn-danger btn-eliminar-titular'>Eliminar</button> </td> </tr>";
                document.querySelector('#listaTitularesOK').innerHTML = fragmento;
            });

            // Asociar los manejadores de eventos   btn-eliminar-titular

            // Click de los botones eliminar
            $('.btn-eliminar-titular').on('click', function () {
                if (confirm('Confirma eliminar este registro?')) {
                    var id = $(this).attr('data-id');
                    var archivoAjax = 'scripts/eliminar_titular.php';
                    var resultAjax = $.getJSON(archivoAjax, {
                        id: id,
                        tipo_persona: accion
                    });

                    resultAjax.done(function (data) {
                        listarTitulares(accion);
                        mostrarNotif(data.mensaje, 1);
                    });

                    resultAjax.fail(function () {
                        mostrarNotif('No se pudo realizar la operacion');
                    });
                }
            });

            // Click de los botones editar
            $('.btn-editar-titular').on('click', function () {
                // Consulto con ajax, los datos del registro que quiero editar y relleno el fomulario antes de mostrarlo
                var id = $(this).attr('data-id');
                var archivoAjax = 'scripts/get_titular.php';
                var resultAjax = $.getJSON(archivoAjax, {
                    id: id,
                    tipo_persona: accion
                });

                resultAjax.done(function (data) {
                    if (data.resultado === 'ok') {
                        // Rellenar el formulario y mostrar el dialogo
                        document.querySelector('#id').value = data.id;
                        document.querySelector('#id_persona').value = data.id_persona;

                        if (data.id_titular != undefined) {
                            // Es un cotitular o garante
                            document.querySelector('#id_titular').value = data.id_titular;
                            document.querySelector('#titular').value = data.titular;
                        }

                        document.querySelector('#nombre').value = data.nombre;
                        document.querySelector('#apellido').value = data.apellido;
                        document.querySelector('#nro_docu').value = data.nro_docu;
                        document.querySelector('#domicilio').value = data.domicilio;
                        document.querySelector('#id_dpto').value = data.id_dpto;
                        document.querySelector('#id_localidad').value = data.id_localidad;
                        document.querySelector('#tel_fijo').value = data.tel_fijo;
                        document.querySelector('#tel_laboral').value = data.tel_laboral;
                        document.querySelector('#tel_celular').value = data.tel_celular;
                        document.querySelector('#observaciones').value = data.observaciones;
                        document.querySelector('#id_organismo').value = data.id_organismo;
                        document.querySelector('#legajo').value = data.legajo;
                        document.querySelector('#ingresos').value = data.ingresos;

                        var id_localidad = data.id_localidad;
                        console.log(id_localidad);

                        // En funcion del id_dpto de la persona editada, leo sus localidades  y selecciono la del titular
                        var ajaxLocalidades = 'scripts/localidades.php';
                        var ajaxResult = $.getJSON(ajaxLocalidades, {
                            id_dpto: data.id_dpto
                        });
                        var marcado = '';

                        ajaxResult.done(function (data) {
                            $("#id_localidad").empty();
                            $.each(data.localidades, function (l, loca) {
                                if (loca.id == id_localidad) {
                                    marcado = ' selected = "selected" ';
                                } else {
                                    marcado = '';
                                }

                                $('#id_localidad').append('<option value="' + loca.id + '"' + marcado + '>' + loca.nombre + '</option>');
                            });

                        });

                        resultAjax.fail(function () {
                            mostrarNotif("Se produjo un error");
                            console.log("error localidades");
                        });

                        //$("#dialog-edit-tit").dialog("option", "width", 600);
                        //$("#dialog-edit-tit").dialog("option", "height", 800);

                        if (window.frmValidator != undefined) {
                            frmValidator.resetForm();
                            window.frmValidator = undefined;
                        }

                        //$("#dialog-edit-tit").dialog("open");
                    } else {
                        mostrarNotif(data.mensaje);
                    }
                });

                resultAjax.fail(function () {
                    // Mensaje error
                    mostrarNotif("Se produjo un error al procesar la solicitud");
                    console.log("error ajax");
                });
            });

        } else {
            mostrarNotif(data.mensaje);
        }

    });

    resultAjax.fail(function () {
        mostrarNotif('No se pudo realizar la operaci&oacute;n');
    });
}

$(function () {
    // Obtengo el parametro get 'accion'
    var accion = (new URL(window.location)).searchParams.get('accion');

    //console.log(accion);
    listarTitulares(accion);

    /* Cuando se cierre el dialogo de editar*/
    $('#dialog-edit-tit').on('hide.bs.modal', function (e) {
        window.frmValidator = $('#form-titular').validate();
        window.frmValidator.resetForm();
        window.frmValidator.currentForm.reset();
    });

    // Seleccionar la localidad en funcion del departamento
    $('#id_dpto').on('change', function () {
        alert('id_dpto: ' + id_dpto);
        $('#id_dpto option:selected').each(function () {
            var id_dpto = $(this).val();

            var archivoAjax = 'scripts/localidades.php';
            var resultAjax = $.getJSON(archivoAjax, {
                id_dpto: id_dpto
            });

            resultAjax.done(function (data) {
                $("#id_localidad").empty();
                $.each(data.localidades, function (l, loca) {
                    $('#id_localidad').append('<option value="' + loca.id + '">' + loca.nombre + '</option>');
                });
            });

            resultAjax.fail(function () {
                alert('error localidades');
            });

        });
    });

    // // Dialogo de buscar titular
    // $('#dialog-buscar-titular').dialog({
    //     autoOpen: false,
    //     modal: true
    // });

    // Al pulsar ENTER en la txt de busqueda de titular, busco y muestro el resultado
    $('#txt-titular-buscado').on('keypress', function (e) {
        if (e.keyCode == 13) {
            var buscado = $('#txt-titular-buscado').val();
            var archivoAjax = 'scripts/obtener_titulares.php';
            var resultAjax = $.getJSON(archivoAjax, {
                buscado: buscado
            });

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

    // Click del boton buscar titular
    $('#btn-buscar-titular').on('click', function (e) {
        e.preventDefault();
        $("#dialog-buscar-titular").dialog("option", "width", 500);
        $("#dialog-buscar-titular").dialog("option", "height", 200);

        document.querySelector('#txt-titular-buscado').value = '';
        $('#tbl-titulares-buscados').empty();
        $("#dialog-buscar-titular").dialog("open");
    });

    // Opciones del dialogo editar titular
//    $("#dialog-edit-tit").dialog({
//        autoOpen: false,
//        modal: true,
//        buttons: {
//            "Aceptar": function () {
//                // Valido el formulario con reglas especificas
//                window.frmValidator = $('#form-titular').validate({
//                    rules: {
//                        titular: {
//                            required: true
//                        },
//                        nombre: {
//                            required: true
//                        },
//                        apellido: {
//                            required: true
//                        },
//                        nro_docu: {
//                            required: true,
//                            digits: true
//                        },
//                        domicilio: {
//                            required: true
//                        },
//                        id_dpto: {
//                            required: true
//                        },
//                        id_localidad: {
//                            required: true
//                        },
//                        ingresos: {
//                            required: true,
//                            number: true
//                        }
//                    },
//                    errorPlacement: function (error, element) {
//                        error.appendTo(element.next());
//                    }
//                });
//
//                // Si el form es valido, envio los datos y cierro el dialogo
//                if ($('#form-titular').valid()) {
//
//                    // Envio los datos al servidor via ajax
//                    var archivoAjax = 'scripts/grabar_titular.php';
//                    // var resultadoAjax = $.post(archivoAjax, $("#form-titular").serialize());
//
//                    var resultadoAjax = $.ajax({
//                        url: archivoAjax,
//                        type: 'post',
//                        data: $("#form-titular").serialize(),
//                        dataType: 'json'
//
//                    });
//
//                    resultadoAjax.done(function (data) {
//                        listarTitulares(accion);
//                        mostrarNotif(data.mensaje, 1);
//                    });
//
//                    resultadoAjax.fail(function () {
//                        mostrarNotif('No se pudo realizar la operaci&oacute;n');
//                        console.log('error ajax');
//                    });
//
//                    $(this).dialog("close");
//                    document.querySelector('#form-titular').reset();
//                }
//                else {
//                    console.log('Form no valido...');
//                }
//            },
//            "Cerrar": function () {
//                // Finalmente, cierro el dialogo
//                $(this).dialog("close");
//                document.querySelector('#form-titular').reset();
//            }
//        }
//    });

    // Click del boton nuevo



    // $('#btn-nuevo-titular').on('click', function () {
    //
    //     $('#accion-titular').val('nuevo-titular');
    //     $("#dialog-edit-tit").dialog("option", "width", 700);
    //     $("#dialog-edit-tit").dialog("option", "height", 700);
    //     $("#dialog-edit-tit").dialog("open");
    //
    //     if (window.frmValidator != undefined) {
    //         window.frmValidator.resetForm();
    //         window.frmValidator = undefined;
    //
    //     }
    //
    //     document.getElementById('form-titular').reset();
    //     document.querySelector('#id').value = '';
    //     document.querySelector('#id_persona').value = '';
    // });


    /* Validacion del formulario cuando se intenta enviar */
    window.frmValidator = $('#form-titular').validate({
        rules: {
            titular: {
                required: true
            },
            nombre: {
                required: true
            },
            apellido: {
                required: true
            },
            nro_docu: {
                required: true,
                digits: true
            },
            domicilio: {
                required: true
            },
            id_dpto: {
                required: true
            },
            id_localidad: {
                required: true
            },
            ingresos: {
                required: true,
                number: true
            }
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.next());
        }
    });

});