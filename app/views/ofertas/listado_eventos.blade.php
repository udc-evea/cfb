@if ($eventos->count())
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
        </tr>
    </thead>

    <tbody>
        @foreach ($eventos as $item)
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
                @if(($userPerfil == "Administrador")||($item->user_id_creador == $userId))
                    @if($item->permite_inscripciones)
                        <small><a href="{{ URL::action('ofertas.inscripciones.create', $item->id) }}">[Form]</a></small>
                    @endif
                @endif
            </td>
            <td>{{ ModelHelper::dateOrNull($item->inicio) }}</td>
            <td>{{ ModelHelper::dateOrNull($item->fin) }}</td>
            <td>
            @if(($userPerfil == "Administrador")||($item->user_id_creador == $userId))
                {{ link_to_route('ofertas.vermail', '', array($item->id), array('class' => 'btn btn-default glyphicon glyphicon-envelope', 'title'=>'Ver Mail personalizado')) }}
                {{ link_to_route('ofertas.edit', '', array($item->id), array('class' => 'btn btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos de la Oferta')) }}
                @if($item->inscriptos == 0)
                    {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $item->id))) }}
                    {{ Form::submit('Borrar', array('class' => 'btn btn-danger')) }}
                    {{ Form::close() }}
                @else
                    {{ Former::disabled_button('Borrar')->disabled()->title("No se puede eliminar: hay inscriptos.") }}
                @endif
            @else
                <small>No tiene permisos para esta oferta</small>
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Sin resultados.</div>
@endif