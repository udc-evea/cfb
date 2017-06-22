@extends('layouts.scaffold')

@section('main')

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ingresar</title>
    </head>
    <body>
        <a href="http://udc.edu.ar" title="Portal Universidad del Chubut" target="_target"><img src="{{ asset('img/LOGO-horizontal-MQ-RGB-150dpi.png') }}" width="250"/></a>
        <br><br>
        <div class="well" align="center">
            <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-lg btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a></p>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger" align="center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <p>Ha ocurrido un error. Revise el USUARIO y/o CLAVE e intente ingresar nuevamente.</p>
        </div>
        @endif
        <div class="formLogin col-lg-5 well">
            {{ Form::open(array('action' => 'HomeController@login')); }}
            <fieldset>
                <div id="legend">
                    <legend class="">Login</legend>
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="username">
                        <i class="glyphicon glyphicon-user"></i> <strong>Usuario</strong>
                    </span>
                    {{Form::text('username', null,array('class' => 'form-control','aria-describedby'=>'username','placeholder'=>'Ingrese su nombre de usuario','title'=>'Ingrese su nombre de usuario','tabindex'=>1))}}
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon" id="password">
                        <i class="glyphicon glyphicon-eye-open"></i> <strong>Clave</strong>
                    </span>
                    {{Form::password('password',array('class' => 'form-control','aria-describedby'=>'password','placeholder'=>'Ingrese su contraseña','title'=>'Ingrese su contraseña','tabindex'=>1))}}
                </div>
                    <br>
                <div align="center">
                    {{Form::submit('Entrar', array('class' => 'btn btn-primary','title'=>'Ingresar al sistema'))}}
                </div>
                {{ Form::close() }}
            </fieldset>
        </div>
    </body>
</html>
@stop
