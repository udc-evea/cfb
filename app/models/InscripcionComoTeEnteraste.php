<?php

class InscripcionComoTeEnteraste extends Eloquent
{
    const ID_OTRA = 99;
    
    protected $guarded = array();
    protected $table = 'inscripcion_como_te_enteraste';

	public static $rules = array();

	public function __toString()
	{
		return $this->descripcion;
	}
}