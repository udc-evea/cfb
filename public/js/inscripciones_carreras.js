var InscripcionesCarrerasModule = {
    init: function(oferta_id)
    {
        var self = this;
        
        self.ID_OTRA      = 99;
        self.ID_CHUBUT    = 1;
        self.ID_ARGENTINA = 1;
        
        self.oferta_id = oferta_id;
        
        self.initIDs();
        self.initTooltips();
        self.initDomicilioProcedencia();
        self.initPaises();
        self.initSituacionLaboral();
        self.initDatosPadre();
        self.initDatosMadre();
    },
    
    initIDs: function() {
        //a cada control le pongo como id su name (a la sf)
        $('input[type=text], input[type=submit], input[type=radio], input[type=checkbox], select, textarea').each(function(){
          $(this).prop("id", $(this).prop('name'));
        });

        //a cada radio o checkbox le pongo como id: name_value (a la sf)
        $('input[type=radio], input[type=checkbox]').each(function(){
          var value = $(this).attr("value").replace(' ','_').replace('/','_');

        $(this).attr("id", $(this).attr('name')+'_'+value);
      });
    },

    initTooltips: function() {
      $(".tooltip-derecha").tooltip();
    },

    initDomicilioProcedencia: function() {
        var $filas = $("table.domicilio_clases tr.opcional");

        $('#domicilio_clases_igual_1').change(function(){
            if (!$(this).prop('checked')) {
                //muestro las filas de la table
                $filas.show(0.5);
            } else {
                //no deshabilito, simplemente copio los valores
                $.each(["calle", "nro", "piso", "depto", "localidad_id", "localidad_otra", "cp", "pcia_id", "pcia_otra", "pais_id", "pais_otro"], (function(i, item){
                    var $origen = $("#domicilio_procedencia_"+item);
                    var $destino = $("#domicilio_clases_"+item);

                    $destino.val($origen.val());
                }));
                
                //el radiobutton de "tipo" es un caso especial
                var $origen = $("input[name=domicilio_procedencia_tipo]:checked");
                
                if($origen.length) {
                    var $destino = $("#"+ $origen.attr("id").replace('procedencia', 'clases'));
                    $destino.prop("checked", "checked");
                }
                
                //oculto las filas de la table
                $filas.hide(0.5);
            }
        });
        
        $('#domicilio_clases_igual_1').trigger("change");
    },
    
    initPaises: function() {
//        var self = this;
//
//        $('.pais').on('change', function() {
//            var $this = $(this);
//            var $pais = $this;
//            var $pcia = $("#"+$this.data("pcia"));
//            
//            if($pais.val() === self.ID_ARGENTINA) { //argentina?
//                if($pcia.val() === self.ID_OTRA) $pcia.val(""); $pcia.trigger("change"); //...le saco el "otra"
//            } else if($pais.val() !== '') { //extranjero?
//                $pcia.val(self.ID_OTRA);    //: 'otra'
//            }
//        });
//        
//        $('.provincia').on('change', function() {
//            var $this = $(this);
//            var $pcia = $this;
//            var $pais = $("#"+$this.data("pais"));
//            var $loc = $("#"+$this.data("loc"));
//            
//            if($pcia.val() === self.ID_CHUBUT) {    //chubut?
//                $pais.val(self.ID_ARGENTINA);       //...argentina
//            } else if($pcia.val() == self.ID_OTRA) {    //otra pcia?
//                $pais.val(self.ID_OTRA);                //...otro pais
//            }
//        });
//        
//        $('.localidad').on('change', function() {
//            var $this = $(this);
//            var $pcia = $("#"+$this.data("pcia"));
//            var $pais = $("#"+$pcia.data("pais"));
//            var $loc  = $this;
//            
//            if($loc.val() !== '' && $loc.val() !== self.ID_OTRA) {    //loc. de chubut?
//                $pcia.val(self.ID_CHUBUT);          //...chubut
//                $pais.val(self.ID_ARGENTINA);       //...y argentina
//            }
//        });
    },

    initSituacionLaboral: function() {
        var $filas = $("table.situacion_laboral tr.opcional");

        $('#situacion_laboral_TRABAJA').change(function() {
            if($(this).is(":checked")) {
                //muestro las filas de la table
                $filas.show(0.5);
            }
        });

        $('#situacion_laboral_NO_TRABAJA, #situacion_laboral_DESOCUPADO').change(function() {
            if($(this).is(":checked")) {
                //limpio los controles
                $filas.find("input[type=radio]").prop("checked", null);
                $filas.find("select, textarea").val("");
                //oculto las filas de la table
                $filas.hide(0.5);
            }
        });
        
        $('#situacion_laboral_TRABAJA, #situacion_laboral_DESOCUPADO, #situacion_laboral_NO_TRABAJA').trigger("change");
    },

    initDatosPadre: function() {
        $('#padre_vive_SI').change(function() {
            if($(this).is(":checked")) {
                var $filas = $("table.datos_padre tr.opcional");
                //habilito los controles
                //muestro las filas de la table
                $filas.show(0.5);
            }
        });
        
        $('#padre_vive_NO, #padre_vive_NS_NC').change(function(){
            if($(this).is(":checked")) {
                var $filas = $("table.datos_padre tr.opcional");
                //deshabilito y limpio los controles
                $filas.find("input[type=radio]").prop("checked", null);
                //limpio los controles

                if($(this).prop("id") === 'padre_vive_NO') {
                    $("table.datos_padre tr.opcional.depende").show();
                    $filas = $("table.datos_padre tr.opcional:not(.depende)");
                }

                $filas.find("select, textarea").val("");
                //oculto las filas de la table
                $filas.hide(0.5);
            }
        });
        
        $("#padre_vive_SI, #padre_vive_NO, #padre_vive_NS_NC").trigger("change");
    },

    initDatosMadre: function() {
        $('#madre_vive_SI').change(function(){
            if($(this).is(":checked")) {
                var $filas = $("table.datos_madre tr.opcional");
                //habilito los controles
                //muestro las filas de la table
                $filas.show(0.5);
            }
        });

        $('#madre_vive_NO, #madre_vive_NS_NC').change(function(){
            if($(this).is(":checked")) {
                var $filas = $("table.datos_madre tr.opcional");
                //deshabilito y limpio los controles
                $filas.find("input[type=radio]").prop("checked", null);
                //limpio los controles

                if($(this).prop("id") === 'madre_vive_NO') {
                    $("table.datos_madre tr.opcional.depende").show();
                    $filas = $("table.datos_madre tr.opcional:not(.depende)");
                }

                $filas.find("select, textarea").val("");
                //oculto las filas de la table
                $filas.hide(0.5);
            }
        });
        
        $("#madre_vive_SI, #madre_vive_NO, #madre_vive_NS_NC").trigger("change");
    }

};