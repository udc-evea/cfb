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
        ->route($route_name, $route_params  );
}}
{{ Former::populate($obj) }}
<fieldset>        
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
    <hr>    
<div class="form-group required">
    <label class="control-label col-lg-2 col-sm-4">Tipo de Oferta</label>
    <div class="col-lg-10 col-sm-8">
        <div class="btn-group" data-toggle="buttons">
        @foreach($tipos_oferta as $item)
            <label class="btn btn-default @if($obj && $item->id == $obj->tipo_oferta) active @endif">
                <i class="fa {{ $item->icono }}"></i> 
                <input type="radio" @if($obj && $item->id == $obj->tipo_oferta) checked="checked" @endif name="tipo_oferta" value="{{$item->id}}" id="tipo_oferta_{{$item->id}}"> {{ $item->descripcion }}
            </label>
        @endforeach
        </div>
    </div>
</div>
<hr>
<!-- <input type="hidden" name="permite_inscripciones" value="0"/>
{{ Former::checkbox('permite_inscripciones')
	->addClass('checkbox')
        ->help('Habilita las inscripciones a esta oferta')
        ->style('visibility: visible; margin-left: 3px')
     }}    
<hr> -->
{{ Former::text('inicio')
            ->label('Fecha inicio')
            ->addClass('fecha')
            ->placeholder('Colocar la fecha de INICIO de las inscripciones para esta Oferta.')
}}
<hr>
{{ Former::text('fin')
            ->label('Fecha fin')
            ->addClass('fecha')
            ->placeholder('Colocar la fecha de FIN de las inscripciones para esta Oferta.')
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
}}
<hr>
    <div class="form-group">
        <label for="mail_bienvenida_file_name" class="control-label col-lg-2 col-sm-4">Archivo de Imágen Seleccinado:</label>
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
                        Cargar <input type="file" id="mail_bienvenida" name="mail_bienvenida">                        
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual.</span>
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
<input type="hidden" name="presentar_mas_doc" value="0"/>
{{ Former::checkbox('presentar_mas_doc')
        ->label('Debe presentar documentación extra?')
	->addClass('checkbox')
        ->placeholder('Checkear si es que para esta Oferta el inscripto debe presentar documentación extra a la solicitada en el formulario de inscripción.') 
        ->style('visibility: visible; margin-left: 3px')
        ->onclick("mostrar_ocultar('DivDocAPresentar','presentar_mas_doc')")
}}
<hr>
<div id='DivDocAPresentar' style='display: none'>
    {{ Former::textarea('doc_a_presentar')
            ->label('Documentación Extra')
            ->rows(8)
            ->style('background-color: #EFFBFB')
    }}
<hr>
</div>
<!-- Agrego los campos nuevos para la certificacion: resolucion_nro, lugar, duracion, lleva_tit_previa y titulacion_id -->
{{ Former::number('resolucion_nro')
            ->label('Resolución Nro.')
            ->help('Ingrese el Nro. de Resolución dispuesta por la UDC.')
            ->class('span7')
}}
<hr>
{{ Former::text('lugar')
            ->label('Lugar de encuentro') 
            ->help('Especificar el lugar de encuentro dónde se llevará a cabo la Oferta.')
            ->class('span7')
}}
<hr>
{{ Former::number('duracion_hs')
            ->label('Duración de la Oferta (en HS.)')
            ->help('Ingrese la cantidad de horas reloj dispuesta para esta Oferta.') 
            ->class('span7')
}}
<hr>
{{ Former::checkbox('lleva_tit_previa')
        ->label('Lleva titulación previa?')
	->help('Checkear si es que para esta Oferta el inscripto debe podeer una Titulación previa.') 
        ->style('visibility: visible; margin-left: 3px')
        ->onclick("mostrar_ocultar('DivTitulacion','lleva_tit_previa')")
}}
<div id='DivTitulacion' style='display: none'>
    <hr>
    <div class="form-group"> 
        <label class="control-label col-lg-2 col-sm-4">Titulación</label>
        <div class="col-lg-10 col-sm-3">
            <select class="form-control" name='titulacion_id'>
                @foreach($titulaciones as $item)
                    <option value="{{$item->id}}">{{ $item->nombre_titulacion }}</option>
                @endforeach
            </select>
        </div>
    </div>    
</div>
<hr>
    <!-- Agrego el campo nuevo: certificado_base_alumnos -->
    <div class="form-group">
        <label for="cert_base_alum_file_name" class="control-label col-lg-2 col-sm-4">Certificado BASE para ALUMNOS:</label>
        <div class="col-lg-5 col-sm-8">
            <?php if($newForm): ?>
                <input class="form-control" id="cert_base_alum_file_name" type="text" name="cert_base_alum_file_name" placeholder="Sin Imágen">
            <?php else: ?>
                <input class="form-control" id="cert_base_alum_file_name" type="text" name="cert_base_alum_file_name" value="<?php echo $oferta->cert_base_alum_file_name?>">
            <?php endif;?>
            <span class="help-block">(*) Para dejar sin imágen el mail sólo debe borrar el texto de arriba.</span>
        </div>
        <div class="col-lg-5 col-sm-8">            
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Cargar <input type="file" id="cert_base_alum" name="cert_base_alum">
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual.</span>
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
            <span class="help-block">(*) Para dejar sin imágen el mail sólo debe borrar el texto de arriba.</span>
        </div>
        <div class="col-lg-5 col-sm-8">            
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Cargar <input type="file" id="cert_base_cap" name="cert_base_cap">
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">(*) Cargar una nueva imágen, o cambiar la actual.</span>
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
</table>
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
      
      function mostrar_ocultar(divId, checkboxId) {
        element = document.getElementById(divId);
        check = document.getElementById(checkboxId);
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>