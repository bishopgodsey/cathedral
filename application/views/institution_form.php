<?php if(!$ajax) : ?>
<div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($institution)?('Change '.$institution_type->nom_type):'Create '.$institution_type->nom_type ; ?>
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
        <i class="fa fa-lock fa-fw"></i> Institution : <?php echo $institution_type->nom_type;?>	
    
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

<?php 

        echo form_open('institution/saveInstitution/'.$institution_type->id_type,'id="institution_form" class="form-horizontal"'); 

        if(! is_null($parent_institution_type)) {
            $selected_parent = isset($institution)?$institution->parent_id:'';
            echo form_dropdown('parent_id',$parent_institutions,$selected_parent,$parent_institution_type->nom_type);        
        }
        echo form_input(array('label'=>'Institution Name',
                            'name'=>'nom_institution',
                            'id'=>'nom_institution',
                            'value'=>(isset($institution)?$institution->nom_institution:'')
                            ));
                            
        echo form_input(array('label'=>'Responsible name',
                            'name'=>'nom_responsable',
                            'id'=>'nom_responsable',
                            'value'=>(isset($institution)?$institution->nom_responsable:'')
                            ));
                            
        echo form_input(array('label'=>'Responsible surname',
                            'name'=>'prenom_responsable',
                            'id'=>'prenom_responsable',
                            'value'=>(isset($institution)?$institution->prenom_responsable:'')
                            ));
        ?>
        <input type="hidden" name="id_institution" id="id_institution" value="<?php echo (isset($institution)?$institution->id_institution:'') ?>" />
        
        <?php if(!$ajax) : ?>
        <div class="row">
            <div class="center-inline">
                <button  class="btn btn-primary" type="submit">
                    <i class="fa fa-save"></i>
                    <?php echo isset($institution)?'Update':'Save' ?>
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

