@extends('layouts.scaffold')

@section('main')
<div align="center">
    <h1 style="background-color: black;border: solid 2px white; color: white;padding: 10px;border-radius: 5px;">Lista de Usuarios</h1>
</div>
<div class="row block">
    <div align="center">
        <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary" title="Nuevo Usuario"><i class="glyphicon glyphicon-user"></i> Nuevo Usuario</a></p>
    </div>
</div>
@if ($usuarios->count())
    <div id="usuarios">
        <input class="search" placeholder="Buscar por Apellido o Usuario" id="inputBuscar"/>        
        <button class="sort" data-sort="apellido" >Por Apellido</button>
        <button class="sort" data-sort="usuario" >Por usuario</button>
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
		<tbody class="list">
                    @foreach ($usuarios as $usu)
                    <tr>
                        <td class="apellido">{{{ $usu->nombreyapellido }}}</td>
			<td class="usuario">{{{ $usu->username }}}</td>
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
                            <td title="Solo otro Administrador puede editar sus datos!">Inhabilitado</td>
                            @endif
                        @endif
                    </tr>
                    @endforeach
		</tbody>
	</table>
    </div>
    <div class="row block">
        <div align="center">
            <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary" title="Nuevo Usuario"><i class="glyphicon glyphicon-user"></i> Nuevo Usuario</a></p>
        </div>
    </div>
@else
	No hay Usuarios!
@endif
<script>
    var options = {
      valueNames: [ 'apellido', 'usuario' ]
    };

    var usuariosList = new List('usuarios', options);
</script>
@stop
