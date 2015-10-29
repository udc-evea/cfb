<?php

class Inicio extends Eloquent {

    protected $guarded = array();
    protected $table = 'version_bd';
    public $timestamps = false;
    
    public static $rules = array(
		'version' => 'between:2,10',
	);
    
    public function getVersionDB() {
        return $this->version;
    }
    
}
