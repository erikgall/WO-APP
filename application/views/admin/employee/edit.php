<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">
		
		<?php echo empty($row->user_id) ? 'Add a User' : 'Edit User: ' . $row->user_first . " " . $row->user_last; ?></h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="panel panel-default">

	<?php 
		if (empty($row->user_id)) {
			$data_id = '';	
		}
		else {
			$data_id = $row->user_id;	
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
					'name' => 'user_first',
					'id' => 'first_name',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('user_first', $row->user_first),
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
					'name' => 'user_last',
					'id' => 'last_name',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('user_last', $row->user_last),
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
					'name' => 'user_street',
					'id' => 'user_street',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('user_street', $row->user_street),
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
					'name' => 'user_city',
					'id' => 'user_city',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('user_city', $row->user_city),
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
					'name' => 'user_state',
					'id' => 'user_state',
					'maxlength' => '2',
					'class' => 'form-control',
					'value' => set_value('user_state', $row->user_state),
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
					'name' => 'user_zip',
					'id' => 'user_zip',
					'maxlength' => '5',
					'class' => 'form-control',
					'value' => set_value('user_zip', $row->user_zip),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Address: Zip Code'); 
				
				echo form_input($zip_attr);
				
				echo div_close();
				
				echo div_close();

				/*******************************************************
				* Email Input
				*******************************************************/
				
				$email_attr = array(
					'name' => 'user_email',
					'id' => 'user_email',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('user_email', $row->user_email),
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
					'name' => 'user_username',
					'id' => 'user_username',
					'maxlength' => '80',
					'class' => 'form-control',
					'value' => set_value('user_username', $row->user_username),
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
					'name' => 'user_password',
					'id' => 'user_password',
					'maxlength' => '32',
					'class' => 'form-control',
					'value' => set_value('user_password', ''),
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

				/*******************************************************
				* User Type
				*******************************************************/
				
				$user_type = $this->config->item('employee_types');
								
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('User Type'); 
				
				echo form_dropdown('user_type', $user_type, $row->user_type, 'class="form-control"');
				
				echo div_close();
				
				echo div_close();

							
				/*******************************************************
				* Active Status
				*******************************************************/
				
				$active_opt = array(
					'0' => 'Inactive',
					'1' => 'Active',
				);
								
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Account Active'); 
				
				echo form_dropdown('user_active', $active_opt, $row->user_active, 'class="form-control"');
				
				echo div_close();
				
				echo div_close();

				echo form_hidden('user_timestamp', unix_to_human(time()), 'us');
							
				echo div_close(); // col-lg-10 col-sm-12
				
				
		?>

		
       
    </div>
    <div class="panel-footer">
        
        	<?php echo form_submit('save_data', 'Save user', 'class="btn btn-primary"'); ?>
        
        	
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
							
							location.reload();
							
						});
					
					});
</script>