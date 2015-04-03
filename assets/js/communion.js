$(function(){

    var Communion = {
    
        init : function() {
        
            //use bootstrap datetimepicker plugin for date selection
            $('.date').datetimepicker({
                pickTime: false
            });
           
            $('#communion_form').bootstrapValidator();

            //activate the plugin on input focus
            $('.date input').focus(function(e){
                e.preventDefault();
                $(this).parent().find('.input-group-addon')
                .trigger('click'); 
            });

            $('#id_diocese').change(
                Communion.cascadeInstitutions
            );

            var 
            search = $('#search'),
            id_bapt = $('#id_bapt');
            search.on('change',function(e){

                if(!id_bapt.val()||id_bapt.val()===''){
                    //alert('validation failed') 
                }
            });
            
            var 
            siteUrl = window._g_site_url+'sacrement/suggestCommunion'; // alert(siteUrl);
            search.typeahead({
               onSelect : function(item) {
                    id_bapt.val(item.value);
               },
               ajax : {
                    items : 10,
                    url : siteUrl,
                    method: "get",
                    triggerLength : 2,
                    loadingClass : 'fa fa-spinner',
                    preDispatch : function(query) {
                        return {key : query};
                    },
                    preProcess : function(data) {
 
                        return data;
                    }

               }
            });

            //autocomplete for lieu de bapteme
            var lieu_confirmation = $('#lieu_conf');
            var id_lieu_confirmation = $('#id_lieu_conf');
            Communion.autocomplete(
                lieu_confirmation,{
                    field : 'nom_institution',
                    url : window._g_site_url+'sacrement/suggestInstitutions'
                    },function(item){
                        id_lieu_confirmation.val(item.value); 
                        var text = item.text.trim().split('-');
                        var institution = text[0];   //alert(insitution);
                        lieu_confirmation.val(institution);
                    }
            );
        },
        autocomplete : function(input,options,callback){
            
            var siteUrl = options.url || (window._g_site_url+'sacrement/suggestParents');
            if(options.url)
                delete options.url;

            input.typeahead({
                autoSelect : false,
                onSelect: function(item) {
                  // $(inputvalue).val(item.value);
                   callback(item);
                    
                },
                ajax: {
                    items : 10,
                    url: siteUrl,
                    triggerLength: 3,
                    method: "get",
                    loadingClass: "fa fa-spinner",
                    preDispatch: function (query) {
                        options = options || {};
                        options.input = query;
                        return options;
                    },
                    preProcess: function (data) {
                        if (data.success === false) {
                            return false;
                        }
                        // We good!
                        return data;
                    }
                }

            });
            
        },
        cascadeInstitutions : function(){
        
            var parroisses = window._g_parroisses[$('#id_diocese').val()] || '';
            var options = '';
            for(p in parroisses) {
                var parroisse = parroisses[p];
                options+='<option value="'+parroisse.id_institution+'">'+
                    parroisse.nom_institution+'</options>'; 
            }
            
            $('#id_paroisse').html(options);
        }
    };

    Communion.init();
    Communion.cascadeInstitutions();

});
