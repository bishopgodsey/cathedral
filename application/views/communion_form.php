<?php if(!$ajax) : ?>
<div class="row">
	<div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($communion)?'Modifier la Communion ':'Nouveau Communion' ; ?>
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
		<i class="fa fa-bar-chart-o fa-fw"></i> Nouveau Communion	
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

<form id="confirmation_form" action="<?php echo site_url('sacrement/saveCommunion'); ?>"  method="post" role="form"
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
            <input type="text" autocomplete="off" name="search" class="form-control input-lg" id="search" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
            </div>
        </div>
            <input type="hidden" name="id_bapt" id="id_communion"/>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-md-12">
        <hr />
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">         
            <div class="form-group">
                <label for="num_confirmation">Numero Communion <span>*</span></label>
                <input type="text" name="numero_communion" class="form-control" id="num_confirmation" placeholder="Numero de Confirmation"
                data-bv-notempty data-bv-notempty-message="Indiquer le numero de communion SVP!">
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="profession">Profession </label>
                <input type="text" name="profession_communion" id="profession" class="form-control" 
                    id="profession" placeholder="Profession du chretien">
            </div>
        </div>
         
        <div class="col-sm-12 col-lg-12 col-md-12">
            <hr />
        </div>

        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="id_diocese">Diocese<span>*</span></label>
                <select id="id_diocese" name="id_diocese_communion" class="form-control" 
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
                <select id="id_paroisse" name="id_paroisse_communion" class="form-control" 
                    data-bv-notempty data-bv-notempty-message="Vous devez selectionner une parroisse">
                </select>
            </div>
        </div>
        
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="lieu_bapt">Lieu Confirmation <span>*</span></label>
                <input type="text" autocomplete="off" name="lieu_conf" class="form-control" id="lieu_conf" placeholder="Tapez quelques lettres pour selectionner" 
            data-bv-notempty data-bv-notempty-message="Le lieu de bapteme ne peut pas etre vide">
                <input type="hidden" id="id_lieu_conf" name="id_lieu_confirmation"/> 
            </div>
        </div>
        
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="date_bapt">Date Communion <span>*</span></label>
                <div class="input-group date" data-date-format="YYYY-MM-DD">
                <input autocomplete="off" type="text" class="form-control" name="date_communion" id="date_confirmation"                     
                    data-bv-notempty data-bv-notempty-message="La date de bapteme est requis"
                    data-bv-date-format="YYYY-MM-DD" data-bv-date-message="Format de la date Invalide. Ex : 2014-04-23" />
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                </div> 
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
