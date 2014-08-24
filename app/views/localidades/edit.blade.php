@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Localidad</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($Localidad, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('localidades.update', $Localidad->id))) }}

        <div class="form-group">
            {{ Form::label('codigo_provincia', 'Codigo_provincia:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('codigo_provincia', Input::old('codigo_provincia'), array('class'=>'form-control', 'placeholder'=>'Codigo_provincia')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('localidad', 'Localidad:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('localidad', Input::old('localidad'), array('class'=>'form-control', 'placeholder'=>'Localidad')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('codigoPostal', 'CodigoPostal:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('codigoPostal', Input::old('codigoPostal'), array('class'=>'form-control', 'placeholder'=>'CodigoPostal')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('codigoTelArea', 'CodigoTelArea:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('codigoTelArea', Input::old('codigoTelArea'), array('class'=>'form-control', 'placeholder'=>'CodigoTelArea')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('latitud', 'Latitud:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('latitud', Input::old('latitud'), array('class'=>'form-control', 'placeholder'=>'Latitud')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('longitud', 'Longitud:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('longitud', Input::old('longitud'), array('class'=>'form-control', 'placeholder'=>'Longitud')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('localidades.show', 'Cancel', $Localidad->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop