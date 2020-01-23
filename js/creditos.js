$(function() {
	$('#btn-buscar-credito').on('click', function(event) {
		event.preventDefault();
		let $dni = $('#dni-titular');
		if ($dni.val() !== '') {
			let archivoAjax = 'scripts/buscar_credito.php';
			let resultAjax = $.post(archivoAjax, { dni: $dni.val() }, null, 'json');
			resultAjax.done(function($resAjax) {
				let $busq = $('#buscar_credito');
				let $resp = $('#respuesta');
				if ($resAjax.resultado === 'ok') {
					$busq.html($resAjax.list);
					divOn($busq);
					divOff($resp);
				} else {
					$resp.html('<p>' + $resAjax.msj + '</p>');
					divOn($resp);
					divOff($busq);
				}
			});
			resultAjax.fail(function() {
				let $resp = $('#respuesta');
				$resp.html('<p>No se pudo acceder a la b&uacute;squeda</p>');
				divOn($resp);
			});
		} else {
			divOff($('#buscar_credito'));
			divOn($('#respuesta').html('<p>Debe ingresar alg&uacute;n valor</p>'));
		}
		$dni.val('');
	});

	$('#buscar_credito').on('click', '#btn-ver-credito', function(event) {
		event.preventDefault();
		let $this = $(this);
		$('#accion').val($this.data('menu'));
		$('<input />')
			.attr('type', 'hidden')
			.attr('name', 'dni')
			.attr('value', $this.data('dni'))
			.appendTo('#form-nav');
		$('#form-nav').submit();
	});

	$('#btn-nuevo-credito').on('click', menu);
});
