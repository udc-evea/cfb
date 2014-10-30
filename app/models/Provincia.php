<?php

class Provincia extends Eloquent {
	protected $guarded = array();

	public static $rules = array();
        protected $table = 'repo_provincia';
        
        public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $query->orderBy('provincia')->lists('provincia', 'id');
        return $selectVals;
    }
}
