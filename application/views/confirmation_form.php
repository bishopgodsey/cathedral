<?php if(!$ajax) : ?>
<div class="row">
	<div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($confirmation)?'Modifier la Confirmation ':'Nouveau Confirmation' ; ?>
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
		<i class="fa fa-bar-chart-o fa-fw"></i> Nouveau Confirmation	
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

<form id="confirmation_form" action="<?php echo site_url('sacrement/saveConfirmation'); ?>"  method="post" role="form"
data-bv-message="This value is not valid"
data-bv-feedbackicons-valid="fa fa-check"
data-bv-feedbackicons-invalid="fa fa-times"
data-bv-feedbackicons-validating="fa fa-spinner">
    <div>
        <div class="form-group">
        <div class="col-sm-2 col-md-2 col-lg-2" style="text-align:right">
            <label for="search" class="sr-only">Search</label>
        </div>
        <div class="col-sm-2 col-md-8 col-lg-8">
            <div class="input-group"> 
            <span class="input-group-addon"><span class="fa fa-search fa-lg"></span></span>
            <input type="text" autocomplete="off	" name="search" class="form-control input-lg" id="search" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"
			value="<?php echo $confirmation['num_carte_bapt']."-".$confirmation['nom_bapt']."-".$confirmation['prenom_bapt'];?>"/>
            </div>
        </div>
            <input type="hidden" id="id_communion" name="id_communion" value="<?php echo $confirmation['id_communion'];?>"/>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-md-12">
        <hr />
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">         
            <div class="form-group">
            	<input type="hidden" name="id_confirmation" value='<?php echo $confirmation['id_confirmation']; ?>'/>
                <label for="num_confirmation">Numero Confirmation <span>*</span></label>
                <input type="text" name="num_confirmation" class="form-control" id="num_confirmation" placeholder="Numero de Confirmation"
                data-bv-notempty data-bv-notempty-message="Indiquer le numero de confirmation SVP!" value="<?php echo $confirmation['num_confirmation'];?>"/>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="profession">Profession </label>
                <input type="text" name="professionConfirmation" id="profession" class="form-control" 
                    id="profession" placeholder="Profession du chretien" value="<?php echo $confirmation['professionConfirmation'];?>"/>
            </div>
        </div>
         
        <div class="col-sm-12 col-lg-12 col-md-12">
            <hr />
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
                <label for="lieu_bapt">Lieu Confirmation <span>*</span></label>
                <input type="text" autocomplete="off" name="lieu_conf" class="form-control" id="lieu_conf" placeholder="Tapez quelques lettres pour selectionner" 
            data-bv-notempty data-bv-notempty-message="Le lieu de bapteme ne peut pas etre vide" value="<?php echo $confirmation['lieu_conf'];?>">
                <input type="hidden" id="id_lieu_conf" name="id_lieu_conf" value="<?php echo $confirmation['id_lieu_conf'];?>"/> 
            </div>
        </div>
        
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="date_bapt">Date Confirmation <span>*</span></label>
                <div class="input-group date" data-date-format="YYYY-MM-DD">
                <input autocomplete="off" type="text" class="form-control" name="date_confirmation" id="date_confirmation"                     
                    data-bv-notempty data-bv-notempty-message="La date de bapteme est requis"
                    data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" value="<?php echo $confirmation['date_confirmation']?>"/>
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                </div> 
            </div>
        </div>
        
        <div class="col-sm-12 col-lg-12 col-md-12">
            <hr />
        </div>
        
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="nom_celebrant">Nom celebrant <span>*</span></label>
                <input type="text" name="nom_celebrant" class="form-control" id="nom_celebrant" placeholder="Tapez le nom du celebrant" 

                data-bv-notempty data-bv-notempty-message="Le nom du celebrant ne peut pas etre vide"
                data-bv-message="Le nom du celebrant est invalide"
                data-bv-regexp="true"
                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis" value="<?php echo $confirmation['nom_celebrant'];?>"/>
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
                data-bv-regexp-message="Le nom contient des caracteres invalide. Seuls les lettres, les chiffres et . et _ sont permis" value="<?php echo $confirmation['prenom_celebrant'];?>"/>
            </div>
        </div>
    </div>
        
    <?php if(!$ajax) : ?>
        <div class="row">
		    <div class="center-inline">
               
                <button  class="btn btn-primary" type="submit">
                    <i class="fa fa-save"></i>
                    <?php echo isset($confirmation)?'Update':'Save' ?>
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
<script>
var site_url = '<?php echo base_url()?>';
window._g_site_url = site_url;
window._g_parroisses = JSON.parse('<?php echo json_encode($parroisses); ?>');
console.log(window._g_parroisses);
</script>
