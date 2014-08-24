<?php

class InscripcionesController extends BaseController {

	/**
	 * inscripcion Repository
	 *
	 * @var inscripcion
	 */
	protected $inscripcion;

	public function __construct(Curso $curso, Inscripcion $inscripcion)
	{
            $this->curso       = $curso;	
            $this->inscripcion = $inscripcion;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($curso_id)
	{
            $curso = Curso::findOrFail($curso_id);
            $inscripciones = $this->inscripcion->all();
            return View::make('inscripciones.index', compact('inscripciones'))->withCurso($curso);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($curso_id)
	{
            $curso = Curso::findOrFail($curso_id);
            if(!$curso->permite_inscripciones || !$curso->vigente)
            {
                return View::make('inscripciones.cerradas')->withCurso($curso);
            }
            
            return View::make('inscripciones.create')->withCurso($curso);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($curso_id)
	{
		$curso    = Curso::findOrFail($curso_id);
                $input    = Input::all();
                $input_db = Input::except(['recaptcha_challenge_field','recaptcha_response_field']);
                
                $reglas = Inscripcion::$rules;
                
                if(!Auth::check())
                {
                    $reglas['recaptcha_response_field'] = 'required|recaptcha';
                }
		$validation = Validator::make($input, $reglas);

		if ($validation->passes())
		{
			$this->inscripcion->create($input_db);

			return Redirect::to('/inscripcion_ok');
		}

		return Redirect::action('InscripcionesController@create', $curso_id)
			->withCurso($curso)
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
		$inscripcion = $this->inscripcion->findOrFail($id);

		return View::make('inscripciones.show', compact('inscripcion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$inscripcion = $this->inscripcion->find($id);
                
		if (is_null($inscripcion))
		{
			return Redirect::route('inscripciones.index');
		}
                
                $curso = $inscripcion->curso;
		return View::make('inscripciones.edit', compact('inscripcion', 'curso'));
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
		$validation = Validator::make($input, inscripcion::$rules);

		if ($validation->passes())
		{
			$inscripcion = $this->inscripcion->find($id);
			$inscripcion->update($input);

			return Redirect::route('inscripciones.index');
		}

		return Redirect::route('inscripciones.edit', $id)
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
            $this->inscripcion = $this->inscripcion->findOrFail($id);
            $curso = $this->inscripcion->curso;
            
            $this->inscripcion->delete();

            return Redirect::action('InscripcionesController@index', $curso->id)
                    ->withCurso($curso)
                    ->with('message', 'Se eliminó el registro correctamente.');
	}

}
