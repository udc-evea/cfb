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
namespace CFB\Bootstrap;

class Bootstrap3
{
    public static function bool_to_label($param)
    {
        $type = $param ? "success" : "danger";
        $text = $param ? "Sí" : "No";
        
        $label = "<label class=\"label label-$type\">$text</label>";
        
        return $label;
    }
    
    public static function bool_to_check($param)
    {
        $type = $param ? "ok" : "remove";
        $label = "<span class=\"glyphicon glyphicon-$type\"/>";
        
        return $label;
    }
}
