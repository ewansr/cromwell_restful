<?php
/**
 * Created by PhpStorm.
 * User: EwanS
 * Date: 23/09/2016
 * Time: 01:48 AM
 */

class apiexceptions extends Exception{
    public $state;

    public function __construct( $state, $message, $code = 400 ){
        $this->state    = $state;
        $this->message  = $message;
        $this->code     = $code;
    }
}