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
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        
        $( "input.fecha" ).datepicker({
                dateFormat: "dd/mm/yy", 
                changeMonth: true,
                changeYear: true,
        }); 
    }
};

$(function() {
   MainModule.init();
});