$(function(){

    var Deces = {
    
        init : function() {
        
            //use bootstrap datetimepicker plugin for date selection
            $('.date').datetimepicker({
                pickTime: false
            });

           
            $('#deces_form').bootstrapValidator({
                fields : {
                    date_deces : {
                        validators : {
                            date : {
                                format : 'YYYY-MM-DD',
                                message : 'Invalid date'
                            }
                        }        
                    },
                    date_enterrement : {
                        validators : {
                            date : {
                                format : 'YYYY-MM-DD',
                                message : 'Invalid date'
                            }
                        }        
                    }
                }
            });

            $('.date').on('dp.show dp.change',function(){
                var name = $(this).children('input').attr('name')
                    ,form_name = $(this).parents('form').attr('id');
                $('#'+form_name).data('bootstrapValidator')
               .updateStatus(name, 'NOT_VALIDATED', null)
               .validateField(name);
            });

            //activate the plugin on input focus
            $('.date input').focus(function(e){
                e.preventDefault();
                $(this).parent().find('.input-group-addon')
                .trigger('click'); 
            });

            $('#id_diocese').change(
                Deces.cascadeInstitutions
            );

            var 
            search = $('#search'),
            id_bapteme = $('#id_bapteme'),
            id_nonBaptise = $('#id_nonBaptise');
            search.parent().on('dblclick',function(e){
                search.removeAttr('disabled');
                search.val('');
                id_bapteme.val('');
                id_nonBaptise.val('');
            });

            
            var 
            siteUrl = window._g_site_url+'sacrement/suggestBaptise';
            //autocomplete for search
            search.typeahead({
               onSelect : function(item) {
                    id_bapteme.val(item.value);
                    search.attr('disabled','disabled');
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
            var lieu = $('#lieu_cel');
            var id_lieu = $('#id_lieu');
            Deces.autocomplete(
                lieu,{
                    field : 'nom_institution',
                    url : window._g_site_url+'sacrement/suggestInstitutions'
                    },function(item){
                        id_lieu.val(item.value); 
                        var text = item.text.trim().split('-');
                        var institution = text[0];
                        lieu.val(institution);
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
        },
        save : function() {
            $('#saveDeces').click(function(e){
                e.preventDefault();
                var id_bapteme = $('#id_bapteme'),
                     id_nonBaptise = $('#id_nonBaptise');
                
                var deces_form = $('#deces_form');
                deces_form.bootstrapValidator('validate');

               if(id_bapteme.val()==='' && id_nonBaptise.val()==='') {
                   deces_form.data('bootstrapValidator')
                   .updateStatus('search', 'INVALID');
                    $('input[name=type_personne]:radio').val('chretien'); 
               }else {
                    deces_form.data('bootstrapValidator')
                    .updateStatus('search','NOT_VALIDATED')
                    .validate('search');
               }

                if(deces_form.data('bootstrapValidator').isValid()) {
                   var data = deces_form.serialize();

                   $.ajax({
                        url : window._g_site_url+'sacrement/saveDeces/1',
                        data : data,
                        type : 'POST',
                        dataType : 'json',
                        beforeSend : function(){
                            
                            Utils.showLoader('saveDeces_loader','Saving...');
                        },
                        success : function(data){
                            Utils.notify(data);
                            Utils.hideLoader('saveDeces_loader');
                            deces_form[0].reset();
                            $('#search').val('').removeAttr('disabled');

                            deces_form.data('bootstrapValidator').resetForm();
                        },
                        error : function(xhr,type,error){
                            
                            var error = {
                                    type : 'error',
                                    text : type+' : '+error
                                };

                            Utils.notify(error);
                            Utils.hideLoader('saveDeces_loader');
                            deces_form[0].reset();
                            $('#search').val('').removeAttr('disabled');

                            deces_form.data('bootstrapValidator').resetForm();
                        }
                   });
                }
            });
        },
        closeModal : function(id){
           $('#'+id).modal('hide'); 
        },
        modal : function() {
           var id_bapteme = $('#id_bapteme'),
                id_nonBaptise = $('#id_nonBaptise');
            $('input[name=type_personne]:radio').change(function(){
           
                var type_personne = $(this).val();
                if(type_personne==='chretien') {
                    id_nonBaptise.val(''); 
                }else {
               
                    $('#createPersonneModal').modal({
                        backdrop : false
                    });
                }
            });

            //make some validations on the form
            $('#personne_form').bootstrapValidator({
                fields : {
                    date_naissance : {
                        validators : {
                            date : {
                                format : 'YYYY-MM-DD',
                                message : 'Invalid date'
                            }
                        }        
                    }
                }
            });

            $('#savePersonne').click(function(){
                
                var personne_form = $('#personne_form');
                personne_form.bootstrapValidator('validate');
                
                if(personne_form.data('bootstrapValidator').isValid()) {
                    
                    var data = $('#personne_form').serialize();

                    $.ajax({
                        url : window._g_site_url+'sacrement/savePersonne/1',
                        data : data,
                        dataType : 'json',
                        type : 'POST',
                        beforeSend : function() {
                            //show loader
                            Utils.showLoader('savePersonne_loader','Saving...');
                        },
                        success : function(data){
                            var personne_id = data.personne_id;
                            Utils.notify(data.message); 
                            Utils.hideLoader('savePersonne_loader');
                            
                            var id_bapteme = $('#id_bapteme'),
                            id_nonBaptise = $("#id_nonBaptise"),
                            nom = $('#nom'),
                            prenom = $('#prenom');

                            $('#search').val(nom.val()+' - '+prenom.val()).attr('disabled','disabled');

                            id_bapteme.val('');
                            id_nonBaptise.val('');

                            if(!personne_id || personne_id==='') {
                                $('input[name=type_personne]:radio').val('chretien'); 
                            }else {
                                id_nonBaptise.val(personne_id); 
                            }

                            $('#personne_form')[0].reset();

                            personne_form.data('bootstrapValidator').resetForm();
                            Deces.closeModal('createPersonneModal');
                        },
                        error : function(xhr,type,error) {
                            Utils.notify({type : 'error',
                                        text : error}); 
                            Utils.hideLoader('savePersonne_loader');
                            console.log(xhr.responseText);
                        }
                    });
                }

            });
        }
    };

    Deces.init();
    Deces.cascadeInstitutions();
    Deces.modal();
    Deces.save();

});
