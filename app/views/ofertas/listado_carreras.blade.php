@if ($carreras->count())
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
        @foreach ($carreras as $item)
        <tr>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->anio }}</td>
            <td>
                {{ $item->inscriptos }}
                @if((int)$item->cupo_maximo > 0)
                de {{$item->cupo_maximo}}
                @if($item->inscriptos > $item->cupo_maximo)
                <span class="text-danger glyphicon glyphicon-warning-sign"></span>
                @endif
                @endif
                @if($item->inscriptos > 0)
                <small><a href="{{ URL::route('ofertas.inscripciones.show', $item->id) }}">[Ver]</a></small>
                @endif
            </td>
            <td>
                {{ BS3::bool_to_label($item->permite_inscripciones) }}
                @if($item->permite_inscripciones)
                <small><a href="{{ URL::action('ofertas.inscripciones.create', $item->id) }}">[Form]</a></small>
                @endif
            </td>
            <td>{{ ModelHelper::dateOrNull($item->inicio) }}</td>
            <td>{{ ModelHelper::dateOrNull($item->fin) }}</td>
            <td>
                {{ link_to_route('ofertas.vermail', 'Ver correo', array($item->id), array('class' => 'btn btn-default')) }}
                {{ link_to_route('ofertas.edit', 'Editar', array($item->id), array('class' => 'btn btn-info')) }}
                @if($item->inscriptos == 0)
                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $item->id))) }}
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
No hay ofertas registradas.
@endif