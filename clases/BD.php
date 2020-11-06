<?php
class BD extends PDO {
    private $conexion = null;
    private $usuario;
    private $contrasenia;
    private $host;
    private $dbname;

    /*
     * Constructor de la clase, invoca la conexion de la base de datos.
    */

    public function __construct(){
        //Asignamos los parametros de conexion
        $this->paramCon();
        $this->setConexion();
    }

    /*
     * Se realiza la conexion de la base de datos.
    */
   
    final public function setConexion(){
        try {
            $this->conexion = null;
            $conexion = parent::__construct('mysql:host='.$this->host.';dbname='.$this->dbname.'', 
                        ''.$this->usuario.'',
                        ''.$this->contrasenia.'',
                        array(
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                        ));
        } catch(PDOException $e) {
            echo "Conexion fallida: " . $e->getMessage();
        }
    }

    /*
     * Se termina la conexion de la base de datos.
    */
   
    final public function close_con(){
        $this->conexion = null;
    }

    /*
     * Configuración de datos de conexiones
    */

    private function paramCon(){
        $this->host = 'localhost';
        $this->dbname = 'bdsis';
        $this->contrasenia = '';
        $this->usuario = '';
    }

    /*
     * Setter y getters
    */
   
    public function getConexion(){
        return $this->conexion;
    }

    public  function setContrasenia($contrasenia){
        $this->contrasenia = $contrasenia;
    }

    public function getContrasenia(){
        return $this->contrasenia;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setDbname($dbname){
        $this->dbname = $dbname;
    }

    public function getDbname(){
        return $this->dbname;
    }

    public function setHost($host){
        $this->host = $host;
    }

    public function getHost(){
        return $this->host;
    }
}
?>