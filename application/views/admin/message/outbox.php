<div class="panel panel-default">        
    
    <div class="panel-heading">
    Outbox
    </div>
    
    <div class="panel-body">
        <div class="table-responsive">
            
            <div class="col-md-12">
                
                <p class="text-right">
                    <strong>Key: </strong>
                    <button class="btn btn-sm btn-success">Sent </button>
                    <button class="btn btn-sm btn-info"> Replied</button>
                    <button class="btn btn-sm btn-danger">Read</button>


                </p>
            
            </div>
            <table class="table table-striped table-bordered table-hover text-center" id="dataTables">

                <thead>

                    <tr>
						<th> id </th>
                        <th>Date</th>

                        <th>To</th>

                        <th>Subject</th>
                        
                        <th>Read/Action</th>

                        <th>Delete</th>

                    </tr>

                </thead>
                
                <tbody>
                
                    <?php
                        
                        if (isset($rows)):

                            foreach($rows as $row):
                                // 1 = message to user from user
                                // 2 = message to client from user
                                // 3 = message from client to user
                           
                                                                                            
                    ?>
                    
                    <tr>
                    	<td><?php echo $row->message_id; ?> </td>
                        <td><?php echo $row->message_timestamp; ?></td>
                        <td><strong><?php echo $row->to_name . '</strong>- ' . $row->user_type; ?></td>
                        <td><?php echo $row->message_title; ?></td>
                        <td><?php echo msg_status($row->message_id, 1, TRUE); ?></td>
                        <td><?php echo btn_delete('message', $row->message_id); ?></td>
                    
                    </tr>
                    
                    <?php 
                            endforeach;
                        
                        endif;
                        
                    ?>
                </tbody>
            
            </table>
        </div>

    </div>

</div>

<script type="text/javascript">
	$('#dataTables').dataTable(<?php if ($this->uri->segment(4) == 'message'): ?>
		{
		"order": [[ 0, "desc" ]],
       	"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }]
    	}<?php endif; ?>);
</script>