<?php
require_once 'db_config.php';

class conexion{

    public $conexion;

    private static $instancia;

    public function __construct(){
        $this->conexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    }

    public static function getInstancia(){
        if(!isset(self::$instancia)){
            self::$instancia = new conexion();
        }
        return self::$instancia;
    }


    static function consulta($sql, $parametros = []) {
        $c = self::getInstancia()->conexion;
    
        $stmt = $c->prepare($sql);
        $stmt->execute($parametros);
    
        $rsx = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        return $rsx;
    }


    static function insertar($sql, $parametros = []) {
        $c = self::getInstancia()->conexion;
    
        $stmt = $c->prepare($sql);
        $stmt->execute($parametros);
    
        return $c->lastInsertId();
    }
    
    static function exec($sql, $parametros = []) {
        $c = self::getInstancia()->conexion;
    
        $stmt = $c->prepare($sql);
        $stmt->execute($parametros);
    
        return $stmt->rowCount();
    }
}

?>