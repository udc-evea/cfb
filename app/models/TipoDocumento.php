<?php

class TipoDocumento extends Eloquent {
	const TIPODOC_DNI = 1;
    
        protected $guarded = array();
        
        protected $table = 'repo_tipo_documento';
        public $timestamps = false;

	public static $rules = array(
		'descripcion' => 'required'
	);
}
