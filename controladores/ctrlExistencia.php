<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/include/php/raiz.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/SIS/clases/Existencia.php');

class ctrlExistencia extends Existencia{    
    function __construct(){
        parent::__construct();
    }

    /**
     * Objetivo: Modificar los datos relacionados con alguna existencia
     * (admonExistencia.php).
     * @param object $datos
     * @return array(json) $resultado
    **/

    function actualizarExistencia($datos){
        //echo "ENTRO";
        try{
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->beginTransaction();
            //Buscamos el registro realizado
            $tmpResultado = $this->buscarAvanzado($datos);
            $datosFinales = (object) $tmpResultado[0];
            $datosFinales->existencias = $datos->existencias;
            
            //Asignamos las variables de clase
            $this->setDatos($datosFinales);

            //Invocamos el metodo para actualizar
            $this->actualizar();

            $this->bd->commit();
            $resultado['bandera'] = true;
            $resultado['mensaje'] = 'Actualización realizada exitosamente';
        }catch(PDOException $e){
            //Si se presenta algun error se revierten los cambios
            $this->bd->rollback();
            $resultado['bandera'] = false;
            $resultado['mensaje'] = 'Ocurrió un error '.$e->getMessage();
        }
        echo json_encode($resultado);
    }

    /**
     * Objetivo: Insertar un registro en la tabla existencia
     * (admonExistencia.php).
     * @param object $datos
     * @return array(json) $resultado
    **/

    function registrarExistencia($datos){
        //echo "ENTRO";
        try{
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->beginTransaction();
            
            //Asignamos las variables de clase
            $this->setDatos($datos);

            //Invocamos el metodo para insertar
            $this->insertar();

            $this->bd->commit();
            $resultado['bandera'] = true;
            $resultado['mensaje'] = 'Registro realizado exitosamente';
        }catch(PDOException $e){
            //Si se presenta algun error se revierten los cambios
            $this->bd->rollback();
            $resultado['bandera'] = false;
            $resultado['mensaje'] = 'Ocurrió un error '.$e->getMessage();
        }
        echo json_encode($resultado);
    }
}
?>