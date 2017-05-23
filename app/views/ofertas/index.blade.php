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
@section('title', 'Inscripciones On Line - Universidad del Chubut')
@extends('layouts.scaffold')
@section('main')
    <!-- Header -->
    <div class="row">
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
        </div>
        <div class="btn-group" style="float: left">
            <a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                <a href="{{action('OfertasController@importarOfertaDeArchivo')}}" class="btn btn-primary" title="Importar Nueva Oferta desde Archivo CSV"><i class="glyphicon glyphicon-plus-sign"></i> Importar Oferta de Archivo</a>
            @endif
        </div>
    </div><br>
    
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
@stop