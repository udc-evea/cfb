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
        //var mensaje = document.getElementById('mjeBorrar').value;
        
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
                changeYear: true
        });
    }
};

$(function() {
   MainModule.init();
});
    
    /* Funcion para que oculte el submit de confirmrInscriptos cuando la lista de preinscriptos 
     * no esta completa */
    function verificarListaCompleta(id_input_buscar, id_btn_Submit_Form){
        var inputBuscarSize = document.getElementById(id_input_buscar).value.length;        
        
        if(inputBuscarSize > 0){
            document.getElementById(id_btn_Submit_Form).disabled = true;
            //alert("disabled TRUE: "+inputBuscarSize);
        }else{
            document.getElementById(id_btn_Submit_Form).disabled = false;
            //alert("disabled FALSE+ "+inputBuscarSize);
        }
    }
        