@extends('layouts.scaffold')
@section('title', 'Importar Oferta de CSV - Universidad del Chubut')
@section('main')

<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    background: red;
    cursor: inherit;
    display: block;
}

input[readonly] {
    background-color: white !important;
    cursor: text !important;
}
</style>

<div class="container">
    <div align="center" class="row">
        <h1 style="background-color: black;border: solid 2px white; color: white;padding: 10px;border-radius: 5px;">Importar una Oferta/Evento de archivo CSV</h1>
    </div>
    @if($MjeError)
    <div class="alert alert-danger">
        {{$MjeError}}
    </div>
    @endif
    <div class="row">
        <div class="btn-group">
            <a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
            <a href="{{ route('ofertas.index') }}" class="btn btn-info" title="Ver todas las Ofertas"><i class="glyphicon glyphicon-list"></i> Todas las ofertas</a>
            <a href="{{action('OfertasController@importarOfertaDeArchivo')}}" class="btn btn-primary" title="Importar Nueva Oferta desde Archivo CSV"><i class="glyphicon glyphicon-plus-sign"></i> Importar Nueva Oferta de Archivo</a>
        </div>
        @if (!$post)
        <div class="well" style="margin-top: 20px">
            <p>Por medio del siguiente formulario, se cargan desde un archivo los datos de una nueva 
                Oferta (Curso/Evento) al Sistema de Inscripciones de la Universidad del Chubut.</p>
            <p>
                Se debe tener en cuenta que el sistema de importación está preparado para leer 
                los archivos de Excel con cierta cantidad de columnas. 
            </p>
            <p> 
                Se puede descargar el archivo de ejemplo, que trae la forma correcta que debe estar la
                información de la Oferta: <a href="{{public_path()}}/public/img/oferta.xlsx"><i class="fa fa-file-excel-o fa-3"></i> Archivo de ejemplo.</a>
            </p>
        </div>
        <div class="alert alert-info" style='margin-top: 20px'>
            {{ Form::open(array(
                    'method' => 'POST',
                    'enctype'=> 'multipart/form-data',
                    'class'  => 'form-horizontal',
                    'action' => array('OfertasController@importarOfertaDeArchivo'))) }}
            <div class="form-group">
                <div class="col-lg-5 col-sm-8">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                                Cargar <input type="file" id="archivo" name="archivo" onchange="validarNombreDeArchivo('archivo')">
                            </span>
                        </span>
                        <input type="text" class="form-control" id="inputNombreArchivo" readonly  placeholder="Clic en Cargar para buscar el archivo">
                    </div>
                    <!--<span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual (el nombre del archivo no debe contener espacios).</span>-->
                </div>
            </div>
            <div class="btn-group">
                {{ Form::submit('Importar Archivo', array('id' => 'btnSubmit' , 'class' => 'btn btn-success', 'title'=>'Importar Archivo CSV', 'disabled' => 'disabled')) }}
                {{ Form::reset('Descartar cambios', array('class' => 'form-button btn btn-warning', 'onclick' => "bloquearSubmit('btnSubmit')"))}}
                {{ Form::close() }}
            </div>
        </div>
        @else        
            @if($datos != null)
                <div class="alert-success"><h3>Los datos leidos desde el archivo son:</h3></div><br>
                <div class="row">
                    {{ Form::open(array(
                            'method' => 'POST',
                            'enctype'=> 'multipart/form-data',
                            'class'  => 'form-horizontal',
                            //'action' => array('OfertasController@agregarOferta')
                            'action' => array('OfertasController@store')
                            )
                        ) }}
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="titulacion_id" value="1">
                        
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nombre"> Nombre</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{$datos[0]}}" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="anio"> Año</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="anio" id="anio" value="{{$datos[1]}}" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="inicio"> Fecha Inicio inscripciones</label>
                            <div class="col-sm-4">
                                <input type="datetime" class="form-control" name="inicio" id="inicio" value="{{$datos[2]->format('d/m/Y')}}" readonly>
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="fin"> Fecha Fin inscripciones</label>
                            <div class="col-sm-4">
                                <input type="datetime" class="form-control" name="fin" id="fin" value="<?php echo $datos[3]->format('d/m/Y')?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="tipo_oferta"> Tipo de Oferta</label>
                            <div class="col-sm-4">
                                <label class="radio-inline"><input type="radio" name="tipo_oferta" value="2" required> Oferta/Curso</label>
                                <label class="radio-inline"><input type="radio" name="tipo_oferta" value="3" required> Evento</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="fecha_fin_oferta"> Fecha Fin de Oferta</label>
                            <div class="col-sm-4">
                                <input type="datetime" class="form-control" name="fecha_fin_oferta" id="fecha_fin_oferta" value="{{$datos[4]->format('d/m/Y')}}" readonly>
                            </div>
                        </div>
                    <div class="btn-group" style="padding-left: 25%">
                        @if($MjeError)
                            {{ Form::submit('Crear oferta', array('class' => 'btn btn-success', 'title'=>'Crear Oferta', 'disabled' => 'disabled')) }}
                        @else
                            {{ Form::submit('Crear oferta', array('class' => 'btn btn-success', 'title'=>'Crear Oferta')) }}
                        @endif
                        <!--<a href="{{action('OfertasController@importarOfertaDeArchivo')}}" class="btn btn-primary" title="Importar Nueva Oferta desde Archivo CSV"><i class="glyphicon glyphicon-plus-sign"></i> Importar Nueva Oferta de Archivo</a>-->
                        {{ Form::close() }}
                    </div>
                </div>
            @else
                <div class="alert alert-danger" style="margin-top: 20px">
                    <h3><i class="glyphicon glyphicon-exclamation-sign"></i> Error en la importación del archivo!</h3>
                </div>
            @endif
        @endif
    </div>
</div>

<script>
    function bloquearSubmit(campoId){
        document.getElementById(campoId).disabled = true;
        
    }
    
    function validarNombreDeArchivo(campoId){
        pathFile = document.getElementById(campoId).value;
        nameFileConEspacios = pathFile.match(/[^\/\\]+\.(?:xls|xlsx|csv)$/i);
        nameOriginalFile = pathFile.match(/[^\/\\]+\.(?:xls|xlsx|csv)$/i);
        nameFileConEspacios = nameFileConEspacios.toString().replace(/\.xls$|\.xlsx$|\.csv$/i,"");
        
        if( (/['']|\s/i).test(nameFileConEspacios)){
            alert('El nombre del archivo no debe contener espacios!!');
            document.getElementById('inputNombreArchivo').value = null;
            document.getElementById(campoId).value = null;
            return document.getElementById(campoId).focus();
        }else{
            document.getElementById('inputNombreArchivo').value = nameOriginalFile;
            document.getElementById('btnSubmit').disabled = false;
        }
        /*nameFileSinEspacios = reemplazar(nameFileConEspacios,' ','-');
        pathFileOk = reemplazar(pathFile,nameFileConEspacios,nameFileSinEspacios);
        alert('Nombre archivo: '+ pathFileOk);*/
        return true;
    }
</script>