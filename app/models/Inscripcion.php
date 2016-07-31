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
        'documento' => 'required|integer|between:1000000,99999999|unique_with:inscripcion_oferta,oferta_formativa_id,tipo_documento_cod,documento',
        'estado_inscripcion' => 'integer',
        'apellido' => 'required|between:2,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'nombre' => 'required|between:2,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'fecha_nacimiento' => 'required|date_format:d/m/Y',
        'localidad_id' => 'required|exists:repo_localidad,id',        
        'localidad_anios_residencia'    => 'required|integer|min:1',
        'nivel_estudios_id' => 'required|exists:repo_nivel_estudios,id',        
        'email'    => 'required|email|unique_with:inscripcion_oferta,oferta_formativa_id,email', //tenia el |confirmed - se lo saque por pedido de guillermo el 20-04-2016
        'email_institucional' => 'between:2,200|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜçÇ]+$/',
        'cant_notificaciones'  => 'integer|min:0',
        'cant_notificaciones_inscripto' => 'integer|min:0',
        'telefono'  => 'required|between:7,50|regex:/^[0-9+\(\)#\.\s\/ext-]+$/', //'required|integer|min:4000000',
        'como_te_enteraste' => 'required|exists:inscripcion_como_te_enteraste,id',
        'como_te_enteraste_otra' => 'between:5,100|regex:/^[\s\'\pLñÑáéíóúÁÉÍÓÚüÜ]+$/',
        'comision_nro' => 'integer|min:0',
        'aprobado' => 'integer'
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
        $nombres2 = $this->sanear_string($nombres);
        //paso a minuscula los nombres del preinscripto
        $nomMinuscula = strtolower($nombres2);
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
    
    public function getCantNotificacionesInscripto(){
        return $this->attributes['cant_notificaciones_inscripto'];
    }
    
    public function seEnvioNotificacionInscripto(){
        $this->attributes['cant_notificaciones_inscripto']++;
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
        // quito el apóstrofe para apellidos tipo "D'alessandro" - "'",
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "¡",
                 "¿", "[", "^", "`", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                 "."),
            '',
            $string
        );
        return $string;
    }
    
    public function sanear_apellidos_y_nombres($string){
        
        //$string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('á', 'á', 'á', 'á', 'á', 'á', 'á', 'á', 'á'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('é', 'é', 'é', 'é', 'é', 'é', 'é', 'é'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('í', 'í', 'í', 'í', 'í', 'í', 'í', 'í'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('ó', 'ó', 'ó', 'ó', 'ó', 'ó', 'ó', 'ó'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('ú', 'ú', 'ü', 'ú', 'ú', 'ú', 'ú', 'ü'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('ñ', 'ñ', 'c', 'C'),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        // quito el apóstrofe para apellidos tipo "D'alessandro" - "'",
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "¡",
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
        $aux = strtolower($apellido);
        $aux = $this->sanear_apellidos_y_nombres($aux);
        $this->attributes['apellido'] = ucwords($aux);
    }
    
    public function setNombreAttribute($nombre){
        $aux = strtolower($nombre);
        $aux = $this->sanear_apellidos_y_nombres($aux);
        $this->attributes['nombre'] = ucwords($aux);        
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
    
    public function getEsAprobado(){
        return ($this->aprobado == 1);
    }
    
    public function getAprobado(){
        return $this->aprobado;
    }
    
    public function setAprobado($valor){
        if ($valor == 0 || $valor == 1){
            $this->attributes['aprobado'] = $valor;
        }
    }
    
    public function getColoresSegunEstados(){
        $bkgcolor = '#F5A9F2'; //alumnos no confirmados = rosado
        $color = 'black';
        if($this->getRequisitosCompletos()){
            $bkgcolor = '#E6E6E6'; //alumnos que presentaron los requisitos = gris_claro
        }else{
            $color = 'red'; //alumnos que NO presentaron requisitos = rojo
        }
        if($this->getEsInscripto()){
            $bkgcolor = '#F7F2E0'; //alumnos confirmados sin requisitos = crema
            if($this->getComisionNro() > 0){
                switch ($this->getComisionNro()){
                    case 1: $bkgcolor="#E0F8F7"; //comision 1 = celeste
                            break;
                    case 2: $bkgcolor="#01DFA5"; //comision 2 = verde_mas_oscuro
                            break;
                    case 3: $bkgcolor="#F7FE2E"; //comision 8 = amarillo_mas_oscuro
                            break;
                    case 4: $bkgcolor="#F3E2A9"; //comision 4 = marron_claro
                            break;
                    case 5: $bkgcolor="#F2F5A9"; //comision 5 = amarillo_claro
                            break;
                    case 6: $bkgcolor="#A9E2F3"; //comision 6 = celeste_mas_oscuro
                            break;
                    case 7: $bkgcolor="grey"; //comision 7 = verde_mas_oscuro
                            break;
                    case 8: $bkgcolor="#F3E2A9"; //comision 4 = marron_claro
                            break;
                    case 9: $bkgcolor="#DF7401"; //comision 9 = marron_mas_oscuro
                            break;
                    default: $bkgcolor="#A901DB"; //comision 10 = lila_mas_oscuro
                }
            }
        }
        $arreglo = array();
        $arreglo[0] = $color;
        $arreglo[1] = $bkgcolor;
        return $arreglo;
    }
        
    public function getCodigoVerificacion(){
        return $this->codigo_verificacion;
    }
    
    public function setCodigoVerificacion($codigo){
        //gusrdo en la base el código de verificación
        $this->attributes['codigo_verificacion'] = $codigo;
    }
}