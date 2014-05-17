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
            $('#bapteme_form').bootstrapValidator();

            //use chosen for select
            $('.chosen-select').chosen();

            $('#id_diocese').change(Bapteme.cascadeInstitutions);      
        },
        cascadeInstitutions : function() {
         
            var parroisses = window._g_parroisses[$('#id_diocese').val()] || '';
            var options = '';
            for(p in parroisses) {
                var parroisse = parroisses[p]; 
                options+='<option value="'+parroisse.id_institution+'">'+parroisse.nom_institution+'</options>'; 
            }
            
            $('#id_paroisse').html(options);
        },
        save : function(){

            $('#save').on('click',function(e){ 
                e.preventDefault();
                var data = $('#bapteme_form').serialize();
                var url = $('#bapteme_form').attr('action');
                $.ajax({
                    type : 'POST',
                    url : url, 
                    dataType : 'json',
                    data : data,
                    success : function(data) {
                        console.log(data);
                        Utils.notify(data);
                    },
                    error : function(xhr, err, desc) {
                        Utils.notify(err+' : '+desc);
                        console.log(xhr.responseText);
                    }
                });

            });
        },
        utils : {
            showLoadingMask : function(state, input) {
                
                if(true===state) {
                    $(input).parent('.form-group').find('i').addClass('fa fa-spinner').show();
                }else {
                    
                    $(input).parent('.form-group').find('i').removeClass('fa fa-spinner').hide();
                }
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
                            Bapteme.utils.showLoadingMask(true,input);
                            options = options || {};
                            options.input = query;

                            return options;
                        },
                        preProcess: function (data) {
                            Bapteme.utils.showLoadingMask(false,input);
                            if (data.success === false) {
                                return false;
                            }
                            // We good!
                            return data;
                        }
                    }

               });
            }
        },
        wizard : function() {
        
            $('#rootwizard').bootstrapWizard({
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;
                    var $percent = ($current/$total) * 100;
                    $('#rootwizard').find('.progress-bar').css({width:$percent+'%'});

                    // If it's the last tab then hide the last button and show the finish instead
                    if($current >= $total) {
                        $('#rootwizard').find('.pager .next').hide();
                        $('#rootwizard').find('.pager .finish').show();
                        $('#rootwizard').find('.pager .finish').removeClass('disabled');
                    } else {
                        $('#rootwizard').find('.pager .next').show();                                                           $('#rootwizard').find('.pager .finish, .pager .last').hide();
                    }
                },
                onTabClick : function(tab, navigation, index) {

                   return this.onNext(tab, navigation, index);
                },
                onNext : function(tab, navigation, index) {
                   $('#bapteme_form').bootstrapValidator('validate');
                    
                   var children = $('#bapteme_form').find('input');
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
            });
        },
        suggest : function() {
           //nom_pere field
            var nom_pere = $('input#nom_pere');
            var prenom_pere = $('input#prenom_pere');
            var id_pere = $('input#pere_id');
            var nom_mere = $('input#nom_mere');
            var prenom_mere = $('input#prenom_mere');
            var id_mere = $('input#mere_id');
            Bapteme.utils.autocomplete(
                    nom_pere,
                    {field : 'nom_bapt','sexe_bapt':'Masculin'},                 
                    function(item){
                    
                        id_pere.val(item.value);
                        var text = item.text.trim();
                        var names = text.split('-')[1];
                        var namesArray = names.trim().split(' ');
                        nom_pere.val(namesArray[0]);
                        prenom_pere.val(namesArray[1]).attr('readonly',true);
                    }
            );


           //prenom_pere field

            Bapteme.utils.autocomplete(
                    prenom_pere,
                    {field : 'prenom_bapt','sexe_bapt':'Masculin'},                 
                    function(item){
                    
                        id_pere.val(item.value);
                        var text = item.text.trim();
                        var names = text.split('-')[1];
                        var namesArray = names.trim().split(' ');
                        prenom_pere.val(namesArray[1]);
                        nom_pere.val(namesArray[0]).attr('readonly',true);
                    }
            );


           //nom_mere field

            Bapteme.utils.autocomplete(
                    nom_mere,
                    {field : 'nom_bapt','sexe_bapt':'Feminin'},                 
                    function(item){
                    
                        id_mere.val(item.value);
                        var text = item.text.trim();
                        var names = text.split('-')[1];
                        var namesArray = names.trim().split(' ');
                        nom_mere.val(namesArray[0]);
                        prenom_mere.val(namesArray[1]).attr('readonly',true);
                    }
            );
           
            //prenom_mere field

            Bapteme.utils.autocomplete(
                    prenom_mere,
                    {field : 'prenom_bapt','sexe_bapt':'Feminin'},                 
                    function(item){
                    
                        id_mere.val(item.value);
                        var text = item.text.trim();
                        var names = text.split('-')[1];
                        var namesArray = names.trim().split(' ');
                        prenom_mere.val(namesArray[1]);
                        nom_mere.val(namesArray[0]).attr('readonly',true);
                    }
            );
            
            //parain/ Maraine
            // nom parain/maraine
            var nom_parrain = $("input#nom_parain");
            var prenom_parrain = $("input#prenom_parain");
            var id_parrain = $('input#parent_bapt_id');

            Bapteme.utils.autocomplete(
                    nom_parrain,
                    {field : 'nom_bapt'},                 
                    function(item){
                    
                        id_parrain.val(item.value);
                        var text = item.text.trim().split('-');
                        var carteBapteme = text[0];
                        var names = text[1];
                        var namesArray = names.trim().split(' ');
                        nom_parrain.val(namesArray[0]);
                        prenom_parrain.val(namesArray[1]).attr('readonly',true);
                    }
            );

            // autocomplete on prenom parrain 
            Bapteme.utils.autocomplete(
                prenom_parrain,
                {field : 'prenom_bapt'},                 
                function(item){
                
                    id_parrain.val(item.value);
                    var text = item.text.trim().split('-');
                    var carteBapteme = text[0];
                    var names = text[1];
                    var namesArray = names.trim().split(' ');
                    nom_parrain.val(namesArray[0]).attr('readonly',true);
                    prenom_parrain.val(namesArray[1]);
                }
            );

           
            var lieuMinistrere = $("input#lieu_ministere");
            var institution_id = $("input#id_lieu_ministere");
            Bapteme.utils.autocomplete(
                lieuMinistrere,
                {
                    field : 'nom_institution',
                    url : window._g_site_url+'sacrement/suggestInstitutions'
                },                 
                function(item){
                
                    institution_id.val(item.value);
                    var text = item.text.trim().split('-');
                    var institution = text[0];

                    lieuMinistrere.val(institution);
                }
            );

            var lieuBapteme = $("input#lieu_bapt");
            var lieuBapteme_id = $("input#id_lieu_bapteme");
            Bapteme.utils.autocomplete(
                lieuBapteme,
                {
                    field : 'nom_institution',
                    url : window._g_site_url+'sacrement/suggestInstitutions'
                },                 
                function(item){
                
                    lieuBapteme_id.val(item.value);
                    var text = item.text.trim().split('-');
                    var institution = text[0];

                    lieuBapteme.val(institution);
                }
            );
        }
    
    };

    Bapteme.init();
    Bapteme.wizard();
    Bapteme.suggest();
    Bapteme.cascadeInstitutions();
    Bapteme.save();

});
