<?php
/**
 * Created by PhpStorm.
 * User: EwanS
 * Date: 23/09/2016
 * Time: 01:54 AM
 */
class nuc_persona{
    const TABLE_NAME = "nuc_persona";
    const ID     = "Id";
    const NOMBRE = "Nombre";
    const APPAT  = "Appat";
    const APMAT  = "Apmat";

    public static function post( $request ){
        if ( $request[0] == 'registro' ){
            return self::registrar();
        }else if ( $request[0] == 'login' ){
            return self::loguear();
        }else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL mal formada, 400");
        }
    }

    private function getPersona($nombre)
    {
        $comando = "SELECT " .
            self::NOMBRE . "," .
            self::APPAT . "," .
            self::APMAT . "" .

            " FROM " . self::TABLE_NAME ;

        $sentencia = conexion::obtenerInstancia()->obtenerDB()->prepare($comando);

//        $sentencia->bindParam(1, $nombre);

        if ($sentencia->execute())
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        else
            return null;
    }


    private function loguear()
    {
        $respuesta = array();

        $body = file_get_contents('php://input');
        $usuario = json_decode($body);

        $nombre = $usuario->nombre;



        if (true) {
            $usuarioBD = self::getPersona($nombre);

            if ($usuarioBD != NULL) {
                http_response_code(200);
                $respuesta["nombre"] = $usuarioBD["nombre"];
                return ["estado" => 1, "usuario" => $respuesta];
            } else {
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error");
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_PARAMETROS_INCORRECTOS,
                utf8_encode("Correo o contraseña inválidos"));
        }
    }

}