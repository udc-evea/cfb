@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Editar Personal</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($personal, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('personal.update', $personal->id))) }}

        <div class="form-group">
            {{ Form::label('apellido', 'Apellido de la Persona:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::text('apellido', Input::old('apellido'), array('class'=>'form-control', 'placeholder'=>'Apellido de la Persona.')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('nombre', 'Nombre de la Persona:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::text('nombre', Input::old('nombre'), array('class'=>'form-control', 'placeholder'=>'Nombre de la Persona.')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('dni', 'DNI de la Persona:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::number('dni', Input::old('dni'), array('class'=>'form-control', 'placeholder'=>'DNI de la Persona.')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('email', 'E-mail de la Persona:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-5">
              {{ Form::email('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'E-mail de la Persona.')) }}
            </div>
        </div>                
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Titulación</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='titulacion_id'>
                    @foreach($titulaciones as $item)
                        <option value="{{$item->id}}">{{ $item->nombre_titulacion }}</option>
                    @endforeach
                </select>
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