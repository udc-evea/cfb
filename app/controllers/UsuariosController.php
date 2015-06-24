<?php

class UsuariosController extends BaseController {

	/**
	 * Usuarios Repository
	 *
	 * @var Usuario
	 */
	protected $usuario;

	public function __construct(Usuario $usuario)
	{
		$this->usuario = $usuario;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
                //agegado por nico
                $userId = Auth::user()->id;
                $user = Auth::user()->username;
                $userPerfil = Auth::user()->perfil;
                $userName = Auth::user()->nombreyapellido;
		$usuarios = $this->usuario->all();
                
                if($userPerfil != 'Administrador'){
                    return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
                }else{
                    return View::make('usuarios.index', compact('usuarios'))->with('perfil',$userPerfil)->with('user',$user);
                }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            if(Auth::user()->perfil == 'Administrador'){
		return View::make('usuarios.create');
            }else{
                return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
            }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
                
		$validation = Validator::make($input, Usuario::$rules);
                                
		if ($validation->passes())
		{
                    //creo un array de las claves a insertar
                    $claves = array('nombreyapellido','username','password','perfil');
                    //creo un array de los datos enviados por POST
                    $datos = array();
                    //extraigo el campo 'nombreyapellido' del POST
                    array_push($datos, $input['nombreyapellido']);
                    //extraigo el campo 'username' del POST
                    array_push($datos, $input['username']);
                    //extraigo el campo 'password' del POST
                    $pass = Hash::make($input['password']);
                    //le aplico un HASH al password enviado
                    array_push($datos, $pass);
                    //extraigo el campo 'perfil' del POST
                    array_push($datos, $input['perfil']);
                    //combino los dos array para formar uno solo, asociativo.
                    $final = array_combine($claves,$datos);
                    //Envío los datos para que se guarden en la BD
                    $this->usuario->create($final);
                    //redirijo hacia el index de usuarios
                    return Redirect::route('usuarios.index');
		}

		return Redirect::route('usuarios.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'La validación de los datos del Usuario no pasó.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$usuario = $this->usuario->findOrFail($id);

		return View::make('usuarios.show', compact('usuario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            if(Auth::user()->perfil == 'Administrador'){
		$usuario = $this->usuario->find($id);
		if (is_null($usuario))
		{
			return Redirect::route('usuarios.index');
		}
		return View::make('usuarios.edit', compact('usuario'));
            }else{
                return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
            }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Usuario::$rules);

		if ($validation->passes())
		{
                    //busco el usuario en la BD
                    $usuario = $this->usuario->find($id);
                    
                    //creo un array de las claves a insertar
                    $claves = array('nombreyapellido','username','password','perfil');
                    //creo un array de los datos enviados por POST
                    $datos = array();
                    //extraigo el campo 'nombreyapellido' del POST
                    array_push($datos, $input['nombreyapellido']);
                    //extraigo el campo 'username' del POST
                    array_push($datos, $input['username']);
                    //extraigo el campo 'password' del POST
                    $pass = Hash::make($input['password']);
                    //le aplico un HASH al password enviado
                    array_push($datos, $pass);
                    //extraigo el campo 'perfil' del POST
                    array_push($datos, $input['perfil']);
                    //combino los dos array para formar uno solo, asociativo.
                    $final = array_combine($claves,$datos);
                                        
                    //Envío los datos para que se guarden en la BD
                    //$usuario->update($input);
                    $usuario->update($final);
                    //throw new Exception;
                    return Redirect::route('usuarios.index', $id);
		}

		return Redirect::route('usuarios.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'El usuario no se actualizó!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            if(Auth::user()->perfil == 'Administrador'){
		$this->usuario->find($id)->delete();
		return Redirect::route('usuarios.index');
            }else{
                return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
            }
            
	}

}
