<?php

/**
 * Created by PhpStorm.
 * User: Saulo
 * Date: 26/09/2016
 * Time: 01:14 AM
 */
 abstract class generalmodel{
     public static $TABLE_NAME = NULL;
     public static $ID = NULL;

     abstract protected function post();
     abstract protected function get();
     abstract protected function put();
     abstract protected function delete();

 }
