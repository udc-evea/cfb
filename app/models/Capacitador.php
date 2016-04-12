<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Capacitador extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'capacitador';
        public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        
    public static $rules = array(
        'oferta_id' => 'required|exists:oferta_formativa,id',
        'personal_id' => 'required|exists:personal,id',
        'rol_id' => 'required|exists:rol_capacitador,id'
    );
        
    protected $fillable = array('oferta_id','personal_id','rol_id');
    
    public function ObtenerOferta() {
        return $this->belongsTo('Oferta', 'oferta_id');
    }
    
    public function ObtenerPersonal() {
        return $this->belongsTo('Personal', 'personal_id');
    }

    public function ObtenerRolPersonal() {        
        return $this->belongsTo('RolCapacitador', 'rol_id');
    }
    
    public function ObtenerNomYApeDelPersonal($idPersonal) {
        return DB::table('capacitador')->where('personal_id','=',$idPersonal)->get(array('apellido','nombre'));
    }        
}
