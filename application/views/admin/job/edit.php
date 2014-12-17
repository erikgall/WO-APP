<?php
	echo script($js['datetimepicker']);

?>
<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">
		
		<?php echo empty($row->job_id) ? 'Add a Job Task' : 'Edit Job Task: ' . $row->job_name; ?></h1>

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
					'name' => 'job_name',
					'id' => 'job_name',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('job_name', $row->job_name),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Task Name'); 
				
				echo form_input($name_attr);
				
				echo div_close(); 
								
				echo div_close(); 
			

				/*******************************************************
				* Project Select
				*******************************************************/
				$projects = array(
					0 => '--- Select Client --- '
				);
				
				$get_project = $this->data_m->get_from('projects');
				
				foreach($get_project as $pro) {
					$projects[$pro->project_id] = $pro->project_name;	
				} 
								
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Project'); 
				
				echo form_dropdown('project_id', $projects, $row->project_id, 'class="form-control"');
				
				echo div_close();
				
				echo div_close();
			
			
				/*******************************************************
				* Desc Input
				*******************************************************/
				
				$desc_attr = array(
					'name' => 'job_desc',
					'id' => 'job_desc',
					'rows' => 3,
					'class' => 'form-control',
					'value' => set_value('job_desc', $row->job_desc),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Task Notes'); 
				
				echo form_textarea($desc_attr);
				
				echo div_close();
				
				echo div_close(); 
			
				
				/*******************************************************
				* Finish Input
				*******************************************************/
				
				$finish_attr = array(
					'name' => 'job_finish',
					'id' => 'job_finish',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('job_finish', $row->job_finish),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Completion Goal:'); 
				
				echo form_input($finish_attr);
				
				echo div_close();
				
				echo div_close();			
			
				/*******************************************************
				* Job Status
				*******************************************************/
				
				$status_options = array(
					'0' => 'In Progress',
					'1' => 'Completed',
					'2' => 'Pending',
				);
								
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Job Status'); 
				
				echo form_dropdown('job_status', $status_options, $row->job_status, 'class="form-control"');
				
				echo div_close();
				
				echo div_close();
							
				echo div_close(); // col-lg-10 col-sm-12
				
				echo form_hidden('job_timestamp', set_value('job_finish', $row->job_timestamp));
				
		?>

		
       
    </div>
    <div class="panel-footer">
        
        	<?php echo form_submit('save_data', 'Save Job', 'class="btn btn-primary"'); ?>
        
        	
        </div>
     <?php echo form_close(); ?>
</div>

<script type="text/javascript">
jQuery('#job_finish').datetimepicker({
	formatTime:'h:i a',
	formatDate:'m-d/Y',
	step: 30,
	inline: true,
});
</script>
<?php echo ajax_post(); ?>
