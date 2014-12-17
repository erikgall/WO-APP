    <!-- jQuery Version 1.11.0 -->
	<?php			
		echo script($js['wo_admin']); 
	?>
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	
	$(document).ready(function() {
		$('#dataTables').dataTable(
		<?php if ($this->uri->segment(4) == 'message'): ?>
		{
        	"order": [[ 0, "desc" ]]
    	}<?php endif; ?>
		
		);
		
		$('#message_drop').on('shown.bs.dropdown', function () {
			
			
			$('.dropdown-messages').html('<?php echo img('assets/img/indicator.gif'); ?> loading...');
			
			$.ajax({
				url: '<?php echo site_url(); ?>admin/dashboard/ajax_get/message/navbar_messages/html',
				type: 'POST',
				success: function(html) {
					
					var data = $.parseJSON(html);
					
					var str = '';

					for(var i = 0; i < data.messages.length; i++) {
						var status = '';
						var li = '<li>';
						if (data.messages[i].message_status == '4') {
							status = '<div class="text-right"><strong><i>New Message</i></strong></div>';
							li = '<li class="bg-success">';
						}
						str += li + '<a href="<?php echo site_url('admin/dashboard/page/message/edit'); ?>/'+data.messages[i].message_id+'" data-toggle="animate"><div><strong>'+data.messages[i].message_from+'</strong>- '+data.messages[i].user_type+'<span class="pull-right text-muted"><em>'+data.messages[i].message_timestamp+'</em></span></div><div>'+ data.messages[i].message_title + '</div>'+status+'</a></li><li class="divider"></li>';
						
						
						if ((data.messages.length - i ) == 1) {
							str+= '<li><?php echo anchor('admin/dashboard/page/message', '<strong>Read All Messages</strong> <i class="fa fa-angle-right"></i>', 'data-toggle="animate" class="text-center"'); ?></li>';	
						}
					}
					
					$('.dropdown-messages').html(str);
					
				}
			});
		});
		
		
		$('#progress_drop').on('shown.bs.dropdown', function () {
			
			
		$('.dropdown-tasks').html('<?php echo img('assets/img/indicator.gif'); ?> loading...');
			
			$.ajax({
				url: '<?php echo site_url(); ?>admin/dashboard/ajax_get/job/navbar_open_projects/html',
				type: 'POST',
				success: function(html) {
					
					var data = $.parseJSON(html);
					
					var str = '<li><div style="padding: 5px 20px;"><p><h3 class="text-center">Open Projects/Jobs</h3><span class="pull-right text-muted">Click a project to view the project\'s tasks</span></p><br></div></a></li>';
					

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
					str += '<li><a class="text-center" href="<?php echo site_url("admin/dashboard/page/job"); ?>"><strong>See All Tasks</strong><i class="fa fa-angle-right"></i></a></li>';
					
					$('.dropdown-tasks').html(str);
					
				}
			});
		});
		
		
		<?php if(isset($subview_change)): ?>
		
		$('#page-wrapper').addClass('animated').addClass('slideOutRight');

		$.ajax({
			url: '<?php echo site_url(); ?>admin/dashboard/ajax_edit/' + $("a[data-target='ajax_edit']").attr('data-src') + '/' + '<?php echo $this->uri->segment(6); ?>',
			type: 'GET',

		}).done(function(html) {
			$("#page-wrapper").removeClass('slideOutRight').addClass('slideInRight');
			$( "#page-wrapper" ).html(html);
			window.localStorage.clear();

		});
		
		<?php endif; ?>
	});
	
	
    </script>
</div>
	<?php			
		echo script($js['functions']);
	?>
</body>

</html>