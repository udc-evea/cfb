<?php $method = $obj ? 'PATCH' : 'POST'; ?>
<?php $route_name = $obj ? 'ofertas.update' : 'ofertas.store'; ?>
<?php $route_params = $obj ? array('id' => $obj->id) : array(); ?>
<style>
#mail_bienvenida { width:0px; height:0px; }    
    
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


{{Former::framework('TwitterBootstrap3')}}
{{ Former::horizontal_open_for_files()
        ->secure()
        ->rules(['nombre' => 'required'])
        ->method($method)
        ->route($route_name, $route_params)
        ->id('formOferta');
}}
{{ Former::populate($obj) }}
<fieldset>
    <div class="form-group required">
        <label class="control-label col-lg-2 col-sm-4">Tipo de Oferta</label>
        <div class="col-lg-10 col-sm-8">
            <div class="btn-group" data-toggle="buttons">
            @foreach($tipos_oferta as $item)
                <label class="btn btn-default @if($obj && $item->id == $obj->tipo_oferta) active @endif">
                    <i class="fa {{ $item->icono }}"></i> 
                    <input type="radio" onchange='ocultarCamposEnCarrera()' required @if($obj && $item->id == $obj->tipo_oferta) checked="checked" @endif name="tipo_oferta" value="{{$item->id}}" id="tipo_oferta_{{$item->id}}"> {{ $item->descripcion }}
                </label>
            @endforeach
            </div>
        </div>
    </div>
    <hr>
    {{ Former::text('nombre')
                ->required()
                ->onGroupAddClass('form-group-lg') 
                ->placeholder('Ingrese el nombre de la Oferta (Sin números)')
    }}    
    <hr>
    {{ Former::number('anio')
                ->required()
                ->value(date("Y"))
                ->help('Año en que se dicta la oferta formativa') }}
    

<!-- <input type="hidden" name="permite_inscripciones" value="0"/>
{{ Former::checkbox('permite_inscripciones')
	->addClass('checkbox')
        ->help('Habilita las inscripciones a esta oferta')
        ->style('visibility: visible; margin-left: 3px')
     }}    -->
<hr>
{{ Former::text('inicio')
            ->label('Fecha inicio para las Incripciones')
            ->addClass('fecha')
            ->placeholder('Colocar la fecha de INICIO de las inscripciones para esta Oferta.')
            ->required();
}}
<hr>
{{ Former::text('fin')
            ->label('Fecha fin para las Inscripciones')
            ->addClass('fecha')
            ->placeholder('Colocar la fecha de FIN de las inscripciones para esta Oferta.')
            ->required();
}}
<hr>
{{ Former::number('cupo_maximo')
            ->label('Cupo máximo')
            ->placeholder('0 o vacío: sin cupo.') 
}}
<hr>
{{ Former::textarea('terminos')
            ->label('Reglamento')
            ->rows(8)
            ->placeholder('Ingrese el texto que se mostrará como REGLAMENTO en la inscripción.')
            ->required();
}}
<hr>
    <div class="form-group">
        <label for="mail_bienvenida_file_name" class="control-label col-lg-2 col-sm-4">Imágen confirmación e-mail:</label>
        <div class="col-lg-5 col-sm-8">
            <?php if($newForm): ?>
                <input class="form-control" id="mail_bienvenida_file_name" type="text" name="mail_bienvenida_file_name" placeholder="Sin Imágen">
            <?php else: ?>
                <input class="form-control" id="mail_bienvenida_file_name" type="text" name="mail_bienvenida_file_name" value="<?php echo $oferta->mail_bienvenida_file_name?>">
            <?php endif;?>
            <span class="help-block">(*) Para dejar sin imágen el mail sólo debe borrar el texto de arriba.</span>
        </div>
        <div class="col-lg-5 col-sm-8">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Cargar <input type="file" id="mail_bienvenida" name="mail_bienvenida" onchange="validarNombreDeArchivo('mail_bienvenida')">
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual (el nombre del archivo no debe contener espacios).</span>
        </div>
    </div>
    <!-- {{ Former::text('mail_bienvenida_file_name')->label('Archivo de imágen seleccionado:') }} 
    {{ Former::file('mail_bienvenida')->label('Mail de bienvenida')->help('Vacío: envía un mail genérico.') }} -->
<hr>    
<!-- Agrego el campo nuevo: url_imagen_mail -->
<input type="hidden" name="url_imagen_mail"/>
{{ Former::text('url_imagen_mail')
            ->label('URL de la imagen')
            ->rows(3)
            ->placeholder('URL a la que apuntara la imagen.') }}
<hr>


<!-- Agrego los campos nuevos: presentar_mas_doc y doc_a_presentar -->
<div class="row-fluid">
    <div class="form-group">
        <label for="presentar_mas_doc" class="control-label col-lg-2 col-sm-4">
            Requisitos y Documentación Extra</label>
        <?php if(!$newForm): ?>
            <div class="col-lg-10 col-sm-8">        
                @if($oferta->presentar_mas_doc == 1)
                    <input class="checkbox" style="visibility: visible; margin-left: 3px" onclick="mostrar_ocultar('DivDocAPresentar','presentar_mas_doc')" id="presentar_mas_doc" type="checkbox" checked name="presentar_mas_doc" value="1">
                @else
                    <input class="checkbox" style="visibility: visible; margin-left: 3px" onclick="mostrar_ocultar('DivDocAPresentar','presentar_mas_doc')" id="presentar_mas_doc" type="checkbox" name="presentar_mas_doc" value="0">
                @endif
                <span class="help-block">Chequear si es que para esta Oferta el inscripto debe completar requisitos y/o presentar documentación extra a la solicitada en el formulario de inscripción.</span>
            </div>
        <?php else: ?>
            <div class="col-lg-10 col-sm-8">                        
                <input class="checkbox" style="visibility: visible; margin-left: 3px" onclick="mostrar_ocultar('DivDocAPresentar','presentar_mas_doc')" id="presentar_mas_doc" type="checkbox" name="presentar_mas_doc" value="0">                
                <span class="help-block">Chequear si es que para esta Oferta el inscripto debe completar requisitos y/o presentar documentación extra a la solicitada en el formulario de inscripción.</span>
            </div>
        <?php endif; ?>
    </div>    
    <!--{{ Former::checkbox('presentar_mas_doc')
            ->label('Requisitos y Documentación Extra')
            ->addClass('checkbox')
            ->placeholder('Chequear si es que para esta Oferta el inscripto debe completar requisitos y/o presentar documentación extra a la solicitada en el formulario de inscripción.') 
            ->style('visibility: visible; margin-left: 3px')
            ->onclick("mostrar_ocultar('DivDocAPresentar','presentar_mas_doc')")
    }}-->
    <div id='DivDocAPresentar'>
        {{ Former::textarea('doc_a_presentar')
                ->label('Documentación Extra')
                ->rows(8)
                ->style('background-color: #EFFBFB;');
        }}
        <?php                    
            if(!$newForm){
                $docs = explode('|',$oferta->doc_a_presentar);
                $i=0;
                if($oferta->doc_a_presentar == null){
                    $oferta->doc_a_presentar = "||||";
                }
            }

        ?>

        <!-- #################################################################### -->
        <div>
        <?php if(!$newForm): ?>
            <!-- Muestro el formulario para Editar los capacitadores de esta oferta -->
            <!-- Modal del Form para editar los Capacitadores a una Oferta -->
            <!-- Muestro el modal con un button -->
            <button type="button" style="margin-left: 162px" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEditDocAPresentar<?php echo $oferta->id ?>"><i class='glyphicon glyphicon-pencil'></i> Editar Documentación Requerida</button>
            <!-- Modal -->
            <div id="modalEditDocAPresentar<?php echo $oferta->id ?>" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content -->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar la documentacion extra a presentar para <b>{{ $oferta->nombre }}</b></h4>
                  </div>
                  <div class="modal-body">
                        <?php foreach($docs as $doc): ?>
                                <?php if($i==0):?>
                                    Cabecera de la documentación: <input type='text' name='cabeceraDocAPresentar' id='cabeceraDocAPresentar' value='<?php echo $doc ?>'><br>
                                    <ul>
                                <?php else:?>
                                    <?php if($doc != null):?>
                                        <?php echo "$i) Doc. a presentar: " ?><input type='text' id='<?php echo $i ?>DocAPresentar' name='<?php echo $i ?>DocAPresentar' value='<?php echo $doc ?>'><br>
                                    <?php else:?>
                                        <?php echo "$i) Doc. a presentar: " ?><input type='text' id='<?php echo $i ?>DocAPresentar' name='<?php echo $i ?>DocAPresentar' value=''><br>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php $i++;?>
                        <?php endforeach;?>
                        </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="completarDocAPresentar()">Cerrar</button>
                  </div>
                </div>

              </div>
            </div>
        <?php else: ?>
            <!-- Muestro el formulario para Agregar los capacitadores de esta oferta -->                                                    
            <!-- Modal del Form para agregar Capacitadores a una Oferta -->            
            <!-- Muestro el modal con un button -->
            <button type="button" style="margin-left: 162px" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalNewDocAPresentar"><i class='glyphicon glyphicon-plus-sign'></i> Agregar Documentación Requerida</button>
            <!-- Modal -->
            <div id="modalNewDocAPresentar" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content -->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Documentacion extra que debe presentar el inscripto!</h4>
                  </div>
                  <div class="modal-body">
                      Ingrese la Cabecera de la documentación: <input type="text" name="cabeceraDocAPresentar" id="cabeceraDocAPresentar"><br>
                      1) Doc. a presentar: <input type="text" id="1DocAPresentar" name="1DocAPresentar"><br>
                      2) Doc. a presentar: <input type="text" id="2DocAPresentar" name="2DocAPresentar"><br>
                      3) Doc. a presentar: <input type="text" id="3DocAPresentar" name="3DocAPresentar"><br>
                      4) Doc. a presentar: <input type="text" id="4DocAPresentar" name="4DocAPresentar"><br>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" onclick="completarDocAPresentar()">Cerrar</button>
                  </div>
                </div>

              </div>
            </div>
        </div>
        <!-- #################################################################### -->
        <?php endif; ?>

    </div>
</div>
<hr>
<div id='ocultosDeCarrera'>
    <!-- Agrego los campos nuevos para la certificacion: resolucion_nro, lugar, duracion, lleva_tit_previa y titulacion_id -->    
    {{ Former::text('resolucion_nro')
            ->label('Resolución/Expediente Nro.')
            ->help('Ingrese el Nro. de Resolución/Expediente dispuesta por la UDC.')
            ->placeholder('Ej.: Res./Expte. UDC-000/2016');            
    }}
    <hr>
    {{ Former::text('fecha_inicio_oferta')
                ->label('Fecha de inicio de la Oferta')
                ->addClass('fecha')
                ->placeholder('Colocar la fecha de inicio de la Oferta.');                
    }}
    <hr>
    {{ Former::text('fecha_fin_oferta')
                ->label('Fecha de finalización de la Oferta')
                ->addClass('fecha')
                ->placeholder('Colocar la fecha de finalización de la Oferta.');                
    }}
    <hr>
    {{ Former::text('fecha_expedicion_cert')
                ->label('Fecha de expedicion de los Certificados')
                ->addClass('fecha')
                ->placeholder('Colocar la fecha de expedición de los certificados.')
                ->required();
    }}
    <hr>
    {{ Former::text('lugar')
                ->label('Lugar de encuentro') 
                ->help('Especificar el lugar de encuentro dónde se llevará a cabo la Oferta.');
    }}
    <hr>
    {{ Former::number('duracion_hs')
                ->label('Duración de la Oferta (en HS.)')
                ->help('Ingrese la cantidad de horas reloj dispuesta para esta Oferta.') 
                ->class('span7')
                ->required();
    }}
    <hr>
    <div class="form-group">
        <label for="lleva_tit_previa" class="control-label col-lg-2 col-sm-4">
            Se requiere una Titulación Previa para pre-inscribirse a esta Oferta?</label>
        <?php if(!$newForm): ?>
            <div class="col-lg-10 col-sm-8">
                @if($oferta->lleva_tit_previa == 1)
                    <input style="visibility: visible; margin-left: 3px" onclick="mostrar_ocultar('DivTitulacion','lleva_tit_previa')" id="lleva_tit_previa" type="checkbox" checked name="lleva_tit_previa" value="1">
                @else
                    <input style="visibility: visible; margin-left: 3px" onclick="mostrar_ocultar('DivTitulacion','lleva_tit_previa')" id="lleva_tit_previa" type="checkbox" name="lleva_tit_previa" value="0">
                @endif
                <span class="help-block">Chequear si es que para esta Oferta el inscripto debe tener un mínimo nivel educativo.</span>
            </div>
        <?php else: ?>
            <div class="col-lg-10 col-sm-8">
                <input style="visibility: visible; margin-left: 3px" onclick="mostrar_ocultar('DivTitulacion','lleva_tit_previa')" id="lleva_tit_previa" type="checkbox" name="lleva_tit_previa" value="0">
                <span class="help-block">Chequear si es que para esta Oferta el inscripto debe tener un mínimo nivel educativo.</span>
            </div>
        <?php endif; ?>
    </div>    
    <div id='DivTitulacion' style='display: none'>
        <hr>
        <div class="form-group"> 
            <label class="control-label col-lg-2 col-sm-4">Titulación</label>
            <div class="col-lg-10 col-sm-3">
                <?php if(!$newForm): ?>
                    <select class="form-control" name='titulacion_id'>
                        @foreach($titulaciones as $item)
                            @if($item->id == $oferta->titulacion_id)
                                <option value="{{$item->id}}" selected>{{ $item->nombre_titulacion }}</option>
                            @else
                                <option value="{{$item->id}}">{{ $item->nombre_titulacion }}</option>
                            @endif
                        @endforeach
                    </select>
                <?php else: ?>
                    <select class="form-control" name='titulacion_id'>
                        @foreach($titulaciones as $item)                            
                            <option value="{{$item->id}}">{{ $item->nombre_titulacion }}</option>                            
                        @endforeach
                    </select>
                <?php endif; ?>
            </div>
        </div>    
    </div>
    
    <hr>
    <div class="form-group">
        <label for="certificado_alumno_digital" class="control-label col-lg-2 col-sm-4">        
            Desea hablitar el envío de los certificados digitales a los alumnos?</label>
        <?php if(!$newForm): ?>
            <div class="col-lg-10 col-sm-8">
                @if($oferta->certificado_alumno_digital == 1)
                    <input style="visibility: visible; margin-left: 3px" id="certificado_alumno_digital" type="checkbox" checked name="certificado_alumno_digital" value="1">
                @else
                    <input style="visibility: visible; margin-left: 3px" id="certificado_alumno_digital" type="checkbox" name="certificado_alumno_digital" value="0">
                @endif
                <span class="help-block">Chequear si es que para esta Oferta se pueda generar y enviar por mail los Certificados Digitales a los alumnos.</span>
            </div>
        <?php else: ?>
            <div class="col-lg-10 col-sm-8">
                <input style="visibility: visible; margin-left: 3px" id="certificado_alumno_digital" type="checkbox" name="certificado_alumno_digital" value="0">                
                <span class="help-block">Chequear si es que para esta Oferta se pueda generar y enviar por mail los Certificados Digitales a los alumnos.</span>
            </div>
        <?php endif; ?>
    </div>
    <!--{{ Former::checkbox('certificado_alumno_digital')
            ->label('Desea hablitar el envío de los certificados digitales a los alumnos?')
            ->addClass('checkbox')
            ->help('Chequear si es que para esta Oferta se pueda generar y enviar por mail los Certificados Digitales a los alumnos.') 
            ->style('visibility: visible; margin-left: 3px')
    }}-->
    <hr>
    <div class="form-group">
        <label for="certificado_capacitador_digital" class="control-label col-lg-2 col-sm-4">
            Desea hablitar el envío de los certificados digitales a los capacitadores?</label>
        <?php if(!$newForm): ?>
            <div class="col-lg-10 col-sm-8">
                @if($oferta->certificado_capacitador_digital == 1)
                    <input style="visibility: visible; margin-left: 3px" id="certificado_capacitador_digital" type="checkbox" checked name="certificado_capacitador_digital" value="1">
                @else
                    <input style="visibility: visible; margin-left: 3px" id="certificado_capacitador_digital" type="checkbox" name="certificado_capacitador_digital" value="0">
                @endif
                <span class="help-block">Chequear si es que para esta Oferta se pueda generar y enviar por mail los Certificados Digitales a los capacitadores.</span>
            </div>
        <?php else: ?>
            <div class="col-lg-10 col-sm-8">
                <input style="visibility: visible; margin-left: 3px" id="certificado_capacitador_digital" type="checkbox" name="certificado_capacitador_digital" value="0">                
                <span class="help-block">Chequear si es que para esta Oferta se pueda generar y enviar por mail los Certificados Digitales a los capacitadores.</span>
            </div>
        <?php endif; ?>
    </div>
    <!--{{ Former::checkbox('certificado_capacitador_digital')
            ->label('Desea hablitar el envío de los certificados digitales a los capacitadores?')
            ->addClass('checkbox')
            ->help('Chequear si es que para esta Oferta se pueda generar y enviar por mail los Certificados Digitales a los capacitadores.') 
            ->style('visibility: visible; margin-left: 3px')
    }}-->
    <hr>
    <div class="alert alert-info" style="padding: 20px;" id="DivCargarBaseCertificados">
        <!-- Agrego el campo nuevo: certificado_base_alumnos -->
        <div class="form-group">
            <label for="cert_base_alum_file_name" class="control-label col-lg-2 col-sm-4">Certificado BASE para ALUMNOS:</label>
            <div class="col-lg-5 col-sm-8">
                <?php if($newForm): ?>
                    <input class="form-control" id="cert_base_alum_file_name" type="text" name="cert_base_alum_file_name" placeholder="Sin Imágen">
                <?php else: ?>
                    <input class="form-control" id="cert_base_alum_file_name" type="text" name="cert_base_alum_file_name" value="<?php echo $oferta->cert_base_alum_file_name?>">
                <?php endif;?>
                <span class="help-block">(*) Para dejar sin imágen base del certificado de alumnos sólo debe borrar el texto de arriba.</span>
            </div>
            <div class="col-lg-5 col-sm-8">            
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Cargar <input type="file" id="cert_base_alum" name="cert_base_alum" onchange="validarNombreDeArchivo('cert_base_alum')">
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
                <span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual (el nombre del archivo no debe contener espacios).</span>
            </div>
        </div>
        <hr>
        <!-- Agrego el campo nuevo: certificado_base_capacitadores -->
        <div class="form-group">
            <label for="cert_base_cap_file_name" class="control-label col-lg-2 col-sm-4">Certificado BASE para CAPACITADORES:</label>
            <div class="col-lg-5 col-sm-8">
                <?php if($newForm): ?>
                    <input class="form-control" id="cert_base_cap_file_name" type="text" name="cert_base_cap_file_name" placeholder="Sin Imágen">
                <?php else: ?>
                    <input class="form-control" id="cert_base_cap_file_name" type="text" name="cert_base_cap_file_name" value="<?php echo $oferta->cert_base_cap_file_name?>">
                <?php endif;?>
                <span class="help-block">(*) Para dejar sin imágen base del certificado de capacitadores sólo debe borrar el texto de arriba</span>
            </div>
            <div class="col-lg-5 col-sm-8">            
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Cargar <input type="file" id="cert_base_cap" name="cert_base_cap"  onchange="validarNombreDeArchivo('cert_base_cap')">
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
                <span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual (el nombre del archivo no debe contener espacios).</span>
            </div>
        </div>
    </div>    
</div>
<?php if($newForm): ?>
{{ Former::actions(
            link_to_route('ofertas.index', 'Volver', null, array('class' => 'btn btn-lg btn-success')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Crear')
    )
}}
<?php else: ?>
{{ Former::actions(
            link_to_route('ofertas.index', 'Volver', null, array('class' => 'btn btn-lg btn-success')),
            Former::lg_default_reset('Restablecer'),
            Former::lg_primary_submit('Guardar Cambios')
    )
}}
<?php endif; ?>
</fieldset>
{{ Former::close() }}

<script>    
    $(function(){
        $('#btn-upload').click(function(e){
            e.preventDefault();
            $('#mail_bienvenida').click();
        });
    });
    
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
      });

      $(document).ready( function() {
          $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

              var input = $(this).parents('.input-group').find(':text'),
                  log = numFiles > 1 ? numFiles + ' files selected' : label;

              if( input.length ) {
                  input.val(log);
              } else {
                  if( log ) alert(log);
              }

          });
      });
      
    function validarNombreDeArchivo(campoId){
        pathFile = document.getElementById(campoId).value;
        nameFileConEspacios = pathFile.match(/[^\/\\]+\.(?:jpg|gif|png|bmp)$/i);        
        nameFileConEspacios = nameFileConEspacios.toString().replace(/\.jpg$|\.gif$|\.png$|\.bmp$/i,"");
        
        if( (/['']|\s/i).test(nameFileConEspacios)){
            alert('El nombre del archivo no debe contener espacios!!');
            document.getElementById(campoId).value = null;
            return document.getElementById(campoId).focus();
        }
        /*nameFileSinEspacios = reemplazar(nameFileConEspacios,' ','-');
        pathFileOk = reemplazar(pathFile,nameFileConEspacios,nameFileSinEspacios);
        alert('Nombre archivo: '+ pathFileOk);*/
        return true;
    }
    
    function reemplazar(texto,s1,s2){
        return texto.split(s1).join(s2);
    }
      
    function mostrar_ocultar(divId, checkboxId) {
        element = document.getElementById(divId);
        check = document.getElementById(checkboxId);
        if (check.checked) {
            element.style.display='block';
        }else{
            element.style.display='none';
        }
    }
    
    function ocultarCamposEnCarrera(){
        oferta_tipo_id = document.querySelector('input[name="tipo_oferta"]:checked').value;
        divAOcultar = document.getElementById('ocultosDeCarrera');
        //window.alert('(fuera del IF)Oferta tipo: '+oferta_id);
        if(oferta_tipo_id === 1){ //si la Oferta es Carrera, oculto algunos campos
            //window.alert('(IF true) Oferta tipo: '+oferta_id);
            divAOcultar.style.display='none';
        }else{
            //window.alert('(IF false) Oferta tipo: '+oferta_id);
            divAOcultar.style.display='block';
            /* quito el required de fecha_inicio_oferta y fecha_fin_oferta s/mail de guillermo del 2018-05-14 */
            //document.getElementById('fecha_inicio_oferta').required = true;
            //document.getElementById('fecha_fin_oferta').required = true;
        }
    };
    
    function sanearFechaFinOferta(){
        ffo = String(document.getElementById('fecha_fin_oferta').value);
        
        if(ffo === '30/11/-0001'){            
            document.getElementById('fecha_fin_oferta').value = '';
            //window.alert('Fecha: '+ffo);
        }
    }
    
    function sanearFechaInicioOferta(){
        ffo = String(document.getElementById('fecha_inicio_oferta').value);
        
        if(ffo === '30/11/-0001'){            
            document.getElementById('fecha_inicio_oferta').value = '';
            //window.alert('Fecha: '+ffo);
        }
    }
    
    window.onload = function (){
        ocultarCamposEnCarrera();
        sanearFechaFinOferta();
        sanearFechaInicioOferta();
        mostrar_ocultar('DivTitulacion','lleva_tit_previa');
        //mostrar_ocultar('DivCargarBaseCertificados','certificado_digital');
    };
    
    function completarDocAPresentar(){
        cabecera = document.getElementById('cabeceraDocAPresentar').value;
        doc1 = document.getElementById('1DocAPresentar').value;
        doc2 = document.getElementById('2DocAPresentar').value;
        doc3 = document.getElementById('3DocAPresentar').value;
        doc4 = document.getElementById('4DocAPresentar').value;
        
        texto = cabecera+"|"+doc1+"|"+doc2+"|"+doc3+"|"+doc4;
        
        //alert("Concatenado:"+texto);
        document.getElementById('doc_a_presentar').value = texto;
    }
        
</script>