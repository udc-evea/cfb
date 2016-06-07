@extends('layouts.scaffold')
@section('title', 'Sistema de Verificación de Certificados - Universidad del Chubut')
@section('main')

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Verificación de Certificados</title>
    </head>
    <body>
        <a href="http://udc.edu.ar" title="Portal Universidad del Chubut" target="_target"><img src="{{ asset('img/LOGO-horizontal-MQ-RGB-150dpi.png') }}" width="250"/></a>
        <br><br>        
        @if ($errors->any())
        <div class="alert alert-danger" align="center">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <p>Revise los datos ingresados!</p>
        </div>
        @endif
        <h2>Verificación de Certificados</h2>
        <p>El Sistema de Validación de Certificados (SVC) permite la verificación de autenticidad de los certificados 
            emitidos por la <strong>Universidad del Chubut</strong>.</p>
        <p>El SVC permite corroborar la veracidad de la información brindada por una persona respecto a su 
            certificación académica. Dicho SVC puede ser utilizado tanto por el alumno en cuestión, como por 
            un tercero que manifieste la necesidad de validar el historial académico de una persona.</p>
        <p>Todos los certificados emitidos poseen un Código Único de Validación (CUV).</p>
        <p>Al ingresar el CUV en el SVC te indica: Nombre, Apellido y DNI del alumno, además de la información 
            académica asociada a ese certificado: Curso, Fecha de Aprobación y Horas reloj.</p>
        <br>
        @if(!$encontrado)
        <p><strong>Para validar un certificado, debés ingresar el código único de Verificación (CUV) en el 
                siguiente cuadro y luego pulsá el botón "Verificar código".</strong></p>
        <div id="formVerificacionCodigo">
            <div class="alert alert-info">
                {{ Form::open(array('action'=>'HomeController@verificarCertificado')) }}
                <fieldset>
                    <!--<div id="legend">
                        <legend class="">Probar Oferta con: K6XD-YBJJ-RCJC-3P5I</legend>
                        <legend class="">Probar Evento con: ZZJQ-7WJ9-J0PP-MVK5</legend>
                        <legend class="">Probar Capacitador con: NZO8-RNM4-LWMA-XOYK</legend>
                    </div>-->
                    <div class="row">
                        <div class="col-xs-1" style="margin-left: 33%">
                          {{Form::text('codigovalidacion1', null,array('class' => 'form-control','id'=>'codigovalidacion1','title'=>'CUV: primeros 4 caracteres.','placeholder'=>'XXXX','style'=>'text-transform:uppercase','onkeyup'=>'javascript:this.value=this.value.toUpperCase()','maxlength'=>4,'required'=>'required','pattern'=>'.{4,}'))}}
                        </div>
                        <div class="col-xs-1">
                          {{Form::text('codigovalidacion2', null,array('class' => 'form-control','id'=>'codigovalidacion2','title'=>'CUV: segundos 4 caracteres.','placeholder'=>'XXXX','style'=>'text-transform:uppercase','onkeyup'=>'javascript:this.value=this.value.toUpperCase()', 'maxlength'=>4,'required'=>'required','pattern'=>'.{4,}'))}}
                        </div>
                        <div class="col-xs-1">
                          {{Form::text('codigovalidacion3', null,array('class' => 'form-control','id'=>'codigovalidacion3','title'=>'CUV: terceros 4 caracteres.','placeholder'=>'XXXX','style'=>'text-transform:uppercase','onkeyup'=>'javascript:this.value=this.value.toUpperCase()', 'maxlength'=>4,'required'=>'required','pattern'=>'.{4,}'))}}
                        </div>
                        <div class="col-xs-1">
                          {{Form::text('codigovalidacion4', null,array('class' => 'form-control','id'=>'codigovalidacion4','title'=>'CUV: últimos 4 caracteres.','placeholder'=>'XXXX','style'=>'text-transform:uppercase','onkeyup'=>'javascript:this.value=this.value.toUpperCase()', 'maxlength'=>4,'required'=>'required','pattern'=>'.{4,}'))}}
                        </div>
                    </div>
                    <!--<div class="input-group" style="padding-top: 30px;">
                        <span class="input-group-addon" id="codigovalidacion1">                        
                            <span class="glyphicon glyphicon-qrcode"></span>
                        </span>                        
                        {{Form::text('codigovalidacion1', null,array('class' => 'form-control','aria-describedby'=>'codigovalidacion1','title'=>'CUV primeros 4 caracteres.','tabindex'=>1))}}
                    </div> -->
                    <br>
                    <div align="center">
                        {{Form::submit('Verificar código', array('class' => 'btn btn-primary','title'=>'Verificar código de certificación'))}}
                    </div>
                    {{ Form::close() }}
                </fieldset>
            </div>
        </div>
        @endif
        @if($message != null)
                {{ $message }}
            @endif
        @if($oferta[0] != null)
            <div id='certifOK' class='alert alert-success'>            
                <!--<div id='imgCertifOK'>
                    <img src="{{ asset('img/usuario_encontrado.png') }}" width="200"/>
                </div>-->
                <div id='datosCertifOK'>
                    @if($oferta[0] != null)
                        <span><b>{{ $tipoOferta }}: </b></span>
                        <ul>
                            <li>Nombre: {{ $oferta[0]->nombre }}</li>
                            <li>Finalización: {{ $oferta[0]->fecha_fin_oferta }}</li>
                            <li>Duración (en horas): {{ $oferta[0]->duracion_hs }}</li>
                            <li>Resolución interna: {{ $oferta[0]->resolucion_nro }}</li>
                        </ul>                    
                    @endif
                    @if($personal[0] != null)
                        <span><b>Datos Personales: </b></span>
                        <ul>
                            <li>Apellido y Nombre: {{ $personal[0]->apellido }}, {{ $personal[0]->nombre }}</li>
                            <li>D.N.I.: {{ $personal[0]->dni }}</li>
                            @if($rol[0] != null)
                                <li>Participo como: {{ $rol[0]->rol }}</li>
                            @endif
                        </ul>
                    @endif
                    @if($inscripto[0] != null)
                        <span><b>Datos Personales: </b></span>
                        <ul>
                            <li>Apellido y Nombre: {{ $inscripto[0]->apellido }}, {{ $inscripto[0]->nombre }}</li>
                            <li>D.N.I.: {{ $inscripto[0]->documento }}</li>
                            <li>E-mail: {{ $inscripto[0]->email }}</li>
                        </ul>
                    @endif
                </div>                
                <div id='btnVerificarDeNuevo'>
                    <a href="{{action('HomeController@verificarCertificado')}}" class="btn btn-info" title="Verificar un nuevo código"><i class="glyphicon glyphicon-qrcode"></i> Verificar un nuevo código</a>
                </div>
            </div>
        @endif
    </body>
    <script type="text/javascript">
        
    </script>
</html>
@stop
