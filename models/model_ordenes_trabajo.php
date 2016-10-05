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
    const CONSULTA_SQL = "Select DISTINCT
                            ft.central,
                            ft.idFolio,
                            ft.Folio,
                            ft.FolioTelmex,
                            ft.IdPersonal,
                            ft.Telefono,
                            ft.Direccion,
                            ft.Principal,
                            ft.Secundario,
                            ft.TipoOS,
                            ft.Distrito,
                            ft.Central,
                            REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(ft.Comentarios, 'Ú','U'),'Ó','O'), 'Í', 'I'),'É','E'),'Á','A') as Comentarios,
                            ft.FechaCreacion,
                            ft.Estatus,
                            ft.IdTipo,
                            ft.Terminal,
                            ft.Puerto,
                            ft.IdContratista,
                            ft.EstatusCobro,
                            c.*,
                            tr.*,
                            cc.*,
                            (Select contratista from mt_contratistas where IdContratista = ft.IdContratista) as sContratista,
                      
                        DATE_ADD(FechaCreacion, INTERVAL 1 HOUR) as editablehasta,
                        If(now() <= DATE_ADD(FechaCreacion, INTERVAL 1 HOUR), 'Si', 'NO') as editable,
                            DATE_ADD(FechaCreacion,INTERVAL 1 MONTH) as Garantia,
                             if(DATE(NOW()) <= DATE(DATE_ADD(FechaCreacion,INTERVAL 1 MONTH)),CONCAT('GARANTIA QUEDAN ', DATEDIFF(date(NOW()),DATE(DATE_ADD(FechaCreacion,INTERVAL 1 MONTH))), ' DIAS'),'SIN GARANTIA') as EstatusGarantia,
                            If(ft.estatus = 'Liquidada' ,IFNULL(if(c.Ubicacion = 'Local', cc.PagoTecnicoLocal, if(c.Ubicacion = 'Foraneo',cc.PagoTecnicoForaneo, 0)),0), 0) as Costo
                        From mt_foliosxtecnicos as ft
                            left join
                          mt_tipoorden as tr on (tr.idTipo=ft.IdTipo)

                            left join
                              mt_central as c
                            on (c.Codigo = ft.Central)

                            left join
                              mt_costos as cc
                            on (cc.IdTipoOrden = ft.IdTipo and cc.Vigencia = (Select max(vigencia) from mt_costos where IdTipoOrden = ft.IdTipo and vigencia <= ft.FechaCreacion))

                        where
                          ft.IdPersonal = ? and
                          DATE(ft.fechacreacion) BETWEEN DATE(?) and DATE(?)  group by ft.IdFolio";
    static $datos = null;


    public function cargar_ordenes(){
        self::$datos = conexion::obtenerInstancia()->obtenerDB()->prepare(self::CONSULTA_SQL);
        $personal = 30;
        $inicio = "2016-10-05";
        $termino = "2016-10-05";
        self::$datos->bindParam(1, $personal);
        self::$datos->bindParam(2, $inicio);
        self::$datos->bindParam(3, $termino);


//        $dt = '2009-04-30 10:09:00';
//        $stmt->bind_param('s', $dt);

        if (self::$datos->execute()){
            $jsonData = array();
            while ($array = self::$datos->fetch(PDO::FETCH_ASSOC)){
                $jsonData[] = $array;
            }

            if ($jsonData != null){
                http_response_code(200);
                return[
                    "found" => 1,
                    "valid" => 1,
                    self::TABLE_NAME => $jsonData
                ];
            }else{
                http_response_code(200);
                return[
                    "found" => 0,
                    "valid" => 0,
                    "message" => "No se encontraron registros que coincidan con el criterio seleccionado",
                    self::TABLE_NAME => $jsonData
                ];

            }


        }

    }



    public abstract function post($request);
    public abstract function get($request);
    public abstract function put($request);
    public abstract function delete($request);
}