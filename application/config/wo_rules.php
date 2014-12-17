<?php

	function rule_helper($field, $label, $rules, $trim = TRUE, $required = TRUE, $xss = TRUE) {
		
		$rule = array(
			'field' => $field,
			'label' => $label,
			
			'rules' => $rules
 		);
	
		$length = strlen($rule['rules']);
		
		$last_char = substr($rule['rules'], 0);
		
		$last_char = $last_char[$length - 1];
		
		if ($length > 0 AND $last_char != '|') {
			
			$rule['rules'] .= '|';	
		
		}
		
		$str = '';
		if ($trim == TRUE) {
			
			$str = 'trim'; 
			
		}
		
		if ($required == TRUE) {
			
			if ($str == '') {
				
				$str = 'required';
							
			}
			else {
				$str .= '|required';	
			}
		
		}
		if ($xss == TRUE) {
			
			if ($str == '') {
				
				$str = 'xss_clean';
							
			}
			else {
				$str .= '|xss_clean';	
			}
		
		}
		
		$rule['rules'] .= $str;
		
		return $rule;

		
		
	}
	
	$config['delete_response'] = array(
		'act_bills',
		'billing'
	
	);
	
	$config['db'] = array(

		
/**********************************************
* Accounting Table
/*********************************************/

		'accountings' => array(
			
			'rules' => array(
	
				'act_name' => rule_helper('act_name', 'Bill Name', 'max_length[80]'),

				'act_status' => rule_helper('act_status', 'Invoice Status', 'integer'),
				
				'act_timestamp' => rule_helper('act_timestamp', 'Creation Timestamp', '', TRUE, TRUE, FALSE), 
				
				'act_date_due' => rule_helper('act_date_due', 'Due Date/Time', '', TRUE, TRUE, FALSE),
			),	
			
			'fields' => array(
				'act_name',
				'act_status',
				'act_timestamp',
				'act_date_due',
			)

		),
		
		
/**********************************************
* Accounting Billing Table
/*********************************************/

		'act_bills' => array(
			'rules' => array(
			
				'bill_name' => rule_helper('bill_name', 'Bill Name', 'max_length[80]'),
				
				'bill_desc' => rule_helper('bill_desc', 'Bill Description', 'max_length[128]', TRUE, FALSE),
				
				'bill_quanity' => rule_helper('bill_quanity', 'Quanity', 'integer'),
				
				'bill_price' => rule_helper('bill_price', 'Price', 'numerical', TRUE, FALSE, TRUE),
				
				'invoice_id' => rule_helper('invoice_id', 'WO Invoice Error', 'integer', TRUE, FALSE, TRUE),
				
			),
			'fields' => array(
				'bill_name',
				'bill_desc',
				'bill_quanity',
				'bill_price',
				'act_id',
				'bill_timestamp',
				'project_id'
			),
						
		),

/**********************************************
* Assignments Table
/*********************************************/

		'assignments' => array (
			
			'rules' => array(
				'job_id' => rule_helper('job_id', 'Job ID', ''),			
			),
			
			'fields' => array(
				'job_id',
				'user_id',
			),
		),
		
/**********************************************
* Billing Table
/*********************************************/

		'billing' => array(
			'rules' => array(
			
				'bill_name' => rule_helper('bill_name', 'Bill Name', 'max_length[80]'),
				
				'bill_desc' => rule_helper('bill_desc', 'Bill Description', 'max_length[128]', TRUE, FALSE),
				
				'bill_quanity' => rule_helper('bill_quanity', 'Quanity', 'integer'),
				
				'bill_price' => rule_helper('bill_price', 'Price', 'numerical'),
				
				'invoice_id' => rule_helper('invoice_id', 'WO Invoice Error', 'integer', TRUE, FALSE, TRUE),
				
			),
			'fields' => array(
				'bill_name',
				'bill_desc',
				'bill_quanity',
				'bill_price',
				'invoice_id',
				'bill_timestamp',
			),
						
		),
		
/**********************************************
* Clients Table
/*********************************************/

		'clients' => array(
			
			'rules' => array(
			
				'client_first' => rule_helper('client_first', 'First Name', 'max_length[45]'),
						
				'client_last' => rule_helper('client_last', 'Last Name', 'max_length[45]'),
				
				'client_street' => rule_helper('client_street', 'Address: Street', 'max_length[80]'),

				'client_city' => rule_helper('client_city', 'Address: City', 'max_length[45]'),
				
				'client_state' => rule_helper('client_state', 'Address: State', 'max_length[2]|alpha'),
				
				'client_zip' => rule_helper('client_zip', 'Address: Zip', 'max_length[5]|integer'),

				//'client_phone' => rule_helper('client_phone', 'Phone Number', 'max_length[15]'),

				'client_email' => rule_helper('client_email', 'Email Address', 'max_length[80]|valid_email'), 
				
				'client_username' => rule_helper('client_username', 'Username', 'max_length[45]'), 
				
				'client_password' => rule_helper('client_password', 'Password', 'matches[password_confirm]', TRUE, FALSE, FALSE),
				
				'password_confirm' => rule_helper('password_confirm', 'Password', 'matches[client_password]', TRUE, FALSE, FALSE),
			),
			
			'fields' => array(
				'client_first',
				'client_last',
				'client_street',
				'client_city',
				'client_state',
				'client_zip',
				'client_phone',
				'client_email',
				'client_username',
			),
		),		
		
/**********************************************
* Employees Table
/*********************************************/

		'employees' => array(
			
			'rules' => array(
		
				'user_first' => rule_helper('user_first', 'First Name', 'max_length[45]'),
			
				'user_last' => rule_helper('user_last', 'Last Name', 'max_length[45]'), 
			
				'user_street' => rule_helper('user_street', 'Address: Street', 'max_length[80]'),

				'user_city' => rule_helper('user_city', 'Address: City', 'max_length[45]'), 
			
				'user_state' => rule_helper('user_state', 'Address: State', 'max_length[2]|alpha'),
			
				'user_zip' => rule_helper('user_zip', 'Address: Zip', 'max_length[5]|integer'),
			
				'user_email' => rule_helper('user_email', 'Email Address', 'max_length[80]|valid_email'),
			
				'user_username' => rule_helper('user_username', 'Username', 'max_length[45]'),
			
				'user_password' => rule_helper('user_password', 'Password', 'matches[password_confirm]', TRUE, FALSE, FALSE),
				
				'password_confirm' => rule_helper('password_confirm', 'Password Confrim', 'matches[client_password]', TRUE, FALSE, FALSE),
			),
			
			'fields' => array(
				'user_first',
				'user_last',
				'user_type',
				'user_street',
				'user_city',
				'user_state',
				'user_zip',
				'user_email',
				'user_username',
				'user_timestamp',
				'user_active'	
			)
		),
		
/**********************************************
* Estimates Table
/*********************************************/

		'estimates' => array(),
		
/**********************************************
* Invoices Table
/*********************************************/

		'invoices' => array(
			
			'rules' => array(
				'invoice_status' => rule_helper('invoice_status', 'Invoice Status', 'integer'),
				
				'invoice_timestamp' => rule_helper('invoice_timestamp', 'Invoice Due', '', TRUE, TRUE, FALSE), 
				
				 'project_id' => rule_helper('project_id', 'Project', 'integer', TRUE, TRUE, FALSE),
			),	
			
			'fields' => array(
				'invoice_status',
				'invoice_timestamp',
				'project_id',
			)

		),
		
/**********************************************
* Jobs Table
/*********************************************/

		'jobs' => array(
			'rules' => array(
				'job_name' => rule_helper('job_name', 'Job Name', 'max_length[80]'),
				
				'job_desc' => rule_helper('job_desc', 'Job Description', '', TRUE, FALSE, TRUE), 
				
				'job_finish' => rule_helper('job_finish', 'Job Due Date', 'max_length[18]'),
				
				'job_status' => rule_helper('job_status', 'Job Status', 'integer'),
				
				'project_id' => rule_helper('project_id', 'Project', 'integer|greater_than[0]'),
			
			),
			
			'fields' => array(
				'project_id',
				'job_name',
				'job_desc',
				'job_timestamp',
				'job_finish',
				'job_assigned',
				'job_status',
			)
		),
		
		
/**********************************************
* Login Attempts Table
/*********************************************/

		'login_attempts' => array(),
		
/**********************************************
* Messages Table
/*********************************************/

		'messages' => array(
			
			'rules' => array(
				'message_title' => rule_helper('message_title', 'Message Title', 'max_length[128]'),
				'message_to' => rule_helper('message_to', 'Message To', 'integer'),
				'message_text' => rule_helper('message_text', 'Message Body', ''),
				'message_status' => rule_helper('message_status', 'Message Status', 'integer', TRUE, FALSE),
				'message_to_user' => rule_helper('message_to_user', 'User Type', 'integer')
			),

			'fields' => array(
				'message_title',
				'message_to',
				'message_text',
				'message_to_user'
			),
		),
		
/**********************************************
* Payroll Table
/*********************************************/

		'payroll' => array(),
		
/**********************************************
* Projects Table
/*********************************************/

		'projects' => array(
			'rules' => array(
				'project_name' => rule_helper('project_name', 'Project Name', 'max_length[45]'),
				
				'project_street' => rule_helper('project_street', 'Address: Street', 'max_length[80]'),
				
				'project_city' => rule_helper('project_city', 'Address: City', 'max_length[45]'),
				
				'project_state' => rule_helper('project_state', 'Address: State', 'max_length[2]|alpha'),
				
				'project_zip' => rule_helper('project_zip', 'Address: Zip', 'max_length[5]|integer'),
				
				'project_status' => rule_helper('project_status', 'Project Status', 'integer'),
				
				'client_id' => rule_helper('client_id', 'Client Select', 'integer|greater_than[0]'),
			),
			
			'fields' => array(
				'project_name',
				'project_street',
				'project_city',
				'project_state',
				'project_zip',
				'project_status',
				'client_id'
			),
		),
		
/**********************************************
* Users Table
/*********************************************/

		'users' => array(
			
			'rules' => array(
				'username' => rule_helper('username', 'Username', ''),
				
				'password' => rule_helper('password', 'Password', ''),

			),
			
			'rules_admin' => array(
				
				'user_first' => rule_helper('user_first', 'First Name', 'max_length[45]'),
			
				'user_last' => rule_helper('user_last', 'Last Name', 'max_length[45]'), 
			
				'user_street' => rule_helper('user_street', 'Address: Street', 'max_length[80]'),

				'user_city' => rule_helper('user_city', 'Address: City', 'max_length[45]'), 
			
				'user_state' => rule_helper('user_state', 'Address: State', 'max_length[2]|alpha'),
				
				'user_zip' => rule_helper('user_zip', 'Address: Zip', 'max_length[5]|integer'),
				
				'user_email' => rule_helper('user_email', 'Email Address', 'max_length[80]|valid_email'),
			
				'username' => rule_helper('username', 'Username', 'callback__unique_username'),
			
				'password' => rule_helper('user_password', 'Password', 'matches[password_confirm]', TRUE, FALSE, FALSE),
				
				'password_confirm' => rule_helper('password_confirm', 'Password Confrim', 'matches[user_password]', TRUE, FALSE, FALSE),
			),
			
			'fields' => array(
				'user_first',
				'user_last',
				'user_type',
				'user_street',
				'user_city',
				'user_state',
				'user_zip',
				'user_email',
				'user_username',
				'user_timestamp',
				'user_active'	
			)
			
		),	
	);