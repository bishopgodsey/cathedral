<?php if(!$ajax) : ?>
<div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($permission)?'Change System permission ':'Create System permission' ; ?>
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
        <i class="fa fa-lock fa-fw"></i> Permission	
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

        echo form_open('settings/savePermission','id="permission_form" class="form-horizontal"'); 
        
        echo form_input(array('label'=>'Permission name',
                            'name'=>'name',
                            'id'=>'permission_name',
                            'value'=>(isset($permission)?$permission->name:'')
                            ));
                            
        echo form_input(array('label'=>'Permission Description',
                            'name'=>'description',
                            'id'=>'description',
                            'value'=>(isset($permission)?$permission->description:'')
                            ));
                            
        ?>
        <input type="hidden" name="permission_id" id="permission_id" value="<?php echo (isset($permission)?$permission->permission_id:'') ?>" />
        <?php 
            echo form_dropdown('status',array('active'=>'Active','inactive'=>'Inactive'),isset($permission)?$permission->status:array(),'Status');
        ?>
        <?php if(!$ajax) : ?>
        <div class="row">
            <div class="center-inline">
                <button  class="btn btn-primary" type="submit">
                    <i class="fa fa-save"></i>
                    <?php echo isset($permission)?'Update':'Save' ?>
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

