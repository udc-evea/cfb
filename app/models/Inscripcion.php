<?php

class Inscripcion extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_oferta';
    protected $dates = array('fecha_nacimiento');
    public $timestamps = false;

    public static $rules = array(
        'oferta_formativa_id'   => array('required', 'exists:oferta_formativa,id', 'unique_persona' => 'unique_with:inscripcion_oferta,tipo_documento_cod,documento'),
        'tipo_documento_cod' => 'required|exists:repo_tipo_documento,id',
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
    
    public static $rules_virtual = ['recaptcha_challenge_field', 'recaptcha_response_field', 'reglamento'];
    public static $mensajes = ['unique_with' => 'El e-mail ingresado ya corresponde a un inscripto en este oferta.'];
    
    public function oferta()
    {
        return $this->belongsTo('Oferta', 'oferta_formativa_id');
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

    public function requisitospresentados()
    {
        return $this->morphMany('RequisitoPresentado', 'inscripto');
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
    
    public function getCorreoAttribute()
    {
        return $this->email;
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
    
    public function validarNuevo($input)
    {
        if (!Auth::check()) {
            self::$rules['recaptcha_response_field'] = 'required|recaptcha';
            self::$rules['reglamento'] = 'required|boolean';
        }
        
        $v = Validator::make($input, self::$rules, self::$mensajes);
        
        $v->sometimes('como_te_enteraste_otra', 'required', function($input){
            return $input->como_te_enteraste == InscripcionComoTeEnteraste::ID_OTRA;
        });
        
        return $v;
    }

    public function validarExistente($input)
    {
        //parche para validators de unique y unique_with
        self::$rules['oferta_formativa_id']['unique_persona'] = sprintf("%s, %s", self::$rules['oferta_formativa_id']['unique_persona'], $this->id);
        self::$rules['email']['unique_mail'] =  sprintf("%s, %s", self::$rules['email']['unique_mail'], $this->id);
        
        return $this->validarNuevo($input);
    }
        
    
    public static function boot()
    {
        parent::boot();

        Inscripcion::created(function($inscripcion){
            $inscripcion->oferta->save();
        });

        Inscripcion::updated(function($inscripcion){
            $inscripcion->oferta->save();
        });

        Inscripcion::deleted(function($inscripcion){
            $inscripcion->oferta->save();
        });
    }
}
