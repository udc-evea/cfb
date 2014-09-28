<?php $cargado = false; ?>
@foreach($presentados as $pres)
    @if($pres->requisito_id == $requisito->id)
        <?php $cargado = true;?>
        <?php $pres1 = $pres;?>
    @else
        <?php continue;?>
    @endif
@endforeach

@if($cargado)
{{ $pres1->fecha_presentacion }}
<a href="{{ route('cursos.inscripciones.requisito_borrar', array($curso->id, $inscripcion->id, $requisito->id)) }}" class="btn btn-default btn-sm action-borrar" data-method="delete" data-remote="true"><span class="glyphicon glyphicon-remove"></span></a>
@else
<form action="{{ route('cursos.inscripciones.requisito_presentar', array($curso->id, $inscripcion->id)) }}" class="nuevo" data-remote="true" method="post">
<input type="hidden" name="requisito_id" value="{{ $requisito->id}}"/>

<div class="input-group">
<input type="date" id="fecha_presentacion_{{$requisito->id}}" name="fecha_presentacion" class="input-sm form-control"/>
<span class="input-group-btn">
<button class="btn btn-default input-sm" type="submit"><span class="glyphicon glyphicon-ok"></span></button>
</span>
</div>
</form>
@endif