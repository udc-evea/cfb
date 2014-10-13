<?php

class ofertasInscripcionesController extends BaseController {

	/**
	 * inscripcion Repository
	 *
	 * @var inscripcion
	 */
	protected $inscripcion;

	public function __construct(Oferta $oferta, Inscripcion $inscripcion)
	{
            $this->oferta       = $oferta;	
            $this->inscripcion = $inscripcion;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($oferta_id)
	{
        $oferta = oferta::findOrFail($oferta_id);
        
        $exp = Request::get('exp');

        if(!empty($exp)) {
        	$inscripciones = Inscripcion::where('oferta_formativa_id', '=', $oferta->id)
        					->with('localidad', 'nivel_estudios', 'rel_como_te_enteraste')
        					->orderBy('apellido')
        					->orderBy('nombre')
        					->get();

        	switch($exp) {
	        	case parent::EXPORT_XLS:
	        		return $this->exportarXLS("inscriptos_".$oferta->nombre, $inscripciones, 'inscripciones.excel');
	        	break;

	        	case parent::EXPORT_PDF:
	        		return $this->exportarPDF("inscriptos_".$oferta->nombre, $inscripciones, 'inscripciones.excel');
	        	break;

	        	case parent::EXPORT_CSV:
	        	//TODO
	        	//break;
	        }
        } else {
        	$inscripciones = $oferta->inscripciones->all();
            return View::make('inscripciones.index', compact('inscripciones'))->withoferta($oferta);
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($oferta_id)
	{
            $oferta = oferta::findOrFail($oferta_id);
            if(!$oferta->permite_inscripciones)
            {
                return View::make('inscripciones.cerradas')->withoferta($oferta);
            }
            
            return View::make('inscripciones.create')->withoferta($oferta);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($oferta_id)
	{
            $oferta    = oferta::findOrFail($oferta_id);
            $input    = Input::all();
            $input_db = Input::except(['recaptcha_challenge_field','recaptcha_response_field', 'reglamento']);
            $reglas   = Inscripcion::$rules;
            $mensajes = array('unique_with' => 'El e-mail ingresado ya corresponde a un inscripto en este oferta.');

            if(!Auth::check())
            {
                $reglas['recaptcha_response_field'] = 'required|recaptcha';
                $reglas['reglamento'] = 'required|boolean';
            }
            $validation = Validator::make($input, $reglas, $mensajes);

            if ($validation->passes())
            {
                    $insc = $this->inscripcion->create($input_db);
                    
                    try {
                        Mail::send($oferta->getVistaMail(), array('inscripcion' => $insc), function($message) use($oferta, $insc) {
                            $message
                                    ->to($insc->email, $insc->nombre)
                                    ->subject('CFB-UDC: Inscripción a '.$oferta->nombre);
                        });
                    } catch(Swift_TransportException $e) { Log::info("No se pudo enviar correo a ".$insc->nombre. " <".$insc->email.">"); }
                    
                    return Redirect::to('/inscripcion_ok');
            }

            return Redirect::route('ofertas.inscripciones.nueva', $oferta_id)
                    ->withoferta($oferta)
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
	public function show($oferta_id, $id)
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
	public function edit($oferta_id, $id)
	{
		$inscripcion = $this->inscripcion->find($id);
                
		if (is_null($inscripcion))
		{
			return Redirect::route('ofertas.inscripciones.index');
		}
                
        $oferta = $inscripcion->oferta;
        $requisitos = $oferta->requisitos;

        $presentados = $inscripcion->requisitospresentados;

		return View::make('inscripciones.edit', compact('inscripcion', 'oferta', 'requisitos',  'presentados'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($oferta_id, $id)
	{
		$input = array_except(Input::all(), array('_method', 'reglamento'));
	    $rules = inscripcion::$rules;
	    $rules['oferta_formativa_id']['unique_persona'] .=', '.$id;
	    $rules['email']['unique_mail'] .=', '.$id;
	    $mensajes = array('unique_with' => 'El e-mail ingresado ya corresponde a un inscripto en este oferta.');

		$validation = Validator::make($input, $rules, $mensajes);

		if ($validation->passes())
		{
			$inscripcion = $this->inscripcion->find($id);
			$inscripcion->update($input);

			return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
		}

		return Redirect::route('ofertas.inscripciones.edit', array($oferta_id, $id))
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
	public function destroy($oferta_id, $id)
	{
            $this->inscripcion = $this->inscripcion->findOrFail($id);
            $oferta = $this->inscripcion->oferta;
            
            $this->inscripcion->delete();

            return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                    ->withoferta($oferta)
                    ->with('message', 'Se eliminó el registro correctamente.');
	}

	/**
	 * Guarda la presentación de un requisito en la inscripción
	 *
	 * @return Response
	 */
	public function presentarRequisito($oferta_id, $id)
	{
            $oferta    = oferta::findOrFail($oferta_id);
            $input    = Input::all();
            $reglas   = RequisitoPresentado::$rules;
            $obj = new Inscripcion;
            $obj = $obj->findOrFail($id);

            $input['inscripcion_id'] = $obj->id;

            $validation = Validator::make($input, $reglas);

            if ($validation->passes())
            {
            	$requisito_presentado =  new RequisitoPresentado;
                $inscripcion = $requisito_presentado->create($input);
                $presentados = $obj->requisitospresentados;
                $requisito = new Requisito;
                $requisito = $requisito->findOrFail($input['requisito_id']);

                return View::make('requisitos.itempresentado', compact('oferta', 'requerimiento', 'inscripcion', 'presentados', 'requisito'));
            } else
            {
            	return Response::json(array('error' => 'Error al guardar'), 400);
            }
	}

	public function borrarRequisito($oferta_id, $inscripcion_id, $requisito_id)
	{
      	$repo = new RequisitoPresentado;
		$repo = $repo
			->where('inscripcion_id', '=', $inscripcion_id)
			->where('requisito_id', '=', $requisito_id)
			->delete()
			;

		return Response::make('', 200);
	}



}
