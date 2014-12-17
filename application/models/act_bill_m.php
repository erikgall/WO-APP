<?php
	class Act_bill_m extends MY_Model {
		protected $_table_name = 'act_bills';
		protected $_primary_key = 'bill_id'; 
		protected $_order_by = 'act_id';
		
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
		
		public function editable() {
			
			$data = array();
			
			$this->db->select('project_id, project_name');
			
			$sql = $this->db->get('projects');
			
			if ($sql->num_rows() > 0) {
				
				$result = $sql->result();

				$data[0] = array(
					'value' => 0,
					'text' => 'No Project Link'
				);
				
				foreach ($result as $row) {
				
					$data[] = array(
						'value' => $row->project_id,
						'text' => $row->project_name,
					);
				
				}					
			}
			
			return $data;
		}
	
	}