<?php
	class Project_m extends MY_Model {
		protected $_table_name = 'projects';
		protected $_primary_key = 'project_id'; 
		protected $_order_by = 'project_name';
		public $rules = array(
			'project_name' => array(
				'field' => 'project_name', 
				'label' => 'Project Name', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'project_street' => array(
				'field' => 'project_street', 
				'label' => 'Street Address', 
				'rules' => 'trim|required|max_length[80]|xss_clean'
			),
			'project_city' => array(
				'field' => 'project_city', 
				'label' => 'Address: City', 
				'rules' => 'trim|required|max_length[45]|xss_clean'
			),
			'project_state' => array(
				'field' => 'project_state', 
				'label' => 'Address: State', 
				'rules' => 'trim|required|max_length[2]|alpha|xss_clean'
			),
			'project_zip' => array(
				'field' => 'project_zip', 
				'label' => 'Zipcode ', 
				'rules' => 'trim|required|max_length[5]|integer|xss_clean'
			),
			'project_status' => array(
				'field' => 'project_status', 
				'label' => 'Project Status', 
				'rules' => 'trim|required|integer|xss_clean'
			),
			'client_id' => array(
				'field' => 'client_id', 
				'label' => 'Client Select', 
				'rules' => 'trim|required|integer|greater_than[0]|xss_clean'
			),
		);
		
		public $fields = array(
			'project_name',
			'project_street',
			'project_city',
			'project_state',
			'project_zip',
			'project_status',
			'client_id'
		);
		
		public function get_new() {
			$row = new stdClass();
			$row->project_name = '';
			$row->project_street = '';
			$row->project_city = '';
			$row->project_state = '';
			$row->project_zip = '';
			$row->project_status = '0';
			$row->client_id = '0';

			return $row;
		}
		
		public function get_client_name($id = NULL) {
			if ($id) {
				$this->db->where('client_id', $id);
			}

			$this->db->select('client_id');			
			$this->db->select('client_first');
			$this->db->select('client_last');
			
			$sql = $this->db->get('clients');
			
			if ($sql->num_rows() > 0) {
				
				if ($id) {
	
					$row = $sql->row();
				
					return $row->client_first . " " . $row->client_last;
				
				}
				else {
					
					$data = array();
					
					foreach ($sql->result() as $row) {
					
						$data[$row->client_id] = $row->client_first . " " . $row->client_last;
						
					}
					
					return $data;
					
				}
					
			}
			
			
				
		}

	}