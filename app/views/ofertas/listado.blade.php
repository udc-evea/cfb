@if ($ofertas->count())
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Año</th>
            <th>Inscriptos</th>
            <th>Inscribiendo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ofertas as $oferta)
        <tr>
            <td>{{ $oferta->nombre }}</td>
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
                @if($oferta->permite_inscripciones)
                <small><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}">[Form]</a></small>
                @endif
            </td>
            <td>{{ ModelHelper::dateOrNull($oferta->inicio) }}</td>
            <td>{{ ModelHelper::dateOrNull($oferta->fin) }}</td>
            <td>
                {{ link_to_route('ofertas.vermail', 'Ver correo', array($oferta->id), array('class' => 'btn btn-default')) }}
                {{ link_to_route('ofertas.edit', 'Editar', array($oferta->id), array('class' => 'btn btn-info')) }}
                @if($oferta->inscriptos == 0)
                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $oferta->id))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                @else
                {{ Former::disabled_button('Eliminar')->disabled()->title("No se puede eliminar: hay inscriptos.") }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Sin resultados.</div>
@endif