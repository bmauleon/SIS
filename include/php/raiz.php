<?php

$raiz = $_SERVER['DOCUMENT_ROOT']."/SIS";

$baseHost = "http://". $_SERVER['SERVER_NAME'];

$rootHTML = $baseHost."/SIS";

$raizInclude = $raiz. "/include";

$raizIncludeHTML = $rootHTML. "/include";
$raizImagen = $raizIncludeHTML . "/img";
$raizTemplate = $raizIncludeHTML . "/bootstrap-4.3.1";
$raizCSS = $raizIncludeHTML . "/css";
$raizJS = $raizIncludeHTML . "/js";
$raizIncPHP = $raizInclude . "/php";

date_default_timezone_set('America/Mexico_City');
?>