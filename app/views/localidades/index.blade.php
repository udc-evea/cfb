@extends('layouts.scaffold')

@section('main')

<h1>All Localidades</h1>

<p>{{ link_to_route('localidades.create', 'Add New Localidad', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($Localidades->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Codigo_provincia</th>
				<th>Localidad</th>
				<th>CodigoPostal</th>
				<th>CodigoTelArea</th>
				<th>Latitud</th>
				<th>Longitud</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($Localidades as $Localidad)
				<tr>
					<td>{{{ $Localidad->codigo_provincia }}}</td>
					<td>{{{ $Localidad->localidad }}}</td>
					<td>{{{ $Localidad->codigoPostal }}}</td>
					<td>{{{ $Localidad->codigoTelArea }}}</td>
					<td>{{{ $Localidad->latitud }}}</td>
					<td>{{{ $Localidad->longitud }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('localidades.destroy', $Localidad->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('localidades.edit', 'Edit', array($Localidad->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no Localidades
@endif

@stop
