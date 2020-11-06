<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/clases/Almacen.php');
$objAlmacen = new Almacen();

$datosBusqueda = !empty($_REQUEST['datosBusqueda'])?$_REQUEST['datosBusqueda']:false;

if($datosBusqueda){
	$datos = json_decode(stripslashes($datosBusqueda));
    $resultado = $objAlmacen->buscarAvanzado($datos);
}

if(!empty($resultado)){
    echo json_encode($resultado);
}else{
    echo null;
}
?>