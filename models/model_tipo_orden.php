<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 30/09/2016
 * Time: 02:21 AM
 */

abstract class model_tipo_orden {
    const TABLE_NAME = 'mt_tipoorden';
    const ID = "IdTipo";
    const ESTADO_URL_INCORRECTA = "ERROR URL";
    const ESTADO_FALLA_DESCONOCIDA = "FALLA DESCONOCIDA";
    const CONSULTA_SQL = "select * from mt_tipoorden where TipoInstalacion = ? order by TipoInstalacion";

    public abstract function post($request);
    public abstract function get($request);
    public abstract function put($request);
    public abstract function delete($request);
}