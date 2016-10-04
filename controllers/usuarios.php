<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 26/09/2016
 * Time: 01:29 AM
 */

require "models/master_usuarios.php";

class usuarios extends master_usuarios{

    public function post($request) {
        if ( $request[0] == 'login' ){
            return self::login();
        }else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL mal formada, 400");
        }
    }

    public function get($request){

    }

    public function put($request){
        // TODO: Implement put() method.
    }

    public function delete($request) {
        // TODO: Implement delete() method.
    }

}