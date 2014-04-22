<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Roles Permissions</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    
    <div class="alert alert-info ?> alert-dismissable">
        <button type="button" class="close" data-dimiss="alert">&times;</button>
       <p>This page allows you to define what which roles can access to. Toogle permissions you want to assign to a particular role and click save</p>  
    </div>
    
    <?php if($this->session->flashdata('action_message')) : $message = $this->session->flashdata('action_message'); ?>
        <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
            <button type="button" class="close" data-dimiss="alert">&times;</button>
        <?php echo $message['text']; ?>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('notification_message')) : 
            $message = $this->session->flashdata('notification_message');?>
        <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
            <button type="button" class="close" data-dimiss="alert" aria-hidden="true">&times;</button>
            <?php echo $message['text']; ?>
        </div>
    <?php endif; ?>
    <div class="table table-responsive">
        <?php echo form_open('settings/saveRolePermissions')?>    
        <table class="table table-striped table-hovered" id="permissions_table">
            <tr>
                <th>Permission</th>
                <th class="border-right-thin">Description</th>
                <?php foreach($roles as $role) : ?>
                <th class="text-center"><?php echo $role->role_name; ?></th> 
                <?php endforeach; ?>
            </tr>
<?php 
    foreach($permissions as $permission) : 
?>
    <tr>
        <td><?php echo $permission->name; ?></td> 
        <td class="border-right-thin"><?php echo $permission->description; ?></td> 
<?php        
        foreach($roles as $role) :
            $checkbox_value = $role->id_role.','.$permission->permission_id;
            $checked = in_array($checkbox_value, $permissions_values)?'checked="checked"':'';
?>
        <td class="text-center">
            <input name="permissions[]" type="checkbox" value="<?php echo $checkbox_value?>"<?php echo $checked;?> />
        </td>
<?php
    endforeach;
?>
</tr>
<?php
    endforeach;                
?>  
        </table>
        <div class="text-center">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Save
            </button>
        </div>    
        <?php echo form_close();?>
    </div>
</div>
