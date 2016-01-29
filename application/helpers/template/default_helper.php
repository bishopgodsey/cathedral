<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
	
	/**
	* returns an array of js file needed to be included in the whole application.
	* This is basically jquery and bootstrap in case of this template
	*/
	function get_default_js() {
		
		$js = array();
		
		$js[] = js_url('jquery-1.10.2');
		$js[] = js_url('bootstrap.min');
		$js[] = js_url('plugins/metisMenu/jquery.metisMenu');
		$js[] = js_url('jquery.noty.packaged.min');
		
		return $js;
	}
	
	function get_default_css() {
		$css = array();
		
		$css[] = css_url('bootstrap.min');
		$css[] = plugin_asset_url('font-awesome/css/font-awesome.css');
		$css[] = css_url('sb-admin');
		
		return $css;
	
	}
	
	function get_default_left_menu() {
		$output = '
		
			<li class="sidebar-search">
				<div class="input-group custom-search-form">
					<input type="text" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
				<!-- /input-group -->
			</li>
			<li>
				<a href="'.site_url('').'"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
			</li>
			<!--<li>
				<a href="tables.php"><i class="fa fa-table fa-fw"></i> Statistics</a>
			</li>-->
			<li>
				<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Churches<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="'.site_url('institution/type/1').'">Diocese</a>
					</li>
					<li>
						<a href="'.site_url('institution/type/2').'">Parish</a>
					</li>
					<li>
						<a href="'.site_url('institution/type/3').'">Chapel</a>
					</li>
					<li>
                    <a href="'.site_url('institution/type/4').'">Branch</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
			
			<!--<li>
				<a href="forms.html"><i class="fa fa-edit fa-fw"></i><span class="fa arrow"></span> Finances</a>
				<ul class="nav nav-second-level">
					<li>
						<a href="panels-wells.html">Imperezwa</a>
					</li>
					<li>
						<a href="panels-wells.html">Ledger</a>
					</li>
				</ul>
			</li>-->
			<li>
				<a href="#"><i class="fa fa-wrench fa-fw"></i> Sacraments<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="'.site_url('sacrement/bapteme').'">Baptism</a>
					</li>
					<li>
                    <a href="'.site_url('sacrement/communions').'">Communion</a>
					</li>
					<li>
						<a href="'.site_url('sacrement/confirmations').'">Confirmation</a>
					</li>
					<li>
                        <a href="'.site_url('sacrement/marriage').'">Marriage</a>
					</li>
					<li>
                        <a href="'.site_url('sacrement/deces').'">Death</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
			<li>
				<a href="#"><i class="fa fa-sitemap fa-fw"></i> Documents<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					
					<li>
						<a href="#">Baptism <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li>
								<a href="#">Delegation of Baptism</a>
							</li>
							<li>
								<a href="#">Taken from Baptism</a>
							</li>
							
						</ul>
						<!-- /.nav-third-level -->
					</li>
					<li>
						<a href="#">Marriage <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li>
								<a href="#">Delegation of Marriage</a>
							</li>
							<li>
								<a href="#">Certificate of Marriage</a>
							</li>
							<li>
								<a href="#">Dispense de Marriage</a>
							</li>
							<li>
								<a href="#">Banc de Marriage</a>
							</li>
							<li>
								<a href="#">Status Animatorium</a>
							</li>
						</ul>
						<!-- /.nav-third-level -->
					</li>
					<!--<li>
						<a href="#">Other documents</a>
					</li>
					<li>
						<a href="#">Second Level Item</a>
					</li>-->
				</ul>
				<!-- /.nav-second-level -->
			</li>
			<li>
				<a href="#"><i class="fa fa-files-o fa-fw"></i> Settings<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="'.site_url('settings/users/').'">Users</a>
					</li>
					<li>
						<a href="'.site_url('settings/permissions').'">Permissions</a>
					</li>
					<li>
						<a href="'.site_url('settings/rolePermissions').'">Manage Permissions</a>
					</li>
					<li>
						<a href="'.site_url('settings/roles/').'">Roles</a>
					</li>
					<li>
						<a href="login.html">Application Settings</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
		
		';
		
		return $output;
	}
	
	function get_left_menu($menus) {
		$menus = array('Dashbord'=>'Dashbord',
						'Charts'=>array('Flot Charts'=>'Flot Charts','Moris.js'=>'Moris.js'),
						'Tables'=>'Table',
						'Forms'=>'Forms',
						'UI Elements'=>array(
							'Panels and Wells'=>'Panels and Wells',
							'Buttons'=>'Buttons',
							'Notifications'=>'Notifications',
						),
						'Sample Pages'=>'Sample Page');
	}
	
	function get_default_top_menu() {
		$output = '
		
			<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="'.site_url('login/logout').'"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
		';
		
		return $output;
	}
	
	function get_top_menu() {
		
	}
