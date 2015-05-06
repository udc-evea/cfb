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
    /*Route::get('/', function() {
        return Redirect::route('ofertas.index');        
    });*/
    
   
    Route::get('/salir', array('uses' => 'HomeController@salir'));        
        
    //Route::get('/logout', function () {
    //    Auth::logout();
        //return Redirect::to(preg_replace("/:\/\//", "://log-me-out:fake-pwd@", url('/')));
    //    return Redirect::route('ofertas.index');
    //});
    
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/imprimir', 
      array('uses' => 'OfertasInscripcionesController@imprimir', 'as' => 'ofertas.inscripciones.imprimir')
    );
    
    //agregue esta ruta para cambiar el estado de la inscripcion
    Route::get('/ofertas/{oferta}/inscripciones/{inscripcion}/cambiar', 
      array('uses' => 'OfertasInscripcionesController@cambiarEstado', 'as' => 'ofertas.inscripciones.cambiarEstado')
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
    
    Route::get('/inscripcion_ok', function() {
        return View::make('inscripciones.ok');
    });
    
    //rutas para ver los usuarios
    Route::resource('usuarios', 'UsuariosController');
    Route::get('/logout', array('uses' => 'HomeController@logout'));
    
});

 Route::get('/', array('uses' => 'HomeController@bienvenido'));
 Route::get('/loguin', array('uses' => 'HomeController@loguin'));
 Route::post('/loguin', array('uses' => 'HomeController@acceso'));


