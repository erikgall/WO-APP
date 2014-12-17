
<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Bills</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			
            <div class="panel-heading">
            	<a href="admin/dashboard/accounting/edit" class="btn btn-small btn-success" data-target="ajax_edit" data-src="accounting" data-id="">Add Bill</a>
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
								
                                <th>Bill ID</th>
                                
								<th>Bill Due</th>

								<th>Bill Name</th>
	
								<th>Bill Status</th>
                                                                
                                <th>Amount</th>

								<th>Edit</th>

								<th>Delete</th>

							</tr>

						</thead>
                        
                        <tbody>
                        
                        	<?php
								
								if (isset($rows)):
																	
									$bills = $this->db->get('act_bills');
																		
									foreach($rows as $row):
																											
										$bill_amount = 0;
										
										if ($bills->num_rows() > 0) {
										
											foreach ($bills->result() as $bill) {
																		
												if ($row->act_id == $bill->act_id) {
											
													$bill_amount += ($bill->bill_price * $bill->bill_quanity);
										
												}
									
											}
										}
										
										
																
							?>
                        	
                            <tr>
							
								<td><?php echo $row->act_id; ?></td>
                                <td><?php echo $row->act_date_due; ?></td>
                                <td><?php echo $row->act_name; ?></td>
                                <td><?php echo btn_status($row->act_status); ?></td>
                                <td><?php echo '$'.$bill_amount; ?></td>
                                <td><?php echo btn_edit('accounting', $row->act_id); ?></td>
                                <td><?php echo btn_delete('accounting', $row->act_id); ?></td>
                            
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