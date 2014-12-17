<?php
	class Billing_m extends MY_Model {
		protected $_table_name = 'billing';
		protected $_primary_key = 'bill_id'; 
		protected $_order_by = 'invoice_id';
		
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