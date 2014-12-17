<?php
	class Assignment_m extends MY_Model {
		protected $_table_name = 'assignments';
		protected $_primary_key = 'assignment_id'; 
		protected $_order_by = 'job_id';
		public $rules = array(
			'job_id' => array(
				'field' => 'job_id', 
				'label' => 'Job ID', 
				'rules' => 'trim|required'
			),			
		);
		
		public function __construct() {
			parent::__construct();	
		}
		
		public $fields = array(
			'job_id',
			'user_id',
		);
		
		public function get_new() {
			$row = new stdClass();
			$row->job_id = '';
			$row->user_id = '';
								
			return $row;
		}
		
		public function save($data, $id) {
			
			$this->db->where('user_id', $data['user_id']);
			$this->db->where('job_id', $data['job_id']);
			$sql = $this->db->get('assignments');
			if ($sql->num_rows() == 0) {
				parent::save($data, $id);	
			}
		}
		
		public function get_employees($job_id) {
			
			$jobs = $this->db->where('job_id', $job_id)->get($this->_table_name);
			
			if ($jobs->num_rows() > 0) {
			
				$employees = array();
			
				$assign = array();
				foreach($jobs->result() as $job) {
			
					$employees[] = $job->user_id;
					
					$assign[$job->user_id] = $job->assignment_id;
					
			
				}
			
			 
				$this->db->select('user_id');
				
				$this->db->select('user_first');
				
				$this->db->select('user_last');			
			
				$this->db->where_in('user_id', $employees);
			
				$sql = $this->db->get('users');
			
				$data = array();
				if ($sql->num_rows() > 0) {
			
					$data = array();

					foreach ($sql->result_array() as $row) {
					
						if (isset($assign[$row['user_id']])) {
						
							$row['assignment_id'] = $assign[$row['user_id']];
					
						}
						
						$data[] = $row;
					}
					
					return $data;
				}
			
				else {
			
					return NULL;
				
				}	
			}
		}
	}