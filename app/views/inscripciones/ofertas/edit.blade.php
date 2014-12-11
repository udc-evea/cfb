@extends('layouts.scaffold')
@section('title', 'Inscripción de: '.$inscripcion->inscripto.' en: '.$oferta->nombre.' - CFB')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ $inscripcion->inscripto }} - {{ $inscripcion->oferta->nombre }}</h1>

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
        @include('inscripciones.'.$oferta->view.'.form', array('obj' => $inscripcion))
    </div>
    <div class="tab-pane fade" id="tab_requisitos">
        @include('inscripciones.requisitos_abm', array('obj'=>$oferta))
    </div>
</div>
@stop


@stop