<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Employees/Users</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			
            <div class="panel-heading">
            	<a href="admin/employee/edit" class="btn btn-small btn-success" data-target="ajax_edit" data-src="employee" data-id="">Add New</a>
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

								<th>Name</th>

								<th>Username</th>
	
								<th>Email</th>
                                
                                <th>User Type</th>

								<th>Edit</th>

								<th>Delete</th>

							</tr>

						</thead>
                        
                        <tbody>
                        
                        	<?php
								
								if (isset($rows)):
									foreach($rows as $row):
									
									$user_type = '';
									
									switch ($row->user_type) {
										case 'employee': 
											$user_type = '<span class="label label-info">'.humanize($row->user_type).'</span>';
											break;
										case 'admin':
											$user_type = '<span class="label label-warning">'.humanize($row->user_type).'</span>';
											break;
										case 'super-admin':
											$user_type = '<span class="label label-success">'.humanize($row->user_type).'</span>';
											break;

									}
																
							?>
                        	
                            <tr>
							
								<td><?php echo $row->user_first . " " . $row->user_last; ?></td>
                                <td><?php echo $row->user_username; ?></td>
                                <td><?php echo $row->user_email; ?></td>
                                <td><?php echo $user_type; ?></td>
                                <td><?php echo btn_edit('employee', $row->user_id); ?></td>
                                <td><?php echo btn_delete('employee', $row->user_id); ?></td>
                            
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
<?php echo $this->load->view('admin/includes/page_scripts'); ?>