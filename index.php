<?php
/**
 * Created by PhpStorm.
 * User: Saulo Euan
 * Date: 23/09/2016
 * Time: 12:57 AM
 * Entrada http://127.0.0.1:8080/api.royalcoder.mx/cromwell/contactos/1
 * Salida Contactos/1
 */
//    require 'utils/conexion.php';
//    print  conexion::obtenerInstancia()->obtenerDB()->errorCode();

/*
 * La idea básica es usar una estructura switch para atender los cuatro verbos GET, POST, PUT y DELETE dependiendo del
 * segmento que llega a través de PATH_INFO. El algoritmo preciso sería el siguiente:
 */
require 'views/vistajson.php';
require 'utils/conexion.php';
require 'models/nuc_persona.php';



$req = $_GET['PATH_INFO'];

$stack = array($req);
$resource = array_shift($stack); // Here you give the parameter

//      = array_shift( $request );
print $resource;
$all_resources = array('nuc_persona');

//if ( !in_array($req, $all_resources) ){
//    //Agregar respuesta de error
//}

$method = strtolower($_SERVER['REQUEST_METHOD']);

switch ($method){
    case 'get':
        break;

    case  'post':
        $view->mprint(nuc_persona::post($req));
        break;

    case 'put':
        break;

    case 'delete':
        break;

    default:
}

$view = new vistajson();

set_exception_handler(function ( $exception ) use ($view){
    $body = array(
        "estado"    => $exception->state,
        "mensaje"   => $exception->getMessage()
    );

    if ($exception->getCode()){
        $view->state = $exception->getCode();
    }else{
        $view->state = 500;
    }
    $view->mprint( $body );
});

