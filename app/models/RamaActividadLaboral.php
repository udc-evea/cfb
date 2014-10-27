<?php

class RamaActividadLaboral extends Eloquent 
{
    protected $guarded = array();
    protected $table = 'rama_actividad_laboral';
    public static $rules = array();
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $this->lists('descripcion', 'id');
        return $selectVals;
    }
}
