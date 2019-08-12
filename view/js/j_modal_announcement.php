<script type="text/javascript">
        
    var man_otable;
    var man_load_type;
    
    $(document).ready(function () {
        
        $('#modal_announcement').on('shown.bs.modal', function() {
            
        });
        
        $('#man_timepicker').timepicker();
        $('#man_timepicker2').timepicker();
        
        $("#man_datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: true,
            closeText:'Clear',
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            }
        });
        $("#man_datepicker2").datepicker({
            dateFormat: 'dd/mm/yy',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: true,
            closeText:'Clear',
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            }
        });
                        
    });
    
    function f_load_announcement(load_type, mch_id, otable) {
        $('#form_man').trigger('reset');
        man_load_type = load_type;
        man_otable = otable;  
        if (man_load_type == 1) {
            $('#man_title').html('Add');
        } else {
            $('#man_title').html('Edit');
        }
        $('#modal_announcement').modal('show');
    }
    
</script>