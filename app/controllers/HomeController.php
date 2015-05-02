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
            $mje = "Sistema de Inscripciones";
            return View::make('inicio.inicio', array('mje'=>$mje));
	}
        
        public function loguin()
	{
            $mje = "Paguina de LOGUIN";
            return View::make('inicio.loguin', array('mje'=>$mje));
	}
        
        public function logout()
	{                
            $mje = "Sistema de Inscripciones";
            return View::make('inicio.inicio', array('mje'=>$mje));
	}
}
