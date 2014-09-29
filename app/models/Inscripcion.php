<?php

class Inscripcion extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_persona';
    public $timestamps = false;

    public static $rules = array(
        'oferta_academica_id'   => array('required', 'exists:oferta_academica,id', 'unique_persona' => 'unique_with:inscripcion_persona,tipo_documento_cod,documento'),
        'tipo_documento_cod' => 'required|exists:repo_tipo_documento,tipo_documento',
        'documento' => 'required|integer|min:1000000|max:99999999',
        'apellido' => 'required',
        'nombre' => 'required',
        'sexo' => 'required|in:m,M,f,F',
        'fecha_nacimiento' => 'required|before:01/01/2004',
        'localidad_id' => 'required|exists:repo_localidad,id',
        //'localidad_otra' => 'text',
        'localidad_anios_residencia'    => 'required|integer|min:1',
        'nivel_estudios_id' => 'required|exists:repo_nivel_estudios,id',
        //'titulo_obtenido' => 'text',
        'email'    => array('required', 'email', 'unique_mail' => 'unique_with:inscripcion_persona,oferta_academica_id,email'),
        'telefono'  => 'required'
    );
    
    public function curso()
    {
        return $this->belongsTo('Curso', 'oferta_academica_id');
    }
    
    public function tipo_documento()
    {
        return $this->belongsTo('TipoDocumento', 'tipo_documento', 'tipo_documento_cod');
    }
    
    public function localidad()
    {
        return $this->belongsTo('Localidad', 'localidad_id');
    }

    public function requisitospresentados()
    {
        return $this->hasMany('RequisitoPresentado');
    }
    
    public function getColumnasCSV()
    {
        return [ 'documento', 'apellido', 'nombre', 'fecha_nacimiento', 'localidad', 'email', 'telefono' ];
    }
    
    public function toCSV()
    {
        $data = [
            'documento'         => $this->documento,
            'apellido'          => $this->apellido,
            'nombre'            => $this->nombre,
            'fecha_nacimiento'  => $this->fecha_nacimiento_text,
            'localidad'         => $this->localidad->localidad,
            'email'             => $this->email,
            'telefono'          => $this->telefono
        ];
        
        $ftemp = fopen('php://temp', 'r+');
        fputcsv($ftemp, $data, ',', "'");
        rewind($ftemp);
        $fila = fread($ftemp, 1048576);
        fclose($ftemp);
        
        return $fila;
    }
    
    public function getTipoydocAttribute()
    {
        return sprintf("%s %s", $this->tipo_documento, number_format($this->documento, 0, ",", "."));
    }
    
    public function getInscriptoAttribute()
    {
        return sprintf("%s %s", $this->apellido, $this->nombre);
    }

    public function getFechaNacimientoTextAttribute()
    {
        return ModelHelper::getFechaFormateada($this->fecha_nacimiento);
    }
    
    public function getDates()
    {
        return array('fecha_nacimiento');
    }

    public static function boot()
    {
        parent::boot();

        Inscripcion::created(function($inscripcion){
            $inscripcion->curso->chequearDisponibilidad();
        });

        Inscripcion::updated(function($inscripcion){
            $inscripcion->curso->chequearDisponibilidad();
        });

        Inscripcion::deleted(function($inscripcion){
            $inscripcion->curso->chequearDisponibilidad();
        });
    }
}
