<?php $method        = $obj != null ? 'PUT' : 'POST';?>
<?php $route_name    = $obj != null ? 'update' : 'store';?>
<?php $route_params  = $obj != null ? array($curso->id, $obj->id) : array($curso->id);?>

{{Former::framework('TwitterBootstrap3')}}
{{ Former::horizontal_open()
        ->secure()
        ->method($method)
        ->route("cursos.inscripciones.$route_name", $route_params)
}}
{{ Former::populate($obj) }}
{{ Former::hidden('oferta_academica_id')->value($curso->id) }}
<div class="panel panel-default">
    <div class="panel-heading"><strong>¿Quién sos?</strong></div>
    <div class="panel-body">
        {{ Former::select('tipo_documento_cod')
            ->fromQuery(TipoDocumento::orderBy('descripcion')->get(), 'descripcion', 'tipo_documento')
            ->label('Tipo doc.')
            ->value(TipoDocumento::TIPODOC_DNI)->required() }}
        {{ Former::number('documento')->required() }}
        {{ Former::text('apellido')->required() }}
        {{ Former::text('nombre')->required() }}
        {{ Former::inline_radios('sexo')->radios([
             'Hombre' => ['value' => 'M'],
             'Mujer'  => ['value' => 'F']
           ])->required() }}

        {{ Former::date('fecha_nacimiento2')->required()->label('Fecha nacimiento') }}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong>¿De dónde sos?</strong>
    </div>
    <div class="panel-body">
    {{ Former::select('localidad_id')
                ->fromQuery(Localidad::all(), 'localidad', 'id')
                ->value(Localidad::ID_RAWSON)
                ->label('Localidad')
                ->required() }}
        {{ Former::text('localidad_otra')->label('Otra') }}
        {{ Former::number('localidad_anios_residencia')->label('Años de residencia')->required() }}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><strong>¿Qué estudiaste?</strong></div>
    <div class="panel-body">
        {{ Former::select('nivel_estudios_id')
            ->fromQuery(NivelEstudios::all(), 'nivel_estudios', 'id')
            ->value(NivelEstudios::NIVEL_SEC_COMPLETO)->required()
            ->label('Nivel de estudios')
        }}
        {{ Former::text('titulo_obtenido')->label('Título obtenido') }}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><strong>¿Cómo te contactamos?</strong></div>
    <div class="panel-body">
        {{ Former::email('email')->label('Correo electrónico')->required() }}
        {{ Former::text('telefono')->label('Teléfono')->required() }}
    </div>
</div>
{{ Former::checkbox('reglamento')
     ->label('Reglamento')
     ->text('He leído y acepto el <a href="#" data-toggle="modal" data-target="#modal_reglamento">reglamento del curso</a>.')
     ->required()
}}
@include('inscripciones.reglamento', array('curso' => $curso))

@if(Auth::check())
{{ Former::actions(
            link_to_route('cursos.inscripciones.index', 'Volver', $curso->id, array('class' => 'btn btn-lg btn-link')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Guardar')
   )
}}
@else
<div class="form-group">
    <label class="control-label col-lg-2 col-sm-4">Código de seguridad</label>
    <div class="col-lg-10 col-sm-8">
        {{ Form::captcha(array('required' => 'required')) }}
    </div>
</div>
{{ Former::actions(
            link_to('http://udc.edu.ar', 'Volver', array('class' => 'btn btn-lg btn-link')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Completar inscripción')
    )
}}
@endif
{{ Former::close() }}