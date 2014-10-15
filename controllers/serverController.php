<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

class serverController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){}
    
    
    public function panamericana($wsdl=false)
    {
        if(!$wsdl)
        {
            $this->loadController('metodosController');
            $server = new SoapServer(ROOT . 'public' . DS . 'panamericana.wsdl');
            $server->setClass('metodosController');
            
            /*
            $tz = date_default_timezone_get();
            $header = new SoapHeader('urn:pc_SOAP_return_time', 'get_timezone', $tz);
            $server->addSoapHeader($header);
             */

            try
            {
                $server->handle();
            }
            catch (Exception $e)
            {
                $server->fault('Sender', $e->getMessage());
            }
        }
        else
        {
            $this->_view->renderizaWSDL('panamericana');
        }
    }
}

?>