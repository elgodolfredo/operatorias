// Id de user global
var id_ok = 0;
var accion_ok = 'noAccion';

$(function () {

    // Seleccionar la localidad en funcion del departamento
//    $('#id_dpto').change(function () {
//        $('#id_dpto option:selected').each(function () {
//            var id_dpto = $(this).val();
//            alert('id_dpto: ' + id_dpto);
//            $.post("includes/localidades.php", {id_dpto: id_dpto}, function (data) {
//                $("#id_localidad").html(data);
//            });
//        });
//    });


    // creación de ventana con formulario con jquery ui
//    $('#agregarTitular').dialog({
//        autoOpen: false,
//        modal: true,
//        width: 'auto',
//        height: 'auto',
//        resizable: false,
//        close: function () {
//            // Quito los mensaje de error de los campos
//            $('#formTitular fieldset > span').removeClass('error').empty();
//
//            // Remuevo el valor del atributo value de todos los input tipo text
//            $('#formTitular input[type="text"]').val('');
//
//            // Remuevo el atributo selected de todos los select del formulario
//            $('#formTitular select > option').removeAttr('selected');
//            $('#id_localidad').html('<option value="0" selected="selected">Seleccione una opci&oacute;n...</option>');
//
//            // Cuando se cierra el formulario, se pone en 0 el campo oculto id_user
//            $('#id').val('0');
//        }
//    });

    $('#dialogo-borrar').dialog({
        autoOpen: false,
        modal: true,
        width: 350,
        height: 'auto',
        resizable: false,
        buttons: {
            Si: function () {
                $.ajax({
                    beforeSend: function () {

                    },
                    cache: false,
                    type: "POST",
                    dataType: "json",
                    url: "includes/phpAjaxTitular.inc.php",
                    data: "accion=" + accion_ok + "&id=" + id_ok,
                    success: function (response) {
                        // Validar mensaje de error
                        if (response.respuesta == false) {
                            alert(response.mensaje);
                        }
                        else {
                            // Si el borrado es exitoso
                            $('#dialog-borrar').dialog('close');
                            //alert(response.contenido);

                            $('#listaTitularesOK').empty();

                            // Agregamos el contenido generado por php al body de la tabla
                            $('#listaTitularesOK').append(response.contenido);
                        }

                        $('#formTitular .ajaxLoader').hide();
                    },
                    error: function () {
                        alert('Error del Sistema. Intente mas tarde');
                    }
                });
            },
            No: function () {
                $(this).dialog('close');
            }
        }
    });

    // Funcionalidad del boton que abre el formulario para insertar un nuevo registro
    $('#goNuevoTitular').on('click', function () {
        // Asignamos valor a la variable accion
        $('#accion').val('addTitular');

        // Abrimos el formulario
        $('#agregarTitular').dialog({
            title: 'Agregar titular',
            autoOpen: true
        });
    });

    // Validar formulario
    $('#formTitular').validate({
        submitHandler: function () {
            // Tomo los datos del formulario y los coloco en una variablepara enviarlos con ajax
            var str = $('#formTitular').serialize();

            $.ajax({
                beforeSend: function () {
                    $('#formTitular .ajaxLoader').show();
                },
                cache: false,
                type: "POST",
                dataType: "json",
                url: "includes/phpAjaxTitular.inc.php",
                data: str,
                success: function (response) {
                    // Validar mensaje de error
                    if (response.respuesta == false) {
                        alert(response.mensaje);
                    }
                    else {
                        $('#agregarTitular').dialog('close');
                        //alert(response.contenido);

                        // Si esta presente la fila sinDatos la elimino
                        if ($('#sinDatos').length) { // Comprobar el largo es una forma de verificar si existe
                            $('#sinDatos').remove(); // De esta forma se elimina el nodo
                        }

//                        // Validar tipo de accion para borrar el listado de usuarios anterior y mostrar el actualizado
//                        if ($('#accion').val() == 'editTitular') {
//                            $('#listaTitularesOK').empty();
//                        }
                        $('#listaTitularesOK').empty();
                        //alert ('adadada');
                        // Agregamos el contenido generado por php al body de la tabla
                        $('#listaTitularesOK').append(response.contenido);
                    }

                    $('#formTitular .ajaxLoader').hide();
                },
                error: function () {
                    alert('Error del Sistema. Intente mas tarde. validate!!!!!');
                }
            });

            return false;
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.next("span").append());
        }
    });

    $('body').on('click', '#listaTitularesOK a', function (e) {
        // Evento click de los enlaces de la lista de titulares (editar y eliminar)

        e.preventDefault(); // Evitar la accion por defecto

        // Id de titular
        id_ok = $(this).attr('href');
        accion_ok = $(this).attr('data-accion');

        // Id de titular que se desea editar
        $('#id').val(id_ok);

        if (accion_ok == 'editar') {

            // Valor de la accion
            $('#accion').val('editTitular');

            // Llenar el formulario con los datos del registro seleccionado
            // Con ajax leo los datos del titular desde la DB y relleno el formulario
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "includes/phpAjaxTitular.inc.php",
                data: "accion=" + 'obtener' + "&id=" + id_ok,
                success: function (response) {
                    // Validar mensaje de error
                    if (response.respuesta == false) {
                        alert(response.mensaje);
                    }
                    else {
                        // Aca relleno el formulario de titular con los datos obtenidos desde la BD
                        titular = response.contenido;
                        $('#id').val(titular['id']);
                        $('#id_persona').val(titular['id_persona']);
                        $('#nombre').val(titular['nombre']);
                        $('#apellido').val(titular['apellido']);
                        $('#nro_docu').val(titular['nro_docu']);
                        $('#domicilio').val(titular['domicilio']);
                        $('#id_dpto').val(titular['id_dpto']);
                        $('#id_localidad').val(titular['id_localidad']);
                        $('#tel_fijo').val(titular['tel_fijo']);
                        $('#tel_laboral').val(titular['tel_laboral']);
                        $('#tel_celular').val(titular['tel_celular']);
                        $('#observaciones').val(titular['observaciones']);
                        $('#organismo').val(titular['organismo']);
                        $('#legajo').val(titular['legajo']);
                        $('#ingresos').val(titular['ingresos']);

                        $('#id_dpto option:selected').each(function () {
                            // var id_dpto = $(this).val();
                            var id_dpto = titular['id_dpto'];
                            var id_localidad = titular['id_localidad'];
                            $.post("includes/localidades.php", {id_dpto: id_dpto, id_localidad: id_localidad}, function (data) {
                                $("#id_localidad").html(data);
                            });
                        });

                    }
                }
            });

            // Abrimos el formulario
            $('#agregarTitular').dialog({
                title: 'Editar titular',
                autoOpen: true
            });
        }
        else if (accion_ok == 'eliminar') {
            $('#dialog-borrar').dialog('open');
        }
    });
});