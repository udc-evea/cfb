@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Nuevo Capacitador</h1>

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
{{ Form::open(array('route' => 'capacitador.store', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Ofertas</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='oferta_id'>
                    <option>Seleccionar</option>
                    @foreach($ofertas as $item)
                        <option value="{{$item->id}}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Personal</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='personal_id'>
                    <option>Seleccionar</option>
                    @foreach($personal as $item)
                        <option value="{{$item->id}}">{{ $item->apellido }}, {{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Rol</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='rol_id'>
                    <option>Seleccionar</option>
                    @foreach($roles as $item)
                        <option value="{{$item->id}}">{{ $item->rol }}</option>
                    @endforeach
                </select>
            </div>
        </div> 
        
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">              
              {{ Form::submit('Crear', array('class' => 'btn btn-lg btn-primary')) }}
              {{ link_to_route('capacitador.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
            </div>
        </div>
{{ Form::close() }}
</fieldset>

@stop
