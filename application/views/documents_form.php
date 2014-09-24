<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-file fa-fw"></i>Documents</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">

<div class="panel panel-default"> 
    <div class="panel-heading"> 
        <i class="fa fa-file"></i> Delogation de Bapteme 
    </div>
    <div class="panel-body">

        <form id="confirmation_form" action="<?php echo site_url('sacrement/saveConfirmation'); ?>"  method="post" role="form"
        data-bv-message="This value is not valid"
        data-bv-feedbackicons-valid="fa fa-check"
        data-bv-feedbackicons-invalid="fa fa-times"
        data-bv-feedbackicons-validating="fa fa-spinner">
        <div>
            <div class="form-group">
            <div class="col-sm-2 col-md-2 col-lg-2" style="text-align:right">
                <label for="search" style="margin-top:15px">Search</label>
            </div>
            <div class="col-sm-2 col-md-8 col-lg-8">
                <div class="input-group"> 
                <span class="input-group-addon"><span class="fa fa-search fa-lg"></span></span>
                <input type="text" autocomplete="off" name="search" class="form-control input-lg" id="search" placeholder="Chercher par Numero carte de Bapteme, Nom ou Prenom" data-bv-notempty data-bv-notempty-message="Veuillez selectionner un chretien"/>
                </div>
            </div>
                <input type="hidden" name="id_bapt" id="id_bapt"/>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-md-12">
            <hr />
        </div>

        </form>
    </div>
</div>
</div>
