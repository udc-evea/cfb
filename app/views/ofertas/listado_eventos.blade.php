@if ($eventos->count())
<table class="table table-striped">
    <thead>
        <tr>
            <th>Evento Nombre</th>
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
        @foreach ($eventos as $item)
        <tr>
            <td title="Creador: {{ $item->creador->nombreyapellido }}">{{ $item->nombre }}</td>
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
                {{ link_to_route('ofertas.vermail', '', array($item->id), array('class' => 'btn btn-xs btn-default glyphicon glyphicon-envelope', 'title'=>'Ver Mail personalizado')) }}
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
            <td>{{ $item->ultimaModificacion->nombreyapellido }} ({{ $item->fecha_modif }})</td>
            <td>
              <?php $capacitadores = $item->obtenerCapacitadoresDeLaOferta($item->id);?>
              <?php if($capacitadores != null): ?>
                <div class="row-fluid">
              <!-- Muestro el formulario para Editar los capacitadores de esta oferta -->
                <!-- Modal del Form para editar los Capacitadores a una Oferta -->
                
                    <!-- Muestro el modal con un button -->
                    <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEditCapacitador<?php echo $item->id ?>"><i class='glyphicon glyphicon-pencil'></i></button>
                    <!-- Modal -->
                    <div id="modalEditCapacitador<?php echo $item->id ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content -->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modificar los Capacitadores para <b>{{ $item->nombre }}</b></h4>
                          </div>
                          <div class="modal-body">
                            <fieldset>
                                <table class="table table-striped">
                                    <thead>
                                        <th>Capacitador</th>
                                        <th>Rol</th>
                                        <th>Certificado</th>
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
                                            <?php $name = $item->cert_base_cap_file_name ?>
                                            <?php if ($name != null): ?>
                                                <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.index', array('ofid' => $item->id, 'exp' => 'pdfcap', 'cap' => $cap->id )) }}" title="Certificado para el Capacitador"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                            <?php else: ?>
                                                {{ link_to_route('ofertas.edit', '', array($item->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                                            <?php endif; ?>
                                        </td>
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
                                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $item->id ?>"> Agregar más</button>
                                    <a href="{{ URL::Route('ofertas.index', array('ofid' => $item->id, 'exp' => 'xlscapes')) }}" target="_blank" title="Exportar listado de Capacitadores a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
                                    <a href="{{ URL::Route('ofertas.index', array('ofid' => $item->id, 'exp' => 'pdfcapes')) }}" target="_blank" title="Exportar listado de Capacitadores a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                </div>
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
                
                    <!-- Muestro el modal con un button -->
                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewCapacitador<?php echo $item->id ?>"><i class='glyphicon glyphicon-plus-sign'></i></button>
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
<br>
<?php //$listaAsoc = Session::get('listaCapacitadores'); $lista = Session::get('lista');
      //echo "<br>Asoc: ".var_dump($listaAsoc);
      //echo "<br><br>del Form: ".var_dump($lista)."<br>";
      //echo "<hr><br>Asociativo: ".var_dump($listaAsoc)."<br>";
                ?>

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
</script>

@else
<div class="alert alert-info">Sin resultados.</div>
@endif