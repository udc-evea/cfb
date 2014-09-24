<?php

class Requisito extends Eloquent {
    protected $guarded = array();

    protected $table = 'oferta_requisitos';
    public $timestamps = false;

    public static $rules = array(
            'requisito'  => 'required'
    );

    public function curso()
    {
        return $this->belongsTo('Curso', 'oferta_academica_id');
    }
        
    public function getCantRequisitosAttribute()
    {
        return $this->requisitos->count();
    }
        
}