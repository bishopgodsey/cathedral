
    var Utils = {
        notify : function (data) {
            var n = noty({
                text        : data.text||data,
                type        : data.type||'alert',
                dismissQueue: data.dismissQueue||false,
                timeout		: 3000,
                layout      : data.layout||'top'
            });
        },
        confirm : function(message,confirm,canceled) {
            noty({
                  text: message||'Do you want to continue?',
                  layout      : 'center',
                  type 		  : 'warning',
                  modal		  : true,
                  buttons: [
                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
                        $noty.close();
                        if(confirm!==undefined && typeof(confirm)==='function')							
                            confirm();
                        
                      }
                    },
                    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                        $noty.close();
                        if(canceled!==undefined && typeof(canceled)==='function')
                            canceled();
                        
                      }
                    }
                  ]
                });
        },
        showLoader : function(id,message) {
            var template = '<span class="loader" style="font-weight:bold;">'+(message||'Working...')+' <img src="../assets/images/spinner-mini.gif"/></span>';
            $('#'+id).html(template);;
        },
        hideLoader : function(id) {
            $('#'+id).html('');
        },
        bootstrapValidate : function(form_id) {
            
            var children = $('#'+form_id).find('input');
            var validationFailed = false;
            children.each(function(index,element){
                 if($(element).parent('div').hasClass('has-error')){
                     validationFailed = true;
                     return false;
                 }
            });

            //if validation failed return false to prevent default action
            return !validationFailed;
        }
    };
