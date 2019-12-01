@if ($carreras->count())
<div id='divCarreras' style="margin-top: 30px">
    <br>
    <input class="search" placeholder="Buscar por Año o Nombre" id="inputBuscarCarrerasIndex"/>
    <button class="sort" data-sort="anio" >Año</button>
    <button class="sort" data-sort="nombre" >Nombre</button>
    <div style="float:right">
        @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
            {{ link_to_route('ofertas.create', 'Crear nueva Carrera', ['tab_activa' => 'carreras'], array('class' => 'btn btn-primary')) }}
        @endif
    </div>    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre de Carrera</th>
                <th>Año</th>
                <th>Pre-Inscriptos</th>
                <th>Inscribiendo</th>
                <!--<th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>-->
                <th>Ultima Modif.</th>
                <th>Opciones</th>
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
                        <?php Session::set('tab_activa_inscripciones',1); ?>
                        <small><a href="{{ URL::route('ofertas.inscripciones.show', $item->id) }}">[Ver]</a></small>
                    @endif
                </td>
                <td>
                    {{ BS3::bool_to_label($item->permite_inscripciones) }}
                    <?php //if(($userPerfil == "Administrador")||($item->user_id_creador == $userId)):?>
                        @if(!$item->estaFinalizada())
                            <small><a title="Formulario de Inscripción a la Oferta" class='btn btn-xs btn-info' href="{{ URL::action('ofertas.inscripciones.create', $item->stringAleatorio($item->id,15)) }}" target="_blank"><i class=" glyphicon glyphicon-list-alt"></i></a></small>
                        @endif
                    <?php //endif; ?>
                    <!-- Muestro el modal con un button -->
                    <button type="button" title="Obtener el link público del formulario de inscripción a la Oferta" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalCopyLink<?php echo $item->id ?>"><i class='glyphicon glyphicon-link'></i></button>
                    <!-- Modal -->
                    <div id="modalCopyLink<?php echo $item->id ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content -->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Copiar el enlace al Formuario Público de Inscripción</h4>
                          </div>
                          <div class="modal-body">
                            <fieldset>
                                <div class="row-fluid">
                                    <?php 
                                        $texto = URL::action('ofertas.inscripciones.create', $item->stringAleatorio($item->id,15)); 
                                        $linkPublico = obtenerLinkPublico($texto);
                                        $idInput = "linkPublico".$item->id;
                                    ?>
                                    <!--<input style="width: 100%" id="linkPublico" value="<?php //echo $linkPublico?>"/><br>-->
                                    <input style="width: 100%" id="<?php echo $idInput?>" value="<?php echo $linkPublico?>"/><br>
                                    <button class="btn btn-xs btn-info" title="Obtener el link público del formulario de inscripción" onclick="copiarAlPortapapeles('<?php echo $idInput ?>','<?php echo $linkPublico ?>')" ><i class="glyphicon glyphicon-link"></i> Copiar link al portapapeles</button>
                                </div>                                    
                            </fieldset>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>

                      </div>
                    </div>
                </td>
                <!--<td>{{ ModelHelper::dateOrNull($item->inicio) }}</td>
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
                </td>-->
                <td>{{ $item->ultimaModificacion->nombreyapellido }} ({{ ($item->fecha_modif) }})</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Más
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Fecha preinscripciones</li>
                            <li style="padding: 3px 20px;">Inicio: {{ $item->inicio }}</li>
                            <li style="padding: 3px 20px;">Fin: {{ $item->fin }}</li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Opciones básicas</li>
                            @if(($userPerfil == "Administrador")||($item->user_id_creador == $userId))
                                <li>{{ link_to_route('ofertas.vermail', 'Ver mail', array($item->id), array('title'=>'Ver Mail personalizado', 'target'=>'_blank')) }}</li>
                                @if(!$item->estaFinalizada())
                                    <li>{{ link_to_route('ofertas.edit', 'Editar Oferta', array($item->id), array('title'=>'Editar datos de la Oferta')) }}</li>
                                @endif
                                @if(($item->inscriptos == 0) && (!$item->estaFinalizada()) && ($userPerfil == "Administrador"))
                                    {{ Form::open(array('class' => 'confirm-delete', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $item->id))) }}
                                        <li style="padding: 3px 20px;">{{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger')) }}</li>
                                    {{ Form::close() }}
                                @else
                                    <li style="padding: 3px 20px;">{{ Former::disabled_button('Borrar')->disabled()->title("No se puede eliminar: hay inscriptos.")->class('btn btn-xs') }}</li>
                                @endif
                                @if(!$item->estaFinalizada())
                                    <li>{{ link_to_route('ofertas.finalizar', 'Finalizar Oferta', array($item->id), array('title'=>'Finalizar la Oferta (no se harán más cambios.')) }}</li>
                                @else
                                    @if($userPerfil == "Administrador")
                                        <li>{{ link_to_route('ofertas.desfinalizar', 'Desfinalizar Oferta', array($item->id), array('title'=>'Desfinalizar la Oferta (se permite hacer cambios.')) }}</li>
                                    @endif
                                @endif
                            @else
                                <li><small>No tiene permisos para esta oferta</small></li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div id='divCarreras' style="margin-top: 40px">
        <div style="float:right">
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nueva Carrera', ['tab_activa' => 'carreras'], array('class' => 'btn btn-primary')) }}
            @endif
        </div>
        <div class="alert alert-info">Sin resultados.</div>
    </div>
@endif

<script>
    var options = {
      valueNames: [ 'anio', 'nombre' ]
    };
    var divCarrerasList = new List('divCarreras', options);
    
</script>