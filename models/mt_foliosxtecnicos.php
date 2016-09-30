<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 30/09/2016
 * Time: 02:21 AM
 */

abstract class mt_foliosxtecnicos {
    const TABLE_NAME = 'mt_foliosxtecnicos';
    const ID = "Idfolioxtecnico";
    const ESTADO_URL_INCORRECTA = "ERROR URL";
    const ESTADO_FALLA_DESCONOCIDA = "FALLA DESCONOCIDA";
    public abstract function post($request);
    public abstract function get($request);
    public abstract function put($request);
    public abstract function delete($request);
}