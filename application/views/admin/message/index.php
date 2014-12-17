
<div class="row">
	
	<div class="col-lg-12">

		<h1 class="page-header">Messages</h1>

	</div>
	<!-- /.col-lg-12 -->

</div><!-- /.row -->

<div class="row">
	<div class="col-md-3 inbox-btns">
	<div class="panel panel-default">
		<div class="panel-body">

            <ul class="list-group">
				<li class="list-group-item"><?php echo anchor('admin/dashboard/page/message/edit', 'COMPOSE', 'data-target="ajax_edit" data-src="message" data-id="" class="btn btn-block btn-success"'); ?></li>

            	<li class="list-group-item">SHORTCUTS</li>
                <li class="list-group-item"><?php echo anchor('admin/dashboard/page/message', 'Inbox <span class="badge pull-right">'.$msg_unread_count.' </span>', 'data-toggle="animate"'); ?></li>
                <li class="list-group-item"><?php echo anchor('admin/dashboard/page/message', 'Outbox', 'id="outbox"'); ?></li>
                
            </ul>
    	</div>    
    </div>
</div>

	<div class="col-md-9" id="msg-container">
		<?php 
		
			if ($this->input->post('outbox') != FALSE):
			
			$this->load->view('admin/message/outbox');
			
			else:
		?>
		<div class="panel panel-default">        
            
			<div class="panel-body">
				<?php 
				
					if (isset($status_msg) AND !empty($status_msg)) {
						echo '<div class="alert alert-success" role="alert">'.$status_msg.'</div>';
					}
				?>
				<div class="table-responsive">
					<?php if ($this->session->flashdata('save') AND $this->session->flashdata('save') == 'success'): ?>
				
                		<div class="alert alert-warning alert-dismissible" role="alert">
  							<button type="button" class="close" data-dismiss="alert">
                				<span aria-hidden="true">&times;</span>
                    			<span class="sr-only">Close</span>
                			</button>
  				
                			<strong>Success!</strong> Your message has been sent and can be monitored from your outbox.
						</div>
            
            
            		<?php endif; ?>
                    
                    <div class="col-md-12">
                    	
                        <p class="text-right">
							<strong>Key: </strong>
		                    <button class="btn btn-sm btn-success">New Message </button>
		                    <button class="btn btn-sm btn-info"> Replied</button>
		                    <button class="btn btn-sm btn-danger">Read</button>


                        </p>
                    
                    </div>
					<table class="table table-striped table-bordered table-hover text-center" id="dataTables">

						<thead>

							<tr>

								<th>Date</th>

								<th>From</th>
	
								<th>Subject</th>
                                
                                <th>Read/Action</th>

								<th>Delete</th>

							</tr>

						</thead>
                        
                        <tbody>
                        
                        	<?php
								
								if (isset($rows)):
									
									$users = array();
									$clients = array();
									
									foreach($rows as $row) {
										// 1 = message to user from user
										// 2 = message to client from user
										// 3 = message from client to user
										
										if (!in_array($row->message_from, $users) AND $row->message_to_user == 1) {

											$users[] = $row->message_from;	

										}
										elseif (!in_array($row->message_from, $clients) AND $row->message_to_user == 3) {
											
											$clients[] = $row->message_from;
												
										}
										
									}
									
									if (count($users) > 0) {
									
										$this->db->where_in('user_id', $users);
										$user = $this->db->get('users');
									
									}
									if (count($clients) > 0) {
										$this->db->where_in('client_id', $clients);
										$client = $this->db->get('clients');	
									}
									foreach ($rows as $row):
										
										$type = '';
										$ok_array = array(1, 3, 4);
										if (in_array($row->message_to_user, $ok_array)):
										
										if ($row->message_to_user == 1) {
									
											$type = $user;
											
										}
										elseif ($row->message_to_user == 3 OR $row->message_to_user == 4) {
											
											$type = $client;
											
										}
										
											foreach ($type->result() as $msg_to) {
											
												if ($row->message_to_user == 1) {
												
													$message_from = $msg_to->user_first . ' ' . $msg_to->user_last;
												
													$user_type = humanize($msg_to->user_type);
											
												}
												elseif ($row->message_to_user == 3 OR $row->message_to_user == 4) {
												
													$message_from = $msg_to->client_first . ' ' . $msg_to->client_last;
												
													$user_type = 'Client';
													
												}
											
											
											
										}
																									
							?>
                        	
                            <tr>
							
								<td><?php echo $row->message_timestamp; ?></td>
                                <td><strong><?php echo $message_from . '</strong>- ' . $user_type; ?></td>
                                <td><?php echo $row->message_title; ?></td>
                                <td><?php echo msg_status($row->message_id, $row->message_status); ?></td>
                                <td><?php echo btn_delete('message', $row->message_id); ?></td>
                            
                            </tr>
                            
                            <?php 
									endif; 
									endforeach;
								
								endif;
								
							?>
                        </tbody>
					
					</table>
				</div>

			</div>

		</div>
        
        <?php endif; ?>

	</div>

</div>
<?php echo $this->load->view('admin/includes/page_scripts'); ?>
<script type="text/javascript">
	$('body').on('click', '#reply', function(e) {
			
		e.preventDefault();

		$.ajax({
			url: '<?php echo site_url('admin/dashboard/ajax_edit/message/'); ?>/' + $(this).data('id'),
			data: {'reply': $(this).data('id')},
			type: 'POST',
		}).done(function(html) {
			$( "#page-wrapper" ).html(html);
		});
		
	});
	
	$('body').on('click', '#outbox', function(e) {
			
		e.preventDefault();
		e.stopImmediatePropagation();
		
		var array = [];
		
		$(array).serialize();
					
		$.ajax({
			url: '<?php echo site_url('admin/dashboard/ajax_get/message/outbox/html'); ?>',
			data: {'outbox': true},
			type: 'POST',
		}).done(function(html) {
			
			if ($('.panel-body').hasClass('msg-view') == false) {
				
				$( "#msg-container" ).html(html);
			}
			else {
				
				$('.col-md-8').html(html).removeClass('col-md-8').addClass('col-md-9');
				$('.inbox-btns').removeClass('col-md-4').addClass('col-md-3');
			}
			
		});
		
	});
	
	$('body').on('click', 'a[data-target="outbox_msg"]', function(e) {
		e.stopImmediatePropagation();
		$('#page-wrapper').addClass('animated').addClass('slideOutRight');
		
		e.preventDefault();	
		$.ajax({
			url: '<?php echo site_url(); ?>admin/dashboard/ajax_edit/' + $(this).attr('data-src') + '/' + $(this).attr('data-id'),
			data: {'outbox_msg': true},
			type: 'POST',

		}).done(function(html) {
			$("#page-wrapper").removeClass('slideOutRight').addClass('slideInRight');
			$( "#page-wrapper" ).html(html);
			window.localStorage.clear();

		});
	});
</script>