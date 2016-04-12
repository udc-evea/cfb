@extends('layouts.scaffold')

@section('main')
<div align="center">
    <h1 style="background-color: black;border: solid 2px white; color: white;padding: 10px;border-radius: 5px;">Lista de Capacitadores</h1>
</div>
<div class="row block">
    <div align="center">
        <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
        <a href="{{ route('capacitador.create') }}" class="btn btn-primary" title="Nuevo Capacitador"><i class="glyphicon glyphicon-user"></i> Nuevo Capacitador</a></p>
    </div>
</div>
@if ($capacitadores->count())
	<table class="table table-striped">
		<thead>
                    <tr>
                        <th>Oferta</th>
                        <th>Personal</th>
                        <th>Rol</th>                        
                        @if($perfil == 'Administrador')
                                <th>Acciones</th>
                        @endif
                    </tr>
		</thead>
		<tbody>
                    @foreach ($capacitadores as $capacitador)
                    <tr>
                        <td>{{ $capacitador->obtenerOferta->nombre }}</td>
                        <td>{{ $capacitador->obtenerPersonal->apellido }}, {{ $capacitador->obtenerPersonal->nombre }}</td>
			<td>{{ $capacitador->obtenerRolPersonal->rol }}</td>
                        @if($perfil == 'Administrador')
                            <td>
                                {{ link_to_route('capacitador.edit', ' ', array($capacitador->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos del capacitador.')) }}
                                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('capacitador.destroy', $capacitador->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar los datos del capacitador')) }}
                                {{ Form::close() }}
                            </td>
                        @endif
                    </tr>
                    @endforeach
		</tbody>
	</table>
<div class="row block">
    <div align="center">
        <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
        <a href="{{ route('capacitador.create') }}" class="btn btn-primary" title="Nuevo Capacitador"><i class="glyphicon glyphicon-user"></i> Nuevo Capacitador</a></p>
    </div>
</div>
@else
	No hay ningun Personal cargado!
@endif

@stop
