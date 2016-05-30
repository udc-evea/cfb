<?php

class CapacitadorController extends BaseController {

	/**
	 * Capacitador Repository
	 *
	 * @var Capacitador
	 */
	protected $capacitador;

	public function __construct(Capacitador $capacitador)
	{
		$this->capacitador = $capacitador;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
                //agregado por nico
                $userId = Auth::user()->id;
                $user = Auth::user()->username;
                $userPerfil = Auth::user()->perfil;
                $userName = Auth::user()->nombreyapellido;                
		$capacitadores = $this->capacitador->all();
                
                if($userPerfil != 'Administrador'){
                    return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
                }else{
                    return View::make('capacitador.index', compact('capacitadores'))->with('perfil',$userPerfil)->with('user',$user);
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
                $personal = Personal::all();
                $roles = RolCapacitador::all();
                $ofertas = Oferta::all();
		return View::make('capacitador.create')
                        ->with('personal',$personal)
                        ->with('roles',$roles)
                        ->with('ofertas',$ofertas)
                    ;
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
                
		$validation = Validator::make($input, Capacitador::$rules);
                                
		if ($validation->passes())
		{
                    try{
                        $this->capacitador->create($input);
                        //redirijo hacia el index de capacitador
                        return Redirect::route('capacitador.index');
                    }  catch (PDOException $e){
                        return Redirect::route('capacitador.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'No se puede repetir el capacitador en la misma oferta.');
                    }
		}

		return Redirect::route('capacitador.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'La validación de los datos del Capacitador no pasó.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$capacitador = $this->capacitador->findOrFail($id);

		return View::make('capacitador.show', compact('capacitador'));
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
		$capacitador = $this->capacitador->find($id);
                $personal = Personal::all();
                $roles = RolCapacitador::all();
                $ofertas = Oferta::all();
		if (is_null($capacitador))
		{
			return Redirect::route('capacitador.index');
		}
		return View::make('capacitador.edit', compact('capacitador'))
                        ->with('personal',$personal)
                        ->with('ofertas',$ofertas)
                        ->with('roles',$roles)
                    ;
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
		$validation = Validator::make($input, Capacitador::$rules);

		if ($validation->passes())
		{
                    $capacitador = $this->capacitador->find($id);
                    
                    //creo un array de las claves a insertar
                    $claves = array('personal_id','oferta_id','rol_id');
                    //creo un array de los datos enviados por POST
                    $datos = array();
                    //extraigo el campo 'apellido' del POST
                    array_push($datos, $input['personal_id']);
                    //extraigo el campo 'nombre' del POST
                    array_push($datos, $input['oferta_id']);
                    //extraigo el campo 'dni' del POST
                    array_push($datos, $input['rol_id']);                    
                    
                    //combino los dos array para formar uno solo, asociativo.
                    $final = array_combine($claves,$datos);
                     
                    try{
                        //Envío los datos para que se guarden en la BD
                        //$this->capacitador->update($input);
                        $capacitador->update($final);

                        //return Redirect::route('capacitador.index', $id);
                        //envío a Ofertas.index luego de editar un capacitador
                        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                        $final = $this->getEstiloMensajeFinal();
                        return Redirect::route('ofertas.index')->with('message',"$cabecera Los cambios en el capacitador se realizaron correctamente!. $final");
                        
                    }  catch (PDOException $e){
                        return Redirect::route('capacitador.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Error en la Actualización, revisar los valores ingresados.');
                    }
		}

		return Redirect::route('capacitador.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'El Capacitador no se actualizó!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-warning-sign');
            $final = $this->getEstiloMensajeFinal();
            if(Auth::user()->perfil == 'Administrador'){
		$this->capacitador->find($id)->delete();
		//return Redirect::route('capacitador.index');
                return Redirect::route('ofertas.index')
                        ->with('message',"$cabecera Se eliminó correctamente el capacitador.$final");
            }else{
                return Redirect::action('HomeController@bienvenido')
                            ->with('message','No tiene los privilegios sufientes para acceder a esa sección!.');
            }
	}

}
