<?php

class InscripcionCarrera extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_carrera';
    protected $dates = array('fecha_nacimiento');
    public $timestamps = false;

    public static $rules = array(
        'oferta_formativa_id'   => array('required', 'exists:oferta_formativa,id', 'unique_persona' => 'unique_with:inscripcion_carrera,tipo_documento_cod,documento'),
        'tipo_documento_cod' => 'required|exists:repo_tipo_documento,id',
        'documento' => 'required|integer|min:1000000|max:99999999',
        'apellido' => 'required',
        'nombre' => 'required',
        'sexo'   => 'required|in:M,F',
        'fecha_nacimiento' => 'required|date_format:d/m/Y',
        'nacionalidad_id'  => 'required|exists:nacionalidad,id',
        'localidad_id' => 'required|exists:repo_localidad,id',
        'localidad_depto' => 'required',
        'localidad_pcia_id'  => 'required|exists:repo_provincia,id',
        'localidad_pais_id'  => 'required|exists:repo_pais,id',
        'telefono_fijo'   => 'required',
        'telefono_celular'   => 'required',
        'email'             => ['required', 'email', 'unique_mail' => 'unique_with:inscripcion_carrera,oferta_formativa_id,email'],
        
        'domicilio_procedencia_tipo'  => 'required|in:CASA,DEPTO,PENSION,RESIDENCIA',
        'domicilio_procedencia_calle' => 'required',
        'domicilio_procedencia_nro'   => 'required',
        'domicilio_procedencia_localidad_id' => 'required|exists:repo_localidad,id',
        'domicilio_procedencia_pcia_id'  => 'required|exists:repo_provincia,id',
        'domicilio_procedencia_cp'   => 'required',
        'domicilio_procedencia_pais_id'   => 'required|exists:repo_pais,id',
        
        'domicilio_clases_tipo'  => 'required|in:CASA,DEPTO,PENSION,RESIDENCIA',
        'domicilio_clases_calle' => 'required',
        'domicilio_clases_nro'   => 'required',
        'domicilio_clases_localidad_id' => 'required|exists:repo_localidad,id',
        'domicilio_clases_pcia_id'  => 'required|exists:repo_provincia,id',
        'domicilio_clases_cp'   => 'required',
        'domicilio_clases_pais_id'   => 'required|exists:repo_pais,id',
        'domicilio_clases_con_quien_vive_id'   => 'required|exists:con_quien_vive,id',
        
        'secundario_titulo_obtenido' => 'required',
        'secundario_anio_egreso' => 'required|digits:4',
        'secundario_nombre_colegio' => 'required',
        'secundario_localidad_id' => 'required|exists:repo_localidad,id',
        'secundario_pcia_id'  => 'required|exists:repo_provincia,id',
        'secundario_pais_id'  => 'required|exists:repo_pais,id',
        'secundario_tipo_establecimiento' => 'required|in:ESTATAL,PRIVADO',
        
        'situacion_laboral' => 'required|in:TRABAJA,NO TRABAJA,DESOCUPADO',
        'situacion_laboral_ocupacion' => 'required|in:TEMPORAL,PERMANENTE',
        'situacion_laboral_relacion_trabajo_carrera' => 'required|in:TOTAL,PARCIAL,NINGUNA',
        'situacion_laboral_categoria_ocupacional_id' => 'required|exists:categoria_ocupacional,id',
        'situacion_laboral_detalle_labor' => 'required',
        'situacion_laboral_horas_semana' => 'required|in:MENOS DE 20,ENTRE 21 Y 35,36 O MAS',
        'situacion_laboral_rama_id' => 'required|exists:rama_actividad_laboral,id',
        
        'padre_apeynom' => 'required',
        'padre_vive' => 'required|in:SI,NO,NS/NC',
        'padre_estudios_id' => 'required|exists:repo_nivel_estudios,id',
        'padre_categoria_ocupacional_id' => 'required|exists:categoria_ocupacional,id',
        'padre_labor' => 'required',
        'padre_ocupacion' => 'required|in:PERMANENTE,TEMPORARIA',
        
        'madre_apeynom' => 'required',
        'madre_vive' => 'required|in:SI,NO,NS/NC',
        'madre_estudios_id' => 'required|exists:repo_nivel_estudios,id',
        'madre_categoria_ocupacional_id' => 'required|exists:categoria_ocupacional,id',
        'madre_labor' => 'required',
        'madre_ocupacion' => 'required|in:PERMANENTE,TEMPORARIA'
        
    );
    
    public static $enum_tipo_residencia      = array('CASA' => 'Casa', 'DEPTO' => 'Depto.', 'PENSION' => 'Pensión', 'RESIDENCIA' => 'Residencia');
    public static $enum_tipo_establecimiento = array('ESTATAL' => 'Estatal', 'PRIVADO' => 'Privado');
    public static $enum_situacion_laboral    = array('TRABAJA' => 'Trabaja', 'NO TRABAJA' => 'No trabaja', 'DESOCUPADO' => 'Desocupado');
    public static $enum_situacion_laboral_ocupacion  = array('TEMPORAL' => 'Trabajo temporal', 'PERMANENTE' => 'Trabajo permanente');
    public static $enum_situacion_laboral_horas_semana = array('MENOS DE 20' => 'Menos de 20', 'ENTRE 21 Y 35' => 'Entre 21 y 35', '36 O MAS' => '36 o más');
    public static $enum_situacion_laboral_relacion_trabajo_carrera = array('TOTAL' => 'Total', 'PARCIAL' => 'Parcial', 'NINGUNA' => 'Ninguna');
    public static $enum_vive = array('SI' => 'SI', 'NO' => 'NO', 'NS/NC' => 'NS/NC');
    public static $enum_padre_ocupacion  = array('TEMPORARIA' => 'Temporaria', 'PERMANENTE' => 'Permanente');
    
    public static $rules_virtual = ['recaptcha_challenge_field', 'recaptcha_response_field', 'reglamento', 'domicilio_clases_igual'];
    public static $mensajes = [];
    
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
    
    public function agregarReglas($input)
    {
        //parche para validators de unique y unique_with
        self::$rules['oferta_formativa_id']['unique_persona'] = sprintf("%s, %s", self::$rules['oferta_formativa_id']['unique_persona'], $this->id);
        self::$rules['email']['unique_mail'] = sprintf("%s, %s", self::$rules['email']['unique_mail'], $this->id);
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
