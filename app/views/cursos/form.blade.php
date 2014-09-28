<?php $method = $obj ? 'PATCH' : 'POST'; ?>
<?php $route_name = $obj ? 'cursos.update' : 'cursos.store'; ?>
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
{{ Former::number('anio')->required()->value(date("Y")) }}
<input type="hidden" name="permite_inscripciones" value="0"/>
{{ Former::checkbox('permite_inscripciones')->addClass('checkbox') }}
<input type="hidden" name="vigente" value="0"/>
{{ Former::checkbox('vigente')->addClass('checkbox') }}

{{ Former::date('inicio')->label('Fecha inicio') }}
{{ Former::date('fin')->label('Fecha fin') }}
{{ Former::number('cupo_maximo')->label('Cupo máximo')->help('0 o vacío: sin cupo.') }}
{{ Former::textarea('terminos')->label('Reglamento')->rows(8) }}

<hr>
{{ Former::actions(
            link_to_route('cursos.index', 'Volver', null, array('class' => 'btn btn-lg btn-link')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Guardar')
    )
}}
</fieldset>
{{ Former::close() }}