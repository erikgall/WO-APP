<?php
	class Client_m extends MY_Model {
		protected $_table_name = 'clients';
		protected $_primary_key = 'client_id'; 
		protected $_order_by = 'client_last';
		public $rules = array(
			'client_first' => array(
				'field' => 'client_first', 
				'label' => 'First Name', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'client_last' => array(
				'field' => 'client_last', 
				'label' => 'Last Name', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'client_street' => array(
				'field' => 'client_street', 
				'label' => 'Street Address', 
				'rules' => 'trim|required|max_length[80]|xss_clean'
			),
			'client_city' => array(
				'field' => 'client_city', 
				'label' => 'City Address', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'client_state' => array(
				'field' => 'client_state', 
				'label' => 'State', 
				'rules' => 'trim|required|max_length[2]|alpha|xss_clean'
			),
			'client_zip' => array(
				'field' => 'client_zip', 
				'label' => 'Postal Code ', 
				'rules' => 'trim|required|max_length[5]|integer|xss_clean'
			),
			'client_email' => array(
				'field' => 'client_email', 
				'label' => 'Client Email ', 
				'rules' => 'trim|required|max_length[80]|valid_email|xss_clean'
			),
			'client_username' => array(
				'field' => 'client_username', 
				'label' => 'Username', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'client_password' => array(
				'field' => 'client_password', 
				'label' => 'Password', 
				'rules' => 'trim|matches[password_confirm]'
			),
			'password_confirm' => array(
				'field' => 'password_confirm', 
				'label' => 'Confirm password', 
				'rules' => 'trim|matches[client_password]'
			),
		);
		
		public $fields = array(
			'client_first',
			'client_last',
			'client_street',
			'client_city',
			'client_state',
			'client_zip',
			'client_email',
			'client_username',
		);
		
		public function get_new() {
			$row = new stdClass();
			$row->client_first = '';
			$row->client_last = '';
			$row->client_street = '';
			$row->client_city = '';
			$row->client_state = '';
			$row->client_zip = '';
			$row->client_email = '';
			$row->client_username = '';
			$row->client_password = '';
		



			return $row;
		}
	}