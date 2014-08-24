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

Route::get('/cursos/{curso}/inscripcion', 'InscripcionesController@create');
Route::post('/cursos/{curso}/inscripcion', 'InscripcionesController@store');

Route::group(array('before' => 'auth.basic', 'except' => array('inscripciones.store')), function() {
    Route::get('/', function() {
        return Redirect::route('cursos.index');
    });

    Route::match(array('GET'), '/cursos/{curso}/inscripciones', 'InscripcionesController@index');
    Route::resource('cursos', 'CursosController');
    Route::resource('inscripciones', 'InscripcionesController', array('except' => array('create', 'store')));

    Route::resource('tipos_documento', 'TipoDocumentosController');
    Route::resource('localidades', 'LocalidadesController');
});

Route::get('/inscripcion_ok', function() {
    return View::make('inscripciones.ok');
});