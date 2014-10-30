var InscripcionesModule = {
    init: function(oferta_id)
    {
        var self = this;
        self.oferta_id = oferta_id;
        
        self.initTabs();
        self.initRequisitos();
        self.initLocalidades();
        self.initFechas();
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
        var self = this;
        
        $(".con_otra").each(function(i, el) {
            var $el = $(this);
            
            name = $el.attr("name");
            $la_otra = $(".otra_"+name);
            if($el.val() != 99) {
                $la_otra.addClass("hide");
                $la_otra.find("input").val("");
            } else {
                $la_otra.removeClass("hide");
            }
            
            $el.on("change", function() {
                name = $el.attr("name");
                $la_otra = $(".otra_"+name);
                if($el.val() != 99) {
                    $la_otra.addClass("hide");
                    $la_otra.find("input").val("");
                } else {
                    $la_otra.removeClass("hide");
                }
            });
        });
    },

    initFechas: function() {
        $("#fecha_nacimiento").datepicker("option", "maxDate", "-14y");
        $("#fecha_nacimiento").datepicker("option", "yearRange", "-115:-14");
    }
};