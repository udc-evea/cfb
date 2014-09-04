@extends('layouts.scaffold')
@section('title', 'Inscripción a: '.$curso->nombre.' - CFB')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Inscripción al curso: {{ $curso->nombre }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

@include('inscripciones.form', array('obj' => null, 'curso' => $curso))

@stop