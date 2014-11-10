<?php

class OfertasInscripcionesController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($oferta_id) {
        $oferta = Oferta::findOrFail($oferta_id);

        $exp = Request::get('exp');
        $inscripciones = $oferta->inscripciones->all();
        
        if (!empty($exp)) {
            switch ($exp) {
                case parent::EXPORT_XLS:
                    return $this->exportarXLS("inscriptos_" . $oferta->nombre, $inscripciones, 'inscripciones.'.$oferta->view.'.excel');
                case parent::EXPORT_PDF:
                    return $this->exportarPDF("inscriptos_" . $oferta->nombre, $inscripciones, 'inscripciones.'.$oferta->view.'.excel');
                case parent::EXPORT_CSV:
                //TODO
                //break;
            }
        } else {
            return View::make('inscripciones.'.$oferta->view.'.index', compact('inscripciones'))->withoferta($oferta);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($oferta_id) {
        $oferta = Oferta::findOrFail($oferta_id);
        if (!$oferta->permite_inscripciones) {
            return View::make('inscripciones.cerradas')->withoferta($oferta);
        }

        return View::make('inscripciones.'.$oferta->view.'.create')->withoferta($oferta);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($oferta_id) {
        $oferta = Oferta::findOrFail($oferta_id);
        $inscripto = $oferta->inscripcionModel;
        
        $input = Input::all();
        
        $input_db = Input::except($inscripto::$rules_virtual);

        $validation = $inscripto->validarNuevo($input);

        if ($validation->passes()) {
            
            $insc = $inscripto->create($input_db);

            try {
                Mail::send($oferta->getVistaMail(), compact('oferta'), function($message) use($oferta, $insc) {
                    $message
                            ->to($insc->correo, $insc->inscripto)
                            ->subject('CFB-UDC: Inscripción a ' . $oferta->nombre);
                });
            } catch (Swift_TransportException $e) {
                Log::info("No se pudo enviar correo a " . $insc->inscripto . " <" . $insc->correo . ">");
            }

            return Redirect::to('/inscripcion_ok');
        }
        //dd($validation);
        return Redirect::route('ofertas.inscripciones.nueva', $oferta_id)
                        ->withOferta($oferta)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'Error al guardar.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($oferta_id, $id) {
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);

        if (is_null($inscripcion)) {
            return Redirect::route('ofertas.inscripciones.index');
        }

        $requisitos = $oferta->requisitos;

        $presentados = $inscripcion->requisitospresentados;

        return View::make('inscripciones.'.$oferta->view.'.edit', compact('inscripcion', 'oferta', 'requisitos', 'presentados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($oferta_id, $id) {
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);

        if (is_null($inscripcion)) {
            return Redirect::route('ofertas.inscripciones.index');
        }
        
        $input = Input::all();

        $input_db = Input::except($inscripcion::$rules_virtual);
                
        $validation = $inscripcion->validarExistente($input);

        if ($validation->passes()) {
            $inscripcion->update($input_db);

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
    public function destroy($oferta_id, $id) {
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
        
        $inscripcion->delete();

        return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                        ->withoferta($oferta)
                        ->with('message', 'Se eliminó el registro correctamente.');
    }

    /**
     * Guarda la presentación de un requisito en la inscripción
     *
     * @return Response
     */
    public function presentarRequisito($oferta_id, $id) {
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
        
        $input = Input::all();
        $reglas = RequisitoPresentado::$rules;

        $input['inscripto_id']   = $inscripcion->id;
        $input['inscripto_type'] = $insc_class;

        $validation = Validator::make($input, $reglas);

        if ($validation->passes()) {
            $requisito = RequisitoPresentado::create($input);
            $presentados = $inscripcion->requisitospresentados;
            
            return View::make('requisitos.itempresentado', compact('oferta', 'requerimiento', 'inscripcion', 'presentados', 'requisito'));
        } else {
            return Response::json(array('error' => 'Error al guardar', 'messages' => $validation->messages()), 400);
        }
    }

    public function borrarRequisito($oferta_id, $inscripto_id, $requisito_id) {
        $req =  RequisitoPresentado::findOrFail($requisito_id);
        $req->delete();

        return Response::make('', 200);
    }
    
    public function imprimir($oferta_id, $id)
    {
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::find($id);

        if (is_null($inscripcion)) {
            return Redirect::route('ofertas.inscripciones.index');
        }
        
        $archivo = sprintf("inscrip_%s_%s", $inscripcion->apellido, $oferta->nombre);
        
        return View::make('inscripciones.carreras.form_pdf', compact('inscripcion', 'oferta'));
        //return $this->exportarFormPDF($archivo , compact('inscripcion', 'oferta'), 'inscripciones.'.$oferta->view.'.form_pdf');
    }

}
