@extends('layouts.scaffold')
@section('title', 'Ofertas Formativas - CFB')
@section('main')

<div class="container">
<!-- Header -->
<div class="row block">
<div class="col-xs-12 col-md-12">
<div class="col-xs-6 col-md-4">
<img  src="{{asset('img/LOGO-200x60px.png')}}" width="150"/></div>
<div class="col-xs-12 col-md-8"><h1><span class="titulo1">Ofertas Formativas</span></h1></div>
</div>
</div>

<!-- Nav tabs -->
<div class="row">
<div class="col-xs-12 col-md-12">
<ul class="nav nav-tabs" id="tabs_ofertas" role="tablist">
    <li class="active"><a href="#tab_ofertas" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Ofertas</a></li>
  <li><a href="#tab_carreras" role="tab" data-toggle="tab"><i class="fa fa-university"></i> Carreras</a></li>
</ul>
</div>
</div>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="tab_ofertas">
        @include('ofertas.listado', compact('ofertas'))
    </div>
    <div class="tab-pane" id="tab_carreras">
        @include('ofertas.listado_carreras', compact('carreras'))
    </div>
</div>
</div>


<script>
    $(function(){
        $('#tabs_ofertas a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@stop