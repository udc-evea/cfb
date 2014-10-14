<?php $method = $obj ? 'PATCH' : 'POST'; ?>
<?php $route_name = $obj ? 'ofertas.update' : 'ofertas.store'; ?>
<?php $route_params = $obj ? array('id' => $obj->id) : array(); ?>

{{Former::framework('TwitterBootstrap3')}}
{{ Former::horizontal_open()
        ->secure()
        ->rules(['nombre' => 'required'])
        ->method($method)
        ->route($route_name, $route_params  );
}}
{{ Former::populate($obj) }}
<fieldset>
{{ Former::text('nombre')->required()->onGroupAddClass('form-group-lg') }}
{{ Former::number('anio')->required()->value(date("Y"))->help('Año en que se dicta la oferta formativa') }}

<div class="form-group required">
    <label class="control-label col-lg-2 col-sm-4">Tipo de Oferta</label>
    <div class="col-lg-10 col-sm-8">
        <div class="btn-group" data-toggle="buttons">
        @foreach($tipos_oferta as $item)
            <label class="btn btn-default @if($obj && $item->id == $obj->tipo_oferta) active @endif">
                <i class="fa {{ $item->icono }}"></i> 
                <input type="radio" @if($obj && $item->id == $obj->tipo_oferta) checked="checked" @endif name="tipo_oferta" value="{{$item->id}}" id="tipo_oferta_{{$item->id}}"> {{ $item->descripcion }}
            </label>
        @endforeach
        </div>
    </div>
</div>

<input type="hidden" name="permite_inscripciones" value="0"/>
{{ Former::checkbox('permite_inscripciones')
	->addClass('checkbox')->help('Habilita las inscripciones a esta oferta') }}

{{ Former::text('inicio')->label('Fecha inicio')->addClass('fecha') }}
{{ Former::text('fin')->label('Fecha fin')->addClass('fecha') }}
{{ Former::number('cupo_maximo')->label('Cupo máximo')->help('0 o vacío: sin cupo.') }}
{{ Former::textarea('terminos')->label('Reglamento')->rows(8) }}
{{ Former::textarea('mail_bienvenida')
            ->label('Mail de bienvenida')->rows(10)->help('Vacío: envía un mail genérico.') }}

<hr>
{{ Former::actions(
            link_to_route('ofertas.index', 'Volver', null, array('class' => 'btn btn-lg btn-link')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Guardar')
    )
}}
</fieldset>
{{ Former::close() }}