<?php 
	
	$user_where = 'user_id';
	$table = 'users';
	if ($row->message_to_user == 2 OR $row->message_to_user == 3) {
		$user_where = 'client_id';
		$table = 'clients';
	}
	
	if ($row->message_status == '4') {
		
		$this->data_m->message_read($row->message_id);
		
	}
	
	$this->db->where($user_where, $row->message_from);
	$from = $this->db->get($table)->row();

	if ($row->message_to_user == 2 OR $row->message_to_user == 3) {
		
		$prefix = 'client_';
		
	}
	else {
		$prefix = 'user_';
	}
	
			$from_name = $from->{$prefix . 'first'} . ' ' . $from->{$prefix . 'last'};

?>

<div class="col-md-4 inbox-btns">
	<div class="panel panel-default">
		<div class="panel-body">

            
            <ul class="list-group">
				<li class="list-group-item"><?php echo anchor('admin/dashboard/page/message/edit', 'COMPOSE', 'class="btn btn-block btn-success"'); ?></li>

            	<li class="list-group-item">SHORTCUTS</li>
                <li class="list-group-item"><?php echo anchor('admin/dashboard/page/message', 'Inbox <span class="badge pull-right">'.$msg_unread_count.' </span>', ''); ?></li>
                <li class="list-group-item"><?php echo anchor('admin/dashboard/page/message', 'Outbox', 'id="outbox"'); ?></li>
                
            </ul>
    	</div>    
    </div>
</div>

<div class="col-md-8">

	<div class="panel panel-default">
	
    	<div class="panel-heading">
    		<strong>Message</strong>
    	</div>

		<div class="panel-body msg-view">
        	<div class="row">
        		<h4 class="page-header">
                	<strong><?php echo ($this->input->post('outbox_msg') != FALSE) ? 'To: ' : 'From: '; ?> </strong>
                	<?php echo $from_name; ?> <small>&lt;<?php echo $from->{$prefix.'email'}; ?>&gt;</small>
                    <span class="pull-right">
	                    <small>On <?php echo $row->message_timestamp; ?></small>
    	                <?php echo ($this->input->post('outbox_msg') != FALSE) ? '' : anchor('admin/dashboard/page/message/edit', 'Reply', 'class="btn btn-sm btn-info" id="reply_btn"'); ?>
                    </span>
                </h4> 
                
                <h4 class="page-header">
            		<strong>Subject: </strong><span class=""><?php echo $row->message_title; ?></span>
            	</h4>
                
                
                <p class="msg-body"><?php echo $row->message_text; ?></p>
            </div>
        </div>
	</div>
</div>