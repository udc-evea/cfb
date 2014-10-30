<?php

class CategoriaOcupacional extends Eloquent 
{
    protected $guarded = array();
    protected $table = 'categoria_ocupacional';
    public static $rules = array();
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $query->orderBy('categoria')->lists('categoria', 'id');
        return $selectVals;
    }
}
