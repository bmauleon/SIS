<?php
require_once('Transaccion.php');

class Existencia implements Transaccion{
	public $bd;
	private $idExistencia;
	private $idProducto;
    private $idAlmacen;
    private $existencias;

	function __construct(){
        require_once('BD.php');
        $this->bd = new BD();
    }

    /**
     * Objetivo: Asignar los datos contenido al objeto con sus correspondientes variables de clase.
     * @param object $datos
    **/

    public function setDatos($datos){
        $this->idExistencia = empty($datos->idExistencia)?null:$datos->idExistencia;
        $this->idProducto = empty($datos->idProducto)?null:$datos->idProducto;
        $this->idAlmacen = empty($datos->idAlmacen)?0:$datos->idAlmacen;
        $this->existencias = empty($datos->existencias)?null:$datos->existencias;
    }

    /**
     * Objetivo: Insertar los datos en la tabla existencias.
     * No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function insertar(){
        $query = "INSERT INTO existencias(
                              exis_id_producto,
                              exis_id_almacen,
                              exis_existencias
                              )
                    VALUES(   :idProducto,
                              :idAlmacen,
                              :existencias)";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":idProducto", $this->idProducto);
        $consulta->bindParam(":idAlmacen", $this->idAlmacen);
        $consulta->bindParam(":existencias", $this->existencias);

        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Actualizar los datos en la tabla existencias.
     * No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function actualizar(){
        $query = "UPDATE existencias
                        SET exis_id_producto = :idProducto,
                            exis_id_almacen = :idAlmacen,
                            exis_existencias = :existencias
                        WHERE exis_id_existencia = :idExistencia";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":idProducto", $this->idProducto);
        $consulta->bindParam(":idAlmacen", $this->idAlmacen);
        $consulta->bindParam(":existencias", $this->existencias);
        $consulta->bindParam(":idExistencia", $this->idExistencia);

        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Borrar un registro de la tabla existencias. 
     * No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function eliminar(){
        $query = "DELETE FROM existencias
                         WHERE exis_id_existencia = :idExistencia";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":idExistencia", $this->idExistencia);

        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Realizar una busqueda personalizada de la tabal existencias y su relaciones (almacenes y productos).
     * @param object $datosBusqueda
     * @return array $resultado - Array asociativo del resultato de la consulta
    **/

    final public function buscarAvanzado($datosBusqueda){
        $idExistencia = !empty($datosBusqueda->idExistencia)?$datosBusqueda->idExistencia:false;
        $idProducto = !empty($datosBusqueda->idProducto)?$datosBusqueda->idProducto:false;
        $idAlmacen = !empty($datosBusqueda->idAlmacen)?$datosBusqueda->idAlmacen:false;
        $tipoAlmacen = !empty($datosBusqueda->tipoAlmacen)?$datosBusqueda->tipoAlmacen:false;

        $query = " SELECT  alma_id_almacen as \"idAlmacen\",
                            alma_nombre_almacen as \"nombreAlmacen\",
                            alma_localizacion as \"localizacion\",
                            alma_responsable as \"responsable\",
                            alma_tipo as \"tipo\",
                            prod_id_producto as \"idProducto\",
                            prod_sku as \"sku\",
                            prod_descripcion as \"descripcion\",
                            prod_marca as \"marca\",
                            prod_color as \"color\",
                            prod_precio as \"precio\",
                            exis_id_existencia as \"idExistencia\",
                            exis_existencias as \"existencias\"
                  FROM existencias
                    INNER JOIN productos ON (exis_id_producto = prod_id_producto)
                    INNER JOIN almacenes ON (exis_id_almacen = alma_id_almacen)
                WHERE exis_id_existencia IS NOT NULL";

        if($idExistencia){
            $query .= " AND exis_id_existencia = :idExistencia";
        }

        if($idProducto){
            $query .= " AND exis_id_producto = :idProducto";
        }

        if($idAlmacen){
            $query .= " AND exis_id_almacen = :idAlmacen";
        }

        if($tipoAlmacen){
            $query .= " AND alma_tipo = :tipoAlmacen";
        }

        $consulta = $this->bd->prepare($query);

        if($idExistencia){
            $consulta->bindParam(":idExistencia", $idExistencia);
        }

        if($idProducto){
            $consulta->bindParam(":idProducto", $idProducto);
        }

        if($idAlmacen){
            $consulta->bindParam(":idAlmacen", $idAlmacen);
        }

        if($tipoAlmacen){
            $consulta->bindParam(":tipoAlmacen", $tipoAlmacen);
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