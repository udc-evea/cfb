@extends('layouts.scaffold')

@section('main')

<h1>{{ $mje }}</h1>
<p>{{ link_to_action('HomeController@bienvenido', ' Inicio', null,array('class'=>'btn btn-sm btn-primary glyphicon glyphicon-chevron-left', 'title'=>'Volver al Inicio')); }}

