<?php

class OfertasInscripcionesController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($oferta_id) {
        //busco la oferta en la BD
        $oferta = Oferta::findOrFail($oferta_id);
        //me fijo si viene con un parametro mas en la url
        $exp = Request::get('exp');
        
        //traigo todos (pre-inscriptos e inscriptos) para ver en la vista
        //$inscripciones = $oferta->inscripciones->all(); --> descomentar esta linea        
        
        //Busco el usuario actual en la BD
        $userName = Auth::user()->username;
        $NomYApe = Auth::user()->nombreyapellido;
        $perfil = Auth::user()->perfil;
        $userId = Auth::user()->id;
        
        $preinscripciones = $oferta->preinscriptosOferta->all();
        $inscripciones = $oferta->inscriptosOferta->all();
        
      if($oferta->getEsOfertaAttribute()){
         $tipoOferta = "Oferta";
      }elseif($oferta->getEsCarreraAttribute()){
         $tipoOferta = "Carrera";
      }else{
         $tipoOferta = "Evento";
      }
        
      if (!empty($exp)) {
            switch ($exp) {
                case parent::EXPORT_XLSP:
                    //traigo solos los preinscriptos para exportar a excel
                    $inscripciones = $oferta->preinscriptosOferta->all();
                    return $this->exportarXLS($oferta->nombre."_preinscriptos", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_XLSI:
                    //traigo solos los inscriptos para exportar a excel
                    $inscripciones = $oferta->inscriptosOferta->all();
                    return $this->exportarXLS($oferta->nombre."_inscriptos", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFP:
                    //traigo solos los preinscriptos para exportar a pdf
                    $inscripciones = $oferta->preinscriptosOferta->all();
                    return $this->exportarPDF($oferta->nombre."_preinscriptos", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFI:
                    //traigo solos los inscriptos para exportar a pdf
                    $inscripciones = $oferta->inscriptosOferta->all();
                    return $this->exportarPDF($oferta->nombre."_inscriptos", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_CSV:
                    //traigo solos los inscriptos para exportar a cvs
                    $inscripciones = $oferta->inscriptosOferta->all();
                    return $this->exportarCSV($oferta->nombre."_inscriptos", $inscripciones, 'inscripciones.'.$oferta->view.'.csv')->with('tipoOferta',$tipoOferta);
            }
      }

      if($oferta->getEsOfertaAttribute()){
                
        $inscripSinCom = $oferta->inscriptosSinComision->all();
        $inscripCom01 = $oferta->inscriptosComision01->all();
        $inscripCom02 = $oferta->inscriptosComision02->all();
        $inscripCom03 = $oferta->inscriptosComision03->all();
        $inscripCom04 = $oferta->inscriptosComision04->all();
        $inscripCom05 = $oferta->inscriptosComision05->all();
        $inscripCom06 = $oferta->inscriptosComision06->all();
        $inscripCom07 = $oferta->inscriptosComision07->all();
        $inscripCom08 = $oferta->inscriptosComision08->all();
        $inscripCom09 = $oferta->inscriptosComision09->all();
        $inscripCom10 = $oferta->inscriptosComision10->all();
        
        if(count($inscripSinCom)>0){
            $comisiones[0]=$inscripSinCom;
        }
        if(count($inscripCom01)>0){
            $comisiones[1]=$inscripCom01;                            
        }
        if(count($inscripCom02)>0){
            $comisiones[2]=$inscripCom02;
        }
        if(count($inscripCom03)>0){
            $comisiones[3]=$inscripCom03;
        }
        if(count($inscripCom04)>0){
            $comisiones[4]=$inscripCom04;
        }
        if(count($inscripCom05)>0){
            $comisiones[5]=$inscripCom05;
        }
        if(count($inscripCom06)>0){
            $comisiones[6]=$inscripCom06;
        }
        if(count($inscripCom07)>0){
            $comisiones[7]=$inscripCom07;
        }
        if(count($inscripCom08)>0){
            $comisiones[8]=$inscripCom08;
        }
        if(count($inscripCom09)>0){
            $comisiones[9]=$inscripCom09;
        }
        if(count($inscripCom10)>0){
            $comisiones[10]=$inscripCom10;
        }
        
        //Obtengo el listado de Aprobados de la Oferta
        $aprobados = $oferta->aprobados->all();
        
        //return View::make('inscripciones.'.$oferta->view.'.index', compact('inscripciones'))->withoferta($oferta)->with('userName',$userName)->with('nomyape',$NomYApe)->with('perfil',$perfil);
        return View::make('inscripciones.'.$oferta->view.'.index', compact('preinscripciones','inscripciones','comisiones'))->withoferta($oferta)->with('userName',$userName)->with('nomyape',$NomYApe)->with('perfil',$perfil)->with('tipoOferta',$tipoOferta)->with('aprobados',$aprobados);
      }else{                    
          $inscripciones = $oferta->inscripciones->all();
          $inscriptos = $oferta->inscriptosOferta->all();
          return View::make('inscripciones.'.$oferta->view.'.index', compact('preinscripciones','inscripciones'))
                  ->withoferta($oferta)
                  ->with('userName',$userName)
                  ->with('nomyape',$NomYApe)
                  ->with('perfil',$perfil)
                  ->with('tipoOferta',$tipoOferta)
                  ->with('inscriptos',$inscriptos);
      }
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($oferta_id) {
        
        $ofertas  = Oferta::cursos()->get();
        $carreras = Oferta::carreras()->get();
        $eventos  = Oferta::eventos()->get();
                
        foreach ($ofertas as $of) { //agregado por nico
            $of->setCerrarOferta();
        }
        foreach ($carreras as $ca) { //agregado por nico
            $ca->setCerrarOferta();
        }
        foreach ($eventos as $ev) { //agregado por nico
            $ev->setCerrarEvento();
        }        
        
        $oferta = Oferta::find($oferta_id);
        if (!$oferta) {
            return View::make('errors.oferta_inexistente');
        } elseif(!$oferta->permite_inscripciones) {
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
                            ->subject('UDC:: Recibimos tu inscripción a ' . $oferta->nombre);
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
    
    public function cambiarEstado($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getEsInscripto()){
            $inscripcion->setEstadoInscripcion(0);
            $inscripcion->vaciarCorreoInstitucional();
            if($oferta->getEsOfertaAttribute()){
                $inscripcion->setComisionNro(0);
            }            
            $inscripcion->save();
        }else{
            $inscripcion->setEstadoInscripcion(1);
            $inscripcion->crearCorreoInstitucional();
            $inscripcion->save();
        }
        
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }
    
    public function cambiarAprobado($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getEsAprobado()){
            $inscripcion->setAprobado(0);
        }else{
            $inscripcion->setAprobado(1);            
        }
        $inscripcion->save();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }
    
    public function cambiarEstadoDeRequisitos($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getRequisitosCompletos()){            
            $inscripcion->setRequisitosCompletos(FALSE);
        }else{
            $inscripcion->setRequisitosCompletos(TRUE);
        }
        $inscripcion->save();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }
    
    public function sumarComision($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
        
        if($inscripcion->getEsInscripto()){
            $inscripcion->sumarComisionNro();
        }else{
            $inscripcion->setComisionNro(0);
        }
        $inscripcion->save();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }
    
    public function restarComision($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getEsInscripto()){
            $inscripcion->restarComisionNro();
        }else{
            $inscripcion->setComisionNro(0);
        }
        $inscripcion->save();        
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }
    
    public function enviarMailInstitucional($oferta_id, $id){
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
        
        
        //########################################################################
        //$oferta = Oferta::findOrFail($oferta_id);
        //$inscripto = $oferta->inscripcionModel;
        
        //$input = Input::all();
        
        //$input_db = Input::except($inscripto::$rules_virtual);

        //$validation = $inscripto->validarNuevo($input);

        //if ($validation->passes()) {
            
            //$insc = $inscripto->create($input_db);        

            try {
                Mail::send('emails.ofertas.notificacion_correo_udc', compact('inscripcion'), function($message) use($inscripcion){
                    $message
                            ->to($inscripcion->email, $inscripcion->apellido.','.$inscripcion->nombre)
                            ->subject('Correo Institucional creado');
                });
            } catch (Swift_TransportException $e) {
                Log::info("No se pudo enviar correo a " . $inscripcion->apellido.','.$inscripcion->nombre." <" . $inscripcion->email.">");
            }

            //return Redirect::to('/ofertas');
        //}
        
                
            // incremento la cantidad de veces que se notifico al inscripto
            $inscripcion->seEnvioNotificacion();
            
            return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }
}
