@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Nueva Titulación</h1>

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
{{ Form::open(array('route' => 'titulacion.store', 'class' => 'form-horizontal')) }}

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
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">              
              {{ Form::submit('Crear', array('class' => 'btn btn-lg btn-primary')) }}
              {{ link_to_route('titulacion.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
            </div>
        </div>
{{ Form::close() }}
</fieldset>

@stop
