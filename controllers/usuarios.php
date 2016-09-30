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
        if ( $request[0] == 'login' ){
            return self::login();
        }else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL mal formada, 400");
        }
    }

    public function get($request){

    }

    public function put($request)
    {
        // TODO: Implement put() method.
    }

    public function delete($request)
    {
        // TODO: Implement delete() method.
    }

    private function autenticar($correo, $contrasena) {
        $comando  = "SELECT u.*, ".
            " AES_DECRYPT(u.contrasena,'AES2016') as pass_decrypt ".
            " FROM " .
            self::TABLE_NAME.
            " as u WHERE u." . self::USUARIO . "=?";

        try {

            $sentencia = Conexion::obtenerInstancia()->obtenerdb()->prepare($comando);

            $sentencia->bindParam(1, $correo);
            $sentencia->execute();

            if ($sentencia) {
                $resultado = $sentencia->fetch();
                if ($contrasena === $resultado['pass_decrypt']) {
                    return true;
                } else return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new apiexceptions(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    private function obtenerUsuarioPorCorreo($correo)
    {
            $comando = "SELECT u.*, " .
                " AES_DECRYPT(contrasena,'AES2016') as pass_decrypt " .
                " FROM " .
                self::TABLE_NAME .
                " as u WHERE u." . self::USUARIO . "=?";

            $sentencia = Conexion::obtenerInstancia()->obtenerdb()->prepare($comando);

            $sentencia->bindParam(1, $correo);

            if ($sentencia->execute())
                return $sentencia->fetch(PDO::FETCH_ASSOC);
            else
                return null;
    }

    private function login() {
        $body = file_get_contents('php://input');
        $respuesta = array();
        $usuario = json_decode($body);
        $correo     = $usuario->correo;
        $contrasena = $usuario->contrasena;

        if (self::autenticar($correo, $contrasena)) {
            try {
                http_response_code(204);
                $usuarioBD = self::obtenerUsuarioPorCorreo($correo);
                if ($usuarioBD != NULL) {
                    http_response_code(200);
                    $respuesta[self::ID] = $usuarioBD[self::ID];
                    $respuesta[self::USUARIO] = $usuarioBD[self::USUARIO];
                    return ["state" => 200,"logueo_valido" => 1,
                            "valid" => 1,
                            "message" => "Logueo Exitoso",
                            self::TABLE_NAME => $respuesta];
                } else {

                    return ["logueo_valido" => 0,
                            "message" => "Usuario o contraseña inválidos",
                            self::TABLE_NAME => $respuesta];
                }
            }catch (Exception $e){
                throw new ApiExceptions(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error vvv" . $e->getMessage() );
            }
        } else {
            return ["logueo_valido" => 0,
                    "message" => "Usuario o contraseña inválidos",
                    self::TABLE_NAME => $respuesta];
        }
    }
}