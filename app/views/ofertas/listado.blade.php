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
            <th>Capacitador/es</th>
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
                                <table class="table table-striped">
                                    <thead>
                                        <th>Capacitador</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>                                      
                                      @foreach($capacitadores as $cap)
                                      <tr>
                                        <?php $capacRol = RolCapacitador::find($cap->rol_id); ?>
                                        <?php $capacPersonal = Personal::find($cap->personal_id); ?>
                                        <td><?php echo $capacPersonal->getApellidoYNombre() ?></td>
                                        <td><?php echo $capacRol->rol ?></td>
                                        <td>
                                          {{ link_to_route('capacitador.edit', ' ', array($cap->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-pencil','title'=>'Editar los datos del capacitador.')) }}
                                          {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'delete', 'route' => array('capacitador.destroy', $cap->id))) }}
                                            {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar los datos del capacitador')) }}
                                          {{ Form::close() }}
                                        </td>
                                      </tr>
                                      @endforeach                                      
                                    </tbody>
                                </table>
                                <div class='row-fluid'>
                                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $oferta->id ?>"> Agregar más</button>
                                </div>
                            </fieldset>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                
              <?php endif;//else: ?>
              <!-- Muestro el formulario para Agregar los capacitadores de esta oferta -->                                                    
                <!-- Modal del Form para agregar Capacitadores a una Oferta -->
                
                    <!-- Muestro el modal con un button -->
                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $oferta->id ?>"><i class='glyphicon glyphicon-plus-sign'></i></button>
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
                                {{ Form::submit('Guardar', array('class' => 'btn btn-xg btn-primary')) }}
                                <button class="add_field_button btn btn-xg btn-success"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                                    
                            {{ Form::close() }}
                            </fieldset>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                </div>
              <?php //endif; ?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">Sin resultados.</div>
@endif