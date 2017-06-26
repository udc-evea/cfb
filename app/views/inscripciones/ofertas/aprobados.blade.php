@if(count($aprobados))
    <div class="divTotales">
        <div><h4>Total: {{ count($aprobados) }}</h4></div>
        <div> (
            <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsapdos')) }}" target="_blank" title="Exportar listado solo de Aprobados a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
            <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfapdos')) }}" target="_blank" title="Exportar listado solo de Aprobados a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
         )</div>
    </div>
@endif
@if (count($aprobados))
<fieldset>    
	<table class="table" style="border-top: 2px black solid; border-bottom: 2px black solid">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Documento</th>
                    <th>Email</th>
                    @if($perfil != "Colaborador")
                        <th>Email UDC</th>
                        <th>Comision Nro.</th>
                        @if($perfil == "Administrador")
                            <th>Aprobó?</th>
                        @endif
                    @endif
                    <th>Localidad</th>
                    @if(($perfil == "Administrador")||($perfil == "Creador"))                        
                        <th>Certificado</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                   <?php $i = 1; ?>
                   @foreach ($aprobados as $inscripcion)                   
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $inscripcion->apellido }}</td>
                        <td>{{ $inscripcion->nombre }}</td>
                        <td>{{ $inscripcion->tipoydoc }}</td>
                        <td>{{ $inscripcion->email }}</td>
                        @if($perfil != "Colaborador")
                            <td>{{ $inscripcion->email_institucional }}</td>
                            <td>@if($inscripcion->getComisionNro() != 0)
                                    <strong>Com. {{ $inscripcion->getComisionNro() }}</strong>
                                @else
                                    <strong>Sin Com.</strong>
                                @endif
                            </td>
                            @if($perfil == "Administrador")
                            <td>
                                @if(!$oferta->estaFinalizada())
                                    @if ($inscripcion->getEsAprobado())
                                       {{ link_to_route('ofertas.inscripciones.cambiarAprobado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Quitar la persona como Aprobado del curso.')) }}
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.cambiarAprobado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Aprobar al inscripto.')) }}
                                    @endif
                                @else
                                    @if ($inscripcion->getEsAprobado())
                                       Si
                                    @else
                                       No
                                    @endif
                                @endif
                            </td>
                            @endif
                        @endif 
                        <td>{{ $inscripcion->localidad->la_localidad }}</td>
                        @if(($perfil == "Administrador")||($perfil == "Creador"))
                        <td>
                            <?php 
                                $name = $oferta->cert_base_alum_file_name;
                                $resolucion = $oferta->resolucion_nro;
                                $duracionHoras = $oferta->duracion_hs;
                            ?>
                            <?php if ($name != null): ?>
                                <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfa', 'alm' => $inscripcion->id )) }}" title="Certificado de Aprobación del alumnos"> <span class='glyphicon glyphicon-download-alt'></span> <i class="fa fa-file-pdf-o fa-3"></i></a>
                                <?php if ($oferta->esCertificadoTotalmenteDigital()): ?>
                                    <a class="btn btn-xs btn-primary" href="{{ URL::Action('ofertas.inscripciones.enviarMailCertificado', array('ofid' => $oferta->id, 'alumnoid' => $inscripcion->id )) }}" title="Enviar el certificado de Aprobación del alumno a sus mails">{{ $inscripcion->getCantNotificacionesConCertificado() }}  <span class='glyphicon glyphicon-envelope'></span> </a>
                                <?php endif; ?>
                            <?php else: ?>
                                {{ link_to_route('ofertas.edit', '', array($oferta->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                            <?php endif; ?>
                        </td>
                        @endif
                    </tr>
                    <?php $i++;?>
		@endforeach
		</tbody>
	</table>
    @if(count($aprobados))
        @if(($perfil == "Administrador")||($perfil == "Creador"))
            <div style="float: right">
                <?php if ($oferta->esCertificadoTotalmenteDigital()): ?>
                <a class="btn btn-primary" href="{{ URL::Action('ofertas.enviarMailsConCertificados', array('ofid' => $oferta->id)) }}" title="Enviar todos  los Certificado de Aprobación de los alumnos a sus mails">Enviar todos los Certificados  <span class='glyphicon glyphicon-envelope'></span> </a>
                <?php endif; ?>
            </div>
        @endif
    @endif
</fieldset>
<hr>
@else
<br>
<h2>Aún no hay inscriptos en esta oferta.</h2>
<p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>            
@endif
<script>
    function CargarAnterior(){
        window.history.go(-1);
    }
</script>