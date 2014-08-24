<?php

class Inscripcion extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_persona';
    public $timestamps = false;

    public static $rules = array(
        'oferta_academica_id'   => 'required|exists:oferta_academica,id|unique_with:inscripcion_persona,tipo_documento_cod,documento|unique_with:inscripcion_persona,email',
        'tipo_documento_cod' => 'required|exists:repo_tipo_documento,tipo_documento',
        'documento' => 'required|integer|min:1000000|max:99999999',
        'apellido' => 'required',
        'nombre' => 'required',
        'sexo' => 'required|in:m,M,f,F',
        'fecha_nacimiento2' => 'required|date_format:"d/m/Y"|before:2004-01-01',
        'localidad_id' => 'required|exists:repo_localidad,id',
        'localidad_otra' => 'text',
        'localidad_anios_residencia'    => 'required|integer|min:1',
        'nivel_estudios_id' => 'required|exists:repo_nivel_estudios,id',
        'titulo_obtenido' => 'text',
        'email'    => 'required|email',
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
    
    public function getTipoydocAttribute()
    {
        return sprintf("%s %s", $this->tipo_documento, number_format($this->documento, 0, ",", "."));
    }
    
    public function getInscriptoAttribute()
    {
        return sprintf("%s %s", $this->apellido, $this->nombre);
    }
    
    public function getDates()
    {
        return array('fecha_nacimiento');
    }
    
    public function getFechaNacimiento2Attribute()
    {
       return ModelHelper::getFechaFormateada($this->fecha_nacimiento);
    }
    
    public function setFechaNacimiento2Attribute($value)
    {
       $this->attributes['fecha_nacimiento'] = ModelHelper::getFechaFormateadaDT($value);
    }
    
    
}
