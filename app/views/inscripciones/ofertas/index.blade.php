@extends('layouts.scaffold')

@section('main')

<h1>Oferta: <strong>"{{ $oferta->nombre }}"</strong></h1>
<h2>Usuario: {{ $nomyape }} - {{ $userName }} ({{ $perfil }})</h2>
<h2>
    <strong>Pre-Inscriptos</strong>
    <!-- <small class='text-muted'>|| <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a></small> -->
</h2>
    @if(count($inscripciones))
    <table class="tablaExportar">
        <tr>
            <td rowspan="2"><strong>Exportar listado</strong></td>
            <td colspan="2"><strong>Excel</strong></td>
            <td colspan="2"><strong>PDF</strong></td>
            @if($perfil == "Administrador")
                <td colspan="2"><strong>CVS</strong></td>
            @endif
        </tr>
        <tr>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsp')) }}" title="Exportar listado de Pre-Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a></td>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsi')) }}" title="Exportar listado de Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a></td>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfp')) }}" title="Exportar listado de Pre-inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a></td>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfi')) }}" title="Exportar listado de Inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a></td>
            @if($perfil == "Administrador")
                <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'cvsp')) }}" title="Exportar listado de Pre-Inscriptos a CVS"><i class="fa fa-file-text-o"></i></a></td>
                <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'cvsi')) }}" title="Exportar listado de Inscriptos a CVS"><i class="fa fa-file-text-o"></i></a></td>
            @endif
        </tr>
    </table>
    @endif
    <br><br>
<h4>
    @if(count($inscripciones))
        Total: {{ count($inscripciones) }}
    @endif
</h4>
@if (count($inscripciones))
	<table class="table table-striped" style="border-top: 2px black solid; border-bottom: 2px black solid">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    @if($perfil != "Colaborador")
                        <th>Documento</th>
                    @endif
                    <th>Localidad</th>
                    <th>Email</th>
                    @if($perfil != "Colaborador")
                        <th>Email UDC</th>
                        <th>Inscripto</th>
                        <th>Notificado/a</th>
                    @endif
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                   <?php $i = 1; ?>
                   @foreach ($inscripciones as $inscripcion)                   
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{{ $inscripcion->apellido }}}</td>	
                        <td>{{{ $inscripcion->nombre }}}</td>
                        @if($perfil != "Colaborador")
                            <td>{{{ $inscripcion->tipoydoc }}}</td>
                        @endif
                        <td>{{{ $inscripcion->localidad->la_localidad }}}</td>
                        <td>{{{ $inscripcion->email }}}</td>
                        @if($perfil != "Colaborador")
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
                        @endif
                        <td>
                            {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
                            <!-- <a href="{{route('ofertas.inscripciones.imprimir', [$oferta->id, $inscripcion->id])}}" class="btn btn-default" title="Imprimir formulario de inscripcion"><i class="fa fa-file-pdf-o"></i></a> -->
                            @if($perfil != "Colaborador")
                                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-danger','title'=>'Eliminar Inscripto')) }}
                                {{ Form::close() }}
                            @endif
                        </td>
                    </tr>
                    <?php $i++;?>
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