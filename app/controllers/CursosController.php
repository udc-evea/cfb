<?php

class CursosController extends BaseController {

	/**
	 * Curso Repository
	 *
	 * @var Curso
	 */
	protected $curso;

	public function __construct(Curso $curso)
	{
		$this->curso = $curso;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cursos = $this->curso->all();

		return View::make('cursos.index', compact('cursos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cursos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Curso::$rules);

		if ($validation->passes())
		{
			$this->curso->create($input);

			return Redirect::route('cursos.index');
		}

		return Redirect::route('cursos.create')
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
		return Redirect::action('InscripcionesController@create', $id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$curso = $this->curso->find($id);

		if (is_null($curso))
		{
			return Redirect::route('cursos.index');
		}

		return View::make('cursos.edit', compact('curso'));
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
		$validation = Validator::make($input, Curso::$rules);

		if ($validation->passes())
		{
			$curso = $this->curso->find($id);
			$curso->update($input);

			return Redirect::route('cursos.index');
		}

		return Redirect::route('cursos.edit', $id)
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
		$this->curso->find($id)->delete();

		return Redirect::route('cursos.index')
                        ->with('message', 'Se eliminó el registro correctamente.');;
	}
}
