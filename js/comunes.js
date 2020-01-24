var hoy = new Date();
var fecha = ((hoy.getDate() < 10) ? '0' : '') + hoy.getDate() + '/' + (((hoy.getMonth() + 1) < 10) ? '0' : '') + (hoy.getMonth() + 1) + '/' + hoy.getFullYear();

function menu(event) {
    event.preventDefault();
    $("#accion").val($(this).data('menu'));
    $("#form-nav").submit();
}

function divOn($resp) {
    $resp.removeClass('invisible');
    $resp.addClass('visible');
}

function divOff($resp) {
    $resp.html('');
    $resp.removeClass('visible');
    $resp.addClass('invisible');
}

function generarLocalidades($idDpto, $idLoc) {//genera las localidades según sea el dpto elegido
    let archivoAjax = 'scripts/localidades.php';
    let resultAjax = $.post(archivoAjax, {id_dpto: $idDpto}, null, 'json');
    resultAjax.done(function (data) {
        $idLoc.empty();
        $.each(data.localidades, function (i, loca) {
            $idLoc.append('<option value="' + loca.id + '">' + loca.nombre + '</option>');
        });
    });
    resultAjax.fail(function () {
        alert('error localidades');
    });
}
function verifTitular(dni){
    let archivoAjax = 'scripts/verificar_persona.php';
    let resultAjax = $.post(archivoAjax, {dni: dni, tipo: 't'}, null, 'json');
    resultAjax.done(function (data) {
        if(data.res){}
    });
    resultAjax.fail(function () {
        alert('error titular');
    });
}
/*function alertar(mensaje) {
 alert(mensaje);
 return 0;
 }
 
 function formatearMoneda(moneda) {
 
 }
 
 var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 
 formatear: function(num) {
 num += '';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft + splitRight;
 },
 new: function(num, simbol) {
 this.simbol = simbol || '';
 return this.formatear(num);
 }
 }
 
 function mostrarNotif(mensaje, tipo = 0) {
 console.log(mensaje, tipo);
 var clase = (tipo === 0) ? 'alert alert-danger' : 'alert alert-success';
 var alerta = '<div class="' + clase + '">' + mensaje + '</div>';
 
 document.querySelector('#area-notif').innerHTML = alerta;
 
 setTimeout(showTooltip, 500);
 }
 
 function showTooltip() {
 $("#area-notif").show("slow");
 setTimeout(hideTooltip, 4000);
 }
 
 function hideTooltip() {
 $("#area-notif").hide("slow");
 }*/
// function generarSelectAnios(inicio, fin, nombre = 'anio') {
//     echo "<select name='$nombre' class='form-control'>";
//     for ($anio = $inicio; $anio <= $fin; $anio++) {
//         if ($anio != $fin) {
//             echo "<option value='$anio'>$anio</option>";
//         }
//         else {
//             echo "<option value='$anio' selected='selected'>$anio</option>";
//         }
//     }
//     echo '</select>';
// }