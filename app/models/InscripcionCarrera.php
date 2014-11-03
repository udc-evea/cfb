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
        'telefono_fijo'   => 'required|integer',
        'telefono_celular'   => 'required',
        'email'             => ['required', 'email', 'confirmed', 'unique_mail' => 'unique_with:inscripcion_carrera,oferta_formativa_id,email'],
        'domicilio_procedencia_tipo'  => 'required|in:CASA,DEPTO,PENSION,RESIDENCIA',
        'domicilio_procedencia_calle' => 'required',
        'domicilio_procedencia_nro'   => 'required|integer',
        'domicilio_procedencia_localidad_id' => 'required|exists:repo_localidad,id',
        'domicilio_procedencia_pcia_id'  => 'required|exists:repo_provincia,id',
        'domicilio_procedencia_cp'   => 'required|integer',
        'domicilio_procedencia_pais_id'   => 'required|exists:repo_pais,id',
        
        'domicilio_clases_tipo'  => 'required|in:CASA,DEPTO,PENSION,RESIDENCIA',
        'domicilio_clases_calle' => 'required',
        'domicilio_clases_nro'   => 'required|integer',
        'domicilio_clases_localidad_id' => 'required|exists:repo_localidad,id',
        'domicilio_clases_pcia_id'  => 'required|exists:repo_provincia,id',
        'domicilio_clases_cp'   => 'required|integer',
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
    
    public static $rules_virtual = ['recaptcha_challenge_field', 'recaptcha_response_field', 'reglamento', 'domicilio_clases_igual', 'email_confirmation'];
    public static $mensajes = ['unique_with' => 'El e-mail ingresado ya corresponde a un inscripto en este oferta.'];
    
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
    
    public function localidadDomicilioProcedencia()
    {
        return $this->belongsTo('Localidad', 'domicilio_procedencia_localidad_id');
    }
    
    public function localidadDomicilioClases()
    {
        return $this->belongsTo('Localidad', 'domicilio_clases_localidad_id');
    }
    
    public function localidadEstablecimiento()
    {
        return $this->belongsTo('Localidad', 'secundario_localidad_id');
    }
    
    public function provincia()
    {
        return $this->belongsTo('Provincia', 'localidad_pcia_id');
    }
    
    public function provinciaDomicilioProcedencia()
    {
        return $this->belongsTo('Provincia', 'domicilio_procedencia_pcia_id');
    }
    
    public function provinciaDomicilioClases()
    {
        return $this->belongsTo('Provincia', 'domicilio_clases_pcia_id');
    }
    
    public function provinciaEstablecimiento()
    {
        return $this->belongsTo('Provincia', 'secundario_pcia_id');
    }
    
    public function pais()
    {
        return $this->belongsTo('Pais', 'localidad_pais_id');
    }
    
    public function paisDomicilioProcedencia()
    {
        return $this->belongsTo('Pais', 'domicilio_procedencia_pais_id');
    }
    
    public function paisDomicilioClases()
    {
        return $this->belongsTo('Pais', 'domicilio_clases_pais_id');
    }
    
    public function paisEstablecimiento()
    {
        return $this->belongsTo('Pais', 'secundario_pais_id');
    }
    
    public function getLaLocalidadAttribute()
    {
        return  ($this->localidad_id != Localidad::ID_OTRA) ? $this->localidad->localidad : $this->localidad_otra;
    }
    
    public function getLaLocalidadDomicilioProcedenciaAttribute()
    {
        return  ($this->domicilio_procedencia_localidad_id != Localidad::ID_OTRA) ? $this->localidadDomicilioProcedencia->localidad : $this->domicilio_procedencia_localidad_otra;
    }
    
    public function getLaLocalidadDomicilioClasesAttribute()
    {
        return  ($this->domicilio_clases_localidad_id != Localidad::ID_OTRA) ? $this->localidadDomicilioClases->localidad : $this->domicilio_clases_localidad_otra;
    }
    
    public function getLaLocalidadEstablecimientoAttribute()
    {
        return  ($this->secundario_localidad_id != Localidad::ID_OTRA) ? $this->localidadEstablecimiento->localidad : $this->secundario_localidad_otra;
    }
    
    public function getLaPciaAttribute()
    {
        return  ($this->localidad_pcia_id != Provincia::ID_OTRA) ? $this->provincia->provincia : $this->localidad_pcia_otra;
    }
    
    public function getLaPciaDomicilioProcedenciaAttribute()
    {
        return  ($this->domicilio_procedencia_pcia_id != Provincia::ID_OTRA) ? $this->provinciaDomicilioProcedencia->provincia : $this->domicilio_procedencia_pcia_otra;
    }
    
    public function getLaPciaDomicilioClasesAttribute()
    {
        return  ($this->domicilio_clases_pcia_id != Provincia::ID_OTRA) ? $this->provinciaDomicilioClases->provincia : $this->domicilio_clases_pcia_otra;
    }
    
    public function getLaPciaEstablecimientoAttribute()
    {
        return  ($this->secundario_pcia_id != Provincia::ID_OTRA) ? $this->provinciaEstablecimiento->provincia : $this->secundario_pcia_otra;
    }
    
    public function getElPaisAttribute()
    {
        return  ($this->localidad_pais_id != Pais::ID_OTRO) ? $this->pais->nombre : $this->localidad_pais_otro;
    }
    
    public function getElPaisDomicilioProcedenciaAttribute()
    {
        return  ($this->domicilio_procedencia_pais_id != Pais::ID_OTRO) ? $this->paisDomicilioProcedencia->nombre : $this->domicilio_procedencia_pais_otro;
    }
    
    public function getElPaisDomicilioClasesAttribute()
    {
        return  ($this->domicilio_clases_pais_id != Pais::ID_OTRO) ? $this->paisDomicilioClases->nombre : $this->domicilio_clases_pais_otro;
    }
    
    public function getElPaisEstablecimientoAttribute()
    {
        return  ($this->secundario_pais_id != Pais::ID_OTRO) ? $this->paisEstablecimiento->nombre : $this->secundario_pais_otro;
    }
    
    public function ramaActividad()
    {
        return $this->belongsTo('RamaActividadLaboral', 'situacion_laboral_rama_id');
    }
    
    public function categoriaOcupacional()
    {
        return $this->belongsTo('CategoriaOcupacional', 'situacion_laboral_categoria_ocupacional_id');
    }
    
    public function padreCategoriaOcupacional()
    {
        return $this->belongsTo('CategoriaOcupacional', 'padre_categoria_ocupacional_id');
    }
    
    public function madreCategoriaOcupacional()
    {
        return $this->belongsTo('CategoriaOcupacional', 'madre_categoria_ocupacional_id');
    }
    
    public function padreEstudios()
    {
        return $this->belongsTo('NivelEstudios', 'padre_estudios_id');
    }
    
    public function madreEstudios()
    {
        return $this->belongsTo('NivelEstudios', 'madre_estudios_id');
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
