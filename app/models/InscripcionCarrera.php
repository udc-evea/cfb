<?php

class InscripcionCarrera extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_carrera';
    protected $dates = array('fecha_nacimiento');
    public $timestamps = false;

    public static $rules = array(
        'oferta_formativa_id'   => array('required', 'exists:oferta_formativa,id', 'unique_persona' => 'unique_with:inscripcion_oferta,tipo_documento_cod,documento'),
        'tipo_documento_cod' => 'required|exists:repo_tipo_documento,tipo_documento',
        'documento' => 'required|integer|min:1000000|max:99999999',
        'apellido' => 'required',
        'nombre' => 'required',
        'fecha_nacimiento' => 'required|date_format:d/m/Y',
        'localidad_id' => 'required|exists:repo_localidad,id',
        
        'localidad_anios_residencia'    => 'required|integer|min:1',
        'nivel_estudios_id' => 'required|exists:repo_nivel_estudios,id',
        
        'email'    => array('required', 'email', 'unique_mail' => 'unique_with:inscripcion_oferta,oferta_formativa_id,email'),
        'telefono'  => 'required',
        'como_te_enteraste' => 'required|exists:inscripcion_como_te_enteraste,id'
    );
    
    public static $enum_tipo_residencia      = array('1' => 'Casa', '2' => 'Depto.', '3' => 'Pensión', '4' => 'Residencia');
    public static $enum_tipo_establecimiento = array('1' => 'Estatal', '2' => 'Privado');
    public static $enum_situacion_laboral    = array('1' => 'Trabaja', '2' => 'No trabaja', '3' => 'Desocupado');
    public static $enum_situacion_laboral_ocupacion  = array('1' => 'Trabajo temporal', '2' => 'Trabajo permanente');
    public static $enum_situacion_laboral_horas_semana = array('1' => 'Menos de 20', '2' => 'Entre 21 y 35', '36 o más');
    public static $enum_situacion_laboral_relacion_trabajo_carrera = array('1' => 'Total', '2' => 'Parcial', '3' => 'Ninguna');
    public static $enum_vive = array('1' => 'SI', '2' => 'NO', '3' => 'NS/NC');
    
    public function oferta()
    {
        return $this->belongsTo('Oferta', 'oferta_formativa_id');
    }
    
    public function requisitospresentados()
    {
        return $this->morphMany('RequisitoPresentado', 'inscripto');
    }
    
    public function tipo_documento()
    {
        return $this->belongsTo('TipoDocumento', 'tipo_documento', 'tipo_documento_cod');
    }
    
    public function localidad()
    {
        return $this->belongsTo('Localidad', 'localidad_id');
    }

    public function nivel_estudios()
    {
        return $this->belongsTo('NivelEstudios', 'nivel_estudios_id');
    }

    public function rel_como_te_enteraste()
    {
        return $this->belongsTo('InscripcionComoTeEnteraste', 'como_te_enteraste');
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
            'fecha_nacimiento'  => $this->fecha_nacimiento,
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

    public function getFechaNacimientoAttribute($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFechaNacimientoAttribute($fecha)
    {
        $this->attributes['fecha_nacimiento'] = ModelHelper::getFechaISO($fecha);
    }
    
    
    public static function boot()
    {
        parent::boot();

        Inscripcion::created(function($inscripcion){
            $inscripcion->oferta->chequearDisponibilidad();
        });

        Inscripcion::updated(function($inscripcion){
            $inscripcion->oferta->chequearDisponibilidad();
        });

        Inscripcion::deleted(function($inscripcion){
            $inscripcion->oferta->chequearDisponibilidad();
        });
    }
}
