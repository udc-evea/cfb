@extends('layouts.scaffold')
@section('title', 'Login')
@section('main')


        <a href="http://udc.edu.ar" title="Portal Universidad del Chubut" target="_target"><img src="{{ asset('img/LOGO-horizontal-MQ-RGB-150dpi.png') }}" width="250"/></a>
        <br><br>
        @if ($errors->any())
        <div class="alert alert-danger" align="center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <p>Ha ocurrido un error. Revise el USUARIO y/o CLAVE e intente ingresar nuevamente.</p>
        </div>
        @endif
        <div class="formLogin col-lg-5">
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
                    <a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
                    {{Form::submit('Verificar', array('class' => 'btn btn-primary','title'=>'Ingresar al sistema', 'onclick'=>'cambiaVisibilidad()'))}}                    
                </div>
                {{ Form::close() }}
            </fieldset>
        </div>

<script>
    
    function cambiaVisibilidad() {
       var div1 = document.getElementById('divUsername');
       var div2 = document.getElementById('dicPassword');
       if(div2.style.display === 'block'){
           div2.style.display = 'none';
           div1.style.display = 'block';
       }else{
          div2.style.display = 'block';
          div1.style.display = 'none';
         }
   }
    
    
</script>
@stop