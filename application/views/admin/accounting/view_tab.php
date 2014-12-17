<?php 
	
	$projects = $this->db->order_by('project_name')->get('projects');

	if (!empty($row->act_id)) {

		if ($projects->num_rows() > 0) {
				
			$project_name = '';
			$p_array = array();
			foreach ($projects->result() as $pro) {
				
				 $p_array[$pro->project_id] = $pro;
				
			
			}
			
		}
	
		$projects = $projects->result();
	}

	if (isset($row->act_id)) {
		
		$this->db->where('act_id', $row->act_id);
		
		$sql = $this->db->get('act_bills');
		
		if ($sql->num_rows() > 0) {
			
			$bills = $sql->result();
				
		}
		
			
	}
?>
<div class="panel-body">
    
    <div class="col-md-12" id="invoice_header">
    	
    	<div class="col-md-6">
    	
           	<?php echo heading(config_item('business_name', 2)); ?>            
            <h4 class="text-muted text-left">Payment Due By: <?php echo $row->act_date_due; ?></h4>
        </div>
        
        <div class="col-md-6">
        
        	<h2 class="text-right">BILL</h2>
            
            <h3 class="text-muted text-right">Bill #<?php echo $row->act_id; ?></h3>
            
        </div>
    
    </div>

	<div class="col-md-12">
	
    	<div class="row">
    	
        	<div class="col-md-4">
        
    			<div class="panel panel-primary">
        	
        		    <div class="panel-heading">
					
                    	<h4>To: <?php echo config_item('business_name'); ?></h4>
        		    
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
								
								echo 'To: ' . $row->act_name;
								
							?>
                    	</h4>
        		    </div>

                    <div class="panel-body">
                    
                    	<address class="">
                        	
                            <span class="pull-left">
                            
                            	<strong class="text-left">Bill Due To: </strong>
								
                       		
                            </span>
                            
                            <span class="pull-right">
                            
                            	<strong class="text-right">
                            
								<?php
							
									echo $row->act_name . br(4);
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
                                
                                <th>Project Link</th>
        
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
                                	
									$project_name = '';
									$project_id = '';
									if (isset($p_array[$bill->project_id])) {
										
										$project_name = $p_array[$bill->project_id]->project_name;
										$project_id = $bill->project_id;
									}
									                                                                      
                                    $bill_amount = 0;
                                    
                                    $bill_amount += ($bill->bill_price * $bill->bill_quanity);
                                    
									$total += ($bill->bill_price * $bill->bill_quanity);
                                                      
                        ?>
                        
                        <tr class="bill_row" data-id="<?php echo $bill->bill_id; ?>">
                            <td><?php echo '<a class="editable" data-name="bill_name" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_name.'"></a>'; ?></td>
                            <td><?php echo '<a class="editable" data-name="bill_desc" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_desc.'">'.word_limiter($bill->bill_desc, 60).'</a>'; ?></td>
                            
                            <td><?php echo '<a class="editable" data-type="select" data-name="project_id" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-pk="'.$bill->bill_id.'" data-value="'.$project_id.'" data-source="'.site_url("admin/dashboard/ajax_get/act_bill/editable/projects").'">'.$project_name.'</a>'; ?></td>
                            
                            <td><?php echo '<a class="editable" data-name="bill_quanity" data-url="'.site_url("admin/dashboard/ajax_save/act_bill/").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_quanity.'">'.$bill->bill_quanity.'</a>'; ?></td>
                            
                            <td><?php echo '<a class="editable" data-name="bill_price" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-pk="'.$bill->bill_id.'" data-value="'.$bill->bill_price.'">'.$bill->bill_price.'</a>'; ?></td>
                            <td class="bill_amount"><?php echo '$'.$bill_amount; ?></td>
                            <td><?php echo btn_delete('act_bill', $bill->bill_id); ?></td>
                        
                        </tr>
                        
                        <?php
							
							endforeach; 
						
							else:
                            
                            	echo '';
                            
                            endif;
                         														
						?>
                        <tr id="new_row">
                        
                            <td><?php echo '<a class="editable add_new" data-name="bill_name" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-value=""></a>'; ?></td>
                            <td><?php echo '<a class="editable add_new" data-name="bill_desc" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-value=""></a>'; ?></td>
                            <td><?php echo '<a class="editable add_new" data-type="select" data-name="project_id" data-url="'.site_url("admin/dashboard/ajax_save_act_bill").'" data-value="0" data-source="'.site_url("admin/dashboard/ajax_get/act_bill/editable/projects").'"></a>'; ?></td>
                            <td id="new_quanity"><?php echo '<a class="editable add_new" data-name="bill_quanity" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-value=""></a>'; ?></td>
                            <td id="new_price"><?php echo '<a class="editable add_new" data-name="bill_price" data-url="'.site_url("admin/dashboard/ajax_save/act_bill").'" data-value=""></a>'; ?></td>
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