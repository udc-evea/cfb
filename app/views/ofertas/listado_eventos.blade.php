@if ($eventos->count())
<div id='divEventos' style="margin-top: 30px">
    <br>
    <div class="btn-group">
        <input class="search" placeholder="Buscar por Año o Nombre" id="inputBuscarEventosIndex"/>
        <button class="sort" data-sort="anio" >Año</button>
        <button class="sort" data-sort="nombre" >Nombre</button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre de Evento</th>
                <th>Año</th>
                <th>Pre-Inscriptos</th>
                <th>Inscribiendo</th>
                <!--<th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>-->
                <th>Ultima Modif.</th>
                <th>Capacitador/es</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody class='list'>
            @foreach ($eventos as $item)
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
                    <small><a href="{{ URL::route('ofertas.inscripciones.show', $item->id) }}">[Ver]</a></small>
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
                <td>{{ $item->ultimaModificacion->nombreyapellido }} ({{ $item->fecha_modif }})</td>
                <td>
                  <?php $capacitadores = $item->obtenerCapacitadoresDeLaOferta($item->id);?>
                  <?php if($capacitadores != null): ?>
                    <div class="row-fluid">
                  <!-- Muestro el formulario para Editar los capacitadores de esta oferta -->
                    <!-- Modal del Form para editar los Capacitadores a una Oferta -->

                        <!-- Muestro el modal con un button -->
                        <button type="button" title="Editar los datos de los capacitadores de la Oferta" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEditCapacitador<?php echo $item->id ?>"><i class='glyphicon glyphicon-pencil'></i></button>
                        <!-- Modal -->
                        <div id="modalEditCapacitador<?php echo $item->id ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content -->
                            <div class="modal-content" style="width: 120%">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modificar los Capacitadores para <b>{{ $item->nombre }}</b></h4>
                              </div>
                              <div class="modal-body">
                                <fieldset>
                                    <div class="row-fluid">
                                        <div class="alert alert-success">
                                            Descargar listado:
                                            <a href="{{ URL::Route('ofertas.index', array('ofid' => $item->id, 'exp' => 'xlscapes')) }}" target="_blank" title="Exportar listado de Capacitadores a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
                                            <a href="{{ URL::Route('ofertas.index', array('ofid' => $item->id, 'exp' => 'pdfcapes')) }}" target="_blank" title="Exportar listado de Capacitadores a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <th>Capacitador</th>
                                            <th>Rol</th>
                                            <th>Email</th>
                                            <th>Certificado</th>
                                            @if(!$item->estaFinalizada())
                                                @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                                    <th>Acciones</th>
                                                @endif
                                            @endif
                                        </thead>
                                        <tbody>                                      
                                          @foreach($capacitadores as $cap)
                                          <tr>
                                            <?php $capacitador = Capacitador::find($cap->id); ?>
                                            <?php $capacRol = RolCapacitador::find($cap->rol_id); ?>
                                            <?php $capacPersonal = Personal::find($cap->personal_id); ?>
                                            <td><?php echo $capacPersonal->getApellidoYNombre() ?></td>
                                            <td><?php echo $capacRol->rol ?></td>
                                            <td>@if($capacPersonal->getEmail() != null){{$capacPersonal->getEmail()}}@else {{'-'}}@endif</td>
                                            <td>
                                                <?php $name = $item->cert_base_cap_file_name ?>
                                                <?php if ($name != null): ?>
                                                    <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.index', array('ofid' => $item->id, 'exp' => 'pdfcap', 'cap' => $cap->id )) }}" title="Certificado para el Capacitador"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                                    <?php if (($capacPersonal->getEmail() != null)&&($item->enviarCertificadoCapacitadorDigital())): ?>
                                                        <a class="btn btn-xs btn-primary" href="{{ URL::Action('ofertas.enviarMailCertificadoCapacitador', array('capid' => $cap->id )) }}" title="Enviar el certificado por mail al Capacitador">{{$capacitador->getCantNotificacionesConCertificado()}} <span class='glyphicon glyphicon-envelope'></span></a>
                                                    <?php endif;?>
                                                <?php else: ?>
                                                    {{ link_to_route('ofertas.edit', '', array($item->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                                                <?php endif; ?>
                                            </td>
                                            @if(!$item->estaFinalizada())
                                                @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                                <td>

                                                    {{ link_to_route('capacitador.edit', ' ', array($cap->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos del capacitador.')) }}
                                                    {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('capacitador.destroy', $cap->id))) }}
                                                      {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar los datos del capacitador')) }}
                                                    {{ Form::close() }}
                                                </td>
                                                @endif
                                            @endif
                                          </tr>
                                          @endforeach                                      
                                        </tbody>
                                    </table>
                                    @if(!$item->estaFinalizada())
                                        @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                            <div class='row-fluid'>
                                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $item->id ?>"> Agregar más</button>
                                                <?php if ($item->enviarCertificadoCapacitadorDigital()): ?>
                                                <a class="btn btn-xs btn-info" href="{{ URL::Action('ofertas.enviarMailCertificadosCapacitadores', array('ofid' => $item->id)) }}" title="Enviar todos  los Certificados a los Capacitadores de esta Oferta a sus mails particulares.">Enviar todos los Certificados  <span class='glyphicon glyphicon-envelope'></span> </a>
                                                <?php endif; ?>
                                            </div>
                                        @endif
                                    @endif
                                </fieldset>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>

                          </div>
                        </div>

                  <?php endif;//else: ?>
                  <!-- Muestro el formulario para Agregar los capacitadores de esta oferta -->                                                    
                    <!-- Modal del Form para agregar Capacitadores a una Oferta -->
                        @if(!$item->estaFinalizada())
                            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                @if($capacitadores != null)
                                    <!-- Muestro el modal con un button -->
                                    <button type="button" title="Agregar un nuevo capacitador a la Oferta" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $item->id ?>"><i class='glyphicon glyphicon-plus-sign'></i></button>
                                @else
                                    <!-- Muestro el modal con un button -->
                                    <button type="button" title="Agregar un nuevo capacitador a la Oferta" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $item->id ?>"><i class='glyphicon glyphicon-plus-sign'></i></button>
                                @endif
                            @endif
                        @endif
                        <!-- Modal -->
                        <div id="modalNewCapacitador<?php echo $item->id ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content -->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Capacitadores para <b>{{ $item->nombre }}</b></h4>
                              </div>
                              <div class="modal-body">
                                <fieldset>
                                {{ Form::open(array('route' => 'ofertas.agregarcapacitadores', 'class' => 'form-inline', 'data-toggle' => 'validator')) }}
                                <div class="input_fields_wrap" style="padding: 5px">

                                    <input type="hidden" name='listaCapacitadores[]' id='oferta_id_selec' value="<?php echo $item->id ?>" >

                                    <div style="margin-left: 40px">
                                       <div class="form-group">
                                           <div class="input-group">
                                               <div class="input-group-addon">Personal</div>
                                               <select class="form-control" name='listaCapacitadores[]' required>
                                                   <option></option>
                                                   @foreach($personal as $pers)
                                                       <option value="{{$pers->id}}">{{ $pers->apellido }}, {{ $pers->nombre }}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                       </div> 

                                       <div class="form-group">
                                           <div class="input-group">
                                           <div class="input-group-addon">Rol</div>
                                               <select class="form-control" name='listaCapacitadores[]' required>
                                                   <option></option>
                                                   @foreach($roles as $rol)
                                                       <option value="{{$rol->id}}">{{ $rol->rol }}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                       </div> 
                                    </div>
                                </div>
                                <hr>
                                <div class="alert alert-info">
                                    <button class="add_field_button btn btn-xg btn-success"><i class="glyphicon glyphicon-plus"></i> Agregar otro</button>
                                    {{ Form::submit('Guardar', array('class' => 'btn btn-xg btn-primary')) }}                                    
                                </div>

                                {{ Form::close() }}
                                </fieldset>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>

                          </div>
                        </div>
                    </div>
                  <?php //endif; ?>
                </td>
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
    <br>
    <?php //$listaAsoc = Session::get('listaCapacitadores'); $lista = Session::get('lista');
          //echo "<br>Asoc: ".var_dump($listaAsoc);
          //echo "<br><br>del Form: ".var_dump($lista)."<br>";
          //echo "<hr><br>Asociativo: ".var_dump($listaAsoc)."<br>";
                    ?>
@else
    <div class="alert alert-info">Sin resultados.</div>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        var max_fields      = 4; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="input_fields_wrap" style="padding: 5px"><div style="margin-left: 40px"><div class="form-group"><div class="input-group"><div class="input-group-addon">Personal</div><select class="form-control" name="listaCapacitadores[]" required><option></option>@foreach($personal as $pers)<option value="{{$pers->id}}">{{ $pers->apellido }}, {{ $pers->nombre }}</option>@endforeach</select></div></div><div class="form-group"><div class="input-group"><div class="input-group-addon">Rol</div><select class="form-control" name="listaCapacitadores[]" required><option></option>@foreach($roles as $rol)<option value="{{$rol->id}}">{{ $rol->rol }}</option>@endforeach</select></div></div><a href="#" class="remove_field btn btn-xs btn-primary" alt="Quitar renglón"><i class="glyphicon glyphicon-minus"></i></a></div></div>');
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        });        
    });
    
    var options = {
      valueNames: [ 'anio', 'nombre' ]
    };
    var divEventosList = new List('divEventos', options);    
    
</script>