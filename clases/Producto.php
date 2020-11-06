<?php
require_once('Transaccion.php');

class Producto implements Transaccion{
    public $bd;
    private $idProducto;
    private $sku;
    private $descripcion;
    private $marca;
    private $color;
    private $precio;

	function __construct(){
        require_once('BD.php');
        $this->bd = new BD();
    }

    /**
     * Objetivo: Asignar los datos contenido al objeto con sus correspondientes variables de clase.
     * @param object $datos
    **/

    public function setDatos($datos){
        $this->idProducto = empty($datos->idProducto)?null:$datos->idProducto;
        $this->sku = empty($datos->sku)?null:$datos->sku;
        $this->descripcion = empty($datos->descripcion)?null:$datos->descripcion;
        $this->marca = empty($datos->marca)?null:$datos->marca;
        $this->color = empty($datos->color)?null:$datos->color;
        $this->precio = empty($datos->precio)?null:$datos->precio;
    }

    /**
     * Objetivo: Insertar los datos en la tabla productos.
     * @param No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function insertar(){
        $query = "INSERT INTO productos(
                              prod_sku,
                              prod_descripcion,
                              prod_marca,
                              prod_color,
                              prod_precio
                              )
                    VALUES(   :sku,
                              :descripcion,
                              :marca,
                              :color,
                              :precio)";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":sku", $this->sku);
        $consulta->bindParam(":descripcion", $this->descripcion);
        $consulta->bindParam(":marca", $this->marca);
        $consulta->bindParam(":color", $this->color);
        $consulta->bindParam(":precio", $this->precio);

        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Actualizar los datos en la tabla productos.
     * @param No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function actualizar(){
        $query = "UPDATE productos
                        SET prod_sku = :sku,
                            prod_descripcion = :descripcion,
                            prod_marca = :marca,
                            prod_color = :color,
                            prod_precio = :precio,
                        WHERE prod_id_producto = :idProducto";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":sku", $this->sku);
        $consulta->bindParam(":descripcion", $this->descripcion);
        $consulta->bindParam(":marca", $this->marca);
        $consulta->bindParam(":color", $this->color);
        $consulta->bindParam(":precio", $this->precio);
        $consulta->bindParam(":idProducto", $this->idProducto);
        
        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Borrar un registro de la tabla productos. 
     * @param No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function eliminar(){
        $query = "DELETE FROM productos
                         WHERE prod_id_producto = :idProducto";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":idProducto", $this->idProducto);
        
        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Realizar una busqueda personalizada de la tabla productos.
     * @param object $datosBusqueda
     * @return array $resultado - Array asociativo del resultato de la consulta
    **/

    final public function buscarAvanzado($datosBusqueda){
        $idProducto = !empty($datosBusqueda->idProducto)?$datosBusqueda->idProducto:false;

        $query = "SELECT    prod_id_producto as \"idProducto\",
                            prod_sku as \"sku\",
                            prod_descripcion as \"descripcion\",
                            prod_marca as \"marca\",
                            prod_color as \"color\",
                            prod_precio as \"precio\"
                  FROM productos
                  WHERE prod_id_producto IS NOT NULL";

        if($idProducto){
            $query .= " AND prod_id_producto = :idProducto";
        }

        $consulta = $this->bd->prepare($query);

        if($idProducto){
            $consulta->bindParam(":idProducto", $idProducto);
        }
        

        if($consulta->execute()){
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $infoError = $consulta->errorInfo();
            $resultado = $infoError[1]. " ". $infoError[0] . " ". $infoError[2];
        }
        
        $this->bd->close_con();
        return $resultado;
    }

    /*
     * Setter y getters
    */
   
    public function setBd($bd){
        $this->bd = $bd;
    }

    public function getBd(){
        return $this->bd;
    }
}
?>