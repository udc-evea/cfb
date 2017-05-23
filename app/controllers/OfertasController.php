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
                    $of->setCerrarOfertaOEvento();
                }
                foreach ($carreras as $ca) { //agrgado por nico
                    $ca->setCerrarCarrera();
                }
                foreach ($eventos as $ev) { //agrgado por nico
                    //$ev->setCerrarOferta();
                    $ev->setCerrarOfertaOEvento();
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
		//$input = Input::all();
                $input = Input::except('cabeceraDocAPresentar','1DocAPresentar','2DocAPresentar','3DocAPresentar','4DocAPresentar');
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
		//$input = array_except(Input::all(), '_method');
                $input = Input::except('cabeceraDocAPresentar','1DocAPresentar','2DocAPresentar','3DocAPresentar','4DocAPresentar', '_method');
                $fechaFinOferta = Input::get('fecha_fin_oferta');
                $imagenMailBienvenida = Input::get('mail_bienvenida_file_name');
                $imagenCertBaseAlum = Input::get('cert_base_alum_file_name');
                $imagenCertBaseCapacitadores = Input::get('cert_base_cap_file_name');
                if($fechaFinOferta != null){
                    $this->oferta->agregarReglas2($input);
                }
                
		$validation = Validator::make($input, Oferta::$rules);
                
		if ($validation->passes()){
                        //busco los datos de la oferta en la Base de Datos
			$oferta = $this->oferta->find($id);
                        //lo completo con los datos ingresados en el formulario
                        $oferta->fill($input);
                        //comparo los campos de Oferta e Input para ver si hay cambios en los campos de imagenes
                        //comparo el campo de la imagen del mail
                        if(($imagenMailBienvenida !== $oferta->mail_bienvenida_file_name)||($imagenMailBienvenida == '')){                            
                            $this->borrarDirectorio('mail_bienvenidas', $oferta->id);
                        }
                        //comparo el campo de la imagen del certificado_base_alumnos
                        if(($imagenCertBaseAlum !== $oferta->cert_base_alum_file_name)||($imagenCertBaseAlum == '')){
                            $this->borrarDirectorio('cert_base_alums', $oferta->id);
                        }
                        //comparo el campo de la imagen del certificado_base_capacitadores
                        if(($imagenCertBaseCapacitadores !== $oferta->cert_base_cap_file_name)||($imagenCertBaseCapacitadores == '')){
                            $this->borrarDirectorio('cert_base_caps', $oferta->id);
                        }
                        
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
                //borro cualquier imagen que se haya cargado a la Oferta
                $this->eliminarImagenesDeOferta($oferta);
                //borro la oferta de la Base de datos
                $oferta->delete();
                //devuelvo mje para el aire
                $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
                $final = $this->getEstiloMensajeFinal();
		return Redirect::route('ofertas.index')
                        ->with('message', "$cabecera Se eliminó el registro correctamente!. $final");
	}
        
        private function eliminarImagenesDeOferta($of) { //recibo la Oferta a borrar
            //me fijo si tiene imagenes cargadas para el certificado de alumnos
            $cert_base_alum = asset($of->cert_base_alum->url());
            //me fijo si tiene imagenes cargadas para el certificado de capacitadores
            $cert_base_cap = asset($of->cert_base_cap->url());
            //me fijo si tiene imagenes cargadas para el mail de preinscripcion
            $mail_bienv = asset($of->mail_bienvenida->url());
            //Me fijo si hay imagenes de mail de bienvenida
            if(@getimagesize($mail_bienv)){
                $this->borrarDirectorio('mail_bienvenidas', $of->id);
            }
            //Me fijo si hay imagenes de certificado_base_alumnos
            if(@getimagesize($cert_base_alum)){
                $this->borrarDirectorio('cert_base_alums', $of->id);
            }
            //Me fijo si hay imagenes de certificado_base_capacitadores
            if(@getimagesize($cert_base_cap)){
                $this->borrarDirectorio('cert_base_caps', $of->id);
            }
        }

        private function borrarDirectorio($dir, $ofId) {
            //obtengo el nombre de la carpeta de la Oferta a borrar
            $nombreCarpeta = $this->nombreDirectorioCorrecto($ofId);
            //armo el nombre del directorio de la oferta a Borrar
            $nomDirectorio = "system/Oferta/$dir/000/000/$nombreCarpeta";
            //armo el nombre del directorio "original" dentro de la carpeta de la Oferta a borrar
            $nomDirectorio_original = "system/Oferta/$dir/000/000/$nombreCarpeta/original";
            if((file_exists($nomDirectorio))&&(file_exists($nomDirectorio_original))){
                //borro el archivo dentro de la carpeta
                $archivos = scandir($nomDirectorio_original);//hace una lista de archivos del directorio "original"
                $num = count($archivos); //los cuenta
                //los borramos
                for($i=2; $i<$num; $i++){
                    unlink($nomDirectorio_original.'/'.$archivos[$i]);
                }
                //borramos le directorio "original"
                rmdir($nomDirectorio_original);
                //borro el directorio de la Oferta a borrar
                rmdir($nomDirectorio);
            }
        }

        private function nombreDirectorioCorrecto($id_oferta) {
            if($id_oferta < 10){
                return "00".$id_oferta;
            }elseif($id_oferta < 100){
                return "0".$id_oferta;
            }elseif($id_oferta < 1000){
                return $id_oferta;
            }
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
        
        public function enviarMailCertificadoCapacitador($capid)
        {      
            //busco la oferta en la BD
            $capacitador = Capacitador::find($capid);
            $oferta = Oferta::findOrFail($capacitador->oferta_id);
            //busco los datos del capacitador
            $capacRol = RolCapacitador::find($capacitador->rol_id);
            $capacPersonal = Personal::find($capacitador->personal_id);
            //$capacPersonal->getApellidoYNombre();
            //$capacRol->rol;            
            //Creo la variable $rows para cargar el certificado            
            $rows = $oferta;

            //creo el nomre del archivo pdf
            $filename = "capacitador_".$oferta->id."_".$capacPersonal->getApellido()."_".$capacPersonal->getNombre();
            //creo el certificado
            Session::set('cap',$capacitador);
            $html = View::make('ofertas.certificado', compact('rows'));        

            //Creo el pdf y lo guardo en la carpeta /public/pdfs
            $pdf = new \Thujohn\Pdf\Pdf();
            $content = $pdf->load($html, 'A4', 'landscape')->output();
            $path_to_pdf = public_path("pdfs/$filename.pdf");
            File::put($path_to_pdf, $content);

            try{
                //Envío el mail al mail institucional y al personal
                Mail::send('emails.ofertas.envio_certificado_capacitador',compact('rows','oferta','capacPersonal','capacRol'), function ($message) use ($rows,$filename,$capacPersonal,$capacRol){
                    $message->to($capacPersonal->getEmail())->subject('Certificado UDC');
                    $message->attach("pdfs/$filename.pdf", array('as'=>'Certificado UDC.pdf', 'mime'=>'application/pdf'));
                });
            } catch (Swift_TransportException $e) {
                //Log::info("No se pudo enviar correo a " . $capacPersonal->apellido.','.$capacPersonal->nombre." <" . $capacPersonal->email.">");
                Log::info("No se pudo enviar correo al capacitador ");
                //devuelvo un mje erroneo y regreso a la inscripcion de la oferta
                $cabecera = $this->getEstiloMensajeCabecera('danger', 'glyphicon glyphicon-warning-sign');
                $final = $this->getEstiloMensajeFinal();
                return Redirect::route('ofertas.index')
                                ->withoferta($oferta)
                                //->with('message', "$cabecera No se pudo enviar el Certificado de $capacPersonal->getNombre(), $capacPersonal->getApellido(). Intente nuevamente más tarde. $final");
                                ->with('message', "$cabecera No se pudo enviar el Certificado del capacitador. Intente nuevamente más tarde. $final");
            }                        

            //incremento la cantidad de veces que se le envió el mail con el certificado
            //$rows->seEnvioNotificacionConCertificado();

            //devuelvo un mje exitoso y regreso a la inscripcion de la oferta
            $cabecera = $this->getEstiloMensajeCabecera('success', 'glyphicon glyphicon-ok');
            $final = $this->getEstiloMensajeFinal();
            return Redirect::route('ofertas.index')
                            ->withoferta($oferta)
                            //->with('message', "$cabecera Se envió el Certificado de $capacPersonal->getNombre(), $capacPersonal->getApellido() correctamente. $final");
                            ->with('message', "$cabecera Se envió el Certificado del capacitador correctamente. $final");
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
        
        public function importarOfertaDeArchivo()
        {
            $MjeError = NULL;
            $post = false;
            //me fijo si la vista se carga por GET
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                //cargo la vista con los argumentos necesarios
                return View::make('ofertas.importarOfertaArchivo')
                        ->with('post',$post)
                        ->with('MjeError',$MjeError);
            }else{
                // Me fijo si es POST y si el $archivo es <> NULL
                // realizo los pasos necesarios para la importación y lo guardo 
                // en un array asociativo para mostrar por pantalla y luego
                // decidir si se importa a la base o no
                
                //$coloco la variable $post en TRUE para la condicion de la vista
                $post = true;
                //obtengo la ubicación real del archivo importado
                $realPath = Input::file('archivo')->getRealPath();
                //Si el archivo existe, leo su contenido. Sino, muestro error.
                if ($realPath != NULL) {
                    //obtengo todos los campos (columnas) con la información del archivo Excel
                    $todoElInput = Input::all();                    
                    $datosArchivo = Excel::load($realPath, function($reader) {})->get();
                    //obtengo solo los datos de las columnas del archivo
                    $datos = $this->obtenerCabecerayDatos($datosArchivo);
                    //verifico si los datos cargados tienen algún error de validación
                    $MjeError = $this->verificarDatosValidos($datos);
                    //cargo la vista con los datos necesarios                    
                    return View::make('ofertas.importarOfertaArchivo')
                            ->with('post',$post)
                            ->with('datos',$datos)
                            ->with('MjeError',$MjeError);
                }else{
                    $MjeError .= "<li> Verficar que el archivo contiene 1 sola fila con los datos de la Oferta a importar.</li>";
                    return View::make('ofertas.importarOfertaArchivo')
                        ->with('post',$post)
                        ->with('MjeError',$MjeError);
                }
            }
            
        }
        
        private function obtenerCabecerayDatos($datosArchivo)
        {   //funcion para obtener solo los datos de las columnas del archivo leido
            
            if ((!empty($datosArchivo))&&($datosArchivo->count()==1)){
                //defino unas variables de ayuda
                $datos = array();
                $soloDatos = array();
                $i = 0;
                
                //recorro fila por fila que contienen los datos (deberia
                foreach ($datosArchivo as $fila) {
                        //echo "<br> - Fila: ".$fila;
                        /*if($fila->count() != $cantCamposOferta){
                            $datosCSV = array();                                
                            return null;
                        }*/
                        
                        foreach ($fila as $campo => $celda){
                            $datos[$i][$campo] = $celda;
                            array_push($soloDatos,$celda);
                            //echo "<br> - campo: $campo - valor: $celda";
                        }
                        $i++;
                        //array_push($arrayCeldas, $i);
                        //echo "<br> - celdas: ".$celdas;
                        //echo "<br> - cant: ".$celdas->count();
                        //echo "<br>";
                        //var_dump($value);
                }
                
                //echo "<br> sub[0][otro]: ".$datosOfertaCSV[0]['cam01']."<br>";
                //$fila1 = $datosOfertaCSV[0];
                //$cabFila1 = array_keys($fila1);
                //echo "<br> cabecera_xls: ".$cabFila1."<br>";
                //var_dump($datosCSV);
                //return $datosCSV;
                return $soloDatos;

            }else{
                $datos = array();
                return null;
            }
        }
        
        private function verificarDatosValidos($datos) 
        { //funcion que verifica algunos datos de la oferta
            
            //defino las variables a utilizar
            $cantColumnas = sizeof($datos);        
            $nombre = $datos[0];
            $anio = $datos[1];
            $inicioInsc = $datos[2];
            $finInsc = $datos[3];
            $finOferta = $datos[4];
        
            $mje = "";
            if($cantColumnas!=5){
                $mje .= "<li> La cantidad de columnas no es 5. Revisar el archivo nuevamente!.</li>";
                //devuelvo los mjes de error
                return $mje;
            }
            if(strlen($nombre)<10){
                $mje .= "<li> El nombre de la Oferta debe contener al menos 10 caracteres.</li>";
            }
            if(strlen($anio)<4){
                $mje .= "<li> El año de la Oferta no puede ser Nulo o menor a 4 digitos.</li>";
            }
            if(($anio < 2010) || ($anio > (date('Y')+1) )){
                $mje .= "<li> El año de la Oferta no puede ser menor a 2010, ni mayor a ".(date('Y')+1)."</li>";
            }
            if($inicioInsc == NULL){
                $mje .= "<li> La fecha de Inicio de las inscripciones no puede ser nulo.</li>";
            }
            if($finInsc == null){
                $mje .= "<li> La fecha de Fin de las inscripciones no puede ser nulo.</li>";
            }
            if( $inicioInsc >= $finInsc ){
                $mje .= "<li> La fecha de inicio de inscripciones no puede ser mayor o igual a la fecha de fin de inscripciones.</li>";
            }
            if($finOferta == null){
                $mje .= "<li> La fecha de Fin de la Oferta no puede ser nulo.</li>";
            }
            if( $finOferta <= $finInsc ){
                $mje .= "<li> La fecha de Fin de la Oferta no puede ser menor o igual a la fecha de fin de las inscripciones.</li>";
            }
            //devuelvo los mjes de error
            return $mje;
        }
}
