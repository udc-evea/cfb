<div class="container"> 
    @if(count($inscripciones))
        <div class="divTotales">
            <div><h4>Total: {{ count($inscripciones) }}</h4></div>
            <div> (
                <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsi')) }}" target="_blank" title="Exportar listado solo de Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a>
                <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfi')) }}" target="_blank" title="Exportar listado solo de Inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a>
                @if($perfil == "Administrador")
                    <a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'csv')) }}" title="Exportar listado solo de Inscriptos a CSV"><i class="fa fa-file-text-o"></i></a>
                @endif
             )</div>
        </div>
    @endif
    @if (count($inscripciones))
    <fieldset>
        <div id="inscriptos">
            <input class="search" placeholder="Buscar por Nro. o Apellido" id="inputBuscarOfInscrIndex" onchange="verificarListaCompleta('inputBuscarOfInscrIndex','btnSubmitFormOfInscrIndex')"/>
            <button class="sort" data-sort="nroinsc" >Por Nro.</button>
            <button class="sort" data-sort="apellidoinsc" >Por Apellido</button>
            <?php $listaIdInscriptos = array(); ?>
            {{ Form::open(array(
                    'method' => 'POST',
                    'action' => array('OfertasInscripcionesController@cambiarEstadoDeRequisitos', $oferta->id))) }}
            <table class="table" style="border-top: 2px black solid; border-bottom: 2px black solid">
                <thead>
                    <tr>
                        <th>Nro.</th>
                        <th>Apellidos y Nombres</th>
                        <!--<th>Nombres</th>-->
                        <th>Documento</th>
                        <th>Email</th>                    
                        <!-- <th>Email UDC</th> -->
                        <th>Requisitos</th>
                        <th>Comision Nro.</th>
                        @if($perfil != "Colaborador")
                            <th>Not. como Inscripto</th>
                        @endif
                        @if($perfil == "Administrador")
                            <th>Not. mail Institucional</th>
                        @endif
                        <!--<th>Acciones</th>-->
                    </tr>
                </thead>
                <tbody class="list">
                    <?php $i = 1; ?>
                    @foreach ($inscripciones as $inscripcion)
                       <?php
                            $arreglo = $inscripcion->getColoresSegunEstados();
                            $color=$arreglo[0];
                            $bkgcolor=$arreglo[1];
                            $listaIdInscriptos[] = $inscripcion->id;
                       ?>                   
                        <tr style="background-color: <?php echo $bkgcolor ?> !important; color: <?php echo $color ?> !important">
                            <td class="nroinsc">{{ $i }}</td>
                            <td class="apellidoinsc">{{ $inscripcion->apellido }}, {{ $inscripcion->nombre }}</td>
                            <!--<td>{{ $inscripcion->nombre }}</td> -->
                            @if($perfil != "Colaborador")
                                <!-- <td>{{ $inscripcion->tipoydoc }}</td> -->
                            @endif
                            <!-- <td>{{ $inscripcion->localidad->la_localidad }}</td> -->
                            <td>{{ $inscripcion->tipoydoc }}</td>
                            <td>{{ $inscripcion->email }}<p style="color: blue">{{ $inscripcion->email_institucional }}</p></td>
                            <!-- <td>{{ $inscripcion->email_institucional }}</td> -->
                            <td>
                                @if(!$oferta->estaFinalizada())
                                <div class="slideTwo">
                                    @if ($inscripcion->getRequisitosCompletos())
                                        <input type="checkbox" name="requisitos[<?php echo $inscripcion->id ?>]" id="slideTwoReq<?php echo $inscripcion->id ?>" value='1' checked='checked'><label for="slideTwoReq<?php echo $inscripcion->id ?>"></label>
                                    @else
                                        <input type="checkbox" name="requisitos[<?php echo $inscripcion->id ?>]" id="slideTwoReq<?php echo $inscripcion->id ?>" value='1'><label for="slideTwoReq<?php echo $inscripcion->id ?>"></label>
                                    @endif
                                </div>
                                @else
                                    @if ($inscripcion->getRequisitosCompletos())
                                        Si
                                    @else
                                        No
                                    @endif
                                @endif
                                    <!-- @if ($inscripcion->getRequisitosCompletos())
                                       {{ link_to_route('ofertas.inscripciones.cambiarEstadoDeRequisitos', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Borrar que la persona presentó todos los requisitos.')) }}
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.cambiarEstadoDeRequisitos', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Anotar que la persona presentó todos los requisitos.')) }}
                                    @endif -->
                            </td>                            
                            <td>
                                @if (($inscripcion->getEsInscripto())&&(!$oferta->estaFinalizada()))
                                  @if($inscripcion->getComisionNro() > 0)
                                    {{ link_to_route('ofertas.inscripciones.restarComision', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-minus','title'=>'Bajar el nro. de la comisión.')) }}
                                  @endif
                                @endif
                                @if($inscripcion->getComisionNro() != 0)
                                    <strong>Com. {{ $inscripcion->getComisionNro() }}</strong>
                                @else
                                    <strong>Sin Com.</strong>
                                @endif
                                @if (($inscripcion->getEsInscripto())&&(!$oferta->estaFinalizada()))
                                  @if($inscripcion->getComisionNro() < 10)
                                    {{ link_to_route('ofertas.inscripciones.sumarComision', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-plus','title'=>'Sumar el nro. de la comisión.')) }}
                                  @endif
                                @endif                                
                            </td>
                            @if($perfil != "Colaborador")
                            <td>
                                @if ($inscripcion->getEsInscripto())
                                  @if(!$oferta->estaFinalizada())
                                    @if ($inscripcion->getCantNotificacionesInscripto() > 0)
                                       {{ link_to_route('ofertas.inscripciones.enviarMailNuevoInscripto', $inscripcion->getCantNotificacionesInscripto().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail notificando que ya es Inscripto.')) }}
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.enviarMailNuevoInscripto', $inscripcion->getCantNotificacionesInscripto().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger','title'=>'Enviar mail notificando que ya es Inscripto.')) }}
                                    @endif
                                  @else
                                    {{ $inscripcion->getCantNotificacionesInscripto() }} veces
                                  @endif
                                @else
                                    <button class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" style="width: 55px" title="No Corresponde"></button>
                                @endif
                            </td>
                            @endif
                            @if($perfil == "Administrador")
                            <td>
                                @if ($inscripcion->getEsInscripto())
                                  @if(!$oferta->estaFinalizada())
                                    @if ($inscripcion->getCantNotificaciones() > 0)
                                       {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                    @endif
                                  @else
                                    {{ $inscripcion->getCantNotificaciones() }} veces
                                  @endif
                                @else
                                    <button class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" style="width: 55px" title="No Corresponde"></button>
                                @endif
                            </td>
                            @endif
                            <!--<td>
                                {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
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
            <?php $listaEnString = implode('-',$listaIdInscriptos); ?>
            <input type="hidden" id="listaIdInscriptos" name="listaIdInscriptos" value="<?php echo $listaEnString; ?>"/>
            @if(!$oferta->estaFinalizada())
            <div class="btn-group" role="group" style="float: right">
                {{ Form::submit('Guardar cambios', array('class' => 'btn btn-success  btn-secondary', 'title'=>'Actualizar los datos de los requisitos presentados.', 'id'=>'btnSubmitFormOfInscrIndex')) }}
                {{ Form::reset('Descartar cambios', ['class' => 'form-button btn btn-warning btn-secondary'])}}
                {{ Form::close() }}
            </div>
            @endif
    </fieldset>
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