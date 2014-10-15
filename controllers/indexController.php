<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

class indexController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){}
    
    
    public function PanamericanaServer()
    {
        $server = new SoapServer("Oris.wsdl");
        $server->setClass("Metodos");

        try
        {
            $server->handle();
        }
        catch (Exception $e)
        {
            $server->fault('Sender', $e->getMessage());
        }
    }
}

?>