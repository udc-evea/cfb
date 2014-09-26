<?php

class RequisitoPresentado extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_requisito_presentado';
    public $timestamps = false;

    public static $rules = array(
            'fecha_presentacion'   => 'required|date'
    );
}