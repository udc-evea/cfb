<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
           
       protected $inicio;


       public function showWelcome()
	{
		return View::make('hello');
	}
        
        public function __construct(Inicio $inicio)
	{
		$this->inicio = $inicio;
	}
        
        public function bienvenido()
	{
            $Inicio = Inicio::first();
            $versionDB = $Inicio->getVersionDB();
            $versionCodigo = $Inicio->getVersionCodigo();
            return View::make('inicio.inicio')
                    ->with('verDB',$versionDB)
                    ->with('verCodigo',$versionCodigo)
                ;
	}

        public function salir()
	{		                
            Auth::logout();
            Session::flush();
            
            return Redirect::to('/');
	}
        
        public function login()
	{            
            return View::make('inicio.login');
	}
        
        public function acceso()
	{                        
            $credentials = [
                'username' => Input::get('username'),
                'password' => Input::get('password')
            ];            
            if(Auth::attempt($credentials)){
                return Redirect::to('/');
            }                      
            return View::make('inicio.login')->withErrors($credentials);
	}
        
        public function logout()
	{                            
            return View::make('inicio.inicio');
	}
        
        public function verificarCertificado(){            
            
            //obtengo si vine por GET o por POST
            $method = Request::getMethod();
            //inicializo variables
            $inscripto=null;$oferta=null;$personal=null;$rol=null;$encontrado=false;$tipoOferta='Oferta';
            
            //si viene por post, armo el código completo y verifico
            if($method == 'POST'){
                $input = Input::except(['_token']);
                //junto los códigos ingresados
                $codPOST = $this->armarCodigoDeVerificacion($input['codigovalidacion1'], $input['codigovalidacion2'], $input['codigovalidacion3'], $input['codigovalidacion4']);
                //verifico que el código sea correcto
                if($this->esCodigoValido($codPOST)){
                    //si es correcto, busco en la BD el código
                    $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                    $final = $this->getEstiloMensajeFinal();                    
                    $esInscriptoDeOferta = DB::table('inscripcion_oferta')->where('codigo_verificacion','=',$codPOST)->get();
                    if($esInscriptoDeOferta == null){
                        $esInscriptoDeEvento = DB::table('inscripcion_evento')->where('codigo_verificacion','=',$codPOST)->get();
                        if($esInscriptoDeEvento == null){
                            $esCapacitador = DB::table('capacitador')->where('codigo_verificacion','=',$codPOST)->get();
                            if($esCapacitador == null){
                                $cabecera = $this->getEstiloMensajeCabecera('warning', 'glyphicon glyphicon-warning-sign');
                                $final = $this->getEstiloMensajeFinal();
                                return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado','tipoOferta'))
                                    ->with('message', "$cabecera La sintaxis del código ingresado es correcta, aunque no se encuentra un certificado que coincida! comuniquese con la Universidad del Chubut $final");
                            }else{
                                $encontrado = true;
                                $oferta = DB::table('oferta_formativa')->where('id','=',$esCapacitador[0]->oferta_id)->get();
                                $personal = DB::table('personal')->where('id','=',$esCapacitador[0]->personal_id)->get();
                                $rol = DB::table('rol_capacitador')->where('id','=',$esCapacitador[0]->rol_id)->get();
                                if($oferta[0]->tipo_oferta == 1){
                                    $tipoOferta = 'Carrera';
                                }elseif($oferta[0]->tipo_oferta == 3){
                                    $tipoOferta = 'Evento';
                                }
                                return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado','tipoOferta'))
                                    ->with('message', "$cabecera El código Ingresado es Correcto $final");
                            }
                        }else{
                            $encontrado = true;
                            $oferta = DB::table('oferta_formativa')->where('id','=',$esInscriptoDeEvento[0]->oferta_formativa_id)->get();                  
                            $tipoOferta = 'Evento';
                            return View::make('inicio.verificarCodigo',compact('oferta','personal','rol','encontrado','tipoOferta'))
                                    ->with('inscripto',$esInscriptoDeEvento)
                                    ->with('message', "$cabecera El código Ingresado es Correcto $final");
                        }
                    }else{
                        $encontrado = true;
                        $inscripto = $esInscriptoDeOferta;
                        $oferta = DB::table('oferta_formativa')->where('id','=',$esInscriptoDeOferta[0]->oferta_formativa_id)->get();                     
                        return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado','tipoOferta'))
                                ->with('message', "$cabecera El código Ingresado es Correcto $final");            
                    }
                }else{
                    $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
                    $final = $this->getEstiloMensajeFinal();
                    return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado'))
                          ->with('message', "$cabecera El código ingresado no es correcto. Verifique el código e intente nuevamente!! $final");
                }
            //si viene por GET, me fijo si viene el codigo como parametro
            }else{
                //si vino el codigo, verifico que sea correcto
                if(Request::has('cuv')){
                    $codGET = Request::get('cuv');
                    //verifico que el código sea correcto
                    if($this->esCodigoValido($codGET)){
                        //si es correcto, busco en la BD el código
                        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                        $final = $this->getEstiloMensajeFinal();
                        $esInscriptoDeOferta = DB::table('inscripcion_oferta')->where('codigo_verificacion','=',$codGET)->get();
                        if($esInscriptoDeOferta == null){
                            $esInscriptoDeEvento = DB::table('inscripcion_evento')->where('codigo_verificacion','=',$codGET)->get();
                            if($esInscriptoDeEvento == null){
                                $esCapacitador = DB::table('capacitador')->where('codigo_verificacion','=',$codGET)->get();
                                if($esCapacitador == null){
                                    $cabecera = $this->getEstiloMensajeCabecera('warning', 'glyphicon glyphicon-warning-sign');
                                    $final = $this->getEstiloMensajeFinal();
                                    return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado','tipoOferta'))
                                        ->with('message', "$cabecera Si bien el código ingresado es correcto, no se encuentra un certificado que coincida! comuniquese con la Universidad del Chubut $final");
                                }else{
                                    $encontrado = true;
                                    $oferta = DB::table('oferta_formativa')->where('id','=',$esCapacitador[0]->oferta_id)->get();
                                    $personal = DB::table('personal')->where('id','=',$esCapacitador[0]->personal_id)->get();
                                    $rol = DB::table('rol_capacitador')->where('id','=',$esCapacitador[0]->rol_id)->get();
                                    if($oferta[0]->tipo_oferta == 1){
                                        $tipoOferta = 'Carrera';
                                    }elseif($oferta[0]->tipo_oferta == 3){
                                        $tipoOferta = 'Evento';
                                    }
                                    return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado','tipoOferta'))
                                        ->with('message', "$cabecera El código Ingresado es Correcto $final");
                                }
                            }else{
                                $tipoOferta = 'Evento';
                                $encontrado = true;
                                $oferta = DB::table('oferta_formativa')->where('id','=',$esInscriptoDeEvento[0]->oferta_formativa_id)->get();                    
                                return View::make('inicio.verificarCodigo',compact('oferta','personal','rol','encontrado','tipoOferta'))
                                        ->with('inscripto',$esInscriptoDeEvento)
                                        ->with('message', "$cabecera El código Ingresado es Correcto $final");
                            }
                        }else{
                            $encontrado = true;
                            $oferta = DB::table('oferta_formativa')->where('id','=',$esInscriptoDeOferta[0]->oferta_formativa_id)->get();
                            return View::make('inicio.verificarCodigo',compact('oferta','personal','rol','encontrado','tipoOferta'))
                                    ->with('inscripto',$esInscriptoDeOferta)
                                    ->with('message', "$cabecera El código Ingresado es Correcto $final");            
                        }
                    //si el código no es correcto, muestro mje de error
                    }else{
                        $encontrado = true;
                        $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
                        $final = $this->getEstiloMensajeFinal();
                        return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado'))
                            ->with('message', "$cabecera El código ingresado no es correcto. Verifique el código e intente nuevamente!! $final");
                    }
                //si no vino el código por parametro
                }else{
                    //voy a la pagina de verificacion sin mensajes
                    return View::make('inicio.verificarCodigo',compact('inscripto','oferta','personal','rol','encontrado'))
                        ->with('message', null);
                }
            }                                 
        }
        
        private function armarCodigoDeVerificacion($parte1,$parte2,$parte3,$parte4)
        {            
            return $codigo = $parte1.'-'.$parte2.'-'.$parte3.'-'.$parte4;
        }
        
        private function esCodigoValido($cod)
        {
            $tamanioCodigo = 19;
            
            return ($tamanioCodigo == strlen($cod));
        }
        
        public static function arreglarCaracteres($s1) 
        {
            $s1 = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                array('Á', 'Á', 'A', 'A', 'A', 'Á', 'Á', 'A', 'A'),
                $s1
            );
            $s1 = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                array('É', 'É', 'E', 'E', 'É', 'É', 'E', 'E'),
                $s1
            );
            $s1 = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                array('Í', 'Í', 'I', 'I', 'Í', 'Í', 'I', 'I'),
                $s1
            );

            $s1 = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                array('Ó', 'Ó', 'O', 'O', 'Ó', 'Ó', 'O', 'O'),
                $s1
            );

            $s1 = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                array('Ú', 'Ú', 'U', 'U', 'Ú', 'Ú', 'U', 'U'),
                $s1
            );

            $s1 = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'),
                array('Ñ', 'Ñ', 'c', 'C'),
                $s1
            );

            //Esta parte se encarga de eliminar cualquier caracter extraño
            // quito el apóstrofe para apellidos tipo "D'alessandro" - "'",
            $s1 = str_replace(
                array("\\", "¨", "º", "-", "~",
                     "#", "@", "|", "!", "\"",
                     "·", "$", "%", "&", "/",
                     "(", ")", "?", "¡",
                     "¿", "[", "^", "`", "]",
                     "+", "}", "{", "¨", "´",
                     ">", "< ", ";", ",", ":",
                     "."),
                '',
                $s1
            );
            return $s1;
        }
}
