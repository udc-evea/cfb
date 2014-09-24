<?php

class Curso extends Eloquent {
	protected $guarded = array();
        
        protected $table = 'oferta_academica';
        public $timestamps = false;

	public static $rules = array(
		'nombre'  => 'required',
		'anio'    => 'required|digits:4',
                'inicio'  => 'date',
                'fin'     => 'date'
	);
        
        public function inscripciones()
        {
            return $this->hasMany('Inscripcion', 'oferta_academica_id');
        }
        
        public function requisitos()
        {
            return $this->hasMany('Requisito', 'oferta_id');
        }
        
        public function getInscriptosAttribute()
        {
            return $this->inscripciones->count();
        }
        
        public function getInicioAttribute()
        {
            return ModelHelper::dateOrNull($this->attributes['inicio']);
        }
        
        public function setInicioAttribute($value)
        {
             $this->attributes['inicio'] = ModelHelper::dateOrNull($value);
        }
        
        public function getFinAttribute()
        {
            return ModelHelper::dateOrNull($this->attributes['fin']);
        }
        
        public function setFinAttribute($value)
        {
             $this->attributes['fin'] = ModelHelper::dateOrNull($value);
        }
        
        public function getVigenteAttribute()
        {
            return ModelHelper::trueOrNull($this->attributes['vigente']);
        }
        
        public function getPermiteInscripcionesAttribute()
        {
            return ModelHelper::trueOrNull($this->attributes['permite_inscripciones']);
        }
        
}
