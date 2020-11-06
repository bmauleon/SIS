<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/include/php/raiz.php');

$data = !empty($_REQUEST['data']) ? $_REQUEST['data'] : false;

if($data){
    $obj = json_decode(stripslashes($data));
    $documento = !empty($obj->documento)?$obj->documento:'';

    if($documento == 'PROD') {
        include_once($_SERVER['DOCUMENT_ROOT'].'/SIS/controladores/ctrlProducto.php');
        $objCtrlProducto = new ctrlProducto();

        if ($obj->accion == 'consultarProductos') {
            return $objCtrlProducto->listarProductos($obj);
        }
    }

    if($documento == 'EXIS') {
        include_once($_SERVER['DOCUMENT_ROOT'].'/SIS/controladores/ctrlExistencia.php');
        $objCtrlExistencia = new ctrlExistencia();

        if ($obj->accion == 'actualizarExistenciaProducto') {
            return $objCtrlExistencia->actualizarExistencia($obj);
        }

        if ($obj->accion == 'registroExistencia') {
            return $objCtrlExistencia->registrarExistencia($obj);
        }
    }
}