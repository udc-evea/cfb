@extends('layouts.inscripciones_publico')
@section('title', 'Preinscripción a: '.$oferta->nombre.' - Universidad del Chubut')
@section('main')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1>Preinscripción a: <strong>{{ $oferta->nombre }}</strong></h1>

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