<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/clases/Producto.php');
$objProducto = new Producto();

$datosBusqueda = !empty($_REQUEST['datosBusqueda'])?$_REQUEST['datosBusqueda']:false;

if($datosBusqueda){
	$datos = json_decode(stripslashes($datosBusqueda));
    $resultado = $objProducto->buscarAvanzado($datos);
}

if(!empty($resultado)){
    echo json_encode($resultado);
}else{
    echo null;
}
?>