<?php

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use \Carbon\Carbon as Carbon;

class Oferta extends Eloquent implements StaplerableInterface {

    use EloquentTrait;

    const RES_FECHA_TODAVIA_NO_EMPEZO = -1;
    const RES_FECHA_YA_TERMINO = 1;
    const RES_FECHA_EN_CURSO = 0;
    const TIPO_CARRERA = 1;
    const TIPO_CURSO = 2;
    const TIPO_EVENTO = 3;

    protected $guarded = array();
    
    protected $table = 'oferta_formativa';
    protected $dates = array('inicio', 'fin');
    public $timestamps = false;
    public static $rules = array(
        'nombre' => 'required|between:2,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ\.]+$/',
        'anio' => 'required|integer',
        'inicio' => 'date_format:d/m/Y',
        'fin' => 'date_format:d/m/Y',
        'cupo_maximo' => 'integer|min:0',
        'tipo_oferta' => 'required|exists:tipo_oferta_formativa,id',
    );

    public function __construct($attributes = array()) {
        $this->hasAttachedFile('mail_bienvenida');
        
        Oferta::creating(function($model) {
            $model->chequearDisponibilidad();           //revisa siempre
        });

        Oferta::updating(function($model) {
            if($model->haCambiadoValor('inicio') || $model->haCambiadoValor('fin')) {
                $model->chequearDisponibilidad();   //solo revisa al modificar las fechas
            }
        });

        parent::__construct($attributes);
    }
    
    public function getInscripcionModelClassAttribute() {
        if ($this->esCarrera) {
            return 'InscripcionCarrera';
        } elseif($this->esOferta) {
            return 'Inscripcion';
        } elseif($this->esEvento) {
            return 'InscripcionEvento';
        }
    }

    public function getInscripcionModelAttribute() {
        
        return new $this->inscripcionModelClass;
    }

    public function inscripciones() {
        if ($this->esCarrera) {
            return $this
                            ->hasMany('InscripcionCarrera', 'oferta_formativa_id')
                            ->with('localidad')
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        } elseif($this->esOferta) {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            ->orderBy('apellido')
                            ->orderBy('nombre');
            
        } elseif($this->esEvento) {
            return $this
                            ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                            ->with('localidad', 'rel_como_te_enteraste')
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        }
    }
    
    // agregado por nico - devuelve los inscriptos de cada oferta
    public function preinscriptosOferta() {
        if ($this->esCarrera) {
            return $this
                            ->hasMany('InscripcionCarrera', 'oferta_formativa_id')
                            ->with('localidad')
                            ->where('estado_inscripcion','LIKE',0)
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        } elseif($this->esOferta) {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            ->where('estado_inscripcion','LIKE',0)
                            ->orderBy('apellido')
                            ->orderBy('nombre');
            
        } elseif($this->esEvento) {
            return $this
                            ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                            ->with('localidad', 'rel_como_te_enteraste')
                            ->where('estado_inscripcion','LIKE',0)
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        }
    }
    
    // agregado por nico - devuelve los inscriptos de cada oferta
    public function inscriptosOferta() {
        if ($this->esCarrera) {
            return $this
                            ->hasMany('InscripcionCarrera', 'oferta_formativa_id')
                            ->with('localidad')
                            ->where('estado_inscripcion','LIKE',1)
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        } elseif($this->esOferta) {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            ->where('estado_inscripcion','LIKE',1)
                            ->orderBy('apellido')
                            ->orderBy('nombre');
            
        } elseif($this->esEvento) {
            return $this
                            ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                            ->with('localidad', 'rel_como_te_enteraste')
                            ->where('estado_inscripcion','LIKE',1)
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        }
    }

    public function getViewAttribute() {
        if ($this->esCarrera) {
            return 'carreras';
        } elseif($this->esOferta) {
            return 'ofertas';
        } elseif($this->esEvento) {
            return 'eventos';
        }
    }
    
    public function getTabAttribute() {
        return $this->view;
    }

    public function getEsCarreraAttribute() {
        return $this->tipo_oferta == self::TIPO_CARRERA;
    }

    public function getEsOfertaAttribute() {
        return $this->tipo_oferta == self::TIPO_CURSO;
    }
    
    public function getEsEventoAttribute() {
        return $this->tipo_oferta == self::TIPO_EVENTO;
    }

    public function scopeCursos($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_CURSO)
                        ->orderBy('anio', 'desc')
                        ->orderBy('nombre');
    }

    public function scopeCarreras($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_CARRERA)
                        ->orderBy('anio', 'desc')
                        ->orderBy('nombre');
    }
    
    public function scopeEventos($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_EVENTO)
                        ->orderBy('anio', 'desc')
                        ->orderBy('nombre');
    }

    public function requisitos() {
        return $this->hasMany('Requisito', 'oferta_id');
    }

    public function tipo_oferta_formativa() {
        return $this->belongsTo('TipoOferta', 'tipo_oferta');
    }

    public function getInscriptosAttribute() {
        return $this->inscripciones->count();
    }

    public function getInicioAttribute($fecha) {
        return Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setInicioAttribute($fecha) {
        $this->attributes['inicio'] = ModelHelper::getFechaISO($fecha);
    }

    public function getFinAttribute($fecha) {
        return Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFinAttribute($fecha) {
        $this->attributes['fin'] = ModelHelper::getFechaISO($fecha);
    }

    public function getPermiteInscripcionesAttribute() {
        return ModelHelper::trueOrNull($this->attributes['permite_inscripciones']);
    }        

    public function chequearDisponibilidad() 
    {
        if($this->haCambiadoValor('permite_inscripciones'))  return; //forzado, no chequeo nada.
                                
            if ($this->cupoSuficiente() && $this->fechasEnTermino()) {
                $this->permite_inscripciones = true;
            } elseif (($this->cupoExcedido() || $this->fechasFueraDeTermino())) {
                $this->permite_inscripciones = false;
            }                    
    }

    public function cupoExcedido() {
        return !$this->cupoSuficiente();
    }

    public function cupoSuficiente() {
        $cupo = (int) $this->cupo_maximo;

        if ($cupo === 0) {
            return true;
        } else {
            return $this->inscripciones->count() < $cupo;
        }
    }

    public function fechasEnTermino() {
        //return in_array($this->chequearFechas(), [self::RES_FECHA_EN_CURSO, self::RES_FECHA_TODAVIA_NO_EMPEZO]); //linea original
        return in_array($this->chequearFechas(), [self::RES_FECHA_EN_CURSO]);
    }

    public function fechasFueraDeTermino() {
        return !$this->fechasEnTermino();
    }

    public function chequearFechas() {
        $f1 = $this->inferirFormatoFecha($this->inicio);
        $fi = Carbon::createFromFormat($f1, $this->inicio);

        $f2 = $this->inferirFormatoFecha($this->fin);
        $ff = Carbon::createFromFormat($f2, $this->fin);
        $hoy = new Carbon();

        if ($hoy < $fi) {
            return self::RES_FECHA_TODAVIA_NO_EMPEZO;
        } elseif ($ff < $hoy) {
            return self::RES_FECHA_YA_TERMINO;
        } else {
            return self::RES_FECHA_EN_CURSO;
        }
    }
    
    public function haCambiadoValor($attr) {
        return array_key_exists($attr, $this->getDirty());
    }

    public function getVistaMail() {
        return empty($this->mail_bienvenida_file_name) ? 'emails.ofertas.bienvenida_generico' : 'emails.ofertas.bienvenida_oferta';
    }

    public function agregarReglas($input) {
        //fecha de inicio menor a fecha de fin
        self::$rules['inicio'].='|before:' . $input['fin'];
    }

    public function inferirFormatoFecha($fecha) {
        if (strpos($fecha, '/') !== FALSE) {
            return 'd/m/Y';
        } elseif (strpos($fecha, '-') !== FALSE) {
            return 'Y-m-d';
        }
    }
    
    //agrego el primer campo: Tiene_que_presentar_mas_documentacion?
    public function getPresentarMasDocAttribute() {
        return ModelHelper::trueOrNull($this->attributes['presentar_mas_doc']);
    }        
    
    //Cambio estado de la inscripcion de "abierta" a "cerrada"
    public function setCerrarOferta() {
                
        if($this->fechasEnTermino() && $this->cupoSuficiente()){
            $this->permite_inscripciones = TRUE;
        }else{
            $this->permite_inscripciones = FALSE;
        }
        //guardo los cambios
        $this->save();
    }
    
    public function Creador(){
        return $this->belongsTo('User', 'user_id_creador');
    }
}
