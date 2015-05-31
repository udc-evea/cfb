<?php

class Inscripcion extends Eloquent {
    protected $guarded = array();

    protected $table = 'inscripcion_oferta';
    protected $dates = array('fecha_nacimiento');
    public $timestamps = false;
    public static $edad_minima = 13;
    public static $edad_maxima = 99;

    public static $rules = array(
        'oferta_formativa_id'   => 'required|exists:oferta_formativa,id',
        'tipo_documento_cod' => 'required|exists:repo_tipo_documento,id',
        'documento' => 'required|integer|between:1000000,99999999|unique_with:inscripcion_oferta,tipo_documento_cod,documento',
        'estado_inscripcion' => 'integer',
        'apellido' => 'required|between:2,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'nombre' => 'required|between:2,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'fecha_nacimiento' => 'required|date_format:d/m/Y',
        'localidad_id' => 'required|exists:repo_localidad,id',        
        'localidad_anios_residencia'    => 'required|integer|min:1',
        'nivel_estudios_id' => 'required|exists:repo_nivel_estudios,id',        
        'email'    => 'required|email|confirmed|unique_with:inscripcion_oferta,oferta_formativa_id,email',
        'email_institucional' => 'between:2,200|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'cant_notificaciones'  => 'integer|min:0',
        'telefono'  => 'required|integer|min:4000000',
        'como_te_enteraste' => 'required|exists:inscripcion_como_te_enteraste,id',
        'como_te_enteraste_otra' => 'between:5,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜ]+$/',
        'comision_nro' => 'integer|min:0'
    );
    
    public static $rules_virtual = ['recaptcha_challenge_field', 'recaptcha_response_field', 'reglamento', 'email_confirmation'];
    public static $mensajes = ['unique_with' => 'Los datos ingresados ya se corresponden con un inscripto en esta oferta.'];
    
    public function oferta()
    {
        return $this->belongsTo('Oferta', 'oferta_formativa_id');
    }
    
    public function tipo_documento()
    {
        return $this->belongsTo('TipoDocumento', 'tipo_documento', 'tipo_documento_cod');
    }
    
    public function localidad()
    {
        return $this->belongsTo('Localidad', 'localidad_id');
    }

    public function nivel_estudios()
    {
        return $this->belongsTo('NivelEstudios', 'nivel_estudios_id');
    }

    public function rel_como_te_enteraste()
    {
        return $this->belongsTo('InscripcionComoTeEnteraste', 'como_te_enteraste');
    }

    public function requisitospresentados()
    {
        return $this->morphMany('RequisitoPresentado', 'inscripto');
    }
    
    public function getColumnasCSV()
    {
        return [ 'documento', 'apellido', 'nombre', 'fecha_nacimiento', 'localidad', 'email', 'telefono' ];
    }
    
    public function toCSV()
    {
        $data = [
            'documento'         => $this->documento,
            'apellido'          => $this->apellido,
            'nombre'            => $this->nombre,
            'fecha_nacimiento'  => $this->fecha_nacimiento,
            'localidad'         => $this->localidad->localidad,
            'email'             => $this->email,
            'telefono'          => $this->telefono
        ];
        
        $ftemp = fopen('php://temp', 'r+');
        fputcsv($ftemp, $data, ',', "'");
        rewind($ftemp);
        $fila = fread($ftemp, 1048576);
        fclose($ftemp);
        
        return $fila;
    }
    
    public function getCorreoAttribute()
    {
        return $this->email;
    }
    
    public function getTipoydocAttribute()
    {
        return sprintf("%s %s", $this->tipo_documento, number_format($this->documento, 0, ",", "."));
    }
    
    public function getInscriptoAttribute()
    {
        return sprintf("%s %s", $this->apellido, $this->nombre);
    }

    public function getFechaNacimientoAttribute($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->format('d/m/Y');
    }

    public function setFechaNacimientoAttribute($fecha)
    {
        $this->attributes['fecha_nacimiento'] = ModelHelper::getFechaISO($fecha);
    }
    
    public function validarNuevo($input)
    {
        if (!Auth::check()) {
            self::$rules['recaptcha_response_field'] = 'required|recaptcha';
            self::$rules['reglamento'] = 'required|boolean';
        }
        
        //los mas viejos
        $dt = new Carbon\Carbon();
        $before = $dt->subYears(self::$edad_minima)->format('d/m/Y');
        self::$rules['fecha_nacimiento'] .= '|before:' . $before;

        //los mas jovenes
        $dt = new Carbon\Carbon();
        $after = $dt->subYears(self::$edad_maxima)->format('d/m/Y');
        self::$rules['fecha_nacimiento'] .= '|after:' . $after;
        
        //valido
        $v = Validator::make($input, self::$rules, self::$mensajes);
        
        //años de residencia < años de fecha de nacimiento
        $iso = ModelHelper::getFechaISO($input['fecha_nacimiento']);
        $fn = new Carbon\Carbon($iso);
        $dt = new Carbon\Carbon();
        
        $anios = $dt->year - $fn->year;
                
        $v->sometimes('localidad_anios_residencia', 'max:'.$anios, function(){
            return true;    //sometimes?
        });

        $v->sometimes('como_te_enteraste_otra', 'required', function($input){
            return $input->como_te_enteraste == InscripcionComoTeEnteraste::ID_OTRA;
        });

        return $v;
    }

    public function validarExistente($input)
    {
        //parche para validators de unique y unique_with
        self::$rules['documento'] = sprintf("%s,%s", self::$rules['documento'], $this->id);
        self::$rules['email'] = sprintf("%s,%s", self::$rules['email'], $this->id);

        return $this->validarNuevo($input);
    }
        
    
    public static function boot()
    {
        parent::boot();

        Inscripcion::created(function($inscripcion){
            $inscripcion->oferta->save();
        });

        Inscripcion::updated(function($inscripcion){
            $inscripcion->oferta->save();
        });

        Inscripcion::deleted(function($inscripcion){
            $inscripcion->oferta->save();
        });
    }
    
    public function getEsInscripto(){
        return ($this->estado_inscripcion == 1);
    }
    
    public function getEstadoInscripcion(){
        return $this->estado_inscripcion;
    }
    
    public function setEstadoInscripcion($valor){
        if ($valor == 0 || $valor == 1){
            $this->attributes['estado_inscripcion'] = $valor;
        }
    }
    
    public function inicialesDeNombres($nombres){
        //defino una variable donde se almacenarán las iniciales de los nombres
        $iniciales = "";        
        //reemplazo todos los caracteres especiales en los nombres
        $nombres = $this->sanear_string($nombres);
        //paso a minuscula los nombres del preinscripto
        $nomMinuscula = strtolower($nombres);
        //$nomMinuscula = $this->sanear_string($nomMinuscula);
        //separo el/los nombre/s del preinscripto
        $nom = explode(" ",$nomMinuscula);
        //defino una variable para recorrer el array de nombres
        $i = 0;
        //obtengo el tamaño del arreglo de nombres
        $cant = count($nom);
        //recorro el arreglo de nombres extrayendo las iniciales
        while ($i <= $cant-1) {
            $iniciales .= substr($nom[$i], 0, 1);
            $i++;
        }        
        //devuelvo solo las iniciales de los nombres del preinscripto
        return $iniciales;
    }
    
    public function apellidosCompletos($apellidos){        
        //paso a minuscula los apellidos del preinscripto
        $apeMinuscula = strtolower($this->sanear_string($apellidos));
        //junto el/los apellidos/s del preinscripto
        $ape = str_replace(' ','',$apeMinuscula);        
        //$ape = preg_replace('[\s+]','', $apeMinuscula);
        //devuelvo solo los apellido de los preinscriptos
        return $ape;
    }
    
    public function crearCorreoInstitucional(){
        //tomo el/los nombre/s del preinscripto
        $nom0 = $this->attributes['nombre'];
        //tomo el/los apellido/s del preinscripto
        $ape0 = $this->attributes['apellido'];
        //defino el dominio que tendrá cada mail creado
        $dominio = "@udc.edu.ar";        
        
        $nom = $this->inicialesDeNombres($nom0);
        //$nom1 = $this->sanear_string($nom);
        
        $ape = $this->apellidosCompletos($ape0);
        //$ape1 = $this->sanear_string($ape);
        
        $correo_institucional = $nom.$ape.$dominio;
        
        $this->attributes['email_institucional'] = $correo_institucional;
        $this->save();
    }
    
    public function vaciarCorreoInstitucional(){        
        $this->attributes['email_institucional'] = "";
        $this->save();
    }
    
    public function getCantNotificaciones(){
        return $this->attributes['cant_notificaciones'];
    }
    
    public function seEnvioNotificacion(){
        $this->attributes['cant_notificaciones']++;
        $this->save();
    }
    
    public function sanear_string($string){
        
        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "`", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                 "."),
            '',
            $string
        );
        return $string;
    }
    
    public function setApellidoAttribute($apellido){
        $this->attributes['apellido'] = ucwords(strtolower($apellido));
    }
    
    public function setNombreAttribute($nombre){
        $this->attributes['nombre'] = ucwords(strtolower($nombre));
    }
    
    public function getComisionNro(){
        return $this->comision_nro;
    }
    
    public function setComisionNro($nro){
        return $this->comision_nro = $nro;
    }
    
    public function sumarComisionNro(){
        return $this->setComisionNro($this->getComisionNro()+1);
    }
    
    public function restarComisionNro(){
        if($this->getComisionNro() > 0){
            return $this->setComisionNro($this->getComisionNro()-1);
        }else{
            return $this->setComisionNro(0);
        }        
    }
    
    public function getRequisitosCompletos(){
        return $this->presento_requisitos;
    }
    
    public function setRequisitosCompletos($estado){
        return $this->presento_requisitos = $estado;
    }
}