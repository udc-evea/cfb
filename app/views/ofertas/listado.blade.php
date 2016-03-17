@if ($ofertas->count())
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Año</th>
            <th>Pre-Inscriptos</th>
            <th>Inscribiendo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
            <th>Ultima Modif.</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ofertas as $oferta)
        <tr>
            <td title="Creador: {{ $oferta->creador->nombreyapellido }}">{{ $oferta->nombre }}</td>
            <td>{{ $oferta->anio }}</td>
            <td>
                {{ $oferta->inscriptos }}
                @if((int)$oferta->cupo_maximo > 0)
                    de {{$oferta->cupo_maximo}}
                    @if($oferta->inscriptos > $oferta->cupo_maximo)
                        <span class="text-danger glyphicon glyphicon-warning-sign"></span>
                    @endif
                @endif
                
                    @if($oferta->inscriptos > 0)
                        <small><a href="{{ URL::route('ofertas.inscripciones.show', $oferta->id) }}">[Ver]</a></small>
                    @endif
                
            </td>
            <td>
                {{ BS3::bool_to_label($oferta->permite_inscripciones) }}
                @if(($userPerfil == "Administrador")||($oferta->user_id_creador == $userId))
                    @if($oferta->permite_inscripciones)
                        <small><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->stringAleatorio($oferta->id,15)) }}">[Form]</a></small>
                    @endif
                @endif
            </td>
            <td>{{ ModelHelper::dateOrNull($oferta->inicio) }}</td>
            <td>{{ ModelHelper::dateOrNull($oferta->fin) }}</td>
            <td>
            @if(($userPerfil == "Administrador")||($oferta->user_id_creador == $userId))
                {{ link_to_route('ofertas.vermail', '', array($oferta->id), array('class' => 'btn btn-xs btn-default glyphicon glyphicon-envelope', 'title'=>'Ver Mail personalizado')) }}
                {{ link_to_route('ofertas.edit', '', array($oferta->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil', 'title'=>'Editar datos de la Oferta')) }}
                @if($oferta->inscriptos == 0)
                    {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $oferta->id))) }}
                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger')) }}
                    {{ Form::close() }}
                @else
                    {{ Former::disabled_button('Borrar')->disabled()->title("No se puede eliminar: hay inscriptos.")->class('btn btn-xs') }}
                @endif
            @else
                <small>No tiene permisos para esta oferta</small>
            @endif
            </td>
            <td>{{ $oferta->ultimaModificacion->nombreyapellido }} ({{ ($oferta->fecha_modif) }})</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Sin resultados.</div>
@endif