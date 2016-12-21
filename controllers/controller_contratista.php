<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 30/09/2016
 * Time: 02:28 AM
 */

require 'models/model_contratista.php';

class controller_contratista extends model_contratista{
    public function post($request)
    {
        if($request[0] == 'catalogo'){
            return self::catalogo();
        }
        else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL MAL FORMADA 400");
        }
    }

    public function get($request)
    {

    }

    public function put($request)
    {
        // TODO: Implement put() method.
    }

    public function delete($request)
    {
        // TODO: Implement delete() method.
    }

    public function catalogo(){
       $comando = self::CONSULTA_SQL;
        try{
            $sentencia = conexion::obtenerInstancia()->obtenerDB()->prepare($comando);
            $sentencia->bindParam(1, $tipo);
            if ($sentencia->execute()){
                $jsonData = array();
                while ($array = $sentencia->fetch(PDO::FETCH_ASSOC)){
                    $jsonData[] = $array;
                }

                if ($jsonData != null){
                    http_response_code(200);
                    return[
                        "found" => 1,
                        "valid" => 1,
                        self::TABLE_NAME => $jsonData
                    ];
                }else{
                    http_response_code(200);
                    return[
                        "found" => 0,
                        "valid" => 0,
                        "message" => "No data",
                        self::TABLE_NAME => $jsonData
                    ];

                }
            }
            else{
                http_response_code(200);
                return[
                    "found" => 0,
                    "valid" => 0,
                    "message" => "No data",
                    self::TABLE_NAME => $jsonData
                ];

            }
        } catch (PDOException $e) {
            throw new apiexceptions(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}