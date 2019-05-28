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
    protected $dates = array('inicio', 'fin', 'fecha_inicio_oferta', 'fecha_fin_oferta');
    public $timestamps = false;
    public static $rules = array(
        'nombre' => 'required|between:2,200',//|regex:/^[0-9+\(\)#\.\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ\/ext-]+$/', //regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ\.]+$/',
        'anio' => 'required|integer',
        'inicio' => 'required|date_format:d/m/Y',
        'fin' => 'required|date_format:d/m/Y',
        'cupo_maximo' => 'required|integer|min:0',
        'tipo_oferta' => 'required|exists:tipo_oferta_formativa,id',
        'presentar_mas_doc' => 'integer',
        'doc_a_presentar' => 'between:2,2000',
        'url_imagen_mail' => 'between:2,100',
        'fecha_modif' => 'date_format:d/m/Y',
        'resolucion_nro' => 'between:2,255|regex:/^[0-9+\(\)#\.\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ\/ext-]+$/',//'required|integer|min:0',
        'fecha_inicio_oferta' => 'required|date_format:d/m/Y',
        'fecha_fin_oferta' => 'required|date_format:d/m/Y',
        'fecha_expedicion_cert' => 'required|date_format:d/m/Y',
        'lugar' => 'between:2,100',
        'duracion_hs' => 'required', //'required|integer|min:0',
        'lleva_tit_previa' => 'integer',
        'titulacion_id' => 'required|exists:titulacion,id',
        'condicion_en_certificado' => 'required|between:10,100|regex:/^[0-9+\(\)#\.\,\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ\/ext-]+$/',
        'certificado_alumno_digital' => 'integer',
        'certificado_capacitador_digital' => 'integer'
    );

    public function __construct($attributes = array()) {
        $this->hasAttachedFile('mail_bienvenida');
        $this->hasAttachedFile('cert_base_alum');
        $this->hasAttachedFile('cert_base_cap');
        
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
                            //->orderBy('apellido')
                            ->orderBy('id');//->orderBy('nombre');
        } elseif($this->esOferta) {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            //->orderBy('apellido')
                            ->orderBy('id');//->orderBy('nombre');
            
        } elseif($this->esEvento) {
            return $this
                            ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                            ->with('localidad', 'rel_como_te_enteraste')
                            //->orderBy('apellido')
                            //->orderBy('nombre');
                            ->orderBy('id');
        }
    }
        
    // agregado por nico - devuelve los preinscriptos de cada oferta
    public function preinscriptosOferta() {
        if ($this->esCarrera) {
            return $this
                            ->hasMany('InscripcionCarrera', 'oferta_formativa_id')
                            ->with('localidad')
                            //->where('estado_inscripcion','LIKE',0)
                            //->orderBy('apellido')
                            //->orderBy('nombre');
                            ->orderBy('id');
        } elseif($this->esOferta) {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            //->where('estado_inscripcion','LIKE',0)
                            //->orderBy('apellido')
                            //->orderBy('nombre');
                            ->orderBy('id');
            
        } elseif($this->esEvento) {
            return $this
                            ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                            ->with('localidad', 'rel_como_te_enteraste')
                            //->where('estado_inscripcion','LIKE',0)
                            //->orderBy('apellido')
                            //->orderBy('nombre');
                            ->orderBy('id');
        }
    }
    
    // agregado por nico - devuelve los inscriptos de cada oferta
    public function inscriptosOferta() {
        if ($this->esCarrera) {
            return $this
                            ->hasMany('InscripcionCarrera', 'oferta_formativa_id')
                            ->with('localidad')
                            ->where('estado_inscripcion','LIKE',1)
                            //->orderBy('apellido')
                            //->orderBy('nombre')
                            ->orderBy('id');
        } elseif($this->esOferta) {
            return $this
                            ->hasMany('Inscripcion', 'oferta_formativa_id')
                            ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                            ->where('estado_inscripcion','LIKE',1)
                            //->orderBy('apellido')
                            //->orderBy('nombre')
                            ->orderBy('id');
            
        } elseif($this->esEvento) {
            return $this
                            ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                            ->with('localidad', 'rel_como_te_enteraste')
                            ->where('estado_inscripcion','LIKE',1)
                            //->orderBy('apellido')
                            //->orderBy('nombre')
                            ->orderBy('id');
        }
    }
    
    // agregado por nico - devuelve los inscriptos que no tienen comision asignada
    public function inscriptosSinComision() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',0)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');        
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 1
    public function inscriptosComision01() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',1)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 2
    public function inscriptosComision02() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',2)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 3
    public function inscriptosComision03() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',3)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }

    // agregado por nico - devuelve los inscriptos de la comision 4
    public function inscriptosComision04() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',4)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 5
    public function inscriptosComision05() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',5)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 6
    public function inscriptosComision06() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',6)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 7
    public function inscriptosComision07() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',7)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 8
    public function inscriptosComision08() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',8)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 9
    public function inscriptosComision09() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',9)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve los inscriptos de la comision 10
    public function inscriptosComision10() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('comision_nro','LIKE',10)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');            
        }
    }
    
    // agregado por nico - devuelve todos los Aprobados de la Oferta
    public function aprobados() {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('aprobado','LIKE',1)
                    //->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');           
        }
    }
    
    // agregado por nico - devuelve todos los Aprobados de la Oferta
    public function asistentes() {
        if($this->esEvento) {
            return $this
                    ->hasMany('InscripcionEvento', 'oferta_formativa_id')
                    ->with('localidad', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('asistente','LIKE',1)
                    ////->orderBy('apellido')
                    //->orderBy('nombre')
                    ->orderBy('id');
        }
    }
    
    // agregado por nico - devuelve los Datos de un alumno Aprobados de una Oferta
    public function datosAprobado($id_alumno) {
        if($this->esOferta) {
            return $this
                    ->hasMany('Inscripcion', 'oferta_formativa_id')
                    ->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
                    ->where('estado_inscripcion','LIKE',1)
                    ->where('aprobado','LIKE',1)
                    ->where('id','LIKE',$id_alumno)
                ;
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
                        ->orderBy('id');//->orderBy('nombre');
    }

    public function scopeCarreras($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_CARRERA)
                        ->orderBy('anio', 'desc')
                        ->orderBy('id');//->orderBy('nombre');
    }
    
    public function scopeEventos($query) {
        return $query
                        ->where('tipo_oferta', '=', self::TIPO_EVENTO)
                        ->orderBy('anio', 'desc')
                        ->orderBy('id');//->orderBy('nombre');
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
    
    public function getFechaInicioOfertaAttribute($fecha) {
        return Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFechaInicioOfertaAttribute($fecha) {
        $this->attributes['fecha_inicio_oferta'] = ModelHelper::getFechaISO($fecha);
    }
    
    public function getFechaFinOfertaAttribute($fecha) {
        return Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFechaFinOfertaAttribute($fecha) {
        $this->attributes['fecha_fin_oferta'] = ModelHelper::getFechaISO($fecha);
    }
    
    public function getFechaExpedicionCertAttribute($fecha) {
        return Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFechaExpedicionCertAttribute($fecha) {
        $this->attributes['fecha_expedicion_cert'] = ModelHelper::getFechaISO($fecha);
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
        //compruebo si se ha pasado el cupo maximo 
        if(($this->preinscriptosOferta->count() > $this->cupo_maximo)&&($this->cupo_maximo > 0)){
            //si es así, envío mail dónde se aclara la lista de espera
            return 'emails.ofertas.bienvenida_evento_cupo_exedido';
        //Si no se exedió el cupo (Ofertas y Carreras)
        }elseif(empty($this->mail_bienvenida_file_name)){
            //si no se cargo una imagen personalizada, envío el mail genérico
            return 'emails.ofertas.bienvenida_generico';
        }else{
            //y si se cargo imagen del mail, envío la imagen
            return 'emails.ofertas.bienvenida_oferta';
        }
        // linea de abajo es la original (de martin pentucci)
        //return empty($this->mail_bienvenida_file_name) ? 'emails.ofertas.bienvenida_generico' : 'emails.ofertas.bienvenida_oferta';
    }

    public function agregarReglas($input) {
        //fecha de inicio_preinscripciones menor o igual a fecha de fin_preinscripciones
        list($day,$mon,$year) = explode('/',$input['fin']);
        $diaDespuesFinPreinscripciones = date('d/m/Y',mktime(0,0,0,$mon,$day+1,$year));
        self::$rules['inicio'].='|before:' . $diaDespuesFinPreinscripciones;
        
        //si hay fecha_inicio_oferta debe haber fecha_fin_oferta y viceversa        
        if (($input['fecha_inicio_oferta'] != null)||($input['fecha_fin_oferta'] != null)){
            self::$rules['fecha_inicio_oferta'] .= '|required';
            self::$rules['fecha_fin_oferta'] .= '|required';       
        }
        
        //fecha de inicio_oferta menor o igual a fecha de fin_oferta
        if (($input['fecha_inicio_oferta'] != null)&&($input['fecha_fin_oferta'] != null)){
            list($day,$mon,$year) = explode('/',$input['fecha_fin_oferta']);
            $diaDespuesFinOferta = date('d/m/Y',mktime(0,0,0,$mon,$day+1,$year));
            self::$rules['fecha_inicio_oferta'].='|before:' . $diaDespuesFinOferta;
        }
        
        //fecha de inicio_oferta mayor o igual a fecha de fin_preinscripciones
        if ($input['fecha_inicio_oferta'] != null){
            list($day,$mon,$year) = explode('/',$input['fin']);
            $diaAntesFinPreinscripcion = date('d/m/Y',mktime(0,0,0,$mon,$day-1,$year));
            self::$rules['fecha_inicio_oferta'].='|after:' . $diaAntesFinPreinscripcion;
        }
        
        //fecha de fin_preinscripciones menor o igual a fecha de fin_oferta
        //if ($input['fecha_fin_oferta'] != null){
        //    list($day,$mon,$year) = explode('/',$input['fecha_fin_oferta']);
        //    $diaDespuesFinOferta = date('d/m/Y',mktime(0,0,0,$mon,$day+1,$year));
        //    self::$rules['fin'].='|before:' . $diaDespuesFinOferta;
        //}
        
        //fecha_expedicion_cert mayor o igual a fecha de fin_fin_oferta o fecha fin_preinscripciones
        if ($input['fecha_fin_oferta'] != null){
            list($day,$mon,$year) = explode('/',$input['fecha_fin_oferta']);
            $diaAntesFinOferta = date('d/m/Y',mktime(0,0,0,$mon,$day-1,$year));
            self::$rules['fecha_expedicion_cert'].='|after:' . $diaAntesFinOferta;
        }else{
            list($day,$mon,$year) = explode('/',$input['fin']);
            $diaAntesFinPreinscripciones = date('d/m/Y',mktime(0,0,0,$mon,$day-1,$year));
            self::$rules['fecha_expedicion_cert'].='|after:' . $diaAntesFinPreinscripciones;
        }
    }
    
    /*public function agregarReglas2($input) {
        //obtengo el dia posterior al dia de fin de la oferta/evento
        list($day,$mon,$year) = explode('/',$input['fecha_fin_oferta']);
        $diaDespuesFinOferta = date('d/m/Y',mktime(0,0,0,$mon,$day+1,$year));
                
        //fecha de fin de inscripciones menor a fecha_fin_oferta
        //self::$rules['fin'].='|before:' . $input['fecha_inicio_oferta'];
        self::$rules['fin'].='|before:' . $diaDespuesFinOferta;        
    }
    
    public function agregarReglas3($input) {        
        //fecha_inicio_oferta menor a fecha_fin_oferta
        self::$rules['fecha_inicio_oferta'].='|before:' . $input['fecha_fin_oferta'];
    }*/

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
    public function setCerrarCarrera() {
        //$user = Auth::check();
        //if(!$user){
            if($this->fechasEnTermino() && $this->cupoSuficiente()){
                $this->permite_inscripciones = TRUE;
            }else{
                $this->permite_inscripciones = FALSE;
            }
        //}else{
        //    $this->permite_inscripciones = TRUE;
        //}
        //guardo los cambios
        $this->save();
    }
    
    //Cambio estado de la inscripcion de "abierta" a "cerrada" solo para Ofertas y Eventos
    public function setCerrarOfertaOEvento() {
        //$user = Auth::check();
        //if($user){
            if($this->fechasEnTermino()){
                $this->permite_inscripciones = TRUE;
            }else{
                $this->permite_inscripciones = FALSE;
            }
        //}else{
        //    $this->permite_inscripciones = TRUE;
        //}
        //guardo los cambios
        $this->save();
    }
    
    //Comprueba si el usuario actual es el creador de una oferta
    public function Creador(){
        return $this->belongsTo('Usuario', 'user_id_creador');
    }
    
    public function getFechaModifAttribute($fecha) {
        return Carbon::parse($fecha)->format('d/m/Y');
    }
    
    //Usuario que realizo la ultima modificacion a la oferta
    public function UltimaModificacion(){
        return $this->belongsTo('Usuario', 'user_id_modif');
    }
    
    public function stringAleatorio($id, $lenght) {
        $string = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $lenght);
        $string .= '*-AAA'.$id;
        return $string;
    }
    
    public static function obtenerCapacitadoresDeLaOferta($oferta_id) {
        /* funcion que busca en la Base de datos todos los capacitadores de una oferta */
        $aux = DB::table('capacitador')->where('oferta_id','=',$oferta_id)->orderby('rol_id','asc')->get();
        return $aux;
    }
    
    public function estaFinalizada() {
        return ($this->attributes['finalizada'] == 1);
    }
    
    public function getFinalizada() {
        return $this->attributes['finalizada'];
    }    

    public function setFinalizada($valor) {
        return $this->attributes['finalizada'] = $valor;
    }
    
    public function getCertificadoAlumnoDigital(){
        return $this->attributes['certificado_alumno_digital'];
    }
    
    public function setCertificadoAlumnoDigital($valor){
        return $this->attributes['certificado_alumno_digital'] = $valor;
    }
    
    public function getCertificadoCapacitadorDigital(){
        return $this->attributes['certificado_capacitador_digital'];
    }
    
    public function setCertificadoCapacitadorDigital($valor){
        return $this->attributes['certificado_capacitador_digital'] = $valor;
    }
    
    public function enviarCertificadoAlumnoDigital(){
        return $this->attributes['certificado_alumno_digital'] == 1;
    }
    
    public function enviarCertificadoCapacitadorDigital(){
        return $this->attributes['certificado_capacitador_digital'] == 1;
    }
    
}
