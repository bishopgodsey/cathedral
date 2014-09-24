$(function() {


    var Marriage = {
    
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
            $('#marriage_form').bootstrapValidator();

            //use chosen for select
            $('.chosen-select').chosen();

            $('#id_diocese').change(Marriage.cascadeInstitutions); 

            $('#tab1content input').prop('disabled',true);
            $('#tab2content input').prop('disabled',true);
            $('#tab3content input').prop('disabled',true);
            $('#tab5content input').prop('disabled',true);
        },
        tab1 : function() {
           var search = $('#search'),
                id_confirmation = $('#id_confirmation'),
                nom = $('#nom'),
                prenom = $('#prenom'),
                sexe = $('#sexe'),
                dateNaissance = $('#date_naissance'),
                tel = $('#tel'),
                adresse = $('#adresse'),
                email = $('#email'),
                photo = $('#photo');
           
            $('input[name=type_personne]:radio').change(function(){
               if($(this).val()==='chretien') {
                    $('#tab1content input').prop("disabled",true);
                    search.prop('disabled',false);

                    Marriage.utils.validateForm('marriage_form','nom');
                    Marriage.utils.validateForm('marriage_form','prenom');
               }else {
                    
                    $('#tab1content input').prop('disabled',false);
                    search.prop('disabled',true);

                    Marriage.utils.validateForm('marriage_form','search_mari')
                    //reset the form
                    nom.val('');
                    id_confirmation.val('');
                    prenom.val('');
                    dateNaissance.val('');
                    adresse.val('');
                    email.val('');
                    tel.val('');
                    search.val('');
                    $('input[name=type_personne]:radio[value=Masculin]').prop('checked',true); 
               } 
            });
            
            Marriage.utils.autocomplete(
                    search,
                    {'url':window._g_site_url+'sacrement/suggestMarriage'},                 
                    function(item){
                        search.val(item.text);
                        var data = JSON.parse(item.value);
                        nom.val(data.nom_bapt);
                        id_confirmation.val(data.id_confirmation);
                        prenom.val(data.prenom_bapt);
                        dateNaissance.val(data.date_naissance);
                        adresse.val(data.domicile_bapt);
                        email.val(data.email);
                        tel.val(data.tel_mob);
                        $('input:radio[value='+data.sexe_bapt+']').prop('checked',true); 
                    
                        Marriage.utils.validateForm('marriage_form','nom');
                        Marriage.utils.validateForm('marriage_form','prenom');
                    }
            );

        },
        tab5 : function() {
       
            var search = $('#search5'),
                 id_confirmation = $('#id_confirmation5'),
                 nom = $('#nom5'),
                 prenom = $('#prenom5'),
                 dateNaissance = $('#date_naissance5'),
                 tel = $('#tel5'),
                 adresse = $('#adresse5'),
                 email = $('#email5'),
                 photo = $('#photo5');

            $('input[name=type_personne5]:radio').change(function(){
                if($(this).val()==='chretien') {
                    $('#tab5content input').prop("disabled",true);
                    search.prop('disabled',false);

                    Marriage.utils.validateForm('marriage_form','nom_epouse');
                    Marriage.utils.validateForm('marriage_form','prenom_epouse');
                }else {
                        
                    $('#tab5content input').prop('disabled',false);
                    search.prop('disabled',true);

                    Marriage.utils.validateForm('marriage_form','search_epouse')
                    //reset the form
                    nom.val('');
                    id_confirmation.val('');
                    prenom.val('');
                    dateNaissance.val('');
                    adresse.val('');
                    email.val('');
                    tel.val('');
                    search.val('');
                   } 
                });

                Marriage.utils.autocomplete(
                        search,
                        {'url':window._g_site_url+'sacrement/suggestMarriage','sexe':'Feminin'},                 
                        function(item){
                            search.val(item.text);
                            var data = JSON.parse(item.value);
                            nom.val(data.nom_bapt);
                            id_confirmation.val(data.id_confirmation);
                            prenom.val(data.prenom_bapt);
                            dateNaissance.val(data.date_naissance);
                            adresse.val(data.domicile_bapt);
                            email.val(data.email);
                            tel.val(data.tel_mob);
                        
                            Marriage.utils.validateForm('marriage_form','nom_epouse');
                            Marriage.utils.validateForm('marriage_form','prenom_epouse');
                        }
                );
                
        },
        tab2 : function() {
        
            var search = $('#search2'),
                 id_confirmation = $('#id_confirmation2'),
                 nom = $('#nom2'),
                 prenom = $('#prenom2'),
                 dateNaissance = $('#date_naissance2'),
                 tel = $('#tel2'),
                 adresse = $('#adresse2'),
                 email = $('#email2'),
                 photo = $('#photo2');

            $('input[name=type_personne2]:radio').change(function(){
                if($(this).val()==='chretien') {
                    $('#tab2content input').prop("disabled",true);
                    search.prop('disabled',false);

                    Marriage.utils.validateForm('marriage_form','nom_parrain');
                    Marriage.utils.validateForm('marriage_form','prenom_parrain');
                }else {
                        
                    $('#tab2content input').prop('disabled',false);
                    search.prop('disabled',true);

                    Marriage.utils.validateForm('marriage_form','search_parrain');
                    //reset the form
                    nom.val('');
                    id_confirmation.val('');
                    prenom.val('');
                    dateNaissance.val('');
                    adresse.val('');
                    email.val('');
                    tel.val('');
                    search.val('');
                   } 
                });

                Marriage.utils.autocomplete(
                        search,
                        {'url':window._g_site_url+'sacrement/suggestMarriage','sexe':'Masculin'},                 
                        function(item){
                            search.val(item.text);
                            var data = JSON.parse(item.value);
                            nom.val(data.nom_bapt);
                            id_confirmation.val(data.id_confirmation);
                            prenom.val(data.prenom_bapt);
                            dateNaissance.val(data.date_naissance);
                            adresse.val(data.domicile_bapt);
                            email.val(data.email);
                            tel.val(data.tel_mob);
                        
                            Marriage.utils.validateForm('marriage_form','nom_parrain');
                            Marriage.utils.validateForm('marriage_form','prenom_parrain');
                        }
                );
        },
        tab3 : function() {
        
            var search = $('#search3'),
                 id_confirmation = $('#id_confirmation3'),
                 nom = $('#nom3'),
                 prenom = $('#prenom3'),
                 dateNaissance = $('#date_naissance3'),
                 tel = $('#tel3'),
                 adresse = $('#adresse3'),
                 email = $('#email3'),
                 photo = $('#photo3');

            $('input[name=type_personne3]:radio').change(function(){
                if($(this).val()==='chretien') {
                    $('#tab3content input').prop("disabled",true);
                    search.prop('disabled',false);

                    Marriage.utils.validateForm('marriage_form','nom_marraine');
                    Marriage.utils.validateForm('marriage_form','prenom_marraine');
                }else {
                        
                    $('#tab3content input').prop('disabled',false);
                    search.prop('disabled',true);

                    Marriage.utils.validateForm('marriage_form','search_marraine');
                    //reset the form
                    nom.val('');
                    id_confirmation.val('');
                    prenom.val('');
                    dateNaissance.val('');
                    adresse.val('');
                    email.val('');
                    tel.val('');
                    search.val('');
                   } 
                });

                Marriage.utils.autocomplete(
                        search,
                        {'url':window._g_site_url+'sacrement/suggestMarriage','sexe':'Masculin'},                 
                        function(item){
                            search.val(item.text);
                            var data = JSON.parse(item.value);
                            nom.val(data.nom_bapt);
                            id_confirmation.val(data.id_confirmation);
                            prenom.val(data.prenom_bapt);
                            dateNaissance.val(data.date_naissance);
                            adresse.val(data.domicile_bapt);
                            email.val(data.email);
                            tel.val(data.tel_mob);
                        
                            Marriage.utils.validateForm('marriage_form','nom_marraine');
                            Marriage.utils.validateForm('marriage_form','prenom_marraine');
                        }
                );
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
                var data = $('#marriage_form').serialize();
                
                var url = $('#marriage_form').attr('action');
                $.ajax({
                    type : 'POST',
                    url : url+'/1', 
                    dataType : 'json',
                    data : data,
                    success : function(data) {
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
                    $(input).parent('.form-group').find('i').addClass('fa fa-spinner fa-spin').show();
                }else {
                    
                    $(input).parent('.form-group').find('i').removeClass('fa fa-spinner fa-spin').hide();
                }
            },
            validateForm : function(form,input){
                
                $('#'+form).data('bootstrapValidator')
                .updateStatus(input,'NOT_VALIDATED',null)
                .validateField(input);
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
                           
                           Marriage.utils.showLoadingMask(true,input);
                           options = options || {};
                           options.input = query;

                            return options;
                        },
                        preProcess: function (data) {
                            Marriage.utils.showLoadingMask(false,input);
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
                        $('#rootwizard').find('.pager .next').show();                                                           
                        $('#rootwizard').find('.pager .finish, .pager .last').hide();
                    }
                },
                onTabClick : function(tab, navigation, index) {

                   return this.onNext(tab, navigation, index);
                },
                onNext : function(tab, navigation, index) {
                   $('#marriage_form').bootstrapValidator('validate');
                    
                   var children = $('#marriage_form').find('input');
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
           
            var lieuMinistrere = $("input#lieu_ministere");
            var institution_id = $("input#id_lieu_ministere");
            Marriage.utils.autocomplete(
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
            Marriage.utils.autocomplete(
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

    Marriage.init();
    Marriage.wizard();
    Marriage.suggest();
    Marriage.cascadeInstitutions();
    Marriage.save();
    Marriage.tab1();
    Marriage.tab5();
    Marriage.tab2();
    Marriage.tab3();

});
