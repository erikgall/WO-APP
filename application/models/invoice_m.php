<?php
	class Invoice_m extends MY_Model {
		protected $_table_name = 'invoices';
		protected $_primary_key = 'invoice_id'; 
		protected $_order_by = 'invoice_timestamp';
		public $rules = array(
			'invoice_status' => array(
				'field' => 'invoice_status', 
				'label' => 'Invoice Status', 
				'rules' => 'trim|required|integer'
			),
			'invoice_timestamp' => array(
				'field' => 'invoice_timestamp', 
				'label' => 'Invoice Due', 
				'rules' => 'trim|required'
			),		
			'project_id' => array(
				'field' => 'project_id', 
				'label' => 'Project', 
				'rules' => 'trim|required|integer'
			),			
	

		);
		
		public function __construct() {
			parent::__construct();	
		}
		
		
		public $fields = array(
			'invoice_status',
			'invoice_timestamp',
			'project_id',
		);
		
		public function get_new() {
			$row = new stdClass();
			$row->invoice_status = 0;
			$row->invoice_timestamp = unix_to_human(time());
			$row->project_id = 0;					
			return $row;
		}
		
	}