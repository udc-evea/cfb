@extends('layouts.scaffold')
@section('main')

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 60%;
			height: 200px;
			margin-left: 20%;
			margin-top: 100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
                
                .listadoOpciones{
                    width: 60%;
                    margin-left: 20%;                    
                }
	</style>
</head>
<body>
	<div class="welcome" align="center">		
                <a href="http://udc.edu.ar" title="Portal Universidad del Chubut" target="_target"><img src="{{ asset('img/LOGO-horizontal-MQ-RGB-150dpi.png') }}" width="250"/></a>
                <div>
                    <h1 style="width: 400px; border: solid white 4px; background-color: black; color: white; border-radius: 15px; padding: 10px">
                        <span class="titulo1">Inscripciones On Line</span>
                        <div><small>código v.3.1.1 | base v.<?php echo $verDB ?></small></div>
                    </h1>                    
                </div> 
	</div>
        <br><br><br>
        @if(Auth::check())
        <div class="listadoOpciones">
            <p><a href="{{ route('ofertas.index') }}" class="btn btn-lg btn-info" title="Ver todas las Ofertas"><i class="glyphicon glyphicon-list"></i> Todas las ofertas</a></p>
            @if(Auth::user()->perfil == 'Administrador')
                <p><a href="{{ route('usuarios.index') }}" class="btn btn-lg btn-danger" title="Ver todas las Usuarios"><i class="glyphicon glyphicon-user"></i> Todos los usuarios</a></p>
            @endif
            <p><a href="{{action('HomeController@salir')}}" class="btn btn-lg btn-warning" title="Salir del Sistema de Inscripciones"><i class="glyphicon glyphicon-off"></i> Salir</a></p>
        </div>
        @else
        <div>
            <p><a href="{{action('HomeController@login')}}" class="btn btn-lg btn-success" title="Entrar al Sistema de Inscripciones"><i class="glyphicon glyphicon-repeat"></i> Ingresar</a></p>
        </div>
        @endif
</body>
</html>
