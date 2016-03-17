@extends('layouts.scaffold')

@section('main')
<div align="center">
    <h1 style="background-color: black;border: solid 2px white; color: white;padding: 10px;border-radius: 5px;">Lista de Titulaciones</h1>
</div>
<div class="row block">
    <div align="center">
        <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
        <a href="{{ route('titulacion.create') }}" class="btn btn-primary" title="Nueva Titulación"><i class="glyphicon glyphicon-user"></i> Nueva Titulación</a></p>
    </div>
</div>
@if ($titulaciones->count())
	<table class="table table-striped">
		<thead>
                    <tr>
                        <th>Titulación</th>
                        <th>Abreviatura</th>
                        <th>Perfil</th>
                        @if($perfil == 'Administrador')
                                <th>Acciones</th>
                        @endif
                    </tr>
		</thead>
		<tbody>
                    @foreach ($titulaciones as $tit)
                    <tr>
                        <td>{{{ $tit->nombre_titulacion }}}</td>
			<td>{{{ $tit->abreviatura_titulacion }}}</td>
                        @if($perfil == 'Administrador')
                            <td>
                                {{ link_to_route('titulacion.edit', ' ', array($tit->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos de la titulación')) }}
                                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('titulacion.destroy', $tit->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar los datos de la titulación')) }}
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
        <a href="{{ route('titulacion.create') }}" class="btn btn-primary" title="Nueva Titulación"><i class="glyphicon glyphicon-user"></i> Nueva Titulación</a></p>
    </div>
</div>
@else
	No hay ninguna Titulación cargada!
@endif

@stop
