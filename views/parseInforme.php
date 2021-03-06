<?php

/* 
 * Proyecto : EuroandinoWS
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 15 de octubre de 2014
 */

$datosPackages= $LM_reserva->getPackages($MC_CodigoPrograma);
$datosDetFile= $LM_reserva->getDetFile($mC_TC_file);
$datosDetBloq= $LM_reserva->getDetBloq($MC_CodigoBloqueo, $mC_TC_file);
$datosBloq= $LM_reserva->getBloqueos($MC_CodigoBloqueo);

//CARGAR LA PLANTILLA DEL CORREO
$mC_HTML=file_get_contents( ROOT . 'views' . DS . 'detalle_informe.html');

$nodosHTML= array();
$nodosHTML["fecha_act"]= date("d F Y");
$nodosHTML["file"]= $mC_TC_file;
$nodosHTML["agencia"]= mb_convert_encoding(trim($datosFile[0]['agencia']), "UTF-8");


//$nodosHTML["nombre_user"]= trim($var_getUser[0]['nombre']);
$nodosHTML["nombre_user"]= trim($datosFile[0]['vage']);


$nodosHTML["nombre_pax"]= mb_convert_encoding(trim($datosFile[0]['nompax']),  "UTF-8");
$nodosHTML["num_pax"]= trim($datosFile[0]['npax']);
$nodosHTML["fecha_viaje"]= trim($datosFile[0]['f_viaje']);

$nodosHTML["nombre_prog"]= mb_convert_encoding(trim($datosPackages[0]['nombre']), "UTF-8");


//INCLUYE 
$mC_incluye='';
if($datosDetFile!=false)
{
    foreach($datosDetFile as $columnDF):
        $mC_totPax=(intval($columnDF["pax_s"]) + intval($columnDF["pax_d"]) + 
                    intval($columnDF["pax_t"]) + intval($columnDF["pax_q"]) + 
                    intval($columnDF["pax_a"]) + intval($columnDF["pax_i"]) + 
                    intval($columnDF["pax_c"]) + intval($columnDF["pax_ca"]) + 
                    intval($columnDF["pax_c2"]));

        $mC_incluye.='<tr>
<td width="80%" class="Base"><strong>&middot;</strong>&nbsp; '.$mC_totPax.' Pax '.mb_convert_encoding(trim($columnDF["nombre"]), "UTF-8", "ISO-8859-1").'<strong></strong></td>
<td width="10%" class="Base">';

        if(trim($columnDF["in_"]) != "01/01/1900")
        {
            $mC_incluye.= trim($columnDF["in_"]); 
        }

        $mC_incluye.='</td>
<td width="10%" class="Base">';

        if(trim($columnDF["out"]) != "01/01/1900")
        {
            $mC_incluye.= trim($columnDF["out"]);
        }

        $mC_incluye.='</td></tr>';
    endforeach;
}

$nodosHTML["incluye"]=$mC_incluye;

$mc_totVenta=trim($datosFile[0]['totventa']);
$mc_ajuste=trim($datosFile[0]['ajuste']);

if(trim($datosFile[0]['moneda']) == "D")
{
    $nodosHTML["texto_moneda"]='D&oacute;lares Americanos (USD)';
    $nodosHTML["valor_total"]=number_format($mc_totVenta, 2, ',', '.').' + '.number_format($mc_ajuste, 2, ',', '.');
    $nodosHTML["tipo_cambio"]='<tr>
                                <td width="25%" bgcolor="#E6E6E6">
                                    <strong>&nbsp;Tipo de cambio al d&iacute;a de hoy </strong>
                                </td>
                                <td width="2%">:</td>
                                <td width="75%">
                                        540 (Consultar al momento del pago)
                                </td>
                            </tr>';
}
elseif(trim($datosFile[0]['moneda']) == "P")
{
    $nodosHTML["texto_moneda"]='Pesos Chilenos ($)';
    $nodosHTML["valor_total"]=number_format($mc_totVenta, 0, '', '.').' + '.number_format($mc_ajuste, 0, '', '.');
    $nodosHTML["tipo_cambio"]='';
}


$nodosHTML["comag"]=trim($datosFile[0]['comag']);

if(trim($datosFile[0]['tcomi'])=='1')
{
    $nodosHTML["tcomi"]=' + I.V.A.';
}
else if(trim($datosFile[0]['tcomi'])=='1')
{
    $nodosHTML["tcomi"]=' I.V.A. Incluido';
}



if($datosDetBloq!=false)
{
    $mC_detBloq='';
    $cntDetBloq=1;
    foreach($datosDetBloq as $columnDB):
        $mC_detBloq.='<tr>
                <td>'.$cntDetBloq.'</td>
                <td>';

        if(trim($columnDB["tipo_pax"]) == 'A')
        {
            $mC_detBloq.="Adulto";
        }
        else if($columnDB["tipo_pax"] == 'C')
        {
            $mC_detBloq.="Child";
        }

        $mC_detBloq.=	'</td>
                <td>'.mb_convert_encoding(str_replace('/', ' ', trim($columnDB["nompax"])), "UTF-8").'</td>
                <td>'.trim($columnDB["rut"]).'</td>
                <td>';

        if(trim($columnDB["fchild"]) == "01/01/1900") 
        {
            $mC_detBloq.=''; 
        }
        else 
        {
            $mC_detBloq.=trim($columnDB["fchild"]);
        }

        $mC_detBloq.='</td>
                <td>'.mb_convert_encoding(trim($columnDB["ninfant"]), "UTF-8").'</td>
                <td>'.trim($columnDB["rut_inf"]).'</td>
                <td>';

        if(trim($columnDB["finfant"]) == "01/01/1900")
        {
            $mC_detBloq.=''; 
        }
        else 
        {
            $mC_detBloq.=$columnDB["finfant"];
        }
        $mC_detBloq.='</td>
        </tr>';

        ++$cntDetBloq;
    endforeach;
    $nodosHTML["detalle_pasajeros"]=$mC_detBloq;
}


$nodosHTML["itinerario_vuelo"]=mb_convert_encoding(str_replace("\n", "<br>", trim($datosBloq[0]['NOTAS'])), "UTF-8");


foreach($nodosHTML as $nombreNodo=>$valorNodo):
    $mC_HTML= str_replace('{'.$nombreNodo.'}', $valorNodo, $mC_HTML);
endforeach;
?>