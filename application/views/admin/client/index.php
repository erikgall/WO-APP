<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Clients</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			
            <div class="panel-heading">
            	<a href="admin/client/edit" class="btn btn-small btn-success" data-target="ajax_edit" data-src="client" data-id="">Add New</a>
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

								<th>Client</th>

								<th>Email</th>
	
								<th>Username</th>

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
							
								<td><?php echo $row->client_first . " " . $row->client_last; ?></td>
                                <td><?php echo $row->client_email; ?></td>
                                <td><?php echo $row->client_username; ?></td>
                                <td><?php echo btn_edit('client', $row->client_id); ?></td>
                                <td><?php echo btn_delete('client', $row->client_id); ?></td>
                            
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