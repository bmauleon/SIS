<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/include/php/raiz.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/clases/Producto.php');

class ctrlProducto extends Producto{	
	function __construct(){
        parent::__construct();
	}

    /**
     * Objetivo: Crear una tabla con el arreglo obtenido de la tabla productos.
     * El arreglo es utilizado al consultar los productos (admonExistencia.php).
     * @param object $datos
     * @return string(HTML) resultadolHTML
    **/

    function listarProductos($datosBusqueda){
        $resultado = $this->buscarAvanzado($datosBusqueda);
        $resultadolHTML = "";

       if($resultado) {
            $resultadolHTML .= "
            <table class=\"table table-hover text-center\" id=\"tbl_productos\">
                <thead class=\"thead-dark\">
                    <tr>
                        <th scope=\"col\">ID.</th>
                        <th scope=\"col\">SKU</th>
                        <th scope=\"col\">DESCRIPCION</th>
                        <th scope=\"col\">MARCA</th>
                        <th scope=\"col\">COLOR</th>
                        <th scope=\"col\">PRECIO</th>
                        <th scope=\"col\">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>";
           foreach ($resultado as $valor) {
                $botones = "
                    <button type=\"button\" class=\"btn btn-success\" title=\"Almacen físico\" onclick=\"consultarAlmacen(".$valor["idProducto"].", 'F')\"><img src=\"../include/img/feather/eye.svg\"></button>
                    <button type=\"button\" class=\"btn btn-info\" title=\"Almacen virtual\" onclick=\"consultarAlmacen(".$valor["idProducto"].", 'V')\"><img src=\"../include/img/feather/eye.svg\"></button>";

                $resultadolHTML .= "
                    <tr>
                        <th scope=\"row\">".$valor["idProducto"]."</th>
                        <th>".$valor["sku"]."</th>
                        <th>".$valor["descripcion"]."</th>
                        <th>".$valor["marca"]."</th>
                        <th>".$valor["color"]."</th>
                        <th>".number_format($valor["precio"], 2, '.', ',')."</th>
                        <td>".$botones."</td>
                    </tr>";
            }

            $resultadolHTML .= "
                </tbody>
            </table>
            ";
       }
        echo $resultadolHTML;
    }
}
?>