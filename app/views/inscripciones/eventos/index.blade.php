<?php
    $liInscEvDatos = '';
    $liInscEvPreinsc = '';
    $liInscEvInscr = '';
    $classDatos = 'class="tab-pane"';
    $classPreinscr = 'class="tab-pane"';
    $classInscr = 'class="tab-pane"';
    $classAsist = 'class="tab-pane"';
    if(Session::has('tab_activa_inscripciones')){
        $tab_activa = Session::get('tab_activa_inscripciones');
        switch ($tab_activa) {
            case 1:
                $classDatos = 'class="tab-pane active"';
                $liInscEvDatos = 'class="active"';
                break;
            case 2:
                $classPreinscr = 'class="tab-pane active"';
                $liInscEvPreinsc = 'class="active"';
                break;
            case 3:
                $classInscr = 'class="tab-pane active"';
                $liInscEvInscr = 'class="active"';
                break;
            case 3:
                $classAsist = 'class="tab-pane active"';
                break;
            default:
                $classDatos = 'class="tab-pane active"';
                $liInscEvDatos = 'class="active"';
                break;
        }
    }
    Session::set('tab_activa',3);
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

    <!--@if(count($preinscripciones))        
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
    @endif-->
    <div>
        <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Volver al listado de Ofertas" >Volver</a>
        @if((!$oferta->estaFinalizada()) && (sizeof($preinscripciones)) && ($perfil == "Administrador"))
                {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.limpiar', $oferta->id))) }}
                    <input id='mjeBorrar' value="¿Está seguro que desea borrar todos los preinscriptos a esta Oferta?" type="hidden" />
                    {{ Form::submit('Borrar inscriptos de Evento', array('class' => 'btn btn-danger','title'=>'Eliminar todos los preinscriptos del Evento')) }}
                {{ Form::close() }}
        @endif
    </div>
    <hr>
        <!-- Nav tabs -->
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <ul class="nav nav-tabs" id="tabs_opciones_ev" role="tablist">
                    <li <?php echo $liInscEvDatos ?>><a title="Editar los datos de todos los Preinscriptos al evento." href="#tab_datos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-align-justify"></i> Editar Datos <span class="badge"><?php echo sizeof($preinscripciones); ?></span></a></li>
                    <li <?php echo $liInscEvPreinsc ?>><a title="Todos los Preinscriptos al evento." href="#tab_preinscriptos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-align-justify"></i> Presinscriptos <span class="badge"><?php echo sizeof($preinscripciones); ?></span></a></li>
                    <?php if(!(empty($inscripciones))):?>
                        <li <?php echo $liInscEvInscr ?>><a title="Solo los Inscriptos al evento." href="#tab_inscriptos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tag"></i> Inscriptos <span class="badge"><?php echo sizeof($inscripciones); ?></span></a></li>
                    <?php endif;?>
                    <?php if(!(empty($asistentes))):?>
                        <li><a title="Solo los Asistentes al Evento." href="#tab_asistentes" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-thumbs-up"></i> Asistentes <span class="badge"><?php echo sizeof($asistentes); ?></span></a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div <?php echo $classDatos ?> id="tab_datos">
                @include('inscripciones.eventos.datos', compact('preinscripciones'))
            </div>
            <div <?php echo $classPreinscr ?> id="tab_preinscriptos">
                @include('inscripciones.eventos.preinscriptos', compact('preinscripciones'))
            </div>
            <div <?php echo $classInscr ?> id="tab_inscriptos">
                @include('inscripciones.eventos.inscriptos', compact('inscripciones'))
            </div>            
            <div <?php echo $classAsist ?> id="tab_asistentes">
                @include('inscripciones.eventos.asistentes', compact('asistentes'))
            </div>
        </div>
</div>
<script>
    (function () {
        $('#tabs_opciones_ev a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $("#tabs_opciones_ev a[href=#tab_{{$tab_activa}}]").tab('show');
    });
</script>
@stop