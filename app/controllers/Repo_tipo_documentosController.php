<?php

class TipoDocumentosController extends BaseController {

	/**
	 * TipoDocumento Repository
	 *
	 * @var TipoDocumento
	 */
	protected $tipo_documento;

	public function __construct(TipoDocumento $tipo_documento)
	{
		$this->tipo_documento = $tipo_documento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipo_documentos = $this->tipo_documento->all();

		return View::make('tipo_documentos.index', compact('tipo_documentos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tipo_documentos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, TipoDocumento::$rules);

		if ($validation->passes())
		{
			$this->tipo_documento->create($input);

			return Redirect::route('tipo_documentos.index');
		}

		return Redirect::route('tipo_documentos.create')
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
		$tipo_documento = $this->tipo_documento->findOrFail($id);

		return View::make('tipo_documentos.show', compact('tipo_documento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipo_documento = $this->tipo_documento->find($id);

		if (is_null($tipo_documento))
		{
			return Redirect::route('tipo_documentos.index');
		}

		return View::make('tipo_documentos.edit', compact('tipo_documento'));
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
		$validation = Validator::make($input, TipoDocumento::$rules);

		if ($validation->passes())
		{
			$tipo_documento = $this->tipo_documento->find($id);
			$tipo_documento->update($input);

			return Redirect::route('tipo_documentos.show', $id);
		}

		return Redirect::route('tipo_documentos.edit', $id)
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
		$this->tipo_documento->find($id)->delete();

		return Redirect::route('tipo_documentos.index');
	}

}
