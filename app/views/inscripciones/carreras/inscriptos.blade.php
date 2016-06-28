@if(count($inscriptos))
    <div class="divTotales">
        <div><h4>Total: {{ count($inscriptos) }}</h4></div>
        <div> (
            <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsi')) }}" target="_blank" title="Exportar listado solo de Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
            <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfi')) }}" target="_blank" title="Exportar listado solo de Inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
            <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'csv')) }}" target="_blank" title="Exportar listado solo de Inscriptos a CSV"><i class="fa fa-file-text-o"></i></a>
         )</div>
    </div>
@endif
    @if (count($inscriptos))
    <div id="inscriptos">
        <input class="search" placeholder="Buscar por Nro. o Apellido" id="inputBuscar" onchange="verificarListaCompleta()"/>
        <button class="sort" data-sort="nroinsc" >Por Nro.</button>
        <button class="sort" data-sort="apellidoinsc" >Por Apellido</button>
        <?php $listaIdPreinscriptos = array();?>
        {{ Form::open(array(
                    'method' => 'POST',
                    'action' => array('OfertasInscripcionesController@cambiarInscripciones', $oferta->id))) }}    
	<table class="table table-striped" style="border-top: 2px black solid; border-bottom: 2px black solid">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Apellidos y Nombres</th>
                    <!-- <th>Nombre</th> -->
                    @if($perfil != "Colaborador")
                        <th>Documento</th>
                    @endif
                    <th>Localidad</th>
                    <th>Correos</th>
                    @if($perfil != "Colaborador")
                        <!--<th>Email UDC</th>-->
                        <th>Inscripto ({{ count($inscriptos) }})</th>
                        <th>Notificado/a</th>
                    @endif
                    <!--<th>Acciones</th>-->
                </tr>
            </thead>
            <tbody class="list">
               <?php $i = 1; ?>
               @foreach ($inscriptos as $inscripcion)
                    <?php $listaIdPreinscriptos[] = $inscripcion->id; ?>
                    <tr>
                        <td class="nroinsc">{{ $inscripcion->id }}</td>
                        <td class="apellidoinsc">{{ $inscripcion->apellido }}, {{ $inscripcion->nombre }}</td>
                        <!-- <td>{{ $inscripcion->nombre }}</td> -->
                        @if($perfil != "Colaborador")
                            <td>{{{ $inscripcion->tipoydoc }}}</td>
                        @endif
                        <td>{{{ $inscripcion->localidad->la_localidad }}}</td>
                        <td>
                            <p>{{ $inscripcion->email }}</p>
                            <p style="color: blue">{{ $inscripcion->email_institucional }}</p>
                        </td>
                        @if($perfil != "Colaborador")
                            <!--<td>{{{ $inscripcion->email_institucional }}}</td>-->
                            <td>@if(!$oferta->estaFinalizada())
                                <div class="slideTwo"><div class="slideTwo">
                                    @if ($inscripcion->getEsInscripto())
                                        <input type="checkbox" name="inscripto[<?php echo $inscripcion->id ?>]" id="slideTwoinsc<?php echo $inscripcion->id ?>" value='1' checked='checked'><label for="slideTwoinsc<?php echo $inscripcion->id ?>"></label>
                                    @else
                                        <input type="checkbox" name="inscripto[<?php echo $inscripcion->id ?>]" id="slideTwoinsc<?php echo $inscripcion->id ?>" value='1'><label for="slideTwoinsc<?php echo $inscripcion->id ?>"></label>
                                    @endif
                                </div>
                                @else
                                    @if ($inscripcion->getEsInscripto())
                                        Si
                                    @else
                                        No
                                    @endif
                                @endif
                            </td>                        
                            <td>
                              @if(!$oferta->estaFinalizada())
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
                              @else
                                @if ($inscripcion->getEsInscripto())
                                    @if ($inscripcion->getCantNotificaciones() > 0)
                                       @if ($inscripcion->getCantNotificaciones() == 1)
                                            {{ $inscripcion->getCantNotificaciones() }} vez
                                       @else
                                            {{ $inscripcion->getCantNotificaciones() }} veces
                                       @endif
                                    @else
                                       nunca
                                    @endif
                                @else
                                    <button style="width: 50px" class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" title="No Corresponde"></button>
                                @endif
                              @endif
                            </td>
                        @endif  
                        <!--<td>
                            {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
                            <a href="{{route('ofertas.inscripciones.imprimir', [$oferta->id, $inscripcion->id])}}" class="btn btn-xs btn-default" title="Imprimir formulario de inscripcion"><i class="fa fa-file-pdf-o"></i></a>
                            @if($perfil != "Colaborador")
                                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar Inscripto')) }}
                                {{ Form::close() }}
                            @endif
                        </td>-->
                    </tr>
                    <?php $i++;?>
                @endforeach
		</tbody>
	</table>
        <?php $listaEnString = implode('-',$listaIdPreinscriptos); ?>
        <input type="hidden" id="listaIdPreinscriptos" name="listaIdPreinscriptos" value="<?php echo $listaEnString ?>">
        @if(($perfil != "Colaborador")&&(!$oferta->estaFinalizada()))
            {{ Form::submit('Guardar cambios', array('class' => 'btn btn-success', 'style'=>'float: right', 'title'=>'Guardar cambios.', 'id'=>'btnSubmitForm')) }}
            {{ Form::reset('Descartar cambios', ['class' => 'form-button btn btn-warning', 'style'=>'float: right' ])}}
            {{ Form::close() }}
        @endif
    </div>
    @else
        <br>
        <h2>Aún no hay inscriptos en esta oferta.</h2>
        <p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
    @endif
    
<script>
    var options = {
      valueNames: [ 'apellidoinsc', 'nroinsc' ]
    };

    var inscriptosList = new List('inscriptos', options);
</script>

