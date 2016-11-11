<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Personal extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'personal';
        public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        
    public static $rules = array(
        'apellido' => 'required|between:2,30|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'nombre' => 'required|between:2,30|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'dni' => 'required|integer|between:1000000,99999999',
        'email' => 'required|between:2,200',
        'titulacion_id' => 'required|exists:titulacion,id'
    );
        
    protected $fillable = array('apellido','nombre','dni','email','titulacion_id');

    public function getApellido() {
        return $this->apellido;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getApellidoYNombre() {
        return $this->apellido.', '.$this->nombre;
    }
    
    public function getTitulacionPersonal() {
        $tit_completa = Titulacion::find($this->titulacion_id);
        return $tit_completa['nombre_titulacion'];
    }
    
    public function getTitulacionPersonalAbreviada() {
        $tit_completa = Titulacion::find($this->titulacion_id);
        return $tit_completa['abreviatura_titulacion'];
    }
}
