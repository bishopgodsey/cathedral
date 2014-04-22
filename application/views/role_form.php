<?php if(!$ajax) : ?>
<div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($permission)?'Change User Roles ':'Create User roles' ; ?>
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
        <i class="fa fa-group fa-fw"></i> Roles	
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

        echo form_open('settings/saveRole','id="role_form" class="form-horizontal"'); 
        
        echo form_input(array('label'=>'Role name',
                            'name'=>'role_name',
                            'id'=>'role_name',
                            'value'=>(isset($role)?$role->role_name:'')
                            ));
                            
        echo form_input(array('label'=>'Role Description',
                            'name'=>'description',
                            'id'=>'role_description',
                            'value'=>(isset($role)?$role->description:'')
                            ));
                            
        ?>
        <input type="hidden" name="id_role" id="id_role" value="<?php echo (isset($role)?$role->id_role:'') ?>" />
        <?php 
            
            echo form_checkbox_label(array(
                'label'   => 'Can Be deleted',
                'id'      => 'can_delete',
                'name'    => 'can_delete',
                'checked' => 'checked',
                'tooltip' => 'Allow this role to be deleted'
            ));
        ?>
        <?php if(!$ajax) : ?>
        <div class="row">
            <div class="center-inline">
                <button  class="btn btn-primary" type="submit">
                    <i class="fa fa-save"></i>
                    <?php echo isset($role)?'Update':'Save' ?>
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

