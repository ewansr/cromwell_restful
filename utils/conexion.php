<?php
/**
 * Created by PhpStorm.
 * User: EwanS
 * Date: 23/09/2016
 * Time: 01:12 AM
 */

/*
 * Clase que provee una instancia del PDO
 * para el manejo de los modelos
 */

require_once  'data/login_mysql.php';

class conexion{
    private static $database = null;
    private static $pdo;

    final private function __construct(){
        try{
            self::obtenerDB();
        }catch (PDOException $e){
            //Agregar mis excepciones
        }
    }

    public static function obtenerInstancia(){
        if (self::$database === null){
            self::$database = new self();
        }
        return self::$database;
    }

    public function obtenerDB(){
        if (self::$pdo == null){
            self::$pdo = new PDO(
                'mysql:dbname='.BASE_DATOS.
                ';host='.NOMBRE_HOST.";",
                USUARIO,
                CONTRASENA,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        }
        return self::$pdo;
    }

    /*
     * Para que el objeto no se clone
     */
    final protected function  __clone(){}
    function _destructor(){
        self::$pdo = null;
    }

}