<?php

class LocalidadesController extends BaseController {

	/**
	 * Localidad Repository
	 *
	 * @var Localidad
	 */
	protected $Localidad;

	public function __construct(Localidad $Localidad)
	{
		$this->Localidad = $Localidad;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Localidades = $this->Localidad->all();

		return View::make('localidades.index', compact('Localidades'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('localidades.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Localidad::$rules);

		if ($validation->passes())
		{
			$this->Localidad->create($input);

			return Redirect::route('localidades.index');
		}

		return Redirect::route('localidades.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$Localidad = $this->Localidad->findOrFail($id);

		return View::make('localidades.show', compact('Localidad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$Localidad = $this->Localidad->find($id);

		if (is_null($Localidad))
		{
			return Redirect::route('localidades.index');
		}

		return View::make('localidades.edit', compact('Localidad'));
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
		$validation = Validator::make($input, Localidad::$rules);

		if ($validation->passes())
		{
			$Localidad = $this->Localidad->find($id);
			$Localidad->update($input);

			return Redirect::route('localidades.show', $id);
		}

		return Redirect::route('localidades.edit', $id)
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
		$this->Localidad->find($id)->delete();

		return Redirect::route('localidades.index');
	}

}
