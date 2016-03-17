<?php

class OfertasController extends BaseController {

	/**
	 * oferta Repository
	 *
	 * @var oferta
	 */
	protected $oferta;

	public function __construct(Oferta $oferta)
	{
		$this->oferta = $oferta;                
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ofertas  = Oferta::cursos()->get();
                $carreras = Oferta::carreras()->get();
                $eventos  = Oferta::eventos()->get();
                
                foreach ($ofertas as $of) { //agrgado por nico
                    $of->setCerrarOferta();
                }
                foreach ($carreras as $ca) { //agrgado por nico
                    $ca->setCerrarOferta();
                }
                foreach ($eventos as $ev) { //agrgado por nico
                    //$ev->setCerrarOferta();
                    $ev->setCerrarEvento();
                }
                
                //agegado por nico
                $userId = Auth::user()->id;
                $userPerfil = Auth::user()->perfil;
                $userName = Auth::user()->nombreyapellido;
                                                                           
                $preinscCarr = DB::table('inscripcion_carrera')->count();                
                $inscCarr = DB::table('inscripcion_carrera')->where('estado_inscripcion','=',1)->count();
                $preinscOfe = DB::table('inscripcion_oferta')->count();
                $inscOfe = DB::table('inscripcion_oferta')->where('estado_inscripcion','=',1)->count();
                $preinscEve = DB::table('inscripcion_evento')->count();
                $inscEve = DB::table('inscripcion_evento')->where('estado_inscripcion','=',1)->count();
                
                /*
                
                Carreras
                SELECT oferta_formativa.id, oferta_formativa.nombre, count(inscripcion_carrera.id), oferta_formativa.anio from oferta_formativa 
                inner JOIN inscripcion_carrera ON oferta_formativa.id = inscripcion_carrera.oferta_formativa_id
                where tipo_oferta = 1
                group by oferta_formativa.id
                
                Ofertas
                SELECT oferta_formativa.id, oferta_formativa.nombre, count(inscripcion_oferta.id), oferta_formativa.anio from oferta_formativa 
                inner JOIN inscripcion_oferta ON oferta_formativa.id = inscripcion_oferta.oferta_formativa_id
                where tipo_oferta = 2
                group by oferta_formativa.id
                
                Eventos
                SELECT oferta_formativa.id, oferta_formativa.nombre, count(inscripcion_evento.id), oferta_formativa.anio from oferta_formativa 
                inner JOIN inscripcion_evento ON oferta_formativa.id = inscripcion_evento.oferta_formativa_id
                where tipo_oferta = 3
                group by oferta_formativa.id
                
                 */
                //obtengo el ID, Nombre, Año y cantidad de Preinscriptos de todas las carreras
                $Carreras = DB::table('oferta_formativa')
                        ->select(DB::raw("count(inscripcion_carrera.id) as total"))
                        ->join('inscripcion_carrera','oferta_formativa.id','=','inscripcion_carrera.oferta_formativa_id')
                        ->addselect('oferta_formativa.id', 'oferta_formativa.nombre', 'oferta_formativa.anio')
                        ->where('tipo_oferta','=','1')
                        ->groupBy('oferta_formativa.id')
                        ->orderBy('oferta_formativa.anio','desc')
                        ->get();
                
                $totalPreinscr = array(
                    'carreras' => $preinscCarr, 
                    'eventos' => $preinscEve,
                    'ofertas' => $preinscOfe);
                $totalInscr = array(
                    'carreras' => $inscCarr, 
                    'eventos' => $inscEve,
                    'ofertas' => $inscOfe);
                
                $preUDC = $preinscCarr + $preinscEve + $preinscOfe;
                $insUDC = $inscCarr + $inscEve + $inscOfe;
                                
		return View::make('ofertas.index', compact('ofertas', 'carreras', 'eventos'))
                        ->with('userId',$userId)
                        ->with('userPerfil',$userPerfil)
                        ->with('userName',$userName)
                        ->with("TotalPreinscriptos",$totalPreinscr)
                        ->with("TotalInscriptos",$totalInscr)
                        ->with("preUDC",$preUDC)
                        ->with("insUDC",$insUDC)
                        ->with("Carreras",$Carreras)
                ;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipos_oferta = TipoOferta::orderBy('descripcion')->get();
                $titulaciones = Titulacion::orderBy('id')->get();
                if(!Session::get('errors')) {
                    Session::set('tab_activa', Input::get('tab_activa', 'ofertas'));
                }

		return View::make('ofertas.create')
                        ->with(compact('tipos_oferta'))
                        ->with('titulaciones',$titulaciones);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->oferta->agregarReglas($input);

		$validation = Validator::make($input, Oferta::$rules);

		if ($validation->passes())
		{                                        
                    $this->oferta = $this->oferta->create($input);

                    Session::set('tab_activa', $this->oferta->tab);
                    
                    //agregado por nico
                    //Busco el usuario actual en la BD y obtengo el ID
                    $userId = Auth::user()->id;
                    //agrego el ID del usuario en el campo user_id_creador de la oferta
                    $this->oferta->user_id_creador = $userId;
                    //agrego los datos de la modificación
                    $this->oferta->user_id_modif = $userId;
                    $this->oferta->fecha_modif = date('Y-m-d');
                    //guardo los cambios antes de redirigir
                    $this->oferta->save();

                    return Redirect::route('ofertas.index');
		}

		return Redirect::route('ofertas.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Error al guardar.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Redirect::action('ofertasInscripcionesController@create', $id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$oferta = $this->oferta->find($id);
                
		if (is_null($oferta))
		{
			return Redirect::route('ofertas.index');
		}
                
                Session::set('tab_activa', $oferta->tab);
                                                
		$tipos_oferta = TipoOferta::all();
                $titulaciones = Titulacion::orderBy('id')->get();
		return View::make('ofertas.edit', compact('oferta', 'tipos_oferta'))
                    ->with('titulaciones',$titulaciones);
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
                $this->oferta->agregarReglas($input);
                
		$validation = Validator::make($input, Oferta::$rules);

		if ($validation->passes())
		{
			$oferta = $this->oferta->find($id);
                        $oferta->fill($input);
                        //agregado por nico
                        //Busco el usuario actual en la BD y obtengo el ID
                        $userId = Auth::user()->id;                
                        //agrego los datos de la modificación
                        $oferta->user_id_modif = $userId;
                        $oferta->fecha_modif = date('Y-m-d');
                        //guardo los cambios                        
			$oferta->save();
                        
                        Session::set('tab_activa', $oferta->tab);
			
                        return Redirect::route('ofertas.index');
		}

		return Redirect::route('ofertas.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$oferta = $this->oferta->find($id);
                
                if(!$oferta) {
                    return Redirect::route('ofertas.index')
                        ->with('message', 'No se pudo encontrar la oferta especificada');
                }
                
                Session::set('tab_activa', $oferta->tab);
                
                $oferta->delete();
                
		return Redirect::route('ofertas.index')
                        ->with('message', 'Se eliminó el registro correctamente.');
	}

	/**
	 * Muestra el correo a enviar.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function verMail($id)
	{
		$oferta = $this->oferta->find($id);

		if (is_null($oferta)) {
			return Redirect::route('ofertas.index');
		}

		return View::make($oferta->getVistaMail(), compact('oferta'));
	}                
}
