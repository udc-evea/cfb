@if(count($aprobados))
    <div class="divTotales">
        <div><h4>Total: {{ count($aprobados) }}</h4></div>
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
                        <th>Aprobó?</th>
                    @endif
                    <th>Localidad</th>
                    <th>Certificado</th>
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
                            <td>
                                @if ($inscripcion->getEsAprobado())
                                   {{ link_to_route('ofertas.inscripciones.cambiarAprobado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Quitar la persona como Aprobado del curso.')) }}
                                @else
                                   {{ link_to_route('ofertas.inscripciones.cambiarAprobado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Aprobar al inscripto.')) }}
                                @endif
                            </td>
                        @endif 
                        <td>{{ $inscripcion->localidad->la_localidad }}</td>
                        <td>
                            <?php 
                                $name = $oferta->cert_base_alum_file_name;
                                $resolucion = $oferta->resolucion_nro;
                                $duracionHoras = $oferta->duracion_hs;
                            ?>
                            <?php if (($name != null)&&($resolucion != null)&&($duracionHoras != null)): ?>
                                <a target="_blank" class="btn btn-xs btn-warning" href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfa', 'alm' => $inscripcion->id )) }}" title="Certificado de Aprobación del alumnos"><i class="fa fa-file-pdf-o fa-3"></i></a>
                            <?php else: ?>
                                {{ link_to_route('ofertas.edit', '', array($oferta->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-paperclip', 'title'=>'Editar datos de la Oferta')) }}
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $i++;?>
		@endforeach
		</tbody>
	</table>
</fieldset>
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