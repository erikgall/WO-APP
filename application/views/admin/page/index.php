<div class="row">

	<div class="col-lg-12">

		<h1 class="page-header">Welcome To The WO APP</h1>

	</div><!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">

			<div class="panel-body">
            	
                <div class="col-md-6">
         
         		   	<div class="panel panel-default">                
             
             			<div class="panel-heading">
                        Open Projects/Jobs
                        </div>
                        
         				<div class="panel-body">
         
         	 			    <ul class="list-unstyled list-group" id="open-jobs">
                
                
            	    		</ul>            
            
            			</div>
                
                	</div>
                    
                </div>
                
                
                <div class="col-md-6">
         
         		   	<div class="panel panel-default">                
             
             			<div class="panel-heading">
                        Message Inbox
                        </div>
             
         				<div class="panel-body">
         
         	 			    <ul class="list-unstyled list-group" id="new-messages">
                
                
            	    		</ul>            
            
            			</div>
                
                	</div>
                    
                </div>
                
            </div>
            
            
		</div><!-- /.panel-default -->

	</div><!-- /.panel -->

</div><!-- /.col-lg-12 -->


<script type="text/javascript">
$(document).ready(function(e) {			
			
			$('#new-messages').html('<?php echo img('assets/img/indicator.gif'); ?> loading...');
			
			$.ajax({
				url: '<?php echo site_url(); ?>admin/dashboard/ajax_get/message/navbar_messages/html',
				type: 'POST',
				success: function(html) {
					
					var data = $.parseJSON(html);
					
					var str = '';

					for(var i = 0; i < data.messages.length; i++) {
						var status = '';
						var li = '<li class="list-group-item">';
						if (data.messages[i].message_status == '4') {
							status = '<div class="text-right"><strong><i>New Message</i></strong></div>';
							li = '<li class="bg-success list-group-item">';
						}
						str += li + '<a href="<?php echo site_url('admin/dashboard/page/message/edit'); ?>/'+data.messages[i].message_id+'" data-toggle="animate"><div><strong>'+data.messages[i].message_from+'</strong>- '+data.messages[i].user_type+'<span class="pull-right text-muted"><em>'+data.messages[i].message_timestamp+'</em></span></div><div>'+ data.messages[i].message_title + '</div>'+status+'</a></li><li class="divider"></li>';
						
						
						if ((data.messages.length - i ) == 1) {
							str+= '<li class="list-group-item"><?php echo anchor('admin/dashboard/page/message', '<strong>Read All Messages</strong> <i class="fa fa-angle-right"></i>', 'data-toggle="animate" class="text-center"'); ?></li>';	
						}
					}
					
					$('#new-messages').html(str);
					
				}
			});
		
		
		$('#open-jobs').html('<?php echo img('assets/img/indicator.gif'); ?> loading...');
			
			$.ajax({
				url: '<?php echo site_url(); ?>admin/dashboard/ajax_get/job/navbar_open_projects/html',
				type: 'POST',
				success: function(html) {
					
					var data = $.parseJSON(html);
					
					var str = '';
					

					for(var i = 0; i < data.length; i++) {
						var status = '';
						var complete = (data[i].complete / data[i].job_count); 
						var css = 'warning';
						if (isNaN(complete) == true) {
							complete = 0;	
							css = 'danger';
						}
						else {
							complete = complete * 100;	
							if (complete == 100) {
								
								css = 'success';
							}
						}
						

						str += '<li><a href="<?php echo site_url("admin/dashboard/page/job/project_id"); ?>/'+data[i].project_id+'"><div><p><strong>'+data[i].project_name+'</strong><span class="pull-right text-muted">'+complete+'% Complete</span></p><div class="progress progress-striped active"><div class="progress-bar progress-bar-'+css+'" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '+complete+'%"><span class="sr-only">'+complete+'% Complete (success)</span></div></div></div></a></li>';
					
						
					}
					str += '<li class="text-center"><a class="text-center" href="<?php echo site_url("admin/dashboard/page/job"); ?>"><strong>See All Tasks</strong></a></li>';
					
					$('#open-jobs').html(str);
					
				}
			});
		});

</script>