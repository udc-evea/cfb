<?php
    $TIPO_CARRERA = 1;
    $TIPO_CURSO = 2;
    $TIPO_EVENTO = 3;
    $liClassOferta = '';
    $liClassCarrera = '';
    $liClassEvento = '';
    $classOf = 'class="tab-pane"';
    $classCa = 'class="tab-pane"';
    $classEv = 'class="tab-pane"';
    $tipoOfertaCadena = 'Evento';
    if(Session::has('tab_activa')){
        $tab_activa = Session::get('tab_activa'); 
        if($tab_activa == $TIPO_CURSO){
            $classOf = 'class="tab-pane active"';
            $liClassOferta = 'class="active"';
            $tipoOfertaCadena = 'Oferta';
        }elseif($tab_activa == $TIPO_CARRERA){
            $classCa = 'class="tab-pane active"';
            $liClassCarrera = 'class="active"';
            $tipoOfertaCadena = 'Carrera';
        }else{
            $classEv = 'class="tab-pane active"';
            $liClassEvento = 'class="active"';
        }
    }
?>
<?php 
    function obtenerLinkPublico($linkPublico){
        $linkCompleto = explode('-',$linkPublico);
        $primeraParte = $linkCompleto[0];
        $segundaParte = $linkCompleto[1];
        $aux = explode('/',$segundaParte);
        return $newSegundaParte = $primeraParte.'-'.$aux[0]."/inscripcion";
    }
?>
@extends('layouts.scaffold')
@section('title', 'Inscripciones On Line - Universidad del Chubut')
@section('main')
<div class="container">
    <!-- Header -->
    <div class="row block">
        <div style="text-align: center;">
            <div style="float: left">
                <img  src="{{asset('img/LOGO-200x60px.png')}}" width="150"/>
            </div>
            <div style="margin: 0% 32% 0% 33%">
                    <h1 style="width: 400px; border: solid white 4px; background-color: black; color: white; border-radius: 15px; padding: 10px">
                        <span class="titulo1">Inscripciones On Line</span>
                    </h1>
            </div>
            <div>
                <h3>Usuario: {{ $userName }}</h3>
            </div>
            <div align="left">
                <p><a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a></p>
            </div>
        </div>
    </div>
    
    <!-- Nav tabs -->
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <ul class="nav nav-tabs" id="tabs_ofertas" role="tablist">
                <li <?php echo $liClassOferta ?>><a href="#tab_ofertas" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Ofertas ({{$ofertas->count()}})</a></li>
                <li <?php echo $liClassCarrera ?>><a href="#tab_carreras" role="tab" data-toggle="tab"><i class="fa fa-university"></i> Carreras ({{$carreras->count()}})</a></li>
                <li <?php echo $liClassEvento ?>><a href="#tab_eventos" role="tab" data-toggle="tab"><i class="fa fa-calendar"></i> Eventos ({{$eventos->count()}})</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div <?php echo $classOf ?> id="tab_ofertas">
            @include('ofertas.listado', compact('ofertas'))
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nueva Oferta', ['tab_activa' => 'ofertas'], array('class' => 'btn btn-primary')) }}
            @endif
        </div>
        <div <?php echo $classCa ?> id="tab_carreras">
            @include('ofertas.listado_carreras', compact('carreras'))
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nueva Carrera', ['tab_activa' => 'carreras'], array('class' => 'btn btn-primary')) }}
                @endif
        </div>
        <div <?php echo $classEv ?> id="tab_eventos">
            @include('ofertas.listado_eventos', compact('eventos'))
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nuevo Evento', ['tab_activa' => 'eventos'], array('class' => 'btn btn-primary')) }}
            @endif
        </div>
    </div>
    <br><br>
       
    <!-- Modal de las Estadisticas 
    <div class="row-fluid">
        <!-- Muestro el modal con un button 
        <button type="button" class="btn btn-toolbar" data-toggle="modal" data-target="#modalEstadisticasTotales">Estadísticas</button>
        <!-- Estadistica de Todas las ofertas:        
        <!-- Modal 
        <div id="modalEstadisticasTotales" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content 
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Estadísticas de todas las ofertas</h4>
              </div>
              <div class="modal-body">
                <p style="color: red"><b>Ofertas/Carreras/Eventos del 2015</b></p>
                <div class="row">
                    <div id="EstTot2015" style="width: 500px; height: 200px;alignment-adjust: central;"></div>
                </div>
                <p style="color: red"><b>Otro cuadro</b></p>
                <div class="row">
                    <div id="EstTot2016" style="width: 600px; height: 500px"></div>
                    Total Carreras: <?php //echo $TotalPreinscriptos['carreras'] ?><br>
                    Total Eventos: <?php //echo $TotalPreinscriptos['eventos'] ?><br>
                    Total Ofertas: <?php //echo $TotalPreinscriptos['ofertas'] ?><br>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
    </div> -->
    <!-- <div style="background-color: blue">
        <?php //foreach($pruebaCarreras as $c):?>
            <?php //echo "-> ".$c->nombre." - ".$c->total."<br>"?>
        <?php //endforeach?>
        <?php //echo var_dump($pruebaCarreras)?>
    </div> -->
</div>

<!-- #################################################################### -->
<!--                     Scripts para los gráficos                        -->
<!-- <script>
    $(function () {
    $('#EstTot2015').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Estadisticas totales'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [{
                name: 'Preinscriptos',
                y: <?php //echo $preUDC?>,
                sliced: true,
                selected: true
            }, {
                name: 'Inscriptos',
                y: <?php //echo $insUDC?>
            }]
        }]
    });
});      

$(function () {
    // Create the chart
    $('#EstTot2016').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Preinscriptos/Inscriptos por Oferta/Carrera/Evento'
        },
        subtitle: {
            text: '(clic en cada barra para mas detalles)'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Interesados'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: total <b>{point.y}</b><br/>'
        },

        series: [{
            name: 'Total',
            colorByPoint: true,
            data: [{
                name: 'Carreras',
                y: <?php //echo $TotalPreinscriptos['carreras'] ?>,
                drilldown: 'Carreras'
            }, {
                name: 'Ofertas',
                y: <?php //echo $TotalPreinscriptos['ofertas'] ?>,
                drilldown: 'Ofertas'
            }, {
                name: 'Eventos',
                y: <?php //echo $TotalPreinscriptos['eventos'] ?>,
                drilldown: 'Eventos'
            }]
        }],
        drilldown: {
            series: [{
                name: 'Carreras',
                id: 'Carreras',                
                data: [
                    <?php //foreach($Carreras as $c):?>
                    [
                           '<?php //echo $c->nombre . "(". $c->anio . ")" ?>',
                           <?php //echo $c->total ?>
                    ],
                    <?php //endforeach?>
                    /*[
                        'Preinscriptos',
                        <?php //echo $TotalPreinscriptos['carreras'] - $TotalInscriptos['carreras'] ?>
                    ],
                    [
                        'Inscriptos',
                        <?php //echo $TotalInscriptos['carreras'] ?>
                    ],*/
                ]
            }, {
                name: 'Ofertas',
                id: 'Ofertas',
                data: [
                    [
                        'Total',
                        <?php //echo $TotalPreinscriptos['ofertas'] ?>
                    ],
                    [
                        'Preinscriptos',
                        <?php //echo $TotalPreinscriptos['ofertas'] - $TotalInscriptos['ofertas'] ?>
                    ],
                    [
                        'Inscriptos',
                        <?php //echo $TotalInscriptos['ofertas'] ?>
                    ]
                ]
            }, {
                name: 'Eventos',
                id: 'Eventos',
                data: [
                    [
                        'Total',
                        <?php //echo $TotalPreinscriptos['eventos'] ?>
                    ],
                    [
                        'Preinscriptos',
                        <?php //echo $TotalPreinscriptos['eventos'] - $TotalInscriptos['eventos'] ?>
                    ],
                    [
                        'Inscriptos',
                        <?php //echo $TotalInscriptos['eventos'] ?>
                    ]
                ]
            }]
        }
    });
}); 
</script> -->
<!-- #################################################################### -->
<!--                  FIN Scripts para los gráficos                       -->
@stop