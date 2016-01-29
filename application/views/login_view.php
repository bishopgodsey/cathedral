<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OCCI Sacramental Register</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo css_url('bootstrap.min');?>" rel="stylesheet">
    <link href="<?php echo plugin_asset_url('font-awesome/css/font-awesome.css');?>" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?php echo css_url('sb-admin');?>" rel="stylesheet">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo site_url('login/login');?>" method="post">
                            
                        <?php if($this->session->flashdata('notification_message')) : 
                            $message = $this->session->flashdata('notification_message');?>
                            <div class="alert alert-<?php echo $message['type']; ?> alert-dismissable">
                                <button type="button" class="close" data-dimiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $message['text']; ?>
                            </div>
                        <?php endif; ?>

    <div class="panel panel-default">
                            <fieldset>
                                <div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
                                    <input class="form-control" placeholder="Username" name="login" type="text" autofocus>
                                </div>
                                <div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-lock"></i>
									</span>
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button name="log-me-in" class="btn btn-lg btn-success btn-block"><i class="fa fa-unlock"></i> Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo js_url('jquery-1.10.2');?>"></script>
    <script src="<?php echo js_url('bootstrap.min');?>"></script>
	<script src="<?php echo js_url('plugins/metisMenu/jquery.metisMenu');?>"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?php echo js_url('sb-admin');?>"></script>

</body>

</html>
