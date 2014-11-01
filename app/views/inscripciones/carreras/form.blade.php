<?php $method        = $obj != null ? 'PUT' : 'POST';?>
<?php $route_name    = $obj != null ? 'update' : 'nueva';?>
<?php $route_params  = $obj != null ? array($oferta->id, $obj->id) : array($oferta->id);?>

{{ HTML::script('js/inscripciones.js') }}
<script>
    $(function(){
       InscripcionesModule.init({{ $oferta->id }}); 
    });
</script>
@if($oferta->esCarrera)
{{ HTML::script('js/inscripciones_carreras.js') }}
<script>
    $(function(){
       InscripcionesCarrerasModule.init({{ $oferta->id }}); 
    });
</script>
@endif

<style>
    td, th {padding: 5px !important;}
</style>
<div class="row">
    <div class="col-md-12">
        @if(is_null($obj))
            {{ Form::model($obj, ['route' => ['ofertas.inscripciones.nueva', $oferta->id], 'method' => 'POST', 'autocomplete' => 'off']) }}
        @else
            {{ Form::model($obj, ['route' => ['ofertas.inscripciones.update', $oferta->id, $obj->id], 'method' => 'PUT', 'autocomplete' => 'off']) }}
        @endif
     
     {{ Form::hidden('oferta_formativa_id', $oferta->id) }}   
        <table align="center" cellpadding="10" cellspacing="10" class="table-bordered" style="width: 100%; text-align: left; font-weight: bold;">
            <thead bgcolor="#FFFFFF"><tr style="text-align: center; background-color: #2c3e50; color: #FFFFFF; font-weight: bold;">
                    <td height="50px" colspan="4"><h1>PLANILLA DE INSCRIPCIÓN</h1></td>
                </tr>
                <tr>
                  <td colspan="2" rowspan="2"><img src="{{asset('img/LOGO-200x60px.png')}}" alt="Logo UDC" width="" height="" class="img-responsive"/></td>
                    <td>
                        <p>AÑO INGRESO A LA UNIVERSIDAD: <strong>{{ $oferta->anio }}</strong>
                </tr>
                <tr>
                    <td>
                        <p>CARRERA: <strong>{{ $oferta->nombre }}</strong></p>
                    </td>
                </tr>
                <tr style="text-align: center; background-color: #ecf0f1; color: #D94548; font-weight: bold;">
                    <td height="25px" colspan="4"><span class="text-danger">Los campos con asterisco* son de carácter obligatorio</span></td>
                </tr>
            </thead>
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#16a085" style="color: #FFF;"><span class="glyphicon glyphicon-user"></span> DATOS PERSONALES </td>
                    <td bgcolor="#FFFFFF">
                        <div class="col-md-12">
                            <label>Apellidos <span class="text-danger"><span style="font-size: 14px">*</span>(campo obligatorio)</span></label> 
                            {{ Form::text('apellido', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                    <td bgcolor="#FFFFFF">
                        <div class="col-md-12">
                            <label>Nombres<span class="text-danger">*</span></label> 
                            {{ Form::text('nombre', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div class="col-md-12">
                            <label>Sexo<span class="text-danger">*</span></label> 
                            <label class="radio-inline">{{Form::radio('sexo', 'M', false)}} M</label>
                            <label class="radio-inline">{{Form::radio('sexo', 'F', false)}} F</label>
                        </div>
                    </td>
                    <td> Documento:<span class="text-danger">*</span>
                        @foreach(TipoDocumento::all() as $item)
                            {{Form::radio('tipo_documento_cod', $item->id, false)}}
                      <label class="radio-inline">{{ $item->descripcion }}</label>
                        @endforeach
                  </td>
                    <td colspan="2">
                        <div class="col-md-12">
                            <label>Número<span class="text-danger">*</span></label> 
                            {{ Form::text('documento', null, ['class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td colspan="4">
                        <div class="col-md-12"> <label>Nacido en</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Localidad<span class="text-danger">*</span></label> {{ Form::select('localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                                    {{ Form::text('localidad_otra', null, ['class' => 'form-control input-sm otra_localidad_id hide']) }}
                                </div>
                                <div class="col-md-2">
                                    <label>Depto.<span class="text-danger">*</span></label>  {{ Form::text('localidad_depto', null, ['class' => 'form-control input-sm']) }}
                                </div>
                                <div class="col-md-3">
                                    <label>Pcia.<span class="text-danger">*</span></label>  {{ Form::select('localidad_pcia_id', Provincia::select(), null, ['class' => 'form-control input-sm']) }}
                                </div>
                                <div class="col-md-3">
                                    <label>País<span class="text-danger">*</span></label> 
                                    {{ Form::select('localidad_pais_id', Pais::select(), null, ['class' => 'form-control input-sm con_otra']) }}
                                    {{ Form::text('localidad_pais_otro', null, ['class' => 'form-control input-sm otra_localidad_pais_id hide']) }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <label>Fecha de Nac.<span class="text-danger">*</span></label>
                            {{ Form::text('fecha_nacimiento', null, ['id' => 'fecha_nacimiento', 'class' => 'form-control input-sm fecha', 'required']) }}
                        </div>
                    </td>
                    <td colspan="3">Nacionalidad:<span class="text-danger">*</span>

                        @foreach(Nacionalidad::all() as $item)
                        <label class="radio-inline">
                            {{Form::radio('nacionalidad_id', $item->id, false)}} 
                            {{ $item->descripcion }}
                        </label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Teléfono fijo</label> {{ Form::text('telefono_fijo', null, ['class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="col-sm-12"><label>Teléfono Celular<span class="text-danger">*</span></label> {{ Form::text('telefono_celular', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="col-sm-6"><label>Email<span class="text-danger">*</span></label> {{ Form::email('email', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        <div class="col-sm-6"><label>Reingrese email<span class="text-danger">*</span></label> {{ Form::email('email_confirmation', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-bordered" width="100%">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#e67e22" style="color: #FFFFFF;"><span class="glyphicon glyphicon-map-marker"></span> DOMICILIO DE PROCEDENCIA</td>
                    <td style="font-weight: bold">Tipo de Residencia: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_tipo_residencia as $num => $item)
                      <label class="radio-inline">{{Form::radio('domicilio_procedencia_tipo', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Calle<span class="text-danger">*</span></label> {{ Form::text('domicilio_procedencia_calle', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-1"><label>N°<span class="text-danger">*</span></label> {{ Form::text('domicilio_procedencia_nro', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-1"><label>Piso</label> {{ Form::text('domicilio_procedencia_piso', null, ['class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>Depto</label> {{ Form::text('domicilio_procedencia_depto', null, ['class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-4"><label>Localidad<span class="text-danger">*</span></label> 
                                {{ Form::select('domicilio_procedencia_localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                                {{ Form::text('domicilio_procedencia_localidad_otra', null, ['class' => 'form-control input-sm otra_domicilio_procedencia_localidad_id hide']) }}
                            </div>
                            <div class="col-sm-2"><label>Cód. Postal<span class="text-danger">*</span></label> {{ Form::text('domicilio_procedencia_cp', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-sm-3"><label>Provincia<span class="text-danger">*</span></label> {{ Form::select('domicilio_procedencia_pcia_id', Provincia::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>País<span class="text-danger">*</span></label> 
                                {{ Form::select('domicilio_procedencia_pais_id', Pais::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                                {{ Form::text('domicilio_procedencia_pais_otro', null, ['class' => 'form-control input-sm otra_domicilio_procedencia_pais_id hide']) }}
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-bordered domicilio_clases" width="100%">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#d35400" style="color: #FFFFFF;"><span class="glyphicon glyphicon-map-marker"></span> DOMICILIO EN PERÍODO DE CLASES</td>
                    <td><label class="checkbox-inline">{{ Form::checkbox('domicilio_clases_igual', true, false) }} Igual que el domicilio de residencia</label></td>
                </tr>
                <tr class="opcional">
                    <td colspan="2" style="font-weight: bold">Tipo de Residencia: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_tipo_residencia as $num => $item)
                      <label class="radio-inline">{{Form::radio('domicilio_clases_tipo', $num, false )}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr class="opcional">
                    <td>
                        <div class="col-sm-12"><label>Calle<span class="text-danger">*</span></label> {{ Form::text('domicilio_clases_calle', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-1"><label>N°<span class="text-danger">*</span></label> {{ Form::text('domicilio_clases_nro', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-1"><label>Piso</label> {{ Form::text('domicilio_clases_piso', null, ['class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>Depto</label> {{ Form::text('domicilio_clases_depto', null, ['class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-4"><label>Localidad<span class="text-danger">*</span></label> 
                                {{ Form::select('domicilio_clases_localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                                {{ Form::text('domicilio_clases_localidad_otra', null, ['class' => 'form-control input-sm otra_domicilio_clases_localidad_id hide']) }}
                            </div>
                            <div class="col-sm-2"><label>Cód. Postal<span class="text-danger">*</span></label> {{ Form::text('domicilio_clases_cp', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        </div>
                    </td>
                </tr>
                <tr class="opcional">
                    <td colspan="2">
                        <div class="row">
                            <div class="col-sm-3"><label>Provincia<span class="text-danger">*</span></label> {{ Form::select('domicilio_clases_pcia_id', Provincia::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>País<span class="text-danger">*</span></label> 
                                {{ Form::select('domicilio_clases_pais_id', Pais::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                                {{ Form::text('domicilio_clases_pais_otro', null, ['class' => 'form-control input-sm otra_domicilio_clases_pais_id hide']) }}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Con quién vive: &nbsp; <span class="text-danger">*</span>
                        @foreach(ConQuienVive::all() as $item)
                        <label class="radio-inline">{{Form::radio('domicilio_clases_con_quien_vive_id', $item->id, false)}} {{$item->descripcion}}</label>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#9054A9" style="color:#fff;"><span class="glyphicon glyphicon-book"></span> COLEGIO SECUNDARIO</td>
                    <td colspan="2"> 
                        <div class="col-md-12">
                            <label>Título Obtenido<span class="text-danger">*</span></label>
                            {{ Form::text('secundario_titulo_obtenido', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                    <td>
                        <div class="col-md-4">
                            <label>Año de egreso<span class="text-danger">*</span></label>
                            {{ Form::text('secundario_anio_egreso', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="col-md-12">
                            <label>Nombre y Número del Colegio<span class="text-danger">*</span></label>
                            {{ Form::text('secundario_nombre_colegio', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                    <td style="font-weight: bold"> Tipo de Establec.:<span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_tipo_establecimiento as $num => $item)
                        <label class="radio-inline">{{Form::radio('secundario_tipo_establecimiento', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <label>Localidad<span class="text-danger">*</span></label>
                            {{ Form::select('secundario_localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                            {{ Form::text('secundario_localidad_otra', null, ['class' => 'form-control input-sm otra_secundario_localidad_id hide']) }}
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12">
                            <label>Provincia<span class="text-danger">*</span></label>
                            {{ Form::select('secundario_pcia_id', Provincia::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="col-md-6">
                            <label>País<span class="text-danger">*</span></label>
                            {{ Form::select('secundario_pais_id', Pais::select(), null, ['required', 'class' => 'form-control input-sm con_otra']) }}
                            {{ Form::text('secundario_pais_otro', null, ['class' => 'form-control input-sm otra_secundario_pais_id hide']) }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-bordered situacion_laboral" width="100%">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#34495e" style="color:#fff;"><span class="glyphicon glyphicon-info-sign"></span> SITUACIÓN LABORAL</td>
                    <td width="65%"><span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr class="opcional">
                    <td style="font-weight: bold"><span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_ocupacion as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral_ocupacion', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                    <td style="font-weight: bold">Cant. de horas/semana: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_horas_semana as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral_horas_semana', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr class="opcional">
                    <td colspan="3">Relación de trabajo con la carrera: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_relacion_trabajo_carrera as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral_relacion_trabajo_carrera', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>

                <tr class="opcional">
                    <td><label>Rama de la actividad económica<span class="text-danger">*</span></label>
                        {{ Form::select('situacion_laboral_rama_id', RamaActividadLaboral::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                    <td> <label>Categoría Ocupacional<span class="text-danger">*</span></label>
                        {{ Form::select('situacion_laboral_categoria_ocupacional_id', CategoriaOcupacional::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                </tr>
                <tr class="opcional">
                    <td colspan="3"><label>Detalle de la labor que realiza<span class="text-danger">*</span></label>
                        {{ Form::textarea('situacion_laboral_detalle_labor', null, ['required', 'class' => 'form-control', 'rows' => '2']) }}
                    </td>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered datos_padre">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#2980b9" style="color:#fff;"><span class="glyphicon glyphicon-list-alt"></span> DATOS DEL PADRE</td>
                    <td width="65%"> <label>Apellidos y Nombres del PADRE: <span class="text-danger">*</span></label>{{ Form::text('padre_apeynom', null, ['required', 'class' => 'form-control input-sm']) }}</td>
                </tr>
                <tr>
                    <td colspan="2">¿Vive? <span class="text-danger">*</span>
                         @foreach(InscripcionCarrera::$enum_vive as $num => $item)
                        <label class="radio-inline">{{Form::radio('padre_vive', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td></tr>
                <tr class="opcional depende">
                    <td colspan="2"><label>Estudios del PADRE<span class="text-danger small">*</span></label>
                        {{ Form::select('padre_estudios_id', NivelEstudios::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                </tr>

                <tr class="opcional">
                    <td style="font-weight: bold">Ocupación:<span class="text-danger">*</span> 
                        @foreach(InscripcionCarrera::$enum_padre_ocupacion as $num => $item)
                        <label class="radio-inline">{{Form::radio('padre_ocupacion', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                    <td>Categoría Ocupacional 
                       {{ Form::select('padre_categoria_ocupacional_id', CategoriaOcupacional::select(), null, ['required', 'class' => 'form-control input-sm']) }}</td>
                </tr>
                <tr class="opcional">
                    <td colspan="2"> <label>Descripción de la labor que realiza<span class="text-danger">*</span></label>
                        {{ Form::textarea('padre_labor', null, ['required', 'class' => 'form-control', 'rows' => '2']) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered datos_madre">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#e74c3c" style="color:#fff;"><span class="glyphicon glyphicon-list-alt"></span> DATOS DE LA MADRE</td>
                    <td width="65%"> <label>Apellidos y Nombres de la MADRE:<span class="text-danger">*</span> </label>{{ Form::text('madre_apeynom', null, ['required', 'class' => 'form-control input-sm']) }}</td>
                </tr>
                <tr>
                    <td colspan="2">¿Vive? <span class="text-danger">*</span>
                         @foreach(InscripcionCarrera::$enum_vive as $num => $item)
                        <label class="radio-inline">{{Form::radio('madre_vive', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td></tr>
                <tr class="opcional depende">
                    <td colspan="2"><label>Estudios de la MADRE<span class="text-danger">*</span></label>
                        {{ Form::select('madre_estudios_id', NivelEstudios::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                </tr>

                <tr class="opcional">
                    <td style="font-weight: bold">Ocupación: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_padre_ocupacion as $num => $item)
                        <label class="radio-inline">{{Form::radio('madre_ocupacion', $num, false)}} {{$item}}</label>
                        @endforeach
                    </td>
                    <td style="font-weight: bold">Categoría Ocupacional <span class="text-danger">*</span>
                       {{ Form::select('madre_categoria_ocupacional_id', CategoriaOcupacional::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                </tr>
                <tr class="opcional">
                    <td colspan="2"> <label>Detalle de la labor que realiza<span class="text-danger">*</span></label>
                        {{ Form::textarea('madre_labor', null, ['required', 'class' => 'form-control', 'rows' => '2']) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br/>
        @unless(Auth::check())
        <table class="table-bordered" width="100%">
            <tbody bgcolor="#ecf0f1">
                <tr>
                    <td align="center">
                        <div class="checkbox">
                            <label><p class="lead">{{Form::checkbox('reglamento', 1, false, ['required'])}} He leído y acepto el <a href="#" data-toggle="modal" data-target="#modal_reglamento">reglamento vigente</a>.<span class="text-danger">*</span></p></label>
                        </div>
                    </td>
             
                    <td><label>Código de seguridad</label>{{ Form::captcha(array('required' => 'required')) }}</td>
                </tr>
            </tbody>
        </table>
        @include('inscripciones.reglamento', array('oferta' => $oferta))
        @endunless
        <hr>
        <div class="row col-md-offset-4">
            
            <button type="button" class="btn btn-lg btn-info"><span class="glyphicon glyphicon-chevron-left"></span><a href="http://udc.edu.ar" class="muted"> Volver </a></button>
            
            <button type="reset" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-refresh"></span> Restablecer </button>
            
            <button type="submit" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-send"></span> Enviar inscripción</button>
            
      </div> 
  </div>
    {{Form::close()}}
    </div>
</div>