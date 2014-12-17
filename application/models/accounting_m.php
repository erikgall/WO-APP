<?php
	class Accounting_m extends MY_Model {
		protected $_table_name = 'accounting';
		protected $_primary_key = 'act_id'; 
		protected $_order_by = 'act_id';
		
		public function __construct() {
			parent::__construct();	
		}
		
		
		public function get_new() {
			$row = new stdClass();
			$row->act_name = '';
			$row->act_timestamp = date('m-d-Y h:i a');
			$row->act_date_due = date('m-d-Y h:i a');
			$row->act_status = 0;					
			return $row;
		}
		
	}