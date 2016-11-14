<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/ofertas/{oferta}/inscripcion',  array('uses' => 'OfertasInscripcionesController@create', 'as' => 'ofertas.inscripciones.nueva'));
Route::post('/ofertas/{oferta}/inscripcion', array('uses' => 'OfertasInscripcionesController@store', 'as' => 'ofertas.inscripciones.nueva'));

Route::group(array('before' => 'auth.basic', 'except' => array('ofertas.inscripciones.nueva')), function() {    
       
    Route::get('/salir', array('uses' => 'HomeController@salir'));            
    
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/imprimir', 
      array('uses' => 'OfertasInscripcionesController@imprimir', 'as' => 'ofertas.inscripciones.imprimir')
    );
    
    //agregue esta ruta para cambiar el estado de aprobación del inscripto
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/aprobar', 
      array('uses' => 'OfertasInscripcionesController@cambiarAprobado', 'as' => 'ofertas.inscripciones.cambiarAprobado')
    );
    
    //agregue esta ruta para cambiar el estado de asistencia a un evento del preinscripto
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/asistente', 
      array('uses' => 'OfertasInscripcionesController@cambiarAsistente', 'as' => 'ofertas.inscripciones.cambiarAsistente')
    );
            
    //Ruta para cambiar el listado de pre a inscriptos de una sola vez
    Route::any('/ofertas/{oferta}/inscripciones/cambiar',
      array('uses' => 'OfertasInscripcionesController@cambiarInscripciones', 'as' => 'ofertas.inscripciones.cambiarInscripciones')
    );
    
    //Ruta para cambiar el listado de asistentes de una sola vez
    Route::any('/ofertas/{oferta}/inscripciones/cambiarAsistentes',
      array('uses' => 'OfertasInscripcionesController@cambiarAsistentes', 'as' => 'ofertas.inscripciones.cambiarAsistentes')
    );
    
    //agregue esta ruta para cambiar el estado de los requisitos del inscripto
    Route::any('/ofertas/{oferta}/inscripciones/requisitos', 
      array('uses' => 'OfertasInscripcionesController@cambiarEstadoDeRequisitos', 'as' => 'ofertas.inscripciones.cambiarEstadoDeRequisitos')
    );
    
    //agregue esta ruta para sumar un nro en la comision del inscripto
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/sumar', 
      array('uses' => 'OfertasInscripcionesController@sumarComision', 'as' => 'ofertas.inscripciones.sumarComision')
    );
    
    //agregue esta ruta para restar un nro en la comision del inscripto
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/restar', 
      array('uses' => 'OfertasInscripcionesController@restarComision', 'as' => 'ofertas.inscripciones.restarComision')
    );
    
    //agregue esta ruta para enviar los mails institucionales a los inscriptos
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/notificar', 
      array('uses' => 'OfertasInscripcionesController@enviarMailInstitucional', 'as' => 'ofertas.inscripciones.enviarMailInstitucional')
    );
    
    //agregue esta ruta para enviar los mails de inscripcion a los preinscriptos
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/notificarinscripcion', 
      array('uses' => 'OfertasInscripcionesController@enviarMailNuevoInscripto', 'as' => 'ofertas.inscripciones.enviarMailNuevoInscripto')
    );

    Route::post('/ofertas/{oferta}/inscripciones/{inscripcion}/requisito', 
      array('uses' => 'OfertasInscripcionesController@presentarRequisito', 'as' => 'ofertas.inscripciones.requisito_presentar')
    );

    Route::delete('/ofertas/{oferta}/inscripciones/{inscripcion}/requisito/{requisito}', 
      array('uses' => 'OfertasInscripcionesController@borrarRequisito', 'as' => 'ofertas.inscripciones.requisito_borrar')
    );

    Route::get('/ofertas/{oferta}/vermail', 
      array('uses' => 'OfertasController@verMail', 'as' => 'ofertas.vermail')            
    );    
    
    Route::post('/ofertas/{oferta}/agregarcapacitadores',
      array('uses' => 'OfertasController@agregarCapacitadores', 'as' => 'ofertas.agregarcapacitadores')
    );
    
    Route::delete('/ofertas/{oferta}/limpiar', 
      array('uses' => 'OfertasInscripcionesController@limpiarPreinscripciones', 'as' => 'ofertas.inscripciones.limpiar')
    );
    
    //ruta para finalizar la oferta
    Route::get('/ofertas/{oferta}/finalizar', 
      array('uses' => 'OfertasController@finalizarOferta', 'as' => 'ofertas.finalizar')
    );
    
    //ruta para desfinalizar la oferta
    Route::get('/ofertas/{oferta}/desfinalizar', 
      array('uses' => 'OfertasController@desfinalizarOferta', 'as' => 'ofertas.desfinalizar')
    );
    
    //agregue esta ruta para enviar el certificado en PDF al mail del capacitador
    Route::get('/ofertas/{oferta}/enviarMailCertificadoCapacitador', 
      array('uses' => 'OfertasController@enviarMailCertificadoCapacitador', 'as' => 'ofertas.enviarMailCertificadoCapacitador')
    );
    
    //agregue esta ruta para enviar el certificado en PDF al mail del alumno
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/enviarMail', 
      array('uses' => 'OfertasInscripcionesController@enviarMailCertificado', 'as' => 'ofertas.inscripciones.enviarMailCertificado')
    );
    
    //agregue esta ruta para enviar todos los certificados automaticamente al mail de los alumnos
    Route::get('/ofertas/{oferta}/enviarCertificados', 
      array('uses' => 'OfertasController@enviarMailsConCertificados', 'as' => 'ofertas.enviarMailsConCertificados')
    );
    
    // especifico que todos los controladores para las Ofertas estan en OfertasController
    Route::resource('ofertas', 'OfertasController');
    // especifico que todos los controladores para las Inscripciones estan en OfertasInscripcionesController
    Route::resource('ofertas.inscripciones', 'OfertasInscripcionesController');
    // especifico que todos los controladores para las Requisitos estan en RequisitosController
    Route::resource('ofertas.requisitos', 'RequisitosController');
    // especifico que todos los controladores para los Tipos de DNI estan en TipoDocumentosController
    Route::resource('tipos_documento', 'TipoDocumentosController');
    // especifico que todos los controladores para las Localidades estan en LocalidadesController
    Route::resource('localidades', 'LocalidadesController');
    // especifico que todos los controladores para las Titulaciones estan en TitulacionesController
    Route::resource('titulacion', 'TitulacionController');
    // especifico que todos los controladores para el Personal estan en PersonalController
    Route::resource('personal', 'PersonalController');
    // especifico que todos los controladores para los Capacitadores estan en CapacitadorController
    Route::resource('capacitador', 'CapacitadorController');
    
            
    //rutas para ver los usuarios
    Route::resource('usuarios', 'UsuariosController');
    Route::get('/logout', array('uses' => 'HomeController@logout'));
    
});

 Route::get('/inscripcion_ok', function() {
     return View::make('inscripciones.ok');
 });
    
 Route::get('/', array('uses' => 'HomeController@bienvenido'));
 Route::get('/login', array('uses' => 'HomeController@login'));
 Route::post('/login', array('uses' => 'HomeController@acceso'));

 Route::any('/verificar-certificado', array('uses' => 'HomeController@verificarCertificado'));

