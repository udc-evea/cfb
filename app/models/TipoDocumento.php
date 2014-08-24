<?php

class TipoDocumento extends Eloquent {
	const TIPODOC_DNI = 'DU';
    
        protected $guarded = array();
        
        protected $table = 'repo_tipo_documento';
        public $timestamps = false;
        protected $primaryKey = "tipo_documento";
        

	public static $rules = array(
		'tipo_documento' => 'required',
		'descripcion' => 'required'
	);
}
