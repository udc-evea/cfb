@extends('layouts.scaffold')
@section('title', 'Importar Alumnos - Universidad del Chubut')
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
        <h1 style="background-color: black;border: solid 2px white; color: white;padding: 10px;border-radius: 5px;">Importar Alumnos a {{$oferta->nombre}}</h1>
    </div>
    @if($MjeError)
    <div class="alert alert-danger">
        {{$MjeError}}
    </div>
    @endif
        <div class="btn-group">
            <a href="{{action('HomeController@bienvenido')}}" class="btn btn-warning" title="Volver al Inicio"><i class="glyphicon glyphicon-chevron-left"></i> Regresar al Inicio</a>
            <a href="{{ route('ofertas.index') }}" class="btn btn-info" title="Ver todas las Ofertas"><i class="glyphicon glyphicon-list"></i> Todas las ofertas</a>
            <a href="{{URL::route('ofertas.inscripciones.importarAlumnosDeArchivo',$oferta->id)}}" class="btn btn-primary" title="Importar alumnos de Archivo"><i class="glyphicon glyphicon-plus-sign"></i> Importar Alumnos de Archivo</a>
        </div>            
        @if (!$post)
        <div class="well" style="margin-top: 20px">
            <p>Por medio del siguiente formulario, se cargan desde un archivo los alumnos que ya 
                completaron su inscripción desde un <b>sistema externo</b> al Sistema de Inscripciones
                de la Universidad del Chubut.</p>
            <p>
                Se debe tener en cuenta que el sistema de importación está preparado para leer 
                los archivos de Excel con cierta cantidad de columnas. 
            </p>
            <p> 
                Se puede descargar el archivo de ejemplo, que trae la forma correcta que debe estar la
                información de los alumnos: <a href="{{ URL::asset('img/alumnos.xlsx') }}"><i class="fa fa-file-excel-o fa-3"></i> Archivo de ejemplo.</a>
            </p>
            <p> 
                <b>Nota:</b> Para la correcta lectura del archivo, los campos "Tipo DNI" y "Localidad" deben contener
                uno de los códigos que se especifican en los siguientes archivos:
                <li><a href="{{ URL::asset('img/tipo_DNI.xlsx') }}"><i class="fa fa-file-excel-o fa-3"></i> Tipo DNI correcto.</a></li>
                <li><a href="{{ URL::asset('img/localidades.xlsx') }}"><i class="fa fa-file-excel-o fa-3"></i> Localidades correctas.</a></li>
            </p>
        </div>
        <div class="alert alert-info" style='margin-top: 20px'>
            {{ Form::open(array(
                    'method' => 'POST',
                    'enctype'=> 'multipart/form-data',
                    'class'  => 'form-horizontal',
                    'action' => array('OfertasInscripcionesController@importarAlumnosDeArchivo', $oferta->id))) }}
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
                </div>
            </div>
            <div class="btn-group">
                {{ Form::submit('Importar Archivo', array('id' => 'btnSubmit' , 'class' => 'btn btn-success', 'title'=>'Importar Archivo', 'disabled' => 'disabled')) }}
                {{ Form::reset('Descartar cambios', array('class' => 'form-button btn btn-warning', 'onclick' => "bloquearSubmit('btnSubmit')"))}}
                {{ Form::close() }}
            </div>
        </div>
        @else
            @if($datos != null)
                {{ Form::open(array(
                                'method' => 'POST',
                                'enctype'=> 'multipart/form-data',
                                'class'  => 'form-horizontal',
                                'action' => array('OfertasInscripcionesController@guardarAlumnosImportados',$oferta->id)
                                )
                ) }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="row responsive">
                        <div class="row alert-info" style="margin: 5px; border-radius: 5px">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="estado_inscripcion"> Elegir el Estado de los inscriptos a la Oferta</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline"><input type="radio" name="estado_inscripcion" value="0" required> PreInscriptos</label>
                                    <label class="radio-inline"><input type="radio" name="estado_inscripcion" value="1" required> Inscriptos</label>
                                    <label class="radio-inline"><input type="radio" name="estado_inscripcion" value="2" required> Asistentes</label>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered table-striped table-condensed">
                            <thead style="background-color: gray; color: white">
                                <tr>
                                    <th>Nro.</th>
                                    <th>Tipo de Documento</th>
                                    <th>Documento</th>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Localidad</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1 ?>
                                <?php $stringValues = ""; ?>
                                @foreach($datos as $fila)
                                <?php $stringValues .= $fila['tipo_documento'].",".$fila['documento'].",".$fila['apellido'].",".$fila['nombre'].",".$fila['fecha_de_nacimiento'].",".$fila['localidad_id'].",".$fila['email'].";"; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <?php $tipoDocID = $fila['tipo_documento'];
                                    $arrayTipoDocs = array('1','2','3','4');
                                    if(in_array($tipoDocID,$arrayTipoDocs)):?>
                                        <td> <?php echo $tipoDocumento[$tipoDocID-1]->descripcion; ?></td>
                                    <?php else:?>
                                        <td style="color: red"> Verificar valor ({{$tipoDocID}})</td>
                                    <?php endif;?>
                                    <td <?php if(!$fila['documento']){ echo 'style="background-color: red"';}?>><?php echo $fila['documento']; ?></td>
                                    <td <?php if(!$fila['apellido']){ echo 'style="background-color: red"';}?>><?php echo $fila['apellido']; ?></td>
                                    <td <?php if(!$fila['nombre']){ echo 'style="background-color: red"';}?>><?php echo $fila['nombre']; ?></td>
                                    <td><?php echo $fila['fecha_de_nacimiento']->format('d/m/Y'); ?></td>
                                    <?php $localidadID = $fila['localidad_id'];
                                        $existeLocalidad = false;
                                        foreach ($localidad as $loc){
                                            if($localidadID == $loc->id){
                                               $locDescripcion = $loc->localidad;
                                               $existeLocalidad = true;
                                            }
                                        }
                                        if($existeLocalidad):?>
                                            <td><?php echo $locDescripcion; ?></td>
                                        <?php else:?>
                                            <td style="color: red"> Verificar valor ({{$localidadID}})</td>
                                        <?php endif;?>
                                    <td <?php if(!$fila['email']){ echo 'style="background-color: red"';}?>><?php echo $fila['email']; ?></td>
                                </tr>
                                <?php $i++ ?>
                                @endforeach                            
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="stringValue" value="<?php echo $stringValues ?>">
                @if($MjeError)
                {{ Form::submit('Importar alumnos', array('class' => 'btn btn-success', 'title'=>'Importar alumnos a la carrera', 'disabled' => 'disabled')) }}
                @else
                {{ Form::submit('Importar alumnos', array('class' => 'btn btn-success', 'title'=>'Importar alumnos a la carrera')) }}
                @endif
                {{ Form::close() }}
                <?php //echo "<br>$stringValues</br>"?>
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