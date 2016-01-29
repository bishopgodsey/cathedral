<?php if(!$ajax) : ?>
<div class="row">
	<div class="col-lg-12">
    <h1 class="page-header">
        <?php echo isset($user)?'Change User Account ':'Create User Account' ; ?>
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
		<i class="fa fa-bar-chart-o fa-fw"></i> Account details	
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

<?php echo form_open('settings/saveUser','id="user_form" class="form-horizontal"'); ?>
		<div >
			<h4 class="page-header">Credentials</h4>
		</div>
		<?php 
		
		echo form_input(array('label'=>'Email',
							'name'=>'email',
							'id'=>'email',
							'value'=>(isset($user)?$user->email:'')
							));

		echo form_input(array('label'=>'First Name',
							'name'=>'nom',
							'id'=>'nom',
							'value'=>(isset($user)?$user->nom:'')
							));
							
		echo form_input(array('label'=>'Last Name',
							'name'=>'prenom',
							'id'=>'prenom',
							'value'=>(isset($user)?$user->prenom:'')
							));

		echo form_input(array('label'=>'Display Name',
							'name'=>'display_name',
							'id'=>'display_name',
							'value'=>(isset($user)?$user->display_name:'')
							));
							
		echo form_input(array('label'=>'Username',
							'name'=>'username',
							'id'=>'username',
							'value'=>(isset($user)?$user->username:'')
							));
							
		echo form_password(array('label'=>'Password',
							'name'=>'password_hash',
							'id'=>'password_hash',
							
							));
							
        ?>
        <input type="hidden" name="id" id="user_id" value="<?php echo (isset($user)?$user->id:'') ?>" />
		<div>
			<h4 class="page-header">Role</h4>
		</div>
		<?php 
			echo form_dropdown('role_id',array('0'=>'Select','1'=>'Admin','2'=>'User','3'=>'Guest'),isset($user)?$user->role_id:array(),'User role','','Select the role of the user');
		?>
        <?php if(!$ajax) : ?>
        <div class="row">
		    <div class="center-inline">

                <button  class="btn btn-primary" type="submit">
                    <i class="fa fa-save"></i>
                    <?php echo isset($user)?'Update':'Save' ?>
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
