<?php
/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 26/09/2016
 * Time: 01:12 AM
 */

 abstract  class master_usuarios{
     const TABLE_NAME = 'master_usuarios';
     const ID = "Idusuario";
     const IDPERSONAL = "IdPersonal";
     const USUARIO = "Usuario";
     const CONTRASENA = "contrasena";
     const CONTRASENA_DECRYPT = "pass_decrypt";
     const IMAGENCUENTA = "ImagenCuenta";
     const COMENTARIOS = "Comentarios";
     const LONGITUDCONTRASENA = "LongitudContrasena";
     const EDITABLE = "Editable";
     const IDPERFIL = "IdPerfil";
     const ACTIVO = "Activo";
     const ESTADO_URL_INCORRECTA = "ERROR URL";
     static $sentence = null;

     public abstract function post($request);
     public abstract function get($request);
     public abstract function put($request);
     public abstract function delete($request);
 }