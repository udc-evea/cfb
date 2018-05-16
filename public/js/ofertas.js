var OfertasModule = {
    init: function(oferta_id)
    {
        var self = this;
        self.oferta_id = oferta_id;
        
        self.initRequisitos();
        self.initTabs();
    },
    
    initTabs: function() {
        $('#tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    },
    
    initRequisitos: function()
    {
        var self = this;
        self.$form_nuevo_requisito = $("#tab_requisitos form.nuevo");
        
        self.$form_nuevo_requisito.bind('ajax:success', function(evt, xhr, status) {
            $(xhr).insertAfter($(".requisitos .nuevo"));
            $("#requisito").val("").focus();
        });

        self.$form_nuevo_requisito.bind('ajax:error', function(event, xhr, settings) {
            bootbox.alert("Error al guardar");
        });

        $('.requisitos').on('ajax:success', 'a.accion_borrar', function(data, status, xhr) {
            $(this).closest('li').remove();
        });
    }
    
    
    
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
        }
        else {
            element.style.display='none';
        }
    }
    
    function ocultarCamposEnCarrera(){
        oferta_id = document.querySelector('input[name="tipo_oferta"]:checked').value;
        divAOcultar = document.getElementById('ocultosDeCarrera');
        //window.alert('(fuera del IF)Oferta tipo: '+oferta_id);
        if(oferta_id == 1){ //si la Oferta es Carrera, oculto algunos campos
            //window.alert('(IF true) Oferta tipo: '+oferta_id);
            divAOcultar.style.display='none';
        }else{
            //window.alert('(IF false) Oferta tipo: '+oferta_id);
            divAOcultar.style.display='block';
            document.getElementById('fecha_fin_oferta').required = true;
        }
    };
    
    function sanearFechaFinOferta(){
        ffo = String(document.getElementById('fecha_fin_oferta').value);
        
        if(ffo === '30/11/-0001'){            
            document.getElementById('fecha_fin_oferta').value = '';
            //window.alert('Fecha: '+ffo);
        }
    }
    
    window.onload = function (){
        ocultarCamposEnCarrera();
        sanearFechaFinOferta();
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
};