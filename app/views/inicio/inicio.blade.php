@extends('layouts.scaffold')
@section('title', 'Inicio')
@section('main')

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
			margin-top: 20px;
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

	<div class="welcome" align="center">		
                <a href="http://udc.edu.ar" title="Portal Universidad del Chubut" target="_target"><img src="{{ asset('img/LOGO-horizontal-MQ-RGB-150dpi.png') }}" width="250"/></a>
                <div>
                    <h1 style="width: 400px; border: solid white 4px; background-color: black; color: white; border-radius: 15px; padding: 10px">
                        <span class="titulo1">Inscripciones On Line</span>
                        <div><small>código v.<?php echo $verCodigo ?> | base v.<?php echo $verDB ?></small></div>
                    </h1>                    
                </div> 
	</div>
        <br>
        @if(Auth::check())
        <div class="listadoOpciones">
            <p><a href="{{ route('ofertas.index') }}" class="btn btn-lg btn-info" style='width: 300px' title="Ver todas las Ofertas"><i class="glyphicon glyphicon-list"></i> Todas las ofertas</a></p>
            <p><a href="{{ action('HomeController@verificarCertificado') }}" class="btn btn-lg btn-default" style='width: 300px' title="Verificar si un certificado es válido" target="_blank"><i class="glyphicon glyphicon-qrcode"></i> Verificar Certificado</a></p>
            @if((Auth::user()->perfil == 'Administrador')||(Auth::user()->perfil == 'creador'))
                <p><a href="{{ route('personal.index') }}" class="btn btn-lg btn-success" style='width: 300px' title="Ver todo el Personal en condiciones de actuar como Capacitadores"><i class="glyphicon glyphicon-user"></i> Personal para Capacitaciones</a></p>
            @endif
            @if(Auth::user()->perfil == 'Administrador')
                <p><a href="{{ route('usuarios.index') }}" class="btn btn-lg btn-danger" style='width: 300px' title="Ver todas las Usuarios"><i class="glyphicon glyphicon-user"></i> Usuarios del Sistema</a></p>
                <p><a href="{{ route('titulacion.index') }}" class="btn btn-lg btn-default" style='width: 300px' title="Ver todas las titulaciones disponibles"><i class="glyphicon glyphicon-book"></i> Titulaciones</a></p>
            @endif                
            <p><a href="{{action('HomeController@salir')}}" class="btn btn-lg btn-warning" title="Salir del Sistema de Inscripciones"><i class="glyphicon glyphicon-off"></i> Salir</a></p>
        </div>
        @else
            <div>
                <div class="formLogin col-lg-5" style="display: none" id="divFormLogin">
                    {{ Form::open(array('action' => 'HomeController@login')); }}
                    <fieldset>
                        <div id="legend">
                            <legend class="">Login</legend>
                        </div>
                        <div id="divUsername" style="display: block">
                            <div class="input-group">
                                <span class="input-group-addon" id="username">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                {{Form::text('username', null,array('class' => 'form-control','aria-describedby'=>'username','placeholder'=>'Ingrese su nombre de usuario','title'=>'Ingrese su nombre de usuario','tabindex'=>1))}}
                            </div>
                        </div>
                        <br>
                        <div id="divPassword" style="display: block">
                            <div class="input-group" id="clave">
                                <span class="input-group-addon" id="password">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                {{Form::password('password',array('class' => 'form-control','aria-describedby'=>'password','placeholder'=>'Ingrese su contraseña','title'=>'Ingrese su contraseña','tabindex'=>1))}}
                            </div>
                        </div>
                        <br>
                        <div align="center">
                            <a href="#" class="btn btn-warning" id="btnOcultarLogin" onclick="cambiaVisibilidad()"><i class="glyphicon glyphicon-repeat"></i> Inicio</a>
                            {{Form::submit('Entrar', array('class' => 'btn btn-primary','title'=>'Ingresar al sistema'))}}
                        </div>
                        {{ Form::close() }}
                    </fieldset>
                </div>
            <!-- <p><a href="{{action('HomeController@login')}}" class="btn btn-lg btn-success" title="Entrar al Sistema de Inscripciones"><i class="glyphicon glyphicon-repeat"></i> Ingresar</a></p> -->
                <a href="#" style="visibility: visible" id="btnMostrarLogin" class="btn btn-lg btn-success" title="Entrar al Sistema de Inscripciones" onclick="cambiaVisibilidad()"><i class="glyphicon glyphicon-repeat"></i> Ingresar</a>
        </div>
        @endif
        
<script>
    
    function cambiaVisibilidad() {
       var div1 = document.getElementById('divFormLogin');
       if(div1.style.display === 'block'){
           div1.style.display = 'none';
           document.getElementById('btnMostrarLogin').style.visibility = 'visible';
       }else{          
          div1.style.display = 'block';
          document.getElementById('btnMostrarLogin').style.visibility = 'hidden';
       }
   }
    
    
</script>

