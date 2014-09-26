@extends('layouts.scaffold')
@section('title', 'Nueva Oferta - CFB')
@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Registrar nueva Oferta Educativa</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

@include('cursos.form', array('obj'=>null))

@stop