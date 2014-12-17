<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">
		
		<?php echo empty($row->project_id) ? 'Add a Project/Job' : 'Edit Project/Job: ' . $row->project_name; ?></h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="panel panel-default">

	<?php 
		if (empty($row->project_id)) {
			$data_id = '';	
		}
		else {
			$data_id = $row->project_id;	
		}
		echo form_open('', array('role'=>'form', 'class'=>'form-horizontal ajax-form', 'data-target' => 'ajax_save', 'data-id'=>$data_id)); 
		
	?>

		<div class="panel-body">
  			
            <?php if (isset($success) AND $success == TRUE): ?>
    		<div class="alert alert-success alert-dismissible" role="alert">
            
            	<button type="button" class="close" data-dismiss="alert">
            		<span aria-hidden="true">&times;</span>
                	<span class="sr-only">Close</span>
				</button>

				<strong>Success!</strong> The data was saved successfully.

			</div>
            <?php endif; ?>
    		<?php 
				echo validation_errors();
				echo div('col-lg-10 col-sm-12');

				/*******************************************************
				* First Name Input
				*******************************************************/
				
				$name_attr = array(
					'name' => 'project_name',
					'id' => 'project_name',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('client_first', $row->project_name),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Project Name'); 
				
				echo form_input($name_attr);
				
				echo div_close(); 
								
				echo div_close(); 
			

				/*******************************************************
				* Client Select
				*******************************************************/
				$clients = array(
					'0' => '--- Select Client --- '
				);
				$clients = array_merge($clients, $this->data_m->get_client_name());
								
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Client'); 
				
				echo form_dropdown('client_id', $clients, $row->client_id, 'class="form-control"');
				
				echo div_close();
				
				echo div_close();
			
			
				/*******************************************************
				* Street Input
				*******************************************************/
				
				$street_attr = array(
					'name' => 'project_street',
					'id' => 'project_street',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('project_street', $row->project_street),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Address: Street'); 
				
				echo form_input($street_attr);
				
				echo div_close();
				
				echo div_close(); 
			
				
				/*******************************************************
				* City Input
				*******************************************************/
				
				$city_attr = array(
					'name' => 'project_city',
					'id' => 'project_city',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('project_city', $row->project_city),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Address: City'); 
				
				echo form_input($city_attr);
				
				echo div_close();
				
				echo div_close();			

				/*******************************************************
				* State Input
				*******************************************************/
				
				$state_attr = array(
					'name' => 'project_state',
					'id' => 'project_state',
					'maxlength' => '2',
					'class' => 'form-control',
					'value' => set_value('project_state', $row->project_state),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Address: State'); 
				
				echo form_input($state_attr);
				
				echo div_close();
				
				echo div_close();
			

				/*******************************************************
				* Zip Input
				*******************************************************/
				
				$zip_attr = array(
					'name' => 'project_zip',
					'id' => 'project_zip',
					'maxlength' => '5',
					'class' => 'form-control',
					'value' => set_value('project_zip', $row->project_zip),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Address: Zipcode'); 
				
				echo form_input($zip_attr);
				
				echo div_close();
				
				echo div_close();

				/*******************************************************
				* Project Status
				*******************************************************/
				
				$status_options = array(
					'0' => 'In Progress',
					'1' => 'Completed',
					'2' => 'Pending',
					'3' => 'Waiting Payment',
					'4' => 'On Hold'
				);
								
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Project Status'); 
				
				echo form_dropdown('project_status', $status_options, $row->project_status, 'class="form-control"');
				
				echo div_close();
				
				echo div_close();
							
				echo div_close(); // col-lg-10 col-sm-12
				
		?>

		
       
    </div>
    <div class="panel-footer">
        
        	<?php echo form_submit('save_data', 'Save Project', 'class="btn btn-primary"'); ?>
        
        	
        </div>
     <?php echo form_close(); ?>
</div>

<script type="text/javascript">
// save page 
					$('.ajax-form').submit(function(e) {
                            
						$( "#page-wrapper" ).slideUp(600);						
						e.preventDefault();	
		   				$.ajax({
							url: $(this).attr('action'),
							data: $(this).serialize(),
							type: 'POST',
				
						}).done(function(html) {
  				
							$( "#page-wrapper" ).slideDown(600).html(html);
							$('.alert-success').hide().slideDown("slow");
							
						});
					
					});
</script>