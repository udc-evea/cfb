@extends('layouts.main')

@section('main')

<h1>All TipoDocumentos</h1>

<p>{{ link_to_route('tipo_documentos.create', 'Add New TipoDocumento', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($tipo_documentos->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Tipo_documento</th>
				<th>Descripcion</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($tipo_documentos as $tipo_documento)
				<tr>
					<td>{{{ $tipo_documento->tipo_documento }}}</td>
					<td>{{{ $tipo_documento->descripcion }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('tipo_documentos.destroy', $tipo_documento->tipo_documento))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('tipo_documentos.edit', 'Edit', array($tipo_documento->tipo_documento), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no tipo_documentos
@endif

@stop
