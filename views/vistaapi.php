<?php
/**
 * Created by PhpStorm.
 * User: EwanS
 * Date: 23/09/2016
 * Time: 01:35 AM
 */

abstract class  vistaapi{
    // Error code
    public $state;
    public abstract function mprint($body);
}