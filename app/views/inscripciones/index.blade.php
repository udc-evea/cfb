@extends('layouts.scaffold')

@section('main')

<h1>
    Inscriptos - {{ $curso->nombre }} &nbsp;&nbsp;
    <small class='text-muted'>|| <a class='text-muted' href="{{ URL::route('cursos.index') }}">Volver</a></small>
</h1>
<h3>
    Total: {{ $inscripciones->count() }}
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href='{{ URL::Route('cursos.inscripciones.index', array('curso_id' => $curso->id, 'csv' => 1)) }}' class='btn btn-small'><span class='glyphicon glyphicon-export'></span> Exportar</a>
</h3>

@if ($inscripciones->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Apellido</th>
				<th>Nombre</th>
				<th>Documento</th>
				<th>Localidad</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
                   @foreach ($inscripciones as $inscripcion)
                    <tr>
                        <td>{{{ $inscripcion->apellido }}}</td>	
                        <td>{{{ $inscripcion->nombre }}}</td>
                        <td>{{{ $inscripcion->tipoydoc }}}</td>
                        <td>{{{ $inscripcion->localidad->localidad }}}</td>
                        <td>
                            {{ link_to_route('cursos.inscripciones.edit', 'Editar', array($curso->id, $inscripcion->id), array('class' => 'btn btn-info')) }}
                            {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('cursos.inscripciones.destroy', $curso->id, $inscripcion->id))) }}
                                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
		@endforeach
		</tbody>
	</table>
<a class='text-muted' href="{{ URL::route('cursos.index') }}">Volver</a>
@else
<p>Aún no hay inscriptos en este curso.</p>
<p><a href="{{ URL::action('cursos.inscripciones.create', $curso->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('cursos.index') }}">Lista de cursos</a></p>
@endif

@stop