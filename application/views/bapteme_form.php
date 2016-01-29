<?php if(!$ajax) : ?>
<div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
       <i class="fa fa-tint"></i> <?php echo 'Registration of a New Baptism' ?>
    </h1>
</div>
    <!-- /.col-lg-12 -->
</div>
<?php endif; ?>

<?php if(!$ajax) : ?>
<!-- /.row -->
<div class="row">
<?php endif; ?>
        
<?php

if($this->session->flashdata('notification_message')) :
        $message = $this->session->flashdata('notification_message');?>
    <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
        <button type="button" class="close" data-dimiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message['text']; ?>
    </div>
<?php endif; ?>

     <div id="rootwizard">
        <ul>
            <li><a href="#tab1" data-toggle="tab"><i class="fa fa-user"></i> Personal Information</a></li>
			<li><a href="#tab5" data-toggle="tab"><i class="fa fa-camera"></i> Photo</a></li>
            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-group"></i> Parents</a></li>
            <li><a href="#tab3" data-toggle="tab"><i class="fa fa-tint"></i> Baptism</a></li>
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
                            <label for="categorie">Category <span>*</span></label>
                            <select id="categorie" name="id_categorie" class="form-control" 
                                data-bv-notempty data-bv-notempty-message="The category can not be empty">
                                <option value="1">Infant</option>
                                <option value="2">Adult</option>
                            </select>
                        </div>
                        <div class="form-group">
                        	<input type="hidden" name="id_bapt" value='<?php echo $bapteme->id_bapt; ?>'/>
                            <label for="nom">Name <span>*</span></label>
                            <input type="text" name="nom_bapt" class="form-control" id="nom" placeholder="Enter the name"  value='<?php echo $bapteme->nom_bapt; ?>'
                            data-bv-notempty data-bv-notempty-message="The name can not be empty"
                            data-bv-message="The name is invalid"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="The name contains invalid characters. Only letters, numbers and . and _ are allowed">
                        </div>
 
                        <div class="form-group">
                            <label for="numcarte">Gender <span>*</span></label>
                            <div class="form-control">   
                                <label for="masculin" style="font-weight:normal;">
                                    <input type="radio" checked id="masculin" name="sexe_bapt" value="Masculin"  
                                    data-bv-notempty data-bv-notempty-message="You must select the gender"/>
                                Male
                                </label>
                                <label for="feminin" style="font-weight:normal;">
                                    <input type="radio" id="feminin" name="sexe_bapt" value="Feminin"/>
                                 Female
                                 </label>
                            </div> 
                        </div>

                        <div class="form-group">
                            <label for="domicile">Address <span>*</span></label>
                            <input type="text" name="domicile_bapt" class="form-control" id="domicile" placeholder="Where do you live? " value='<?php echo $bapteme->domicile_bapt; ?>'
                            data-bv-notempty data-bv-notempty-message="Address cannot be blank">
                        </div>

                        <div class="form-group">
                            <label for="tel_fixe">Home Phone</label>
                            <input type="tel" name="tel_fixe" class="form-control" id="tel_fixe" value="<?php echo $bapteme->tel_fixe; ?>" placeholder="Enter the Home Phone">
                        </div>

                        <div class="form-group">
                            <label for="date_naissance">Date of Birth <span>*</span></label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_naissance" id="date_naissance"  value='<?php echo $bapteme->date_naissance; ?>'
                            data-bv-notempty data-bv-notempty-message="Date of Birth is Required"
                            data-bv-date-format="YYYY-MM-DD" data-bv-date-message="The date format is invalid Ex : 2014-04-23" />
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6"> 
                        <div class="form-group">
                            <label for="numcarte">Card Number <span>*</span></label>
                            <input type="text" name="num_carte_bapt" id="numcarte" class="form-control" 
                                id="numcarte" placeholder="Card number"  value='<?php echo $bapteme->num_carte_bapt; ?>'
                                data-bv-notempty="true"
                                data-bv-notempty-message="The number of the card can not be empty" >
                        </div>
                        <div class="form-group">
                            <label for="prenom">First name <span>*</span></label>
                            <input type="text" name="prenom_bapt" class="form-control" id="prenom" placeholder="Enter first name" value='<?php echo $bapteme->prenom_bapt; ?>'
                            data-bv-notempty data-bv-notempty-message="The name can not be empty"
                            data-bv-message="The name is invalid"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="The name contains invalid characters. Only letters, numbers andn. and _ are allowed">
                        </div>

                        <div class="form-group">
                            <label for="professionf">Profession</label>
                            <input type="text" name="professionBapt" class="form-control" id="prefession" value="<?php echo $bapteme->professionBapt;?>" placeholder="Saisissez la profession"> 
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo $bapteme->email;?>"
                            data-bv-emailaddress-message="This email is invalid">
                        </div>

                        <div class="form-group">
                            <label for="tel_mob">Cell Phone</label>
                            <input type="tel" name="tel_mob" class="form-control" id="tel_mob" value="<?php echo $bapteme->tel_mob;?>" placeholder="Cell Phone Number">
                        </div>
                    </div>
               </div> 
            </div>
            <div class="tab-pane" id="tab2">
                <div class="row spaceup">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_pere">Father's name</label>
                            <input type="text" name="nom_pere" class="form-control" id="nom_pere" placeholder="Type a few letters"  value="<?php echo $bapteme->nom_pere;?>" />
                            <input type="hidden" name="pere_id" id="pere_id" >
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_pere">Father's first name</label>
                            <input type="text" name="prenom_pere" class="form-control" id="prenom_pere" placeholder="Type a few letters" value="<?php echo $bapteme->prenom_pere;?>" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_mere">Mother's name</label>
                            <input type="text" name="nom_mere" class="form-control" id="nom_mere" placeholder="Type a few letters" value="<?php echo $bapteme->nom_mere;?>" />
                            <input type="hidden" name="mere_id" id="mere_id">
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_mere">Mother's first name</label>
                            <input type="text" name="prenom_mere" class="form-control" id="prenom_mere" placeholder="Type a few letters" value="<?php echo $bapteme->prenom_mere;?>">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="dateMariageParent">Date of Marriage</label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="dateMariageParent" id="dateMariageParent" value="<?php echo $bapteme->dateMariageParent; ?>"
                            data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Date format is invalid. Ex : 2014-04-23" />
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div> 
                        </div>
                    </div>
					<div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>
					<div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nom_pere">Name of Sponsor / Sponsors <span>*</span></label>
                            <input type="text" name="nom_parain" class="form-control" id="nom_parain" placeholder="Type a few letters" value="<?php echo $bapteme->nom_parrain;?>"
                            data-bv-notempty data-bv-notempty-message="The name of the sponsor can not be empty"
                            data-bv-message="The name of the sponsor is invalid."
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="The name contains invalid characters. Only letters, numbers and. and _ are allowed">
                            <input type="hidden" id="parent_bapt_id" name="parent_bapt_id"/>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="prenom_pere">Surname of the Godfather / Godmother <span>*</span></label>
                            <input type="text" name="prenom_parain" class="form-control" id="prenom_parain" placeholder="Type a few letters" value="<?php echo $bapteme->prenom_parrain;?>"

                            data-bv-notempty data-bv-notempty-message="The surname cannot be empty"
                            data-bv-message="The surname is invalid"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="The surname contains invalid characters. Only letters, numbers and. and _ are allowed">
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
                                data-bv-notempty data-bv-notempty-message="You must select a diocese">
								<?php foreach($dioceses as $diocese) : ?>
									<option value="<?php echo $diocese->id_institution;?>"><?php echo $diocese->nom_institution;?></option>
								<?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="id_paroisse">Parish<span>*</span></label>
                            <select id="id_paroisse" name="id_paroisse" class="form-control" 
                                data-bv-notempty data-bv-notempty-message="You must select a parish">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                    <hr />
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="lieu_bapt">Baptism Location <span>*</span></label>
                            <input type="text" name="lieu_bapt" class="form-control" id="lieu_bapt" placeholder="Type a few letters to select" value="<?php echo $bapteme->lieu_bapteme;?>"
                        data-bv-notempty data-bv-notempty-message="The place of baptism can not be empty">
							<input type="hidden" id="id_lieu_bapteme" name="id_lieu_bapteme"/>
							
                        </div>
                    </div>
					<div class="col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
                            <label for="date_bapt">Date of Baptism <span>*</span></label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_bapt" id="date_bapt" value="<?php echo $bapteme->date_bapt; ?>"                     
                                data-bv-notempty data-bv-notempty-message="The date is required"
                                data-bv-date-format="YYYY-MM-DD" data-bv-date-message="The date format is invalid. Ex : 2014-04-23" />
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
                            <label for="nom_celebrant">Celebrant's Name <span>*</span></label>
                            <input type="text" name="nom_celebrant" class="form-control" id="nom_celebrant" placeholder="Enter the name of the celebrant" value="<?php echo $bapteme->nom_celebrant;?>"

                            data-bv-notempty data-bv-notempty-message="The name of the celebrant cannot be empty"
                            data-bv-message="The name of the celebrant is invalid"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="The name contains invalid characters. Only letters, numbers and . and _ are allowed">
                        </div>
                        
                        <div class="form-group">
                            <label for="lieu_ministere">Location of Celebrant</label>
                            <input type="text" name="lieu_ministere" class="form-control" id="lieu_ministere" value="<?php echo $bapteme->id_lieu_ministere; ?>" />
                            <input type="hidden" id="id_lieu_ministere" name="id_lieu_ministere" value="<?php echo $bapteme->id_lieu_ministere; ?>/>
                        </div>

                        <div class="form-group">
                            <label for="tel_cel_1">Contact</label>
                            <input type="text" name="contact" class="form-control" id="tel_cel_1" placeholder="Telephone Number" value="<?php echo $bapteme->contact;?>" />
                        </div>
                    </div>
    
                    <div class="col-sm-6 col-md-6 col-lg-6">

                        <div class="form-group">
                            <label for="prenom_celebrant">Celebrant's Last Name <span>*</span></label>
                            <input type="text" name="prenom_celebrant" class="form-control" id="prenom_celebrant" placeholder="Last Name of the Celebrant" 
                            value="<?php echo $bapteme->prenom_celebrant;?>"

                            data-bv-notempty data-bv-notempty-message="Last name cannot be empty"
                            data-bv-message="Last name is invalid"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="The name contains invalid characters. Only letters, numbers and . and _ are allowed">
                        </div>

                        <div class="form-group">
                            <label for="service">Service</label>
                            <input type="text" name="service" class="form-control" id="service" value="<?php echo $bapteme->service;?>" />
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

