<?php
/**
 * Created by PhpStorm.
 * User: EwanS
 * Date: 23/09/2016
 * Time: 01:37 AM
 */

require_once 'vistaapi.php';

class vistajson extends vistaapi{
    public function  __construct( $state = 400 ){
        $this->state = $state;
    }
    public function mprint( $body )
    {
        // TODO: Implement mprint() method.
        if ( $this->state ){
            http_response_code( $this->state );
        }
        header( 'Content-Type: application/json; charset=utf8' );
        echo json_encode( $body, JSON_PRETTY_PRINT );
        exit;
    }
}