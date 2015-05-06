<?php $tab_activa = Session::get('tab_activa', 'ofertas'); ?>
@extends('layouts.scaffold')
@section('title', 'Ofertas Formativas - Universidad del Chubut')
@section('main')
<div class="container">
    <!-- Header -->
    <div class="row block">
        <div class="col-xs-12 col-md-12">
            <div class="col-xs-6 col-md-4"><img  src="{{asset('img/LOGO-200x60px.png')}}" width="150"/></div>
            <div class="col-xs-12 col-md-8"><h1><span class="titulo1">Ofertas Formativas</span></h1></div>
            <h3>Usuario: {{ $userName }}  
                {{ link_to_action('HomeController@salir', ' Salir', null,array('class'=>'btn btn-sm btn-success glyphicon glyphicon-chevron-left', 'title'=>'Salir del sistema')); }}
                <!-- <a href="#" title="Salir"><i class="glyphicon glyphicon-open"></i></a> -->
            </h3>
            <p>{{ link_to_action('HomeController@bienvenido', ' Inicio', null,array('class'=>'btn btn-sm btn-primary glyphicon glyphicon-chevron-left', 'title'=>'Volver al Inicio')) }}</p>
        </div>
    </div>
    
    <!-- Nav tabs -->
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <ul class="nav nav-tabs" id="tabs_ofertas" role="tablist">
                <li><a href="#tab_ofertas" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Ofertas</a></li>
                <li><a href="#tab_carreras" role="tab" data-toggle="tab"><i class="fa fa-university"></i> Carreras</a></li>
                <li><a href="#tab_eventos" role="tab" data-toggle="tab"><i class="fa fa-calendar"></i> Eventos</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="tab_ofertas">
            @include('ofertas.listado', compact('ofertas'))
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nueva Oferta', ['tab_activa' => 'ofertas'], array('class' => 'btn btn-primary')) }}
            @endif
        </div>
        <div class="tab-pane" id="tab_carreras">
            @include('ofertas.listado_carreras', compact('carreras'))
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nueva Carrera', ['tab_activa' => 'carreras'], array('class' => 'btn btn-primary')) }}
                @endif
        </div>
        <div class="tab-pane" id="tab_eventos">
            @include('ofertas.listado_eventos', compact('eventos'))
            @if(($userPerfil == "Administrador")||($userPerfil == "Creador"))
                {{ link_to_route('ofertas.create', 'Crear nuevo Evento', ['tab_activa' => 'eventos'], array('class' => 'btn btn-primary')) }}
            @endif
        </div>
    </div>    
</div>

<script>
    $(function () {
        $('#tabs_ofertas a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $("#tabs_ofertas a[href=#tab_{{$tab_activa}}]").tab('show');
    });
</script>
@stop