(function($) {
	consultarProductos();
	incializarCombos();
	
})(window.jQuery);

function listenExistencias(){
	var baseURL = "http://"+ window.location.host+"/SIS";
	$('.btn_actualizar').on('click', function(event) {
		event.preventDefault();
		var datosForm = {};
		datosForm.documento = 'EXIS';
		datosForm.accion = 'actualizarExistenciaProducto';
		datosForm.existencias = $(this).parents('tr').find("td .num_existencias").val();
		datosForm.idExistencia = $(this).parents('tr').find("td .id_existencia").val();
		$.post(baseURL+'/controladores/ctrlMain.php', {data: JSON.stringify(datosForm)}, function(data){
			var dataObj = jQuery.parseJSON(data);
			if(dataObj.bandera == true){
				$('#div_mensaje').addClass('text-success');
	            $('#div_mensaje').html(dataObj.mensaje);
	        }else{
	        	$('#div_mensaje').addClass('text-danger');
	            $('#div_mensaje').html(dataObj.mensaje);
	        }
	        setTimeout(function(){
				$('#div_mensaje').html('');
			}, 1500);
	    });
	});
}

function consultarProductos(){
	var baseURL = "http://"+ window.location.host+"/SIS";
	$('#div_tabla').html('');
	var datosForm = {};
	datosForm.documento = 'PROD';
	datosForm.accion = 'consultarProductos';
	$.get(baseURL+'/controladores/ctrlMain.php', {data: JSON.stringify(datosForm)}, function(data){
		if(data != false) {
			$('#div_tabla').html(data);
            $('#tbl_productos').DataTable();
		}else{
			$('#div_tabla').html('<div class="text-primary">No se encontraron resultados con los criterios establecidos</div>');
		}
    });
}

function consultarAlmacen(idProducto, tipoAlmacen){
	var baseURL = "http://"+ window.location.host+"/SIS";
	if(idProducto != null && tipoAlmacen != null){
		var leyendaAlmacen = 'almacen físico';
		var titulo = '';
		if(tipoAlmacen == 'V'){
			leyendaAlmacen = 'almacen virtual';
		}

		$('#div_detalle_modal').html('');
		var datosBusqueda = {};
		datosBusqueda.idProducto = idProducto;
		datosBusqueda.tipoAlmacen = tipoAlmacen;
		$.get(baseURL+'/dataSources/json_existencias.php', {datosBusqueda: JSON.stringify(datosBusqueda)}, function (data) {
	        if(data != false) {
	        	var tablaHTML = ''
	        		+'<table class=\"table table-hover text-center\" id=\"tbl_detalle_productos\">'
						+'<thead>'
						+'	<tr>'
						+'		<th scope=\"col\">NOMBRE ALMACEN</th>'
						+'		<th scope=\"col\">RESPONSABLE</th>'
						+'		<th scope=\"col\">TIPO</th>'
						+'		<th scope=\"col\">EXISTENCIAS</th>'
						+'		<th scope=\"col\">ACCIONES</th>'
						+'	</tr>'
						+'</thead>'
						+'<tbody>'
						+'	<tr></tr>'
						+'</tbody>'
					+'</table>';
	        	$('#div_detalle_modal').html(tablaHTML);
	        	datos = jQuery.parseJSON(data);
	        	titulo = datos[0]['descripcion']+' '+leyendaAlmacen;
	        	$('#modal_titulo_detalle').html(titulo);
	        	for (var i = 0; i < datos.length; i++) {
	        		$('#tbl_detalle_productos tr:last').after(''
	        			+'<tr>'
		        			+'<td scope=\"row\">'+datos[i]['nombreAlmacen']+'</td>'
		        			+'<td>'+datos[i]['responsable']+'</td>'
		        			+'<td>'+datos[i]['tipo']+'</td>'
		        			+'<td>'
		        			+'	<input class=\"num_existencias\" type=\"number\" value=\"'+datos[i]['existencias']+'\">'
		        			+'	<input class=\"id_existencia\" type=\"hidden\" value=\"'+datos[i]['idExistencia']+'\">'
		        			+'</td>'
		        			+'<td><button type=\"button\" class=\"btn btn-primary btn_actualizar\">Actualizar</button></td>'
	        			+'</tr>');
	        	}

	        	listenExistencias();
			}else{
	        	$('#modal_titulo_detalle').html('');
				$('#div_detalle_modal').html('<div class="text-danger">No se tienen registros con el producto solicitado</div>');
			}
	    });
	}else{
		$('#modal_titulo_detalle').html('ERROR');
		$('#div_detalle_modal').html('<div class="text-danger">Ocurrio un error al realizar la petición</div>');
	}
	$('#modal_detalle_producto').modal('show');
}

function modalRegistro(){
	$('#sel_producto').val('').trigger('change');
	$('#sel_almacen').val('').trigger('change');
	$('#num_existencias').val('');
	$('#modal_registro_existencias').modal('show');
}

function incializarCombos(){
	var baseURL = "http://"+ window.location.host+"/SIS";
	var datosBusqueda = {};
	//Poblamos el select de productos
	$.get(baseURL+'/dataSources/json_productos.php', {datosBusqueda: JSON.stringify(datosBusqueda)}, function (data) {
        if(data != false) {
        	datos = jQuery.parseJSON(data);
        	for (var i = 0; i < datos.length; i++) {
        		$('#sel_producto option:last').after(''
        			+'<option value="'+datos[i]['idProducto']+'">'+datos[i]['descripcion']+'</option>');
        	}
		}
    });
    //Poblamos el select de almacenes
	$.get(baseURL+'/dataSources/json_almacenes.php', {datosBusqueda: JSON.stringify(datosBusqueda)}, function (data) {
        if(data != false) {
        	datos = jQuery.parseJSON(data);
        	for (var i = 0; i < datos.length; i++) {
        		$('#sel_almacen option:last').after(''
        			+'<option value="'+datos[i]['idAlmacen']+'">'+datos[i]['nombreAlmacen']+' ('+datos[i]['tipo']+')</option>');
        	}
		}
    });
}

function registrarExistencias(){
	var baseURL = "http://"+ window.location.host+"/SIS";
	if($('#sel_producto').val() != '' || $('#sel_almacen').val() != '' || $('#num_existencias').val() != '') {
		var datosForm = {};
		datosForm.idProducto =  $('#sel_producto').val();
		datosForm.idAlmacen = $('#sel_almacen').val().toUpperCase();
		datosForm.existencias = $('#num_existencias').val();
		
		//Datos de control
        datosForm.documento = 'EXIS';
        datosForm.accion = 'registroExistencia';

		$.post(baseURL+'/controladores/ctrlMain.php', {data: JSON.stringify(datosForm)}, function(data){
	        var dataObj = jQuery.parseJSON(data);
	        if(dataObj.bandera == true){
	            $('#modal_registro_existencias').modal('hide');
	            $('#modal_texto').addClass('text-success');
	            $('#modal_texto').html(dataObj.mensaje);
	            $('#modal_aviso').modal('show');
	        }else{
	            $('#modal_registro_existencias').modal('hide');
	            $('#modal_texto').addClass('text-danger');
	            $('#modal_texto').html(dataObj.mensaje);
	            $('#modal_aviso').modal('show');
	        }
	        setTimeout(function(){consultarProductos();}, 1500);
	    });

	}
}	