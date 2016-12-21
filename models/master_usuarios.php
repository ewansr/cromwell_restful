<?php
/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 26/09/2016
 * Time: 01:12 AM
 */
//require "utils/conexion.php";

 abstract  class master_usuarios{
     const TABLE_NAME = 'master_usuarios';
     const ID = "Idusuario";
     const IDPERSONAL = "IdPersonal";
     const USUARIO = "Usuario";
     const CONTRASENA = "contrasena";
     const CONTRASENA_DECRYPT = "pass_decrypt";
     const EDITABLE = "Editable";
     const IDPERFIL = "IdPerfil";
     const ACTIVO = "Activo";

     const ESTADO_URL_INCORRECTA = "ERROR URL";
     const ESTADO_FALLA_DESCONOCIDA = "FALLA DESCONOCIDA";
     const ESTADO_ERROR_BD = "ERROR AL EJECUTAR LA CONSULTA EN LA BASE DE DATOS";
     const CONSULTA_SQL = " select *, AES_DECRYPT(contrasena,'AES2016') as pass_decrypt FROM master_usuarios";


     public function autenticar($usuario, $contrasena) {
         $comando  = self::CONSULTA_SQL . " WHERE " . self::USUARIO . "=?";

         try {
             $sentencia = Conexion::obtenerInstancia()->obtenerdb()->prepare($comando);
             $sentencia->bindParam(1, $usuario);
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

     public function obtenerUsuario($usuario)
     {
         $comando  = self::CONSULTA_SQL . " WHERE " . self::USUARIO . "=?";
         $sentencia = Conexion::obtenerInstancia()->obtenerdb()->prepare($comando);
         $sentencia->bindParam(1, $usuario);

         if ($sentencia->execute())
             return $sentencia->fetch(PDO::FETCH_ASSOC);
         else
             return null;
     }


     public function login() {
         $respuesta = array();
         $body = file_get_contents('php://input');
         $usuario = json_decode($body);
         $correo     = $usuario->correo;
         $contrasena = $usuario->contrasena;

         if (self::autenticar($correo, $contrasena)) {
             try {
                 $usuarioBD = self::obtenerUsuario($correo);
                 if ($usuarioBD != NULL) {
                     http_response_code(200);
                     header("HTTP/1.1 200 OK");
                     $respuesta[self::ID] = $usuarioBD[self::ID];
                     $respuesta[self::USUARIO] = $usuarioBD[self::USUARIO];
                     $respuesta[self::IDPERSONAL] = $usuarioBD[self::IDPERSONAL];
                     return ["state" => 200,"logueo_valido" => 1,
                         "valid" => 1,
                         "message" => "Logueo Exitoso",
                         self::TABLE_NAME => $respuesta];
                 } else {
                     http_response_code(200);
                     return ["logueo_valido" => 0,
                         "message" => "Usuario o contraseña inválidos",
                         self::TABLE_NAME => $respuesta];
                 }
             }catch (Exception $e){
                 throw new ApiExceptions(self::ESTADO_FALLA_DESCONOCIDA,
                     "Ha ocurrido un error vvv" . $e->getMessage() );
             }
         } else {
             http_response_code(200);
             return ["logueo_valido" => 0,
                 "message" => "Usuario o contraseña inválidoss",
                 self::TABLE_NAME => $respuesta];
         }
     }

     public abstract function post($request);
     public abstract function get($request);
     public abstract function put($request);
     public abstract function delete($request);

 }