<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>

	<?php foreach($css as $url): ?>
	<link rel="stylesheet" href="<?php echo $url; ?>" />
	<?php endforeach; ?>

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url();?>"><?php echo ucfirst($this->config->item('app_title'));?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <?php echo isset($menu['top'])?$menu['top']:''; ?>
            </ul>
            <!-- /.navbar-top-links -->

        </nav>
        <!-- /.navbar-static-top -->

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <?php echo isset($menu['left'])?$menu['left']:''; ?>
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->

        <div id="page-wrapper">
            <?php echo isset($output)?$output:''; ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <?php foreach($js as $url): ?>
	<script src="<?php echo $url; ?>"></script>
	<?php endforeach; ?>

</body>

</html>
