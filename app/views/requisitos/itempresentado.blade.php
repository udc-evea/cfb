<?php $cargado = false; ?>
@foreach($presentados as $pres)
@if($pres->requisito_id == $requisito->id)
<?php $cargado = true; ?>
<?php $pres1 = $pres; ?>
@else
<?php continue; ?>
@endif
@endforeach

@if($cargado)
<div class="input-group">
    <span class="form-control-static input-xs">{{ $pres1->fecha_presentacion }}</span>
    <span class="input-group-btn">
        <a href="{{ route('ofertas.inscripciones.requisito_borrar', array($oferta->id, $inscripcion->id, $pres1->id)) }}" class="btn btn-warning btn-xs action-borrar" data-method="delete" data-remote="true"> Anular</a>
    </span>
</div>
@else
<form action="{{ route('ofertas.inscripciones.requisito_presentar', array($oferta->id, $inscripcion->id)) }}" class="nuevo" data-remote="true" method="post">
    <input type="hidden" name="requisito_id" value="{{ $requisito->id}}"/>

    <div class="input-group">
        <input type="text" id="fecha_presentacion_{{$requisito->id}}" name="fecha_presentacion" class="form-control input-xs fecha" value="{{ date("d/m/Y") }}"/>
        <span class="input-group-btn">
            <button class="btn btn-primary btn-xs" type="submit">Presentar</button>
        </span>
    </div>
</form>
@endif