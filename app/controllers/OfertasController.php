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
                    $ev->setCerrarOferta();
                }
                
		return View::make('ofertas.index', compact('ofertas', 'carreras', 'eventos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipos_oferta = TipoOferta::orderBy('descripcion')->get();
                if(!Session::get('errors')) {
                    Session::set('tab_activa', Input::get('tab_activa', 'ofertas'));
                }

		return View::make('ofertas.create')->with(compact('tipos_oferta'));
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
		return View::make('ofertas.edit', compact('oferta', 'tipos_oferta'));
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
