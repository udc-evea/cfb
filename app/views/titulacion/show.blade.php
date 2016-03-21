@extends('layouts.scaffold')

@section('main')

<h1>Datos del Usuario</h1>

<p>{{ link_to_route('usuarios.index', 'Usuarios', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
            <tr>
                <th>Tipo_documento</th>
                <th>Descripcion</th>
            </tr>
        </thead>
	<tbody>
            <tr>
                <td>{{{ $tipo_documento->tipo_documento }}}</td>
                <td>{{{ $tipo_documento->descripcion }}}</td>
                <td>
                    {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('tipo_documentos.destroy', $tipo_documento->tipo_documento))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                    {{ Form::close() }}
                    {{ link_to_route('tipo_documentos.edit', 'Edit', array($tipo_documento->tipo_documento), array('class' => 'btn btn-info')) }}
                </td>
            </tr>
	</tbody>
</table>

@stop
