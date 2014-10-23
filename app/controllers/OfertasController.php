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
		$ofertas  = Oferta::sinCarreras()->get();
                $carreras = Oferta::carreras()->get();

		return View::make('ofertas.index', compact('ofertas', 'carreras'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipos_oferta = TipoOferta::all();

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
			$this->oferta->create($input);

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
			$oferta->update($input);

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
		$this->oferta->find($id)->delete();

		return Redirect::route('ofertas.index')
                        ->with('message', 'Se eliminó el registro correctamente.');;
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
