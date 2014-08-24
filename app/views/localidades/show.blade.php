@extends('layouts.scaffold')

@section('main')

<h1>Show Localidad</h1>

<p>{{ link_to_route('localidades.index', 'Return to All Localidades', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Codigo_provincia</th>
				<th>Localidad</th>
				<th>CodigoPostal</th>
				<th>CodigoTelArea</th>
				<th>Latitud</th>
				<th>Longitud</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
