<?php $this->load->view('admin/includes/header'); ?>
<body>

    <div id="wrapper" class="animated slideInRight">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

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
			


            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" class="" style="margin: 0; border:none;">
            <?php $this->load->view($subview); ?>
        </div>
        <!-- /#page-wrapper -->
<?php $this->load->view('admin/includes/footer'); ?>