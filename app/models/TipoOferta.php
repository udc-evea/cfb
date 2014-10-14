<?php

class TipoOferta extends Eloquent 
{
    protected $guarded = array();
    protected $table = 'tipo_oferta_formativa';

	public static $rules = array();

	public function __toString()
	{
		return $this->descripcion;
	}
}
