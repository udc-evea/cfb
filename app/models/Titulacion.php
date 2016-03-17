<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Titulacion extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'titulacion';
        public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        
    public static $rules = array(
        'nombre_titulacion' => 'required|between:2,50|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'abreviatura_titulacion' => 'required|between:2,10|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/'
    );
        
    protected $fillable = array('nombre_titulacion','abreviatura_titulacion');

}
