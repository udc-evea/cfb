@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Editar Capacitador</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($capacitador, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('capacitador.update', $capacitador->id))) }}
    
        <!-- <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Ofertas</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='oferta_id'>
                    @foreach($ofertas as $item)
                        <option value="{{$item->id}}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div> -->
        {{ Former::hidden('oferta_id')->value($capacitador->obtenerOferta->id) }}
        {{ Former::hidden('personal_id')->value($capacitador->obtenerPersonal->id) }}
        <!-- <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Personal</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='personal_id'>
                    @foreach($personal as $item)
                        <option value="{{$item->id}}">{{ $item->apellido }}, {{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>  -->
        {{ $capacitador->obtenerPersonal->apellido }}, {{ $capacitador->obtenerPersonal->nombre }}<br>
        {{ $capacitador->obtenerOferta->nombre }}<br>
        {{ $capacitador->obtenerRolPersonal->rol }}<br>
                
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Nuevo Rol</label>
            <div class="col-lg-10 col-sm-3">
                <select class="form-control" name='rol_id'>
                    @foreach($roles as $item)
                        <option value="{{$item->id}}">{{ $item->rol }}</option>
                    @endforeach
                </select>
            </div>
        </div> 

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Guardar', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('ofertas.index', 'Cancel', null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop