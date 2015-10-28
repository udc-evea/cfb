@extends('layouts.scaffold')
@section('title', 'Nueva Oferta - Universidad del Chubut')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div align="center">
            <h1><b>Registrar nueva Oferta Formativa</b></h1>
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
    <div class="col-md-10 col-md-offset-1" style="background-color: #ACF3C3; border-radius: 5px; padding: 20px">
        @include('ofertas.form', array('obj'=>null,'newForm'=>true))
    </div>
</div>

@stop