<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 30/09/2016
 * Time: 02:28 AM
 */

require 'models/model_ordenes_trabajo.php';

class ordenes_trabajo extends mt_foliosxtecnicos{
    public function post($request)
    {
        if($request[0] == 'tablero'){
            return self::cargar_tablero();
        }else if($request[0] == 'todas_ordenes'){
           return self::cargar_ordenes();
        }
        else{
            throw new apiexceptions(self::ESTADO_URL_INCORRECTA, "URL MAL FORMADA 400");
        }
    }

    public function get($request)
    {
        // TODO: Implement get() method.
    }

    public function put($request)
    {
        // TODO: Implement put() method.
    }

    public function delete($request)
    {
        // TODO: Implement delete() method.
    }

    public function cargar_tablero(){
        $comando =
            " Select".
            " (Select Count(*) from mt_foliosxtecnicos where DATE(fechacreacion) =  DATE(NOW()) and estatus = 'Liquidada') as liquidadas,".
            " (Select Count(*) from mt_foliosxtecnicos where DATE(fechacreacion) =  DATE(NOW()) and estatus = 'Objetada') as objetadas,".
            " (Select Count(*) from mt_foliosxtecnicos where DATE(fechacreacion) =  DATE(NOW()) and estatus = 'Queja') as quejas,".
            " (Select Count(*) from mt_foliosxtecnicos where DATE(fechacreacion) =  DATE(NOW()) and estatus = 'Retornada') as retornadas,".
            " (Select Count(*) from mt_foliosxtecnicos where DATE(fechacreacion) =  DATE(NOW())) as Total".
            " From mt_foliosxtecnicos as ft".
            " left join ".
            " mt_central as c".
            " on (c.Codigo = ft.Central) ".
            " left join".
            " mt_tipoorden as tr ".
            " on (tr.idTipo=ft.IdTipo)".
            " inner join".
            " master_personal as p".
            " on (p.IdPersonal = ft.IdPersonal)".
            " where".
            " DATE(ft.fechacreacion) =  DATE(NOW())".
            " group by ft.IdFolio";
        try{
            $sentencia = conexion::obtenerInstancia()->obtenerDB()->prepare($comando);
            if ($sentencia->execute()){
                http_response_code(200);
                $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
                if ($registros != NULL){
                    return ["valid" => 1,
                            "found" => 1,
                            "message" => "Registros cargado exitosamente",
                            self::TABLE_NAME => $registros];
                }
            }
        } catch (PDOException $e) {
            throw new apiexceptions(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}