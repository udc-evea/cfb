@extends('layouts.scaffold')
@section('title', 'Inscripción de: '.$inscripcion->inscripto.' en: '.$curso->nombre.' - CFB')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ $inscripcion->inscripto }} en: {{ $inscripcion->curso->nombre }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

@include('inscripciones.form', array('obj' => $inscripcion))

@stop