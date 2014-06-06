<?php if(!$ajax) : ?>
<div class="row">
	<div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($deces)?'Modifier Deces ':'Nouveau Deces' ; ?>
    </h1>
</div>
	<!-- /.col-lg-12 -->
</div>
<?php endif; ?>

<?php if(!$ajax) : ?>
<!-- /.row -->
<div class="row">
<?php endif; ?>
<?php if(!$ajax) : ?>
<div class="panel panel-default">
	<div class="panel-heading">		
		<i class="fa fa-bar-chart-o fa-fw"></i> Nouveau Deces	
	</div>
	<div class="panel-body">		
<?php endif; ?>
		
<?php if($this->session->flashdata('notification_message')) : 
        $message = $this->session->flashdata('notification_message');?>
    <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
        <button type="button" class="close" data-dimiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message['text']; ?>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('action_message')) : 
        $message = $this->session->flashdata('action_message');?>
    <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
        <button type="button" class="close" data-dimiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message['text']; ?>
    </div>
<?php endif; ?>
<?php echo validation_errors(); ?>
<form id="deces_form" action="<?php echo site_url('sacrement/saveDeces'); ?>"  method="post" role="form"
data-bv-message="This value is not valid"
data-bv-feedbackicons-valid="fa fa-check"
data-bv-feedbackicons-invalid="fa fa-times"
data-bv-feedbackicons-validating="fa fa-spinner">
    <div class="row"> 
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <label>Categorie </label>
                </div>
                <div class="col-sm-8 col-md-8 col-lg-8">
                    <div>
                        <label style="font-weight:normal">
                            <input type="radio" value="chretien" id="chretien" checked name="type_personne"/>
                            Catholique
                        </label>
                    </div>
                    <div>
                        <label style="font-weight:normal">
                            <input type="radio" id="no_chretien" value="no_chretien" name="type_personne"/>
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
                    <input type="text" autocomplete="off" name="search" class="form-control" id="search" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
                </div>
                <input type="hidden" name="id_bapt" id="id_bapteme"/>
                <input type="hidden" name="id_nonBaptise" id="id_nonBaptise"/>
            </div>
        </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-md-12">
            <hr />
        </div>
        <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">         
            <div class="form-group">
                <label for="num_enterrement">Numero de l'enterrement <span>*</span></label>
                <input type="text" name="num_enterrement" class="form-control" id="num_enterrement" placeholder="Numero de deces"
                data-bv-notempty data-bv-notempty-message="Indiquer le numero de deces SVP!">
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="date_deces">Date Deces <span>*</span></label>
                <div class="input-group date" data-date-format="YYYY-MM-DD">
                <input autocomplete="off" type="text" class="form-control" name="date_deces" id="date_deces"             
                    data-bv-notempty data-bv-notempty-message="La date de deces est requis"
                    data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                </div> 
            </div>
        </div>
        </div>
        <div class="row"> 
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="date_enterrement">Date Enterrement <span>*</span></label>
                <div class="input-group date" data-date-format="YYYY-MM-DD">
                <input autocomplete="off" type="text" class="form-control" name="date_enterrement" id="date_enterrement"             
                    data-bv-notempty data-bv-notempty-message="La date de l'enterrement est requis"
                    data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                </div> 
            </div>
        </div>
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
        </div>
        <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="id_paroisse">Parroisse<span>*</span></label>
                <select id="id_paroisse" name="id_paroisse" class="form-control" 
                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner une parroisse">
                </select>
            </div>
        </div>
        
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="lieu_bapt">Lieu <span>*</span></label>
                <input type="text" autocomplete="off" name="lieu_cel" class="form-control" id="lieu_cel" placeholder="Tapez quelques lettres pour selectionner" 
            data-bv-notempty data-bv-notempty-message="Le lieu de bapteme ne peut pas etre vide">
                <input type="hidden" id="id_lieu" name="id_lieu_cel"/> 
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
                <input type="text" name="nom_celebrant" class="form-control" id="nom_celebrant" placeholder="Tapez le nom du celebrant" 

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
                <input type="text" name="prenom_celebrant" class="form-control" id="prenom_celebrant" placeholder="Tapez le prenom du celebrant"

                data-bv-notempty data-bv-notempty-message="Le prenom du celebrant ne peut pas etre vide"
                data-bv-message="Le prenom du parain est invalide"
                data-bv-regexp="true"
                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
            </div>
        </div>
    </div>
        
    <?php if(!$ajax) : ?>
        <div class="row">
		    <div class="center-inline">
                <span id="saveDeces_loader"></span>
                <button  class="btn btn-primary" id="saveDeces" type="submit">
                    <i class="fa fa-save"></i>
                    <?php echo isset($deces)?'Update':'Save' ?>
                </button>
                <button  class="btn btn-default previous" type="button"><i class="fa fa-times-circle-o"></i> Cancel</button>
            </div>
        </div>
	<?php endif; ?>
<?php echo form_close(); ?>
		
<?php if(!$ajax) : ?>
	</div>
	
</div>
<?php endif; ?>
<?php if(!$ajax) : ?>
</div>
<?php endif; ?>
<!-- Persone modal panel -->

<div id="createPersonneModal"class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">	
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Informations personnelles</h4>
        </div>
        <div class="modal-body">
            
            <form id="personne_form" action="<?php echo site_url('sacrement/saveDeces'); ?>"  method="post" role="form"
            data-bv-message="This value is not valid"
            data-bv-feedbackicons-valid="fa fa-check"
            data-bv-feedbackicons-invalid="fa fa-times"
            data-bv-feedbackicons-validating="fa fa-spinner">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">         
                        <div class="form-group">
                            <label for="nom">Nom <span>*</span></label>
                            <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom"
                            data-bv-notempty data-bv-notempty-message="Indiquer le nom SVP!"
                            data-bv-regexp="true"
                            data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                            data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">         
                        <div class="form-group">
                            <label for="prenom">Prenom <span>*</span></label>
                            <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prenom"
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
                            <label for="numcarte">Sexe <span>*</span></label>
                            <div class="form-control">   
                                <label for="masculin" style="font-weight:normal;">
                                    <input type="radio" checked id="masculin" name="sexe" value="Masculin" 
                                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner le genre"/>
                                Masculin
                                </label>
                                <label for="feminin" style="font-weight:normal;">
                                    <input type="radio" id="feminin" name="sexe" value="Feminin"/>
                                Feminin
                                </label>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="date_naissance">Date de Naissance </label>
                            <div class="input-group date" data-date-format="YYYY-MM-DD">
                            <input autocomplete="off" type="text" class="form-control" name="date_naissance" id="date_naissance"             
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
                            <input id="adresse" placeholder="Adresse" name="adresse" class="form-control" /> 
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="tel">Telephone </label>
                            <input id="tel" type="tel" placeholder="Numero de Telephone" name="tel" class="form-control"
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
                            <input type="email" name="email" class="form-control" id="email" placeholder="Saisissez l'email"
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
            </form> 
        </div>
        <div class="modal-footer">
            <span id="savePersonne_loader"></span> 
            <button type="button" class="btn btn-primary" id="savePersonne"><i class="fa fa-save"></i> Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<!-- end personne modal -->

<script>
var site_url = '<?php echo base_url()?>';
window._g_site_url = site_url;
window._g_parroisses = JSON.parse('<?php echo json_encode($parroisses); ?>');
console.log(window._g_parroisses);
</script>
