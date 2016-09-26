<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 26/09/2016
 * Time: 01:29 AM
 */
require 'models/master_usuarios.php';

class usuarios extends master_usuarios{

    public function post($request)
    {
        // TODO: Implement post() method.
    }

    public function get($request){
        if ( $request[0] == 'login' ){
            return self::login();
        }else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL mal formada, 400");
        }
    }

    public function put($request)
    {
        // TODO: Implement put() method.
    }

    public function delete($request)
    {
        // TODO: Implement delete() method.
    }
    
    public function login(){
//        $SQLCommand = "SELECT " .self::ID.",".self::IDPERSONAL.",".self::USUARIO." FROM " . self::TABLE_NAME ;
        $SQLCommand = "SELECT *, "." AES_DECRYPT(contrasena,'AES2016') as pass_decrypt"." FROM " . self::TABLE_NAME ;
        self::$sentence = conexion::obtenerInstancia()->obtenerDB()->prepare($SQLCommand);

        if (self::$sentence->execute()) {
            $data = self::$sentence->fetch(PDO::FETCH_ASSOC);
            if ($data != NULL) {
                http_response_code(200);
                $row = $data;
//                $jsonData = array();
//                while ($row = mysql_fetch_row(self::$sentence)) {

                    $response[self::ID] = $row[self::ID];
                    $response[self::IDPERSONAL] = $row[self::IDPERSONAL];
                    $response[self::USUARIO] = $row[self::USUARIO];
                    $response[self::CONTRASENA_DECRYPT] = $row[self::CONTRASENA_DECRYPT];
                    $response[self::COMENTARIOS] = $row[self::COMENTARIOS];
                    $response[self::EDITABLE] = $row[self::EDITABLE];
                    $response[self::IDPERFIL] = $row[self::IDPERFIL];
                    $response[self::ACTIVO] = $row[self::ACTIVO];
//                    $jsonData = $row;
//                }
                    return [
                        "Found" => true,
                        SELF::TABLE_NAME => $response,
                        "SQL" => self::$sentence
                    ];

            } else {
                return ["Found" => False, "usuario" => "Usuario no encontrado"];
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error");
            }
        }
    }
}