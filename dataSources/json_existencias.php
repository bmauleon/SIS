<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/clases/Existencia.php');
$objExistencia = new Existencia();

$datosBusqueda = !empty($_REQUEST['datosBusqueda'])?$_REQUEST['datosBusqueda']:false;

if($datosBusqueda){
	$datos = json_decode(stripslashes($datosBusqueda));
    $resultado = $objExistencia->buscarAvanzado($datos);
}

if(!empty($resultado)){
    echo json_encode($resultado);
}else{
    echo null;
}
?>