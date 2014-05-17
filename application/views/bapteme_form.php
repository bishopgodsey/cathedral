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
			<li><a href="#tab5" data-toggle="tab"><i class="fa fa-camera"></i> Photo</a></li>
            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-group"></i> Parents</a></li>
            <li><a href="#tab3" data-toggle="tab"><i class="fa fa-tint"></i> Bapteme</a></li>
            <li><a href="#tab4" data-toggle="tab"><i class="fa fa-ruble"></i> Celebrant</a></li>
            
        </ul>

        <form id="bapteme_form" action="<?php echo site_url('sacrement/saveBapteme'); ?>"  method="post" role="form"
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
                            <label for="categorie">Categorie <span>*</span></label>
                            <select id="categorie" name="id_categorie" class="form-control" 
                                data-bv-notempty data-bv-notempty-message="La Categorie ne peut pas etre vide">
                                <option value="1">Enfant</option>
                                <option value="2">Adulte</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nom">Nom <span>*</span></label>
                            <input type="text" name="nom_bapt" class="form-control" id="nom" placeholder="Saissez le nom" 
                            data-bv-notempty data-bv-notempty-message="Le nom ne peut pas etre vide"
                            data-bv-message="Le nom est invalide"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
 
                        <div class="form-group">
                            <label for="numcarte">Sexe <span>*</span></label>
                            <div class="form-control">   
                                <label for="masculin" style="font-weight:normal;">
                                    <input type="radio" checked id="masculin" name="sexe_bapt" value="Masculin" 
                                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner le genre"/>
                                Masculin
                                </label>
                                <label for="feminin" style="font-weight:normal;">
                                    <input type="radio" id="feminin" name="sexe_bapt" value="Feminin"/>
                                 Feminin
                                 </label>
                            </div> 
                        </div>

                        <div class="form-group">
                            <label for="domicile">Domicile <span>*</span></label>
                            <input type="text" name="domicile_bapt" class="form-control" id="domicile" placeholder="Ou habite vous? "
                            data-bv-notempty data-bv-notempty-message="Veuillez indiquer le domicile">
                        </div>

                        <div class="form-group">
                            <label for="tel_fixe">Tel Fixe</label>
                            <input type="tel" name="tel_fixe" class="form-control" id="tel_fixe" placeholder="Numero de telephone fixe">
                        </div>

                        <div class="form-group">
                            <label for="date_naissance">Date Naissance <span>*</span></label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_naissance" id="date_naissance" 
                            data-bv-notempty data-bv-notempty-message="La date de naissance est requis"
                            data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6"> 
                        <div class="form-group">
                            <label for="numcarte">Numero carte <span>*</span></label>
                            <input type="text" name="num_carte_bapt" id="numcarte" class="form-control" 
                                id="numcarte" placeholder="numero de la carte" 
                                data-bv-notempty="true"
                                data-bv-notempty-message="Le numero de la carte ne peut pas etre vide" >
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom <span>*</span></label>
                            <input type="text" name="prenom_bapt" class="form-control" id="prenom" placeholder="Saisissez le prenom"
                            data-bv-notempty data-bv-notempty-message="Le nom ne peut pas etre vide"
                            data-bv-message="Le nom est invalide"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>

                        <div class="form-group">
                            <label for="professionf">Profession</label>
                            <input type="text" name="professionBapt" class="form-control" id="prefession" placeholder="Saisissez la profession">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Saisissez l'email"
                            data-bv-emailaddress-message="Cette email n'est pas valide">
                        </div>

                        <div class="form-group">
                            <label for="tel_mob">Tel Mobile</label>
                            <input type="tel" name="tel_mob" class="form-control" id="tel_mob" placeholder="Numero de telephone mobile">
                        </div>
                    </div>
               </div> 
            </div>
            <div class="tab-pane" id="tab2">
                <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_pere">Nom du pere</label>
                            <input type="text" name="nom_pere" class="form-control" id="nom_pere" placeholder="Tapez quelques lettres" >
                            <input type="hidden" name="pere_id" id="pere_id">
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
                            <input type="hidden" name="mere_id" id="mere_id">
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
                            <label for="dateMariageParent">Date Marriage</label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="dateMariageParent" id="dateMariageParent"
                            data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
					<div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>
					<div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_pere">Nom du parain / Maraine <span>*</span></label>
                            <input type="text" name="nom_parain" class="form-control" id="nom_parain" placeholder="Tapez quelques lettres"
                            data-bv-notempty data-bv-notempty-message="Le nom du parrain ne peut pas etre vide"
                            data-bv-message="Le nom du parain est invalide"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                            <input type="hidden" id="parent_bapt_id" name="parent_bapt_id"/>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_pere">Prenom du parrain / Maraine <span>*</span></label>
                            <input type="text" name="prenom_parain" class="form-control" id="prenom_parain" placeholder="Tapez quelques lettres"

                            data-bv-notempty data-bv-notempty-message="Le prenom du parrain ne peut pas etre vide"
                            data-bv-message="Le prenom du parrain est invalide"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le prenom du parrain contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                    </div>
                </div> 
            </div>
            <div class="tab-pane" id="tab3">
                
                <div class="row spaceup">
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
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="lieu_bapt">Lieu Bapteme <span>*</span></label>
                            <input type="text" name="lieu_bapt" class="form-control" id="lieu_bapt" placeholder="Tapez quelques lettres pour selectionner" 
                        data-bv-notempty data-bv-notempty-message="Le lieu de bapteme ne peut pas etre vide">
							<input type="hidden" id="id_lieu_bapteme" name="id_lieu_bapteme"/>
							
                        </div>
                    </div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
                            <label for="date_bapt">Date bapteme <span>*</span></label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_bapt" id="date_bapt"                     
                                data-bv-notempty data-bv-notempty-message="La date de bapteme est requis"
                                data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
					</div>
                    
                </div>
            </div>
            <div class="tab-pane" id="tab4">
                
                <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_celebrant">Nom celebrant <span>*</span></label>
                            <input type="text" name="nom_celebrant" class="form-control" id="nom_celebrant" placeholder="Tapez le nom du celebrant" 

                            data-bv-notempty data-bv-notempty-message="Le nom du celebrant ne peut pas etre vide"
                            data-bv-message="Le nom du celebrant est invalide"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                        
                        <div class="form-group">
                            <label for="lieu_ministere">Lieu du Ministere</label>
                            <input type="text" name="lieu_ministere" class="form-control" id="lieu_ministere">
                            <input type="hidden" id="id_lieu_ministere" name="id_lieu_ministere"/>
                        </div>

                        <div class="form-group">
                            <label for="tel_cel_1">Contact</label>
                            <input type="text" name="contact" class="form-control" id="tel_cel_1" placeholder="Numero de telephone">
                        </div>
                    </div>
    
                    <div class="col-sm-6 col-md-6 col-lg-6">

                        <div class="form-group">
                            <label for="prenom_celebrant">Prenom celebrant <span>*</span></label>
                            <input type="text" name="prenom_celebrant" class="form-control" id="prenom_celebrant" placeholder="Tapez le prenom du celebrant"

                            data-bv-notempty data-bv-notempty-message="Le prenom du celebrant ne peut pas etre vide"
                            data-bv-message="Le prenom du parain est invalide"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
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

