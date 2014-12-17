<?php 

	if (isset($row->invoice_id)) {
		
		$this->db->where('invoice_id', $row->invoice_id);
		
		$sql = $this->db->get('billing');
		
		if ($sql->num_rows() > 0) {
			
			$bills = $sql->result();
				
		}
		
			
	}
?>
<div class="panel-body">
    
    <div class="col-md-12" id="invoice_header">
    	
    	<div class="col-md-6">
    	
           	<?php echo heading(config_item('business_name', 2)); ?>            
            <h4 class="text-muted text-left">Payment Due By: <?php echo $row->invoice_timestamp; ?></h4>
        </div>
        
        <div class="col-md-6">
        
        	<h2 class="text-right">INVOICE</h2>
            
            <h3 class="text-muted text-right">Invoice #<?php echo $row->invoice_id; ?></h3>
            
        </div>
    
    </div>

	<div class="col-md-12">
	
    	<div class="row">
    	
        	<div class="col-md-4">
        
    			<div class="panel panel-primary">
        	
        		    <div class="panel-heading">
					
                    	<h4>From: <?php echo config_item('business_name'); ?></h4>
        		    
                    </div>
                    
                    <div class="panel-body">
                    
                    	<address class="">
                        	
                            <span class="pull-left">
                            
                            	<strong class="text-left">Address: </strong>
                                <br><br>
								
                                <strong class="text-left">Phone: </strong>
                       		
                            </span>
                            
                            <span class="pull-right">
                            
                            	<strong class="text-right">
                            
								<?php
							
									echo config_item('business_street') . br();
								
									echo config_item('business_city') . ', ' . config_item('business_state') . ' ' . config_item('business_zip');
								
									echo br() . config_item('business_phone');
								?> 
                                
	                    		</strong>

							</span>
                            
                        </address>
                    
                    </div>
        	    
        		</div>
    
    		</div>

    	    <div class="col-md-4 col-md-offset-4">
        
    			<div class="panel panel-primary">
        	
        		    <div class="panel-heading text-right">
						<h4> 
							
							<?php 
								
								$client = $this->data_m->get_client($row->project_id, TRUE);
								
								echo 'To: ' . $client->client_first . ' ' . $client->client_last;
								
							?>
                    	</h4>
        		    </div>

                    <div class="panel-body">
                    
                    	<address class="">
                        	
                            <span class="pull-left">
                            
                            	<strong class="text-left">
                                
                                	Address: <br><br>
									
                                    Phone: 
                                    
                                    </strong>
								
                       		
                            </span>
                            
                            <span class="pull-right">
                            
                            	<strong class="text-right">
                            
								<?php
							
									echo $client->client_street . br();
								
									echo $client->client_city . ', ' . $client->client_state . ' ' . $client->client_zip;
								
									echo br() . $client->client_phone;
								?> 
                                
	                    		</strong>

							</span>
                            
                        </address>
                    
                    </div>
            
        		</div>
    
   	 		</div>
            
            <div class="col-md-12">

	            <div class="table-responsive">
            		
                    <div class="alert alert-danger alert-dismissible hidden" role="alert" id="msg-alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
                       <span style="font-weight:bold;" id="msg"></span>
                        
                    </div>
                    
                    <table class="table table-bordered table-hover text-center items">
        
           				<thead>
        
							<tr>
        
            	        		<th>Name</th>
        	
		                    	<th>Description</th>
        
        		            	<th>Quanity</th>
                    
                		    	<th>Price</th>
                    
                		    	<th>Total Amount</th>
                                
                                <th>&nbsp;</th>
                            
                			</tr>
        
           				</thead>
            
            			<tbody>
                    
                        <?php
                           
                           if (isset($bills)):
                                             
								$total = 0;
								                                                           
                                foreach($bills as $bill):
                                                                                                                    
                                    $bill_amount = 0;
                                    
                                    $bill_amount += ($bill->bill_price * $bill->bill_quanity);
                                    
									$total += ($bill->bill_price * $bill->bill_quanity);
                                                      
                        ?>
                        
                        <tr>
                            <td><?php echo '<a class="editable" data-name="bill_name" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_name.'"></a>'; ?></td>
                            <td><?php echo '<a class="editable" data-name="bill_desc" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_desc.'">'.word_limiter($bill->bill_desc, 60).'</a>'; ?></td>
                            <td><?php echo '<a class="editable" data-name="bill_quanity" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_quanity.'">'.$bill->bill_quanity.'</a>'; ?></td>
                            <td><?php echo '<a class="editable" data-name="bill_price" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_price.'">'.$bill->bill_price.'</a>'; ?></td>
                            <td class="bill_amount"><?php echo '$'.$bill_amount; ?></td>
                            <td><?php echo btn_delete('billing', $bill->bill_id); ?></td>
                        
                        </tr>
                        
                        <?php
							
							endforeach; 
						
							else:
                            
                            	echo '';
                            
                            endif;
                         														
						?>
                        <tr id="new_row">
                        
                            <td><?php echo '<a class="editable add_new" data-name="bill_name" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-value=""></a>'; ?></td>
                            <td><?php echo '<a class="editable add_new" data-name="bill_desc" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-value=""></a>'; ?></td>
                            <td id="new_quanity"><?php echo '<a class="editable add_new" data-name="bill_quanity" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-value=""></a>'; ?></td>
                            <td id="new_price"><?php echo '<a class="editable add_new" data-name="bill_price" data-url="'.site_url("admin/dashboard/ajax_save/billing/").'" data-value=""></a>'; ?></td>
                            <td id="total_amount"></td>
                                                        
                            <td id="btn_cell" class="add_new"><a href="#" class="btn btn-sm btn-success" id="add_bill">Add Item</a>
                        
                        </tr>
                        <?php if (isset($bills)): ?>
                        <tr id="amount_row">
                        	<td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total Amount:</strong></td>
                            <td>$<span id="bill_total"><?php echo $total; ?></span></td> 
                        </tr>
                        
                        <?php endif; ?>
        			    </tbody>
        
        			</table>
            
            
    	        </div>

			</div>
            
		</div>
            
    </div>

</div>