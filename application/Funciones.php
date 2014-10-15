<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

class Funciones
{
    public static function invertirFecha($fecha, $char, $newChar)
    {
        $datos = explode($char, $fecha);
        $fechaFinal = $datos[2].$newChar.$datos[1].$newChar.$datos[0];
        return $fechaFinal;
    }
    
    public static function getTipoMoneda($moneda)
    {
        if($moneda == 'D')
        {
             $newMon= 'USD';
        }
        elseif($moneda == 'P')
        {
            $newMon= '$';
        }
        elseif($moneda == 'E')
        {
            $newMon= 'EUR';
        }
        
        return $newMon;
    }
}