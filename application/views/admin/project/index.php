<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Projects/Jobs</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			
            <div class="panel-heading">
            	<a href="../client/admin/client/edit" class="btn btn-small btn-success" data-target="ajax_edit" data-src="project" data-id="">Add New</a>
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
                            
                            	<th>Status</th>

								<th>Project</th>

								<th>Client</th>
								
                                <th>Project Tasks/Progress</th>

								<th>Edit</th>

								<th>Delete</th>

							</tr>

						</thead>
                        
                        <tbody>
                        
                        	<?php
								
								if (isset($rows)):
									
									foreach($rows as $row):
																
							?>
                        	
                            <tr>

                                <td><?php echo btn_status($row->project_status, TRUE); ?></td>							
								<td><?php echo $row->project_name; ?></td>
                                <td><?php echo $this->data_m->get_client_name($row->client_id); ?></td>
                                <td><?php echo anchor('admin/dashboard/page/job/project_id/'.$row->project_id, '<i class="fa fa-flag-checkered"></i> View Progress', 'class="btn btn-sm btn-success" data-toggle="animate"'); ?></td>
                                <td><?php echo btn_edit('project', $row->project_id); ?></td>
                                <td><?php echo btn_delete('project', $row->project_id); ?></td>
                            
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