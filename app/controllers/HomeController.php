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
            //controlador para manejar el Sistema de Verificación de Certificados
            $cant_caracteres_cuv = 19;  //16 caracteres + 3 guiones
            
            //obtengo si vine por GET o por POST
            $method = Request::getMethod();
            if($method == 'POST'){
                $input = Input::except(['_token']);
                $mje = "vino por POST!";
                $codGET = $input['codigovalidacion'];
            }else{
                if(Request::has('cuv')){
                    $codGET = Request::get('cuv');
                    if(strlen($codGET) != $cant_caracteres_cuv ){
                        $mje = "El CUV ingresado no tiene los 19 caracteres necesarios.";
                    }
                }else{
                    $codGET = null;
                }            
                if($codGET == null){
                    $mje = "vino por GET pero NOOOOOO tiene el CUV";
                }else{
                    $mje = "vino por GET con el CUV";
                }
            }
            
            return View::make('inicio.verificarCodigo')
                    ->with('mje',$mje)
                    ->with('cuv',$codGET);
        }
}
