@if ($carreras->count())
<div id='divCarreras'>
    <br>
    <input class="search" placeholder="Buscar por Año o Nombre" id="inputBuscar"/>
        <button class="sort" data-sort="anio" >Año</button>
        <button class="sort" data-sort="nombre" >Nombre</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Carrera Nombre</th>
                <th>Año</th>
                <th>Pre-Inscriptos</th>
                <th>Inscribiendo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
                <th>Ultima Modif.</th>
            </tr>
        </thead>

        <tbody class='list'>
            @foreach ($carreras as $item)
            <tr>
                <td class='nombre' title="Creador: {{ $item->creador->nombreyapellido }}">{{ $item->nombre }}</td>
                <td class='anio'>{{ $item->anio }}</td>
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
                    <?php //if(($userPerfil == "Administrador")||($item->user_id_creador == $userId)):?>
                        <?php //if($item->permite_inscripciones): ?>
                    <small><a title="Formulario de Inscripción a la Oferta" class='btn btn-xs btn-info' href="{{ URL::action('ofertas.inscripciones.create', $item->stringAleatorio($item->id,15)) }}"><i class=" glyphicon glyphicon-list-alt"></i></a></small>
                        <?php //endif; ?>
                     <?php //endif; ?>
                </td>
                <td>{{ ModelHelper::dateOrNull($item->inicio) }}</td>
                <td>{{ ModelHelper::dateOrNull($item->fin) }}</td>
                <td>
                @if(($userPerfil == "Administrador")||($item->user_id_creador == $userId))
                    {{ link_to_route('ofertas.vermail', '', array($item->id), array('class' => 'btn btn-xs btn-default glyphicon glyphicon-envelope', 'title'=>'Ver Mail personalizado', 'target'=>'_blank')) }}
                    {{ link_to_route('ofertas.edit', '', array($item->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil', 'title'=>'Editar datos de la Oferta')) }}
                    @if($item->inscriptos == 0)
                        {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $item->id))) }}
                        {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger')) }}
                        {{ Form::close() }}
                    @else
                        {{ Former::disabled_button('Borrar')->disabled()->title("No se puede eliminar: hay inscriptos.")->class('btn btn-xs') }}
                    @endif
                @else
                    <small>No tiene permisos para esta oferta</small>
                @endif
                </td>
                <td>{{ $item->ultimaModificacion->nombreyapellido }} ({{ ($item->fecha_modif) }})</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="alert alert-info">Sin resultados.</div>
@endif

<script>
    var options = {
      valueNames: [ 'anio', 'nombre' ]
    };
    var divCarrerasList = new List('divCarreras', options);
    
</script>