<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Invoices</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			
            <div class="panel-heading">
            	<a href="admin/invoice/edit" class="btn btn-small btn-success" data-target="ajax_edit" data-src="invoice" data-id="">Add New</a>
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
								
                                <th>Invoice ID</th>
                                
								<th>Invoice Date</th>

								<th>Invoice Status</th>
	
								<th>Project</th>
                                
                                <th>Client</th>
                                
                                <th>Amount</th>

								<th>Edit</th>

								<th>Delete</th>

							</tr>

						</thead>
                        
                        <tbody>
                        
                        	<?php
								
								if (isset($rows)):
									
									$projects = $this->db->get('projects');
								
									$clients = $this->db->get('clients');

									$bills = $this->db->get('billing');
																		
									foreach($rows as $row):
										
										$client_id = '';
										
										$invoice_project = '';
									
										if ($projects->num_rows > 0) {
									
											foreach ($projects->result() as $project) {												
																			
												if ($row->project_id == $project->project_id) {
										
													$invoice_project = $project->project_name;	
										
													$client_id = $project->client_id;
										
												}
										
											}
										}
										
										
										$client_name = '';
										
										if ($clients->num_rows() > 0) {
										
											foreach ($clients->result() as $client) {
										
									
												if ($client->client_id == $client_id) {
											
													$client_name = $client->client_first . ' ' . $client->client_last;	
										
												}
									
											}
										}
										
										$bill_amount = 0;
										
										if ($bills->num_rows() > 0) {
										
											foreach ($bills->result() as $bill) {
																		
												if ($row->invoice_id == $bill->invoice_id) {
											
													$bill_amount += ($bill->bill_price * $bill->bill_quanity);
										
												}
									
											}
										}
										
										
																
							?>
                        	
                            <tr>
							
								<td><?php echo $row->invoice_id; ?></td>
                                <td><?php echo $row->invoice_timestamp; ?></td>
                                <td><?php echo btn_status($row->invoice_status); ?></td>
                                <td><?php echo $invoice_project; ?></td>
                                <td><?php echo $client_name; ?></td>
                                <td><?php echo '$'.$bill_amount; ?></td>
                                <td><?php echo btn_edit('invoice', $row->invoice_id); ?></td>
                                <td><?php echo btn_delete('invoice', $row->invoice_id); ?></td>
                            
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