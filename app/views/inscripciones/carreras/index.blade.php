<?php
    $liInscCaDatos = '';
    $liInscCaPreinsc = '';
    $liInscCaInscr = '';
    $classDatos = 'class="tab-pane"';
    $classPreinscr = 'class="tab-pane"';
    $classInscr = 'class="tab-pane"';
    if(Session::has('tab_activa_inscripciones')){
        $tab_activa = Session::get('tab_activa_inscripciones');
        switch ($tab_activa) {
            case 1:
                $classDatos = 'class="tab-pane active"';
                $liInscCaDatos = 'class="active"';
                break;
            case 2:
                $classPreinscr = 'class="tab-pane active"';
                $liInscCaPreinsc = 'class="active"';
                break;
            case 3:
                $classInscr = 'class="tab-pane active"';
                $liInscCaInscr = 'class="active"';
                break;
            default:
                $classDatos = 'class="tab-pane active"';
                $liInscCaDatos = 'class="active"';
                break;
        }
    }
    Session::set('tab_activa',1);
?>
@extends('layouts.scaffold')
@section('main')

<div id="divIrAbajo">
    <a href="#fondo" title="Ir abajo"><i class="glyphicon glyphicon-chevron-down"></i></a>
    <a href="#arriba" title="Ir arriba"><i class="glyphicon glyphicon-chevron-up"></i></a>
</div>
<div id="arriba" class="container">
    <div class="alert alert-info" align="center">
        <h1>{{ $tipoOferta }}: <strong>"{{ $oferta->nombre }}"</strong></h1>
        @if($oferta->estaFinalizada())
            <div class='alert alert-danger'>
                <h2>Esta {{ $tipoOferta }} se encuentra <strong>Finalizada</strong></h2>
            </div>
        @endif
    </div>
    <!--@if(count($inscripciones))
    <div class="alert alert-warning" style="width: 30%;margin-left: 33%;">
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
     </div>
    @endif -->
    <div>
        <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Volver al listado de Ofertas" >Volver</a>
        @if((!$oferta->estaFinalizada()) && (sizeof($preinscripciones)) && ($perfil == "Administrador"))
            {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.limpiar', $oferta->id))) }}
                <input id='mjeBorrar' value="¿Está seguro que desea borrar todos los preinscriptos a esta Oferta?" type="hidden" />
                {{ Form::submit('Borrar inscriptos de Carrera', array('class' => 'btn btn-danger','title'=>'Eliminar todos los preinscriptos de la Carrera')) }}
            {{ Form::close() }}
        @endif
    </div>
    <hr>
        <!-- Nav tabs -->
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <ul class="nav nav-tabs" id="tabs_opciones" role="tablist">
                    <li <?php echo $liInscCaDatos?>>
                        <a title="Todos los datos de los Preinscriptos a la Carrera" href="#tab_datos" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-align-justify"></i> 
                            Editar Datos
                            <span class="badge"><?php echo sizeof($preinscripciones); ?></span>
                        </a>
                    </li>
                    <li <?php echo $liInscCaPreinsc?>>
                        <a title="Todos los Preinscriptos a la Carrera" href="#tab_preinscriptos" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-align-justify"></i> 
                            Presinscriptos 
                            <span class="badge"><?php echo sizeof($preinscripciones); ?></span>
                        </a>
                    </li>
                    <?php if(!(empty($inscriptos))):?>
                        <li <?php echo $liInscCaInscr?>><a title="Solo los Inscriptos a la Carrera" href="#tab_inscriptos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tag"></i> Inscriptos <span class="badge"><?php echo sizeof($inscripciones); ?></span></a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div <?php echo $classDatos ?> id="tab_datos">
                @include('inscripciones.carreras.datos', compact('inscripciones'))
            </div>
            <div <?php echo $classPreinscr ?> id="tab_preinscriptos">
                @include('inscripciones.carreras.preinscriptos', compact('inscripciones'))
            </div>
            <div <?php echo $classInscr ?> id="tab_inscriptos">
                @include('inscripciones.carreras.inscriptos', compact('inscripciones'))
            </div>
        </div>
    <div id="fondo">
        <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Volver al listado de Ofertas" >Volver</a>
    </div>
</div>

@stop