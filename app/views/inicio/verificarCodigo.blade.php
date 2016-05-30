@extends('layouts.scaffold')

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
        <p>Al ingresar el CUV en el SVC le indica: Nombre, Apellido y DNI del alumno, además de la información 
            académica asociada a ese certificado: Curso, Fecha de Aprobación y Horas reloj.</p>
        <br>
        <p><strong>Para validar un certificado, debe ingresar el código único de Verificación (CUV) en el 
                siguiente cuadro y luego pulsar el botón "Verificar código".</strong></p>
        <div id="formVerificacionCodigo" style="display: inline-block">
            <div class="col-lg-6 alert alert-info" style="margin-left: 30%; padding: 20px;">
                {{ Form::open(array('action' => 'HomeController@verificarCertificado')); }}
                <fieldset>
                    <!--<div id="legend">
                        <legend class="">Verificar código <a href="localhost:8080/cfb/public/verificar-certificado?cuv=1234-1224-1234-1234">CUV</a></legend>
                    </div> -->
                    <div class="input-group" style="padding-top: 30px;">
                        <span class="input-group-addon" id="codigovalidacion">                        
                            <span class="glyphicon glyphicon-qrcode"></span>
                        </span>
                        {{Form::text('codigovalidacion', null,array('class' => 'form-control','aria-describedby'=>'codigovalidacion','placeholder'=>'ingrese el código de validación (con guiones inclusive)','title'=>'Ingrese el Código de Verificación','tabindex'=>1))}}
                    </div>                
                    <br>
                    <div align="center">
                        {{Form::submit('Verificar código', array('class' => 'btn btn-primary','title'=>'Verificar código de certificación'))}}
                    </div>
                    {{ Form::close() }}
                </fieldset>
            </div>
        </div>
        <div id="formVerificacionCodigo" style="display: inline-block">
            {{ $mje }} - {{ $cuv }} - <?php echo strlen($cuv) ?>
        </div>
    </body>
</html>
@stop
