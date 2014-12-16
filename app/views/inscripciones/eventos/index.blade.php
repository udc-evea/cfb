@extends('layouts.scaffold')

@section('main')

<h1>
    Inscriptos - {{ $oferta->nombre }} &nbsp;&nbsp;
    <small class='text-muted'>|| <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a></small>
</h1>
<h3>
    Total: {{ count($inscripciones) }}
    &nbsp;&nbsp;&nbsp;&nbsp;
    @if(count($inscripciones))
    <small>Exportar listado: </small>
    <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xls')) }}"><i class="fa fa-file-excel-o fa-2"></i></a>&nbsp;
    <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdf')) }}"><i class="fa fa-file-pdf-o fa-2"></i></a>
    @endif
</h3>

@if (count($inscripciones))
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Apellido</th>
				<th>Nombre</th>
				<th>Documento</th>
				<th>Localidad</th>
                <th>Email</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
                   @foreach ($inscripciones as $inscripcion)
                    <tr>
                        <td>{{{ $inscripcion->apellido }}}</td>	
                        <td>{{{ $inscripcion->nombre }}}</td>
                        <td>{{{ $inscripcion->tipoydoc }}}</td>
                        <td>{{{ $inscripcion->localidad->la_localidad }}}</td>
                        <td>{{{ $inscripcion->email }}}</td>
                        <td>
                            {{ link_to_route('ofertas.inscripciones.edit', 'Editar', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-info')) }}
                            {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
		@endforeach
		</tbody>
	</table>
<a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a>
@else
<p>Aún no hay inscriptos en esta oferta.</p>
<p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
@endif

@stop