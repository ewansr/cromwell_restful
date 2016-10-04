<?php
/**
 * Created by PhpStorm.
 * User: EwanS
 * Date: 23/09/2016
 * Time: 01:54 AM
 */
require "utils/conexion.php";

class nuc_persona{
    const TABLE_NAME = "master_usuarios";
    const ID     = "Id";
    const NOMBRE = "Nombre";
    const APPAT  = "Appat";
    const APMAT  = "Apmat";
    const ESTADO_URL_INCORRECTA = "ERROR URL";
    static $sentence = null;

    public static function post( $request ){
        if ( $request[0] == 'registro' ){
            return self::registrar();
        }else if ( $request[0] == 'login' ){
            return self::loguear();
        }else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL mal formada, 400");
        }
    }

    private function getPersona()
    {
        $SQLCommand = "SELECT * " .


            " FROM " . self::TABLE_NAME ;

        self::$sentence = conexion::obtenerInstancia()->obtenerDB()->prepare($SQLCommand);

//        $sentence->bindParam(1, $nombre);

        if (self::$sentence->execute()){

            $jsonData = array();
            while ($array = self::$sentence->fetch(PDO::FETCH_ASSOC)) {
                $jsonData[] = $array;
            }

            return $jsonData;
//            return self::$sentence->fetch(PDO::FETCH_ASSOC);
        }
        else
            return null;
    }


    private function loguear()
    {
        $response = array();

        $body = file_get_contents('php://input');
        //$usuario = json_decode($body);
        $data = self::getPersona();

        if ($data != NULL) {
            http_response_code(200);
            //$response["Id"]  = $data["id"];
//            $response["Nombre"] = $data["Nombre"];
//            $response["Appat"]  = $data["Appat"];
//            $response["Apmat"]  = $data["Apmat"];
            return [
                    "Found" => true,
                    "persona" => var_dump($data),
                    "SQL" => self::$sentence
                    ];
        } else {
            return ["cuco" => 1, "usuario" => "cucoerror"];
            throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                "Ha ocurrido un error");
        }
       
    }

}