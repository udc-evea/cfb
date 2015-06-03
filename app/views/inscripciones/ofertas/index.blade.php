@extends('layouts.scaffold')

@section('main')

<style type="text/css">
  #divIrAbajo{
      position: fixed;
      right: 5px;;
      width: 80px;
      bottom: 100px;
      text-align: center;      
  }
  #divIrAbajo a{
      text-decoration: none;
      color: white;
      background-color: black;
      padding: 7px;
      border: 1px solid graytext;
  }
  #divIrAbajo i{
      size: 20px;
  }
</style>

<div id="divIrAbajo">
    <a href="#fondo" title="Ir abajo"><i class="glyphicon glyphicon-chevron-down"></i></a>
    <a href="#arriba" title="Ir arriba"><i class="glyphicon glyphicon-chevron-up"></i></a>
</div>
<div id="arriba">
<h1>Oferta: <strong>"{{ $oferta->nombre }}"</strong></h1>
<h2>Usuario: {{ $nomyape }} - {{ $userName }} ({{ $perfil }})</h2>
<h2>
    <strong>Pre-Inscriptos</strong>
    <!-- <small class='text-muted'>|| <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a></small> -->
</h2>
    @if(count($inscripciones))
    <table class="tablaExportar">
        <tr>
            <td rowspan="2"><strong>Exportar listado</strong></td>
            <td colspan="2"><strong>Excel</strong></td>
            <td colspan="2"><strong>PDF</strong></td>
            @if($perfil == "Administrador")
                <td><strong>CSV</strong></td>
            @endif
        </tr>
        <tr>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsp')) }}" title="Exportar listado de todos los Pre-Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a></td>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'xlsi')) }}" title="Exportar listado solo de Inscriptos a Excel"><i class="fa fa-file-excel-o fa-3"></i></a></td>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfp')) }}" title="Exportar listado de todos los Pre-inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a></td>
            <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'pdfi')) }}" title="Exportar listado solo de Inscriptos a PDF"><i class="fa fa-file-pdf-o fa-3"></i></a></td>
            @if($perfil == "Administrador")
                <td><a href="{{ URL::Route('ofertas.inscripciones.index', array('oferta_id' => $oferta->id, 'exp' => 'csv')) }}" title="Exportar listado solo de Inscriptos a CSV"><i class="fa fa-file-text-o"></i></a></td>
            @endif
        </tr>
    </table>
    @endif
    <br><br>
    <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Vollver al listado de Ofertas" >Volver</a>
<h4>
    @if(count($inscripciones))
        Total: {{ count($inscripciones) }}
    @endif
</h4>

@if (count($inscripciones))
<fieldset>
    <div></div>
	<table class="table" style="border-top: 2px black solid; border-bottom: 2px black solid">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Apellidos y Nombres</th>                    
                    @if($perfil != "Colaborador")
                        <!-- <th>Documento</th> -->
                    @endif
                    <!-- <th>Localidad</th> -->
                    <th>Datos Personales</th>
                    @if($perfil != "Colaborador")
                        <th>Email UDC</th>
                        <th>Requisitos</th>
                        <th>Inscripto</th>
                        <th>Comision Nro.</th>
                        <th>Notificado/a</th>
                    @endif
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                   <?php $i = 1; ?>
                   @foreach ($inscripciones as $inscripcion)                   
                   <?php
                        $arreglo = $inscripcion->getColoresSegunEstados();
                        $color=$arreglo[0];
                        $bkgcolor=$arreglo[1];
                   ?>                   
                    <tr style="background-color: <?php echo $bkgcolor ?> !important; color: <?php echo $color ?> !important">
                        <td>{{ $i }}</td>
                        <td><p>{{ $inscripcion->apellido }},</p><p>{{ $inscripcion->nombre }}</p>
                        </td>
                        @if($perfil != "Colaborador")
                            <!-- <td>{{ $inscripcion->tipoydoc }}</td> -->
                        @endif
                        <!-- <td>{{ $inscripcion->localidad->la_localidad }}</td> -->
                        <td>
                            <p><strong>D.N.I.:</strong> {{ $inscripcion->tipoydoc }}</p>
                            <p><strong>e-mail:</strong> {{ $inscripcion->email }}</p>
                            <p><strong>Loc.:</strong> {{ $inscripcion->localidad->la_localidad }}</p>
                        </td>
                        @if($perfil != "Colaborador")
                            <td>{{{ $inscripcion->email_institucional }}}</td>
                            <td>
                                @if ($inscripcion->getRequisitosCompletos())
                                   {{ link_to_route('ofertas.inscripciones.cambiarEstadoDeRequisitos', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Borrar que la persona presentó todos los requisitos.')) }}
                                @else
                                   {{ link_to_route('ofertas.inscripciones.cambiarEstadoDeRequisitos', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Anotar que la persona presentó todos los requisitos.')) }}
                                @endif
                            </td>
                            <td>
                                @if ($inscripcion->getEsInscripto())
                                   {{ link_to_route('ofertas.inscripciones.cambiarEstado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-ok-sign','title'=>'Quitar la persona como Inscripto en el curso.')) }}
                                @else
                                   {{ link_to_route('ofertas.inscripciones.cambiarEstado', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove-sign','title'=>'Inscribir a la persona.')) }}
                                @endif
                            </td>
                            <td>@if ($inscripcion->getEsInscripto())
                                  @if($inscripcion->getComisionNro() < 10)
                                    {{ link_to_route('ofertas.inscripciones.sumarComision', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-plus','title'=>'Sumar el nro. de la comisión.')) }}
                                  @endif
                                @endif
                                @if($inscripcion->getComisionNro() != 0)
                                    <strong>Com. {{ $inscripcion->getComisionNro() }}</strong>
                                @else
                                    <strong>Sin Com.</strong>
                                @endif
                                @if ($inscripcion->getEsInscripto())
                                  @if($inscripcion->getComisionNro() > 0)
                                    {{ link_to_route('ofertas.inscripciones.restarComision', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success glyphicon glyphicon-minus','title'=>'Bajar el nro. de la comisión.')) }}
                                  @endif
                                @endif
                            </td>
                            <td>
                                @if ($inscripcion->getEsInscripto())
                                    @if ($inscripcion->getCantNotificaciones() > 0)
                                       {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-success','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                    @else
                                       {{ link_to_route('ofertas.inscripciones.enviarMailInstitucional', $inscripcion->getCantNotificaciones().' veces', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-danger','title'=>'Enviar mail con instrucciones de ingreso a cuenta institucional.')) }}
                                    @endif
                                @else
                                    <button class="btn btn-xs btn-block glyphicon glyphicon-remove-sign disable" style="width: 55px" title="No Corresponde"></button>
                                @endif
                            </td>
                        @endif                        
                        <td>
                            {{ link_to_route('ofertas.inscripciones.edit', '', array($oferta->id, $inscripcion->id), array('class' => 'btn btn-xs btn-info glyphicon glyphicon-edit', 'title'=>'Editar datos del inscripto')) }}
                            <!-- <a href="{{route('ofertas.inscripciones.imprimir', [$oferta->id, $inscripcion->id])}}" class="btn btn-default" title="Imprimir formulario de inscripcion"><i class="fa fa-file-pdf-o"></i></a> -->
                            @if($perfil != "Colaborador")
                                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.destroy', $oferta->id, $inscripcion->id))) }}
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-xs btn-danger','title'=>'Eliminar Inscripto')) }}
                                {{ Form::close() }}
                            @endif
                        </td>
                    </tr>
                    <?php $i++;?>
		@endforeach
		</tbody>
	</table>
    {{ Form::close() }}
</fieldset>
</div>

<!-- <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a> -->
<div id="fondo">
<a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Vollver al listado de Ofertas" >Volver</a>
</div>
@else
<br>
<h2>Aún no hay inscriptos en esta oferta.</h2>
<p><a href="{{ URL::action('ofertas.inscripciones.create', $oferta->id) }}" class="btn-btn-link">Formulario de inscripción</a> | <a href="{{ URL::route('ofertas.index') }}">Lista de ofertas</a></p>
@endif

@stop