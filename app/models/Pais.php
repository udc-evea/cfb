<?php

class Pais extends Eloquent 
{
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
