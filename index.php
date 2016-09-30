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

//require 'controladores/nuc_persona.php';
require 'controllers/usuarios.php';
require 'controllers/ordenes_trabajo.php';
require 'views/vistajson.php';
require 'utils/apiexceptions.php';
require 'models/nuc_persona.php';

// Constantes de estado
const ESTADO_URL_INCORRECTA = 2;
const ESTADO_EXISTENCIA_RECURSO = 3;
const ESTADO_METODO_NO_PERMITIDO = 4;

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

// Extraer segmento de la url
if (isset($_GET['PATH_INFO'])) {
    $request = explode('/', $_GET['PATH_INFO']);
    //print($request[0]);
}
else
    throw new apiexceptions(ESTADO_URL_INCORRECTA, utf8_encode("No se reconoce la petición"));

// Obtener recurso
$resource = array_shift($request);
$resource_available = array('nuc_persona', 'usuarios', 'ordenes_trabajo');

// Comprobar si existe el recurso
if (!in_array($resource, $resource_available)) {
    throw new apiexceptions(ESTADO_EXISTENCIA_RECURSO,
        "No se reconoce el recurso al que intentas acceder");
}

$method = strtolower($_SERVER['REQUEST_METHOD']);

switch ($method){
    case 'get':
        $response = call_user_func(array($resource, $method), $request);
        $view->mprint($response);
        break;

    case  'post':
        //$view->mprint(nuc_persona::post($request));
        $response = call_user_func(array($resource, $method), $request);
        $view->mprint($response);
        break;

    case 'put':
        break;

    case 'delete':
        break;

    default:
}


