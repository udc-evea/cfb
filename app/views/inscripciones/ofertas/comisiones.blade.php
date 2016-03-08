<h4>
    @if(count($com))
        Total: {{ count($com) }}
    @endif
</h4>
@if (count($com))
<fieldset>    
	<table class="table" style="border-top: 2px black solid; border-bottom: 2px black solid">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    @if($perfil != "Colaborador")
                        <!-- <th>Documento</th> -->
                    @endif
                    <!-- <th>Localidad</th> -->
                    <th>Documento</th>
                    <th>Email</th>
                    @if($perfil != "Colaborador")
                        <th>Email UDC</th>
                        <!-- <th>Requisitos</th>
                        <th>Inscripto</th> -->
                        <th>Comision Nro.</th>
                        <th>Aprobó?</th>
                        <!-- <th>Notificado/a</th> -->
                    @endif
                    <!-- <th>Acciones</th> -->
                </tr>
            </thead>
            <tbody>
                   <?php $i = 1; ?>
                   @foreach ($com as $inscripcion)
                   <?php
                        $arreglo = $inscripcion->getColoresSegunEstados();
                        $color=$arreglo[0];
                        $bkgcolor=$arreglo[1];
                   ?>                   
                    <tr style="background-color: <?php echo $bkgcolor ?> !important; color: <?php echo $color ?> !important">
                        <td>{{ $i }}</td>
                        <td>{{ $inscripcion->apellido }}</td>
                        <td>{{ $inscripcion->nombre }}</td>
                        @if($perfil != "Colaborador")
                            <!-- <td>{{ $inscripcion->tipoydoc }}</td> -->
                        @endif
                        <!-- <td>{{ $inscripcion->localidad->la_localidad }}</td> -->
                        <td>{{ $inscripcion->tipoydoc }}</td>
                        <td>{{ $inscripcion->email }}</td>
                        @if($perfil != "Colaborador")
                            <td>{{{ $inscripcion->email_institucional }}}</td>
                            <!-- <td>
                                @if ($inscripcion->getRequisitosCompletos())
                                   {{ link_to_route('ofertas.inscripciones.cambiarEstadoDeRequisitos', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Borrar que la persona presentó todos los requisitos.')) }}
                                @else
                                   {{ link_to_route('ofertas.inscripciones.cambiarEstadoDeRequisitos', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Anotar que la persona presentó todos los requisitos.')) }}
                                @endif
                            </td> -->
                            <td>@if ($inscripcion->getEsInscripto())
                                  @if($inscripcion->getComisionNro() > 0)
                                    {{ link_to_route('ofertas.inscripciones.restarComision', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-minus','title'=>'Bajar el nro. de la comisión.')) }}
                                  @endif
                                @endif
                                @if($inscripcion->getComisionNro() != 0)
                                    <strong>Com. {{ $inscripcion->getComisionNro() }}</strong>
                                @else
                                    <strong>Sin Com.</strong>
                                @endif
                                @if ($inscripcion->getEsInscripto())
                                  @if($inscripcion->getComisionNro() < 10)
                                    {{ link_to_route('ofertas.inscripciones.sumarComision', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-plus','title'=>'Sumar el nro. de la comisión.')) }}
                                  @endif
                                @endif 
                            </td>
                            <td>
                                @if ($inscripcion->getEsAprobado())
                                   {{ link_to_route('ofertas.inscripciones.cambiarAprobado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Quitar la persona como Aprobado del curso.')) }}
                                @else
                                   {{ link_to_route('ofertas.inscripciones.cambiarAprobado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Aprobar al inscripto.')) }}
                                @endif
                            </td>
                            <!-- <td>
                                @if ($inscripcion->getEsInscripto())
                                    @if ($inscripcion->getCantNotificaciones() > 0)
                                       {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                    @endif
                                @else
                                    <button class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" style="width: 55px" title="No Corresponde"></button>
                                @endif
                            </td>-->
                        @endif                        
                        <!-- <td>
                            {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
                            <!-- <a href="{{route('ofertas.inscripciones.imprimir', [$oferta->id, $inscripcion->id])}}" class="btn btn-default" title="Imprimir formulario de inscripcion"><i class="fa fa-file-pdf-o"></i></a> -->
                            @if($perfil != "Colaborador")
                                <!-- {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar Inscripto')) }}
                                {{ Form::close() }} -->
                            @endif
                        <!-- </td> -->
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