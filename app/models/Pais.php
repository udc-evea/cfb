<?php

class Pais extends Eloquent 
{
    protected $guarded = array();
    protected $table = 'repo_pais';
    public static $rules = array();
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $this->lists('nombre', 'id');
        return $selectVals;
    }
}
