<?php

class Localidad extends Eloquent {
    const ID_RAWSON = 57;
    
	protected $guarded = array();
        
        protected $table = 'repo_localidad';
        public $timestamps = false;

	public static $rules = array(
		'codigo_provincia' => 'required',
		'localidad' => 'required',
		'codigoPostal' => 'required',
		'codigoTelArea' => 'required',
		'latitud' => 'required',
		'longitud' => 'required'
	);
        
        public function provincia()
        {
            return $this->belongsTo('Provincia');
        }
}
