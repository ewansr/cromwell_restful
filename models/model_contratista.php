<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 30/09/2016
 * Time: 02:21 AM
 */

abstract class model_contratista {
    const TABLE_NAME = 'mt_contratistas';
    const ID = "IdContratista";
    const ESTADO_URL_INCORRECTA = "ERROR URL";
    const ESTADO_FALLA_DESCONOCIDA = "FALLA DESCONOCIDA";
    const CONSULTA_SQL = "select * from mt_contratistas order by Contratista ASC";

    public abstract function post($request);
    public abstract function get($request);
    public abstract function put($request);
    public abstract function delete($request);
}