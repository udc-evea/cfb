<?php $tab_activa = Session::get('tab_activa', 'preinscriptos'); ?>
@extends('layouts.scaffold')
@section('main')

<div id="divIrAbajo">
    <a href="#fondo" title="Ir abajo"><i class="glyphicon glyphicon-chevron-down"></i></a>
    <a href="#arriba" title="Ir arriba"><i class="glyphicon glyphicon-chevron-up"></i></a>
</div>
<div id="arriba" class="container">
    <div class="alert alert-info" align="center">
        <h1>{{ $tipoOferta }}: <strong>"{{ $oferta->nombre }}"</strong></h1>
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
        @if(sizeof($preinscripciones))
            {{ Form::open(array('class' => 'confirm-delete', 'style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ofertas.inscripciones.limpiar', $oferta->id))) }}
                {{ Form::submit('Limpiar Carrera', array('class' => 'btn btn-danger','title'=>'Eliminar todos los preinscriptos de la Carrera')) }}
            {{ Form::close() }}
        @endif
    </div>
    <hr>
        <!-- Nav tabs -->
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <ul class="nav nav-tabs" id="tabs_opciones" role="tablist">
                    <li class='active'>
                        <a title="Todos los datos de los Preinscriptos a la Carrera" href="#tab_datos" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-align-justify"></i> 
                            Editar Datos
                            <span class="badge"><?php echo sizeof($preinscripciones); ?></span>
                        </a>
                    </li>
                    <li>
                        <a title="Todos los Preinscriptos a la Carrera" href="#tab_preinscriptos" role="tab" data-toggle="tab">
                            <i class="glyphicon glyphicon-align-justify"></i> 
                            Presinscriptos 
                            <span class="badge"><?php echo sizeof($preinscripciones); ?></span>
                        </a>
                    </li>
                    <?php if(!(empty($inscriptos))):?>
                        <li><a title="Solo los Inscriptos a la Carrera" href="#tab_inscriptos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tag"></i> Inscriptos <span class="badge"><?php echo sizeof($inscripciones); ?></span></a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tab_datos">
                @include('inscripciones.carreras.datos', compact('inscripciones'))
            </div>
            <div class="tab-pane" id="tab_preinscriptos">
                @include('inscripciones.carreras.preinscriptos', compact('inscripciones'))
            </div>
            <div class="tab-pane" id="tab_inscriptos">
                @include('inscripciones.carreras.inscriptos', compact('inscripciones'))
            </div>
        </div>
    <div id="fondo">
        <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Volver al listado de Ofertas" >Volver</a>
    </div>
</div>
<script>
    $(function () {
        $('#tabs_opciones a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $("#tabs_opciones a[href=#tab_{{$tab_activa}}]").tab('show');
    });
</script>    

@stop