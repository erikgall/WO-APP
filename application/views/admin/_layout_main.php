<?php $this->load->view('admin/includes/header'); ?>
<body>

    <div id="wrapper" class="animated slideInRight">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        	<div class="navbar-filler">

            <div class="navbar-header">
        
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
        
                </button>
        
                <?php echo anchor(site_url(), $this->config->item('meta_title'), 'class="navbar-brand"'); ?>
            </div>
            <!-- /.navbar-header -->
			
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown" id="message_drop">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> 
                        <span class="badge <?php echo ($msg_unread_count > 0) ? 'badge-unread' : 'badge-default'; ?>">
						<?php echo $msg_unread_count; ?> </span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        
                        <li>
	                        <?php echo anchor('admin/dashboard/page/message', '<strong>Read All Messages</strong> <i class="fa fa-angle-right"></i>', 'data-toggle="animate" class="text-center"'); ?>
                            
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown" id="progress_drop">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        
                        
                     
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
                        <li>
							<?php echo anchor(site_url('admin/user/logout'), '<i class="fa fa-sign-out fa-fw"></i> Logout', 'data-toggle="animate"'); ?>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            </div>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                        	<?php echo anchor(site_url(), '<i class="fa fa-dashboard fa-fw"></i> Dashboard', 'data-toggle="animate"'); ?>
                        </li>
                        <li>
							<?php echo anchor('admin/dashboard/page/employee', '<i class="fa fa-user fa-fw"></i> Employees', 'data-toggle="animate"'); ?>
                        
                        </li>
                        <li>
							<?php echo anchor('admin/dashboard/page/client', '<i class="fa fa-child fa-fw"></i> Clients', 'data-toggle="animate"'); ?>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i>Projects/Jobs<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
   								<li>
                                <?php echo anchor('admin/dashboard/page/project', 'All Projects/Jobs', 'data-toggle="animate"'); ?>
                                </li>
                                <li>
                                   <?php echo anchor('admin/dashboard/page/job', 'Project Tasks', 'data-toggle="animate"'); ?>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
							<?php echo anchor('admin/dashboard/page/invoice', '<i class="fa fa-money fa-fw"></i> Invoices', 'data-toggle="animate"'); ?>
                        </li>
                         <li>
							<?php echo anchor('admin/dashboard/page/accounting', '<i class="fa fa-money fa-fw"></i> Bills', 'data-toggle="animate"'); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" class="">
            <?php

				$this->load->view($subview); 
				
			?>
        </div>
        <!-- /#page-wrapper -->
<?php $this->load->view('admin/includes/footer'); ?>