<div class="row">
	<div class="col-lg-12">
    <h1 class="page-header">Institution : <?php echo $institution_type->nom_type; ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> List of <?php echo $institution_type->nom_type; ?>
        <div class="pull-right">
            <?php if(has_permission('Institutions.Add')) : ?>
            <a title="Add new <?php echo $institution_type->nom_type; ?>" id="createInstitution" class="btn btn-primary panel-header-btn" href="<?php echo site_url('institution/create/'.$institution_type->id_type);?>"><i title="Add new <?php echo $institution_type->nom_type; ?>" class="fa fa-plus-circle"></i> New <?php echo $institution_type->nom_type; ?></a>
            <?php endif; ?>
        </div>
    </div>
	<div class="panel-body">
        <?php if($this->session->flashdata('action_message')) : 
            $message = $this->session->flashdata('action_message'); ?>
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
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
					<th><?php echo form_checkbox('select_all','select_all[]',FALSE,'id="select_all"'); ?></th>
					<?php foreach($institution_columns as $column) : ?>
						<th><?php echo $column; ?></th>
					<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($institutions as $institution) : ?>
						<tr>
							<td><?php echo form_checkbox('select_all','select_all[]'); ?></td>
                            <td><?php echo $institution->nom_institution; ?></td>
                            <?php if($institution->parent_id && count($parent_institutions)>0 ) :  ?>
                            <td><?php echo $parent_institutions[$institution->parent_id]; ?></td>
                            <?php endif; ?>
                            <td><?php echo $institution->nom_responsable; ?></td>
							<td><?php echo $institution->prenom_responsable; ?></td>
                            <?php 
                            if(has_permission('Institutions.Edit') || has_permission('Institutions.Delete')) : ?>
                            <td>
                                <?php if(has_permission('Institutions.Edit')) :  ?>
                                <a class="btn btn-info edit" href="<?php echo site_url('institution/edit/'.$institution_type->id_type.'/'.$institution->id_institution);?>"><i class="fa fa-edit"></i> Edit</a>
                                <?php endif; ?>
                                <?php if(has_permission('Institutions.Delete')) :  ?>
                                <a class="btn btn-danger delete" href="<?php echo site_url('institution/delete/'.$institution_type->id_type.'/'.$institution->id_institution);?>"><i class="fa fa-trash-o"></i> Delete</a>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-lg-12 col-12 col-sm-12">
				<?php echo form_checkbox('select_all','select_all[]',FALSE,'id="select_all_table"'); ?>
				<?php echo form_label('Check All','select_all_table'); ?>
				
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> With Selected <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
					  <li><a href="#"><i class="fa fa-check"></i> Activate</a></li>					  
					  <li><a href="#"><i class="fa fa-minus-circle"></i> Deactivate</a></li>
					  <li><a href="#"><i class="fa fa-ban"></i> Ban</a></li>
					  <li class="divider"></li>
					  <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
					</ul>
				</div><!-- /btn-group -->

			</div>
		</div>
</div>
</div>
