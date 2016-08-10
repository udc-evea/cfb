<?php

class OfertasController extends BaseController {

	/**
	 * oferta Repository
	 *
	 * @var oferta
	 */
	protected $oferta;

	public function __construct(Oferta $oferta)
	{
		$this->oferta = $oferta;                
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ofertas  = Oferta::cursos()->get();
                $carreras = Oferta::carreras()->get();
                $eventos  = Oferta::eventos()->get();
                
                foreach ($ofertas as $of) { //agrgado por nico
                    $of->setCerrarOferta();
                }
                foreach ($carreras as $ca) { //agrgado por nico
                    $ca->setCerrarOferta();
                }
                foreach ($eventos as $ev) { //agrgado por nico
                    //$ev->setCerrarOferta();
                    $ev->setCerrarEvento();
                }
                
                //agegado por nico
                $userId = Auth::user()->id;
                $userPerfil = Auth::user()->perfil;
                $userName = Auth::user()->nombreyapellido;
                                                                           
                $preinscCarr = DB::table('inscripcion_carrera')->count();                
                $inscCarr = DB::table('inscripcion_carrera')->where('estado_inscripcion','=',1)->count();
                $preinscOfe = DB::table('inscripcion_oferta')->count();
                $inscOfe = DB::table('inscripcion_oferta')->where('estado_inscripcion','=',1)->count();
                $preinscEve = DB::table('inscripcion_evento')->count();
                $inscEve = DB::table('inscripcion_evento')->where('estado_inscripcion','=',1)->count();
                
                /*
                
                Carreras
                SELECT oferta_formativa.id, oferta_formativa.nombre, count(inscripcion_carrera.id), oferta_formativa.anio from oferta_formativa 
                inner JOIN inscripcion_carrera ON oferta_formativa.id = inscripcion_carrera.oferta_formativa_id
                where tipo_oferta = 1
                group by oferta_formativa.id
                
                Ofertas
                SELECT oferta_formativa.id, oferta_formativa.nombre, count(inscripcion_oferta.id), oferta_formativa.anio from oferta_formativa 
                inner JOIN inscripcion_oferta ON oferta_formativa.id = inscripcion_oferta.oferta_formativa_id
                where tipo_oferta = 2
                group by oferta_formativa.id
                
                Eventos
                SELECT oferta_formativa.id, oferta_formativa.nombre, count(inscripcion_evento.id), oferta_formativa.anio from oferta_formativa 
                inner JOIN inscripcion_evento ON oferta_formativa.id = inscripcion_evento.oferta_formativa_id
                where tipo_oferta = 3
                group by oferta_formativa.id
                
                 */
                //obtengo el ID, Nombre, Año y cantidad de Preinscriptos de todas las carreras
                /*$Carreras = DB::table('oferta_formativa')
                        ->select(DB::raw("count(inscripcion_carrera.id) as total"))
                        ->join('inscripcion_carrera','oferta_formativa.id','=','inscripcion_carrera.oferta_formativa_id')
                        ->addselect('oferta_formativa.id', 'oferta_formativa.nombre', 'oferta_formativa.anio')
                        ->where('tipo_oferta','=','1')
                        ->groupBy('oferta_formativa.id')
                        ->orderBy('oferta_formativa.anio','desc')
                        ->get();
                */
                /*$totalPreinscr = array(
                    'carreras' => $preinscCarr, 
                    'eventos' => $preinscEve,
                    'ofertas' => $preinscOfe);
                $totalInscr = array(
                    'carreras' => $inscCarr, 
                    'eventos' => $inscEve,
                    'ofertas' => $inscOfe);
                */
                /*$preUDC = $preinscCarr + $preinscEve + $preinscOfe;
                $insUDC = $inscCarr + $inscEve + $inscOfe;
                */
                $personal = Personal::all();
                $roles = RolCapacitador::all();
                
                $exp = Request::get('exp');
                if (!empty($exp)) {
                    switch ($exp) {
                        case parent::EXPORT_PDFCAP:
                            //obtengo los datos de la oferta y el capacitador
                            $id_oferta = Request::get('ofid');
                            $oferta = $this->oferta->find($id_oferta);
                            //traigo solo los datos del CAPACITADOR para exportar a pdf
                            $id_capacitador = Request::get('cap');
                            $capacitador = DB::table('capacitador')->find($id_capacitador);
                            $capacPersonal = Personal::find($capacitador->personal_id);
                            Session::set('cap', $capacitador);
                            //Session::set('of', $oferta);
                            return $this->exportarPDF($oferta->nombre." - Certificado_del_Capacitador - ".$capacPersonal->apellido."_".$capacPersonal->nombre, $oferta, 'ofertas.certificado');
                        case parent::EXPORT_XLSCAPES:
                            $id_oferta = Request::get('ofid');
                            $oferta = DB::table('oferta_formativa')->where('id','=',$id_oferta)->get();
                            $capAux = Oferta::obtenerCapacitadoresDeLaOferta($id_oferta);
                            $capacitadores = $this->datosCapacitadores($capAux);
                            Session::set('capacitadores', $capacitadores);
                            return $this->exportarXLS($oferta[0]->nombre."_Capacitadores", $oferta, 'ofertas.capacitadores');
                        case parent::EXPORT_PDFCAPES:
                            $id_oferta = Request::get('ofid');
                            $oferta = DB::table('oferta_formativa')->where('id','=',$id_oferta)->get();
                            $capAux = Oferta::obtenerCapacitadoresDeLaOferta($id_oferta);
                            $capacitadores = $this->datosCapacitadores($capAux);
                            Session::set('capacitadores', $capacitadores);
                            return $this->exportarPDF($oferta[0]->nombre."_Capacitadores", $oferta, 'ofertas.capacitadores');
                    }
                }
                
                if(!Session::has('tab_activa')){
                    Session::set('tab_activa', 'carreras');
                }
                                
		return View::make('ofertas.index', compact('ofertas', 'carreras', 'eventos'))
                        ->with('userId',$userId)
                        ->with('userPerfil',$userPerfil)
                        ->with('userName',$userName)
                        //->with("TotalPreinscriptos",$totalPreinscr)
                        //->with("TotalInscriptos",$totalInscr)
                        //->with("preUDC",$preUDC)
                        //->with("insUDC",$insUDC)
                        //->with("Carreras",$Carreras)
                        ->with('personal',$personal)                        
                        ->with('roles',$roles)
                ;
	}
        
        private function datosCapacitadores($capAux){
            $datosCapacitadores = array();
            $i=0;
            foreach($capAux as $c){
                $datosCapacitadores[$i]['personal'] = Personal::find($c->personal_id);
                $datosCapacitadores[$i]['rol'] = RolCapacitador::find($c->rol_id);
                $i++;
            }
            return $datosCapacitadores;
        }

        /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipos_oferta = TipoOferta::orderBy('descripcion')->get();
                $titulaciones = Titulacion::orderBy('id')->get();                

		return View::make('ofertas.create')
                        ->with(compact('tipos_oferta'))
                        ->with('titulaciones',$titulaciones);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->oferta->agregarReglas($input);
                $fechaFinOferta = Input::get('fecha_fin_oferta');
                if($fechaFinOferta != null){
                    $this->oferta->agregarReglas2($input);
                }
                
		$validation = Validator::make($input, Oferta::$rules);                                
                
		if ($validation->passes()){
                  $this->oferta = $this->oferta->create($input);
                    
                  //agregado por nico
                  //Busco el usuario actual en la BD y obtengo el ID
                  $userId = Auth::user()->id;
                  //agrego el ID del usuario en el campo user_id_creador de la oferta
                  $this->oferta->user_id_creador = $userId;
                  //agrego los datos de la modificación
                  $this->oferta->user_id_modif = $userId;
                  $this->oferta->fecha_modif = date('Y-m-d');
                  //Si es carrera: guardo la fecha_fin_oferta en NULL
                  if($this->oferta->getEsCarreraAttribute()){
                      $this->oferta->setFechaFinOfertaAttribute(null);
                  }
                  //guardo los cambios antes de redirigir
                  $this->oferta->save();

                  //coloco en la sesion a que tipo de oferta entre, asi puedo regresar al mismo
                  Session::set('tab_activa', $this->oferta->tipo_oferta);
                  
                  //return Redirect::route('ofertas.edit', $this->oferta->id)
                  $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                  $final = $this->getEstiloMensajeFinal();
                  return Redirect::route('ofertas.index')
			->withInput()			
			->with('message', "$cabecera Oferta creada exitosamente!! $final");
		}

		return Redirect::route('ofertas.create')
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
		return Redirect::action('ofertasInscripcionesController@create', $id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$oferta = $this->oferta->find($id);
                
                //coloco en la sesion a que tipo de oferta entre, asi puedo regresar al mismo
                Session::set('tab_activa', $oferta->tipo_oferta);
                
		if (is_null($oferta))
		{
			return Redirect::route('ofertas.index');
		}
                
                $cap = $oferta->obtenerCapacitadoresDeLaOferta($id);
		$tipos_oferta = TipoOferta::all();
                $titulaciones = Titulacion::orderBy('id')->get();
                $personal = Personal::all();
                $roles = RolCapacitador::all();
		return View::make('ofertas.edit', compact('oferta', 'tipos_oferta'))
                    ->with('titulaciones',$titulaciones)
                    ->with('capacitadores',$cap)
                    ->with('personal',$personal)
                    ->with('roles',$roles);
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
                $fechaFinOferta = Input::get('fecha_fin_oferta');
                if($fechaFinOferta != null){
                    $this->oferta->agregarReglas2($input);
                }
                
		$validation = Validator::make($input, Oferta::$rules);
                
		if ($validation->passes()){
			$oferta = $this->oferta->find($id);
                        $oferta->fill($input);
                        //agregado por nico
                        //Busco el usuario actual en la BD y obtengo el ID
                        $userId = Auth::user()->id;                
                        //agrego los datos de la modificación
                        $oferta->user_id_modif = $userId;
                        $oferta->fecha_modif = date('Y-m-d');
                        //Si es carrera: guardo la fecha_fin_oferta en NULL
                        if($oferta->getEsCarreraAttribute()){
                            $oferta->setFechaFinOfertaAttribute(null);
                        }
                        if($fechaFinOferta == null){
                            $oferta->setFechaFinOfertaAttribute(NULL);
                        }
                        //guardo los cambios                        
			$oferta->save();
			
                        $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                        $final = $this->getEstiloMensajeFinal();
                        return Redirect::route('ofertas.index')
                                ->with('message', "$cabecera Se guardaron los cambios correctamente!. $final");
		}

                $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
                $final = $this->getEstiloMensajeFinal();
		return Redirect::route('ofertas.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', "$cabecera Hay errores en la validación de los datos!. $final");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$oferta = $this->oferta->find($id);                                
                
                //coloco en la sesion a que tipo de oferta entre, asi puedo regresar al mismo
                Session::set('tab_activa', $oferta->tipo_oferta);
                
                if(!$oferta) {
                    $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
                    $final = $this->getEstiloMensajeFinal();
                    return Redirect::route('ofertas.index')
                        ->with('message', "$cabecera No se pudo encontrar la oferta especificada. $final");
                }
                
                //borro todos los capacitadores de esa oferta
                $this->eliminarCapacitadores($oferta->id);
                //borro la oferta de la Base de datos                
                $oferta->delete();
                //devuelvo mje para el aire
                $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                $final = $this->getEstiloMensajeFinal();
		return Redirect::route('ofertas.index')
                        ->with('message', "$cabecera Se eliminó el registro correctamente!. $final");
	}

	/**
	 * Muestra el correo a enviar.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function verMail($id)
	{
		$oferta = $this->oferta->find($id);
                //$insc = new InscripcionEvento();
		if (is_null($oferta)) {
                    return Redirect::route('ofertas.index');
		}

		//return View::make($oferta->getVistaMail(), compact('oferta','insc'));
                return View::make($oferta->getVistaMail(), compact('oferta'));
	}                
        
        /**
	 * Guardo el/los Capacitador/es de la Oferta
	 *
	 * 
	 * @return Response
	 */
	public function agregarCapacitadores()
	{
            if(Input::has('listaCapacitadores')){
                //obtengo del POST la variable de todos los capacitadores agregados
                $lista = Input::get('listaCapacitadores');
                //separo los capacitadores en un array asociativo                
                $size = sizeof($lista); $i=0;$j=1;
                //recorro el array listaCapacitadores y divido la información
                while ($j<$size){
                    //obtengo el campo oferta_id y lo guardo en el array asociativo
                    $listaAsociativo[$i]['oferta_id'] = $lista[0];
                    //obtengo el campo personal_id y lo guardo en el array asociativo
                    $listaAsociativo[$i]['personal_id'] = $lista[$j];
                    //obtengo el campo rol_id y lo guardo en el array asociativo
                    $listaAsociativo[$i]['rol_id'] = $lista[$j+1];
                    //genero el código de verificación para el certificado del Capacitador
                    $listaAsociativo[$i]['codigo_verificacion'] = $this->generarCodigoDeVerificacion();
                    //incremento las variables utilizadas: $j para sacar la info de la lista, e $i para el array asociativo
                    $j=$j+2; $i++;
                }
                
                //coloco en la sesion a que tipo de oferta entre, asi puedo regresar al mismo
                Session::set('tab_activa', $this->oferta->tipo_oferta);
                
                //Session::put('listaCapacitadores',$listaAsociativo);
                //Session::put('lista',$lista);
                try{
                    //recorro el array asociativo
                    foreach ($listaAsociativo as $cap){
                        //guardo la info en la Base de datos
                        Capacitador::create($cap);
                    }
                    $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                    $final = $this->getEstiloMensajeFinal();
                                        
                    //redirijo a Ofertas Index
                    return Redirect::route('ofertas.index')
                        ->with('message', "$cabecera Se agregaron correctamente los capacitadores.$final");
                }  catch (PDOException $e){
                    $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
                    $final = $this->getEstiloMensajeFinal();
                    return Redirect::route('ofertas.index')
                        ->with('message', "$cabecera Error en la reación de/los capacitador/es. $final");
                }   
            }
            $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.index')
                    ->with('message', "$cabecera La validación de los datos del Capacitador no pasó.$final");
	}
        
        public function eliminarCapacitadores($oferta_id) {
            //obtengo los capacitadores de la oferta
            $capacitadores = DB::table('capacitador')->where('oferta_id','=',$oferta_id)->get();
            //recorro los capacitadores y los elimino
            foreach ($capacitadores as $cap){
                DB::table('capacitador')->where('id','=',$cap->id)->delete();
            }
            //regreso a eliminar la oferta
            return ;
        }
        
        public function finalizarOferta($id_oferta){
            //busco la oferta según el ID ingresado
            $oferta = $this->oferta->findOrFail($id_oferta);
            
            //seteo la Oferta como FINALIZADA (no se puede modificar nada)
            $oferta->setFinalizada(1);
            $oferta->save();
            
            //coloco en la sesion a que tipo de oferta entre, asi puedo regresar al mismo
            Session::set('tab_activa', $oferta->tipo_oferta);
            
            //vuelvo al index con un  mensaje exitoso
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.index')
                    ->with('message', "$cabecera La Oferta: $oferta->nombre se finalizó de manera correcta! No se pueden realizar más cambios en ella.$final");
        }
        
        public function desfinalizarOferta($id_oferta){
            //busco la oferta según el ID ingresado
            $oferta = $this->oferta->findOrFail($id_oferta);
            
            //seteo la Oferta como DESFINALIZADA (se puede modificar)
            $oferta->setFinalizada(0);
            $oferta->save();
            
            //coloco en la sesion a que tipo de oferta entre, asi puedo regresar al mismo
            Session::set('tab_activa', $oferta->tipo_oferta);
            
            //vuelvo al index con un mensaje exitoso
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.index')
                    ->with('message', "$cabecera La Oferta: $oferta->nombre se desfinalizó de manera correcta! Ya se pueden realizar cambios en ella.$final");
        }
        
        public function enviarMailsConCertificados($ofid)
        {
            //busco la oferta en la BD
            $oferta = Oferta::findOrFail($ofid);

            //si es Oferta traigo los aprobados
            if($oferta->getEsOfertaAttribute()){
                $inscripciones = $oferta->aprobados->all();
            }elseif($oferta->getEsEventoAttribute()){
                //si es Evento traigo los Asistentes
                $inscripciones = $oferta->asistentes->all();
            }

            //recorro todos los alumnos (inscripciones) para generar el PDF y enviarlo a su mail
            foreach ($inscripciones as $inscripto) {
                
                //busco los datos de los inscriptos
                $insc_class = $oferta->inscripcionModelClass;
                $rows = $insc_class::findOrFail($inscripto->id);
                
                //creo el nomre del archivo pdf
                $filename = $ofid.$rows->id;
                //creo el certificado
                $html = View::make('inscripciones.'.$oferta->view.'.certificado', compact('rows'));
                //Creo el pdf y lo guardo en la carpeta /public/pdfs
                $pdf = new \Thujohn\Pdf\Pdf();                
                $content = $pdf->load($html, 'A4', 'landscape')->output();
                $path_to_pdf = public_path("pdfs/$filename.pdf");
                File::put($path_to_pdf, $content);
                
                //envío los mails que se agregaron en public/pdfs
                try{
                    $view_mail = View::make('emails.ofertas.envio_certificado', compact('rows','oferta'));
                    //Envío el mail al mail institucional y al personal
                    Mail::queue($view_mail,compact('rows','oferta'), function ($message) use ($rows,$filename){
                        $message->to($rows->email)->cc($rows->email_institucional)->subject('Certificado UDC');
                        $message->attach("pdfs/$filename.pdf", array('as'=>'Certificado UDC.pdf', 'mime'=>'application/pdf'));
                    });
                    //incremento la cantidad de veces que se le envió el mail con el certificado
                    $rows->seEnvioNotificacionConCertificado();
                    
                } catch (Swift_TransportException $e) {
                    Log::info("No se pudo enviar correo a " . $rows->apellido.','.$rows->nombre." <" . $rows->email.">");
                }
            }
            
            
            //devuelvo un mje exitoso y regreso a la inscripcion de la oferta
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.inscripciones.index', array($oferta->id))
                            ->withoferta($oferta)
                            ->with('message', "$cabecera Los Certificados se enviarán automaticamente durante los próximo minutos. Mientras puede seguir utilizando el sistema. $final");
        }
}
