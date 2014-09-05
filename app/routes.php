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

Route::get('/cursos/{curso}/inscripcion',  'CursosInscripcionesController@create');
Route::post('/cursos/{curso}/inscripcion', 'CursosInscripcionesController@store');

Route::group(array('before' => 'auth.basic', 'except' => array('cursos.inscripciones.create', 'cursos.inscripciones.store')), function() {
    Route::get('/', function() {
        return Redirect::route('cursos.index');
    });

    Route::resource('cursos', 'CursosController');
    Route::resource('cursos.inscripciones', 'CursosInscripcionesController');

    Route::resource('tipos_documento', 'TipoDocumentosController');
    Route::resource('localidades', 'LocalidadesController');
});

Route::get('/inscripcion_ok', function() {
    return View::make('inscripciones.ok');
});
