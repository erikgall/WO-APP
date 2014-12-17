<?php
	class Employee_m extends MY_Model {
		protected $_table_name = 'users';
		protected $_primary_key = 'user_id'; 
		protected $_order_by = 'user_last';
		public $rules = array(
			'user_first' => array(
				'field' => 'user_first', 
				'label' => 'First Name', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'user_last' => array(
				'field' => 'user_last', 
				'label' => 'Last Name', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'user_street' => array(
				'field' => 'user_street', 
				'label' => 'Street Address', 
				'rules' => 'trim|required|max_length[80]|xss_clean'
			),
			'user_city' => array(
				'field' => 'user_city', 
				'label' => 'City Address', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'user_state' => array(
				'field' => 'user_state', 
				'label' => 'State', 
				'rules' => 'trim|required|max_length[2]|alpha|xss_clean'
			),
			'user_zip' => array(
				'field' => 'user_zip', 
				'label' => 'Postal Code ', 
				'rules' => 'trim|required|max_length[5]|integer|xss_clean'
			),
			'user_email' => array(
				'field' => 'user_email', 
				'label' => 'user Email ', 
				'rules' => 'trim|required|max_length[80]|valid_email|xss_clean'
			),
			'user_username' => array(
				'field' => 'user_username', 
				'label' => 'Username', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'user_password' => array(
				'field' => 'user_password', 
				'label' => 'Password', 
				'rules' => 'trim|matches[password_confirm]'
			),
			'password_confirm' => array(
				'field' => 'password_confirm', 
				'label' => 'Confirm password', 
				'rules' => 'trim|matches[user_password]'
			),
		);
		
		public $fields = array(
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
		);
		
		public function get_new() {
			$row = new stdClass();
			$row->user_first = '';
			$row->user_last = '';
			$row->user_type = 'employee';
			$row->user_street = '';
			$row->user_city = '';
			$row->user_state = '';
			$row->user_zip = '';
			$row->user_email = '';
			$row->user_username = '';
			$row->user_password = '';
			$row->user_timestamp = unix_to_human(time());
			$row->user_active = 1;
		
			return $row;
		}
	
	}