var InscripcionesModule = {
    init: function(oferta_id)
    {
        var self = this;
        self.oferta_id = oferta_id;
        
        self.initTabs();
        self.initRequisitos();
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
    }
};