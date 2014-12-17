<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">
		
			<?php echo empty($row->message_id) ? 'Compose Message' : 'View Message'; ?>
        
        </h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->
<?php if (empty($row->message_id) OR $this->input->post('reply')): ?>
<div class="panel panel-default">

	<?php 
		if (empty($row->message_id)) {
			$data_id = '';	
		}
		else {
			$data_id = '';	
		}
		echo form_open('admin/dashboard/ajax_edit/message', array('role'=>'form', 'class'=>'form-horizontal ajax-form', 'data-target' => 'ajax_save', 'data-id'=>$data_id)); 
		
	?>

		<div class="panel-body">
    	
    		<?php 
				
				if ($this->input->post('reply') != TRUE) { 
				
					echo validation_errors();
					$reply = NULL;
				}
	
				if ($this->input->post('reply') != FALSE) {
					$reply = TRUE;
					$row = $this->data_m->get_reply_user($this->input->post('reply'));
				
					$reply_name = $row->first . ' ' . $row->last;
					
					echo form_hidden('reply', $row->message_id);					
								
				}
				echo div('col-lg-10 col-sm-12');
				/*******************************************************
				* Message To Input
				*******************************************************/
				
				$to_attr = array(
					'name' => 'user_name',
					'id' => 'message_to',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => (isset($reply_name)) ? set_value('user_name', $reply_name) : '',
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
								
				echo input_addon('To'); 
				
				echo form_hidden('message_to',	$row->message_from);
				
				echo form_hidden('message_to_user', $row->message_to_user);
				
				echo form_input($to_attr);
								
				echo div_close();
				
				echo '<span class="help-block">Being typing a person\'s name to see available users/clients</span>';
				
				echo div_close(); 

				/*******************************************************
				* Message Title
				*******************************************************/

				$title_attr = array(
					'name' => 'message_title',
					'id' => 'message_title',
					'maxlength' => '128',
					'class' => 'form-control',
					'value' => ($reply == TRUE) ? 'RE: ' . $row->message_title : set_value('message_title', $row->message_title),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Subject'); 
				
				echo form_input($title_attr);
				
				
				echo div_close(); 
								
				echo div_close(); 			
			
				/*******************************************************
				* Message Body
				*******************************************************/
				
				$body_attr = array(
					'name' => 'message_text',
					'id' => 'message_text',
					'class' => 'form-control',
					'value' => set_value('message_text', $row->message_text),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Subject'); 
				
				echo form_textarea($body_attr);
				
				echo div_close(); 
								
				echo div_close();
				
				echo div_close(); // col-lg-10 col-sm-12
				
				
		?>

		
       
    </div>
    <div class="panel-footer">
        
        	<?php echo form_submit('save_data', 'Save user', 'class="btn btn-primary"'); ?>
        
        	
        </div>
     <?php echo form_close(); ?>
</div>
<?php 

	echo script($js['type_ahead']); 
	echo script($js['bloodhound']);

?>

<script type="text/javascript">
	$(document).ready(function(e) {
		
    	var user = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			prefetch: '<?php echo site_url("admin/dashboard/ajax_get/message/typeahead/users"); ?>',
		});
		
		var client = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			prefetch: '<?php echo site_url("admin/dashboard/ajax_get/message/typeahead/clients"); ?>',
		});
		
		user.initialize();
		client.initialize(); 
	  
	   $('#message_to').typeahead({
			highlight: true,
			valueKey: '',
			minLength: 0
	   },
	   {
			name: 'user',
			displayKey: 'name',
			source: user.ttAdapter(),
			templates: {
				header: '<h3 class="user-type">Admins & Employees</h3>'
			}
		},	
		{
			name: 'client',
			displayKey: 'name',
			source: client.ttAdapter(),
			templates: {
				header: '<h3 class="user-type">Clients</h3>' 
			}
		}).blur(function(){
			var data = [];
			var id = 0;
			var type = '';
			
    		match = false

    		for (var i = user.index.datums.length - 1; i >= 0; i--) {
	
		        if($(this).val() == user.index.datums[i].name){
    	
		        	match = true;
				
        	
				}
			}
			
			if (match == false) {
				
				for (var i = client.index.datums.length - 1; i >= 0; i--) {
		
					 if($(this).val() == client.index.datums[i].name){
    	
				     	match = true;
						
						id = client.index.datums[i].id;
				
					}
				}
				
			};
		
    		if(!match){
        		
				alert("Please select the user you wish to message from the suggestion list");   	
			}  
		});	
		
		
        var message_to = $('#message_to').on('typeahead:selected', function(e, value, dataset) {
		  
			$('input[name="message_to"]').val(value.id);

			if (dataset == 'user') {
			
				$('input[name="message_to_user"]').val('1');
			
			}
			else if (dataset == 'client') {
			
				$('input[name="message_to_user"]').val('2');
				
			}
		  	
	   });               
	});
	
// save page 
$('.ajax-form').submit(function(e) {
	e.preventDefault();	
	
	var data = $(this).serialize();
		
	$.ajax({
		url: $(this).attr('action'),
		data: data,
		type: 'POST',
				
		}).done(function(html) {
  				
			window.location = '<?php echo site_url("admin/dashboard/page/message"); ?>';
							
	});

<?php if ($this->input->post('reply')): ?>


<?php endif; ?>
});



</script>

<?php 
	else:
		
		$this->load->view('admin/message/view');
?>

	<script type="text/javascript">
		$('body').on('click', '#reply_btn', function(e) {
			
			e.preventDefault();
			var array = [];
			
			$(array).serialize();
						
			$.ajax({
				url: '<?php echo site_url('admin/dashboard/ajax_edit/message/'.$row->message_id); ?>',
				data: {'reply': <?php echo $row->message_id; ?>},
				type: 'POST',
			}).done(function(html) {
				$( "#page-wrapper" ).html(html);

			});
			
		});
	</script>

<?php

	endif; 

?>
<script type="text/javascript">
// Update the browser URL without reloading the page
		var stateObject = {};
		var title = "";
		var newUrl = "<?php echo empty($row->message_id) ? site_url('admin/dashboard/page/message/edit/') : site_url('admin/dashboard/page/message/edit/'. $row->message_id); ?>";
		
		history.pushState(stateObject,title,newUrl);

</script>