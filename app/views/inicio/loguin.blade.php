@extends('layouts.scaffold')

@section('main')

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ingresar</title>
</head>
<body>
	<div>
            <a href="http://udc.edu.ar" title="Portal Universidad del Chubut" target="_target"><img src="{{ asset('img/LOGO-horizontal-MQ-RGB-150dpi.png') }}" width="250"/></a>
            <p>{{ link_to_action('HomeController@bienvenido', ' Inicio', null,array('class'=>'btn btn-sm btn-primary glyphicon glyphicon-chevron-left', 'title'=>'Volver al Inicio')); }}
	</div>
        
        <div>
            {{ Form::open(array('action' => 'HomeController@loguin')); }}
                {{Form::label('username','Usuario')}}
                {{Form::text('username', null,array('class' => 'form-control'))}}
                {{Form::label('password','Password')}}
                {{Form::password('password',array('class' => 'form-control'))}}
                {{Form::submit('Entrar', array('class' => 'btn btn-primary'))}}
            {{ Form::close() }}
        </div>        
</body>
</html>
@stop
