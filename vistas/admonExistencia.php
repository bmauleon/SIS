<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/include/php/raiz.php');

$HTMLcurrentPageName = "Productos por almacen";
$HTMLdescripcion = 'Administracion de productos por almacen';
$HTMLauthorName = "Bryant Mauleon";
$scriptPropio = 'admonExistencia.js';

include_once ($raizIncPHP."/encabezado.php");
?>
		<!--Comienza contenido principal-->
		<div class="content">
			<?php include_once ($raizIncPHP."/nav_bar.php"); ?>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<h3>Productos por almacen
							<button type="button" class="btn btn-primary m-1" data-toggle="modal" onclick="modalRegistro()">
								Registrar existencias
							</button>
						</h3>
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 table-responsive" id="div_tabla">
						<!--Contenido de la tabla al realizar la peticion-->
					</div>
				</div>
			</div>
			<!--Termina contenido principal-->

			<!--Comienza Modal detalle de productos en almacen-->
			<div class="modal" tabindex="-1" role="dialog" id="modal_registro_existencias">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Registro de existencias</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="col-lg-12">
								<form>
									<div class="form-group row">
									 	<label for="sel_producto" class="col-lg-2 col-form-label"><span class="text-danger">* </span> Producto:</label>
										<div class="col-lg-4">
											<select class="form-control custom-select" id="sel_producto">
												<option value="" selected>Selecciona un producto</option>
											</select>
										</div>
										<label for="sel_almacen" class="col-lg-2 col-form-label"><span class="text-danger">* </span> Almacen:</label>
										<div class="col-lg-4">
											<select class="form-control custom-select" id="sel_almacen">
												<option value="" selected>Selecciona un almacen</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="num_existencias" class="col-lg-2"><span class="text-danger">* </span> Num. existencias:</label>
										<div class="col-lg-4">
											<input type="number" class="form-control" id="num_existencias">
										</div>
										<div class="col-lg-6 text-right">
											<button type="button" id="btn_guardar" class="btn btn-info m-1" onclick="registrarExistencias()">Guardar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Termina  Modal detalle de productos en almacen-->

			<!--Comienza Modal detalle de productos en almacen-->
			<div class="modal" tabindex="-1" role="dialog" id="modal_detalle_producto">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modal_titulo_detalle"><!--Titulo del modal--></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="col-lg-12" id="div_mensaje">
								<!--Mensaje de estatus de la peticiones-->
							</div>
							<div class="col-lg-12 table-responsive" id="div_detalle_modal">
								<!--Contenido del detalle del producto al realizar la peticion-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Termina  Modal detalle de productos en almacen-->
<?php
include_once ($raizIncPHP."/pie.php");
?>