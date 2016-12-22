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
        }else if($request[0] == 'guardar_orden'){
           return self::guardar_orden();
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

    public function guardar_orden(){
        $body     = file_get_contents('php://input');
        $params   = json_decode($body);
        $folio = $params->folio;
        $foliotelmex = $params->foliotelmex;
        $idpersonal = $params->idpersonal;
        $telefono = $params->telefono;
        $principal = $params->principal;
        $secundario = $params->secundario;
        $tipoos = $params->tipoos;
        $distrio = $params->distrito;
        $central = $params->central;
        $comentarios = $params->comentarios;
        $estatus = $params->estatus;
        $idtipo = $params->idtipo;
        $terminal = $params->terminal;
        $puerto = $params->puerto;
        $idcontratista = $params->idcontratista;


        $comando ="INSERT INTO 
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
                              now(),
                              ?,
                              0,
                              ?,
                              ?,
                              ?,
                              ?,
                              'Pendiente'
                              )";
        try{

            if (self::existeFolio($folio)){
                http_response_code(200);
                return ["valid" => 0,
                    "found" => 1,
                    "message" => "La orden de trabajo que deseas registrar ya se encuentra en la base de datos"];
            }else {

                $sentencia = conexion::obtenerInstancia()->obtenerDB()->prepare($comando);
                $sentencia->bindParam(1, $folio);
                $sentencia->bindParam(2, $foliotelmex);
                $sentencia->bindParam(3, $idpersonal);
                $sentencia->bindParam(4, $telefono);
                $sentencia->bindParam(5, $principal);
                $sentencia->bindParam(6, $secundario);
                $sentencia->bindParam(7, $tipoos);
                $sentencia->bindParam(8, $distrio);
                $sentencia->bindParam(9, $central);
                $sentencia->bindParam(10, $comentarios);
                $sentencia->bindParam(11, $estatus);
                $sentencia->bindParam(12, $idtipo);
                $sentencia->bindParam(13, $terminal);
                $sentencia->bindParam(14, $puerto);
                $sentencia->bindParam(15, $idcontratista);


                if ($sentencia->execute()) {
                    http_response_code(200);
                    return ["valid" => 1,
                        "found" => 1,
                        "message" => "Órden de Trabajo registrada exitosamente."];
                } else {
                    http_response_code(200);
                    return ["valid" => 0,
                        "found" => 0,
                        "message" => "Error al registrar la órden de trabajo. Intente nuevamente."];
                }
            }
        } catch (PDOException $e) {
            throw new apiexceptions(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    public function existeFolio($folio_check){
        $comando ="Select folio from mt_foliosxtecnicos where folio = ?";
        try{
            $sentencia = conexion::obtenerInstancia()->obtenerDB()->prepare($comando);
            $sentencia->bindParam(1,$folio_check);

            if ($sentencia->execute()){
                $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
                if ($registros != NULL) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        } catch (PDOException $e) {
            throw new apiexceptions(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}