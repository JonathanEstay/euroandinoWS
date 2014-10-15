<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

class Model
{
    protected $_db;
    public function __construct() {
        $this->_db= new Database;
    }
}