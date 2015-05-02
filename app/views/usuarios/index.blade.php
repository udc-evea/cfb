@extends('layouts.scaffold')

@section('main')

<h1>Lista de Usuarios</h1>

<p>{{ link_to_action('HomeController@bienvenido', ' Inicio', null,array('class'=>'btn btn-sm btn-primary glyphicon glyphicon-chevron-left', 'title'=>'Volver al Inicio')); }}
<a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary" title="Nuevo Usuario"><i class="glyphicon glyphicon-user"></i> Nuevo Usuario</a></p>
@if ($usuarios->count())
	<table class="table table-striped">
		<thead>
                    <tr>
                        <th>Nombre y Apellido</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        @if($perfil == 'Administrador')
                            <th>Acciones</th>
                        @endif
                    </tr>
		</thead>
		<tbody>
                    @foreach ($usuarios as $usu)
                    <tr>
                        <td>{{{ $usu->nombreyapellido }}}</td>
			<td>{{{ $usu->username }}}</td>
                        <td>{{{ $usu->perfil }}}</td>
                        @if($perfil == 'Administrador')
                        <td>
                            {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('usuarios.destroy', $usu->id))) }}
                                {{ Form::submit('Borrar', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                            {{ link_to_route('usuarios.edit', 'Editar', array($usu->id), array('class' => 'btn btn-info')) }}
                        </td>
                        @endif
                    </tr>
                    @endforeach
		</tbody>
	</table>
@else
	There are no usuarios
@endif

@stop
