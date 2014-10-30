<?php

class RamaActividadLaboral extends Eloquent 
{
    protected $guarded = array();
    protected $table = 'rama_actividad_laboral';
    public static $rules = array();
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $query->orderBy('descripcion')->lists('descripcion', 'id');
        return $selectVals;
    }
}
