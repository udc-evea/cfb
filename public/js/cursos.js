var CursosModule = {
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
};