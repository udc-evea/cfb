<?php

class Curso extends Eloquent {
	protected $guarded = array();
        
        protected $table = 'oferta_academica';
        public $timestamps = false;

	public static $rules = array(
		'nombre'        => 'required',
		'anio'          => 'required|digits:4',
        'inicio'        => 'date',
        'fin'           => 'date',
        'cupo_maximo'   => 'integer|min:0'
	);
        
        public function inscripciones()
        {
            return $this
                ->hasMany('Inscripcion', 'oferta_academica_id')
                ->with('localidad')
                ->orderBy('apellido')
                ->orderBy('nombre');
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
             
        public function getPermiteInscripcionesAttribute()
        {
            return ModelHelper::trueOrNull($this->attributes['permite_inscripciones']);
        }

        public function chequearDisponibilidad()
        {
            if($this->inscripciones->count() >= (int)$this->cupo_maximo)
            {
                $this->permite_inscripciones = false;
                $this->save();
            }    
        }

        public function getVistaMail()
        {
            return empty($this->mail_bienvenida) ? 'emails.inscripciones.bienvenida_generico' : 'emails.inscripciones.bienvenida_curso';
        }
        
}
