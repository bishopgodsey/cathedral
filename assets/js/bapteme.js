$(function() {


    var Bapteme = {
    
        init : function() {
            
            //use bootstrap datetimepicker plugin for date selection
            $('.date').datetimepicker({
                pickTime: false
            });
           
            //activate the plugin on input focus
            $('.date input').focus(function(e){
                e.preventDefault();
                $(this).parent().find('.input-group-addon').trigger('click'); 
            });

            //use bootstrapvalidation plugin
            $('#bapteme_form').bootstrapValidator({
                submitButtons: '.validate'
            });

        },
        utils : {
        
        },
        wizard : function() {
        
            $('#rootwizard').bootstrapWizard({
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;
                    var $percent = ($current/$total) * 100;
                    $('#rootwizard').find('.progress-bar').css({width:$percent+'%'});
                },
                onNext : function(tab, navigation, index) {
                   if(! $('#bapteme_form').bootstrapValidator('validate')) {
                       return false; 
                   } 
                }
            });
        }
    
    };

    Bapteme.init();
    Bapteme.wizard();
});
