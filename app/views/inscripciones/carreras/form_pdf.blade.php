@extends('layouts.layout_form')
@section('title', 'Inscripción en: '.$oferta->nombre.' - CFB')
@section('main')
<link rel="stylesheet" href="{{asset('css/form_print.css')}}" media="print">

<?php $check_lleno = '<span class="fa fa-check-square-o"></span>';
$check_vacio = '<span class="fa fa-square-o"></span>'; ?>

<style>
    td, th {padding: 2px !important;}
</style>
<div class="row">
    <div class="col-md-12">
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
                            <label>Apellidos: <span class="text-danger"><span style="font-size: 14px">*</span>(campo obligatorio)</span></label> 
                            {{ $inscripcion->apellido }}
                        </div>
                    </td>
                    <td bgcolor="#FFFFFF">
                        <div class="col-md-12">
                            <label>Nombres: <span class="text-danger">*</span></label> 
                            {{ $inscripcion->nombre }}
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <div class="col-md-12">
                            <label>Sexo: <span class="text-danger">*</span></label> 
                            @foreach(['M', 'F'] as $item)
                            <label class="radio-inline">
                                @if($inscripcion->sexo == $item)
                                {{ $check_lleno }}
                                @else
                                {{ $check_vacio }}
                                @endif
                                {{ $item }}
                            </label>
                            @endforeach
                        </div>
                    </td>
                    <td> Documento:<span class="text-danger">*</span>
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
                            <label>Número:<span class="text-danger">*</span></label> 
                            {{ $inscripcion->documento }}
                        </div>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td colspan="4">
                        <div class="col-md-12"> <label>Nacido en</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Localidad: <span class="text-danger">*</span></label> 
                                    {{ $inscripcion->laLocalidad }}
                                </div>
                                <div class="col-md-2">
                                    <label>Depto.: <span class="text-danger">*</span></label>  {{ $inscripcion->localidad_depto }}
                                </div>
                                <div class="col-md-3">
                                    <label>Pcia.: <span class="text-danger">*</span></label>  {{ $inscripcion->laPcia }}
                                </div>
                                <div class="col-md-3">
                                    <label>País: <span class="text-danger">*</span></label> 
                                    {{ $inscripcion->elPais }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <label>Fecha de Nac.: <span class="text-danger">*</span></label>
                            {{ $inscripcion->fecha_nacimiento }}
                        </div>
                    </td>
                    <td colspan="3">Nacionalidad:<span class="text-danger">*</span>
                        @foreach(Nacionalidad::all() as $item)
                        <label class="radio-inline">
                            @if($inscripcion->nacionalidad_id == $item->id)
                            {{ $check_lleno }} {{$item->descripcion}}
                            @else
                            {{ $check_vacio }} {{$item->descripcion}}
                            @endif
                        </label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Teléfono fijo: </label> {{ $inscripcion->telefono_fijo }}</div>
                    </td>
                    <td>
                        <div class="col-sm-12"><label>Teléfono Celular: <span class="text-danger">*</span></label> {{ $inscripcion->telefono_fijo }}</div>
                    </td>
                    <td>
                        <div class="col-sm-6"><label>Email: <span class="text-danger">*</span></label> {{ $inscripcion->email }}</div>
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
                        <label class="radio-inline">
                            @if($inscripcion->domicilio_procedencia_tipo == $num)
                            {{ $check_lleno }} {{$item}}
                            @else
                            {{ $check_vacio }} {{$item}}
                            @endif
                        </label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12"><label>Calle: <span class="text-danger">*</span></label> {{ $inscripcion->domicilio_procedencia_calle }}</div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-1"><label>N°: <span class="text-danger">*</span></label> {{ $inscripcion->domicilio_procedencia_nro }}</div>
                            <div class="col-sm-1"><label>Piso: </label> {{ $inscripcion->domicilio_procedencia_piso }}</div>
                            <div class="col-sm-1"><label>Depto: </label> {{ $inscripcion->domicilio_procedencia_depto }}</div>
                            <div class="col-sm-4"><label>Localidad: <span class="text-danger">*</span></label> 
                                {{ $inscripcion->laLocalidadDomicilioProcedencia }}
                            </div>
                            <div class="col-sm-2"><label>Cód. Postal: <span class="text-danger">*</span></label> {{ $inscripcion->domicilio_procedencia_cp }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-sm-3"><label>Provincia: <span class="text-danger">*</span></label> {{ $inscripcion->laPciaDomicilioProcedencia }}</div>
                            <div class="col-sm-3"><label>País: <span class="text-danger">*</span></label> 
                                {{ $inscripcion->elPaisDomicilioProcedencia }}
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
                    <td></td>
                </tr>
                <tr class="opcional">
                    <td colspan="2" style="font-weight: bold">Tipo de Residencia: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_tipo_residencia as $num => $item)
                        <label class="radio-inline">
                            @if($inscripcion->domicilio_clases_tipo == $num)
                            {{ $check_lleno }} {{$item}}
                            @else
                            {{ $check_vacio }} {{$item}}
                            @endif
                        </label>
                        @endforeach
                    </td>
                </tr>
                <tr class="opcional">
                    <td>
                        <div class="col-sm-12"><label>Calle: <span class="text-danger">*</span></label> {{ $inscripcion->domicilio_clases_calle }}</div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-1"><label>N°: <span class="text-danger">*</span></label> {{ $inscripcion->domicilio_clases_nro }}</div>
                            <div class="col-sm-1"><label>Piso: </label> {{ $inscripcion->domicilio_clases_piso }}</div>
                            <div class="col-sm-1"><label>Depto: </label> {{ $inscripcion->domicilio_clases_depto }}</div>
                            <div class="col-sm-4"><label>Localidad: <span class="text-danger">*</span></label> 
                                {{ $inscripcion->laLocalidadDomicilioClases }}
                            </div>
                            <div class="col-sm-2"><label>Cód. Postal: <span class="text-danger">*</span></label> {{ $inscripcion->domicilio_clases_cp }}</div>
                        </div>
                    </td>
                </tr>
                <tr class="opcional">
                    <td colspan="2">
                        <div class="row">
                            <div class="col-sm-3"><label>Provincia: <span class="text-danger">*</span></label> {{ $inscripcion->laPciaDomicilioClases }}</div>
                            <div class="col-sm-3"><label>País: <span class="text-danger">*</span></label> 
                                {{ $inscripcion->elPaisDomicilioClases }}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Con quién vive: &nbsp; <span class="text-danger">*</span>
                        @foreach(ConQuienVive::all() as $item)
                        <label class="radio-inline">
                            @if($inscripcion->domicilio_clases_con_quien_vive_id == $item->id)
                            {{ $check_lleno }} {{$item->descripcion}}
                            @else
                            {{ $check_vacio }} {{$item->descripcion}}
                            @endif
                        </label>
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
                            <label>Título Obtenido: <span class="text-danger">*</span></label>
                            {{ $inscripcion->secundario_titulo_obtenido }}
                        </div>
                    </td>
                    <td>
                        <div class="col-md-4">
                            <label>Año de egreso: <span class="text-danger">*</span></label>
                            {{ $inscripcion->secundario_anio_egreso }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="col-md-12">
                            <label>Nombre y Número del Colegio: <span class="text-danger">*</span></label>
                            {{ $inscripcion->secundario_nombre_colegio }}
                        </div>
                    </td>
                    <td style="font-weight: bold"> Tipo de Establec.: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_tipo_establecimiento as $num => $item)
                        <label class="radio-inline">
                            @if($inscripcion->secundario_tipo_establecimiento == $num)
                            {{ $check_lleno }} {{$item}}
                            @else
                            {{ $check_vacio }} {{$item}}
                            @endif
                        </label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <label>Localidad: <span class="text-danger">*</span></label>
                            {{ $inscripcion->laLocalidadEstablecimiento }}
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12">
                            <label>Provincia: <span class="text-danger">*</span></label>
                            {{ $inscripcion->laPciaEstablecimiento }}
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="col-md-6">
                            <label>País: <span class="text-danger">*</span></label>
                            {{ $inscripcion->elPaisEstablecimiento }}
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
                        @if($inscripcion->situacion_laboral == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td>
                </tr>
                <tr class="opcional">
                    <td style="font-weight: bold"><span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_ocupacion as $num => $item)
                        @if($inscripcion->situacion_laboral_ocupacion == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td>
                    <td style="font-weight: bold">Cant. de horas/semana: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_horas_semana as $num => $item)
                        @if($inscripcion->situacion_laboral_horas_semana == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td>
                </tr>
                <tr class="opcional">
                    <td colspan="3">Relación de trabajo con la carrera: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_situacion_laboral_relacion_trabajo_carrera as $num => $item)
                        @if($inscripcion->situacion_laboral_relacion_trabajo_carrera == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td>
                </tr>

                <tr class="opcional">
                    <td><label>Rama de la actividad económica: <span class="text-danger">*</span></label>
                        {{ $inscripcion->ramaActividad->descripcion }}
                    </td>
                    <td> <label>Categoría Ocupacional: <span class="text-danger">*</span></label>
                        {{ $inscripcion->categoriaOcupacional->categoria }}
                    </td>
                </tr>
                <tr class="opcional">
                    <td colspan="3"><label>Detalle de la labor que realiza: <span class="text-danger">*</span></label>
                        {{ $inscripcion->situacion_laboral_detalle_labor }}
                    </td>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered datos_padre">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#2980b9" style="color:#fff;"><span class="glyphicon glyphicon-list-alt"></span> DATOS DEL PADRE</td>
                    <td width="65%"> <label>Apellidos y Nombres del PADRE: <span class="text-danger">*</span></label>{{ $inscripcion->padre_apeynom }}</td>
                </tr>
                <tr>
                    <td colspan="2">¿Vive? <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_vive as $num => $item)
                        @if($inscripcion->padre_vive == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td></tr>
                <tr class="opcional depende">
                    <td colspan="2"><label>Estudios del PADRE: <span class="text-danger small">*</span></label>
                        {{ $inscripcion->padreEstudios->nivel_estudios }}
                    </td>
                </tr>

                <tr class="opcional">
                    <td style="font-weight: bold">Ocupación: <span class="text-danger">*</span> 
                        @foreach(InscripcionCarrera::$enum_padre_ocupacion as $num => $item)
                        @if($inscripcion->padre_ocupacion == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td>
                    <td>Categoría Ocupacional: 
                        {{ $inscripcion->padreCategoriaOcupacional->categoria }}</td>
                </tr>
                <tr class="opcional">
                    <td colspan="2"> <label>Descripción de la labor que realiza: <span class="text-danger">*</span></label>
                        {{ $inscripcion->padre_labor }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="100%" class="table-bordered datos_madre">
            <tbody bgcolor="#FFFFFF">
                <tr>
                    <td height="60px" bgcolor="#e74c3c" style="color:#fff;"><span class="glyphicon glyphicon-list-alt"></span> DATOS DE LA MADRE</td>
                    <td width="65%"> <label>Apellidos y Nombres de la MADRE: <span class="text-danger">*</span> </label>{{ $inscripcion->madre_apeynom }}</td>
                </tr>
                <tr>
                    <td colspan="2">¿Vive?: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_vive as $num => $item)
                        @if($inscripcion->madre_vive == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td></tr>
                <tr class="opcional depende">
                    <td colspan="2"><label>Estudios de la MADRE: <span class="text-danger">*</span></label>
                        {{ $inscripcion->madreEstudios->nivel_estudios }}
                    </td>
                </tr>

                <tr class="opcional">
                    <td style="font-weight: bold">Ocupación: <span class="text-danger">*</span>
                        @foreach(InscripcionCarrera::$enum_padre_ocupacion as $num => $item)
                        @if($inscripcion->madre_ocupacion == $num)
                        {{ $check_lleno }} {{$item}}
                        @else
                        {{ $check_vacio }} {{$item}}
                        @endif
                        @endforeach
                    </td>
                    <td style="font-weight: bold">Categoría Ocupacional: <span class="text-danger">*</span>
                        {{ $inscripcion->madreCategoriaOcupacional->categoria }}
                </tr>
                <tr class="opcional">
                    <td colspan="2"> <label>Detalle de la labor que realiza: <span class="text-danger">*</span></label>
                        {{ $inscripcion->madre_labor }}
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-bordered">
            <tbody bgcolor="#fff">
                <tr>
                    <td>
                        <p class="pull-left">Rawson, Chubut ....../....../......</p>
                        <p class="pull-right" >Firma ingresante................................................................</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><img src="{{asset('img/tijera.png')}}" alt="" width="14"/>&#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211;&#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211; &#8211;</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table align="left" cellpadding="5" cellspacing="10" class="table table-bordered" style="width:100%;">
            <tbody bgcolor="#fff">
                <tr>
                    <td bgcolor="#ecf0f1"><span style="font-weight: bold">RECIBO DE INSCRIPCIÓN</span> (para el ingresante)</td><td> AÑO: {{ $oferta->anio }} </td><td colspan="2">Carrera: {{ $oferta->nombre }} </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="5" cellspacing="5" class="table table-bordered" style="width:100%;">
            <tbody bgcolor="#fff">
                <tr style="vertical-align: top;">
                    <td>Apellido/s: {{ $inscripcion->apellido }}</td>
                    <td colspan="2">Nombre/s: {{ $inscripcion->nombre }}</td>
                    <td rowspan="2"> Fecha y firma Depto. Alumnos</td>
                </tr>
                <tr>
                    <td><p>SEXO  @foreach(['M', 'F'] as $item)
                            <label class="radio-inline">
                                @if($inscripcion->sexo == $item)
                                {{ $check_lleno }}
                                @else
                                {{ $check_vacio }}
                                @endif
                                {{ $item }}
                                @endforeach
                            </p>
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
                        
                        <p>Número: {{ $inscripcion->documento }}</p>
                    </td>
                </tr>
                <tr style="text-align: center; background-color: #ecf0f1; color: #FFFFFF"><td colspan="8"><img src="{{asset('img/LOGO-200x60px.png')}}" width="100" height="31" alt=""/> </td>
                </tr>
            </tbody>
        </table>
        <div class="row col-md-offset-4 form-actions">
            <a href="{{ route('ofertas.inscripciones.index', [$oferta->id,  $inscripcion->id]) }}" class="btn btn-lg btn-info"><span class="glyphicon glyphicon-chevron-left"></span> Volver </a>
            <button type="button" onclick="window.print();" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-print"></span> Imprimir formulario</button>
        </div> 
    </div>
</div>
@stop