@extends('layouts.inscripciones_publico')
@section('title', 'Inscripción a: '.$oferta->nombre.' - CFB')
@section('main')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1>Inscripción a: {{ $oferta->nombre }}</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
            </ul>
        </div>
        @endif
        @include('inscripciones.'.$oferta->view.'.form', array('obj' => null, 'oferta' => $oferta))
    </div>
</div>
@stop