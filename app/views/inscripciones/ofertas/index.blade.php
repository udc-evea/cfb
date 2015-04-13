@extends('layouts.scaffold')

@section('main')

<h1>Oferta: <strong>"{{ $oferta->nombre }}"</strong></h1>
<h2>
    <strong>Pre-Inscriptos</strong>
    <!-- <small class='text-muted'>|| <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a></small> -->
</h2>
<hr>
<h4>    
    @if(count($inscripciones))
        Total: {{ count($inscripciones) }}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <small>Exportar listado: </small>
        <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xls')) }}"><i class="fa fa-file-excel-o fa-2"></i></a>&nbsp;
        <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdf')) }}"><i class="fa fa-file-pdf-o fa-2"></i></a>
    @endif
</h4>
@if (count($inscripciones))
	<table class="table table-striped" style="border-top: 2px black solid; border-bottom: 2px black solid">
            <thead>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Localidad</th>
                    <th>Email</th>
                    <th>Email UDC</th>
                    <th>Inscripto</th>
                    <th>Notificado/a</th>
                    <th>Acciones</th>
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
                        <td>{{{ $inscripcion->email_institucional }}}</td>
                        <td>
                            @if ($inscripcion->getEsInscripto())
                               {{ link_to_route('ofertas.inscripciones.cambiarEstado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-success glyphicon glyphicon-ok-sign')) }}
                            @else
                               {{ link_to_route('ofertas.inscripciones.cambiarEstado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-danger glyphicon glyphicon-remove-sign')) }}
                            @endif
                            
                        </td>
                        <td>
                            @if ($inscripcion->getEsInscripto())
                                @if ($inscripcion->getCantNotificaciones() > 0)
                                   {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-success')) }}
                                @else
                                   {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-danger')) }}
                                @endif
                            @else
                            <button class="btn btn-block glyphicon glyphicon-remove-sign disable" title="No Corresponde"></button>
                            @endif
                        </td>
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
<!-- <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a> -->
<a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}">Volver</a>
@else
<br>
<h2>Aún no hay inscriptos en esta oferta.</h2>
<p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
@endif

@stop