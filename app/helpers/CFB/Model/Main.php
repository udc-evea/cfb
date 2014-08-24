<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Main
 *
 * @author universidad
 */
namespace CFB\Model;

class Main
{
    /**
     * Devuelve la fecha original, o bien NULL si está vacía o es "cero"
     * @param String $value la fecha
     * @return String|null la fecha original, o null si está vacía
     */
    public static function dateOrNull($value)
    {
        return (in_array($value, ['0000-00-00', ''])) ? NULL : $value;
    }
    
    /**
     * Devuelve 1 o null, para solucionar problemas de 
     * "checkboxes" siempre chequeados
     * @param int $value valor de la columna
     * @return int|null valor resultado
     */
    public static function trueOrNull($value)
    {
        return ($value == 1) ? 1 : null;
    }
    
    /**
     * Formatea una fecha en d/m/Y, o vacía (por ejemplo, para mostrar en form)
     * @param \DateTime $fn la fecha (DateTime, Carbon)
     * @return string la fecha formateada
     */
    public static function getFechaFormateada(\DateTime $fn)
    {
       if($fn)
       {
           return $fn->format("d/m/Y");
       }
       else
       {
          return ""; 
       }
    }
    
    public static function getFechaFormateadaDT($fecha)
    {
       $dia = $mes = $anio = 0;
       
       if(!$fecha)
       {
           return null;
       }
       
       sscanf($fecha, "%d/%d/%d", $dia, $mes, $anio);
       return \DateTime::createFromFormat("Y-m-d", "$anio-$mes-$dia");
    }
}
