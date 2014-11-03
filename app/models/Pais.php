<?php

class Pais extends Eloquent 
{
    const ID_OTRO = 99;
    
    protected $guarded = array();
    protected $table = 'repo_pais';
    public static $rules = array();
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $query->orderBy('nombre')->lists('nombre', 'id');
        return $selectVals;
    }
}
