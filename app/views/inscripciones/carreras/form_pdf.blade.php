@extends('layouts.base')
@section('title', 'Inscripción en: '.$oferta->nombre.' - CFB')
@section('main')

<?php $check_vacio = '<span class="fa fa-check-square-o"></span>'; $check_lleno = '<span class="fa fa-square-o"></span>';?>
<style>
    td, th {padding: 5px !important;}
</style>
<div class="row">
    <div class="col-md-12">
        <table align="center" cellpadding="10" cellspacing="10" class="table-bordered" style="width: 100%;">
            <thead><tr style="text-align: center; background-color: #bdc3c7; color: #FFFFFF">
                    <td colspan="4">PLANILLA DE INSCRIPCIÓN</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2"><img src="{{asset('img/LOGO-horizontal-MQ-RGB-150dpi.png')}}" alt="Logo UDC" width="" height="" class="img-responsive"/></td>
                    <td>
                        <p>AÑO INGRESO A LA UNIVERSIDAD: <strong>{{ $oferta->anio }}</strong>
                </tr>
                <tr>
                    <td>
                        <p>CARRERA: <strong>{{ $oferta->nombre }}</strong></p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">DATOS PERSONALES </td>
                    <td>
                        <div class="col-md-12">
                            <label>Apellidos: </label> 
                            {{ $inscripcion->apellido }}
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12">
                            <label>Nombres</label> 
                            {{ $inscripcion->nombre }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <label>Sexo</label> 
                            <label class="radio-inline">
                                @if($inscripcion->sexo == 'M')
                                {{ $check_lleno }}
                                @else
                                {{ $check_vacio }}
                                @endif
                                M
                            </label>
                            <label class="radio-inline">
                                @if($inscripcion->sexo == 'F')
                                {{ $check_lleno }}
                                @else
                                {{ $check_vacio }}
                                @endif
                                F
                            </label>
                        </div>
                    </td>
                    <td> Documento: 
                        @foreach(TipoDocumento::all() as $item)
                        <label class="radio-inline">
                            @if($inscripcion->tipo_documento_cod == $item->id)
                            {{ $check_lleno }} {{$item->descripcion}}
                            @else
                            {{ $check_vacio }} {{$item->descripcion}}
                            @endif
                        </label>
                        @endforeach
                    </td>
                    <td colspan="2">
                        <div class="col-md-12">
                            <label>Número</label> 
                            {{ $inscripcion->documento }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="col-md-12"> <label>Nacido en </label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Localidad</label> {{ $inscripcion->localidad }}
                                </div>
                                <div class="col-md-2">
                                    <label>Depto.</label>  {{ Form::text('localidad_depto', null, ['class' => 'form-control input-sm']) }}
                                </div>
                                <div class="col-md-3">
                                    <label>Pcia.</label>  {{ Form::select('localidad_pcia_id', Provincia::select(), null, ['class' => 'form-control input-sm']) }}
                                </div>
                                <div class="col-md-3">
                                    <label>País</label>  {{ Form::select('localidad_pais_id', Pais::select(), null, ['class' => 'form-control input-sm']) }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <label>Fecha de Nac.</label>
                            {{ Form::text('fecha_nacimiento', null, ['id' => 'fecha_nacimiento', 'class' => 'form-control input-sm fecha', 'required']) }}
                        </div>
                    </td>
                    <td colspan="3">Nacionalidad:  

                        @foreach(Nacionalidad::all() as $item)
                        <label class="radio-inline">
                            {{Form::radio('nacionalidad_id', $item->id, false, ['required'])}} 
                            {{ $item->descripcion }}
                        </label>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-bordered" width="100%">
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">DOMICILIO DE PROCEDENCIA</td>
                    <td>Tipo de Residencia: 
                        @foreach(InscripcionCarrera::$enum_tipo_residencia as $num => $item)
                        <label class="radio-inline">{{Form::radio('domicilio_procedencia_tipo', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Calle</label> {{ Form::text('domicilio_procedencia_calle', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-1"><label>N°</label> {{ Form::text('domicilio_procedencia_nro', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-1"><label>Piso</label> {{ Form::text('domicilio_procedencia_piso', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>Depto</label> {{ Form::text('domicilio_procedencia_depto', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-4"><label>Localidad</label> {{ Form::select('domicilio_procedencia_localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-2"><label>Cód. Postal</label> {{ Form::text('domicilio_procedencia_cp', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-sm-3"><label>Provincia</label> {{ Form::select('domicilio_procedencia_pcia_id', Provincia::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>País</label> {{ Form::select('domicilio_procedencia_pais_id', Pais::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>Teléfono fijo</label> {{ Form::text('domicilio_procedencia_telefono_fijo', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Teléfono Celular</label> {{ Form::text('domicilio_procedencia_telefono_celular', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="col-sm-3"><label>Email</label> {{ Form::email('domicilio_procedencia_email', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-bordered" width="100%">
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">DOMICILIO EN PERÍODO DE CLASES</td>
                    <td>Tipo de Residencia:  
                        @foreach(InscripcionCarrera::$enum_tipo_residencia as $num => $item)
                        <label class="radio-inline">{{Form::radio('domicilio_clases_tipo', $num, false , ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Calle</label> {{ Form::text('domicilio_clases_calle', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-1"><label>N°</label> {{ Form::text('domicilio_clases_nro', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-1"><label>Piso</label> {{ Form::text('domicilio_clases_piso', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>Depto</label> {{ Form::text('domicilio_clases_depto', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-4"><label>Localidad</label> {{ Form::select('domicilio_clases_localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-2"><label>Cód. Postal</label> {{ Form::text('domicilio_clases_cp', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-sm-3"><label>Provincia</label> {{ Form::select('domicilio_clases_pcia_id', Provincia::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>País</label> {{ Form::select('domicilio_clases_pais_id', Pais::select(), null, ['required', 'class' => 'form-control input-sm']) }}</div>
                            <div class="col-sm-3"><label>Teléfono fijo</label> {{ Form::text('domicilio_clases_telefono_fijo', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Teléfono Celular</label> {{ Form::text('domicilio_clases_telefono_celular', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                    <td>
                        <div class="col-sm-3"><label>Email</label> {{ Form::text('domicilio_clases_email', null, ['required', 'class' => 'form-control input-sm']) }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Con quién vive: &nbsp;
                        @foreach(ConQuienVive::all() as $item)
                        <label class="radio-inline">{{Form::radio('domicilio_clases_con_quien_vive_id', $item->id, false, ['required'])}} {{$item->descripcion}}</label>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered">
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">COLEGIO SECUNDARIO</td>
                    <td> 
                        <div class="col-md-12">
                            <label>Título Obtenido</label>
                            {{ Form::text('secundario_titulo_obtenido', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
                            <label>Año de egreso</label>
                            {{ Form::text('secundario_anio_egreso', null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" colspan="2">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nombre y Número del Colegio</label>
                                {{ Form::text('secundario_nombre_colegio', null, ['required', 'class' => 'form-control input-sm']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Provincia</label>
                                {{ Form::select('secundario_pcia_id', Provincia::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                            </div>
                            <div class="col-md-6">
                                <label>País</label>
                                {{ Form::select('secundario_pais_id', Pais::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12">
                            <label>Localidad</label>
                            {{ Form::select('secundario_localidad_id', Localidad::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td> Tipo de Establec.:
                        @foreach(InscripcionCarrera::$enum_tipo_establecimiento as $num => $item)
                        <label class="radio-inline">{{Form::radio('secundario_tipo_establecimiento', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-bordered" width="100%">
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">SITUACIÓN LABORAL</td>
                    <td width="65%">
                        @foreach(InscripcionCarrera::$enum_situacion_laboral as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_ocupacion as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral_ocupacion', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                    <td>Cant. de horas/semana: 
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_horas_semana as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral_horas_semana', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Relación de trabajo con la carrera: 
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_relacion_trabajo_carrera as $num => $item)
                        <label class="radio-inline">{{Form::radio('situacion_laboral_relacion_trabajo_carrera', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td><label>Rama de la actividad económica</label>
                        {{ Form::select('situacion_laboral_rama_id', RamaActividadLaboral::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                    <td> <label>Categoría Ocupacional</label>
                        {{ Form::select('situacion_laboral_categoria_ocupacional_id', CategoriaOcupacional::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><label>Detalle de la labor que realiza</label>
                        {{ Form::textarea('situacion_laboral_detalle_labor', null, ['required', 'class' => 'form-control', 'rows' => '2']) }}
                    </td>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered">
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">DATOS DEL PADRE</td>
                    <td width="65%"> <label>Apellidos y Nombres del PADRE: </label>{{ Form::text('padre_apeynom', null, ['required', 'class' => 'form-control input-sm']) }}</td>
                </tr>
                <tr>
                    <td colspan="2">¿Vive? 
                         @foreach(InscripcionCarrera::$enum_vive as $num => $item)
                        <label class="radio-inline">{{Form::radio('padre_vive', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td></tr>
                <tr>
                    <td colspan="2"><label>Estudios del PADRE</label>
                        {{ Form::select('padre_estudios_id', NivelEstudios::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                </tr>

                <tr>
                    <td>Ocupación: 
                        @foreach(InscripcionCarrera::$enum_padre_ocupacion as $num => $item)
                        <label class="radio-inline">{{Form::radio('padre_ocupacion', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                    <td>Categoría Ocupacional 
                       {{ Form::select('padre_categoria_ocupacional_id', CategoriaOcupacional::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                </tr>
                <tr>
                    <td colspan="2"> <label>Descripción de la labor que realiza</label>
                        {{ Form::textarea('padre_labor', null, ['required', 'class' => 'form-control', 'rows' => '2']) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered">
            <tbody>
                <tr>
                    <td bgcolor="#ecf0f1" style="font-weight: bold">DATOS DE LA MADRE</td>
                    <td width="65%"> <label>Apellidos y Nombres de la MADRE: </label>{{ Form::text('madre_apeynom', null, ['required', 'class' => 'form-control input-sm']) }}</td>
                </tr>
                <tr>
                    <td colspan="2">¿Vive? 
                         @foreach(InscripcionCarrera::$enum_vive as $num => $item)
                        <label class="radio-inline">{{Form::radio('madre_vive', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td></tr>
                <tr>
                    <td colspan="2"><label>Estudios de la MADRE</label>
                        {{ Form::select('madre_estudios_id', NivelEstudios::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                    </td>
                </tr>

                <tr>
                    <td>Ocupación: 
                        @foreach(InscripcionCarrera::$enum_padre_ocupacion as $num => $item)
                        <label class="radio-inline">{{Form::radio('madre_ocupacion', $num, false, ['required'])}} {{$item}}</label>
                        @endforeach
                    </td>
                    <td>Categoría Ocupacional 
                       {{ Form::select('madre_categoria_ocupacional_id', CategoriaOcupacional::select(), null, ['required', 'class' => 'form-control input-sm']) }}
                </tr>
                <tr>
                    <td colspan="2"> <label>Descripción de la labor que realiza</label>
                        {{ Form::textarea('madre_labor', null, ['required', 'class' => 'form-control', 'rows' => '2']) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br/>
        @unless(Auth::check())
        <table class="table-bordered" width="100%">
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="checkbox">
                            <label>{{Form::checkbox('reglamento', 1, false, ['required'])}} He leído y acepto el <a href="#" data-toggle="modal" data-target="#modal_reglamento">reglamento vigente</a>.</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Código de seguridad</label></td>
                    <td>{{ Form::captcha(array('required' => 'required')) }}</td>
                </tr>
            </tbody>
        </table>
        @include('inscripciones.reglamento', array('oferta' => $oferta))
        @endunless
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Completar inscripción</button>
            </div>
        </div>
    {{Form::close()}}
    </div>
</div>
@stop