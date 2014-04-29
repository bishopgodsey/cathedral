<?php if(!$ajax) : ?>
<div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
       <i class="fa fa-tint"></i> <?php echo 'Enregistrement du nouveau bapteme' ?>
    </h1>
</div>
    <!-- /.col-lg-12 -->
</div>
<?php endif; ?>

<?php if(!$ajax) : ?>
<!-- /.row -->
<div class="row">
<?php endif; ?>
        
<?php if($this->session->flashdata('notification_message')) : 
        $message = $this->session->flashdata('notification_message');?>
    <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
        <button type="button" class="close" data-dimiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message['text']; ?>
    </div>
<?php endif; ?>

     <div id="rootwizard">
        <ul>
            <li><a href="#tab1" data-toggle="tab"><i class="fa fa-user"></i> Informations personnelles</a></li>
            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-group"></i> Informations sur les parents</a></li>
            <li><a href="#tab3" data-toggle="tab"><i class="fa fa-group"></i> Informations sur les parent spirtuelles</a></li>
            <li><a href="#tab4" data-toggle="tab"><i class="fa fa-camera"></i> Bapteme</a></li>
            <li><a href="#tab5" data-toggle="tab"><i class="fa fa-camera"></i> Photo</a></li>
        </ul>
        <?php
        //echo form_open('sacrement/saveBapteme','id="bapteme_form" role="form"'); 
?>

    <form id="bapteme_form" method="post" role="form"
        data-bv-message="This value is not valid"
        data-bv-feedbackicons-valid="fa fa-check"
        data-bv-feedbackicons-invalid="fa fa-times"
        data-bv-feedbackicons-validating="fa fa-spinner">
        <div class="progress progress-striped active" style="margin-top:10px">
            <div class="progress-bar" role="progressbar" style="width: 0%">
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane" id="tab1">
               <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="numcarte">Numero carte</label>
                            <input type="text" name="num_cart_bapt" class="form-control" 
                                id="numcarte" placeholder="numero de la carte" 
                                data-bv-notempty="true"
                                data-bv-notempty-message="The first name is required" >
                        </div>

                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom_bapt" class="form-control" id="nom" placeholder="Saissez le nom">
                        </div>
 
                        <div class="form-group">
                            <label for="numcarte">Sexe</label>
                            <div class="form-control">   
                                <label for="masculin" style="font-weight:normal;">
                                    <input type="radio" checked id="masculin" name="sexe_bapt" value="Masculin"/>
                                Masculin
                                </label>
                                <label for="feminin" style="font-weight:normal;">
                                    <input type="radio" id="feminin" name="sexe_bapt" value="Feminin"/>
                                 Feminin
                                 </label>
                            </div> 
                        </div>

                        <div class="form-group">
                            <label for="domicile">Domicile</label>
                            <input type="text" name="domicile_bapt" class="form-control" id="domicile" placeholder="Ou habite vous? ">
                        </div>

                        <div class="form-group">
                            <label for="tel_fixe">Tel Fixe</label>
                            <input type="tel" name="tel_fixe" class="form-control" id="tel_fixe" placeholder="Numero de telephone fixe">
                        </div>

                        <div class="form-group">
                            <label for="date_naissance">Date Naissance</label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_naissance" id="date_naissance"/>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">

                        <div class="form-group">
                            <label for="categorie">Categorie</label>
                            <select id="categorie" name="id_categorie" class="form-control">
                                <option value="1">Enfant</option>
                                <option value="2">Adulte</option>
                            </select>
                        </div>
                         
                        <div class="form-group">
                            <label for="prenom">Prenom</label>
                            <input type="text" name="prenom_bapt" class="form-control" id="prenom" placeholder="Saisissez le prenom">
                        </div>

                        <div class="form-group">
                            <label for="professionf">Profession</label>
                            <input type="text" name="professionBapt" class="form-control" id="prefession" placeholder="Saisissez la profession">
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom">Email</label>
                            <input type="email" name="email" class="form-control" id="prenom" placeholder="Saisissez l'email ">
                        </div>

                        <div class="form-group">
                            <label for="tel_mob">Tel Mobile</label>
                            <input type="tel" name="tel_mob" class="form-control" id="tel_mob" placeholder="Numero de telephone mobile">
                        </div>

                        <div class="form-group">
                            <label for="date_bapt">Date bapteme</label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_bapt" id="date_bapt"/>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
               </div> 
            </div>
            <div class="tab-pane" id="tab2">
                <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_pere">Nom du pere</label>
                            <input type="text" name="nom_pere" class="form-control" id="nom_pere" placeholder="Tapez quelques lettres">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_pere">Prenom du pere</label>
                            <input type="text" name="prenom_pere" class="form-control" id="prenom_pere" placeholder="Tapez quelques lettres">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_mere">Nom de la mere</label>
                            <input type="text" name="nom_mere" class="form-control" id="nom_mere" placeholder="Tapez quelques lettres">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_mere">Prenom de la mere</label>
                            <input type="text" name="prenom_mere" class="form-control" id="prenom_mere" placeholder="Tapez quelques lettres">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="date_marriage">Date Marriage</label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="dateMarriageParent" id="dateMarriageParent"/>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                </div> 
            </div>
            <div class="tab-pane" id="tab3">
                
                <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_pere">Nom du parain / Maraine</label>
                            <input type="text" name="nom_parain" class="form-control" id="nom_parain" placeholder="Tapez quelques lettres">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_pere">Prenom du parrain / Maraine</label>
                            <input type="text" name="prenom_perain" class="form-control" id="prenom_parain" placeholder="Tapez quelques lettres">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="num_carte_parrain">Numero Carte Bapteme</label>
                            <input type="text" name="num_carte_parrain" class="form-control" id="num_carte_parrain" placeholder="Tapez quelques lettres">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="date_bapteme_parrain">Date bapteme</label>

                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" disabled type="text" class="form-control" name="date_bapteme_parrain" id="date_bapteme_parrain" />
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab4">
                
                <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="institution">Institution</label>
                            <input type="text" name="id_institution" class="form-control" id="institution" placeholder="Tapez quelques lettres pour selectionner">
                        </div>

                        <div class="form-group">
                            <label for="nom_celebrant">Nom celebrant</label>
                            <input type="text" name="nom_celebrant" class="form-control" id="nom_celebrant" placeholder="Tapez le nom du celebrant">
                        </div>

                        <div class="form-group">
                            <label for="tel_cel_1">Telephone 1</label>
                            <input type="text" name="tel_cel_1" class="form-control" id="tel_cel_1" placeholder="Numero de telephone">
                        </div>
                        <div class="form-group">
                            <label for="lieu_ministere">Lieu du Ministere</label>
                            <input type="text" name="lieu_ministere" class="form-control" id="lieu_ministere">
                        </div>
                    </div>
    
                    <div class="col-sm-6 col-md-6 col-lg-6">

                        <div class="form-group">
                            <label for="lieu_bapt">Lieu Bapteme</label>
                            <input type="text" name="lieu_bapt" class="form-control" id="lieu_bapt" placeholder="Lieu du Bapteme">
                        </div>
                        <div class="form-group">
                            <label for="prenom_celebrant">Prenom celebrant</label>
                            <input type="text" name="prenom_celebrant" class="form-control" id="prenom_celebrant" placeholder="Tapez le prenom du celebrant">
                        </div>

                        <div class="form-group">
                            <label for="tel_cel_2">Telephone 2</label>
                            <input type="text" name="tel_cel_2" class="form-control" id="tel_cel_2" placeholder="Numero de telephone">
                        </div>
                        <div class="form-group">
                            <label for="service">Service</label>
                            <input type="text" name="service" class="form-control" id="service">
                        </div>
                    </div>
                </div>
            </div>
        
<div class="tab-pane" id="tab5">
    test
</div>
            <ul class="pager wizard">
                <li class="previous first" style="display:none;"><a href="#" class="validate">First</a></li>
                <li class="previous"><a href="#" class="validate">Previous</a></li>
                <li class="next last" style="display:none;"><a href="#" class="validate">Last</a></li>
                <li class="next"><a href="#" class="validate">Next</a></li>
            </ul>
        </div>  
<?php echo form_close(); ?> 
    </div>
<?php if(!$ajax) : ?>
    </div>
<?php endif; ?>    
</div>

