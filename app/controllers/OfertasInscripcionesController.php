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
        $mailReplyTo = "inscripciones@udc.edu.ar";
                        
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
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Preinscriptos');
                    //traigo solos los preinscriptos para exportar a excel
                    $preinscripciones = $oferta->inscripciones->all();
                    return $this->exportarXLS($oferta->nombre."_preinscriptos_XLS", $preinscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_XLSI:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Inscriptos');
                    //traigo solos los inscriptos para exportar a excel
                    $inscripciones = $oferta->inscriptosOferta->all();
                    return $this->exportarXLS($oferta->nombre."_inscriptos_XLS", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFP:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Preinscriptos');
                    //traigo solos los preinscriptos para exportar a pdf
                    $preinscripciones = $oferta->inscripciones->all();
                    return $this->exportarPDF($oferta->nombre."_preinscriptos_PDF", $preinscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFI:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Inscriptos');
                    //traigo solos los inscriptos para exportar a pdf
                    $inscripciones = $oferta->inscriptosOferta->all();
                    return $this->exportarPDF($oferta->nombre."_inscriptos_PDF", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_CSV:
                    //traigo solos los inscriptos para exportar a cvs
                    $inscripciones = $oferta->inscriptosOferta->all();
                    return $this->exportarCSV($oferta->nombre."_inscriptos_CSV", $inscripciones, 'inscripciones.'.$oferta->view.'.csv')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFA:
                    //traigo solo los datos de alumno APROBADO para exportar a pdf
                    $id_alumno = Request::get('alm');
                    $aprobado = $oferta->aprobados->find($id_alumno);
                    Session::set('oferta',$oferta);
                    return $this->exportarPDF($oferta->nombre." - Certificado_de_Aprobacion - ".$aprobado->apellido.'_'.$aprobado->nombre, $aprobado, 'inscripciones.'.$oferta->view.'.certificado');
                case parent::ENV_PDFA:
                    //traigo solo los datos de alumno APROBADO para descargar a pdf
                    $id_alumno = Request::get('alm');
                    $aprobado = $oferta->aprobados->find($id_alumno);
                    Session::set('oferta',$oferta);
                    return $this->enviarPDF($oferta->id.$id_alumno, $aprobado, 'inscripciones.'.$oferta->view.'.certificado');
                case parent::EXPORT_PDFAS:
                    //traigo solo los datos de alumno ASISTENTE para exportar a pdf
                    $id_alumno = Request::get('alm');
                    $alumnoAsistente = $oferta->asistentes->find($id_alumno);
                    return $this->exportarPDF($oferta->nombre." - Certif_Asistencia - ".$alumnoAsistente->apellido.'_'.$alumnoAsistente->nombre, $alumnoAsistente, 'inscripciones.'.$oferta->view.'.certificado')->with('oferta',$oferta);
                case parent::EXPORT_PDFASIST:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Asistentes');
                    //traigo todos los asistentes del evento para exportar a pdf                    
                    $asistentes = $oferta->asistentes->all();
                    return $this->exportarPDF($oferta->nombre."_asistentes",$asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                case parent::EXPORT_XLSAS:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Asistentes');
                    //traigo solos los asistentes al evento para exportar a excel
                    $asistentes = $oferta->asistentes->all();
                    return $this->exportarXLS($oferta->nombre."_asistentes_XLS", $asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFAPDOS:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Aprobados');
                    //traigo todos los aprobados de la oferta para exportar a pdf
                    $aprobados = $oferta->aprobados->all();
                    return $this->exportarPDF($oferta->nombre."_aprobados",$aprobados, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                case parent::EXPORT_XLSAPDOS:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Aprobados');
                    //traigo todos los aprobados de la oferta para exportar a excel
                    $aprobados = $oferta->aprobados->all();
                    return $this->exportarXLS($oferta->nombre."_aprobados_XLS", $aprobados, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
            }
      }
      
      //Seteo el tab_activo de las inscripciones
      if(!Session::has('tab_activa_inscripciones')){
        Session::set('tab_activa_inscripciones',1);
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
        return View::make('inscripciones.'.$oferta->view.'.index', compact('preinscripciones','inscripciones','comisiones'))
                ->withoferta($oferta)
                ->with('userName',$userName)
                ->with('nomyape',$NomYApe)
                ->with('perfil',$perfil)
                ->with('tipoOferta',$tipoOferta)
                ->with('aprobados',$aprobados);
        
      }elseif($oferta->getEsEventoAttribute()){ //solo si es un Evento
            /*if (!empty($exp)) {
                switch ($exp) {
                    case parent::EXPORT_PDFAS:
                        //traigo solo los datos de alumno Asistente para exportar a pdf
                        $id_alumno = Request::get('alm');
                        $alumnoAsistente = $oferta->asistentes->find($id_alumno);
                        return $this->exportarPDF($oferta->nombre." - Certif_Asistencia - ".$alumnoAsistente->apellido.'_'.$alumnoAsistente->nombre, $alumnoAsistente, 'inscripciones.'.$oferta->view.'.certificado')->with('oferta',$oferta);
                    case parent::EXPORT_PDFASIST:
                        //traigo todos los asistentes dle evento para exportar a pdf
                        $asistentes = $oferta->asistentes->all();
                        return $this->exportarPDF($oferta->nombre."_asistentes",$asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                    case parent::EXPORT_XLSAS:
                        //traigo solos los asistentes al evento para exportar a excel
                        $asistentes = $oferta->asistentes->all();
                        return $this->exportarXLS($oferta->nombre."_asistentes_XLS", $asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                }
            }*/
      
            //Obtengo el listado de Asistentes al Evento
            $asistentes = $oferta->asistentes->all();

            return View::make('inscripciones.'.$oferta->view.'.index', compact('preinscripciones','inscripciones','asistentes'))
                    ->withoferta($oferta)
                    ->with('userName',$userName)
                    ->with('nomyape',$NomYApe)
                    ->with('perfil',$perfil)
                    ->with('tipoOferta',$tipoOferta)
                  ;
        
      }else{ //solo si es una Carrera
          $preinscripciones = $oferta->inscripciones->all();
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
    public function create($id) {        
        $oferta_id = $this->obtenerElId($id);
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
        } elseif((!Auth::check()) && (!$oferta->permite_inscripciones)) {
            return View::make('inscripciones.cerradas')->withoferta($oferta);
        }

        return View::make('inscripciones.'.$oferta->view.'.create')->withoferta($oferta);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($of_id) {
        $oferta_id = $this->obtenerElId($of_id);
        $oferta = Oferta::findOrFail($oferta_id);
        $inscripto = $oferta->inscripcionModel;
        
        $input = Input::all();
        
        $input_db = Input::except($inscripto::$rules_virtual);

        $validation = $inscripto->validarNuevo($input);

        if ($validation->passes()) {
            
            // verifico a cual correo se configura el 'replyTo()'
            if($oferta->getEsOfertaAttribute()){
                $mailReplyTo = "cursos@udc.edu.ar";
            }elseif($oferta->getEsCarreraAttribute()){
                $mailReplyTo = "alumnos@udc.edu.ar";
            }else{
                $mailReplyTo = "eventos@udc.edu.ar";
            }
            
            $insc = $inscripto->create($input_db);

            try {
                Mail::send($oferta->getVistaMail(), compact('oferta','insc'), function($message) use($oferta, $insc, $mailReplyTo) {
                    $message
                            ->to($insc->correo, $insc->inscripto)
                            ->subject('UDC:: Recibimos tu Preinscripción a ' . $oferta->nombre)
                            ->replyTo($mailReplyTo);
                });
            } catch (Swift_TransportException $e) {
                Log::info("No se pudo enviar correo a " . $insc->inscripto . " <" . $insc->correo . ">");
            }

            return Redirect::to('/inscripcion_ok');
        }
        //dd($validation);
        $id_string = $oferta->stringAleatorio($oferta_id,15);
        $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.nueva', $id_string)
                        ->withOferta($oferta)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', "$cabecera Error al guardar. $final");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($of_id, $id) {
        $oferta_id = $this->obtenerElId($of_id);
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
    public function update($of_id, $id) {
        $oferta_id = $this->obtenerElId($of_id);
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);

        if (is_null($inscripcion)) {
            return Redirect::route('ofertas.inscripciones.index');
        }
        
        $input = Input::all();

        $input_db = Input::except($inscripcion::$rules_virtual);
                
        $validation = $inscripcion->validarExistente($input);
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',1);

        if ($validation->passes()) {
            $inscripcion->update($input_db);
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
                ->with('message', "$cabecera Se guardaron correctamente los cambios! $final")
                ;
        }                
        
        $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.edit', array($oferta_id, $id))
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', "$cabecera Ocurrieron errores al guardar.! $final");
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
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',1);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                        ->withoferta($oferta)
                        ->with('message', "$cabecera Se eliminó el registro correctamente. $final");
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
            
    public function cambiarInscripciones($oferta_id) {
        
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        //según la Oferta, me fijo si debo consultar los inscriptos de Eventos, Ofertas o Carreras
        $insc_class = $oferta->inscripcionModelClass;        
        //me fijo si la variable del POST existe
        if(Input::has('listaIdPreinscriptos')){
            //obtengo del POST la variable de los ID de todos los preinscriptos
            $variable = Input::get('listaIdPreinscriptos');
            //separo todos los ID y los almaceno como un array asociativo
            $lista = explode('-',$variable);
        }
        //me fijo si la variable del POST existe
        if(Input::has('inscripto')){
            //obtengo del POST la variable de los ID que van a ser inscriptos
            $listacheck = Input::get('inscripto');
        }
        //si las dos variables existen y no son null, guardo los cambios
        if(isset($listacheck,$lista)){
            /*Session::forget('lista');
            Session::forget('listacheck');
            Session::push('lista', $lista);
            Session::push('listacheck', $listacheck);*/
            //recorro la lista de los preinscriptos uno por uno
            foreach($lista as $nroPreIncr){                
                //obtengo el objeto de ese preinscripto
                $inscripcion = $insc_class::findOrFail($nroPreIncr);
                //si el nro. de inscripto es uno de los que se debe inscribir, lo guardo
                if(array_key_exists($nroPreIncr, $listacheck)){
                    //si se trata de una Oferta y no estaba anotado como Inscripto, se debe además reiniciar otros campos
                    if(($oferta->getEsOfertaAttribute()) && (!$inscripcion->getEsInscripto())){
                        //reinicio comision nro.
                        $inscripcion->setComisionNro(0);
                        //reinicio Aprobado en 0
                        $inscripcion->setAprobado(0);
                        //reinicio presento_requisitos en FALSE
                        $inscripcion->setRequisitosCompletos(FALSE);
                    }
                    //le creo el correo institucional
                    $inscripcion->crearCorreoInstitucional();
                    //le asigno el campo inscripcion a 1
                    $inscripcion->setEstadoInscripcion(1);
                //si el preinscripto no esta para inscribir
                }else{
                    //borro el correo institucional
                    $inscripcion->vaciarCorreoInstitucional();
                    //le asigno el campo inscripcion a 0
                    $inscripcion->setEstadoInscripcion(0);
                    //si se trata de una Oferta, se debe además reiniciar otros campos
                    if($oferta->getEsOfertaAttribute()){
                        //reinicio presento_requisitos en FALSE
                        $inscripcion->setRequisitosCompletos(FALSE);
                    }elseif($oferta->getEsEventoAttribute()){
                        //reinicio Asistente en 0
                        $inscripcion->setAsistente(0);
                    }
                }
                //guardo los cambios en la BD
                $inscripcion->save();
            }
        //si alguno de las variables viene vacia
        }else{
            //recorro todos los preinscriptos y les reseteo algunos campos
            foreach($lista as $nroPreIncr){
                //obtengo el objeto de ese preinscripto
                $inscripcion = $insc_class::findOrFail($nroPreIncr);
                //si se trata de una Oferta, se debe además reiniciar otros campos
                if($oferta->getEsOfertaAttribute()){
                    //reinicio comision nro.
                    $inscripcion->setComisionNro(0);
                    //reinicio presento_requisitos en FALSE
                    $inscripcion->setRequisitosCompletos(FALSE);
                }
                //borro el correo institucional
                $inscripcion->vaciarCorreoInstitucional();
                //le asigno el campo inscripcion a 0
                $inscripcion->setEstadoInscripcion(0);
                //guardo los cambios en la BD
                $inscripcion->save();
            }
        }
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',2);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
            ->with('message',"$cabecera Se hicieron los cambios correctamente! $final");
    }
    
    public function cambiarAsistentes($oferta_id) {
        
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        //según la Oferta, me fijo si debo consultar los inscriptos de Eventos, Ofertas o Carreras
        $insc_class = $oferta->inscripcionModelClass;        
        //me fijo si la variable del POST existe
        if(Input::has('listaIdInscriptos')){
            //obtengo del POST la variable de los ID de todos los Inscriptos
            $variable = Input::get('listaIdInscriptos');
            //separo todos los ID y los almaceno como un array asociativo
            $lista = explode('-',$variable);
        }
        //me fijo si la variable del POST existe
        if(Input::has('asistente')){
            //obtengo del POST la variable de los ID que van a ser inscriptos
            $listacheck = Input::get('asistente');
        }
        //si las dos variables existen y no son null, guardo los cambios
        if(isset($listacheck,$lista)){
            /*Session::forget('lista');
            Session::forget('listacheck');
            Session::push('lista', $lista);
            Session::push('listacheck', $listacheck);*/
            //recorro la lista de los inscriptos uno por uno
            foreach($lista as $nroIncr){
                //obtengo el objeto de ese inscripto
                $inscripcion = $insc_class::findOrFail($nroIncr);
                //si el nro. de inscripto es uno de los que asistieron, lo guardo
                if(array_key_exists($nroIncr, $listacheck)){
                    //le asigno el campo asistente a 1
                    $inscripcion->setAsistente(1);
                    //genero el Codigo de Verificación del Asistente
                    $inscripcion->setCodigoVerificacion($this->generarCodigoDeVerificacion());
                //si el inscripto no esta como asistente
                }else{
                    //le asigno el campo asistente a 0
                    $inscripcion->setAsistente(0);
                    //pongo el Codigo de Verificacion en null
                    $inscripcion->vaciarCodigoVerificacion($inscripcion);
                    //throw new Exception;
                }    
                //guardo los cambios en la BD
                $inscripcion->save();
            }
        //si alguno de las variables viene vacia
        }else{
            //recorro todos los inscriptos y les reseteo algunos campos
            foreach($lista as $nroIncr){
                //obtengo el objeto de ese inscripto
                $inscripcion = $insc_class::findOrFail($nroIncr);
                //le asigno el campo asistente a 0
                $inscripcion->setAsistente(0);
                //pongo el Codigo de Verificacion en null
                $inscripcion->vaciarCodigoVerificacion($inscripcion);
                //guardo los cambios en la BD
                $inscripcion->save();
            }
        }
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',3);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
            ->with('message',"$cabecera Se hicieron los cambios correctamente! $final");
    }
    
    public function cambiarAprobado($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getEsAprobado()){
            $inscripcion->setAprobado(0);
            $inscripcion->setCodigoVerificacion(null);
            //Seteo el tab_activo de las inscripciones
            Session::set('tab_activa_inscripciones',3);
            /* Aca se borrarian los datos del que deja de ser "aprobado" */
        }else{
            $inscripcion->setAprobado(1);
            $inscripcion->setCodigoVerificacion($this->generarCodigoDeVerificacion());
            //Seteo el tab_activo de las inscripciones
            Session::set('tab_activa_inscripciones',15);
        }
        $inscripcion->save();                
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
            ->with('message',"$cabecera Se hicieron los cambios correctamente! $final");
    }
    
    /*public function cambiarAsistente($oferta_id, $id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getEsAsistente()){
            $inscripcion->setAsistente(0);
            /* Aca se borrarian los datos del que deja de ser "asistente" 
        }else{
            $inscripcion->setAsistente(1);
            $inscripcion->setCodigoVerificacion($this->generarCodigoDeVerificacion());
        }
        $inscripcion->save();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id));
    }*/
    
    public function cambiarEstadoDeRequisitos($oferta_id) {
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        $oferta = Oferta::findorFail($oferta_id);
        //según la Oferta, me fijo si debo consultar los inscriptos de Eventos, Ofertas o Carreras
        $insc_class = $oferta->inscripcionModelClass;        
        //me fijo si la variable del POST existe
        if(Input::has('listaIdInscriptos')){
            //obtengo del POST la variable de los ID de todos los Inscriptos
            $variable = Input::get('listaIdInscriptos');
            //separo todos los ID y los almaceno como un array asociativo
            $lista = explode('-',$variable);
        }
        //me fijo si la variable del POST existe
        if(Input::has('requisitos')){
            //obtengo del POST la variable de los ID que van a ser inscriptos
            $listacheck = Input::get('requisitos');
        }
        //si las dos variables existen y no son null, guardo los cambios
        if(isset($listacheck,$lista)){
            /*Session::forget('lista');
            Session::forget('listacheck');
            Session::push('lista', $lista);
            Session::push('listacheck', $listacheck);*/
            //recorro la lista de los inscriptos uno por uno
            foreach($lista as $nroIncr){
                //obtengo el objeto de ese inscripto
                $inscripcion = $insc_class::findOrFail($nroIncr);
                //si el nro. de inscripto es uno de los que asistieron, lo guardo
                if(array_key_exists($nroIncr, $listacheck)){
                    //le asigno el campo presento_requisitos en TRUE
                    $inscripcion->setRequisitosCompletos(TRUE);
                //si el inscripto no esta con requisitos presentados
                }else{
                    //le asigno el campo presento_requisitos en FALSE
                    $inscripcion->setRequisitosCompletos(FALSE);
                }    
                //guardo los cambios en la BD
                $inscripcion->save();
            }
        //si alguno de las variables viene vacia
        }else{
            //recorro todos los inscriptos y les reseteo algunos campos
            foreach($lista as $nroIncr){
                //obtengo el objeto de ese inscripto
                $inscripcion = $insc_class::findOrFail($nroIncr);
                //le asigno el campo presento_requisitos en FALSE
                $inscripcion->setRequisitosCompletos(FALSE);
                //guardo los cambios en la BD
                $inscripcion->save();
            }
        }
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',3);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
            ->with('message',"$cabecera Se hicieron los cambios correctamente! $final");
                
        /* ################################################################# */
        //busco el inscripto ($id) segun la oferta ($oferta_id)
        /*$oferta = Oferta::findorFail($oferta_id);
        $insc_class = $oferta->inscripcionModelClass;
        $inscripcion = $insc_class::findOrFail($id);
               
        if($inscripcion->getRequisitosCompletos()){            
            $inscripcion->setRequisitosCompletos(FALSE);
        }else{
            $inscripcion->setRequisitosCompletos(TRUE);
        }
        $inscripcion->save();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id)); */
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
        
        //Seteo el tab_activo de las inscripciones        
        Session::set('tab_activa_inscripciones',3);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
            ->with('message',"$cabecera Se sumó correctamente la comisión! $final");
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
        
        //Seteo el tab_activo de las inscripciones        
        Session::set('tab_activa_inscripciones',3);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
            ->with('message',"$cabecera Se restó correctamente la comisión! $final");
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
        
            // verifico a cual correo se configura el 'replyTo()'
            if($oferta->getEsOfertaAttribute()){
                $mailReplyTo = "cursos@udc.edu.ar";
            }elseif($oferta->getEsCarreraAttribute()){
                $mailReplyTo = "alumnos@udc.edu.ar";
            }else{
                $mailReplyTo = "eventos@udc.edu.ar";
            }

            try {
                Mail::send('emails.ofertas.notificacion_correo_udc', compact('inscripcion'), function($message) use($inscripcion, $mailReplyTo){
                    $message
                            ->to($inscripcion->email, $inscripcion->apellido.','.$inscripcion->nombre)
                            ->subject('Correo Institucional creado')
                            ->replyTo($mailReplyTo);
                });
            } catch (Swift_TransportException $e) {
                Log::info("No se pudo enviar correo a " . $inscripcion->apellido.','.$inscripcion->nombre." <" . $inscripcion->email.">");
            }

            //return Redirect::to('/ofertas');
        //}
            //Seteo el tab_activo de las inscripciones        
            Session::set('tab_activa_inscripciones',3);
                        
            // incremento la cantidad de veces que se notifico al inscripto
            $inscripcion->seEnvioNotificacion();
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
                    ->with('message',"$cabecera Se envió correctamente el mail informativo de la cuenta institucional! $final");
    }
    
    public function enviarMailNuevoInscripto($oferta_id, $id){
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
        
            // verifico a cual correo se configura el 'replyTo()'
            if($oferta->getEsOfertaAttribute()){
                $mailReplyTo = "cursos@udc.edu.ar";
            }elseif($oferta->getEsCarreraAttribute()){
                $mailReplyTo = "alumnos@udc.edu.ar";
            }else{
                $mailReplyTo = "eventos@udc.edu.ar";
            }

            try {
                Mail::send('emails.ofertas.notificacion_inscripto_udc', compact('inscripcion','oferta'), function($message) use($inscripcion, $mailReplyTo){
                    $message
                            ->to($inscripcion->email, $inscripcion->apellido.','.$inscripcion->nombre)
                            ->subject('Correo Institucional creado')
                            ->replyTo($mailReplyTo);
                });
            } catch (Swift_TransportException $e) {
                Log::info("No se pudo enviar correo a " . $inscripcion->apellido.','.$inscripcion->nombre." <" . $inscripcion->email.">");
            }

            //return Redirect::to('/ofertas');
        //}
            //Seteo el tab_activo de las inscripciones        
            Session::set('tab_activa_inscripciones',3);
                        
            // incremento la cantidad de veces que se notifico al inscripto
            $inscripcion->seEnvioNotificacionInscripto();
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.inscripciones.index', array($oferta_id))
                    ->with('message',"$cabecera Se envió correctamente el mail informativo al inscripto! $final");
    }
    
    public function limpiarPreinscripciones($id_oferta) {
        //busco la oferta en la BD
        $oferta = Oferta::findOrFail($id_oferta);
        
        //traigo todos (pre-inscriptos e inscriptos) para ver en la vista
        $preinscripciones = $oferta->preinscriptosOferta->all();
        
        foreach($preinscripciones as $preinscripto){
            $preinscripto->delete();
        }
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                        ->withoferta($oferta)
                        ->with('message', "$cabecera Se eliminaron todos los preinscriptos correctamente. $final");
    }
    
    public function enviarMailCertificado($ofid, $alumnoid)
    {      
        //busco la oferta en la BD
        $oferta = Oferta::findOrFail($ofid);
        //busco los datos del alumnos inscripto
        $insc_class = $oferta->inscripcionModelClass;
        $rows = $insc_class::findOrFail($alumnoid);
                            
        //creo el nomre del archivo pdf
        $filename = $ofid.$alumnoid;
        //creo el certificado
        $html = View::make('inscripciones.'.$oferta->view.'.certificado', compact('rows'));        
        
        //Creo el pdf y lo guardo en la carpeta /public/pdfs
        $pdf = new \Thujohn\Pdf\Pdf();
        $content = $pdf->load($html, 'A4', 'landscape')->output();
        $path_to_pdf = public_path("pdfs/$filename.pdf");
        File::put($path_to_pdf, $content);
        
        try{
            //Envío el mail al mail institucional y al personal
            Mail::send('emails.ofertas.envio_certificado',compact('rows','oferta'), function ($message) use ($rows,$filename){                
                $message->to($rows->email)->cc($rows->email_institucional)->subject('Certificado UDC');
                $message->attach("pdfs/$filename.pdf", array('as'=>'Certif. UDC', 'mime'=>'application/pdf'));
            });
        } catch (Swift_TransportException $e) {
            Log::info("No se pudo enviar correo a " . $rows->apellido.','.$rows->nombre." <" . $rows->email.">");
            //devuelvo un mje erroneo y regreso a la inscripcion de la oferta
            $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                            ->withoferta($oferta)
                            ->with('message', "$cabecera No se pudo enviar el Certificado de $rows->nombre, $rows->apellido. Intente nuevamente más tarde. $final");
        }                        
        
        //incremento la cantidad de veces que se le envió el mail con el certificado
        $rows->seEnvioNotificacionConCertificado();
        
        //devuelvo un mje exitoso y regreso a la inscripcion de la oferta
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                        ->withoferta($oferta)
                        ->with('message', "$cabecera Se envió el Certificado de $rows->nombre, $rows->apellido correctamente. $final");
    }        
    
}
