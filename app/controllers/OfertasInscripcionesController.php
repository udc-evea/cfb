<?php

use \Carbon\Carbon as Carbon;

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
                    //return $this->exportarXLS($oferta->nombre."_inscriptos_XLS", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                    return $this->exportarXLS($oferta->id."_inscriptos_XLS", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFP:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Preinscriptos');
                    //traigo solos los preinscriptos para exportar a pdf
                    $preinscripciones = $oferta->inscripciones->all();
                    //return $this->exportarPDF($oferta->nombre."_preinscriptos_PDF", $preinscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                    return $this->exportarPDF($oferta->id."_preinscriptos_PDF", $preinscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFI:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Inscriptos');
                    //traigo solos los inscriptos para exportar a pdf
                    $inscripciones = $oferta->inscriptosOferta->all();
                    //return $this->exportarPDF($oferta->nombre."_inscriptos_PDF", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                    return $this->exportarPDF($oferta->id."_inscriptos_PDF", $inscripciones, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_CSV:
                    //traigo solos los inscriptos para exportar a cvs
                    $inscripciones = $oferta->inscriptosOferta->all();
                    //return $this->exportarCSV($oferta->nombre."_inscriptos_CSV", $inscripciones, 'inscripciones.'.$oferta->view.'.csv')->with('tipoOferta',$tipoOferta);
                    return $this->exportarCSV($oferta->id."_inscriptos_CSV", $inscripciones, 'inscripciones.'.$oferta->view.'.csv')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFA:
                    //traigo solo los datos de alumno APROBADO para exportar a pdf
                    $id_alumno = Request::get('alm');
                    $aprobado = $oferta->aprobados->find($id_alumno);
                    Session::set('oferta',$oferta);
                    //return $this->exportarPDF($oferta->nombre." - Certificado_de_Aprobacion - ".$aprobado->apellido.'_'.$aprobado->nombre, $aprobado, 'inscripciones.'.$oferta->view.'.certificado');
                    return $this->exportarPDF($oferta->id." - Certificado_de_Aprobacion - ".$aprobado->apellido.'_'.$aprobado->nombre, $aprobado, 'inscripciones.'.$oferta->view.'.certificado');
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
                    //return $this->exportarPDF($oferta->nombre." - Certif_Asistencia - ".$alumnoAsistente->apellido.'_'.$alumnoAsistente->nombre, $alumnoAsistente, 'inscripciones.'.$oferta->view.'.certificado')->with('oferta',$oferta);
                    return $this->exportarPDF($oferta->id." - Certif_Asistencia - ".$alumnoAsistente->apellido.'_'.$alumnoAsistente->nombre, $alumnoAsistente, 'inscripciones.'.$oferta->view.'.certificado')->with('oferta',$oferta);
                case parent::EXPORT_PDFASIST:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Asistentes');
                    //traigo todos los asistentes del evento para exportar a pdf                    
                    $asistentes = $oferta->asistentes->all();
                    //return $this->exportarPDF($oferta->nombre."_asistentes",$asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                    return $this->exportarPDF($oferta->id."_asistentes",$asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                case parent::EXPORT_XLSAS:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Asistentes');
                    //traigo solos los asistentes al evento para exportar a excel
                    $asistentes = $oferta->asistentes->all();
                    //return $this->exportarXLS($oferta->nombre."_asistentes_XLS", $asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                    return $this->exportarXLS($oferta->id."_asistentes_XLS", $asistentes, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                case parent::EXPORT_PDFAPDOS:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Aprobados');
                    //traigo todos los aprobados de la oferta para exportar a pdf
                    $aprobados = $oferta->aprobados->all();
                    //return $this->exportarPDF($oferta->nombre."_aprobados",$aprobados, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                    return $this->exportarPDF($oferta->id."_aprobados",$aprobados, 'inscripciones.'.$oferta->view.'.excel')->with('oferta',$oferta);
                case parent::EXPORT_XLSAPDOS:
                    //pongo el titulo del cuadro en la session
                    Session::set('titulo','Aprobados');
                    //traigo todos los aprobados de la oferta para exportar a excel
                    $aprobados = $oferta->aprobados->all();
                    //return $this->exportarXLS($oferta->nombre."_aprobados_XLS", $aprobados, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
                    return $this->exportarXLS($oferta->id."_aprobados_XLS", $aprobados, 'inscripciones.'.$oferta->view.'.excel')->with('tipoOferta',$tipoOferta);
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
                ->with('mjeError',"")
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
            $of->setCerrarOfertaOEvento();
        }
        foreach ($carreras as $ca) { //agregado por nico
            $ca->setCerrarCarrera();
        }
        foreach ($eventos as $ev) { //agregado por nico
            $ev->setCerrarOfertaOEvento();
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
            
            if($oferta->getPermiteInscripcionesAttribute()){
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
            Session::set('tab_activa_inscripciones',4);
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
        
        if (!file_exists(public_path("pdfs/$filename.pdf"))){
            //Creo el pdf y lo guardo en la carpeta /public/pdfs
            $pdf = new \Thujohn\Pdf\Pdf();
            $content = $pdf->load($html, 'A4', 'landscape')->output();
            $path_to_pdf = public_path("pdfs/$filename.pdf");
            File::put($path_to_pdf, $content);
        }
        
        try{
            //Envío el mail al mail institucional y al personal
            Mail::send('emails.ofertas.envio_certificado',compact('rows','oferta'), function ($message) use ($rows,$filename){                
                $message->to($rows->email)/*->cc($rows->email_institucional)*/->subject('Certificado UDC');
                $message->attach("pdfs/$filename.pdf", array('as'=>'Certificado_UDC.pdf', 'mime'=>'application/pdf'));
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
    
    public function importarAlumnosDeArchivo($ofid)
    {    
        $oferta_id = $this->obtenerElId($ofid);
        $oferta = Oferta::findorFail($oferta_id);

        $MjeError = NULL;
        $post = false;
        $datos = NULL;
        //me fijo si la vista se carga por GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //cargo la vista con los argumentos necesarios
            return View::make('inscripciones.'.$oferta->view.'.importarAlumnosDeArchivo')
                    ->with('datos',$datos)
                    ->with('ofid',$ofid)
                    ->with('post',$post)
                    ->with('oferta',$oferta)
                    ->with('MjeError',$MjeError);
        }else{
            // Me fijo si es POST y si el $archivo es <> NULL
            // realizo los pasos necesarios para la importación y lo guardo 
            // en un array asociativo para mostrar por pantalla y luego
            // decidir si se importa a la base o no

            //$coloco la variable $post en TRUE para la condicion de la vista
            $post = true;
            //obtengo la ubicación real del archivo importado
            $archivo = Input::file('archivo');
            $realPath = Input::file('archivo')->getRealPath();
            //Si el archivo existe, leo su contenido. Sino, muestro error.
            if ($realPath != NULL) {
                //obtengo todos los campos (columnas) con la información del archivo Excel
                $datosArchivo = Excel::load($realPath, function($reader) {})->get();
                //obtengo solo los datos de las columnas del archivo
                $datos = $this->obtenerCabecerayDatos($datosArchivo);
                //verifico si los datos cargados tienen algún error de validación
                $MjeError = $this->verificarDatosValidos($datos);
                //cargo la vista con los datos necesarios
                $tipoDocumento = TipoDocumento::all();
                $localidad = Localidad::all();                
                return View::make('inscripciones.'.$oferta->view.'.importarAlumnosDeArchivo')
                    ->with('datos',$datos)
                    ->with('post',$post)
                    ->with('oferta',$oferta)
                    ->with('tipoDocumento',$tipoDocumento)
                    ->with('localidad',$localidad)
                    ->with('MjeError',$MjeError);
            }else{
                $MjeError .= "<li> Verficar que el archivo contiene 1 sola fila con los datos de la Oferta a importar.</li>";
                return View::make('inscripciones.'.$oferta->view.'.importarAlumnosDeArchivo')
                    ->with('datos',$datos)
                    ->with('ofid',$ofid)
                    ->with('post',$post)
                    ->with('oferta',$oferta)
                    ->with('MjeError',$MjeError);
            }
        }
    }
    
    private function obtenerCabecerayDatos($datosArchivo)
        {   //funcion para obtener solo los datos de las columnas del archivo leido
            
            if ((!empty($datosArchivo))&&($datosArchivo->count()>0)){
                //defino unas variables de ayuda
                $datos = array();
                $soloDatos = array();
                $i = 0;
                
                //recorro fila por fila que contienen los datos (deberia
                foreach ($datosArchivo as $fila) {
                    //echo "<br> - Fila $i: ".$fila;
                    if($fila->count() != 7){
                        return null;
                    }
                    foreach ($fila as $campo => $celda){                        
                        $datos[$i][$campo] = $celda;
                        array_push($soloDatos,$celda);
                        //echo "<br> - campo: $campo - valor: $celda";
                    }
                    $i++;
                }                
                return $datos;
            }else{                
                //$datos = null;
                return null;
            }
        }
        
        private function verificarDatosValidos($datos) 
        { //funcion que verifica algunos datos del alumno a importar
            
            //defino las variables a utilizar
            $cantColumnas = sizeof($datos);
        
            $mje = "";
            $arrayDNI = array();
            if($datos == null){
                $mje .= "<li> El archivo no contiene datos de alumnos.</li>";
                return $mje;
            }
            //recorro fila por fila que contienen los datos (deberia
            $i = 1;
            foreach ($datos as $fila) {
                $cabecera_ok = true;
                if(!key_exists('tipo_documento', $fila)&&($i==1)){
                    $mje .= "<li>La columna 1 (del tipo de DNI) debe llamarse <b>tipo documento</b></li>";
                    $cabecera_ok = FALSE;
                }
                if(!key_exists('documento', $fila)&&($i==1)){
                    $mje .= "<li>La columna 2 (del DNI) debe llamarse <b>documento</b></li>";
                    $cabecera_ok = FALSE;
                }
                if(!key_exists('apellido', $fila)&&($i==1)){
                    $mje .= "<li>La columna 3 (del APELLIDO) debe llamarse <b>apellido</b></li>";
                    $cabecera_ok = FALSE;
                }
                if(!key_exists('nombre', $fila)&&($i==1)){
                    $mje .= "<li>La columna 4 (del NOMBRE) debe llamarse <b>nombre</b></li>";
                    $cabecera_ok = FALSE;
                }
                if(!key_exists('fecha_de_nacimiento', $fila)&&($i==1)){
                    $mje .= "<li>La columna 5 (de la FECHA DE NACIMIENTO) debe llamarse <b>fecha de nacimiento</b></li>";
                    $cabecera_ok = FALSE;
                }
                if(!key_exists('localidad_id', $fila)&&($i==1)){
                    $mje .= "<li>La columna 6 (de la LOCALIDAD ID) debe llamarse <b>localidad id</b></li>";
                    $cabecera_ok = FALSE;
                }
                if(!key_exists('email', $fila)&&($i==1)){
                    $mje .= "<li>La columna 7 (del EMAIL) debe llamarse <b>email</b></li>";
                    $cabecera_ok = FALSE;
                }
                if($cabecera_ok){                    
                    if(sizeof($fila)!=7){
                        $mje .= "<li> Fila $i: La cantidad de columnas no es 7. Revisar el archivo nuevamente!.</li>";
                    }
                    if(($fila['tipo_documento']==null)&&($fila['tipo_documento']=="")){
                        $mje .= "<li> Fila $i: La fila esta vacia. Elimine esta fila del archivo XLS para poder importar correctamente!.</li>";
                    }else{
                        if(($fila['tipo_documento']<1)||($fila['tipo_documento']>4)){
                            $mje .= "<li> Fila $i: El Tipo de Documento debe ser uno de los siguientes codigos: 1-DNI, 2-LC, 3-LE o 4-Pasaporte.</li>";
                        }
                        $dni = $fila['documento'];                    
                        //if(($dni<99999)||($dni>99999999)){
                        //    $mje .= "<li> Fila $i:  El documento debe estar entre los nros. 99.999 y 99.999.999.</li>";
                        //}
                        if((strlen($dni)<7)||(strlen($dni)>15)){
                            $mje .= "<li> Fila $i:  El documento debe tener entre 7 y 15 caracteres.</li>";
                        }
                        if (($i>1)&&(in_array($dni,$arrayDNI))){
                            $mje .= "<li> Fila $i:  El documento ($dni) ya existe en este listado de alumnos, verifique!.</li>";
                        }
                        array_push($arrayDNI, $dni);
                        if(ctype_space($fila['documento'])){
                            $mje .= "<li> Fila $i:  El documento no debe contener espacios en blanco ni tabulaciones.</li>";
                        }
                        if(strlen($fila['apellido'])<2){
                            $mje .= "<li> Fila $i:  El apellido debe tener por lo menos 2 caracteres de longitud.</li>";
                        }
                        if(strlen($fila['nombre'])<3){
                            $mje .= "<li> Fila $i:  El nombre debe tener por lo menos 3 caracteres de longitud.</li>";
                        }                    
                        //$anio = explode('/',(new Carbon($fila['fecha_de_nacimiento']))->format('d/m/Y'));
                        $anio = explode('/',(new Carbon($fila['fecha_de_nacimiento']))->format('d/m/Y'));
                        if (count($anio)>=3){
                            $anio = explode('/',$fila['fecha_de_nacimiento']->format('d/m/Y'));
                        }else{
                            $anio[0]="01";$anio[1]="01";$anio[2]="1910";
                            $mje .= "Count(anio):".count($anio);
                            $mje .= "<li> Fila $i: Error en la fecha de nacimiento - REVISAR! - La fecha original era: ".$fila['fecha_de_nacimiento']."</li>";
                        }                    
                        if(($anio[2] < 1910) || ($anio[2] > (date('Y')-18))){
                            $mje .= "<li> Fila $i: La fecha de nacimiento no puede ser menor a 1910, ni mayor a ".(date('Y')-18)."</li>";
                        }
                        $arrayLocalidades = array('1','87','88','89','99','100','101','102','103','104','105','106','107','108','109','110','111','112','113','114');
                        $localidadID = $fila['localidad_id'];
                        if(!in_array($localidadID,$arrayLocalidades)){
                            $mje .= "<li> Fila $i:  El ID de localidad debe estar dentro de los valores estipulados.</li>";
                        }
                        if(strlen($fila['email'])<5){
                            $mje .= "<li> Fila $i:  El mail debe tener por lo menos 5 caracteres de longitud.</li>";
                        }
                    }
                }
                $i++;
            }
            //devuelvo los mjes de error
            return $mje;
        }
    
        public function guardarAlumnosImportados($of_id) {            
            
            //busco la oferta en la Base de Datos
            $oferta = Oferta::findOrFail($of_id);
            if(Input::has('stringValue')){
                $stringValue = Input::get('stringValue');
            }else{
                $stringValue = null;
            }
            if (strlen($stringValue) != null){
                
                $estadoInscripcion = Input::get('estado_inscripcion');
                
                $filas = explode(';', $stringValue);                                
                
                DB::beginTransaction();
                
                foreach($filas as $fila){
                    if(strlen($fila > 0)){                        
                        try{
                            //guardo los datos en la base de datos
                            $this->guardarAlumnosEnBase($oferta,$fila,$estadoInscripcion);
                        } catch (Exception $ex) {                            
                            DB::rollBack();
                            Session::set('imperror',"<h2>Error al importar el archivo. Contáctese con el área de Sistemas de la UDC.</h2><h3>Error:</h3><br>$ex.");
                            return Redirect::to('ofertas/'.$oferta->id.'/inscripciones');
                        }                       
                    }
                }
                DB::commit();                
                return Redirect::to('ofertas/'.$oferta->id.'/inscripciones');
            }else{                
                return Redirect::to('ofertas/'.$oferta->id.'/inscripciones');
            }
        }
        
        private function guardarAlumnosEnBase($oferta,$fila,$estadoInscripcion)
        {
            //obtengo los datos de una fila del excel importado
            list($tipoDoc, $doc, $ape, $nom, $fe_nac, $loc_id, $email) = explode(',',$fila);
            
            //creo un modelo del Inscripto con los campos a insertar
            $inscripto = $oferta->inscripcionModel;
            
            $inscripto['oferta_formativa_id'] = $oferta->id;
            if($estadoInscripcion < 2){
                $inscripto['estado_inscripcion'] = $estadoInscripcion; //el estado_inscripcion 0: Preinscripto o 1: Inscripto
            }else{
                $inscripto['estado_inscripcion'] = 1; //el estado_inscripcion 0: Preinscripto o 1: Inscripto
                $codigoDeVerificacionExitente = false;
                do{
                    $codigoDeVerificacionExitente = ($inscripto->setCodigoVerificacion($this->generarCodigoDeVerificacion()));
                }while (!$codigoDeVerificacionExitente);
                //$inscripto->setCodigoVerificacion($this->generarCodigoDeVerificacion());
                if($oferta->tipo_oferta == 2){
                    $inscripto['aprobado'] = 1; //coloco el 1 ya en en el formualario vino que todos los alumnos son aprobados
                }else{
                    $inscripto['asistente'] = 1; //coloco el 1 ya en en el formualario vino que todos los alumnos son asistentes
                }
            }
            $inscripto['tipo_documento_cod'] = $tipoDoc;
            $inscripto['documento'] = $doc;
            $inscripto['apellido'] = $ape;
            $inscripto['nombre'] = $nom;
            $fechaNac = strtotime($fe_nac);
            $fechaNacFormat = date('Y-m-d',$fechaNac);
            $inscripto['fecha_nacimiento'] = $fechaNacFormat;
            $inscripto['localidad_id'] = $loc_id;
            $inscripto['email'] = $email;
            $inscripto['como_te_enteraste'] = 12; //el 12 es porque es "Web Institucional" en la base de datos
            //si la oferta es Oferta (curso) lleno otros campos más
            if($oferta->tipo_oferta == 2){
                $inscripto['localidad_anios_residencia'] = 0; //el 0 es porque no tiene un valor por defecto en la base de datos
                $inscripto['nivel_estudios_id'] = 2; //el 2 es porque es NS/NC en la base de datos
                if($estadoInscripcion > 0){
                    $inscripto['presento_requisitos'] = 1; //el 2 es porque es NS/NC en la base de datos                
                }
            }
            if($estadoInscripcion > 0){
                //le creo el correo institucional
                $inscripto->crearCorreoInstitucional();
            }
            $inscripto->save();
            return;
        }
        
    public function inscribirTodosLosAlumnos($ofid)
    {    
        //busco la oferta segun el $id
        $oferta = Oferta::findorFail($ofid);
        //traigo todos los pre-inscriptos de la oferta seleccionada
        $lista = $oferta->preinscriptosOferta->all();
        
        //recorro todos los preinscriptos los cambio a insciptos a quienes no esten en esa condicion
        foreach($lista as $preIncr){
            //si ya esta inscripto lo dejo, sino lo paso a inscripto
            if(!$preIncr->getEstadoInscripcion()){
                //le asigno el campo inscripcion a 1
                $preIncr->setEstadoInscripcion(1);
                //le creo el correo institucional
                $preIncr->crearCorreoInstitucional();                
            }                                    
            //guardo los cambios en la BD
            $preIncr->save();
        }        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',3);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($ofid))
            ->with('message',"$cabecera Se inscribieron correctamente todos los pre-inscriptos $final");
    }
    
    public function quitarTodasLasInscripciones($ofid)
    {    
        //busco la oferta segun el $id
        $oferta = Oferta::findorFail($ofid);
        //traigo todos los inscriptos de la oferta seleccionada
        $lista = $oferta->inscriptosOferta->all();
        
        //recorro todos los inscriptos los cambio a pre-insciptos
        foreach($lista as $incr){
            //si ya esta inscripto lo paso a pre-inscripto
            if($incr->getEstadoInscripcion()){
                //le asigno el campo inscripcion a 0
                $incr->setEstadoInscripcion(0);
                //vacio la cantidad de notificaciones que se le envió
                $incr->vaciarCantNotificaciones();
                $incr->vaciarCantNotificacionesInscripto();
                //vacio el correo institucional
                $incr->vaciarCorreoInstitucional();
                
                //me fijo si es evento u oferta
                if($oferta->getEsEventoAttribute()){
                    //le asigno el campo asistio a 0
                    $incr->setAsistente(0);
                }elseif($oferta->getEsOfertaAttribute()){
                    //le asigno el campo aprobo a 0
                    $incr->setAprobado(0);
                    //reinicio comision nro.
                    $incr->setComisionNro(0);
                    //reinicio presento_requisitos en FALSE
                    $incr->setRequisitosCompletos(FALSE);
                }
            }                        
            //guardo los cambios en la BD
            $incr->save();
        }        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',2);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($ofid))
            ->with('message',"$cabecera Se quitaron todas las inscripciones correctamente $final");
    }
    
    public function certificarTodosLosAlumnos($ofid)
    {    
        //busco la oferta segun el $id
        $oferta = Oferta::findorFail($ofid);
        //traigo todos los inscriptos de la oferta seleccionada
        $lista = $oferta->inscriptosOferta->all();                
                        
        $tabNro = $oferta->getEsEventoAttribute()?4:15;
        
        //recorro todos los inscriptos los cambio a asistentes/aprobados a quienes no esten en esa condicion
        foreach($lista as $inscr){
            //Me fijo si estoy en Evento o en Ofertas
            if($oferta->getEsEventoAttribute()){
                //si ya esta como asistente lo dejo, sino lo paso a asistente                
                if(!$inscr->getAsistente()){
                    //le asigno el campo asistio a 1
                    $inscr->setAsistente(1);
                }
            }elseif($oferta->getEsOfertaAttribute()){
                //si ya esta como aprobado lo dejo, sino lo paso a aprobado
                if(!$inscr->getAprobado()){
                    //le asigno el campo aprobo a 1
                    $inscr->setAprobado(1);
                }
            }
            //genero un nuevo codigo de validacion para el certificado
            $inscr->setCodigoVerificacion($this->generarCodigoDeVerificacion());
            //guardo los cambios en la BD
            $inscr->save();
        }
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',$tabNro);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($ofid))
            ->with('message',"$cabecera Se inscribieron correctamente todos los pre-inscriptos $final");
    }
    
    public function quitarTodasLasCertificaciones($ofid)
    {    
        //busco la oferta segun el $id
        $oferta = Oferta::findorFail($ofid);
        
        $tabNro = $oferta->getEsEventoAttribute()?3:4;
        
        //Me fijo si es Oferta o Evento y traigo los aprobados/asistentes
        if($oferta->getEsEventoAttribute()){
            //Si es Evento, traigo a los asistentes
            $lista = $oferta->asistentes->all();
            //recorro todos los alumnos y los cambio a insciptos
            foreach($lista as $inscr){
                //le asigno el campo asistente a 0
                $inscr->setAsistente(0);
                //borro el codigo de validacion para el certificado
                $inscr->setCodigoVerificacion(null);
                //vacio la cantidad de notificaciones que se le envió
                $inscr->vaciarCantNotificacionesConCertificado();
                //guardo los cambios en la BD
                $inscr->save();
            }
        }elseif($oferta->getEsOfertaAttribute()){
            //Si es Oferta, traigo a los aprobados
            $lista = $oferta->aprobados->all();
            //recorro todos los alumnos y los cambio a insciptos
            foreach($lista as $inscr){
                //le asigno el campo aprobado a 0
                $inscr->setAprobado(0);
                //borro el codigo de validacion para el certificado
                $inscr->setCodigoVerificacion(null);
                //vacio la cantidad de notificaciones que se le envió
                $inscr->vaciarCantNotificacionesConCertificado();
                //guardo los cambios en la BD
                $inscr->save();
            }
        }
        
        //Seteo el tab_activo de las inscripciones
        Session::set('tab_activa_inscripciones',$tabNro);
        
        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
        $final = $this->getEstiloMensajeFinal();
        return Redirect::route('ofertas.inscripciones.index', array($ofid))
            ->with('message',"$cabecera Se quitaron todas las certificaciones correctamente $final");
    }
}
