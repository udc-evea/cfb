<?php

class ConQuienVive extends Eloquent 
{
    protected $guarded = array();
    protected $table = 'con_quien_vive';
    public static $rules = array();
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $this->lists('descripcion', 'id');
        return $selectVals;
    }
}
