<?php

class Localidad extends Eloquent {
    const ID_RAWSON = 1;
    const ID_OTRA = 99;
    
    protected $guarded = array();

    protected $table = 'repo_localidad';
    public $timestamps = false;

    public static $rules = array(
            'codigo_provincia' => 'required',
            'localidad' => 'required',
            'codigoPostal' => 'required',
            'codigoTelArea' => 'required',
            'latitud' => 'required',
            'longitud' => 'required'
    );

    public function provincia()
    {
        return $this->belongsTo('Provincia');
    }
    
    public function getLaLocalidadAttribute() 
    {
        if($this->id == static::ID_OTRA)
            return sprintf("Otra (%s)", $this->localidad);
        else
            return $this->localidad;
    }
    
    public function scopeSelect($query, $title = 'Seleccione')
    {
        $selectVals[''] = $title;
        $selectVals += $query->orderBy('localidad')->lists('localidad', 'id');
        return $selectVals;
    }
}
