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
    
    //agregue esta ruta para cambiar el estado de la inscripcion
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/cambiar', 
      array('uses' => 'OfertasInscripcionesController@cambiarEstado', 'as' => 'ofertas.inscripciones.cambiarEstado')
    );
    
    //agregue esta ruta para cambiar el estado de los requisitos del inscripto
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/requisitos', 
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

    Route::post('/ofertas/{oferta}/inscripciones/{inscripcion}/requisito', 
      array('uses' => 'OfertasInscripcionesController@presentarRequisito', 'as' => 'ofertas.inscripciones.requisito_presentar')
    );

    Route::delete('/ofertas/{oferta}/inscripciones/{inscripcion}/requisito/{requisito}', 
      array('uses' => 'OfertasInscripcionesController@borrarRequisito', 'as' => 'ofertas.inscripciones.requisito_borrar')
    );

    Route::get('/ofertas/{oferta}/vermail', 
      array('uses' => 'OfertasController@verMail', 'as' => 'ofertas.vermail')            
    );
            
    Route::resource('ofertas', 'OfertasController');
        
    Route::resource('ofertas.inscripciones', 'OfertasInscripcionesController');

    Route::resource('ofertas.requisitos', 'RequisitosController');

    Route::resource('tipos_documento', 'TipoDocumentosController');
    Route::resource('localidades', 'LocalidadesController');
            
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


