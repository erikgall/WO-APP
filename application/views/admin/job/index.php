<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Job Tasks</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			
            <div class="panel-heading">
            	<a href="#" class="btn btn-small btn-success" data-target="ajax_edit" data-src="job" data-id="">Add New</a>
            </div>
            
            
			<div class="panel-body">
				<?php 
				
					if (isset($status_msg) AND !empty($status_msg)) {
						echo '<div class="alert alert-warning" role="alert">'.$status_msg.'</div>';
					}
				?>
				<div class="table-responsive">

					<table class="table table-striped table-bordered table-hover text-center" id="dataTables">

						<thead>

							<tr>
                            
								<th>Project</th>

								<th>Task</th>

                            	<th>Status</th>
								
                                <th>Created On</th>
                                
                                <th>Job Assigned</th>

								<th>Edit</th>
                                
                                <th>Delete</th>

							</tr>

						</thead>
                        
                        <tbody>
                        
                        	<?php
								
								if (isset($rows)):
								
									$projects = $this->data_m->get_from('projects');
									
									$assignment = $this->data_m->get_from('assignments');
									foreach($rows as $row):
									
										foreach($projects as $project) {
											
											if ($project->project_id == $row->project_id) {
												
												$project_name = $project->project_name;
												
											}										
										}
										
										$job_assigned = FALSE;
										$assigned = array();
										foreach ($assignment as $assign) {
											$assigned[$assign->job_id] = TRUE;
										}
										$class = 'btn-warning';
										$assigned_icon = '<i class="fa fa-warning"></i> ';
										$assigned_text = 'Assign Task';
										if (array_key_exists($row->job_id, $assigned)) {
											$class = 'btn-success';	
											$assigned_icon = '<i class="fa fa-check"> </i> ';
											$assigned_text = 'Assigned ';

										}
										
										
																
							?>
                        	
                            <tr>
								<td><?php echo $project_name; ?></td>
                                <td><?php echo $row->job_name; ?></td>
                                <td><?php echo btn_status($row->job_status, TRUE); ?></td>							
                                <td><?php echo date('m/d/Y h:i a', strtotime($row->job_timestamp)); ?></td>
                                <td>
                                	<?php if ($row->job_status != 1): ?>
                                    
                                		<a data-toggle="modal" data-id="<?php echo $row->job_id; ?>" data-target="#assign_job" href="#" class="btn btn-sm <?php echo $class; ?>">
											<?php echo $assigned_icon . $assigned_text; ?>
										</a>
                                    
                                    	
                                    <?php endif; ?>
                               	</td>
                                <td><?php echo btn_edit('job', $row->job_id); ?></td>
                                <td><?php echo btn_delete('job', $row->job_id); ?></td>
                            
                            </tr>
                            
                            <?php 
							
									endforeach;

								endif;
								
							?>
                        </tbody>
					
					</table>
				</div>

			</div>

		</div>

	</div>

</div>


<div class="modal" id="assign_job" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal">
                	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>

				<h4 class="modal-title">Assign Jobs</h4>

			</div>
			
            <?php echo form_open('admin/dashboard/ajax_save/assignment', array('role'=>'form', 'class'=>'form-horizontal ajax-form', 'data-target' => 'ajax_save')); ?>
            
			<div class="modal-body">
            	<div class="container-fluid">
                <div class="col-md-12">
                	<h3 class="page-heading">Employees Assigned: </h4>
                </div>
				

					<table class="table table-striped table-bordered table-hover text-center">
                		<thead>
                        	<th>Name</th>
                            <th>Remove</th>
                        </thead>
                        <tbody id="employees_assigned">
                        	
                        </tbody>
	                </table>
				
                
                
				
				<?php 
				
					$options = $this->db->get('users');
					
					if ($options->num_rows() > 0) {
						
						$opt = array();
					
						foreach ($options->result() as $option) {
					
							$opt[$option->user_id] = $option->user_first . " " . $option->user_last;
						
						}
					
					}
					else {
						$opt = array('' => 'No Employees');	
					}

					echo div('form-group');
			
					echo div('input-group');
				
					echo input_addon('Employee'); 

					echo form_dropdown('user_id', $opt, 0, 'class="form-control"');
					
					echo form_hidden('job_id', '');

					echo form_hidden('redirect', 'admin/job/index');
					
					echo div_close();
					
					echo div_close();
				
				?>
</div>
			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	
				<button type="submit" class="btn btn-primary">Save Assignment</button>

			</div>

			<?php echo form_close(); ?>
    
		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<script type="text/javascript">
// save page 
				function confirmDelete() {
					if (confirm('Are you sure you wish to delete item? Once deleted, this item will be removed from the database!') === true) {
						var href = this
						alert($(this).attr('href'));						
					}
					
						return false;	
					
				}

				$('a[data-toggle="modal"]').click(function(e) {
               	
					$('.ajax-form').attr('data-id', $(this).attr('data-id'));
					$('input[name="job_id"]').attr('value', $(this).attr('data-id'));
				
					$.ajax({
						url: '<?php echo site_url("/admin/dashboard/ajax_get/assignment/get_employees");?>/' +  $(this).attr('data-id'),
						type: "GET"
					}).done(function(html) {
						var data = JSON.parse(html);
						if (data != null) {
						var string = '';
   						for (var i = 0; i < data.length; i++) {
							
							var delete_btn = '<a data-id="'+ data[i].job_id+'" data-src="assignment" data-target="ajax_delete" class="btn btn-danger btn-sm" href="<?php echo site_url(); ?>admin/dashboard/ajax_delete/assignment/'+data[i].assignment_id+'/false"><i class="fa fa-times"></i> Delete</a>';
						string += '<tr><td data-id="'+data[i].user_id+'">' + data[i].user_first + ' ' + data[i].user_last + '</td><td>'+delete_btn+'</td></tr>';
							
							
							
						
						}
						
						$('#employees_assigned').html(string);
							$('a[data-target="ajax_delete"]').click(function(e) {
                                e.preventDefault();
								if (confirm('Are you sure you wish to delete item? Once deleted, this item will be removed from the database!') === true) {
									
									$.ajax({
										type: "GET",
										url:$(this).attr('href'),
									}).done(function(html) {
										location.reload();
									});
								}
								else {
									return false;	
								}
								
                            });						
						}
						else {
							$('#employees_assigned').html('');

						}
						
					});
				
				});
					
					$('.ajax-form').submit(function(ev) {
                            
                       
						ev.preventDefault();	
		   				$.ajax({
							url: $(this).attr('action'),
							data: $(this).serialize(),
							type: 'POST',
				
						}).done(function(html) {
  							
							location.reload(true);
							
						});
					
					});
</script>

<?php echo $this->load->view('admin/includes/page_scripts'); ?>