<?php $tab_activa = Session::get('tab_activa', 'preinscriptos'); ?>
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
<div id="arriba" class="container">
    <div class="alert alert-info" align="center">
        <h1>{{ $tipoOferta }}: <strong>"{{ $oferta->nombre }}"</strong></h1>
    </div>
    <!-- <h2>Usuario: {{ $nomyape }} - {{ $userName }} ({{ $perfil }})</h2>
    <h2>
        <strong>Pre-Inscriptos</strong> -->
        <!-- <small class='text-muted'>|| <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a></small> -->
    <!-- </h2> -->
     @if(count($inscripciones))
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
     @endif        
        <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Volver al listado de Ofertas" >Volver</a>
    <hr>
    <?php //var_dump($comisiones); ?>
    <?php //echo "-->> CANT:".sizeof($comisiones)."<br>" ?>
        <!-- Nav tabs -->
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <ul class="nav nav-tabs" id="tabs_opciones" role="tablist">
                    <li class='active'><a title="Todos los Preinscriptos a la Oferta." href="#tab_preinscriptos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-align-justify"></i> Presinscriptos <span class="badge"><?php echo sizeof($preinscripciones); ?></span></a></li>
                    <?php if(!(empty($inscripciones))):?>
                        <li><a title="Solo los Inscriptos a la Oferta." href="#tab_inscriptos" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tag"></i> Inscriptos <span class="badge"><?php echo sizeof($inscripciones); ?></span></a></li>
                    <?php endif;?>
                    <?php if(!(empty($comisiones))):?>
                        <?php if(sizeof($comisiones)>1):?>
                            <?php foreach($comisiones as $com):?>
                                     <?php if($com[0]['comision_nro'] == 0):?>
                                        <li><a title="Inscriptos sin Comision asignada." href="#tab_sincomision" role="tab" data-toggle="tab">
                                        <?php echo "Sin Com.";?>
                                        <span class="badge"><?php echo sizeof($com); ?></span></a></li>
                                     <?php elseif($com[0]['comision_nro'] != 10):?>
                                        <li><a title="Inscriptos en la Comision 0<?php echo $com[0]['comision_nro'] ?> " href="#tab_comision0<?php echo $com[0]['comision_nro'] ?>" role="tab" data-toggle="tab">                                        
                                        <?php echo "C.".$com[0]['comision_nro'];?>
                                        <span class="badge"><?php echo sizeof($com); ?></span></a></li>
                                     <?php else:?>
                                        <li><a title="Inscriptos en la Comision 10." href="#tab_comision10" role="tab" data-toggle="tab">
                                        <?php echo "C.10";?><span class="badge"><?php echo sizeof($com); ?></span></a></li>
                                     <?php endif;?>
                            <?php endforeach;?>
                        <?php else:?>
                            <?php foreach($comisiones as $comis):?>
                                  <?php if($comis[0]['comision_nro'] == 0):?>
                                        <li><a title="Inscriptos sin Comision asignada." href="#tab_sincomision" role="tab" data-toggle="tab">
                                        <?php echo "Sin Com.";?>
                                        <span class="badge"><?php echo sizeof($comis); ?></span></a></li>
                                  <?php elseif($comis[0]['comision_nro'] != 10):?>
                                        <li><a title="Inscriptos en la Comision 0<?php echo $comis[0]['comision_nro'] ?> " href="#tab_comision0<?php echo $comis[0]['comision_nro'] ?>" role="tab" data-toggle="tab">
                                        <?php echo "C.".$comis[0]['comision_nro'];?>
                                            <span class="badge"><?php echo sizeof($comis); ?></span></a></li>
                                  <?php else:?>
                                        <li><a title="Inscriptos en la Comision 10." href="#tab_comision10" role="tab" data-toggle="tab">
                                        <?php echo "C.10";?>
                                            <span class="badge"><?php echo sizeof($comis); ?></span></a></li>
                                  <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tab_preinscriptos">
                @include('inscripciones.ofertas.preinscriptos', compact('preinscriptos'))
            </div>            
            <div class="tab-pane" id="tab_inscriptos">
                @include('inscripciones.ofertas.inscriptos', compact('inscriptos'))
            </div>
            <?php if(!(empty($comisiones))):?>
                <?php foreach($comisiones as $com):?>
                    <?php foreach($com as $c):?>
                       <?php if($c['comision_nro'] == 0):?>
                          <div class="tab-pane" id="tab_sincomision">
                       <?php elseif($c['comision_nro'] != 10):?>
                          <div class="tab-pane" id="tab_comision0<?php echo $c['comision_nro'] ?>">
                       <?php else:?>                              
                          <div class="tab-pane" id="tab_comision<?php echo $c['comision_nro'] ?>">
                       <?php endif;?>
                              <?php //throw new Exception;?>
                             @include('inscripciones.ofertas.comisiones', compact('com'))
                          </div>
                    <?php endforeach;?>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    <!-- <a class='text-muted' href="{{ URL::route('ofertas.index') }}">Volver</a> -->
    <div id="fondo">
        <a class='btn btn-primary' href="{{ URL::route('ofertas.index') }}" title="Vollver al listado de Ofertas" >Volver</a>
    </div>
</div>
@stop