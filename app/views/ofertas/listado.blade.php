@if ($ofertas->count())
<div id='divOfertas'>
    <br>
    <div class="btn-group">
        <input class="search" placeholder="Buscar por Año o Nombre" id="inputBuscarOfertasIndex"/>
        <button class="sort" data-sort="anio" >Año</button>
        <button class="sort" data-sort="nombre" >Nombre</button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre de Oferta</th>
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
        <tbody class="list">
            @foreach ($ofertas as $oferta)
            <tr>
                <td class="nombre" title="Creador: {{ $oferta->creador->nombreyapellido }}">{{ $oferta->nombre }}</td>
                <td class="anio">{{ $oferta->anio }}</td>
                <td>
                    {{ $oferta->inscriptos }}
                    @if((int)$oferta->cupo_maximo > 0)
                        de {{$oferta->cupo_maximo}}
                        @if($oferta->inscriptos > $oferta->cupo_maximo)
                            <span class="text-danger glyphicon glyphicon-warning-sign"></span>
                        @endif
                    @endif
                    <small><a href="{{ URL::route('ofertas.inscripciones.show', $oferta->id) }}">[Ver]</a></small>
                </td>
                <td>
                    {{ BS3::bool_to_label($oferta->permite_inscripciones) }}                
                    <?php //if(($userPerfil == "Administrador")||($item->user_id_creador == $userId)):?>
                        <?php if(!$oferta->estaFinalizada()): ?>
                            <small><a title="Formulario de Inscripción a la Oferta" class='btn btn-xs btn-info link' href="{{ URL::action('ofertas.inscripciones.create', $oferta->stringAleatorio($oferta->id,15)) }}" target="_blank" ><i class=" glyphicon glyphicon-list-alt"></i></a></small>
                        <?php endif; ?>
                     <?php //endif; ?>                     
                     
                        <!-- Muestro el modal con un button -->
                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalCopyLink<?php echo $oferta->id ?>"><i class='glyphicon glyphicon-link'></i></button>
                        <!-- Modal -->
                        <div id="modalCopyLink<?php echo $oferta->id ?>" class="modal fade" role="dialog">
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
                                            $texto = URL::action('ofertas.inscripciones.create', $oferta->stringAleatorio($oferta->id,15)); 
                                            $linkPublico = obtenerLinkPublico($texto);
                                            $idInput = "linkPublico".$oferta->id;
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
                <!--<td>{{ ModelHelper::dateOrNull($oferta->inicio) }}</td>
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
                </td>-->
                <td>{{ $oferta->ultimaModificacion->nombreyapellido }} ({{ ($oferta->fecha_modif) }})</td>
                <td>
                  <?php $capacitadores = $oferta->obtenerCapacitadoresDeLaOferta($oferta->id);?>
                  <?php if($capacitadores != null): ?>
                    <div class="row-fluid">
                  <!-- Muestro el formulario para Editar los capacitadores de esta oferta -->
                    <!-- Modal del Form para editar los Capacitadores a una Oferta -->
                        
                        <!-- Muestro el modal con un button -->
                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEditCapacitador<?php echo $oferta->id ?>"><i class='glyphicon glyphicon-pencil'></i></button>                        
                        <!-- Modal -->
                        <div id="modalEditCapacitador<?php echo $oferta->id ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content -->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modificar los Capacitadores para <b>{{ $oferta->nombre }}</b></h4>
                              </div>
                              <div class="modal-body">
                                <fieldset>
                                    <div class="row-fluid">
                                        <div class="alert alert-success">
                                            Descargar listado:
                                            <a href="{{ URL::Route('ofertas.index', array('ofid' => $oferta->id, 'exp' => 'xlscapes')) }}" target="_blank" title="Exportar listado de Capacitadores a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
                                            <a href="{{ URL::Route('ofertas.index', array('ofid' => $oferta->id, 'exp' => 'pdfcapes')) }}" target="_blank" title="Exportar listado de Capacitadores a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <th>Capacitador</th>
                                            <th>Rol</th>
                                            <th>Email</th>
                                            <th>Certificado</th>
                                            @if(!$oferta->estaFinalizada())
                                                @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                                    <th>Acciones</th>
                                                @endif
                                            @endif
                                        </thead>
                                        <tbody>                                      
                                          @foreach($capacitadores as $cap)
                                          <tr>
                                            <?php $capacRol = RolCapacitador::find($cap->rol_id); ?>
                                            <?php $capacPersonal = Personal::find($cap->personal_id); ?>
                                            <td><?php echo $capacPersonal->getApellidoYNombre() ?></td>
                                            <td><?php echo $capacRol->rol ?></td>
                                            <td>@if($capacPersonal->getEmail() != null){{$capacPersonal->getEmail()}}@else {{'-'}}@endif</td>
                                            <td>
                                                <?php 
                                                    $nomb = $oferta->cert_base_cap_file_name;
                                                    $hs = $oferta->duracion_hs;
                                                    $resol = $oferta->resolucion_nro;
                                                    $fechafinoferta = $oferta->fecha_fin_oferta;
                                                ?>
                                                <?php if (($nomb != null)&&($fechafinoferta != null)): ?>
                                                    <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.index', array('ofid' => $oferta->id, 'exp' => 'pdfcap', 'cap' => $cap->id )) }}" title="Certificado para el Capacitador"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                                    <?php if ($capacPersonal->getEmail() != null): ?>
                                                        <a class="btn btn-xs btn-primary" href="{{ URL::Action('ofertas.enviarMailCertificadoCapacitador', array('capid' => $cap->id )) }}" title="Enviar el certificado por mail al Capacitador"><span class='glyphicon glyphicon-envelope'></span></a>
                                                    <?php endif;?>
                                                <?php else: ?>
                                                    {{ link_to_route('ofertas.edit', '', array($oferta->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                                                <?php endif; ?>
                                            </td>
                                            @if(!$oferta->estaFinalizada())
                                                @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                                <td>
                                                  {{ link_to_route('capacitador.edit', ' ', array($cap->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos del capacitador.')) }}
                                                  {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('capacitador.destroy', $cap->id))) }}
                                                    <input id='mjeBorrar' value="¿Está seguro que desea eliminar esta Oferta?" type="hidden" />
                                                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar los datos del capacitador')) }}
                                                  {{ Form::close() }}
                                                </td>
                                                @endif
                                            @endif
                                          </tr>
                                          @endforeach                                      
                                        </tbody>
                                    </table>
                                    @if(!$oferta->estaFinalizada())
                                        @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                            <div class='row-fluid'>
                                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $oferta->id ?>"> Agregar más</button>
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
                        @if(!$oferta->estaFinalizada())
                            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                                @if($capacitadores != null)
                                    <!-- Muestro el modal con un button -->
                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $oferta->id ?>"><i class='glyphicon glyphicon-plus-sign'></i> Agregar otro</button>
                                @else
                                    <!-- Muestro el modal con un button -->
                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $oferta->id ?>"><i class='glyphicon glyphicon-plus-sign'></i></button>
                                @endif
                            @endif
                        @endif
                        <!-- Modal -->
                        <div id="modalNewCapacitador<?php echo $oferta->id ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content -->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Capacitadores para <b>{{ $oferta->nombre }}</b></h4>
                              </div>
                              <div class="modal-body">
                                <fieldset>
                                {{ Form::open(array('route' => 'ofertas.agregarcapacitadores', 'class' => 'form-inline', 'data-toggle' => 'validator')) }}
                                <div class="input_fields_wrap" style="padding: 5px">

                                    <input type="hidden" name='listaCapacitadores[]' id='oferta_id_selec' value="<?php echo $oferta->id ?>" >

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
                            <li class="dropdown-header">Datos de la Oferta</li>
                            <li style="padding: 3px 20px;">Inicio: {{ $oferta->inicio }}</li>
                            <li style="padding: 3px 20px;">Fin: {{ $oferta->fin }}</li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Opciones básicas</li>
                            @if(($userPerfil == "Administrador")||($oferta->user_id_creador == $userId))
                                <li>{{ link_to_route('ofertas.vermail', 'Ver mail', array($oferta->id), array('title'=>'Ver Mail personalizado', 'target'=>'_blank')) }}</li>
                                @if(!$oferta->estaFinalizada())
                                    <li>{{ link_to_route('ofertas.edit', 'Editar Oferta', array($oferta->id), array('title'=>'Editar datos de la Oferta')) }}</li>
                                @endif                                
                                @if(($oferta->inscriptos == 0) && (!$oferta->estaFinalizada()) && ($userPerfil == "Administrador"))
                                    {{ Form::open(array('class' => 'confirm-delete', 'method' => 'DELETE', 'route' => array('ofertas.destroy', $oferta->id))) }}
                                        <li style="padding: 3px 20px;">{{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger')) }}</li>
                                    {{ Form::close() }}
                                @else
                                    <li style="padding: 3px 20px;">{{ Former::disabled_button('Borrar')->disabled()->title("No se puede eliminar: hay inscriptos.")->class('btn btn-xs') }}</li>
                                @endif
                                @if(!$oferta->estaFinalizada())
                                    <li>{{ link_to_route('ofertas.finalizar', 'Finalizar Oferta', array($oferta->id), array('title'=>'Finalizar la Oferta (no se harán más cambios.')) }}</li>
                                @else
                                    @if($userPerfil == "Administrador")
                                        <li>{{ link_to_route('ofertas.desfinalizar', 'Desfinalizar Oferta', array($oferta->id), array('title'=>'Desfinalizar la Oferta (se permite hacer cambios.')) }}</li>
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
    <div class="alert alert-info">Sin resultados.</div>
@endif

<script>
    var options = {
      valueNames: [ 'anio', 'nombre' ]
    };
    var divOfertasList = new List('divOfertas', options);        
    
    
</script>