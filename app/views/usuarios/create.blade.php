@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Nuevo Usuario</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>
<fieldset>
{{ Form::open(array('route' => 'usuarios.store', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label('nombreyapellido', 'Nombre y Apellido:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::text('nombreyapellido', Input::old('nombreyapellido'), array('class'=>'form-control', 'placeholder'=>'Nombre y Apellido')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('username', 'Usuario:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::text('username', Input::old('username'), array('class'=>'form-control', 'placeholder'=>'Nombre de usuario')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('password', 'Clave:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Clave de usuario')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('perfil', 'Perfil:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              <?php $tipoUser = array('Colaborador'=>'Colaborador','Creador'=>'Creador','Administrador'=>'Administrador'); ?>
              {{ Form::select('perfil',$tipoUser); }}
              {{ Form::token('remember_token') }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">              
              {{ Form::submit('Crear', array('class' => 'btn btn-lg btn-primary')) }}
              {{ link_to_route('usuarios.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
            </div>
        </div>
</fieldset>
{{ Form::close() }}

@stop
