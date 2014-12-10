<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

class View
{
    private $_controlador;
    
    public function __construct(Request $peticion) { //$peticion es un objeto de Request
        $this->_controlador= $peticion->getControlador();
    }
    
    public function renderizaWSDL($vista) {
        $rutaView = ROOT . 'public' . DS . $vista . '.wsdl';
        if (is_readable($rutaView)) {
            header('Content-Type: application/xml; charset=utf-8');
            header('Content-Disposition: inline; filename="' . $vista . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            echo file_get_contents($rutaView);
        } else {
            throw new Exception('Error de vista WSDL');
        }
    }

}