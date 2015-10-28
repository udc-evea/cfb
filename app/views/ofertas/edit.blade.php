@extends('layouts.scaffold')
@section('title', 'Oferta: '.$oferta->nombre.' - Universidad del Chubut')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div align="center">
            <h1><b>{{ $oferta->nombre }}</b></h1>
        </div>
        <hr>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
            </ul>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="span12">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li class="active"><a href="#tab_datos">Datos básicos</a></li>
            @if(isset($oferta))
            <li><a href="#tab_requisitos">Requisitos</a></li>
            @endif
        </ul>
    </div>
</div>
<div class="row">
    <div class="span12">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="tab_datos">
                <div class="col-md-10 col-md-offset-1" style="background-color: #E0F3AC; border-radius: 5px; padding: 20px">
                    @include('ofertas.form', array('obj'=>$oferta,'newForm'=>False))
                </div>
            </div>
            <div class="tab-pane fade" id="tab_requisitos">
                @include('ofertas.requisitos_abm', array('oferta'=>$oferta,'newForm'=>False))
            </div>
        </div>
    </div>
</div>
@stop