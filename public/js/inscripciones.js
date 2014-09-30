var InscripcionesModule = {
    init: function(oferta_id)
    {
        var self = this;
        self.oferta_id = oferta_id;
        
        self.initTabs();
        self.initRequisitos();
        self.initLocalidades();
        self.initComoTeEnteraste();
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
        self.$area_requisito = $("td.area_requisito");
        self.$form_nuevo_requisito = self.$area_requisito.find('form.nuevo');

        self.$form_nuevo_requisito.bind('ajax:success', function(evt, xhr, status) {
            $(this).closest('td.area_requisito').html("Éxito");
        });

        self.$form_nuevo_requisito.bind('ajax:error', function(event, xhr, settings) {
            bootbox.alert("Error al guardar");
        });

        $('.action-borrar').on('ajax:success', function(data, status, xhr) {
            $(this).closest('td.area_requisito').html("Éxito");
        });
    },

    initLocalidades: function() {
        var $loc      = $('#localidad_id');
        var $otra     = $('<option value="99">Otra</option>');
        var $loc_otra = $('#localidad_otra');
        
        $otra.appendTo($loc);
        
        $loc.on("change", function() {
            if($(this).val() != 99) {
                $("div.otra_localidad").addClass("hide");
                $loc_otra.val("");
            } else {
                $("div.otra_localidad").removeClass("hide");
            }
            
                
        });
    },

    initComoTeEnteraste: function(){
        $("#como_te_enteraste option:first").val("");
    }
};