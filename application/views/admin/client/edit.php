<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">
		
		<?php echo empty($row->client_id) ? 'Add a Client' : 'Edit Client: ' . $row->client_first . " " . $row->client_last; ?></h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="panel panel-default">

	<?php 
		if (empty($row->client_id)) {
			$data_id = '';	
		}
		else {
			$data_id = $row->client_id;	
		}
		echo form_open('', array('role'=>'form', 'class'=>'form-horizontal ajax-form', 'data-target' => 'ajax_save', 'data-id'=>$data_id)); 

	?>

		<div class="panel-body">
    	
    		<?php 
				echo validation_errors();
				echo div('col-lg-10 col-sm-12');

				/*******************************************************
				* First Name Input
				*******************************************************/
				
				$first_attr = array(
					'name' => 'client_first',
					'id' => 'first_name',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('client_first', $row->client_first),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('First Name'); 
				
				echo form_input($first_attr);
				
				echo div_close(); 
								
				echo div_close(); 
			
				/*******************************************************
				* Last Name Input
				*******************************************************/
				
				$last_attr = array(
					'name' => 'client_last',
					'id' => 'last_name',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('client_last', $row->client_last),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Last Name'); 
				
				echo form_input($last_attr);
				
				echo div_close();
				
				echo div_close(); 
			
			
				/*******************************************************
				* Street Input
				*******************************************************/
				
				$street_attr = array(
					'name' => 'client_street',
					'id' => 'client_street',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('client_street', $row->client_street),
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
					'name' => 'client_city',
					'id' => 'client_city',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('client_city', $row->client_city),
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
					'name' => 'client_state',
					'id' => 'client_state',
					'maxlength' => '2',
					'class' => 'form-control',
					'value' => set_value('client_state', $row->client_state),
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
					'name' => 'client_zip',
					'id' => 'client_zip',
					'maxlength' => '5',
					'class' => 'form-control',
					'value' => set_value('client_zip', $row->client_zip),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Address: Postal Code'); 
				
				echo form_input($zip_attr);
				
				echo div_close();
				
				echo div_close();

				/*******************************************************
				* Email Input
				*******************************************************/
				
				$email_attr = array(
					'name' => 'client_email',
					'id' => 'client_email',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('client_email', $row->client_email),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Email'); 
				
				echo form_input($email_attr);
				
				echo div_close();
				
				echo div_close();

				/*******************************************************
				* Username Input
				*******************************************************/
				
				$username_attr = array(
					'name' => 'client_username',
					'id' => 'client_username',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('client_username', $row->client_username),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Username'); 
				
				echo form_input($username_attr);
				
				echo div_close();
				
				echo div_close();

				/*******************************************************
				* Password Input
				*******************************************************/
				
				$password_attr = array(
					'name' => 'client_password',
					'id' => 'client_password',
					'maxlength' => '32',
					'class' => 'form-control',
					'value' => set_value('client_password', ''),
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Password'); 
				
				echo form_password($password_attr);
				
				echo div_close();
				
				echo div_close();

				/*******************************************************
				* Password Confirm Input
				*******************************************************/
				
				$confirm_attr = array(
					'name' => 'password_confirm',
					'id' => 'password_confirm',
					'maxlength' => '32',
					'class' => 'form-control',
					'value' => set_value('password_confirm', ''),
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Confirm Password'); 
				
				echo form_password($confirm_attr);
				
				echo div_close();
				
				echo div_close();
							
				echo div_close(); // col-lg-10 col-sm-12
				
		?>

		
       
    </div>
    <div class="panel-footer">
        
        	<?php echo form_submit('save_data', 'Save Client', 'class="btn btn-primary"'); ?>
        
        	
        </div>
     <?php echo form_close(); ?>
</div>

<script type="text/javascript">
// save page 
					$('.ajax-form').submit(function(e) {
                            
                       
						e.preventDefault();	
		   				$.ajax({
							url: $(this).attr('action'),
							data: $(this).serialize(),
							type: 'POST',
				
						}).done(function(html) {
  				
							$( "#page-wrapper" ).html(html);
							
						});
					
					});
</script>