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
     * Convierte formatos de fecha Y-m-d => d/m/Y, o vacía.
     * @param string $fn la fecha
     * @return string la fecha en formato d/m/Y
     */
    public static function getFechaFormateada($fn)
    {
       if(!empty($fn) && $fn != '0000-00-00') {
           return date("d/m/Y", strtotime($fn));
       } else {
          return "";
       }
    }

    /**
     * Convierte formatos de fecha d/m/Y => Y-m-d, o vacía.
     * @param string $fn la fecha d/m/Y
     * @return string la fecha en formato Y-m-d
     */
    public static function getFechaISO($fn)
    {
       if(!empty($fn)) {
           $dt = \DateTime::createFromFormat('d/m/Y', $fn);

           if($dt)
            return $dt->format('Y-m-d');
           else
            return $fn;

       } else {
          return "";
       }
    }
    
    public static function getFechaFormateadaDT($fecha)
    {
       $dia = $mes = $anio = 0;
       
       if(empty($fecha))
       {
           return null;
       }
       
       sscanf($fecha, "%d/%d/%d", $dia, $mes, $anio);
       return \DateTime::createFromFormat("Y-m-d", "$anio-$mes-$dia");
    }
}
