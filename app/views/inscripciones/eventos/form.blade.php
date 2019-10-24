<?php $method        = $obj != null ? 'PUT' : 'POST';?>
<?php $route_name    = $obj != null ? 'update' : 'nueva';?>
<?php $route_params  = $obj != null ? array($oferta->id, $obj->id) : array($oferta->id);?>
{{ HTML::script('js/inscripciones.js') }}
<script>
    $(function(){
       InscripcionesModule.init({{ $oferta->id }}); 
    });
</script>
{{Former::framework('TwitterBootstrap3')}}
{{ Former::horizontal_open()
        ->secure()
        ->method($method)
        ->route("ofertas.inscripciones.$route_name", $route_params)
        ->autocomplete("off")
}}
{{ Former::populate($obj) }}
{{ Former::hidden('oferta_formativa_id')->value($oferta->id) }}
<div class="panel panel-default">
    <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> <strong>Datos Personales</strong></div>
    <div class="panel-body">
        {{ Former::text('apellido')->required()->placeholder('Como figura en tu D.N.I.')->label('Apellido/s')}}
        {{ Former::text('nombre')->required()->placeholder('Como figura en tu D.N.I.')->label('Nombre/s')}}

        {{ Former::select('tipo_documento_cod')
            ->fromQuery(TipoDocumento::orderBy('descripcion')->get(), 'descripcion', 'tipo_documento')
            ->label('Tipo doc.')
            ->value(TipoDocumento::TIPODOC_DNI)
            ->required() }}
        <!--{{ Former::number('documento')->required() }} -->
        {{ Former::text('documento')->required() }}
        {{ Former::text('fecha_nacimiento')->required()->label('Fecha nacimiento')->class('form-control fecha') }}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-map-marker"></span> <strong>Lugar de Residencia</strong>
    </div>
    <div class="panel-body">
    {{ Former::select('localidad_id')
                ->fromQuery(Localidad::orderBy('localidad')->get(), 'localidad', 'id')
                ->value(Localidad::ID_RAWSON)
                ->label('Localidad')
                ->addClass('con_otra')
                ->required() }}
    {{ Former::text('localidad_otra')->label('Otra')->addGroupClass('otra_localidad_id hide') }}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><span class="glyphicon glyphicon-phone"></span> <strong>Información de Contacto</strong></div>
    <div class="panel-body">
        {{ Former::email('email')->label('Correo electrónico')->required() }}
        <!-- {{ Former::email('email_confirmation')->label('Reingrese correo')->required() }} -->
        {{ Former::text('telefono')->label('Teléfono')->required() }}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> <strong>Para terminar...</strong></div>
    <div class="panel-body">
        {{ Former::select('como_te_enteraste')
            ->fromQuery(InscripcionComoTeEnteraste::all(), 'como_te_enteraste', 'id')
            ->value(1)->required()
            ->label('¿Cómo te enteraste de esta oferta?')
            ->addClass('con_otra')
        }}
        {{ Former::text('como_te_enteraste_otra')->label("&nbsp;")->addClass('otra_como_te_enteraste hide') }}
    </div>
</div>


@if(Auth::check())   
    {{ Former::actions(
                link_to_route('ofertas.inscripciones.index', 'Volver', $oferta->id, array('class' => 'btn btn-lg btn-default')),
                Former::lg_primary_reset('Restablecer'),
                Former::lg_success_submit('Enviar Inscripción')
       )
    }}
@else
    {{ Former::checkbox('reglamento')
         ->label('Reglamento')
         ->text('He leído y acepto el <a href="#" data-toggle="modal" data-target="#modal_reglamento">reglamento vigente</a>.')
         ->required()
         ->style('visibility: visible')
    }}
    @include('inscripciones.reglamento', array('oferta' => $oferta))

    <div class="form-group">
        <label class="control-label col-lg-2 col-sm-4">Código de seguridad</label>
        <div class="col-lg-10 col-sm-8">
            {{ Form::captcha(array('required' => 'required')) }}
        </div>
    </div>

    {{ Former::actions(
                link_to('http://udc.edu.ar', 'Volver', array('class' => 'btn btn-lg btn-default')),
                Former::lg_primary_reset('Restablecer'),
                Former::lg_success_submit('Completar inscripción')
        )
    }}
@endif
{{ Former::close() }}