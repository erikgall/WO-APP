<?php
	class Job_m extends MY_Model {
		protected $_table_name = 'jobs';
		protected $_primary_key = 'job_id'; 
		protected $_order_by = 'project_id';
		public $rules = array(
			'job_name' => array(
				'field' => 'job_name', 
				'label' => 'Job Name', 
				'rules' => 'trim|required|max_length[80]|xss_clean'
			),
			'job_desc' => array(
				'field' => 'job_desc', 
				'label' => 'Job Description', 
				'rules' => 'trim|xss_clean'
			),
			'job_finish' => array(
				'field' => 'job_finish', 
				'label' => 'Job Due Date', 
				'rules' => 'trim||max_length[18]|xss_clean'
			),
			'job_status' => array(
				'field' => 'job_status', 
				'label' => 'Job Status', 
				'rules' => 'trim|integer|required'
			),
			'project_id' => array(
				'field' => 'project_id', 
				'label' => 'Project', 
				'rules' => 'trim|integer|required|greater_than[0]'
			),
			
		);
		
		public $fields = array(
			'project_id',
			'job_name',
			'job_desc',
			'job_timestamp',
			'job_finish',
			'job_assigned',
			'job_status',
		);
		
		public function get_new() {
			$row = new stdClass();
			$row->project_id = '';
			$row->job_name = '';
			$row->job_desc = '';
			$row->job_timestamp = date("Y-m-d H:i:s");
			$row->job_finish = '';
			$row->job_assigned = '';
			$row->job_status = '';
					
			return $row;
		}
	}