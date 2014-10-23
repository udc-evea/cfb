<?php

class RequisitoPresentado extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_requisito_presentado';
    protected $dates = array('fecha_presentacion');
    public $timestamps = false;

    public static $rules = array(
            'fecha_presentacion'   => 'required|date_format:d/m/Y|before:tomorrow'
    );
    
    public function inscripto()
    {
        return $this->morphTo();
    }
    
    public function getFechaPresentacionAttribute($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFechaPresentacionAttribute($fecha)
    {
        $this->attributes['fecha_presentacion'] = ModelHelper::getFechaISO($fecha);
    }
}