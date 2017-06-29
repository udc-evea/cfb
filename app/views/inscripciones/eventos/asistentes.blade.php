<div class="container">      
    @if (count($asistentes))
        <div class="divTotales">
            <div><h4>Total: {{ count($asistentes) }}</h4></div>
            <div> (
                <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsas')) }}" target="_blank" title="Exportar listado de asistentes a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
                <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfasist')) }}" target="_blank" title="Exportar listado de asistentes a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>                
             )</div>
        </div>
    @endif    
    @if (count($asistentes))
    <div id='asistentes'>
        <input class="search" placeholder="Buscar por Nro. o Apellido" id="inputBuscarEvAsistIndex"/>
        <button class="sort" data-sort="nroasis" >Por Nro.</button>
        <button class="sort" data-sort="apellidoasis" >Por Apellido</button>
            <table class="table table-condensed" style="border-top: 2px black solid; border-bottom: 2px black solid">
                <thead>
                    <tr>
                        <th>Nro.</th>
                        <th>Apellidos y Nombres</th>
                        <!-- <th>Nombre</th> -->
                        @if($perfil != "Colaborador")
                            <th>Documento</th>
                        @endif
                        <!-- <th>Localidad</th> -->
                        <th>Email Personal</th>
                        @if(($perfil == "Administrador")||($perfil == "Creador"))
                            <th>Email UDC</th>
                            <!-- <th>Inscriptos ({{ count($asistentes) }})?</th>
                            <th>Notificado/a</th> -->                            
                            <th>Certificado</th>
                        @endif
                        <!-- <th>Acciones</th> -->
                    </tr>
                </thead>
                <tbody class="list">
                    <?php $i = 1;?>
                    @foreach ($asistentes as $inscripcion)
                        <tr>
                            <td class="nroasis">{{ $i }}</td>
                            <td class="apellidoasis">{{{ $inscripcion->apellido }}}, {{ $inscripcion->nombre }}</td>
                            <!-- <td>{{ $inscripcion->nombre }}</td> -->
                            @if($perfil != "Colaborador")
                                <td>{{{ $inscripcion->tipoydoc }}}</td>
                            @endif
                            <!-- <td>{{ $inscripcion->localidad->la_localidad }}</td> -->
                            <td>{{{ $inscripcion->email }}}</td>
                            @if(($perfil == "Administrador")||($perfil == "Creador"))
                                <td>{{{ $inscripcion->email_institucional }}}</td>
                                <!-- <td>
                                    <div class="slideTwo">
                                    @if ($inscripcion->getEsInscripto())
                                        <input type="checkbox" name="inscripto[<?php //echo $inscripcion->id ?>]" id="slideTwo<?php //echo $inscripcion->id ?>" value='1' checked='checked'><label for="slideTwo<?php //echo $inscripcion->id ?>"></label>
                                    @else
                                        <input type="checkbox" name="inscripto[<?php //echo $inscripcion->id ?>]" id="slideTwo<?php //echo $inscripcion->id ?>" value='1'><label for="slideTwo<?php //echo $inscripcion->id ?>"></label>
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
                                <td>
                                    <?php 
                                        $name = $oferta->cert_base_alum_file_name;
                                        $resolucion = $oferta->resolucion_nro;
                                        $duracionHoras = $oferta->duracion_hs;
                                    ?>
                                    <?php if ($name != null): ?>
                                        <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfas', 'alm' => $inscripcion->id )) }}" title="Certificado de Asistencia del alumno"> <span class='glyphicon glyphicon-download-alt'></span> <i class="fa fa-file-pdf-o fa-3"></i></a>
                                        <?php if ($oferta->enviarCertificadoAlumnoDigital()): ?>
                                            <a class="btn btn-xs btn-primary" href="{{ URL::Action('ofertas.inscripciones.enviarMailCertificado', array('ofid' => $oferta->id, 'alumnoid' => $inscripcion->id )) }}" title="Enviar el certificado de Aprobación del alumno a sus mails">{{ $inscripcion->getCantNotificacionesConCertificado() }}  <span class='glyphicon glyphicon-envelope'></span></a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        {{ link_to_route('ofertas.edit', '', array($oferta->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                                    <?php endif; ?>
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
        @if(count($asistentes))
            @if(($perfil == "Administrador")||($perfil == "Creador"))
                <div style="float: right">
                    <?php if ($oferta->enviarCertificadoAlumnoDigital()): ?>
                    <a class="btn btn-primary" href="{{ URL::Action('ofertas.enviarMailsConCertificados', array('ofid' => $oferta->id)) }}" title="Enviar todos  los Certificado de Aprobación de los alumnos a sus mails">Enviar todos los Certificados <span class='glyphicon glyphicon-envelope'></span> </a>
                    <?php endif; ?>
                </div>
            @endif
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
      valueNames: [ 'apellidoasis', 'nroasis' ]
    };

    var asistentesList = new List('asistentes', options);
</script>