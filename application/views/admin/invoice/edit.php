<?php
	
	$projects = $this->db->order_by('project_name')->get('projects');
	
	if ($projects->num_rows() > 0) {
		
		if (!empty($row->invoice_id)) {
				
			$project_name = '';
			$project_client = '';
			
			foreach ($projects->result() as $pro) {
				
				 
				
				// row->project_id == invoice->project_id
				if ($pro->project_id == $row->project_id) {
					
					$project_name = $pro->project_name;
					$client_id = $pro->client_id; 
					
					$client = $this->db->where('client_id')->get('clients');
					
					if ($client->num_rows() > 0 AND $client->row()->client_id == $client_id) {
						
						$client_name = $client->row()->client_first . ' ' . $client->row()->client_last;
						
					}
					
				}
			
			}
		}
	
		$projects = $projects->result();
	}
?>


<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">
		
		<?php echo empty($row->invoice_id) ? 'Add an Invoice' : 'Edit Invoice: ' . $project_name . "- " . $row->invoice_timestamp; ?></h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="panel panel-primary" role="tabpanel">

	<div class="panel-heading">

		<ul class="nav nav-tabs" role="tablist">
			<?php if (!empty($row->invoice_id)): ?>
			<li role="presentation" class="active"><a href="#view" aria-controls="bills" role="tab" data-toggle="tab">View Invoice</a></li>  
            <?php endif; ?>      	
            <li role="presentation" class="<?php echo empty($row->invoice_id) ? 'active' : ''; ?>"><a href="#invoice" aria-controls="invoice" role="tab" data-toggle="tab">Invoice Information</a></li>
                    
        </ul> 
   
	</div>
	
	
	<?php 
	
		if (empty($row->user_id)) {
			$data_id = '';	
		}
		else {
			$data_id = $row->user_id;	
		}
		
	?>
	<div class="tab-content">
		
       	<div class="tab-pane<?php echo empty($row->invoice_id) ? 'active' : ''; ?>" id="invoice" role="tabpanel">
        	
            <?php 				echo form_open('', array('role'=>'form', 'class'=>'form-horizontal ajax-form', 'data-target' => 'ajax_save', 'data-id'=>$data_id)); 
?>
           	<div class="panel-body">
    		            
    		<?php 
			

				echo validation_errors();
				echo div('col-lg-10 col-sm-12');

				/*******************************************************
				* Projects Dropdown
				*******************************************************/
				
				$projects_attr = array();
				
				foreach($projects as $attr) {
					
					$projects_attr[$attr->project_id] = $attr->project_name;
					
				}
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Project'); 
				
				echo form_dropdown('project_id', $projects_attr, $row->project_id, 'class="form-control" required');
				
				echo div_close(); 
								
				echo div_close(); 


				/*******************************************************
				* Invoice Status Dropdown
				*******************************************************/
				
				$invoice_status = $this->config->item('invoice_status');
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Invoice Status'); 
				
				echo form_dropdown('invoice_status', $invoice_status, $row->invoice_status, 'class="form-control"');
				
				echo div_close(); 
								
				echo div_close(); 
			
				/*******************************************************
				* Invoice Due
				*******************************************************/
				
				$invoice_due_attr = array(
					'name' => 'invoice_timestamp',
					'id' => 'invoice_timestamp',
					'maxlength' => '45',
					'class' => 'form-control',
					'value' => set_value('invoice_timestamp', $row->invoice_timestamp),
					'required' => 'true'
				);
				
				echo div('form-group');
				
				echo div('input-group');
				
				echo input_addon('Invoice Due:'); 
				
				echo form_input($invoice_due_attr);
				
				echo div_close();
				
				echo div_close();				
		
				echo div_close(); // col-lg-10 col-sm-12		
		
		?>
		</div> 
		
        <div class="panel-footer">
        
 		<?php echo form_submit('save_data', 'Save Invoice', 'class="btn btn-primary"'); ?>

        	
        </div>
        
      
		<?php echo form_close(); ?>

	</div>

        <?php if (!empty($row->invoice_id)): ?>
		<div class="tab-pane active" id="view" role="tabpanel">

			<?php $this->load->view('admin/invoice/view_tab'); ?>
    	
    	</div>
		<?php endif; ?>
               

	</div>

</div>

<?php 

	echo link_tag($css['x_editable']);	
	echo script($js['datetimepicker']);
	echo script($js['x_editable']);
	
?>
<script type="text/javascript">
	
	$(document).ready(function() {
		
		// Update the browser URL without reloading the page
		var stateObject = {};
		var title = "";
		var newUrl = "<?php echo empty($row->invoice_id) ? site_url('admin/dashboard/page/invoice/edit/') : site_url('admin/dashboard/page/invoice/edit/'. $row->invoice_id); ?>";
		
		history.pushState(stateObject,title,newUrl);
		
		<?php if (!empty($row->invoice_id)): ?>
		// set the default for xeditable to inline
		$.fn.editable.defaults.mode = 'inline';
	
		// clone the add row so we can add it after we add a new row
		var row = $('#new_row').clone().html();
	
		// create the editable instance
	    $('.editable').editable();
		
		
		// When we add a item starting on the far left, open the next editable item
		function goToNext() {
			$('.add_new').on('save.newBill', function() {
			
			var current = this;
			
			setTimeout(function() {
				
				// find the next editable item
				$(current).closest('td').next().find('.add_new').editable('show');
			
			}, 200);
			
		});
		}
		
		function getValue(pk) {
			
			alert($('a[data-name="bill_quanity"][data-pk="'+pk+'"]').text());
			
		}
		
		$('a[data-name="bill_price"]').on('save', function(e, params) {
			
			if ($(this).hasClass('editable-empty') === false) {
				
				var obj = $.parseJSON(params.response);
				
				var oldValue = parseFloat($(this).parent().parent().children('.bill_amount').text().substr(1)); 
				
				var value = parseFloat(params.newValue);
				
				var quanity = parseFloat($('a[data-name="bill_quanity"][data-pk="'+obj.id+'"]').text());
				
				var new_amount = (value * quanity);
				
				$('#bill_total').html(parseFloat(($('#bill_total').html() - oldValue) + new_amount));
				$(this).parent().next('td').html('$' + new_amount);				
			}
		});
		goToNext();
	// when we add a new item and click save
	$('body').on('click', '#add_bill', function(e) {
    	
		// prevent anything from happening
		e.preventDefault();
		
		// set the js vars for the invoice id and the completion date
		var invoice_id = <?php echo $row->invoice_id; ?>;
		
		var timestamp = "<?php echo date('m-d-Y h:i a'); ?>";
		
		// submit the editable items
		$('.add_new').editable('submit', {
			
    		url: '<?php echo site_url("admin/dashboard/ajax_save/billing"); ?>',
    		data: {
				'invoice_id': invoice_id,
				'bill_timestamp': timestamp,
				'response': 'json'
			},
			ajaxOptions: {
    			dataType: 'json' //assuming json response
    		},
    
			success: function(data, config) {
				if (data && data.id) { //record created, response like {"id": 2}
    				
					//set pk for new row
					$(this).each(function(index, element) {
                    	
						$('.add_new').attr('data-pk', data.id);
                    
					});
    				
					//remove unsaved class
    				$(this).removeClass('editable-unsaved');
    
					//show messages
    				var msg = 'Item was created successfully!';
					
					// add alert-success to alert and unhide it
				    $('#msg-alert').addClass('alert-success').removeClass('alert-danger').removeClass('hidden');
					
					// display the message and show it
					$('#msg').html(msg).hide().slideDown('slow');
    				
					// Display the combined price
					$('#new_row #total_amount').html('$' + (data.post.bill_quanity * data.post.bill_price).toFixed(2));
					
					var bill = parseFloat($('span#bill_total').html()) + parseFloat((data.post.bill_quanity * data.post.bill_price).toFixed(2));

					$('span#bill_total').html(bill);
					
					$('#btn_cell.add_new').html('<a data-confirm="Are you sure you wish to delete item? Once deleted, this item will be removed from the database!" data-id="'+data.id+'" data-src="billing" data-target="ajax_delete" class="btn btn-danger btn-sm" href="http://localhost/wo/#"><i class="fa fa-times"></i> Delete</a>');
					$('.add_new').each(function() {
                    
					    $(this).removeClass('add_new');
                    
					});
					
					
					$('#new_row').removeAttr('id');
					
					$('.items tbody').append('<tr id="new_row">' + row + '</tr>');
					
					var amount_row = $('#amount_row').clone();
					
					$('#amount_row').remove();
					
					$('.items tbody').append(amount_row);
					
					$('#add_bill').hide();
					
					$(this).off('save.newBill');
					
					$('.editable').editable('destroy').editable();
					
					$('#new_row td #add_bill').show();	
					
					goToNext();				
    			} 
			
				else if (data && data.errors) {

				    //server-side validation error, response like {"errors": {"username": "username already exist"} }
    				config.error.call(this, data.errors);
				}
			},
    
			error: function(errors) {
    			
				var msg = '';
    
				if (errors && errors.responseText) { //ajax error, errors = xhr object
    
					msg = errors.responseText;

				} 
				else { //validation error (client-side or server-side)
    		
					$.each(errors, function(k, v) { msg += k+": "+v+"<br>"; });
    		
				}
    
				$('#msg-alert').removeClass('alert-success').addClass('alert-error').removeClass('hidden').html(msg).show();
    		}
    	});
	});
	<?php endif; ?>
});
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
					
	$('#invoice_timestamp').datetimepicker({
		format: 'm-d-Y h:i a',
		formatTime:'h:i a',
		formatDate:'m-d-Y',
		step: 30,
		minDate: '1-1-2010',
		inline: true,
	});
	

	$(document).ready(function() {
		
		var total = 0;
		var id = 0;
		var tr = '';
		$('body').on('click', 'a[data-confirm]', function(ev) {
			
			ev.preventDefault();
			
			id = $(this).attr('data-id');
			
			tr = $('a[data-id="'+id+'"]').parent().parent();
			total = parseFloat($(this).parent().siblings('.bill_amount').html().substr(1));

			var href = '<?php echo site_url(); ?>admin/dashboard/ajax_delete/' + $(this).attr('data-src') + '/' + $(this).attr('data-id')+'/false';

			if (!$('#dataConfirmModal').length) {

					$('body').append('<!-- Modal --><div class="modal fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="myModalLabel">Please Confirm</h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-danger" aria-hidden="true" data-dismiss="modal">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">Delete</a></div></div></div></div>');

				} 

				$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));

				$('#dataConfirmOK').attr('href', href);

				$('#dataConfirmModal').modal('show');
				
				$('body').on('click', '#dataConfirmOK', function(i) {
					
					i.preventDefault();
					i.stopImmediatePropagation();
					$(tr).hide();
					$('#dataConfirmModal').modal('hide')

				$.ajax({
					
					url: $(this).attr('href'),
					type: 'POST',
					success: function(html) {
						$('#msg').html(html).hide().slideDown('slow');
					}
				}).complete(function(html) {

					$('#bill_total').html((parseFloat($('#bill_total').html()) - total).toFixed(2));
					
				    $('#msg-alert').addClass('alert-success').removeClass('alert-danger').removeClass('hidden');
								
			});

			});				
				return false;

		});

	});



</script>