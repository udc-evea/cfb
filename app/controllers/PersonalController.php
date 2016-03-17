<?php

class PersonalController extends BaseController {

	/**
	 * Personal Repository
	 *
	 * @var Personal
	 */
	protected $personal;

	public function __construct(Personal $personal)
	{
		$this->personal = $personal;
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
		$personal = $this->personal->all();
                
                if($userPerfil != 'Administrador'){
                    return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
                }else{
                    return View::make('personal.index', compact('personal'))->with('perfil',$userPerfil)->with('user',$user);
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
                $titulaciones = Titulacion::all();
		return View::make('personal.create')->with('titulaciones',$titulaciones);
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
                
		$validation = Validator::make($input, Personal::$rules);
                                
		if ($validation->passes())
		{
                    $this->personal->create($input);
                    //redirijo hacia el index de personal
                    return Redirect::route('personal.index');
		}

		return Redirect::route('personal.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'La validación de los datos de la Personal no pasó.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$personal = $this->personal->findOrFail($id);

		return View::make('personal.show', compact('personal'));
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
		$personal = $this->personal->find($id);
                $titulaciones = Titulacion::all();
		if (is_null($personal))
		{
			return Redirect::route('personal.index');
		}
		return View::make('personal.edit', compact('personal'))->with('titulaciones',$titulaciones);
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
                //$input = Input::except(['_method', '_token']);
		$validation = Validator::make($input, Personal::$rules);

		if ($validation->passes())
		{
                    $personal = $this->personal->find($id);
                    
                    //creo un array de las claves a insertar
                    $claves = array('apellido','nombre','documento','email','titulacion_id');
                    //creo un array de los datos enviados por POST
                    $datos = array();
                    //extraigo el campo 'apellido' del POST
                    array_push($datos, $input['apellido']);
                    //extraigo el campo 'nombre' del POST
                    array_push($datos, $input['nombre']);
                    //extraigo el campo 'dni' del POST
                    array_push($datos, $input['dni']);
                    //extraigo el campo 'email' del POST
                    array_push($datos, $input['email']);
                    //extraigo el campo 'titulacion_id' del POST
                    array_push($datos, $input['titulacion_id']);
                    
                    //combino los dos array para formar uno solo, asociativo.
                    $final = array_combine($claves,$datos);
                                        
                    //Envío los datos para que se guarden en la BD
                    //$this->personal->update($input);
                    $personal->update($final);
                                                                                
                    return Redirect::route('personal.index', $id);
		}

		return Redirect::route('personal.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'La Titulación no se actualizó!');
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
		$this->personal->find($id)->delete();
		return Redirect::route('personal.index');
            }else{
                return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
            }
	}

}
