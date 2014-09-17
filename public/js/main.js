var MainModule = {
    init: function()
    {
        var self = this;
        self.initBootbox();
        self.confirmDeleteForm();
        self.initDatepicker();
    },
    
    initBootbox: function()
    {
      bootbox.setDefaults({
        'locale': 'es'  
      });
    },
    
    confirmDeleteForm: function()
    {
        var $forms = $("form.confirm-delete");
        var mensaje = "¿Seguro que desea eliminar este registro?";
        
        if(!$forms.length) return;

        $forms.submit(function(e) {
            e.preventDefault();
            var currentForm = this;
            bootbox.confirm(mensaje, function(result) {
                if (result) {
                    currentForm.submit();
                }
            });
        });
    },
    
    initDatepicker: function()
    {
        if (!Modernizr.inputtypes.date) { $( "input[type=date]" ).datepicker({
                format: "yyyy-mm-dd",
                language: "es"
        }); }
    }

};

$(function() {
   MainModule.init();
});