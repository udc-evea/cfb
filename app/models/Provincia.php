<?php

class Provincia extends Eloquent {
	protected $guarded = array();

	public static $rules = array();
        protected $table = 'repo_provincia';
        
        public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $this->lists('provincia', 'id');
        return $selectVals;
    }
}
