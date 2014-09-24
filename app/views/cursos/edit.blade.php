@extends('layouts.scaffold')
@section('title', 'Curso: '.$curso->nombre.' - CFB')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ $curso->nombre }}</h1>

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
    @if(isset($curso))
    <li><a href="#tab_requisitos">Requisitos</a></li>
    @endif
</ul>

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active in" id="tab_datos">
        @include('cursos.form', array('obj'=>$curso))
    </div>
    <div class="tab-pane fade" id="tab_requisitos">
        @include('cursos.requisitos_abm', array('obj'=>$curso))
    </div>
</div>
@stop