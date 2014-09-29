@extends('layouts.inscripciones_publico')
@section('title', 'Inscripción a: '.$curso->nombre.' - CFB')
@section('main')

<div class="row">
    <div class="col-md-6">
        <h1>Inscripción a: {{ $curso->nombre }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
        @include('inscripciones.form', array('obj' => null, 'curso' => $curso))
    </div>
</div>
@stop