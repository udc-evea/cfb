<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Sexo extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sexo';        

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        
    public static $rules = array(
        'id' => 'required|integer',
        'desripcion' => 'required|between:2,50|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/'
    );
        
    protected $fillable = array('id','descripcion');

    public function getSexoDescripcion() {
        return $this->descripcion;
    }
    
    public function setSexo($sexo) {
        return $this->descripcion = $sexo;
    }
    
    
}
