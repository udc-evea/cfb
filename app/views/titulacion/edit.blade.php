@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Editar Titulación</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($titulacion, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('titulacion.update', $titulacion->id))) }}

        <div class="form-group">
            {{ Form::label('nombre_titulacion', 'Nombre de la Titulación:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::text('nombre_titulacion', Input::old('nombre_titulacion'), array('class'=>'form-control', 'placeholder'=>'Nombre de la Titulación.')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('abreviatura_titulacion', 'Abreviatura:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::text('abreviatura_titulacion', Input::old('abreviatura_titulacion'), array('class'=>'form-control', 'placeholder'=>'Ingrese la abreviatura de la Titulación.')) }}
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Guardar', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('titulacion.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop