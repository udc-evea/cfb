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
@include('cursos.form', array('obj'=>$curso))
@stop