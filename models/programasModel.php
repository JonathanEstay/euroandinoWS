<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

class programasModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getProgramas($record_c) {
        $sql = 'EXEC WS_getProgramas "' . $record_c . '" ';

        $datos = $this->_db->consulta($sql);
        if ($this->_db->numRows($datos) > 0) {
            return $this->_db->fetchAll($datos);
        } else {
            return false;
        }
    }

}