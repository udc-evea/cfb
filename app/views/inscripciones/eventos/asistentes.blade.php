<div>                     
    @if (count($asistentes))
            <table class="table table-condensed" style="border-top: 2px black solid; border-bottom: 2px black solid">
                <thead>
                    <tr>
                        <th>Nro.</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        @if($perfil != "Colaborador")
                            <th>Documento</th>
                        @endif
                        <!-- <th>Localidad</th> -->
                        <th>Email Personal</th>
                        @if($perfil != "Colaborador")
                            <th>Email UDC</th>
                            <!-- <th>Inscriptos ({{ count($asistentes) }})?</th>
                            <th>Notificado/a</th> -->
                        @endif
                        <th>Certificado</th>
                        <!-- <th>Acciones</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;?>
                    @foreach ($asistentes as $inscripcion)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{{ $inscripcion->apellido }}}</td>
                            <td>{{ $inscripcion->nombre }}</td>
                            @if($perfil != "Colaborador")
                                <td>{{{ $inscripcion->tipoydoc }}}</td>
                            @endif
                            <!-- <td>{{ $inscripcion->localidad->la_localidad }}</td> -->
                            <td>{{{ $inscripcion->email }}}</td>
                            @if($perfil != "Colaborador")
                                <td>{{{ $inscripcion->email_institucional }}}</td>
                                <!-- <td>
                                    <div class="slideTwo">
                                    @if ($inscripcion->getEsInscripto())
                                        <input type="checkbox" name="inscripto[<?php echo $inscripcion->id ?>]" id="slideTwo<?php echo $inscripcion->id ?>" value='1' checked='checked'><label for="slideTwo<?php echo $inscripcion->id ?>"></label>
                                    @else
                                        <input type="checkbox" name="inscripto[<?php echo $inscripcion->id ?>]" id="slideTwo<?php echo $inscripcion->id ?>" value='1'><label for="slideTwo<?php echo $inscripcion->id ?>"></label>
                                    @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($inscripcion->getEsInscripto())
                                        @if ($inscripcion->getCantNotificaciones() > 0)
                                           @if ($inscripcion->getCantNotificaciones() == 1)
                                                {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' vez', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success')) }}
                                           @else
                                                {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success')) }}
                                           @endif
                                        @else
                                           {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', 'nunca', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger')) }}
                                        @endif
                                    @else
                                    <button style="width: 50px" class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" title="No Corresponde"></button>
                                    @endif
                                </td> -->
                            @endif
                            <td>
                                <?php 
                                    $name = $oferta->cert_base_alum_file_name;
                                    $resolucion = $oferta->resolucion_nro;
                                    $duracionHoras = $oferta->duracion_hs;
                                ?>
                                <?php if (($name != null)&&($resolucion != null)&&($duracionHoras != null)): ?>
                                    <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfas', 'alm' => $inscripcion->id )) }}" title="Certificado de Asistencia del alumno"><i class="fa fa-file-pdf-o fa-3"></i></a>
                                <?php else: ?>
                                    {{ link_to_route('ofertas.edit', '', array($oferta->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                                <?php endif; ?>
                            </td>
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
    @else
        <br>
        <h2>Aún no hay inscriptos en esta oferta.</h2>
        <p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
    @endif
</div>