<?php $method        = $obj ? 'PATCH' : 'POST';?>
<?php $route_name    = $obj ? 'cursos.update' : 'cursos.store';?>
<?php $route_params  = $obj ? array('id' => $obj->id) : array();?>

{{Former::framework('TwitterBootstrap3')}}
{{ Former::horizontal_open()
        ->secure()
        ->rules(['nombre' => 'required'])
        ->method($method)
        ->route($route_name, $route_params  );
}}
{{ Former::populate($obj) }}
{{ Former::text('nombre')->required() }}
{{ Former::number('anio')->required()->value(date("Y")) }}
<input type="hidden" name="permite_inscripciones" value="0"/>
{{ Former::checkbox('permite_inscripciones') }}
<input type="hidden" name="vigente" value="0"/>
{{ Former::checkbox('vigente') }}

{{ Former::date('inicio')->label('Fecha inicio') }}
{{ Former::date('fin')->label('Fecha fin') }}
{{ Former::textarea('terminos')->label('Reglamento')->rows(8) }}
{{ Former::actions(
            link_to_route('cursos.index', 'Volver', null, array('class' => 'btn btn-lg btn-link')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Guardar curso')
    )
}}
{{ Former::close() }}