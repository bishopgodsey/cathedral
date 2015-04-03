<?php if(!$ajax) : ?>
<div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
       <i class="fa fa-tint"></i> <?php echo 'Enregistrement du marriage' ?>
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
            <li><a href="#tab1" data-toggle="tab"><i class="fa fa-male fa-lg"></i> Mari</a></li>
			<li><a href="#tab5" data-toggle="tab"><i class="fa fa-female fa-lg"></i> Epouse</a></li>
            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-male fa-lg"></i> Parrain</a></li>
            <li><a href="#tab3" data-toggle="tab"><i class="fa fa-female fa-lg"></i> Marraine</a></li>
            <li><a href="#tab4" data-toggle="tab"><i class="fa fa-institution fa-lg"></i> Marriage</a></li>
            
        </ul>

        <form id="marriage_form" action="<?php echo site_url('sacrement/saveMarriage'); ?>"  method="post" role="form"
        data-bv-message="This value is not valid"
        data-bv-feedbackicons-valid="fa fa-check"
        data-bv-feedbackicons-invalid="fa fa-times"
        data-bv-feedbackicons-validating="fa fa-spinner fa-spin">
        <div class="progress progress-striped active" style="margin-top:10px">
            <div class="progress-bar" role="progressbar" style="width: 0%">
            </div>
        </div>
        <div class="tab-content">
			<input type="hidden" name="marriage_id" value="<?php echo $marriage_id;?>"/>
            <div class="tab-pane" id="tab1">
               <div class="spaceup spaceright spaceleft">
                <div class="row"> 
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <label>Categorie </label>
                            </div>
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <div>
                                    <label style="font-weight:normal">
                                        <input type="radio" value="chretien" id="chretien" name="type_personne" <?php if($marriage_id=="") echo "checked='checked'"; if($conjoint_id!='' AND $conjoint_id!=0){ echo "checked='checked'"; }else{  echo '';}?>/>
                                        Catholique
                                    </label>
                                </div>
                                <div>
                                    <label style="font-weight:normal">
                                        <input type="radio" id="no_chretien" value="no_chretien" name="type_personne" <?php if($no_catholique_conjoint_id!='' AND $no_catholique_conjoint_id!=0){ echo "checked='checked'"; }else{  echo '';}?>/>
                                        Non Catholique
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <div class="input-group"> 
                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                <input type="text" autocomplete="off" name="search_mari" class="form-control" id="search" value="<?php echo $husband;?>" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
                            </div>
                            <input type="text" name="conjoint_id" id="id_confirmation" value="<?php echo $conjoint_id;?>"/>
							<input type="text" name="no_catholique_conjoint_id" id="no_catholique_conjoint_id" value="<?php echo $no_catholique_conjoint_id;?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                </div>
                
               <div id="tab1content"> 
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">         
                            <div class="form-group">
                                <label for="nom">Nom <span>*</span></label>
                                <input type="text" name="nom" class="form-control" id="nom" value="<?php echo $husband_name;?>" placeholder="Nom"
                                data-bv-notempty data-bv-notempty-message="Indiquer le nom SVP!"
                                data-bv-regexp="true"
                                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">         
                            <div class="form-group">
                                <label for="prenom">Prenom <span>*</span></label>
                                <input type="text" name="prenom" class="form-control" id="prenom" value="<?php echo $husband_surname;?>" placeholder="Prenom"
                                data-bv-notempty data-bv-notempty-message="Indiquer le prenom SVP!"
                                data-bv-regexp="true"
                                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                data-bv-regexp-message="Le prenom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="numcarte">Sexe <span>*</span></label>
                                <div class="form-control">   
                                    <label for="masculin" style="font-weight:normal;">
                                        <input type="radio" checked id="masculin" name="sexe" value="Masculin" 
                                        data-bv-notempty data-bv-notempty-message="Vous devez selectionner le genre"/>
                                    Masculin
                                    </label>
                                    <!--<label for="feminin" style="font-weight:normal;">
                                        <input type="radio" id="feminin" name="sexe" value="Feminin"/>
                                    Feminin
                                    </label>-->
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="date_naissance">Date de Naissance </label>
                                <div class="input-group date" data-date-format="YYYY-MM-DD">
                                <input autocomplete="off" type="text" class="form-control" name="date_naissance" id="date_naissance" value="<?php echo $husband_date_naissance;?>"            
                                    data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="adresse">Adresse </label>
                                <input id="adresse" placeholder="Adresse" name="adresse" class="form-control" value="<?php echo $husband_domicile_bapt;?>"/> 
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="tel">Telephone </label>
                                <input id="tel" type="tel" placeholder="Numero de Telephone" name="tel" value="<?php echo $husband_tel;?>" class="form-control"
                                data-bv-regexp="true"
                                data-bv-regexp-regexp="(22|71|72|75|76|77|78|79){1}[0-9]{6}$"
                                data-bv-regexp-message="Le numero de telephone est invalide">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $husband_email;?>" placeholder="Saisissez l'email"
                                data-bv-emailaddress-message="Cette email n'est pas valide">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" class="form-control" id="photo" >
                            </div>
                        </div>
                    </div>
                </div>
               </div> 
            </div>
            <div class="tab-pane" id="tab2">
            
            <div class="spaceup spaceright spaceleft">
            <div class="row"> 
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <label>Categorie </label>
                        </div>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <div>
                                <label for="chretien2" style="font-weight:normal">
                                    <input type="radio" value="chretien" id="chretien2" <?php if($marriage_id=="") echo "checked='checked'"; if($parrain_id!='' AND $parrain_id!=0){ echo "checked='checked'"; }else{  echo '';}?> name="type_personne2" />
                                    Catholique
                                </label>
                            </div>
                            <div>
                                <label id="no_chretien2" style="font-weight:normal">
                                    <input type="radio" id="no_chretien2" value="no_chretien" <?php if($no_catholique_parrain_id!='' AND $no_catholique_parrain_id!=0){ echo "checked='checked'"; }else{  echo '';} ?>  name="type_personne2"/>
                                    Non Catholique
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="search2">Search</label>
                        <div class="input-group"> 
                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            <input type="text" autocomplete="off" name="search_parrain" class="form-control" id="search2" value="<?php echo $godfather;?>" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
                        </div>
                        <input type="text" name="parrain_id" id="id_confirmation2" value="<?php echo $parrain_id;?>"/>
						<input type="text" name="no_catholique_parrain_id" id="no_catholique_parrain_id" value="<?php echo $no_catholique_parrain_id;?>"/>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12 col-md-12">
                <hr />
            </div>

            <div id="tab2content"> 
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">         
                        <div class="form-group">
                            <label for="nom2">Nom <span>*</span></label>
                            <input type="text" name="nom_parrain" class="form-control" id="nom2" value="<?php echo $godfather_name;?>" placeholder="Nom"
                            data-bv-notempty data-bv-notempty-message="Indiquer le nom SVP!"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">         
                        <div class="form-group">
                            <label for="prenom2">Prenom <span>*</span></label>
                            <input type="text" name="prenom_parrain" class="form-control" id="prenom2" value="<?php echo $godfather_surname;?>" placeholder="Prenom"
                            data-bv-notempty data-bv-notempty-message="Indiquer le prenom SVP!"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le prenom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Sexe <span>*</span></label>
                            <div class="form-control">   
                                <label for="masculin2" style="font-weight:normal;">
                                    <input type="radio" checked id="masculin2" name="sexe_parrain" value="Masculin" 
                                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner le genre"/>
                                Masculin
                                </label>
                                <!--<label for="feminin" style="font-weight:normal;">
                                    <input type="radio" id="feminin2" name="sexe_parrain" value="Feminin"/>
                                Feminin
                                </label> -->
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="date_naissance2">Date de Naissance </label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_naissance_parrain" id="date_naissance2"             
                             value="<?php echo $godfather_date_naissance;?>"   data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="adresse2">Adresse </label>
                            <input id="adresse2" placeholder="Adresse" name="adresse_parrain" 
							class="form-control" value="<?php echo $godfather_domicile_bapt;?>" /> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="tel2">Telephone </label>
                            <input id="tel2" type="tel" placeholder="Numero de Telephone" name="tel_parrain" class="form-control" 
							value="<?php echo $godfather_tel?>"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="(22|71|72|75|76|77|78|79){1}[0-9]{6}$"
                            data-bv-regexp-message="Le numero de telephone est invalide">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="email2">Email</label>
                            <input type="email" name="email_parrain" class="form-control" id="email2" value="<?php echo $godfather_email;?>" placeholder="Saisissez l'email"
                            data-bv-emailaddress-message="Cette email n'est pas valide">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="photo2">Photo</label>
                            <input type="file" name="photo_parrain" class="form-control" id="photo2" >
                        </div>
                    </div>
                </div>
            </div>
            </div> 
            </div>
            <div class="tab-pane" id="tab3">
                
                <div class="spaceup spaceright spaceleft">
                    <div class="row"> 
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <label>Categorie </label>
                                </div>
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <div>
                                        <label for="chretien3" style="font-weight:normal">
                                            <input type="radio" value="chretien" id="chretien3"  name="type_personne3" <?php if($marriage_id=="") echo "checked='checked'"; if($marraine_id!='' AND $marraine_id!=0){ echo "checked='checked'"; }else{  echo '';}?> />
                                            Catholique
                                        </label>
                                    </div>
                                    <div>
                                        <label for="no_chretien3" style="font-weight:normal">
                                            <input type="radio" id="no_chretien3" value="no_chretien" name="type_personne3" <?php if($no_catholique_marraine_id!='' AND $no_catholique_marraine_id!=0){ echo "checked='checked'"; }else{  echo '';}?> />
                                            Non Catholique
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="search3">Search</label>
                                <div class="input-group"> 
                                    <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                    <input type="text" autocomplete="off" name="search_marraine" class="form-control" id="search3" 
									  value="<?php echo $godmother;?>" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
                                </div>
                                <input type="text" name="marraine_id" id="id_confirmation3" value="<?php echo $marraine_id;?>"/>
								<input type="text" name="no_catholique_marraine_id" id="no_catholique_marraine_id" value="<?php echo $no_catholique_marraine_id;?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                        <hr />
                    </div>

                    <div id="tab3content"> 
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">         
                                <div class="form-group">
                                    <label for="nom3">Nom <span>*</span></label>
                                <input type="text" name="nom_marraine" class="form-control" id="nom3" value="<?php echo $godmother_name;?>" placeholder="Nom"
                                    data-bv-notempty data-bv-notempty-message="Indiquer le nom SVP!"
                                    data-bv-regexp="true"
                                    data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                    data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">         
                                <div class="form-group">
                                    <label for="prenom3">Prenom <span>*</span></label>
                                    <input type="text" name="prenom_marraine" class="form-control" id="prenom3" value="<?php echo $godmother_surname;?>" placeholder="Prenom"
                                    data-bv-notempty data-bv-notempty-message="Indiquer le prenom SVP!"
                                    data-bv-regexp="true"
                                    data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                    data-bv-regexp-message="Le prenom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="numcarte">Sexe <span>*</span></label>
                                    <div class="form-control">   
                                        <!--<label for="masculin" style="font-weight:normal;">
                                            <input type="radio" checked id="masculin" name="sexe" value="Masculin" 
                                            data-bv-notempty data-bv-notempty-message="Vous devez selectionner le genre"/>
                                        Masculin
                                        </label> -->
                                        <label for="feminin3" style="font-weight:normal;">
                                            <input type="radio" id="feminin3" name="sexe_marraine" value="Feminin"/>
                                        Feminin
                                        </label>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="date_naissance3">Date de Naissance </label>
                                    <div class="input-group date" data-date-format="YYYY-MM-DD">
                                    <input autocomplete="off" type="text" class="form-control" value="<?php echo $godmother_date_naissance;?>" name="date_naissance_marraine" id="date_naissance3"             
                                        data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="adresse3">Adresse </label>
                                    <input id="adresse3" placeholder="Adresse" name="adresse_marraine" value="<?php echo $godmother_domicile_bapt;?>" class="form-control" /> 
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="tel3">Telephone </label>
                                    <input id="tel3" type="tel" placeholder="Numero de Telephone" name="tel_marraine" value="<?php echo $godmother_tel;?>" class="form-control"
                                    data-bv-regexp="true"
                                    data-bv-regexp-regexp="(22|71|72|75|76|77|78|79){1}[0-9]{6}$"
                                    data-bv-regexp-message="Le numero de telephone est invalide">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email3">Email</label>
                                    <input type="email" name="email_marraine" class="form-control" id="email3" value="<?php echo $godmother_email;?>" placeholder="Saisissez l'email"
                                    data-bv-emailaddress-message="Cette email n'est pas valide">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="photo3">Photo</label>
                                    <input type="file" name="photo_marraine" class="form-control" id="photo3" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="tab-pane" id="tab4">
                
                <div class="spaceup spaceleft spaceright"> 
                    <div class="row"> 
                        <div class="col-sm-6 col-md-6 col-lg-6">                     
                            <div class="form-group">
                                <label for="num_marriage">Numero Marriage <span>*</span></label>
                                <input type="text" name="num_marriage" class="form-control" id="num_marriage" placeholder="Numero du Marriage"  value="<?php echo $num_marriage;?>"

                                data-bv-notempty data-bv-notempty-message="Le numero du marriage ne peut pas etre vide"
                                data-bv-message="Le numero de marriage invalide"
                                data-bv-regexp="true"
                                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                            </div>
                        </div> 
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="date_bapt">Date Marriage <span>*</span></label>
                                <div class="input-group date" data-date-format="YYYY-MM-DD">
                                <input autocomplete="off" type="text" class="form-control" name="date_marriage" id="date_bapt" value="<?php echo $date_marriage;?>"                    
                                    data-bv-notempty data-bv-notempty-message="La date de marriage est requis"
                                    data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="id_diocese">Diocese<span>*</span></label>
                                <select id="id_diocese" name="id_diocese" class="form-control" 
                                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner une diocese">
                                    <?php foreach($dioceses as $diocese) : ?>
                                        <option value="<?php echo $diocese->id_institution;?>"><?php echo $diocese->nom_institution;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="id_paroisse">Parroisse<span>*</span></label>
                                <select id="id_paroisse" name="id_paroisse" class="form-control" 
                                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner une parroisse">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="lieu_bapt">Lieu Marriage <span>*</span></label>
                                <input type="text" name="lieu_marriage" class="form-control" id="lieu_bapt" value="<?php echo $lieu_marriage;?>" placeholder="Tapez quelques lettres pour selectionner" 
                            data-bv-notempty data-bv-notempty-message="Le lieu de marriage ne peut pas etre vide">
                                <input type="hidden" id="id_lieu_bapteme" name="lieu_celebration_id" value="<?php echo $lieu_celebration_id;?>"/>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                        <hr />
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nom_celebrant">Nom celebrant <span>*</span></label>
                                <input type="text" name="nom_celebrant" class="form-control" id="nom_celebrant" value="<?php echo $nom_celebrant;?>" placeholder="Tapez le nom du celebrant" 

                                data-bv-notempty data-bv-notempty-message="Le nom du celebrant ne peut pas etre vide"
                                data-bv-message="Le nom du celebrant est invalide"
                                data-bv-regexp="true"
                                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6"> 
                            <div class="form-group">
                                <label for="prenom_celebrant">Prenom celebrant <span>*</span></label>
                                <input type="text" name="prenom_celebrant" class="form-control" id="prenom_celebrant" value="<?php echo $prenom_celebrant;?>" placeholder="Tapez le prenom du celebrant"

                                data-bv-notempty data-bv-notempty-message="Le prenom du celebrant ne peut pas etre vide"
                                data-bv-message="Le prenom du parain est invalide"
                                data-bv-regexp="true"
                                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                            </div>
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="lieu_ministere">Lieu du Ministere</label>
                                <input type="text" name="lieu_ministere" class="form-control" id="lieu_ministere" value="<?php echo $lieu_ministere;?>"/>
                                <input type="hidden" id="id_lieu_ministere" name="id_lieu_ministere" value="<?php echo $id_lieu_ministere;?>"/>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="service">Service</label>
                                <input type="text" name="service" class="form-control" id="service" value="<?php echo $service;?>" />
                            </div>
                            
                        </div>
                    </div> 
                </div>
            </div>
        
        <div class="tab-pane" id="tab5">
            <div class="spaceup spaceright spaceleft">
            <div class="row"> 
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <label>Categorie </label>
                        </div>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <div>
                                <label style="font-weight:normal">
                                    <input type="radio" value="chretien" id="chretien5" checked name="type_personne5"/>
                                    Catholique
                                </label>
                            </div>
                            <div>
                                <label style="font-weight:normal">
                                    <input type="radio" id="no_chretien5" value="no_chretien" name="type_personne5"/>
                                    Non Catholique
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <div class="input-group"> 
                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            <input type="text" autocomplete="off" name="search_epouse" class="form-control" id="search5" value="<?php echo $wife;?>" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
                        </div>
                        <input type="text" name="conjointe_id" id="id_confirmation5" value="<?php echo $conjointe_id;?>"/>
						<input type="text" name="no_catholique_conjointe_id" id="no_catholique_conjoint_id" value=""/>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12 col-md-12">
                <hr />
            </div>
            
            <div id="tab5content"> 
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">         
                        <div class="form-group">
                            <label for="nom5">Nom <span>*</span></label>
                            <input type="text" name="nom_epouse" class="form-control" id="nom5" placeholder="Nom" value="<?php echo $wife_name;?>"
                            data-bv-notempty data-bv-notempty-message="Indiquer le nom SVP!"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">         
                        <div class="form-group">
                            <label for="prenom5">Prenom <span>*</span></label>
                            <input type="text" name="prenom_epouse" class="form-control" id="prenom5" placeholder="Prenom" value="<?php echo $wife_surname;?>"
                            data-bv-notempty data-bv-notempty-message="Indiquer le prenom SVP!"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le prenom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Sexe <span>*</span></label>
                            <div class="form-control">   
                                <!--<label for="masculin" style="font-weight:normal;">
                                    <input type="radio" checked id="masculin" name="sexe" value="Masculin" 
                                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner le genre"/>
                                Masculin
                                </label> -->
                                <label for="feminin" style="font-weight:normal;">
                                    <input type="radio" checked id="feminin5" name="sexe_epouse" value="Feminin"/>
                                Feminin
                                </label>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="date_naissance5">Date de Naissance </label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_naissance_epouse" id="date_naissance5" value="<?php echo $wife_date_naissance;?>"            
                                data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="adresse5">Adresse </label>
                            <input id="adresse5" placeholder="Adresse" name="adresse_epouse" class="form-control" value="<?php echo $wife_domicile_bapt;?>"/> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="tel5">Telephone </label>
                            <input id="tel5" type="tel" placeholder="Numero de Telephone" name="tel_epouse" class="form-control" value="<?php echo $wife_tel;?>"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="(22|71|72|75|76|77|78|79){1}[0-9]{6}$"
                            data-bv-regexp-message="Le numero de telephone est invalide">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="email5">Email</label>
                            <input type="email" name="email_epouse" class="form-control" id="email5" value="<?php echo $wife_email;?>" placeholder="Saisissez l'email"
                            data-bv-emailaddress-message="Cette email n'est pas valide">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="photo5">Photo</label>
                            <input type="file" name="photo_epouse" class="form-control" id="photo5" >
                        </div>
                    </div>
                </div>
            </div>
        </div> 
</div>
            <ul class="pager wizard">
                <li class="previous first" style="display:none;"><a href="#" class="validate">First</a></li>
                <li class="previous"><a href="#" class="validate">Previous</a></li>
                <li class="next last" style="display:none;"><a href="#" class="validate">Last</a></li>
                <li class="next"><a href="#" class="validate">Next</a></li>
                <li class="next finish" id="save" style="display:none;"><a href="#">Save</a></li>
            </ul>
        </div>  
<?php echo form_close(); ?> 
    </div>
<?php if(!$ajax) : ?>
    </div>
<?php endif; ?>    
</div>
<script>
var site_url = '<?php echo base_url()?>';
window._g_site_url = site_url;
window._g_parroisses = JSON.parse('<?php echo json_encode($parroisses); ?>');
console.log(window._g_parroisses);
</script>

