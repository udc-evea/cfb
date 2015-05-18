@extends('layouts.scaffold')

@section('main')

<h1>Lista de Usuarios</h1>

<div class="row block">
    <div align="center">
        <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary" title="Nuevo Usuario"><i class="glyphicon glyphicon-user"></i> Nuevo Usuario</a></p>
    </div>
</div>
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
                            @if( $user != $usu->username)
                            <td>
                                {{ link_to_route('usuarios.edit', ' ', array($usu->id), array('class' => 'btn btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos del usuario')) }}
                                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('usuarios.destroy', $usu->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-danger','title'=>'Eliminar los datos del usuario')) }}
                                {{ Form::close() }}
                            </td>
                            @else
                            <td>Inhabilitado</td>
                            @endif
                        @endif
                    </tr>
                    @endforeach
		</tbody>
	</table>
@else
	There are no usuarios
@endif

@stop
