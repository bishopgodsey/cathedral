$(function(){

    var search = $('#search'),
        result = $('#result')
        ;
    var Delogation = {
        
        init : function() {
            search.typeahead({
                autoSelect : false,
                onSelect : function(item) {
                    //do the magic here
                   search.val('');
                   search.blur();
                   var tab = window.open(window._g_site_url+'documents/generateDelogationBapteme/'+item.value);
                   tab.focus();
                   
               },
               ajax : {
                    items : 10,
                    url : window._g_site_url+'documents/suggestBapteme',
                    method : "get",
                    loadingClass : "fa fa-spinner",
                    preDispatch : function(query) {
                        Delogation.Utils.showLoadingMask(true,this);
                        return {key : query};
                    },
                    preProcess : function(data) {
                        Delogation.Utils.showLoadingMask(false,this);
                        return data;
                    }
               }
            });
        },
        Utils : {
        
            showLoadingMask : function(state, input) {
                
                if(true===state) {
                    $(input).parent('.form-group').find('i').addClass('fa fa-spinner').show();
                }else {    
                    $(input).parent('.form-group').find('i').removeClass('fa fa-spinner').hide();
                }
            }
        }
    }

    Delogation.init();
});
