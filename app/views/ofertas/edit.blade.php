@extends('layouts.scaffold')
@section('title', 'Oferta: '.$oferta->nombre.' - Universidad del Chubut')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ $oferta->nombre }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

<ul class="nav nav-tabs" role="tablist" id="tabs">
    <li class="active"><a href="#tab_datos">Datos básicos</a></li>
    @if(isset($oferta))
    <li><a href="#tab_requisitos">Requisitos</a></li>
    @endif
</ul>

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="tab_datos">
        @include('ofertas.form', array('obj'=>$oferta))
    </div>
    <div class="tab-pane fade" id="tab_requisitos">
        @include('ofertas.requisitos_abm', array('oferta'=>$oferta))
    </div>
</div>
@stop