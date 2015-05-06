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

	public function showWelcome()
	{
		return View::make('hello');
	}
        
        public function bienvenido()
	{		
                //return View::make('inicio.inicio');
                $mje = "Sistema de Inscripciones";
                return View::make('inicio.inicio', array('mje'=>$mje));
	}

        public function salir()
	{		                
            Auth::logout();
            Session::flush();
            
            return View::make('inicio.inicio');
	}
        
        public function loguin()
	{            
            return View::make('inicio.loguin');
	}
        
        public function acceso()
	{                        
            $credentials = [
                'username' => Input::get('username'),
                'password' => Input::get('password')
            ];            
            if(Auth::attempt($credentials)){
                return View::make('inicio.inicio');
            }                      
            return View::make('inicio.loguin');                            
	}
        
        public function logout()
	{                
            $mje = "Sistema de Inscripciones";
            return View::make('inicio.inicio', array('mje'=>$mje));
	}
}
