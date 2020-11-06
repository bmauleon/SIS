<?php
interface Transaccion{

	/*
	 * Método que permita realizar un registro en la tabla relacionada con el clase
	*/
	public function insertar();

	/*
	 * Método que permita actualizar un registro en la tabla relacionada con el clase
	*/
	public function actualizar();

	/*
	 * Método que permita eliminar un registro en la tabla relacionada con el clase
	*/
	public function eliminar();
}
?>