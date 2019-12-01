<div class="container">      
    @if (count($inscripciones))
        <div class="divTotales">
            <div><h4>Total: {{ count($inscripciones) }}</h4></div>
            <div> (
                <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsi')) }}" target="_blank" title="Exportar listado solo de Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
                <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfi')) }}" target="_blank" title="Exportar listado solo de Inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
                @if($perfil == "Administrador")
                    <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'csv')) }}" target="_blank" title="Exportar listado solo de Inscriptos a CSV"><i class="fa fa-file-text-o"></i></a>
                @endif
             )</div>
        </div>
    @endif
    @if (count($inscripciones))
    <div id='inscriptos'>
        <input class="search" placeholder="Buscar por Nro. o Apellido" id="inputBuscarEvInscrIndex" onchange="verificarListaCompleta('inputBuscarEvInscrIndex','btnSubmitFormEvInscrIndex')"/>
        <button class="sort" data-sort="nroinsc" >Por Nro.</button>
        <button class="sort" data-sort="apellidoinsc" >Por Apellido</button>
        <div class="btn-group" role="group" style="float:right">
            <a href="{{URL::route('ofertas.inscripciones.certificarTodosLosAlumnos', $oferta->id)}}" class="btn btn-success btn-secondary" title="Colocar a todos los inscriptos como Asistentes"><i class="glyphicon glyphicon-check"></i> Asistieron todos</a>
            <a href="{{URL::route('ofertas.inscripciones.quitarTodasLasInscripciones', $oferta->id)}}" class="btn btn-warning btn-secondary" title="Quitar a todos los alumnos inscriptos (también los quita si asistieron o no al evento)"><i class="glyphicon glyphicon-minus-sign"></i> Quitar inscripciones</a>
        </div>
        <?php $listaIdInscriptos = array();?>
        {{ Form::open(array(
                    'method' => 'POST',
                    'action' => array('OfertasInscripcionesController@cambiarAsistentes', $oferta->id))) }}
            <table class="table table-condensed" style="border-top: 2px black solid; border-bottom: 2px black solid">
                <thead>
                    <tr>
                        <th>Nro.</th>
                        <th>Apellidos y Nombres</th>
                        <!-- <th>Nombre</th> -->
                        @if($perfil != "Colaborador")
                            <th>Documento</th>
                        @endif
                        <!-- <th>Localidad</th> 
                        <th>Email Personal</th> -->
                        @if($perfil != "Colaborador")
                            <th>Email UDC</th>
                        @endif
                        <!-- <th>Inscriptos?</th> -->
                        @if((!$oferta->estaFinalizada()) && ($perfil != "Colaborador"))
                            <th>Not. como Inscripto</th>
                            @if($perfil == "Administrador")
                                <th>Not. mail Institucional</th>
                            @endif
                        @endif
                        @if((!$oferta->estaFinalizada()) && (($perfil == "Administrador")||($perfil == "Creador")))
                            <th>Asistio?</th>
                        @endif
                        <!-- <th>Acciones</th> -->
                    </tr>
                </thead>
                <tbody class="list">
                    <?php $i = 1;?>
                    @foreach ($inscripciones as $inscripcion)
                        <?php $listaIdInscriptos[] = $inscripcion->id; ?>
                        <tr>
                            <td class="nroinsc">{{ $i }}</td>
                            <td class="apellidoinsc">{{ $inscripcion->apellido }}, {{ $inscripcion->nombre }}</td>
                            <!-- <td>{{ $inscripcion->nombre }}</td> -->
                            @if($perfil != "Colaborador")
                                <td>{{{ $inscripcion->tipoydoc }}}</td>
                            @endif
                            <!-- <td>{{ $inscripcion->localidad->la_localidad }}</td> 
                            <td>{{{ $inscripcion->email }}}</td> -->
                            @if($perfil != "Colaborador")
                                <td>{{ $inscripcion->email_institucional }}</td>
                            @endif
                            <!-- <td>
                                <div class="slideTwo">
                                @if ($inscripcion->getEsInscripto())
                                    <input type="checkbox" name="inscripto[<?php //echo $inscripcion->id ?>]" id="slideTwo<?php //echo $inscripcion->id ?>" value='1' checked='checked'><label for="slideTwo<?php //echo $inscripcion->id ?>"></label>
                                @else
                                    <input type="checkbox" name="inscripto[<?php //echo $inscripcion->id ?>]" id="slideTwo<?php //echo $inscripcion->id ?>" value='1'><label for="slideTwo<?php //echo $inscripcion->id ?>"></label>
                                @endif
                                </div>
                            </td> -->
                            @if((!$oferta->estaFinalizada()) && ($perfil != "Colaborador"))
                            <td>
                                @if ($inscripcion->getEsInscripto())
                                    @if ($inscripcion->getCantNotificacionesInscripto() > 0)
                                       @if ($inscripcion->getCantNotificacionesInscripto() == 1)
                                            {{ link_to_route('ofertas.inscripciones.enviarMailNuevoInscripto', $inscripcion->getCantNotificacionesInscripto().' vez', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail notificando que ya es Inscripto.')) }}
                                       @else
                                            {{ link_to_route('ofertas.inscripciones.enviarMailNuevoInscripto', $inscripcion->getCantNotificacionesInscripto().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail notificando que ya es Inscripto.')) }}
                                       @endif
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.enviarMailNuevoInscripto', 'nunca', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger','title'=>'Enviar mail notificando que ya es Inscripto.')) }}
                                    @endif
                                @else
                                    <button style="width: 50px" class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" title="No Corresponde"></button>
                                @endif
                            </td>
                                @if($perfil == "Administrador")
                                <td>
                                    @if ($inscripcion->getEsInscripto())
                                        @if ($inscripcion->getCantNotificaciones() > 0)
                                           @if ($inscripcion->getCantNotificaciones() == 1)
                                                {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' vez', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                           @else
                                                {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                           @endif
                                        @else
                                           {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', 'nunca', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                        @endif
                                    @else
                                        <button style="width: 50px" class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" title="No Corresponde"></button>
                                    @endif
                                </td>
                                @endif
                            @endif
                            @if((!$oferta->estaFinalizada()) && (($perfil == "Administrador")||($perfil == "Creador")))
                            <td>
                                <div class="slideTwo">
                                    @if ($inscripcion->getEsAsistente())
                                        <input type="checkbox" name="asistente[<?php echo $inscripcion->id ?>]" id="slideTwoA<?php echo $inscripcion->id ?>" value='1' checked='checked'><label for="slideTwoA<?php echo $inscripcion->id ?>"></label>
                                    @else
                                        <input type="checkbox" name="asistente[<?php echo $inscripcion->id ?>]" id="slideTwoA<?php echo $inscripcion->id ?>" value='1'><label for="slideTwoA<?php echo $inscripcion->id ?>"></label>
                                    @endif
                                </div>
                            </td>
                            @endif
                            <!-- <td>
                                {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
                                
                                @if($perfil != "Colaborador")
                                    {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                        {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar Inscripto')) }}
                                    {{ Form::close() }}
                                @endif
                            </td> -->
                        </tr>                  
                        <?php $i++;?>
                    @endforeach
                    </tbody>
            </table>
            <?php $listaEnString = implode('-',$listaIdInscriptos); ?>
            <input type="hidden" id="listaIdInscriptos" name="listaIdInscriptos" value="<?php echo $listaEnString ?>">
            @if((!$oferta->estaFinalizada()) && ($perfil == "Administrador"))
            <div class="btn-group" role="group" style="float: right">
                {{ Form::submit('Guardar cambios', array('class' => 'btn btn-success btn-secondary', 'title'=>'Guardar cambios.', 'id'=>'btnSubmitFormEvInscrIndex')) }}
                {{ Form::reset('Descartar cambios', ['class' => 'form-button btn btn-warning btn-secondary'])}}
                {{ Form::close() }}
            </div>
            @endif
    </div>
    @else
        <br>
        <h2>Aún no hay inscriptos en esta oferta.</h2>
        <p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
    @endif
</div>

<script>
    var options = {
      valueNames: [ 'apellidoinsc', 'nroinsc' ]
    };

    var inscriptosList = new List('inscriptos', options);
</script>
