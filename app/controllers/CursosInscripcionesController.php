<?php

class CursosInscripcionesController extends BaseController {

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
            
            $csv = (int)Request::get('csv');
            
            if($csv == 1)
            {
                return $this->exportarCSV("inscriptos_".$curso->nombre.".csv", $inscripciones);
            }
            
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
            $input_db = Input::except(['recaptcha_challenge_field','recaptcha_response_field', 'reglamento']);
            Log::info($input['fecha_nacimiento2']);
            $reglas = Inscripcion::$rules;

            if(!Auth::check())
            {
                $reglas['recaptcha_response_field'] = 'required|recaptcha';
                $reglas['reglamento'] = 'required|boolean';
            }
            $validation = Validator::make($input, $reglas);

            if ($validation->passes())
            {
                    $insc = $this->inscripcion->create($input_db);
                    
                    try {
                        Mail::send('inscripciones.mail_bienvenida', array('inscripcion' => $insc), function($message) use($curso, $insc) {
                            $message
                                    ->to($insc->email, $insc->nombre)
                                    ->subject('CFB-UDC: Inscripción a '.$curso->nombre);
                        });
                    } catch(Swift_TransportException $e) { Log::info("No se pudo enviar correo a ".$insc->nombre. " <".$insc->email.">"); }
                    
                    return Redirect::to('/inscripcion_ok');
            }

            return Redirect::route('cursos.inscripciones.nueva', $curso_id)
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
	public function show($curso_id, $id)
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
	public function edit($curso_id, $id)
	{
		$inscripcion = $this->inscripcion->find($id);
                
		if (is_null($inscripcion))
		{
			return Redirect::route('cursos.inscripciones.index');
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
	public function update($curso_id, $id)
	{
		$input = array_except(Input::all(), '_method');
                $rules = inscripcion::$rules;
                $rules['oferta_academica_id']['unique_persona'] .=', '.$id;
                $rules['oferta_academica_id']['unique_email'] .=', '.$id;
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			$inscripcion = $this->inscripcion->find($id);
			$inscripcion->update($input);

			return Redirect::route('cursos.inscripciones.index', array($curso_id));
		}

		return Redirect::route('cursos.inscripciones.edit', array($curso_id, $id))
			->withInput()
			->withErrors($validation)
			->with('message', 'Ocurrieron errores al guardar.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($curso_id, $id)
	{
            $this->inscripcion = $this->inscripcion->findOrFail($id);
            $curso = $this->inscripcion->curso;
            
            $this->inscripcion->delete();

            return Redirect::route('cursos.inscripciones.index', array($curso->id))
                    ->withCurso($curso)
                    ->with('message', 'Se eliminó el registro correctamente.');
	}

}
