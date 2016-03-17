<?php

class TitulacionController extends BaseController {

	/**
	 * Titulacion Repository
	 *
	 * @var Titulacion
	 */
	protected $titulacion;

	public function __construct(Titulacion $titulacion)
	{
		$this->titulacion = $titulacion;
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
		$titulaciones = $this->titulacion->all();
                
                if($userPerfil != 'Administrador'){
                    return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
                }else{
                    return View::make('titulacion.index', compact('titulaciones'))->with('perfil',$userPerfil)->with('user',$user);
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
		return View::make('titulacion.create');
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
                
		$validation = Validator::make($input, Titulacion::$rules);
                                
		if ($validation->passes())
		{                    
                    $this->titulacion->create($input);
                    //redirijo hacia el index de titulacion
                    return Redirect::route('titulacion.index');
		}

		return Redirect::route('titulacion.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'La validación de los datos de la Titulacion no pasó.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$titulacion = $this->titulacion->findOrFail($id);

		return View::make('titulacion.show', compact('titulacion'));
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
		$titulacion = $this->titulacion->find($id);
		if (is_null($titulacion))
		{
			return Redirect::route('titulacion.index');
		}
		return View::make('titulacion.edit', compact('titulacion'));
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
		$validation = Validator::make($input, Titulacion::$rules);

		if ($validation->passes())
		{
                    $tit = $this->titulacion->find($id);
                    
                    //creo un array de las claves a insertar
                    $claves = array('nombre_titulacion','abreviatura_titulacion');
                    //creo un array de los datos enviados por POST
                    $datos = array();
                    //extraigo el campo 'nombre_titulacion' del POST
                    array_push($datos, $input['nombre_titulacion']);
                    //extraigo el campo 'abreviatura_titulacion' del POST
                    array_push($datos, $input['abreviatura_titulacion']);
                    
                    //combino los dos array para formar uno solo, asociativo.
                    $final = array_combine($claves,$datos);
                                        
                    //Envío los datos para que se guarden en la BD
                    //$this->titulacion->update($input);
                    $tit->update($final);
                                                                                
                    return Redirect::route('titulacion.index', $id);
		}

		return Redirect::route('titulacion.edit', $id)
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
		$this->titulacion->find($id)->delete();
		return Redirect::route('titulacion.index');
            }else{
                return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
            }
	}

}
