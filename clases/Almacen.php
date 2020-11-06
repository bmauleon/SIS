<?php
require_once('Transaccion.php');

class Almacen implements Transaccion{
    public $bd;
    private $idAlmacen;
    private $nombreAlmacen;
    private $localizacion; // Al atomizar este campo solo se dejaria el id de la localizacion y en otra tabla tener los datos de calle, no. exterior, no. interior, id del estado, id delegacion/municipio, etc.
    private $responsable; // Al atomatizar este campo solo se dejaria el id de la persona responsable y en otra tabla los datos como nombre, apellido paterno, apellido materno, etc.
    private $tipo; //(V) Virtual | (F) Físico

	 function __construct(){
        require_once('BD.php');
        $this->bd = new BD();
    }

    /**
     * Objetivo: Asignar los datos contenido al objeto con sus correspondientes variables de clase.
     * @param object $datos
    **/

    public function setDatos($datos){
        $this->idAlmacen = empty($datos->idAlmacen)?null:$datos->idAlmacen;
        $this->nombreAlmacen = empty($datos->nombreAlmacen)?null:$datos->nombreAlmacen;
        $this->localizacion = empty($datos->localizacion)?null:$datos->localizacion;
        $this->responsable = empty($datos->responsable)?null:$datos->responsable;
        $this->tipo = empty($datos->tipo)?null:$datos->tipo;
    }

    /**
     * Objetivo: Insertar los datos en la tabla almacenes.
     * @param No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function insertar(){
        $query = "INSERT INTO almacenes(
                              alma_nombre_almacen,
                              alma_localizacion,
                              alma_responsable,
                              alma_tipo
                              )
                    VALUES(   :nombreAlmacen,
                              :localizacion,
                              :responsable,
                              :tipo)";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":nombreAlmacen", $this->nombreAlmacen);
        $consulta->bindParam(":localizacion", $this->localizacion);
        $consulta->bindParam(":responsable", $this->responsable);
        $consulta->bindParam(":tipo", $this->tipo);

        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Actualizar los datos en la tabla almacenes.
     * @param No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function actualizar(){
        $query = "UPDATE almacenes
                        SET alma_nombre_almacen = :nombreAlmacen,
                            alma_localizacion = :localizacion,
                            alma_responsable = :responsable,
                            alma_tipo = :tipo
                         WHERE alma_id_almacen = :idAlmacen";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":nombreAlmacen", $this->nombreAlmacen);
        $consulta->bindParam(":localizacion", $this->localizacion);
        $consulta->bindParam(":responsable", $this->responsable);
        $consulta->bindParam(":tipo", $this->tipo);
        $consulta->bindParam(":idAlmacen", $this->idAlmacen);
        
        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Borrar un registro de la tabla almacenes. 
     * @param No recibe parametros ya que utilza las variables de clase asignadas normalmente con el metodo setDatos().
    **/

    final public function eliminar(){
        $query = "DELETE FROM almacenes
                         WHERE alma_id_almacen = :idAlmacen";
        $consulta = $this->bd->prepare($query);
        $consulta->bindParam(":idAlmacen", $this->idAlmacen);
        
        $consulta->execute();
        $this->bd->close_con();
    }

    /**
     * Objetivo: Realizar una busqueda personalizada de la tabla almacenes.
     * @param object $datosBusqueda
     * @return array $resultado - Array asociativo del resultato de la consulta
    **/

    final public function buscarAvanzado($datosBusqueda){
        $idAlmacen = !empty($datosBusqueda->idAlmacen)?$datosBusqueda->idAlmacen:false;

        $query = "SELECT    alma_id_almacen as \"idAlmacen\",
                            alma_nombre_almacen as \"nombreAlmacen\",
                            alma_localizacion as \"localizacion\",
                            alma_responsable as \"responsable\",
                            alma_tipo as \"tipo\"
                  FROM almacenes
                  WHERE alma_id_almacen IS NOT NULL";

        if($idAlmacen){
            $query .= " AND alma_id_almacen = :idAlmacen";
        }

        $consulta = $this->bd->prepare($query);

        if($idAlmacen){
            $consulta->bindParam(":idAlmacen", $idAlmacen);
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