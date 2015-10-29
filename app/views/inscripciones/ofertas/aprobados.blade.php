<h4>
    @if(count($aprobados))
        Total: {{ count($aprobados) }}
    @endif
</h4>
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