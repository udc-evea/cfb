@extends('layouts.scaffold')
@section('title', 'Ofertas Formativas - CFB')
@section('main')
<h1>Ofertas Formativas</h1>

<!-- Nav tabs -->
<ul class="nav nav-tabs" id="tabs_ofertas" role="tablist">
    <li class="active"><a href="#tab_ofertas" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Ofertas</a></li>
  <li><a href="#tab_carreras" role="tab" data-toggle="tab"><i class="fa fa-university"></i> Carreras</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="tab_ofertas">
        @include('ofertas.listado', compact('ofertas'))
    </div>
    <div class="tab-pane" id="tab_carreras">
        @include('ofertas.listado_carreras', compact('carreras'))
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