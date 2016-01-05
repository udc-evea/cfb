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
            $versionDB = "HolaBD";
            return View::make('inicio.inicio')->with('verDB',$versionDB);
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
}
