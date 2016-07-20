@extends('layouts.scaffold')

@section('main')
<div align="center">
    <h1 style="background-color: black;border: solid 2px white; color: white;padding: 10px;border-radius: 5px;">Lista del Personal</h1>
</div>
<div class="row block">
    <div align="center">
        <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
        <a href="{{ route('personal.create') }}" class="btn btn-primary" title="Nuevo Personal"><i class="glyphicon glyphicon-user"></i> Nuevo Personal</a></p>
    </div>
</div>
@if ($personal->count())
    <div id="personal">
        <input class="search" placeholder="Buscar por Apellido o DNI" id="inputBuscar"/>        
        <button class="sort" data-sort="apellido" >Por Apellido</button>
        <button class="sort" data-sort="dni" >Por DNI</button>
	<table class="table table-striped">
		<thead>
                    <tr>
                        <th>Apellido y Nombre</th>
                        <th>DNI</th>
                        <th>E-mail</th>
                        <th>Titulación</th>
                        @if($perfil != 'Colaborador')
                                <th>Acciones</th>
                        @endif
                    </tr>
		</thead>
		<tbody class="list">
                    @foreach ($personal as $pers)
                    <tr>
                        <td class="apellido">{{ $pers->apellido }}, {{ $pers->nombre }}</td>
                        <td class="dni">{{ $pers->dni }}</td>
			<td>{{ $pers->email }}</td>
                        <td>{{ $pers->titulacion_id }}</td>
                        @if($perfil != 'Colaborador')
                            <td>
                                {{ link_to_route('personal.edit', ' ', array($pers->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos del personal.')) }}
                                @if($perfil == 'Administrador')
                                    {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('personal.destroy', $pers->id))) }}
                                        {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar los datos del personal')) }}
                                    {{ Form::close() }}
                                @endif
                            </td>
                        @endif
                    </tr>
                    @endforeach
		</tbody>
	</table>
    </div>
    <div class="row block">
        <div align="center">
            <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
            <a href="{{ route('personal.create') }}" class="btn btn-primary" title="Nuevo Personal"><i class="glyphicon glyphicon-user"></i> Nuevo Personal</a></p>
        </div>
    </div>
@else
	No hay ningun Personal cargado!
@endif
<script>
    var options = {
      valueNames: [ 'apellido', 'dni' ]
    };

    var personalList = new List('personal', options);
</script>
@stop
