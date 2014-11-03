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
    const TIPO_OFERTA = 2;

    protected $guarded = array();
    
    protected $table = 'oferta_formativa';
    protected $dates = array('inicio', 'fin');
    public $timestamps = false;
    public static $rules = array(
        'nombre' => 'required',
        'anio' => 'required|digits:4',
        'inicio' => 'date_format:d/m/Y',
        'fin' => 'date_format:d/m/Y',
        'cupo_maximo' => 'integer|min:0',
        'tipo_oferta' => 'required|exists:tipo_oferta_formativa,id',
    );

    public function __construct($attributes = array()) {
        $this->hasAttachedFile('mail_bienvenida');
        
        Oferta::creating(function($model) {
            $model->chequearDisponibilidad();
        });

        Oferta::updating(function($model) {
            $model->chequearDisponibilidad();
        });

        parent::__construct($attributes);
    }
    
    public function getInscripcionModelClassAttribute() {
        if ($this->esCarrera) {
            return 'InscripcionCarrera';
        } else {
            return 'Inscripcion';
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
        } else {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            ->orderBy('apellido')
                            ->orderBy('nombre');
        }
    }

    public function getViewAttribute() {
        switch ($this->tipo_oferta) {
            case self::TIPO_CARRERA: return 'carreras';
            case self::TIPO_OFERTA: return 'ofertas';
        }
    }

    public function getEsCarreraAttribute() {
        return $this->tipo_oferta == self::TIPO_CARRERA;
    }

    public function getEsOfertaAttribute() {
        return $this->tipo_oferta == self::TIPO_OFERTA;
    }

    public function scopeSinCarreras($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_OFERTA)
                        ->orderBy('anio', 'desc')
                        ->orderBy('nombre');
    }

    public function scopeCarreras($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_CARRERA)
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

    public function chequearDisponibilidad() {
        if ($this->cupoSuficiente() && $this->fechasEnTermino() && !$this->permite_inscripciones) {
            $this->permite_inscripciones = true;
        } elseif (($this->cupoExcedido() || $this->fechasFueraDeTermino()) && $this->permite_inscripciones) {
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
        return in_array($this->chequearFechas(), [self::RES_FECHA_EN_CURSO, self::RES_FECHA_TODAVIA_NO_EMPEZO]);
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
}
