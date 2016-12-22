<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 30/09/2016
 * Time: 02:21 AM
 */

abstract class model_contratista {
    const TABLE_NAME = 'mt_foliosxtecnicos';
    const ID = "IdFolio";
    const ESTADO_URL_INCORRECTA = "ERROR URL";
    const ESTADO_FALLA_DESCONOCIDA = "FALLA DESCONOCIDA";
    const CONSULTA_SQL = "INSERT INTO 
                            mt_foliosxtecnicos(
                              IdFolio,
                              Folio,
                              FolioTelmex,
                              IdPersonal,
                              Telefono,
                              Principal,
                              Secundario,
                              TipoOS,
                              Distrito,
                              Central,
                              Comentarios,
                              FechaCreacion,
                              Estatus,
                              ImgIndex,
                              IdTipo,
                              Terminal,
                              Puerto,
                              IdContratista,
                              EstatusCobro)
                            VALUES
                              (0,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              0,
                              ?,
                              ?,
                              ?,
                              ?,
                              'Pendiente'
                              )";

    public abstract function post($request);
    public abstract function get($request);
    public abstract function put($request);
    public abstract function delete($request);
}